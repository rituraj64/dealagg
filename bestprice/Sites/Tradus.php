<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/tradus';
	}
	public function isTrusted($category){
		if($category == Category::BOOKS){
			return false;
		}
		return true;
	}
	public function getAllowedCategory(){
		return array(Category::GAMING,Category::TABLETS,Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::MOBILE,Category::MOBILE_ACC,Category::COMP_LAPTOP);
	}

	public function getWebsiteUrl(){
		return 'http://www.tradus.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.tradus.com/search?query=$query&cat=357";
		}else if($category == Category::MOBILE){
			return "http://www.tradus.com/search?query=$query&cat=7844";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.tradus.com/search?query=$query&cat=10465";
			if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "http://www.tradus.com/search?query=$query&cat=10465";
			}elseif ($subcat == Category::MOB_BATTERY){
				return "http://www.tradus.com/search?query=$query&cat=10469";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://www.tradus.com/search?query=$query&cat=10477";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.tradus.com/search?query=$query&cat=10472";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://www.tradus.com/search?query=$query&cat=10473";
			}elseif ($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://www.tradus.com/search?query=$query&cat=10476";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.tradus.com/search?query=$query&cat=10480";
			}elseif ($subcat == Category::MOB_CAR_ACC){
				return "http://www.tradus.com/search?query=$query&cat=10471";
			}elseif ($subcat == Category::MOB_CABLE){
				return "http://www.tradus.com/search?query=$query&cat=10470";
			}elseif($subcat == Category::MOB_SPEAKER){
				return "http://www.tradus.com/search?query=$query&cat=10483";
			}else return "http://www.tradus.com/search?query=$query&cat=10465";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.tradus.com/search?query=$query&cat=10305";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.tradus.com/search?query=$query&cat=7668";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.tradus.com/search?query=$query&cat=7670";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.tradus.com/search?query=$query&cat=7671";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.tradus.com/search?query=$query&cat=7668";
			}else{
				return "http://www.tradus.com/search?query=$query&cat=10305";
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.tradus.com/search?query=$query&cat=7667"; // acc
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.tradus.com/search?query=$query&cat=8106"; // acc
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.tradus.com/search?query=$query&cat=8099"; // acc
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.tradus.com/search?query=$query&cat=8106"; // acc
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.tradus.com/search?query=$query&cat=8104"; // acc
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.tradus.com/search?query=$query&cat=8101"; // filters
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.tradus.com/search?query=$query&cat=8108"; // lens
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.tradus.com/search?query=$query&cat=8100"; // lens
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.tradus.com/search?query=$query&cat=7667"; // acc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.tradus.com/search?query=$query&cat=7667"; // acc
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.tradus.com/search?query=$query&cat=8102"; // lens
			}else{
				return "http://www.tradus.com/search?query=$query&cat=7667"; // acc
			}
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://www.tradus.com/search?query=$query&availability=true&cat=7689";
		}elseif($category == Category::TABLETS){
			return "http://www.tradus.com/search?query=$query&availability=true&cat=7762";
		}elseif($category == Category::GAMING){
			if ($subcat == Category::GAMING_ACC_CONSOLES){
				return "http://www.tradus.com/search?query=$query&availability=true&cat=10417";
			}elseif($subcat == Category::GAMING_ACC_ACC){
				return "http://www.tradus.com/search?query=$query&availability=true&cat=7708";
			}elseif ($subcat == Category::GAMING_ACC_GAMES){
				return "http://www.tradus.com/search?query=$query&availability=true&cat=7710";
			}else{
				return "http://www.tradus.com/search?query=$query&availability=true&cat=7707";
			}
		}else{
			return "http://www.tradus.com/search?query=".$query;
		}
	}
	public function getLogo(){
		return "http://www.tradus.com/sites/all/themes/basic/images/ci_images/tradus_logo/tradus_new_logo.jpg";
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		$ele = pq('#search-result-main-heading')->children('h1');
		if(sizeof($ele)){
			$html = $ele->html();
			if(strpos($html, 'Zero items found') !== false){
				return $data;
			}
		}
		foreach(pq('div.prod_main_div') as $div){
			if(sizeof(pq($div)->find('.product_image'))){
				$image = pq($div)->find('.product_image')->children()->html();
				$url = pq($div)->find('.product_image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_name')->find('a')->html());
				$disc_price = pq($div)->find('.prod_price_3')->find('.numDiv_left')->html();
				$shipping = '';
				$cat = '';
				$stock = 0;
				if(pq($div)->find('.prod_price_3')->find('.numDiv_right')->html() == 'Sold Out'){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$offer = '';
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
			$row['image']= pq('img')->attr('data-original');
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
	public function hasProductdata(){
		return false;//most information is ajax based, and no offers mostly
	}
	public function getProductData($html,$price,$stock){
		return false;
		phpQuery::newDocumentHTML($html);
		$price = pq('#whole-sale-price')->html();
		$offer = pq('.tradus-special-offer-midpart')->html();
		//this is javascript based
		$stock = 0;
		$shipping_cost = '';//pq('.blogdistDiv:first')->find('.priceDiv')->find('.fiLt')->html();;
		$shipping_time = '';//pq('.blogdistDiv:first')->find('.optionDiv')->html();;

		$attr = array();
		$cat = '';
		foreach(pq('#breadcrump')->find('a') as $li){
			$cat .= pq($li)->children('span')->html().',';
		}

		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => '',
				'cat' => $cat
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}