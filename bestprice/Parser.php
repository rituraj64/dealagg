<?php
class Parser{

	public function getHtml($url){
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		//fetch a random list of user agents here instead of 1.
		$target_url = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$target_url);
		//curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		$html = curl_exec($ch);
		if (!$html || strpos($html, '<body') === false) {
			$a = @simplexml_load_string($html);
			if($a===FALSE) {
				$zoomin = new Zoomin();
				$a = $zoomin->jsonp_decode($html,true);
				if(!is_array($a)){
					$a = json_decode($html,true);
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
		curl_close($ch);
		return $html;
	}
}