<?php
class Parser{
	const SITE_URL = 'http://pricegenie.in/';
	const AJAX_URL = 'http://site.pricegenie.in/';

	//const SITE_URL = 'http://localhost/scrapping/bestprice/';
	//const AJAX_URL = 'http://localhost/scrapping/bestprice/';


	public function getHtml($url,$fields = array(),$headersOnly = false){
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		//fetch a random list of user agents here instead of 1.
		$target_url = $url;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$target_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

		if(!empty($fields)){
			$fields_string = '';
			foreach($fields as $key=>$value) {
				$fields_string .= $key.'='.$value.'&';
			}
			rtrim($fields_string, '&');
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		}

		if(strpos($url, 'uread.com') !== false){
			$cookie_file = "uread.txt";
		}else{
			$cookie_file = "cookie1.txt";
		}
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

		$strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';
		session_write_close();
		curl_setopt( $ch, CURLOPT_COOKIE, $strCookie );

		$html = curl_exec($ch);

		if (!$html || strpos($html, '<body') === false) {
			if(strpos($url, 'buytheprice.com') !== false || strpos($url, 'rediff.com') !== false){
			}else{
				$a = @simplexml_load_string($html);
				if($a===FALSE) {
					require_once 'Sites/Zoomin.php';
					$zoomin = new Zoomin();
					$a = $zoomin->jsonp_decode($html,true);
					if(!is_array($a)){
						$a = json_decode(trim($html),true);
						if(!is_array($a)){
							$msg = "<br />cURL error number:" .curl_errno($ch);
							$msg .= "<br />cURL error:" . curl_error($ch);
							$msg .=  "<br>".$url;
							$msg .=  "<br>".$html;
							throw new Exception($msg);
						}
					}
				}
			}
		}
		curl_close($ch);
		return $html;
	}
}