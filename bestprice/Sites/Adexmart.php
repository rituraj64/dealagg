<?php
class Adexmart extends Parsing{
	public $_code = 'Adexmart';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://adexmart.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://adexmart.com/search?search_query=$query&n=10&orderby=position&orderway=desc&submit_search=Search";
	}
	public function getLogo(){
		return "http://adexmart.com/img/logo.jpg";
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul#product_list')->children('li')) > 0){
			foreach(pq('ul#product_list')->children('li') as $div){
				$image = pq($div)->find('.product_img_link')->html();
				$url = pq($div)->find('.product_img_link')->attr('href');
				$name = pq($div)->children('div.center_block')->children('h3')->children('a')->html();
				$disc_price = pq($div)->find('.price')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				$s = pq($div)->find('.availability')->html();
				if(strpos( strtolower($s), 'out of stock') !== false){
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