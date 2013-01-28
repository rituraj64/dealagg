<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class HtmlDetect extends SmartModel{
	public $id;
	public $website;
	public $search_url;
	public $cache_key;
	public $problem;
	public $warned;
	public $priority;
	public $html;
	
	public $_table = 'html_detect';
	public $_fields = array('id','website','search_url','cache_key','problem','warned','priority','html');
}