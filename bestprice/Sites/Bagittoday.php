<?php
class Bagittoday extends Parsing{
	public $_code = 'Bagittoday';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::TABLETS,Category::MOBILE_ACC,Category::CAMERA);
	}

	public function getWebsiteUrl(){
		return 'http://www.bagittoday.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://www.bagittoday.com/searchForProductsFromWeb.htm?param=searchForProducts&searchStr=$query";
	}
	public function getLogo(){
		return 'http://images.bagittoday.intoday.in/images/itbc/eventv1/images/logo.jpg';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.productBox')) > 0){
			foreach(pq('.productBox') as $div){
				$image = pq($div)->children('div:first')->children('a')->html();
				$url = pq($div)->children('div:first')->children('a')->attr('href');
				$name = pq($div)->children('.pText:first')->html();
				pq($div)->children('.pPrice')->children('span:first')->html('');
				$disc_price = pq($div)->children('.pPrice')->html();
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