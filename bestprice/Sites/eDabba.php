<?php
class eDabba extends Parsing{
	
	public $_code = 'eDabba';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/edabbamall';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.edabba.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5860&f[1]=im_taxonomy_catalog:5921";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5860&f[1]=im_taxonomy_catalog:5922";
			if ($subcat == Category::MOB_BATTERY){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog%3A5860&f[1]=im_taxonomy_catalog%3A5922&f[2]=im_taxonomy_catalog%3A6175";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog%3A5860&f[1]=im_taxonomy_catalog%3A5922&f[2]=im_taxonomy_catalog%3A6174";
			}elseif ($subcat == Category::MOB_HANDSFREE){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog%3A5860&f[1]=im_taxonomy_catalog%3A5922&f[2]=im_taxonomy_catalog%3A6171";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog%3A5860&f[1]=im_taxonomy_catalog%3A5922&f[2]=im_taxonomy_catalog%3A6173";
			}elseif ($subcat == Category::NOT_SURE || $subcat == Category::MOB_OTHERS){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5860&f[1]=im_taxonomy_catalog:5922"; //a mobile acc
			}else{
				return '';
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.edabba.com/search/site/$query?f%5B0%5D=im_taxonomy_catalog%3A5861"; //all cam and acc
			}else if($subcat == Category::CAM_DIGITAL_CAMERA || $subcat == Category::CAM_DIGITAL_SLR || $subcat == Category::CAM_MIRRORLESS){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5917"; //digial camera & slr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5918"; //camcorders
			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5919"; //all acc
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6145"; //memory cards
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6146"; //memory cards
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6155";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6154";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6149";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6148";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6145";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5919";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:6153";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5919";
			}else{
				return '';
			}
		}
		return "http://www.edabba.com/search/site/$query";
	}
	public function getLogo(){
		return 'http://d43w3023ueaau.cloudfront.net/sites/default/files/images/logo.png';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.products-li')) > 0){
			foreach(pq('.products-li') as $div){
				$image = pq($div)->children('.mini-node')->children('.field-image')->children('a')->html();
				$url = pq($div)->children('.mini-node')->children('.field-image')->children('a')->attr('href');
				$name = pq($div)->children('.mini-node')->children('.node-title')->children('a')->html();
				if(sizeof(pq($div)->children('.mini-node')->children('.offer-price')->children('.uc-price'))){
					$disc_price =pq($div)->children('.mini-node')->children('.offer-price')->children('.uc-price')->html();
				}else{
					$disc_price = pq($div)->children('.mini-node')->children('.price:first')->children('span')->html();
				}
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
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}