<?php
class Royalimages extends Parsing{
	public $_code = 'Royalimages';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.royalimages.in/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.royalimages.in/catalogsearch/result/index/?cat=13&q=$query";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.royalimages.in/catalogsearch/result/index/?cat=15&q=$query";
		}else if($category == Category::CAMERA){
			return "http://www.royalimages.in/catalogsearch/result/index/?cat=32&q=$query";
		}
		return "http://www.royalimages.in/catalogsearch/result/?q=$query";
	}
	public function getLogo(){
		return 'http://www.royalimages.in/skin/frontend/default/royalimages/images/Royalimages.jpg';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.products-grid')) > 0){
			foreach(pq('ul.products-grid') as $div){
				foreach(pq($div)->children('li.item') as $div){
					$image = pq($div)->children('a:first')->html();
					$url = pq($div)->children('a:first')->attr('href');
					$name = pq($div)->children('.product-name')->children('a')->html();
					$disc_price = pq($div)->children('.info')->children('.price-box')->find('.price')->html();
					$offer = '';
					$shipping = '';
					$stock = 0;
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