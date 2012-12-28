<?php
class Indiaplaza extends Parsing{
	public $_code = 'Indiaplaza';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.indiaplaza.com';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.indiaplaza.com/searchproducts.aspx?sn=books&q=".$query;
		}
	}
	public function getLogo(){
		return "http://images.indiaplaza.com/indiaplazaimages/logo.png";
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('table#ContentPlaceHolder1_repBrowseLst'))){
			foreach(pq('table#ContentPlaceHolder1_repBrowseLst')->find('tr') as $div){
				if(sizeof(pq($div)->find('.skuRow'))){
					$div = pq($div)->children('.skuRow');
					$image = pq($div)->find('.skuImg')->children('a')->html();
					$url = pq($div)->find('.skuImg')->children('a')->attr('href');
					$name = pq($div)->find('.skuName')->children('a:first')->html();
					$disc_price = pq($div)->find('.ourPrice')->html();
					$shipping = pq($div)->find('.fdpNormShip')->html();
					$offer = '' ;
					$stock = 0;
					$cat ='';
					$author = pq($div)->find('.skuName')->children('a:last')->html();
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
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$img = pq('img')->attr('data-href');
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
}