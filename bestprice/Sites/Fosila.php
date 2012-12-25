<?php
class Fosila extends Parsing{
	public $_code = 'Fosila';

	public function getAllowedCategory(){
		return array(Category::MOBILE);
	}

	public function getWebsiteUrl(){
		return 'http://www.fosila.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.fosila.com/mobiles?search=".$query;
		}
		return "http://www.fosila.com/all?key=".$query;;
	}
	public function getLogo(){
		return 'http://www.fosila.com/assets/fosila_logo-4cf0c01116ac6c3dab120d73e5e97cb5.jpg';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.product_info')) > 0){
			foreach(pq('ul.product_info') as $ul){
				foreach(pq($ul)->children('li') as $div){
					$image = pq($div)->children('.product_img')->html();
					$url = pq($div)->children('.product_img')->attr('href');
					$name = pq($div)->children('.procuct_info_name')->html();
					$disc_price = pq($div)->children('.procuct_info_price')->children('.our_cost')->html();
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