<?php
class TimTara extends Parsing{
	public $_code = 'TimTara';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.timtara.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.timtara.com/search.php?catLevel=0&category[]=1021&category[]=1022&search_query=$query&x=0&y=0";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1023&category[]=1025&category[]=1027&category[]=1028&category[]=1029";
		}
		return "http://www.timtara.com/search.php?catLevel=0&category[]=&search_query=$query&x=0&y=0";
	}
	public function getLogo(){
		return 'http://image1.timtara.com/product_images/logo.jpg';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		
		if(sizeof(pq('ul.ProductList')) > 0){
			foreach(pq('ul.ProductList')->children('li') as $div){
				$image = pq($div)->children('.ProductImage')->children('a')->html();
				$url = pq($div)->children('.ProductImage')->children('a')->attr('href');
				$name = pq($div)->children('.ProductDetails')->children('strong')->children('a')->html();
				$disc_price = pq($div)->children('.timtaraprice')->children('b')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->children('.sohwHideProductAddTextnone'))){
					$stock = -1;
				}else{
					$stock = 1;
				}

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