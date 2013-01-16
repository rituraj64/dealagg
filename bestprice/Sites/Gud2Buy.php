<?php
class Gud2Buy extends Parsing{
	
	public $_code = 'Gud2Buy';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/gud2buy';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC,Category::COMP_COMPUTER,Category::COMP_LAPTOP,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://gud2buy.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::MOBILE){
			return "http://gud2buy.com/mobiles-and-accessories/mobiles&filter_name=$query&sort=stock_status_id+desc";
		}else if($category == Category::MOBILE_ACC){
			//return "http://gud2buy.com/mobiles-and-accessories/accessories&filter_name=$query&sort=stock_status_id+desc";
			if($subcat == Category::MOB_HANDSFREE){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Bluetooth";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Screen_Guard";
			}elseif($subcat == Category::MOB_CASES){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Cover";
			}elseif($subcat == Category::MOB_BATTERY){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Batteries";
			}elseif($subcat == Category::MOB_CABLE){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Data_Cable";
			}elseif($subcat == Category::MOB_CAR_ACC){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Car_Charger";
			}elseif($subcat == Category::MOB_CHARGER){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Charger";
			}elseif($subcat == Category::MOB_HEADSETS){
				return "http://gud2buy.com/mobiles-and-accessories&filter_name=$query&sort=newprice%20asc&filters=type:Earphones";
			}elseif ($subcat == Category::NOT_SURE || $subcat == Category::MOB_OTHERS){
				return "http://gud2buy.com/mobiles-and-accessories/accessories&filter_name=$query&sort=stock_status_id+desc";
			}else{
				return "";
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return '';
			}else if($category == Category::CAM_DIGITAL_CAMERA || $category == Category::CAM_DIGITAL_SLR){
				return "http://gud2buy.com/cameras/digital-camera&filter_name=$query&sort=stock_status_id+desc";
			}else if($category == Category::CAM_CAMCORDER){
				return "http://gud2buy.com/cameras/camcorder&filter_name=$query&sort=stock_status_id+desc";
			}else {
				return '';
			}
		}elseif ($category == Category::COMP_COMPUTER){
			return "http://gud2buy.com/computers/desktops&filter_name=$query";
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://gud2buy.com/computers/laptops&filter_name=$query";
		}elseif ($category == Category::TABLETS){
			return "http://gud2buy.com/mobiles-and-accessories/tablets&filter_name=$query";
		}
		return "http://gud2buy.com/search&sort=stock_status_id+desc&filter_name=$query&filters=";
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/guy2buy.png';
	}
	public function getData($html,$query,$category,$subcat=false){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.row')) > 0){
			foreach(pq('.row') as $div){
				foreach(pq($div)->children('.select_piece') as $div){
					$image = pq($div)->children('a:first')->children('.image')->html();
					$url = pq($div)->children('a:first')->attr('href');
					$name = pq($div)->children('a:first')->children('.name')->html();
					if(sizeof(pq($div)->children('a')->children('span.price'))){
						$disc_price = pq($div)->children('a')->children('span.price')->html();
					}else{
						$disc_price = pq($div)->children('a')->children('div.temp')->children('.price-new')->html();
					}
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
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}