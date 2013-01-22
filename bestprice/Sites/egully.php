<?php
class egully extends Parsing{
	public $_code = 'egully';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/egullydeals';
	}
	public function getAllowedCategory(){
		return array(Category::CAMERA_ACC,Category::BOOKS,Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC,Category::COMP_COMPUTER,Category::COMP_LAPTOP);
	}

	public function getWebsiteUrl(){
		return 'http://www.egully.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.egully.com/search.php?mode=1&search_query_adv=$query&brand=&category[]=8&searchsubs=ON&price_from=&price_to=&featured=&shipping=";
		}elseif ($category == Category::MOBILE_ACC){
			return "http://www.egully.com/search.php?mode=1&search_query_adv=$query&brand=&category[]=9&searchsubs=ON&price_from=&price_to=&featured=&shipping=";
		}elseif($category == Category::CAMERA_ACC){
			return "http://www.egully.com/search.php?mode=1&search_query_adv=$query&brand=&category[]=92&searchsubs=ON&price_from=&price_to=&featured=&shipping=";
		}elseif($category == Category::CAMERA){
			return "http://www.egully.com/search.php?mode=1&search_query_adv=$query&brand=&category[]=16&searchsubs=ON&price_from=&price_to=&featured=&shipping=";
		}else{
			return 'http://www.egully.com/search.php?search_query='.$query.'&x=0&y=0';
		}
	}

	public function getLogo(){
		return 'http://www.egully.com/product_images/egullyLogo.png';
	}
	public function getData($html,$query,$category,$subcat){

	}
}