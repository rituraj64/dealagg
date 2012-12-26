<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.tradus.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://www.tradus.com/search?query=$query&cat=357";
		}else if($category == Category::CAMERA){
			return "http://www.tradus.com/search?query=$query&cat=7666";
		}else if($category == Category::MOBILE){
			return "http://www.tradus.com/search?query=$query&cat=7844";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.tradus.com/search?query=$query&cat=10465";
		}else if($category == Category::CAMERA){
			return "http://www.tradus.com/search?query=$query&cat=10305"; //digital camera
			return "http://www.tradus.com/search?query=$query&cat=7671"; //camcorder
		}else if($category == Category::CAMERA_ACC){
			return "http://www.tradus.com/search?query=$query&cat=7667"; // acc
			return "http://www.tradus.com/search?query=$query&cat=8101"; // filters
			return "http://www.tradus.com/search?query=$query&cat=8108"; // lens
			
		}else{
			return "http://www.tradus.com/search?query=".$query;
		}
	}
	public function getLogo(){
		return "http://www.tradus.com/sites/all/themes/basic/images/ci_images/tradus_logo/tradus_new_logo.jpg";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		$ele = pq('#search-result-main-heading')->children('h1');
		if(sizeof($ele)){
			$html = $ele->html();
			if(strpos($html, 'Zero items found') !== false){
				return $data;
			}
		}
		foreach(pq('div.prod_main_div') as $div){
			if(sizeof(pq($div)->find('.product_image'))){
				$image = pq($div)->find('.product_image')->children()->html();
				$url = pq($div)->find('.product_image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_name')->find('a')->html());
				$disc_price = pq($div)->find('.prod_price_3')->find('.numDiv_left')->html();
				$shipping = '';
				$cat = '';
				$stock = 0;
				if(pq($div)->find('.prod_price_3')->find('.numDiv_right')->html() == 'Sold Out'){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$offer = '';
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
						'cat' => $cat
				);
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$row['image']= pq('img')->attr('data-original');
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}