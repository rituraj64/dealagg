<?php
class FutureBazaar extends Parsing{
	public $_code = 'FutureBazaar';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/FutureBazaar';
	}
	public function getAllowedCategory(){
		return array(Category::GAMING,Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC,Category::COMP_LAPTOP,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://www.futurebazaar.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.futurebazaar.com/search/?q=$query&c=2459&NormalSearch=enabled";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.futurebazaar.com/search/?q=$query&c=2464&NormalSearch=enabled";
			if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "http://www.futurebazaar.com/search/?q=$query&c=2464&NormalSearch=enabled";
			}elseif($subcat == Category::MOB_BATTERY || $subcat == Category::MOB_CHARGER){
				return "http://www.futurebazaar.com/search/?q=$query&c=3115";
			}elseif($subcat == Category::MOB_HEADSETS){
				return "http://www.futurebazaar.com/search/?q=$query&c=3118";
			}elseif($subcat == Category::MOB_CASES){
				return "http://www.futurebazaar.com/search/?q=$query&c=3114";
			}elseif($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://www.futurebazaar.com/search/?q=$query&c=3116";
			}else return "";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.futurebazaar.com/search/?q=$query&c=2486";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.futurebazaar.com/search/?q=$query&c=2487&NormalSearch=enabled"; //digtal camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.futurebazaar.com/search/?q=$query&c=2488";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return '';
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.futurebazaar.com/search/?q=$query&c=3172&NormalSearch=enabled"; //cam corder
			}else{
				return '';
			}


		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.futurebazaar.com/search/?q=$query&c=2751&NormalSearch=enabled"; //bags
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.futurebazaar.com/search/?q=$query&c=3132&NormalSearch=enabled"; //lense acc
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.futurebazaar.com/search/?q=$query&c=2750&NormalSearch=enabled"; //lenses
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.futurebazaar.com/search/?q=$query&c=2490&NormalSearch=enabled"; //camera acc
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.futurebazaar.com/search/?q=$query&c=2749&NormalSearch=enabled"; //tripod and monopods
			}else{
				return '';
			}
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://www.futurebazaar.com/search/?q=$query&c=2466";
		}elseif ($category == Category::TABLETS){
			return "http://www.futurebazaar.com/search/?q=$query&c=2468";
		}elseif ($category == Category::GAMING){
			if ($subcat == Category::GAMING_ACC_GAMES) {
				return "http://www.futurebazaar.com/search/?q=$query&c=3236&NormalSearch=enabled";
			}elseif($subcat == Category::GAMING_ACC_ACC){
				return "http://www.futurebazaar.com/search/?q=$query&c=2496";
			}elseif ($subcat == Category::GAMING_ACC_CONSOLES){
				return "http://www.futurebazaar.com/search/?q=$query&c=2497";
			}
		}
		return "http://www.futurebazaar.com/search/?q=$query&c=0&NormalSearch=enabled";
	}
	public function getLogo(){
		return 'http://www.futurebazaar.com/media/images/futurebazaar-logo-xmas.png';
	}
	public function getData($html,$query,$category,$subcat){

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
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}