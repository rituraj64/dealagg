<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Search extends SmartModel{
	public $id;
	public $query;
	public $category;
	public $subcat;
	public $query_id;
	public $remove_websites;
	public $created_at;
	public $hits;
	public $time_taken;
	public $website_data;
	public $website_cache_data;

	public $_table = "search";
	public $_fields = array('id','query','category','subcat','query_id','remove_websites','created_at','hits','time_taken','website_data','website_cache_data');
}