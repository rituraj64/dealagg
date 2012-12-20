<?php
require_once 'phpQuery.php';
require_once 'Parser.php';
class Parsing{
//list of websits to be scraped	
	public function getWebsites(){
		//,'Sulekha','TheMobileStore'  the html is not valid is not included yet in list.
		// indiaplaza gives page requested was moved.
		return array('Tradus');
	}
}