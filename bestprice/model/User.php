<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class User extends SmartModel{
	public $id;
	public $email;
	public $fb_id;
	public $firstname;
	public $lastname;
	public $time;

	public $_table = "registration";
	public $_fields = array('id','email','fb_id','firstname','lastname','time');
}