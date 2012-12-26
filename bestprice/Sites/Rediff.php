<?php
class Rediff extends Parsing{
	public $_code = 'Rediff';

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'rediff.com';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://books.rediff.com/search/$query?&output=xml&src=search_$query";
		}else if($category == Category::MOBILE){
			$query = urldecode($query);
			return "http://shopping.rediff.com/productv2/$query/cat-mobile phones & accessories|mobile accessories";
		}else if($category == Category::CAMERA){
			return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital cameras";
			return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital slr cameras";
			return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|camcorders";
		}else if($category == Category::CAMERA_ACC){
			return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|camera accessories";
		}else{
			return "http://shopping.rediff.com/shopping/index.html#!".urldecode($query);
		}
	}
	public function getLogo(){
		return "http://books.rediff.com/booksrediff/pix/rediff.png";
	}
	public function getData($html,$query,$category){
		if($category == Category::BOOKS){
			$data = array();

			$xmlObj = new SimpleXMLElement($html);
			$match = $xmlObj->QueryMatch->total;
			if($match > 0){
				foreach($xmlObj->QueryMatch->book as $book){
					$name = $book->title."";
					$isbn = $book->isbn."";
					$author = $book->author.'';
					$image = $book->imagesmall.'';
					$disc_price = $book->domesticwebprice.'';
					$url = $book->book_url.'';
					$shipping = $book->despatchleadtime.' Working Days';
					$cat = '';
					$stock = 0;
					$offer = '';
					$data[] = array(
							'name'=>$name,
							'image'=>$image,
							'disc_price'=>$disc_price,
							'url'=>$url,
							'website'=>$this->getCode(),
							'offer'=>$offer,
							'shipping'=>$shipping,
							'stock'=>$stock,
							'author' => $author,
							'isbn' => $isbn,
							'cat' => $cat
					);
				}
			}
			$data = $this->cleanData($data, $query);
			$data = $this->bestMatchData($data, $query,$category);
			return $data;
		}else{
			$data = array();
			phpQuery::newDocumentHTML($html);
			if(sizeof(pq('.div_grid_display_big')) > 0){
				foreach(pq('.div_grid_display_big') as $div){
					$image = pq($div)->find('.mitemimg_h4_big:first')->children('a')->html();
					$url = pq($div)->find('.mitemimg_h4_big:first')->children('a')->attr('href');
					$name = pq($div)->find('.mitemname_h4:first')->children('a')->html();
					$disc_price = pq($div)->children('div')->children('div')->children('div:last')->children('span')->html();
					$offer = '';
					$shipping = '';
					$stock = 0;
					$author = '';
					$data[] = array(
							'name'=>$name,
							'image'=>$image,
							'disc_price'=>$disc_price,
							'url'=>$url,
							'website'=>$this->getCode(),
							'offer'=>$offer,
							'shipping'=>$shipping,
							'stock'=>$stock,
							'author' => $author,
							'cat' => ''
					);
				}
			}
			$data2 = array();
			foreach($data as $row){
				$html = $row['image'];
				$html .= '</img>';
				phpQuery::newDocumentHTML($html);
				$img = pq('img')->attr('src');
				$row['image'] = $img;
				$data2[] = $row;
			}
			$data2 = $this->cleanData($data2, $query);
			$data2 = $this->bestMatchData($data2, $query,$category);
			return $data2;
		}
	}
}