<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Product extends SmartModel{
	public $id;
	public $full_name;
	public $brand;
	public $model_no;
	public $category_id;
	public $prod_order;

	public $_table = "product";
	public $_fields = array('id','full_name','brand','model_no','category_id','prod_order');
}