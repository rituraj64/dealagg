<?php
class egully extends Parsing{
	public $_code = 'egully';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/egullydeals';
	}
	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC,Category::COMP_COMPUTER,Category::COMP_LAPTOP);
	}

	public function getWebsiteUrl(){
		return 'http://www.egully.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return 'http://www.egully.com/search.php?search_query='.$query.'&x=0&y=0';
	}

	public function getLogo(){
		return 'http://www.egully.com/product_images/egullyLogo.png';
	}
	public function getData($html,$query,$category,$subcat){

	}
}