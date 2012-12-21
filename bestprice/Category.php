<?php
class Category{
	const MOBILE = '1';
	const TABLETS = '2';
	const TV = 3;
	const GAMING = 4;
	const COMP_LAPTOP = 5;
	const COMP_ACC = 6;
	const CAMERA = 7;
	const NUTRITION = 8;
	const BOOKS = 9;
	const HOME_APPLIANCE = 10;
	const BEAUTY  =11;

	public function getStoreCategory(){
		return array(
				self::MOBILE=>'Mobiles',
				self::MOBILE=>'Mobiles Accessories',
				self::TABLETS=>'Tablets',
				//self::TV=>'TV, Video & Audio',
				self::GAMING =>'Gaming',
				//self::COMP_LAPTOP=>'Computer & Laptop',
				//self::COMP_ACC=>'Computer Accessories & Software',
				//self::CAMERA=>'Cameras',
				self::NUTRITION=>'Nutrition',
				self::BOOKS=>'Books',
				//self::HOME_APPLIANCE=>'Home Appliances',
				//self::BEAUTY=>'Health & Beauty'
		);

		//other section we can see
		//1. gift 2. baby care 3. music 4. toys 5. ebooks 6. Movies 7. mobile recharge 8. automobile acc
		//9. baby products
	}
}