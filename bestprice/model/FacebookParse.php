<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class FacebookParse extends SmartModel{
	public $id;
	public $website;
	public $last_id;
	
	public $_table = "facebook_parse";
	public $_fields = array('id','website','last_id');
}