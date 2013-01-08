<?php
	require_once '../smartmodel/SmartModel.php';
	class coupon_active extends SmartModel
	{
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
		
		public $_table = "coupon_active";
		public $_fields = array('id','active_from','active_to','discount','discount_type','category','product','description','deal_url','deal_type','coupon_code','min_amt','bank','image');
		
	}
	class coupon_parse extends SmartModel
	{
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
		
		public $_table = "coupon_parse";
		public $_fields = array('id','uniq_id','coupon_code','coupon_type','deal_url','title','website','desc','success','code','read');
		
	}
?>