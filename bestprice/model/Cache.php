<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Cache extends SmartModel{
	public $id;
	public $cache_key;
	public $time;
	public $cache_type;
	public $cache_data;
	public $hits;

	public $_table = "cache";
	public $_fields = array('id','cache_key','time','cache_type','cache_data','hits');
}