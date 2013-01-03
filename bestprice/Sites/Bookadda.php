<?php
class Bookadda extends Parsing{
	public $_code = 'Bookadda';

	public function getFacebookUrl(){
		return 'http://www.facebook.com/bookadda';
	}
	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.bookadda.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		$q = urldecode($query);
		$q = str_replace(" ", '+', $q);
		$q = urlencode($q);
		return "http://www.bookadda.com/general-search?searchkey=".$q;
	}
	public function getLogo(){
		return "http://static.bookadda.com/common/bookadda/images/bookadda_logo.jpg";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.results')->find('li'))){
			foreach(pq('ul.results')->find('li') as $div){
				if(sizeof(pq($div)->find('.frame'))){
					$image = pq($div)->find('.frame')->children('a')->html();
					$url = pq($div)->find('.frame')->children('a')->attr('href');
					$name = pq($div)->find('.details')->children('div:first')->find('h4')->html();
					$disc_price = pq($div)->find('.details')->find('.secondrow')->find('.new_price')->html();
					$shipping = '';
					foreach(pq($div)->find('.details')->find('.secondrow')->find('.price')->find('strong') as $strong){
						$html = pq($strong)->html();
						if(strpos($html, 'business days') !== false){
							$shipping = $html;
							break;
						}
					}
					$offer = '' ;
					$stock = 0;
					if( strpos(strtolower($shipping), 'out of stock') !== false ){
						$stock = -1;
					}else{
						$stock = 1;
					}
					$cat ='';
					$author = pq($div)->find('.details')->children('div:first')->find('.prodAuthor')->html();
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