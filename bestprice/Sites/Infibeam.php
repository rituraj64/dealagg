<?php
class Infibeam extends Parsing{
	public $_code = 'Infibeam';

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC);
	}
	public function isTrusted($category){
		return true;
	}

	public function getWebsiteUrl(){
		return 'http://www.infibeam.com';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.infibeam.com/Books/search?q=".$query;
		}else if($category == Category::MOBILE){
			return "http://www.infibeam.com/Mobiles/search?q=".$query;
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.infibeam.com/Mobile_Accessories/search?q=$query";
			if($subcat == Category::MOB_BATTERY){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query&category=Batteries";
			}elseif($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADSETS || $subcat == Category::MOB_HEADPHONE){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query#category=Bluetooth%20Devices&category=Handset&category=Handsfree&category=Headsets&q=$query&store=Mobile_Accessories";
			}elseif($subcat == Category::MOB_CABLE){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query&category=Cables";
			}elseif($subcat == Category::MOB_CHARGER){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query&category=Chargers";
			}elseif($subcat == Category::MOB_CASES){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query&category=Covers";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query&category=Screen%20Protectors";
			}elseif($subcat == Category::MOB_SPEAKER){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query#category=Speakers&q=$query&store=Mobile_Accessories";
			}elseif($subcat == Category::MOB_CAR_ACC){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query#category=Car%20Accessories&q=$query&store=Mobile_Accessories";
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query#category=Memory%20Cards&q=$query&store=Mobile_Accessories";
			}elseif($subcat == Category::MOB_OTHERS){
				return "http://www.infibeam.com/Mobile_Accessories/search?q=$query";
			}
			else return "";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.infibeam.com/Cameras/search?q=$query";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.infibeam.com/Cameras/search?q=$query#subCategory=Point and Shoot&q=$query&store=Cameras";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.infibeam.com/Cameras/search?q=$query#subCategory=DSLR&q=$query&store=Cameras";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.infibeam.com/Cameras/search?q=$query#category=Camcorder&q=$query&store=Cameras";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.infibeam.com/Cameras/search?q=$query#subCategory=Mirrorless&q=$query&store=Cameras";
			}else {
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Chargers&q=$query&store=Camera_Accessories"; //cables and charges
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Backpacks&q=$query&store=Camera_Accessories"; // camera pouchse
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Batteries&q=$query&store=Camera_Accessories"; // battery
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=$query Units&q=$query&store=Camera_Accessories";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Filters&q=$query&store=Camera_Accessories"; // lenses
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Lens&q=$query&store=Camera_Accessories"; // lenses
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Memory Cards&q=$query&store=Camera_Accessories"; // memory
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Screen Protector&q=$query&store=Camera_Accessories";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.infibeam.com/Camera_Accessories/search?q=$query#category=Tripod&q=$query&store=Camera_Accessories";
			}else{
				return '';
			}

		}else{
			return "http://www.infibeam.com/search?q=".$query;
		}
	}
	public function getLogo(){
		return "http://www.infibeam.com/assets/skins/common/images/logo.png";
	}
	public function getData($html,$query,$category,$subcat=false){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.boxinner')) > 0){
			foreach(pq('div.boxinner') as $div){
				$cat = pq($div)->children('a:first')->html();
				$cat = $this->removeNum($this->clearHtml($cat));
				foreach(pq($div)->find('ul.srch_result') as $div){
					foreach(pq($div)->find('li') as $div){
						$image = pq($div)->find('a')->html();
						$url = pq($div)->find('a')->attr('href');
						$name = strip_tags(pq($div)->find('.title')->html());
						$disc_price = pq($div)->find('.price')->find('.normal')->html();
						$org_price = pq($div)->find('.price')->find('.scratch ')->html();
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
								'cat' => $cat
						);
					}
				}
			}
		}else if(sizeof(pq('ul.search_result')->children('li')) > 0){
			foreach(pq('ul.search_result')->children('li') as $div){
				$image = pq($div)->find('.img')->find('a')->html();
				$url = pq($div)->find('.img')->find('a')->attr('href');
				$name = pq($div)->find('.title')->children('h2')->html();
				$disc_price = pq($div)->find('.price')->find('b')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				foreach(pq($div)->find('span') as $span){
					$html = pq($span)->html();
					$html = $this->clearHtml($html);
					if(strpos($html, 'Ships') !== false){
						$shipping = $html;
						if(strpos($html, '.') !== false){
							$shipping = substr($html, strpos($html, '.') + 1,strlen($html));
						}
					}
					if(strpos($html, 'Out Of Stock') !== false){
						$stock = -1;
					}else{
						$stock = 1;
					}
				}
				$author = '';
				if($category == Category::BOOKS){
					$author = pq($div)->find('.title')->children('a')->html();
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
		}else if(pq('ul.srch_result')->children('li')){
			foreach(pq('ul.srch_result')->children('li') as $div){
				$url = pq($div)->children('a:first')->attr('href');
				$name = pq($div)->children('a:first')->children('.title')->html();
				$disc_price = pq($div)->children('.price')->children('.normal')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				$author = '';
				pq($div)->children('a:first')->children()->remove('span');
				$image = pq($div)->children('a:first')->html();
				$cat = pq('#resultsPane')->find('h1:first')->html();
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
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}