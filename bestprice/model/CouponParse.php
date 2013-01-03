<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class CouponParse extends SmartModel{
	public $id;
	public $uniq_id;
	public $coupon_code;
	public $coupon_type;
	public $deal_url;
	public $title;
	public $desc;
	public $website;
	public $success;
	public $code;
	public $read;
	public $website_landing;

	public $_table = "coupon_parse";
	public $_fields = array('id','uniq_id','coupon_code','coupon_type','deal_url','title','desc','website','success','code','read','website_landing');
}