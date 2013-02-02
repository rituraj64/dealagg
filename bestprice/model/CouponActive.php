<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class CouponActive extends SmartModel{
	public $id;
	public $active_from;
	public $active_to;
	public $discount;
	public $discount_type;
	public $category;
	public $product;
	public $deal_url;
	public $deal_type;
	public $coupon_code;
	public $min_amt;
	public $bank;
	public $description;
	public $image;
	public $max_discount;
	public $website;
	public $is_follow;

	public $_table = "coupon_active";
	public $_fields = array('id','active_from','active_to','discount','discount_type','category','product','deal_url','deal_type',
			'coupon_code','min_amt','bank','description','image','max_discount','website','is_follow');
}