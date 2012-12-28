<?php
class BuyThePrice extends Parsing{
	public $_code = 'BuyThePrice';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::TABLETS,Category::CAMERA,Category::CAMERA_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.buytheprice.com/';
	}
	public function getSearchURL($query,$category = false,$subcat = false){
		if($category == Category::MOBILE){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=75&bid=0";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=78&bid=0";
		}else if($category == Category::TABLETS){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=78&bid=0";
		}else if($category == Category::CAMERA){
			if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=91&bid=0"; //digial camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=92&bid=0"; //digial dslr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=95&bid=0"; //camcorder
			}else if($subcat == Category::NOT_SURE){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=91&bid=0"; //digial camera
			}else{
				return '';
			}
			//return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=96&bid=0"; //optics
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=97&bid=0";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=501&bid=0";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=502&bid=0";
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=501&bid=0";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=509&bid=0";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=508&bid=0";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=505&bid=0";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=510&bid=0";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=510&bid=0";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=500&bid=0";
			}else{
				return '';
			}
		}
		return "http://www.buytheprice.com/search__".$query;
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/bestprice/img/buytheprice.png';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.product-block1')) > 0){
			foreach(pq('.product-block1') as $div){
				$image = pq($div)->find('.mosaic-backdrop:first')->html();
				$url = pq($div)->find('.mosaic-backdrop:first')->attr('href');
				$name = pq($div)->find('h2.product-name:first')->html();
				$disc_price = pq($div)->children('a')->html();
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