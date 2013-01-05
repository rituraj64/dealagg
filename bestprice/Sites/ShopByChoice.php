<?php
class ShopByChoice extends Parsing{
	public $_code = 'ShopByChoice';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/shopbychoice';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.shopbychoice.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		$query = urldecode($query);
		$query = trim(preg_replace("![^0-9a-z]+!i", "-", $query));
		if($category == Category::MOBILE){
			return "http://www.shopbychoice.com/search/result+category-smartphones+searchtext-$query";
		}else if($category == Category::MOBILE_ACC){
			$query = str_replace(" ", "-", $query);
			if($subcat == Category::NOT_SURE || $subcat == Category::MOB_OTHERS){
				return "http://www.shopbychoice.com/search/result+category-accessories+searchtext-$query";
			}elseif($subcat == Category::MOB_CASES){
				return "http://www.shopbychoice.com/search/result+category-mobile-cases-and-skins+searchtext-$query";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.shopbychoice.com/search/result+category-screen-protectors+searchtext-$query";
			}elseif($subcat == Category::MOB_HEADPHONE){
				return "http://www.shopbychoice.com/search/result+category-earphones+searchtext-$query";
			}elseif($subcat == Category::MOB_HEADSETS){
				return "http://www.shopbychoice.com/search/result+category-bluetooth+searchtext-$query";
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://www.shopbychoice.com/search/result+category-micro-memory-cards+searchtext-$query";
			}else return "";
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
		}elseif ($category == Category::COMP_COMPUTER){
			return "http://www.shopbychoice.com/search/result+category-desktops+searchtext-$query";
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://www.shopbychoice.com/search/result+searchtext-$query+category-laptops";
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