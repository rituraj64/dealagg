<?php
require_once 'phpQuery-onefile.php';
require_once 'Parser.php';
require_once 'Category.php';
set_time_limit(10000);
class Parsing{
	//public $_code = 'Website';

	public function getCode(){
		return $this->_code;
	}
	public function getWebsites(){
		//,'Sulekha','TheMobileStore'  the html is not valid is not included yet in list.
		// indiaplaza gives page requested was moved.
		return array('Snapdeal','ShopClues','Flipkart','Tradus','Indiatimes','Zoomin','Saholic','Landmark','Infibeam','Homeshop','Croma','Crossword','EBay','Rediff','uRead','Bookadda');
	}
	public function allowCategory($cat){
		foreach($this->getAllowedCategory() as $key => $val){
			if($cat == $val){
				return true;
			}
		}
		return false;
	}
	public function getPriceData($query,$category = false,$delay = true){
		$url = $this->getSearchURL($query,$category);
		$website = $this->getCode();
		if($this->hasCachedData($website, $query, $category,$url)){
			$data = $this->getCachedData($website, $query,$category, $url);
			return json_decode($data,true);
		}else{
			if(!$delay){
				$parser = new Parser();
				$html = $parser->getHtml($url);
				$data = $this->getData($html,$query,$category);
				$this->cacheData($website, $query,$category, $url, json_encode($data));
				return $data;
			}else{
				return false;
			}
		}
	}
	public function getCachedData($website,$query,$category,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category, $url);
		$filename = 'cache/'.$cacheKey;
		$content = '';
		if(file_exists($filename)){
			$content = file_get_contents('cache/'.$cacheKey);
		}
		return $content;
	}
	public function hasCachedData($website,$query,$category,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category, $url);
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

	public function cacheData($website,$query,$category,$url,$html){
		$cacheKey = $this->getCacheKey($website, $query,$category, $url);
		file_put_contents('cache/'.$cacheKey,$html);
	}
	private function getCacheKey($website,$query,$category,$url){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);

		$category = urldecode($category);
		$category = preg_replace("![^a-z0-9]+!i", "-", $category);


		$cacheKey = $website.'-'.$query2.'-'.$category.'-'.md5($url);
		return $cacheKey;
	}
	public function cleanData($data,$query){
		$data2 = array();
		foreach($data as $row){
			foreach($row as $key => $value){
				$value = $this->clearHtml($value);
				$row[$key] = trim($value);
			}

			$row['disc_price'] = $this->removeAlpha($row['disc_price'],true);

			$row['image'] = $this->makeAbsUrl($row['image']);
			$row['url'] = $this->makeAbsUrl($row['url']);

			if(isset($row['author'])){
				$row['author'] = trim(str_replace("by", '', $row['author']));
				$row['author'] = $this->removeSpecial($row['author']);
			}

			$data2[] = $row;
		}
		return $data2;
	}
	public function bestMatchData($data,$query){
		$data2 = array();
		$i = 0;
		foreach($data as $row){
			$data2[] = $row;
			if($i > 7){
				break;
			}
			$i++;
		}
		return $data2;
	}
	public function clearHtml($str){
		$str = trim(strip_tags(str_replace(PHP_EOL, '', $str)));
		$str = str_replace('&nbsp;', '', $str);
		return $str;
	}
	public function removeNum($str){
		return trim(preg_replace("![^a-z]+!i", "", $str));
	}
	public function removeAlpha($str,$isPrice){
		if($isPrice){
			$price  = trim(preg_replace("![^0-9.]+!i", "", $str));
			if(strpos($price, '.') == 0 && strpos($price, '.') !== false){
				$price = substr($price,1, strlen($price));
			}
			return $price;
		}else{
			return trim(preg_replace("![^0-9]+!i", "", $str));
		}
	}
	public function removeSpecial($str){
		return trim(preg_replace("![^0-9a-z ]+!i", "", $str));
	}
	public function makeAbsUrl($img){
		if(empty($img)){
			return $img;
		}
		if(strpos($img, 'http') === false && strpos($img, '.com') === false){
			$hasImage = false;
			$hasUrl = false;
			if($img[0] == '/'){
				$hasImage = true;
			}
			$website_url = $this->getWebsiteUrl();
			if($website_url[strlen($website_url)-1] == '/')
			{
				$hasUrl = true;
			}
			if($hasImage && $hasUrl){
				return substr($website_url, 0,-1).$img;
			}else{
				return $website_url.$img;
			}
		}else{
			return $img;
		}
	}
}