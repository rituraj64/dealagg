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

	const DATA_NUM = 4;
	public function getCode(){
		return $this->_code;
	}

	public function isTrusted($category){
		return false;
	}
	public function getWebsites(){
		// indiaplaza gives page requested was moved.
		// check if these needs to be added samsungindiaestore.com,next.co.in,
		//uread shows price in USD, right now i am multiping with exchange rate, but that doesnt give correct amt in INR as per site
		// http://www.imagestore.co.in its offiec cannon store
		// add http://www.shoperskart.com/
		// add pepperfry
		// add egully

		// for greendust, its important to go to product page since they sell second hand stuff also
		// naaptol product page need to get shop points and shipping charges
		// buytheprice.com, process product page to get details about seller etc
		// check if need to search ebay
		//shopclues, need to parse product page to get coupon code and special offer


		//for snapdeal need to think something about brands pages, if you search sony it goes to its brand page and not that perticular category



		//CostPrize this is disabled right now, cos site doesnt look good

		return array('Flipkart','Snapdeal','ShopClues','Tradus','Indiatimes','Zoomin','Saholic','Landmark','Infibeam','Homeshop','Croma','Crossword','EBay','Rediff','uRead','Bookadda','Justbooks','Letskart','Amegabooks','Simplebooks','Indianbooks','Yebhi','Greendust','Adexmart','Naaptol','BuyThePrice','FutureBazaar','Fosila','MirchiMart','Seventymm','TheMobileStore','Sulekha','TimTara','Bagittoday','Storeji','Letshop','eDabba','Royalimages','Suzalin','Giffiks','ManiacStore','ezeekart','Kaunsa');
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
	public function getPriceData($query,$category = false,$subcat = 0,$delay = true,$cache = 1){
		$url = $this->getSearchURL($query,$category,$subcat);
		if(empty($url)){
			return array(); //no result
		}

		$website = $this->getCode();
		if($cache == 0){
			$this->deleteCachedData($website, $query, $category,$subcat,$url);
		}
		if($this->hasCachedData($website, $query, $category,$subcat,$url)){
			$data = $this->getCachedData($website, $query,$category,$subcat, $url);
			$this->_resultTime = $this->getCachedDataTime($website, $query, $category,$subcat, $url);
			//$data = $this->getData($data,$query,$category);
			//return $data;
			return json_decode($data,true);
		}else{
			if(!$delay){
				$parser = new Parser();

					
				$html = $parser->getHtml($url,$this->getPostFields($query));
				//$this->cacheData($website, $query,$category, $url, $html);

				$data = $this->getData($html,$query,$category,$subcat);
				$this->_resultTime = time();
				$this->cacheData($website, $query,$category,$subcat, $url, json_encode($data));
				return $data;
			}else{
				return false;
			}
		}
	}
	public function deleteCachedData($website, $query, $category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		$filename = 'cache/'.$cacheKey;
		if(file_exists($filename)){
			unlink($filename);
		}
	}
	public function getCachedData($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		$filename = 'cache/'.$cacheKey;
		$content = '';
		if(file_exists($filename)){
			$content = file_get_contents('cache/'.$cacheKey);
		}
		return $content;
	}
	public function getCachedDataTime($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		$filename = 'cache/'.$cacheKey;
		if(file_exists($filename)){
			$time = filemtime($filename);
			return $time;
		}
		return false;
	}
	public function hasCachedData($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
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

	public function cacheData($website,$query,$category,$subcat,$url,$html){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		file_put_contents('cache/'.$cacheKey,$html);
	}
	private function getCacheKey($website,$query,$category,$subcat,$url){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);

		$category = urldecode($category);
		$category = preg_replace("![^a-z0-9]+!i", "-", $category);

		$subcat  = urldecode($subcat );
		$subcat  = preg_replace("![^a-z0-9]+!i", "-", $subcat );

		$cacheKey = $website.'-'.$query2.'-'.$category.'-'.$subcat.'-'.md5($url);
		return $cacheKey;
	}
	public function cleanProductData($data){
		foreach($data as $key => $value){
			$value = $this->clearHtml($value);
			$value = utf8_encode($value); //changed for homeshop18
			$data[$key] = trim($value);
		}

		foreach($data['attr'] as $key => $value){
			$n = array();
			foreach($value as $v){
				$v = $this->clearHtml($v);
				$v = utf8_encode($v); //changed for homeshop18
				$n[] = trim($value);
			}
			$data['attr'][$key] = $n;
		}

		$row['price'] = $this->removeAlpha($row['price'],true);
		$row['price'] = round($row['price'],2);
		if($row['price'] > 99999999){
			$row['price'] = '';
		}else if($row['price'] == 0){
			$row['price'] = '';
		}

		$row['name'] = ucwords($row['name']);

		if($row['stock'] == 0 || $row['stock'] == 1 || $row['stock'] == -1){

		}else{
			if(strtolower($row['stock']) == 'out of stock'){
				$row['stock'] = -1;
			}else if(strtolower($row['stock']) == 'in stock'){
				$row['stock'] = 1;
			}else{
				$row['stock'] = 0;
			}
		}

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
		return $data2;
	}
	public function cleanData($data,$query){
		$data2 = array();
		foreach($data as $row){
			foreach($row as $key => $value){
				$value = $this->clearHtml($value);
				$value = utf8_encode($value); //changed for homeshop18
				$row[$key] = trim($value);
			}

			$row['disc_price'] = $this->removeAlpha($row['disc_price'],true);
			$row['disc_price'] = round($row['disc_price'],2);
			if($row['disc_price'] > 99999999){
				$row['disc_price'] = '';
			}else if($row['disc_price'] == 0){
				$row['disc_price'] = '';
			}


			if(empty($row['image'])){
				$row['image'] = Parser::AJAX_URL . 'img/50x50.gif';
			}else{
				$row['image'] = $this->makeAbsUrl($row['image']);
			}
			$row['url'] = $this->makeAbsUrl($row['url']);

			$row['name'] = ucwords($row['name']);

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
	public function bestMatchData($data,$query,$category,$subcat){
		$data2 = array();
		$i = 0;
		foreach($data as $row){
			if($row['disc_price'] > 0 && $row['disc_price'] != '' || true){ //removed price check, cos flipkart has item with price N/A
				$i++;
				if($i > self::DATA_NUM){
					break;
				}
				$data2[] = $row;
			}
		}

		//make entry into html detecting system

		foreach($data2 as $row){
			$problem = '';
			if(empty($row['price']) || $row['price'] <=0 ){
				$problem .= 'Empty Price Found';
			}
			if(empty($row['name'])){
				$problem .= 'Empty Name Found';
			}
			if(empty($row['image'])){
				$problem .= 'Empty Image Found';
			}
			if(empty($row['url'])){
				$problem .= 'Empty URL Found';
			}
			if(!empty($problem)){
				$problem .= print_r($row,true);
				require_once dirname(__FILE__).'/model/HtmlDetect.php';
				$detect = new HtmlDetect();
				$detect->website = $this->getCode();
				$url = $this->getSearchURL($query,$category,$subcat);
				$detect->search_url = $url;
				$detect->cache_key = $this->getCacheKey($this->getCode(), $query,$category,$subcat, $url);
				$detect->problem = $problem;
				$detect->insert();
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
		return utf8_encode($text); //change to this safter homeshop18 null
		//return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
	}
	public function getPostFields($query,$category = false,$subcat=false){
		return array();
	}
	public function getFacebookUrl(){
		return false;
	}
	public function getProductData($html,$price,$stock){
		return false;
	}
}