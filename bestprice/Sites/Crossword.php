<?php
class Crossword extends Parsing{
	public $_code = 'Crossword';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.crossword.in/';
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/bestprice/img/crossword.png';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://www.crossword.in/books/search?q=$query";
		}
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('ul#search-result-items')->children('li') as $div){
			$image = pq($div)->find('.variant-image')->find('a')->html();
			$url = pq($div)->find('.variant-image')->find('a')->attr('href');
			$name = pq($div)->find('.variant-title')->html();
			$author = pq($div)->find('.contributors')->find('.ctbr-name')->html();
			$disc_price = pq($div)->find('.variant-final-price')->html();
			$shipping = pq($div)->find('.ships-in')->html();
			$offer = '';
			$stock = 0;
			if(sizeof(pq($div)->find('.in-stock'))){
				$stock = 1;
			}else{
				$stock = -1;
			}
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
					'cat' => Category::BOOKS
			);
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
		$data2 = $this->cleanData($data2,$query);
		$data2 = $this->bestMatchData($data2,$query,$category);
		return $data2;
	}
}