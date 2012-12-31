<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';
	public function isTrusted($category){
		return true;
	}
	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::CAMERA,Category::CAMERA_ACC,Category::MOBILE,Category::MOBILE_ACC);
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
			return "http://www.tradus.com/search?query=$query&cat=10465";
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
				return '';
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
				return ""; //acc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return '';
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.tradus.com/search?query=$query&cat=8102"; // lens
			}else{
				return '';
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
}