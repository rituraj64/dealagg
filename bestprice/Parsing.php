<?php
require_once 'phpQuery-onefile.php';
require_once 'Parser.php';
require_once 'Category.php';
set_time_limit(10000);
class Parsing{
	//public $_code = 'Website';

	public static function getReplace(){
		return array('&amp;'=>'and','&'=>'and');
	}

	const DATA_NUM = 9;
	public function getCode(){
		return $this->_code;
	}
	public function getWebsites(){
		// indiaplaza gives page requested was moved.
		// check if these needs to be added samsungindiaestore.com,ezeekart.com,next.co.in,
		// maniac store is search post form
		// http://www.imagestore.co.in its offiec cannon store
		// add kaunsa.com

		// for greendust, its important to go to product page since they sell second hand stuff also
		// naaptol product page need to get shop points and shipping charges
		// buytheprice.com, process product page to get details about seller etc
		// check if need to search ebay
		//shopclues, need to parse product page to get coupon code and special offer
		return array('Flipkart','Snapdeal','ShopClues','Tradus','Indiatimes','Zoomin','Saholic','Landmark','Infibeam','Homeshop','Croma','Crossword','EBay','Rediff','uRead','Bookadda','Justbooks','Letskart','Amegabooks','Simplebooks','Indianbooks','Yebhi','Greendust','Adexmart','Naaptol','BuyThePrice','FutureBazaar','CostPrize','Fosila','MirchiMart','Seventymm','TheMobileStore','Sulekha','TimTara','Bagittoday','Storeji','Letshop','eDabba','Royalimages','Suzalin','Giffiks');
	}
	public function allowCategory($cat){
		foreach($this->getAllowedCategory() as $key => $val){
			if($cat == $val){
				return true;
			}
		}
		return false;
	}
	private $_resultTime = 0;
	public function getResultTime(){
		return $this->_resultTime;
	}
	public function getPriceData($query,$category = false,$delay = true,$cache = 1){
		$url = $this->getSearchURL($query,$category);
		$website = $this->getCode();
		if($cache == 0){
			$this->deleteCachedData($website, $query, $category,$url);
		}
		if($this->hasCachedData($website, $query, $category,$url)){
			$data = $this->getCachedData($website, $query,$category, $url);
			$this->_resultTime = $this->getCachedDataTime($website, $query, $category, $url);
			//$data = $this->getData($data,$query,$category);
			//return $data;
			return json_decode($data,true);
		}else{
			if(!$delay){
				$parser = new Parser();
				$html = $parser->getHtml($url);

				//$this->cacheData($website, $query,$category, $url, $html);

				$data = $this->getData($html,$query,$category);
				$this->_resultTime = time();
				$this->cacheData($website, $query,$category, $url, json_encode($data));
				return $data;
			}else{
				return false;
			}
		}
	}
	public function deleteCachedData($website, $query, $category,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category, $url);
		$filename = 'cache/'.$cacheKey;
		if(file_exists($filename)){
			unlink($filename);
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
	public function getCachedDataTime($website,$query,$category,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category, $url);
		$filename = 'cache/'.$cacheKey;
		if(file_exists($filename)){
			$time = filemtime($filename);
			return $time;
		}
		return false;
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
				$value = $this->Convert_TO_Utf8($value);
				$row[$key] = trim($value);
			}

			$row['disc_price'] = $this->removeAlpha($row['disc_price'],true);

			$row['image'] = $this->makeAbsUrl($row['image']);
			$row['url'] = $this->makeAbsUrl($row['url']);

			if(isset($row['author'])){
				$row['author'] = trim(str_replace("by ", '', $row['author']));
				$row['author'] = trim(str_replace("By ", '', $row['author']));
				$row['author'] = trim(str_replace("By: ", '', $row['author']));
				$row['author'] = trim(str_replace("by: ", '', $row['author']));
				$row['author'] = trim(str_replace("BY ", '', $row['author']));
				$row['author'] = trim(str_replace("BY: ", '', $row['author']));
				$row['author'] = $this->removeSpecial($row['author']);
			}

			$data2[] = $row;
		}
		return $data2;
	}
	public function bestMatchData($data,$query,$category){
		$data2 = array();
		$i = 0;
		foreach($data as $row){
			if($row['disc_price'] > 0 && $row['disc_price'] != ''){
				$i++;
				if($i > self::DATA_NUM){
					//break;
				}
				$data2[] = $row;
			}
		}


		/*
		 $data3 = array();
		$sorting = new Sorting();
		//		print_r($names);
		$names = $sorting->sort($names, $query);
		//	print_r($names);die;
		foreach($names as $name){
		foreach($data2 as $row){
		if($row['name'] == $name){
		$data3[] = $row;
		break;
		}
		}
		}
		*/
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
	public static function removeSpecial($str){
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
	public function Convert_TO_Utf8($text)
	{
		return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
	}
}