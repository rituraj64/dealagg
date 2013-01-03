<?php
class Fosila extends Parsing{

	public $_code = 'Fosila';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/fosiladotcom';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE);
	}

	public function getWebsiteUrl(){
		return 'http://www.fosila.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.fosila.com/mobiles?search=".$query;
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.fosila.com/digitalcameras?search=$query";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.fosila.com/digitalcameras?search=$query";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.fosila.com/slr?search=$query";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return '';
			}else if($subcat == Category::CAM_CAMCORDER){
				return '';
			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.fosila.com/batterychargers?search=$query";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return '';
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.fosila.com/batteries?search=$query";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return '';
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.fosila.com/lenses?search=$query";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.fosila.com/lenses?search=$query";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.fosila.com/memorycards?search=$query";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return '';
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return '';
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return '';
			}else{
				return '';
			}
		}
		return "http://www.fosila.com/all?key=".$query;;
	}
	public function getLogo(){
		return 'http://www.fosila.com/assets/fosila_logo-4cf0c01116ac6c3dab120d73e5e97cb5.jpg';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.product_info')) > 0){
			foreach(pq('ul.product_info') as $ul){
				foreach(pq($ul)->children('li') as $div){
					$image = pq($div)->children('.product_img')->html();
					$url = pq($div)->children('.product_img')->attr('href');
					$name = pq($div)->children('.procuct_info_name')->html();
					$disc_price = pq($div)->children('.procuct_info_price')->children('.our_cost')->html();
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