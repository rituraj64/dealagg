<?php
class CostPrize extends Parsing{
	public $_code = 'CostPrize';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::TABLETS,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.costprize.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
		}
		return "http://www.costprize.com/search_results.php?search_str=$query";
	}
	public function getLogo(){
		return 'http://www.costprize.com/images/costprize_small.png';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.productgroup')) > 0){
			foreach(pq('.productgroup') as $div){
				$image = pq($div)->children('.image:first')->children('a')->html();
				$url = pq($div)->children('.image:first')->children('a')->attr('href');
				$name = pq($div)->children('.productname:first')->children('h1')->html();
				$disc_price = pq($div)->children('.price:first')->children('h1')->html();
				$offer = '';
				if(pq($div)->children('.cash_reward:first')){
					$offer = pq($div)->children('.cash_reward:first')->find('.grid:first')->html();
				}
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->find('.add_to_cart_form'))){
					$stock = 1;
				}else{
					$stock = -1;
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
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}