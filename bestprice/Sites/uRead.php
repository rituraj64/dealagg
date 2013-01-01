<?php
class uRead extends Parsing{
	public $_code = 'uRead';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}
	public function isTrusted($category){
		return true;
	}
	public function getWebsiteUrl(){
		return 'http://www.uread.com/';
	}
	public function getPostFields($query,$category = false,$subcat=false){
		return array();
		/*
		 $a = array('__EVENTTARGET'=>'ctl00$ddlCurrency',
		 		'__EVENTARGUMENT'=>'',
		 		'__LASTFOCUS'=>'',
		 		'ctl00$hdnAddedMeta'=>'true',
		 		'ctl00$hdnPageSize'=>'',
		 		'ctl00$ddlCurrency'=>'5',
		 		'ctl00$TopSearch1$txtSearch'=>'Search for Book, Author, Publisher or ISBN',
		 		'ctl00$TopSearch1$hdnSearch'=>'',
		 		'select'=>'15',
		 		'select'=>'1',
		 		'ctl00$phBody$SearchResult$SearchFeedback$txtName'=>'',
		 		'ctl00$phBody$SearchResult$SearchFeedback$txtPhone'=>'',
		 		'ctl00$phBody$SearchResult$SearchFeedback$txtEmail'=>'',
		 		'ctl00$phBody$SearchResult$SearchFeedback$txtDescription'=>'',
		 		'ctl00$Footer$txtNameFB'=>'',
		 		'ctl00$Footer$txtPhoneFB'=>'',
		 		'ctl00$Footer$txtEmailFB'=>'',
		 		'ctl00$Footer$txtDescriptionFB'=>'',
		 		'ctl00$Footer$BottomSearch$txtBottomSearch'=>'Search for Book, Author, Publisher or ISBN',
		 		'hiddenInputToUpdateATBuffer_CommonToolkitScripts'=>'1');
		return $a;
		*/
	}
	public function getSearchURL($query,$category = false,$subcat){
		$q = urldecode($query);
		$q = str_replace(" ", '-', $q);
		$q = urlencode($q);
		return "http://www.uread.com/search-books/".$q;
	}
	public function getLogo(){
		return "http://www.uread.com/images/logos/logo.gif";
	}
	private $_exchange = false;
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.product-vert-list-item'))){
			foreach(pq('div.product-vert-list-item') as $div){
				if(sizeof(pq($div)->find('.product-vert-list-image'))){

					if(!$this->_exchange){
						$this->_exchange = $this->getExchange();
					}

					$image = pq($div)->find('.product-vert-list-image')->children('a')->html();
					$url = pq($div)->find('.product-vert-list-image')->children('a')->attr('href');
					$name = pq($div)->find('.product-vert-list-summary')->children('.product-vert-list-title')->children('h2')->html();
					$disc_price = pq($div)->find('.product-vert-list-summary')->children('.product-vert-list-price')->children('.our-price')->html();
					$disc_price = $this->removeAlpha($disc_price,true);
					$disc_price = (int)$disc_price * (int)$this->_exchange;
					$shipping = pq($div)->find('.product-shipping-info')->html();
					$shipping = $this->clearHtml($shipping);
					$offer = '' ;
					$stock = 0;
					if( strpos(strtolower($shipping), 'out of stock') !== false ){
						$stock = -1;
					}else{
						$stock = 1;
					}
					$cat ='';
					$author = pq($div)->find('.product-vert-list-summary')->children('.product-vert-list-title')->find('strong:first')->html();
					$data[] = array(
							'name'=>$name,
							'image'=>$image,
							'disc_price'=>$disc_price,
							'url'=>$url,
							'website'=>$this->getCode(),
							'offer'=>$offer,
							'shipping'=>$shipping,
							'stock'=>$stock,
							'author' => $author,
							'cat' => $cat
					);
				}
			}
		}else{
			if(sizeof(pq('.product-detail'))){
				$image = pq('.product-image')->html();
				$url = '';
				$name = pq('.product-title')->children('h1')->html();
				$disc_price = pq('.product-detail-summary')->find('.our-price')->html();
				$shipping = pq('.additional-info')->html();
				$offer = '' ;
				$stock = 0;
				if( sizeof(pq('.Addtocart')) == 0){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$cat ='';
				$author = pq('.product-detail')->find('.product-title-author')->html();
				$data[] = array(
						'name'=>$name,
						'image'=>$image,
						'disc_price'=>$disc_price,
						'url'=>$url,
						'website'=>$this->getCode(),
						'offer'=>$offer,
						'shipping'=>$shipping,
						'stock'=>$stock,
						'author' => $author,
						'cat' => $cat
				);
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$img = pq('img')->attr('src');
			if(strpos($img, 'http') === false){
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
	public function getExchange(){
		$lines = dirname(__FILE__).'/../uread.txt';
		if(!file_exists($lines)){
			return 1;
		}
		$lines = file($lines);

		// var to hold output
		$trows = '';

		// iterate over lines
		foreach($lines as $line) {

			// we only care for valid cookie def lines
			if($line[0] != '#' && substr_count($line, "\t") == 6) {

				// get tokens in an array
				$tokens = explode("\t", $line);

				// trim the tokens
				$tokens = array_map('trim', $tokens);

				// let's convert the expiration to something readable
				$tokens[4] = date('Y-m-d h:i:s', $tokens[4]);

				// we can do different things with the tokens, here we build a table row
				$trows .= '<tr></td>' . implode('</td><td>', $tokens) . '</td></tr>' . PHP_EOL;

				if($tokens[5] == 'CurrencyFactor'){
					return trim($tokens[6]);
				}

				// another option, make arrays to do things with later,
				// we'd have to define the arrays beforehand to use this
				// $domains[] = $tokens[0];
				// flags[] = $tokens[1];
				// and so on, and so forth

			}

		}
		return 1;
	}
}