<?php
class Justbooks extends Parsing{
	public $_code = 'Justbooks';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://justbooks.in/';
	}
	public function getSearchURL($query,$category = false){
		return "http://justbooks.in/search/node/".$query;
	}
	public function getLogo(){
		return "http://justbooks.in/sites/all/themes/justbooks/logo.png";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.jb-cat-des'))){
			foreach(pq('.jb-cat-des') as $div){
				$image = pq($div)->find('.jb-cat-des-img')->children('a')->html();
				$url = pq($div)->find('.jb-cat-des-img')->children('a')->attr('href');
				$name = pq($div)->find('.jb-cat-des-text')->find('li:first')->find('strong')->html();
				$disc_price = pq($div)->find('.jb-cat-des-text')->find('.jb-bookprice')->html();
				$shipping = '';
				$offer = '' ;
				$stock = 0;
				$s = pq($div)->find('.jb-stock')->html();
				if( strpos(strtolower($s), 'out of stock') !== false ){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$cat ='';
				$author = pq($div)->find('span.jb-bookauthor')->children('a')->html();
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