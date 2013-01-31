<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class FollowUrl extends SmartModel{
	public $id;
	public $follow_url;
	public $follow_website;
	public $prev_data;
	public $last_followed;

	public $_table = "follow_up";
	public $_fields = array('id','follow_url','follow_website','prev_data','last_followed');
}