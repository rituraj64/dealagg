<?php
class FutureBazaar extends Parsing{
	public $_code = 'FutureBazaar';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.futurebazaar.com';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.futurebazaar.com/search/?q=$query&c=2459&NormalSearch=enabled";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.futurebazaar.com/search/?q=$query&c=2464&NormalSearch=enabled";
		}
		return "http://www.futurebazaar.com/search/?q=$query&c=0&NormalSearch=enabled";
	}
	public function getLogo(){
		return 'http://www.futurebazaar.com/media/images/futurebazaar-logo-xmas.png';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('li.grid_5')) > 0){
			foreach(pq('li.grid_5') as $div){
				$image = pq($div)->find('.imgbottom:first')->html();
				$url = pq($div)->children('.greed_inner')->children('h3')->children('a')->attr('href');
				$name = pq($div)->children('.greed_inner')->children('h3')->children('a')->html();
				$disc_price = pq($div)->children('.greed_inner')->find('.price:first')->children('.offer_price:first')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->find('.add_to_cart_form'))){
					$stock = 1;
				}else{
					$stock = -1;
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
			$img = pq('img')->attr('prodsrc');
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}