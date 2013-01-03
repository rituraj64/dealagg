<?php
class Homeshop extends Parsing{
	public $_code = 'Homeshop18';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/homeshop18';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC);
	}
	public function isTrusted($category){
		return true;
	}

	public function getWebsiteUrl(){
		return 'http://www.homeshop18.com/';
	}
	public function getLogo(){
		return "http://www.homeshop18.com/homeshop18/media/images/homeshop18_2011/header/hs18-logo.png";
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::BOOKS){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:10000";
		}else if($category == Category::MOBILE){
			return "http://www.homeshop18.com/$query/mobiles/search:$query/categoryid:14569";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.homeshop18.com/$query/accessories/categoryid:3032/search:$query/";
			if($subcat == Category::MOB_CASES){
				return "http://www.homeshop18.com/$query/cases-pouches/categoryid:3036/search:$query/";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.homeshop18.com/$query/scratch-guard-screen-protector/categoryid:3042/search:$query/";
			}($subcat == Category::MOB_CHARGER){
				return "http://www.homeshop18.com/$query/chargers/categoryid:3037/search:$query/";
			}($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADSETS $subcat == Category::MOB_HEADPHONE){
				return "http://www.homeshop18.com/$query/handsfree-headsets/categoryid:3039/search:$query/";
			}($subcat == Category::MOB_BATTERY){
				return "http://www.homeshop18.com/$query/batteries/categoryid:3033/search:$query/";
			}($subcat == Category::MOB_MEMORY){
				return "http://www.homeshop18.com/$query/memory-cards/categoryid:3040/search:$query/";
			}($subcat == Category::MOB_OTHERS){
				return "http://www.homeshop18.com/$query/others/categoryid:3043/search:$query/";
			}elseif($subcat == Category::NOT_SURE){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3032/search:$query/";
			}else return "";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.homeshop18.com/$query/digital-cameras/categoryid:3178/search:$query/";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.homeshop18.com/$query/camcorders/categoryid:3164/search:$query/";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.homeshop18.com/$query/digital-cameras/categoryid:3178/search:$query/";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.homeshop18.com/$query/digital-cameras/categoryid:3188/search:$query/";
			}else {
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3170/search:$query/";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3172/search:$query/";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3175/search:$query/";
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3172/search:$query/";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.homeshop18.com/$query/accessories/categoryid:8933/search:$query/";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.homeshop18.com/$query/accessories/categoryid:8935/search:$query/";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.homeshop18.com/$query/accessories/categoryid:8931/search:$query/";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.homeshop18.com/$query/memory-storage-media/categoryid:3192/search:$query/";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3170/search:$query/";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3176/search:$query/";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.homeshop18.com/$query/accessories/categoryid:3177/search:$query/";
			}else{
				return '';
			}
		}else{
			return "http://www.homeshop18.com/$query/search:$query";
		}
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);

		if($category == Category::BOOKS){
			foreach(pq('div.book_rock') as $div){
				if(sizeof(pq($div)->find('.listView_image'))){
					$image = pq($div)->find('.listView_image')->html();
					$url = pq($div)->find('.listView_image')->attr('href');
					$name = pq($div)->find('.listView_details')->find('.listView_title')->find('a')->html();
					$disc_price = pq($div)->find('.listView_details')->find('.listView_price')->find('.our_price')->html();
					$offer = '';
					$shipping = pq($div)->find('.listView_info')->find('.listView_shipping')->html();
					$stock = 0;
					if(sizeof(pq($div)->find('.listView_info')->find('.in_stock')) > 0){
						$stock = 1;
					}else{
						$stock = -1;
					}
					$author = pq($div)->find('.listView_details')->find('.listView_title')->find('span')->html();
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
							'cat' => Category::BOOKS
					);
				}
			}
		}else{
			foreach(pq('div.product_div') as $div){
				if(sizeof(pq($div)->find('.product_image'))){
					$image = pq($div)->children('.product_image')->find('a')->html();
					$url = pq($div)->children('.product_image')->find('a')->attr('href');
					$name = pq($div)->children('.product_title')->children('a')->html();
					$disc_price = strip_tags(pq($div)->find('.product_price')->find('.product_new_price')->html());
					//$org_price = strip_tags(pq($div)->find('.product_price')->find('.product_new_price')->html());
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