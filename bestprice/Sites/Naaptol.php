<?php
class Naaptol extends Parsing{

	public $_code = 'Naaptol';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/ShopRight';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::BOOKS);
	}
	public function isTrusted($category){
		return true;
	}

	public function getWebsiteUrl(){
		return 'http://www.naaptol.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=27&kw=$query&sb=49,9,8&req=ajax";
		}else if($category == Category::BOOKS){
			return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=2578&kw=$query&sb=49,9,8&req=ajax";
		}else if($category == Category::MOBILE_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=4&kw=$query&sb=49,9,8&req=ajax";
			}elseif ($subcat == Category::MOB_OTHERS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=2494&kw=$query&sb=49,9,8";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=279&kw=$query&sb=49,9,8";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=104&kw=$query&sb=49,9,8";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=103&kw=$query&sb=49,9,8";
			}elseif($subcat == Category::MOB_BATTERY){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=106&kw=$query&sb=49,9,8";
			}elseif($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=105&kw=$query&sb=49,9,8";
			}elseif($subcat == Category::MOB_CHARGER){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=101&kw=$query&sb=49,9,8";
			}elseif($subcat == Category::MOB_CABLE){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=102&kw=$query&sb=49,9,8";
			}elseif ($subcat == Category::MOB_CAR_ACC){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=186&kw=$query&sb=49,9,8";
			}else return "";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=1&kw=$query&sb=49,9,8&req=ajax";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=6&kw=$query&sb=49,9,8&req=ajax"; // digital camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=7&kw=$query&sb=49,9,8&req=ajax"; //slr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=9&kw=$query&sb=49,9,8&req=ajax"; // camcorders
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=6&kw=$query&sb=49,9,8&req=ajax"; // digital camera
			}else {
				return '';
			}

		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=108&kw=$query&sb=49,9,8&req=ajax"; //chargers
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=38&kw=$query&sb=49,9,8&req=ajax"; // camera pouch
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=37&kw=$query&sb=49,9,8&req=ajax"; //battery
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=253&kw=$query&sb=49,9,8&req=ajax";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=2582&kw=$query&sb=49,9,8&req=ajax"; //lens
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=252&kw=$query&sb=49,9,8&req=ajax"; //lens
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return '';
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=2495&kw=$query&sb=49,9,8&req=ajax"; //misc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=2591&kw=$query&sb=49,9,8&req=ajax";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&fltrNam=catFltr&catid=39&kw=$query&sb=49,9,8&req=ajax"; //tripods
			}else{
				return '';
			}

		}
		return "http://www.naaptol.com/faces/jsp/search/searchResults.jsp?type=srch_catlg&kw=samsung&sb=49,9,8&req=ajax";
	}
	public function getLogo(){
		return "http://images2.naptol.com/usr/local/csp/staticContent/images_layout/naaptolXmasLogo.gif";
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		$json = json_decode($html,true);
		if(sizeof($json['prodList']) > 0){
			foreach($json['prodList'] as $row){
				$image = 'http://images2.naptol.com/usr/local/csp/staticContent/NormImg105x105/'.$row['pimg'];
				$url = $this->getWebsiteUrl().$row['purl'];
				$name = $row['pnm'];
				$disc_price = $row['pc'];
				$offer = isset($row['cdEiFs']) ? $row['cdEiFs'] : '';
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