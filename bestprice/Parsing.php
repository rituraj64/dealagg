<?php
require_once 'phpQuery-onefile.php';
require_once 'Parser.php';
require_once 'Category.php';
require_once 'model/Cache.php';

set_time_limit(10000);
class Parsing{
	//public $_code = 'Website';

	const CACHE_FILE = 'FILE';
	const CACHE_DB = 'DB';
	const CACHE_NOCACHE = 'NO';

	public function getCurrentCache(){
		return self::CACHE_NOCACHE;
	}
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
		// buytheprice.com, process product page to get details about seller etc
		// check if need to search ebay
		//shopclues, need to parse product page to get coupon code and special offer


		//for snapdeal need to think something about brands pages, if you search sony it goes to its brand page and not that perticular category

		// need to add sub category, camcorder, because product like this Wespro DV538 Camcorder is not working correct.


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
	private $_query_id = false;
	public function setQueryId($query_id){
		$this->_query_id = $query_id;
	}

	private $_toParseHtml = '';
	public function getPriceData($query,$category = false,$subcat = 0,$delay = true,$cache = 1){
		$url = $this->getSearchURL($query,$category,$subcat);
		if(empty($url)){
			return array(); //no result
		}

		$website = $this->getCode();
		if($cache == 0){
			$this->deleteCachedData($website, $query, $category,$subcat,$url);
		}
		if($cache == 1 && $this->hasCachedData($website, $query, $category,$subcat,$url)){
			$data = $this->getCachedData($website, $query,$category,$subcat, $url);
			$this->_resultTime = $this->getCachedDataTime($website, $query, $category,$subcat, $url);
			//$data = $this->getData($data,$query,$category);
			//return $data;
			$data = json_decode($data,true);
			if(isset($data[0])){
				$row = $data[0];
				$text = $this->findBestCoupon(array('product'=>$row,'cat'=>$category));
				if(empty($text)){
					$text = 'Not Found';
				}
				$row['coupon'] = $text;
				$data[0] = $row;
			}
			return $data;
		}else{
			if(!$delay){
				$parser = new Parser();

					
				$html = $parser->getHtml($url,$this->getPostFields($query,$category,$subcat));
				//$this->cacheData($website, $query,$category, $url, $html);
				$this->_toParseHtml = $html;


				$data = $this->getData($html,$query,$category,$subcat);
				$this->_resultTime = time();

				if($this->_query_id){
					/*
					 if(!isset($_SESSION)){
					ini_set('session.cookie_domain', '.pricegenie.in');
					session_set_cookie_params(0, '/', '.pricegenie.in');
					session_start();
					if(isset($_REQUEST[session_name()]) && $_REQUEST[session_name()] != session_id()){
					$request_id = $_REQUEST[session_name()];
					session_id($request_id);
					}
					}
					$_SESSION[$website] = array();
					$_SESSION[$website][$this->_query_id] = $data;
					*/
					$file = $website.'-'.$this->_query_id;
					file_put_contents('cache/'.$file,json_encode($data));
				}

				$this->cacheData($website, $query,$category,$subcat, $url, json_encode($data));
				return $data;
			}else{
				return false;
			}
		}
	}
	public function deleteCachedData($website, $query, $category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		if($this->getCurrentCache() == self::CACHE_FILE){
			$filename = 'cache/'.$cacheKey;
			if(file_exists($filename)){
				unlink($filename);
			}
		}else if($this->getCurrentCache() == self::CACHE_DB){
			$cache = new Cache();
			//$cache->delete(array('cache_key'=>$cacheKey));
		}
	}
	public function getCachedData($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		$content = '';
		if($this->getCurrentCache() == self::CACHE_FILE){
			if(isset($_REQUEST['url_based'])){
				$cacheKey = $cacheKey . '-' . $_REQUEST['query_id'];
			}
			$filename = 'cache/'.$cacheKey;
			$content = '';
			if(file_exists($filename)){
				$content = file_get_contents('cache/'.$cacheKey);
				if(isset($_REQUEST['url_based'])){

				}else{
					$query_id = $this->_query_id;
					if($query){
						$cacheKey = $cacheKey . '-' . $query_id;
						if(!file_exists($filename)){
							file_put_contents('cache/'.$cacheKey,$content);
						}
					}
				}
			}
		}else if($this->getCurrentCache() == self::CACHE_DB){
			$cache = new Cache();
			$data = $cache->read(null,array('cache_key'=>$cacheKey),array('time'=>'asc'));
			if(sizeof($data) > 0){
				$content = $data[0]['cache_data'];
			}
			if(isset($_REQUEST['url_based'])){
				$content = '';
				$cache = new Cache();
				$data = $cache->read(null,array('cache_key'=>$cacheKey,'cache_type'=>$query_id));
				if(sizeof($data) > 0){
					$content = $data[0]['cache_data'];
					$cache->query('update `cache` set hits = hits + 1 where id = '.$data[0]['id']);
				}
			}else{
				$query_id = $this->_query_id;
				if($query){
					$cacheKey = $cacheKey;
					$cache = new Cache();
					$data = $cache->read(null,array('cache_key'=>$cacheKey,'cache_type'=>$query_id));
					if(sizeof($data) == 0){
						$cache->cache_key = $cacheKey;
						$cache->time = time();
						$cache->cache_type = 'query_id';
						$cache->cache_data = $content;
						$cache->insert();
					}
				}
			}
		}
		return $content;
	}
	public function getCachedDataTime($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		if($this->getCurrentCache() == self::CACHE_FILE){
			$filename = 'cache/'.$cacheKey;
			if(file_exists($filename)){
				$time = filemtime($filename);
				return $time;
			}
		}else if($this->getCurrentCache() == self::CACHE_DB){
			$cache = new Cache();
			$data = $cache->read(null,array('cache_key'=>$cacheKey),array('time'=>'asc'));
			if(sizeof($data)){
				return $data[0]['time'];
			}
		}
		return false;
	}
	public function hasCachedData($website,$query,$category,$subcat,$url){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		if($this->getCurrentCache() == self::CACHE_FILE){
			if(isset($_REQUEST['url_based'])){
				$cacheKey = $cacheKey . '-' . $_REQUEST['query_id'];
			}
			$filename = 'cache/'.$cacheKey;
			if(file_exists($filename)){
				if(isset($_REQUEST['url_based'])){
					return true;
				}else{
					$time = filemtime($filename);
					$expiry = 24 * 60 * 60;
					if(time() - $time > $expiry){
						unlink($filename);
						return false;
					}else{
						return true;
					}
				}
			}else{
				//echo $filename;die;
			}
		}else if($this->getCurrentCache() == self::CACHE_DB){
			$cache = new Cache();
			if(isset($_REQUEST['url_based'])){
				$data = $cache->smartRead(array('where'=>array('cache_key'=>$cacheKey,'cache_type'=>$_REQUEST['query_id'])));
				if(sizeof($data)){
					return true;
				}
			}else{
				$data = $cache->smartRead(array('where'=>array('cache_key'=>$cacheKey,array('time'=>'desc'))));
				if(sizeof($data)){
					$row = $data[0];
					$time = $row['time'];
					$expiry = 24 * 60 * 60;
					if(time() - $time > $expiry){
						//$cache->delete(array('id'=>$row['id']));
						return false;
					}else{
						return true;
					}
				}
			}
		}
		return false;
	}

