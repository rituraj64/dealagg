<?php
class Seventymm extends Parsing{
	public $_code = 'Seventymm';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/SeventymmCom';
	}
	public function getAllowedCategory(){
		return array(Category::TABLETS,Category::MOBILE,Category::MOBILE_ACC,Category::COMP_LAPTOP);
	}

	public function getWebsiteUrl(){
		return 'http://shop.seventymm.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		$q = urldecode($query);
		$q = str_replace(" ", '-', $q);
		$q = trim(preg_replace("![^0-9a-z-]+!i", "", $q));
		if($category == Category::MOBILE){
			return "http://shop.seventymm.com/Search/$q/Tablets-and-Mobiles/2829/Mobiles/2369/All-Price/0/Any/0/Any/0/1/1/3/Go";
		}else if($category == Category::MOBILE_ACC){
			$query = str_replace(" ", "-", $query);
			if($subcat == Category::NOT_SURE || $subcat == Category::MOB_OTHERS){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif($subcat == Category::MOB_CASES){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Cases-and-Covers/2740/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif($subcat == Category::MOB_HEADSETS){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Bluetooth-Headsets/2737/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif ($subcat == Category::MOB_CABLE){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Cables/2862/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Screen-Protector/2860/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif($subcat == Category::MOB_CHARGER){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Chargers/2741/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif ($subcat == Category::MOB_HEADPHONE || $subcat == Category::MOB_HANDSFREE){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Headphones-and-Headsets/2739/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://shop.seventymm.com/Search/$query/Tablets-and-Mobiles/2829/Memory-Cards/2370/All-Price/0/Any/0/Any/0/1/1/3/Go";
			}else return "";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Point-and-Shoot/2375/All-Price/0/Any/0/Any/0/1/1/3/Go"; //digital camera
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Point-and-Shoot/2375/All-Price/0/Any/0/Any/0/1/1/3/Go"; //digital camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/D-SLR/2377/All-Price/0/Any/0/Any/0/1/1/3/Go"; // dslr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Camcorders/2378/All-Price/0/Any/0/Any/0/1/1/3/Go"; //camcorders
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Point-and-Shoot/2375/All-Price/0/Any/0/Any/0/1/1/3/Go"; //digital camera
			}else{
				return 'http://shop.seventymm.com/Search/$q/All-Categories/0/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Lenses/2619/All-Price/0/Any/0/Any/0/1/1/3/Go"; //lenses
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Lenses/2619/All-Price/0/Any/0/Any/0/1/1/3/Go"; //lenses
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://shop.seventymm.com/Search/$query/Electronics/2235/Accessories/2629/All-Price/0/Any/0/Any/0/1/1/3/Go"; //acc
			}else{
				return 'http://shop.seventymm.com/Search/$q/All-Categories/0/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go';
			}
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://shop.seventymm.com/search/$q/all-categories/0/laptops/2371/all-price/0/any/0/any/0/1/1/3/go";
		}elseif ($category == Category::TABLETS){
			return "http://shop.seventymm.com/search/$q/tablets-and-mobiles/2829/tablets/2277/all-price/0/any/0/any/0/1/1/3/go";
		}
		return "http://shop.seventymm.com/Search/$q/All-Categories/0/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go";
	}
	public function getLogo(){
		return 'http://staticcontent.seventymm.com/Images/SiteMasterV4/LogoC.png';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.Search_Panel')) > 0){
			//http://images.seventymm.com/Img/Item/ItemRegular/43262.jpg
			foreach(pq('.Search_Panel')->children('.MT10')->children('.MT20')->children('div') as $div){
				$image = pq($div)->children('img')->attr('do');
				$url = pq($div)->children('a')->attr('href');
				$name = pq($div)->children('a')->html();
				$disc_price = pq($div)->attr('sp');
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
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query,$category,$subcat);
		return $data;
	}
}