<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class FollowUrl extends SmartModel{
	public $id;
	public $follow_url;
	public $follow_name;
	public $follow_website;
	public $prev_data;
	public $last_followed;
	public $follow_id;
	public $follow_brand;
	public $follow_modelno;

	public $_table = "follow_url";
	public $_fields = array('id','follow_url','follow_name','follow_website','prev_data','last_followed','follow_id','follow_brand','follow_modelno');
}