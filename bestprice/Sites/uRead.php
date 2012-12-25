<?php
class uRead extends Parsing{
	public $_code = 'uRead';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.uread.com/';
	}
	public function getSearchURL($query,$category = false){
		$q = urldecode($query);
		$q = str_replace(" ", '-', $q);
		$q = urlencode($q);
		return "http://www.uread.com/search-books/".$q;
	}
	public function getLogo(){
		return "http://www.uread.com/images/logos/logo.gif";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.product-vert-list-item'))){
			foreach(pq('div.product-vert-list-item') as $div){
				if(sizeof(pq($div)->find('.product-vert-list-image'))){
					$image = pq($div)->find('.product-vert-list-image')->children('a')->html();
					$url = pq($div)->find('.product-vert-list-image')->children('a')->attr('href');
					$name = pq($div)->find('.product-vert-list-summary')->children('.product-vert-list-title')->children('h2')->html();
					$disc_price = pq($div)->find('.product-vert-list-summary')->find('.product-vert-list-price')->children('.our-price')->html();
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
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}