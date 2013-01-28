<?php
class TheMobileStore extends Parsing{
	public $_code = 'TheMobileStore';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/themobilestorebd';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::TABLETS,Category::MOBILE_ACC);
	}
	public function getWebsiteUrl(){
		return 'http://www.themobilestore.in';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.themobilestore.in/home-mobiles-&-tablet/search?q=".$query;
		}else if($category == Category::MOBILE_ACC){
			if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "http://www.themobilestore.in/home-accessories/search?q=".$query;
			}elseif($subcat == Category::MOB_MEMORY){
				return "http://www.themobilestore.in/home-accessories-memory-card/search?q=$query";
			}elseif($subcat == Category::MOB_BATTERY){
				return "http://www.themobilestore.in/home-accessories-battery/search?q=$query";
			}elseif($subcat == Category::MOB_CHARGER){
				return "http://www.themobilestore.in/home-accessories-charger/search?q=$query";
			}elseif($subcat == Category::MOB_HEADSETS){
				return "http://www.themobilestore.in/home-accessories-bluetooth/search?q=$query";
			}elseif($subcat == Category::MOB_CAR_ACC){
				return "http://www.themobilestore.in/home-accessories-car-gadgets/search?q=$query";
			}elseif($subcat == Category::MOB_CASES){
				return "http://www.themobilestore.in/home-accessories-cover/search?q=$query";
			}elseif($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://www.themobilestore.in/home-accessories-handsfree-or-headphones/search?q=$query";
			}elseif($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.themobilestore.in/home-accessories-screen-guard/search?q=$query";
			}elseif($subcat == Category::MOB_CABLE){
				return "http://www.themobilestore.in/home-accessories-cables/search?q=$query";
			}else return "";
		}else if($category == Category::TABLETS){
			return "http://www.themobilestore.in/home-mobiles-&-tablet-tablet/search?q=".$query;
		}
		return "http://www.themobilestore.in/home/search?q=".$query;
	}
	public function getLogo(){
		return "http://a02-tata.buildabazaar.com/img/lookandfeel/31103/2e19ed541909556e27f03_999x350x.png.999xx.png";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('ul#search-result-items')->children('li') as $div){
			if(sizeof(pq($div)->children('.variant-image'))){
				$image = pq($div)->children('.variant-image')->children('a')->html();
				$url = pq($div)->children('.variant-image')->children('a')->attr('href');
				$name = strip_tags(pq($div)->children('.variant-desc')->children('.variant-title')->children('a')->html());
				if(sizeof(pq($div)->children('.variant-desc')->children('.price')->children('.variant-final-price'))){
					$disc_price = pq($div)->children('.variant-desc')->children('.price')->children('.variant-final-price')->html();
				}else{
					$disc_price = pq($div)->children('.variant-desc')->children('.price')->children('.variant-list-price')->html();					
				}
				$shipping = '';
				$offer = '' ;
				$stock = 0;
				$h = pq($div)->children('.variant-desc')->children('.buy-now')->html();
				if(strpos(strtolower($h), 'out of stock') !== false){
					$stock = -1;
				}else{
					$stock = 1;
				}
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