	public function cacheData($website,$query,$category,$subcat,$url,$html){
		$cacheKey = $this->getCacheKey($website, $query,$category,$subcat, $url);
		if($this->getCurrentCache() == self::CACHE_FILE){

			//file_put_contents('cache/'.$cacheKey,$html);
			// not doing normal caching only query caching

			/* this code is for caching query wise, so the users previous data is saved */
			$query_id = $this->_query_id;
			if($query){
				$cacheKey = $cacheKey . '-' . $query_id;
				$s = file_put_contents('cache/'.$cacheKey,$html);
				if($s === false){
					error_log('unable to create file for cache'.$s);
				}
			}
		}else if($this->getCurrentCache() == self::CACHE_DB){
			/*
			 $cache = new Cache();
			$cache->cache_key = $cacheKey;
			$cache->time = time();
			$cache->cache_type = 'website';
			$cache->cache_data = $html;
			$cache->insert();
			*/

			$query_id = $this->_query_id;
			if($query){
				$cache = new Cache();
				$cache->cache_key = $cacheKey;
				$cache->time = time();
				$cache->cache_type = $query_id;
				$cache->cache_data = $html;
				$cache->insert();
			}
		}

	}
	private function getCacheKey($website,$query,$category,$subcat,$url){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);
		$query2 = strtolower($query2);

