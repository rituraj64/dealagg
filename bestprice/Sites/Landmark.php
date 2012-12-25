<?php
class Landmark extends Parsing{
	public $_code = 'Landmark';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::BOOKS,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.landmarkonthenet.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://www.landmarkonthenet.com/books/search/?q=".$query;
		}else if($category == Category::MOBILE_ACC){
			return "http://www.landmarkonthenet.com/mobile-accessories/search/?q=".$query;
		}else if($category == Category::MOBILE){
			return "http://www.landmarkonthenet.com/mobiles/search/?q=".$query;
		}
		return "http://www.landmarkonthenet.com/search/?q=".$query;
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/bestprice/img/landmark.png';
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		
		$html = pq('#page-content')->children('h1')->html();
		if(strpos($html, 'Sorry, no results were found for') !== false){
			return $data;
		}
		
		foreach(pq('div.searchresult') as $div){
			if(sizeof(pq($div)->find('.image'))){
				$image = pq($div)->find('.image')->find('a')->html();
				$url = pq($div)->find('.image')->find('a')->attr('href');
				$name = pq($div)->find('.info')->children('h1')->find('a')->html();
				$disc_price = strip_tags(pq($div)->find('.buttons')->find('.prices')->find('.oldprice')->html());
				$offer = '';
				$shipping = pq($div)->find('.stockinfo')->find('.despatch-time')->html() . ' '. pq($div)->find('.stockinfo')->find('.shipping-cost')->html() ;
				$stock = 0;
				if(sizeof(pq($div)->find('.stockinfo')->find('.instock'))){
					$stock = 1;
				}else{
					$stock = -1;
				}
				$author = '';
				if($category == Category::BOOKS){
					$author = pq($div)->find('.info')->children('h2')->find('a')->html();
				}
				$cat ='';
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
				$img = $img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}