<?php
class ezeekart extends Parsing{
	
	public $_code = 'ezeekart';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/ezeekart';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC);
	}
	public function getWebsiteUrl(){
		return 'http://www.ezeekart.com';
	}
	public function getPostFields($query,$category = false,$subcat=false){
		return array('search_word'=>'samsung','act'=>'search');
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://www.ezeekart.com/search_result.php";
	}
	public function getLogo(){
		return "http://www.ezeekart.com/theme/bgrtheme/logo.jpg";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(pq('.head_product_price')){
			foreach(pq('.head_product_price') as $div){
				$image = pq($div)->children('.product_image')->find('a:first')->html();
				$url = pq($div)->children('.product_image')->find('a:first')->attr('href');
				$name = pq($div)->children('.product_heading')->children('a')->html();
				$disc_price = pq($div)->children('.price_gap')->children('.price')->html();
				$shipping = '';
				$offer = '' ;
				$stock = 0;
				$cat ='';
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