<?php
class Indianbooks extends Parsing{
	public $_code = 'Indianbooks';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.indianbooks.co.in/';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.indianbooks.co.in/bookmart/?subcats=Y&status=A&pshort=Y&pfull=Y&pname=Y&pkeywords=Y&search_performed=Y&q=$query&dispatch=products.search";
	}
	public function getLogo(){
		return "http://www.indianbooks.co.in/bookmart/skins/basic/customer/images/indianbooks3.gif";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.product-container'))){
			foreach(pq('.product-container') as $div){
				$image = pq($div)->find('.product-item-image')->find('a')->html();
				$url = pq($div)->find('.product-item-image')->find('a')->attr('href');
				$name = pq($div)->find('.product-info')->children('a:first')->html();
				$disc_price = pq($div)->find('.product-info')->children('.prod-info')->children('.prices-container')->find('.price-update')->html();
				$shipping = '';
				$offer = '' ;
				$stock = 0;
				$cat ='';
				$author = pq($div)->find('.product-info')->children('.prod-info')->children('.product-descr')->children('p')->html();
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
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}