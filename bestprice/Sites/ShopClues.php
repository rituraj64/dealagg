<?php

class ShopClues extends Parsing{

	public $_code = 'ShopClues';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/ShopClues';
	}
	public function isTrusted($category){
		return true;
	}
	public function getAllowedCategory(){
		return array(Category::GAMING,Category::TABLETS,Category::MOBILE,Category::MOBILE_ACC,Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.shopclues.com';
	}

	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::BOOKS){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1383&q=$query&dispatch=products.search";
		}else if($category == Category::MOBILE){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=455&q=$query&dispatch=products.search";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1471&q=$query&dispatch=products.search";
			if ($subcat == Category::MOB_BATTERY){
				return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1533";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1456";
			}elseif ($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1064";
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1346";
			}elseif ($subcat == Category::MOB_SPEAKER){
				return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1630";
			}elseif ($subcat == Category::MOB_CAR_ACC){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=628&q=$query&dispatch=products.search";
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=682&q=$query&dispatch=products.search";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=461&q=$query&dispatch=products.search"; //digtal camere,point&shoot
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=683&q=$query&dispatch=products.search"; //dslr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1174&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1475&q=$query&dispatch=products.search"; //mirror less
			}
		}elseif($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=688&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1625&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1317&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=114&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1642&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1315&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=681&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1344&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=688&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1623&q=$query&dispatch=products.search"; //camcorder
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1313&q=$query&dispatch=products.search"; //camcorder
			}else{
				return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=688&q=$query&dispatch=products.search"; //camcorder
			}
		}elseif($category == Category::COMP_LAPTOP){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=85&q=$query&dispatch=products.search";
		}elseif($category == Category::TABLETS){
			return "http://www.shopclues.com/index.php?dispatch=products.search&q=$query&subcats=N&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1566";
		}elseif($category == Category::GAMING){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=668&q=$query&dispatch=products.search";
		}else{
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=0&dispatch=products.search&q=".$query;
		}
	}
	public function getLogo(){
		return "http://www.shopclues.com/images/skin/diwali-logo-fevicon.gif";
	}
	public function getData($html,$query,$category,$subcat){

		$i = 0;
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.box_GridProduct') as $div){
			$image = pq($div)->find('a.box_metacategory_image')->children()->attr('src2');
			$a_link = pq($div)->find('.box_metacategory_name');
			$name = $a_link->html();
			$url = $a_link->attr('href');
			if(sizeof(pq($div)->children('.box_metacategory_pricing')->find('.box_metacategory_priceoffer'))){
				$disc_price = pq($div)->children('.box_metacategory_pricing')->find('.box_metacategory_priceoffer')->html();
			}else{
				pq($div)->children('.box_metacategory_pricing')->find('.nl_red_icon_spl_offer_tag')->remove();
				$disc_price = pq($div)->children('.box_metacategory_pricing')->find('span:last')->html();
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
			$i++;
		}
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query,$category,$subcat);
		return $data;
	}
}