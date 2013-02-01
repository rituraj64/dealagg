<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Follow extends SmartModel{
	public $id;
	public $query_id;
	public $follow_start;
	public $follow_end;
	public $follow_reason;
	public $userid;

	public $_table = "follow";
	public $_fields = array('id','query_id','follow_start','follow_end','follow_reason','userid');
	
	public function checkFollow($rows){
		
	}
}