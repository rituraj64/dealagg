<?php
class Indiatimes extends Parsing{
	public $_code = 'Indiatimes';


	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://shopping.indiatimes.com/';
	}
	public function getLogo(){
		return "http://shopping.indiatimes.com/images/images/shopping-indiatimes.png";
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BEAUTY){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10010";
		}else if($category == Category::BOOKS){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10011";
		}else if($category == Category::CAMERA){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002";
		}else if($category == Category::COMP_ACC || $category == Category::COMP_LAPTOP || $category == Category::TABLETS){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10013";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10004";
		}else if($category == Category::MOBILE){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10001";
		}else if($category == Category::TV){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10004";
		}else if($category == Category::GAMING){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10021";
		}else{
			return "http://shopping.indiatimes.com/control/mtkeywordsearch?SEARCH_STRING=".$query;
		}
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.productlistview')) > 0){
			foreach(pq('div.productlistview') as $div){
				$image = pq($div)->find('.productthumb')->find("a")->html();
				$url = pq($div)->find('.productthumb')->find('a')->attr('href');
				$name = pq($div)->find('.itemname')->find('a')->html();
				$disc_price = pq($div)->find('.productdescription')->find('.newprice')->find('.price')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->find('.productdescription')->find('.instock')) > 0){
					$stock = 1;
				}else{
					$stock = -1;
				}
				$author = '';
				$cat = '';
				$isbn = '';
				if($category == Category::BOOKS){
					$detail = pq($div)->find('.productdescription')->find('.bookmore')->html();
					$detail = strip_tags($detail);
					$author = substr($detail, 0,strpos($detail, "ISBN"));
					$isbn = substr($detail, strpos($detail, "ISBN"),strlen($detail));
					$author = str_replace("Author:", "", $author);
					$isbn = str_replace("ISBN:", "", $isbn);
				}
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

		}else{
			foreach(pq('div.ProductList') as $div){
				if(sizeof(pq($div)->find('.productthumb'))){
					$image = pq($div)->find('.productthumb')->find("a")->html();
					$url = pq($div)->find('.productthumb')->find('a')->attr('href');
					$name = strip_tags(pq($div)->find('.productdetail')->find('a')->html());
					$disc_price = pq($div)->find('.productdetail')->find('.price')->html();
					$offer = '';
					$shipping = '';
					$stock = 0;
					$author = '';
					$cat = '';
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
							'cat' => $cat
					);
				}
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$img = pq('img')->attr('src');
			if(strpos($img, 'http') === false){
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}