		$category = urldecode($category);
		$category = preg_replace("![^a-z0-9]+!i", "-", $category);

		$subcat  = urldecode($subcat );
		$subcat  = preg_replace("![^a-z0-9]+!i", "-", $subcat );

		$cacheKey = $website.'-'.$query2.'-'.$category.'-'.$subcat.'-'.md5($url);
		return $cacheKey;
	}
	public function cleanProductData($data){
		foreach($data as $key => $value){
			if(is_array($value)){
				continue;
			}
			$value = $this->clearHtml($value);
			$value = $this->removeSpecial($value,true);
			$value = utf8_encode($value); //changed for homeshop18
			$data[$key] = trim($value);
		}

		foreach($data['attr'] as $key => $value){
			$n = array();
			foreach($value as $v){
				$v = $this->clearHtml($v);
				$v = utf8_encode($v); //changed for homeshop18
				$n[] = trim($v);
			}
			$data['attr'][$key] = $n;
		}

		$data['price'] = $this->removeAlpha($data['price'],true);
		$data['price'] = round($data['price'],2);
		if($data['price'] > 99999999){
			$data['price'] = '';
		}else if($data['price'] == 0){
			$data['price'] = '';
		}

		if(strpos(strtolower($data['stock']),'out') !== false){
			$data['stock'] = -1;
		}else if(strpos(strtolower($data['stock']),'in')!==false || strpos(strtolower($data['stock']),'available')!==false){
			$data['stock'] = 1;
		}else{
			//$data['stock'] = 0;
		}

		if(isset($data['author'])){
			$data['author'] = trim(str_replace("by ", '', $data['author']));
			$data['author'] = trim(str_replace("By ", '', $data['author']));
			$data['author'] = trim(str_replace("By: ", '', $data['author']));
			$data['author'] = trim(str_replace("by: ", '', $data['author']));
			$data['author'] = trim(str_replace("BY ", '', $data['author']));
			$data['author'] = trim(str_replace("BY: ", '', $data['author']));
			$data['author'] = $this->removeSpecial($data['author']);
		}

		$data['website'] = $this->getCode();
		return $data;
	}
	public function cleanData($data,$query){
		$data2 = array();
		$index = 1;
		foreach($data as $row){
			foreach($row as $key => $value){
				$value1 = $this->clearHtml($value);
				if(!empty($value1)){
					$value = $value1;
				}
				$value1 = utf8_encode($value); //changed for homeshop18
				if(!empty($value1)){
					$value = $value1;
				}
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
			$row['index'] = $index;
			$data2[] = $row;
			$index++;
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

		if($query){
			$index = 0;
			foreach($data2 as $row){
				$problem = '';
				if(empty($row['disc_price']) || $row['disc_price'] <=0 ){
					$problem .= 'Empty Price Found';
					if($row['website'] == 'Landmark' && $row['stock'] == -1){
						$problem = '';
					}
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
					if($row['website'] == 'eBay' && $index != 0){
						continue;
					}
					$problem .= 'Index '.$index.' '.print_r($row,true);
					require_once dirname(__FILE__).'/model/HtmlDetect.php';
					$detect = new HtmlDetect();
					$detect->website = $this->getCode();
					$url = $this->getSearchURL($query,$category,$subcat);
					$detect->search_url = $url;
					$detect->cache_key = $this->getCacheKey($this->getCode(), $query,$category,$subcat, $url);
					$detect->problem = $problem;
					$detect->warned = 0;
					$detect->html = $this->_toParseHtml;
					if($index == 0){
						$detect->priority = 'HIGH';
					}else{
						$detect->priority = 'LOW';
					}
					$detect->insert();
				}
				$index++;
			}


			if(isset($data[0])){
				$row = $data[0];
				$text = $this->findBestCoupon(array('product'=>$row,'cat'=>$category));
				if(empty($text)){
					$text = 'Not Found';
				}
				$row['coupon'] = $text;
				$data[0] = $row;
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
		return $data;
	}
	public function clearHtml($str){
		$str = preg_replace(
				array(
						// Remove invisible content
						'@<iframe[^>]*?>.*?</iframe>@siu',
						'@<head[^>]*?>.*?</head>@siu',
						'@<style[^>]*?>.*?</style>@siu',
						'@<script[^>]*?.*?</script>@siu',
						'@<object[^>]*?.*?</object>@siu',
						'@<embed[^>]*?.*?</embed>@siu',
						'@<applet[^>]*?.*?</applet>@siu',
						'@<noframes[^>]*?.*?</noframes>@siu',
						'@<noscript[^>]*?.*?</noscript>@siu',
						'@<noembed[^>]*?.*?</noembed>@siu',
						// Add line breaks before and after blocks
				),
				array(
						' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '), $str );
		$str = trim(strip_tags(str_replace(PHP_EOL, '', $str)));
		$str = str_replace('&nbsp;', '', $str);
		// you can exclude some html tags here, in this case B and A tags
		while(strpos($str,'  ') !== false){
			$str = str_replace('  ', ' ', $str);
		}
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
	public static function removeSpecial($str,$light = false){
		if($light){
			return preg_replace('/[^(\x20-\x7F)]*/','', $str);
		}else{
			return trim(preg_replace("![^0-9a-z ]+!i", "", $str));
		}
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
	public function hasProductdata(){
		return false;
	}
	public function getProductData($html,$price,$stock){
		return false;
	}
	public function findBestCoupon($condition = array(),$dontCheckDate = false,$includeExpired = false){
		if(!isset($condition['website'])){
			$condition['website'] = $this->getCode();
		}
		$cat = -1;
		if(isset($condition['category'])){
			$cat = $condition['category'];
		}
		$name = '';
		$price = 0;
		if(isset($condition['product'])){
			$name = $condition['product']['name'];
			$price = $condition['product']['disc_price'];
		}
		$website = $condition['website'];
		$today = time();
		$category = new Category();
		$store_cats = $category->getStoreCategory();

		require_once 'model/CouponActive.php';
		$active = new CouponActive();
		$data = $active->query('select * from coupon_active where active_to >= '.time().' and website = "'.$website.'" order by id desc');
		$data = $active->getData($data);
		$data2 = array();

		$per = 0;
		$amt = 0;
		$title_amt = '';
		$title_per = '';

		foreach($data as $row){
			if(($row['active_to'] != 0 && $row['active_to'] > time()) || $dontCheckDate){
				if($cat != -1){
					$cats = $row['categories'];
					$cats = explode(',',$cats);
					if(!in_array($cat,$cats)){
						continue;
					}
				}
				if($row['min_amt'] >0 && $price > 0){
					if($price < $row['min_amt']){
						continue;
					}
				}


				if($row['bank'] != 'None'){
					continue;
				}

				if(!empty($row['product'])){
					if(!empty($name)){

						$found = false;
						$prod = explode(' ',$row['product']);
						foreach($prod as $p){
							if(strpos($name,$p) !== false){
								$found = true;
							}
						}
						if(!$found){
							continue;
						}
					}else{
						continue;
					}
				}


				if($row['discount_type'] == 'fixed'){
					if($row['discount'] > $amt){
						$amt = $row['discount'];
						$title_amt = 'Discounts Upto <span class="WebRupee">Rs.</span>'.$amt.' Valid Upto '. date('d M',$row['active_to']).' <br> Use Coupon Code: '.$row['coupon_code'].'<br/>'.$row['description'];
					}
				}else if($row['discount_type'] == 'percentage'){
					if($row['discount'] > $per){
						$per = $row['discount'];
						$title_per = 'Discounts Upto '.$amt.'%'.' Valid Upto '. date('d M',$row['active_to']) .' <br> Use Coupon Code: '.$row['coupon_code'].'<br/>'.$row['description'];
					}
				}
			}
		}



		if($per == 0 && $amt == 0){
			if(!$dontCheckDate && !$includeExpired){
				return $this->findBestCoupon($condition,true,false);
			}else if($dontCheckDate && !$includeExpired){
				return $this->findBestCoupon($condition,true,true);
			}
		}


		if($per == 0){
			return $title_amt;
		}else if($amt == 0){
			return $title_per;
		}else{
			if($per > 20){
				return $title_per;
			}else{
				return $title_amt;
			}
		}
	}
	public function findCoupons($condition = array()){
		if(!isset($condition['website'])){
			$condition['website'] = $this->getCode();
		}
		$website = $condition['website'];
		$today = time();
		$category = new Category();
		$store_cats = $category->getStoreCategory();

		require_once 'model/CouponActive.php';
		$active = new CouponActive();
		$data = $active->query('select * from coupon_active where active_to >= UNIX_TIMESTAMP(NOW()) and website = "'.$website.'" order by id desc');
		$num_rows=mysql_num_rows($data);
		if($num_rows==0)
		{
			$data = $active->query('select * from coupon_active where active_to ="" and website = "'.$website.'" order by id desc limit 0,1');
		}
		$data = $active->getData($data);

		$data2 = array();
		foreach($data as $row){
			$row['categories'] = '';
			$cats = $row['category'];
			$cats = explode(',',$cats);
			foreach($cats as $cat){
				if(isset($store_cats[$cat])){
					$name = $store_cats[$cat];
					if(is_array($name)){
						$name = key($name);
					}
					$row['categories'] .= $name.', ';
				}
			}
			if(!empty($row['categories'])){
				$row['categories'] = substr($row['categories'],0,-2);
			}
			if($row['active_from'] != 0){
				$row['active_from'] = date('d M',$row['active_from']);
			}
			if($row['active_to'] != 0){
				$row['active_to'] = date('d M',$row['active_to']);
			}
			$data2[] = $row;
		}
		return $data2;
	}
	public function findExactMatchCoupon($coupons,$product){
		$category = $product['category'];
		$name = $product['name'];
		$website = $product['website'];
		$price = $product['disc_price'];
		$name = $product['name'];

		foreach($coupons as $c){
			$coupon_cat = $c['category'];
			$coupon_cat = explode(',',$coupon_cat);
			if(in_array($category,$coupon_cat)){
				if(strcasecmp($c['website'],$website) == 0){
					if(empty($c['active_to']) || time() <= $c['active_to']){
						$min = 0;
						if(!empty($c['min_amt'])){
							$min = $c['min_amt'];
						}

						if($price > $min){
							if(!empty($c['product'])){
								if($this->matchProductName($c['product'], $name)){
									return $c;
								}
							}else{
								return $c;
							}
						}
					}
				}
			}
		}
	}
	function matchProductName($main,$sec){
		$main = explode(' ',$main);
		foreach($main as $m){
			if(strpos($m,'-') !== false){
				$m1 = $m;
				$m = array($m1,str_replace('-',' ',$m1),str_replace('-','',$m1));
			}
			$found = false;
			if(is_array($m)){

				$subf = false;
				foreach($m as $mm){
					if(strpos($sec,$mm) !== false){
						$subf = true;
						break;
					}
				}
				$found = $subf;

			}else{
				if(strpos($sec,$m) !== false){
					$found = true;
				}
			}
			if(!$found){
				return false;
			}
		}
		return true;
	}
}