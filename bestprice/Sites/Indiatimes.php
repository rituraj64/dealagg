<?php
class Indiatimes extends Parsing{

	public $_code = 'Indiatimes';

	public function getFacebookUrl(){
		return 'http://www.facebook.com/indiatimesshopping';
	}
	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::COMP_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://shopping.indiatimes.com/';
	}
	public function getLogo(){
		return "http://shopping.indiatimes.com/images/images/shopping-indiatimes.png";
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::BEAUTY){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10010";
		}else if($category == Category::BOOKS){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10011";
		}else if($category == Category::COMP_ACC){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10013";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10004";
		}else if($category == Category::MOBILE){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10001";
		}else if($category == Category::MOBILE_ACC){
			if($subcat == Category::MOB_BATTERY){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20003";
			}elseif($subcat == Category::MOB_CABLE){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20005";
			}elseif($subcat == Category::MOB_CASES){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:10016";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20007";
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20006";
			}elseif($subcat == Category::MOB_OTHERS){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20009";
			}elseif($subcat == Category::MOB_SPEAKER){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10001";
			}elseif($subcat == Category::MOB_HANDSFREE){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10001";
			}elseif($subcat == Category::MOB_CAR_ACC){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:41853";
			}elseif($subcat == Category::MOB_HEADPHONE || $subcat == Category::MOB_HEADSETS){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10001&filter=PRIMARY_CATEGORY_ID:20002";
			}
		}else if($category == Category::TV){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10004";
		}else if($category == Category::GAMING){
			return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10021";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:20011"; //cameras
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:20012"; //camcorder
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:20011"; //cameras
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:20011"; //cameras
			}elseif($category == Category::TABLETS){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10013&filter=PRIMARY_CATEGORY_ID:40105";//tablets
			}

		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40535"; //cables and charges
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40534"; // camera pouchse
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40532"; // battery
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return '';
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40538"; // lenses
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40538"; // lenses
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10002&filter=PRIMARY_CATEGORY_ID:40537"; // memory
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return '';
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return '';
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10002&filter=PRIMARY_CATEGORY_ID:40543";
			}
		}elseif($category == Category::COMP_LAPTOP){
			if($subcat == Category::COMP_COMPUTER){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID%3A10013&filter=PRIMARY_CATEGORY_ID:40599";
			}elseif($subcat == Category::COMP_LAPTOP){
				return "http://shopping.indiatimes.com/control/pinpointsearch?SEARCH_STRING=$query&filter=PRIMARY_CATALOG_ID:10013";
			}
		}else{
			return "http://shopping.indiatimes.com/control/mtkeywordsearch?SEARCH_STRING=".$query;
		}
	}
	public function getData($html,$query,$category,$subcat){

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
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}