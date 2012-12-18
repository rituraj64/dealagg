<?php

class ShopClues extends Parsing{
	public $_code = 'ShopClues';
	
	public function getWebsiteUrl(){
		return 'http://www.shopclues.com';
	}
	
	public function getSearchURL($query,$category = false){
		return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=0&dispatch=products.search&q=".$query;
	}
	public function getLogo(){
		return "http://www.shopclues.com/images/skin/diwali-logo-fevicon.gif";
	}
	public function getData($html){
		
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