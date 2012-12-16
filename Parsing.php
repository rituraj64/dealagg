<?php
require_once 'phpQuery-onefile.php';
class Parsing{
	public $_code = 'Website';
	
	public function getCode(){
		return $this->_code;
	}
	public function getWebsites(){
		return array('ShopClues','Flipkart','Tradus','Indiatimes','Sulekha','Zoomin');
	}
}