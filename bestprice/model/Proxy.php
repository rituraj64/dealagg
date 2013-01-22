<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Proxy extends SmartModel{
	public $id;
	public $proxy;
	public $data;

	public $_table = "proxy";
	public $_fields = array('id','proxy','data');
}