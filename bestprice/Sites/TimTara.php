<?php
class TimTara extends Parsing{
	public $_code = 'TimTara';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/timtara';
	}
	public function isTrusted($category){
		return true;
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.timtara.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.timtara.com/search.php?catLevel=0&category[]=1021&category[]=1022&search_query=$query&x=0&y=0";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1023&category[]=1025&category[]=1027&category[]=1028&category[]=1029";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1064"; //all
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1066"; //digital camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1067"; //digital slr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1068"; //video camer
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1982";
			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1069";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1071";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1427";
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1071";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1865";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1939";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1073";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=107o";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return ""; //acc
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return '';
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.timtara.com/search.php?catLevel=1&search_query=$query&x=0&y=0&category[]=1072";
			}else{
				return '';
			}
		}elseif ($category == Category::COMP_COMPUTER || $category == Category::COMP_LAPTOP){
			return "http://www.timtara.com/search.php?catLevel=0&category[]=1001&category[]=1001&category[]=1002&category[]=1003&category[]=1004&category[]=1005&category[]=1006&category[]=1007&category[]=1008&category[]=1009&category[]=1010&category[]=1011&category[]=1012&category[]=1013&category[]=1014&category[]=1015&category[]=1016&category[]=1017&category[]=1018&category[]=1019&category[]=1397&category[]=1403&category[]=1405&category[]=1407&category[]=1409&category[]=1411&category[]=1413&category[]=1415&category[]=1417&category[]=1419&category[]=1431&category[]=1433&category[]=1947&category[]=1949&category[]=1951&category[]=1953&category[]=1955&category[]=1957&category[]=1959&category[]=1961&category[]=1963&category[]=1965&category[]=1967&search_query=$query&x=0&y=0";
		}
		return "http://www.timtara.com/search.php?catLevel=0&category[]=&search_query=$query&x=0&y=0";
	}
	public function getLogo(){
		return 'http://image1.timtara.com/product_images/logo.jpg';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);

		if(sizeof(pq('ul.ProductList')) > 0){
			foreach(pq('ul.ProductList')->children('li') as $div){
				$image = pq($div)->children('.ProductImage')->children('a')->html();
				$url = pq($div)->children('.ProductImage')->children('a')->attr('href');
				$name = pq($div)->children('.ProductDetails')->children('strong')->children('a')->html();
				$disc_price = pq($div)->children('.timtaraprice')->children('b')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				if(sizeof(pq($div)->children('.sohwHideProductAddTextnone'))){
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
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
	public function getProductData($html,$price,$stock){
		phpQuery::newDocumentHTML($html);
		$price = pq('.ProductPrice')->html();
		$offer = pq('.ProductOptionList')->html();
		$stock = 0;
		if(sizeof(pq('#qty_') > 0)){
			$stock = 1;
		}else{
			$stock = -1;
		}
		if(strpos(pq('.pro-shipping').attr('style'),'display:none') !== false){
			$shipping_cost = 'Free Shipping Not Available';
		}else{
			$shipping_cost = pq('.pro-shipping').html();
		}
		if(strpos(pq('.pro-deliver').attr('style'),'display:none') !== false){
			$shipping_time = '';
		}else{
			$shipping_time = pq('.pro-deliver').html();
		}

		$attr = array();
		$cat = '';
		foreach(pq('#ProductBreadcrumb')->children('ul:first')->children('li') as $li){
			$cat .= pq($li)->children('a')->html().',';
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