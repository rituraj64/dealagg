<?php

class ShopClues extends Parsing{
	public $_code = 'ShopClues';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.shopclues.com';
	}

	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1383&q=$query&dispatch=products.search";
		}else if($category == Category::CAMERA){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=682&q=$query&dispatch=products.search";
		}else if($category == Category::MOBILE){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=455&q=$query&dispatch=products.search";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1471&q=$query&dispatch=products.search";
		}else if($category == Category::CAMERA){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=461&q=$query&dispatch=products.search"; //digtal camere,point&shoot
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1475&q=$query&dispatch=products.search"; //mirror less
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=683&q=$query&dispatch=products.search"; //dslr
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1174&q=$query&dispatch=products.search"; //camcorder
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=1174&q=$query&dispatch=products.search"; //camcorder
		}elseif($category == Category::CAMERA_ACC){
			return "http://www.shopclues.com/?subcats=Y&status=A&pname=Y&product_code=Y&match=all&pkeywords=Y&search_performed=Y&cid=688&q=$query&dispatch=products.search"; //camcorder
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
		$data = $this->bestMatchData($data, $query,$category);
		return $data;
	}
}