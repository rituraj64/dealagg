<?php
class Letshop extends Parsing{
	public $_code = 'Letsshop';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://letsshop.in/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://letsshop.in/catalogsearch/result/?q=$query&cat=4";
		}else if($category == Category::MOBILE_ACC){
			return "http://letsshop.in/catalogsearch/result/?q=$query&cat=12";
		}else if($category == Category::CAMERA){
			return "http://letsshop.in/catalogsearch/result/?q=$query&cat=27";
		}else if($category == Category::CAMERA_ACC){
			return "http://letsshop.in/catalogsearch/result/?q=$query&cat=34";
		}
		return "http://letsshop.in/catalogsearch/result/?q=$query";
	}
	public function getLogo(){
		return 'http://letsshop.in/media/images/default/letsshop_1_1.png';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.products-grid')) > 0){
			foreach(pq('ul.products-grid')->children('li') as $div){
				$image = pq($div)->children('a:first')->html();
				$url = pq($div)->children('a:first')->attr('href');
				$name = pq($div)->children('.product-name')->children('a')->html();
				if(sizeof(pq($div)->children('.price-box')->children('.special-price'))){
					$disc_price = pq($div)->children('.price-box')->children('.special-price')->children('.price')->html();
				}else{
					$disc_price = pq($div)->children('.price-box')->children('.regular-price')->children('.price')->html();
				}
				$offer = '';
				$shipping = '';
				$stock = 0;
				$html = pq($div)->children('p.availability')->html();
				$html = strip_tags($html);
				if(strpos($html, 'Out of stock') !== false){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$author = '';
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
						'cat' => ''
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