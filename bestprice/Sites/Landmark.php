<?php
class Landmark extends Parsing{
	public $_code = 'Landmark';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/landmarkstores';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::BOOKS,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.landmarkonthenet.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.landmarkonthenet.com/books/search/?q=".$query;
		}else if($category == Category::MOBILE_ACC){
			return "http://www.landmarkonthenet.com/mobile-accessories/search/?q=".$query;
		}else if($category == Category::MOBILE){
			return "http://www.landmarkonthenet.com/mobiles/search/?q=".$query;
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.landmarkonthenet.com/cameras/search/?q=$query";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.landmarkonthenet.com/cameras/search/?q=sony&type=Point+%26+Shoot";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.landmarkonthenet.com/cameras/search/?q=sony&type=D-SLR";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.landmarkonthenet.com/cameras/search/?q=$query";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.landmarkonthenet.com/cameras/search/?q=sony&type=Camcorder";

			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			return "http://www.landmarkonthenet.com/camera-accessories/search/?q=$query";
		}
		return "http://www.landmarkonthenet.com/search/?q=".$query;
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/landmark.png';
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);

		$html = pq('#page-content')->children('h1')->html();
		if(strpos($html, 'Sorry, no results were found for') !== false){
			return $data;
		}

		foreach(pq('div.searchresult') as $div){
			if(sizeof(pq($div)->find('.image'))){
				$image = pq($div)->find('.image')->find('a')->html();
				$url = pq($div)->find('.image')->find('a')->attr('href');
				$name = pq($div)->find('.info')->children('h1')->find('a')->html();
				$disc_price = strip_tags(pq($div)->find('.buttons')->find('.prices')->find('.oldprice')->html());
				$offer = '';
				$shipping = pq($div)->find('.stockinfo')->find('.despatch-time')->html() . ' '. pq($div)->find('.stockinfo')->find('.shipping-cost')->html() ;
				$stock = 0;
				if(sizeof(pq($div)->find('.stockinfo')->find('.instock'))){
					$stock = 1;
				}else{
					$stock = -1;
				}
				$author = '';
				if($category == Category::BOOKS){
					$author = pq($div)->find('.info')->children('h2')->find('a')->html();
				}
				$cat ='';
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
			$img = pq('img')->attr('src');
			if(strpos($img, 'http') === false){
				$img = $img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}