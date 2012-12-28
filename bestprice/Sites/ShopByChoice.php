<?php
class ShopByChoice extends Parsing{
	public $_code = 'ShopByChoice';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA);
	}

	public function getWebsiteUrl(){
		return 'http://www.shopbychoice.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		$query = urldecode($query);
		$query = trim(preg_replace("![^0-9a-z]+!i", "-", $query));
		if($category == Category::MOBILE){
			return "http://www.shopbychoice.com/search/result+category-smartphones+searchtext-$query";
		}else if($category == Category::CAMERA){
			
			if($subcat == Category::NOT_SURE){
				return "http://www.shopbychoice.com/search/result+category-compact-cameras+searchtext-$query"; //digital
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.shopbychoice.com/search/result+category-compact-cameras+searchtext-$query"; //digital
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.shopbychoice.com/search/result+category-dslr+searchtext-$query"; //dslr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.shopbychoice.com/search/result+category-camcorders+searchtext-sony-$query"; //cam
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.shopbychoice.com/search/result+category-compact-cameras+searchtext-$query"; //digital
			}else{
				return '';
			}
		}
		return "http://www.shopbychoice.com/search/result+searchtext-".$query;
	}
	public function getLogo(){
		return 'http://www.shopbychoice.com/images/logo.png';
	}
	public function getData($html,$query,$category,$subcat=false){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.search-sec-main-right-sec')) > 0){
			//http://images.seventymm.com/Img/Item/ItemRegular/43262.jpg
			foreach(pq('.search-sec-main-right-sec') as $div){
				$image = pq($div)->find('.img-sec-second:first')->children('figure')->children('a')->children('span');
				$url = pq($div)->find('.img-sec-second:first')->children('figure')->children('a')->attr('href');
				$name = pq($div)->find('.prd-desc')->children('h3')->children('a')->html();
				$disc_price = pq($div)->children('.search-sec-main-right-sec-right')->children('small')->children('strong')->html();
				$offer = '';
				$shipping = pq($div)->find('.prd-desc')->children('em')->children('strong')->html();
				if(!empty($shipping) && $shipping[strlen($shipping)-1] == ')'){
					$shipping = substr($shipping, 0,-1);
				}
				$stock = 0;
				if(pq($div)->find('.prd-desc')->children('em')->children('b')->html() != 'Out Of Stock'){
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