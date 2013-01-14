<?php
class ManiacStore extends Parsing{
	
	public $_code = 'ManiacStore';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/maniacstores';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.maniacstore.com';
	}
	
	public function getPostFields($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			$cat_id = 251;
		}else if($category == Category::MOBILE_ACC){
			$cat_id = 252;
			if($subcat == Category::NOT_SURE){
				$cat_id = 252;
			}else if ($subcat == Category::MOB_SCREEN_GUARD){
				$cat_id = 598;
			}elseif ($subcat == Category::MOB_HANDSFREE){
				$cat_id = 254;
			}elseif ($subcat == Category::MOB_HEADSETS){
				$cat_id = 253;
			}elseif ($subcat == Category::MOB_BATTERY){
				$cat_id = 601;
			}elseif ($subcat == Category::MOB_CHARGER){
				$cat_id = 599;
			}elseif ($subcat == Category::MOB_SPEAKER){
				$cat_id = 252;
			}elseif ($subcat == Category::MOB_CABLE){
				$cat_id = 599;
			}elseif ($subcat == Category::MOB_CASES){
				$cat_id = 254;
			}elseif ($subcat == Category::MOB_OTHERS){
				return array();
			}else {
				return array();
			}
		}
		$str = 'simple_search=Y&mode=search&posted_data%5Bcategoryid%5D='.$cat_id.'&posted_data%5Bby_title%5D=Y&posted_data%5Bby_descr%5D=Y&posted_data%5Bby_sku%5D=Y&posted_data%5Bsearch_in_subcategories%5D=Y&posted_data%5Bincluding%5D=all&posted_data%5Bsubstring%5D='.$query;
		$a = array();
		$str = explode('&',$str);
		foreach($str as $s){
			$s = explode('=',$s);
			$a[$s[0]] = $s[1];
		}
		return $a;
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://www.maniacstore.com/search.php?mode=search&page=1";
	}
	public function getLogo(){
		return "http://www.maniacstore.com/skin/common_files/images/logo.jpg";
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.proImg')) > 0){
			foreach(pq('div.proImg') as $div){
				$image = pq($div)->children('a')->html();
				$url = pq($div)->children('a')->attr('href');
				$name = pq($div)->siblings('b:first')->html();
				$disc_price = pq($div)->siblings('span:first')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->siblings('.soldOut'))){
					$stock = -1;
				}else{
					$stock = 1;	
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