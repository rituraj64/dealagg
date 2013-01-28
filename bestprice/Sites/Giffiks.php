<?php
class Giffiks extends Parsing{

	public $_code = 'Giffiks';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/GIFFIKS';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC,Category::CAMERA_ACC,Category::BOOKS,Category::COMP_LAPTOP,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://www.giffiks.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::MOBILE || $category == Category::MOBILE_ACC || $category == Category::TABLETS){
			//return "http://www.giffiks.com/search.php?category=mobile&search=$query&go=";
			return "http://www.giffiks.com/search.php?category=all&search=$query&go=";
			//changed by Vikas
		}else if($category == Category::CAMERA || $category == Category::CAMERA_ACC){
			return "http://www.giffiks.com/search.php?category=camera&search=sd&go=";
		}else if($category == Category::BOOKS){
			return "http://www.giffiks.com/search.php?category=books&search=$query&go=";
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://www.giffiks.com/search?category=laptop&search=$query&go=";
		}
		return "http://www.giffiks.com/search.php?search=$query&go=";
	}
	public function getLogo(){
		return 'http://www.giffiks.com/images/logo.jpg';
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.product_box_new')) > 0){
			foreach(pq('.product_box_new') as $div){
				if(sizeof(pq($div)->children('.product_img')->children('a.book_name')) <= 0){
					$image = pq($div)->children('.product_img')->children('.img_data')->find('.image_size2:first')->html();
					$url =  pq($div)->children('.product_img')->children('.data')->children('a:first')->attr('href');
					$name = pq($div)->children('.product_img')->children('.data')->children('a:first')->children('span:first')->html();
					$disc_price = pq($div)->children('.product_img')->children('.data')->children('.product_price')->html();
					$author = '';
				}else{
					$image = pq($div)->children('.product_img')->children('a:first')->html();
					$url = pq($div)->children('.product_img')->children('a:first')->attr('href');
					$name = pq($div)->children('.product_img')->children('a.book_name')->html();
					$disc_price = pq($div)->children('.product_img')->children('.product_price')->html();
					$author = pq($div)->children('.product_img')->children('.normal_pro_display')->html();
				}
				$offer = '';
				$shipping = '';
				$stock = 0;
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