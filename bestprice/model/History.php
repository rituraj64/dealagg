<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class History extends SmartModel{
	public $id;
	public $name;
	public $model_no;
	public $brand;
	public $data;
	public $updated_at;

	public $_table = "product_history";
	public $_fields = array('id','name','model_no','brand','data','updated_at');
}