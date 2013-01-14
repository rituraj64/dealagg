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
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
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
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1471&q=$query&dispatch=products.search";
			/*
			 * for mobile acc catogeries later
			*
			* if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
			return "";
			}elseif ($subcat == Category::MOB_BATTERY){
			return "";
			}elseif ($subcat == Category::MOB_HEADSETS){
			return "";
			}elseif ($subcat == Category::MOB_CASES){
			return "";
			}elseif ($subcat == Category::MOB_CHARGER){
			return "";
			}elseif ($subcat == Category::MOB_HANDSFREE){
			return "";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
			return "";
			}elseif ($subcat == Category::MOB_HEADPHONE){
			return "";
			}else return "";
			*/
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
			}else{
				return '';
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
				return '';
			}
		}elseif($category == Category::COMP_COMPUTER || $category == Category::COMP_LAPTOP){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=85&q=$query&dispatch=products.search";
		}
		else{
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
			$disc_price = pq($div)->find('.box_metacategory_priceoffer')->html();
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
	public function hasProductdata(){
		return false;
	}
	public function getProductData($html,$price,$stock){
		return false; //takes lot of time for response
		phpQuery::newDocumentHTML($html);
		$price = pq('.product-prices')->find('.price')->html();
		$offer = pq('.box_specialoffer')->children('.box_specialoffer_message')->html();
		$offer .= ' + ' + floor($price*.2) . ' ShopClues Points';
		$stock = 0;
		if(sizeof(pq('.in-stock'))){
			$stock = 1;
		}else{
			$stock = -1;
		}
		$shipping_cost = '';
		$shipping_time = pq('.product-list-field:first')->html();;

		$attr = array();
		$cat = '';
		foreach(pq('.breadcrumbs')->find('a') as $li){
			$cat .= pq($li)->html().',';
		}

		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => '',
				'cat' => $cat
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}