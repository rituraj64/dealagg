<?php
require_once 'phpQuery.php';
require_once 'Parser.php';
class Parsing
{
	public function getCode(){
		return $this->_code;
	}
	
	public function getWebsites(){
		return array('Tradus');
	}
	
}