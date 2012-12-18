<?php
require_once 'phpQuery-onefile.php';
require_once 'Parser.php';
set_time_limit(10000);
class Parsing{
	//public $_code = 'Website';

	public function getCode(){
		return $this->_code;
	}
	public function getWebsites(){
		//,'Sulekha','TheMobileStore'  the html is not valid is not included yet in list.
		return array('ShopClues','Flipkart','Tradus','Indiatimes','Zoomin','Saholic','Snapdeal','Landmark','Infibeam','Homeshop','Croma');
	}
	public function getPriceData($query,$category = false,$delay = true){
		$url = $this->getSearchURL($query,$category);
		$website = $this->getCode();
		if($this->hasCachedData($website, $query, $category,$url)){
			$html = $this->getCachedData($website, $query, $url);
			return $this->getData($html);
		}else{
			if(!$delay){
				$parser = new Parser();
				$html = $parser->getHtml($url);
				$this->cacheData($website, $query, $url, $html);
				return $this->getData($html);
			}else{
				return false;
			}
		}
	}
	public function getCachedData($website,$query,$url){
		$cacheKey = $this->getCacheKey($website, $query, $url);
		$filename = 'cache/'.$cacheKey;
		$content = '';
		if(file_exists($filename)){
			$content = file_get_contents('cache/'.$cacheKey);
		}
		return $content;
	}
	public function hasCachedData($website,$query,$category,$url){
		$cacheKey = $this->getCacheKey($website, $query, $url);
		$filename = 'cache/'.$cacheKey;
		if(file_exists($filename)){
			$time = filemtime($filename);
			$expiry = 24 * 60 * 60;
			if(time() - $time > $expiry){
				unlink($filename);
				return false;
			}else{
				return true;
			}
		}
		return false;
	}

	public function cacheData($website,$query,$url,$html){
		$cacheKey = $this->getCacheKey($website, $query, $url);
		file_put_contents('cache/'.$cacheKey,$html);
	}
	private function getCacheKey($website,$query,$url){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);
		$cacheKey = $website.'-'.$query2.'-'.md5($url);
		return $cacheKey;
	}
}