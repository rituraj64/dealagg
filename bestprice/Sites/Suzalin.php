<?php
class Suzalin extends Parsing{
	public $_code = 'Suzalin';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/SuzalinOnlineShopping';
	}
	public function getAllowedCategory(){
		return array(Category::TABLETS,Category::MOBILE,Category::CAMERA,Category::COMP_LAPTOP);
	}

	public function getWebsiteUrl(){
		return 'http://www.suzalin.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.suzalin.com/Search/1_2_$query";
		}else if($category == Category::CAMERA){
			return "http://www.suzalin.com/Search/1_7_$query";
		}elseif($category == Category::COMP_LAPTOP){
			return "http://www.suzalin.com/Search/1_3_$query";
		}elseif ($category == Category::TABLETS){
			return "http://www.suzalin.com/Search/1_4_$query";
		}
		return "http://www.suzalin.com/Search/1_0_$query";
	}
	public function getLogo(){
		return 'http://www.suzalin.com/images/suzalin-logo.gif';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.productData')) > 0){
			foreach(pq('ul.productData') as $div){
				foreach(pq($div)->find('li') as $div){
					$image = pq($div)->children('.productWidget')->children('.productWidgetImage')->children('a')->html();
					$url = pq($div)->children('.productWidget')->children('.productWidgetImage')->children('a')->attr('href');
					$name = pq($div)->children('.productWidget')->children('.productWidgetTitle')->children('a')->html();
					$disc_price = pq($div)->children('.productWidget')->children('.productWidgetPriceContainer')->children('.ourPrice')->html();
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
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}