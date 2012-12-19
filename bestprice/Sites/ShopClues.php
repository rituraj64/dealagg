<?php

class ShopClues extends Parsing{
	public $_code = 'ShopClues';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://www.shopclues.com';
	}

	public function getSearchURL($query,$category = false){
		if($category == Category::BEAUTY){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=480&q=$query&dispatch=products.search";
		}else if($category == Category::BOOKS){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=93&q=$query&dispatch=products.search";
		}else if($category == Category::CAMERA){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=682&q=$query&dispatch=products.search";
		}else if($category == Category::COMP_ACC || $category == Category::COMP_LAPTOP){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=85&q=$query&dispatch=products.search";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=368&q=$query&dispatch=products.search";
		}else if($category == Category::MOBILE || $category == Category::TABLETS){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=453&q=$query&dispatch=products.search";
		}else if($category == Category::TV){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=460&q=$query&dispatch=products.search";
		}else if($category == Category::BEAUTY){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=480&q=$query&dispatch=products.search";
		}else{
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=0&dispatch=products.search&q=".$query;
		}
	}
	public function getLogo(){
		return "http://www.shopclues.com/images/skin/diwali-logo-fevicon.gif";
	}
	public function getData($html,$query,$category){

		$i = 0;
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.box_GridProduct') as $div){
			$image = pq($div)->find('a.box_metacategory_image')->children()->attr('src2');
			$a_link = pq($div)->find('.box_metacategory_name');
			$name = $a_link->html();
			$url = $a_link->attr('href');
			$org_price = pq($div)->find('.box_metacategory_price')->html();
			$disc_price = pq($div)->find('.box_metacategory_priceoffer')->html();
			$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
			$i++;
			if($i > 5){
				break;
			}
		}
		return $data;
	}
}