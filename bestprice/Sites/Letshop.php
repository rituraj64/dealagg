<?php
class Letshop extends Parsing{
	public $_code = 'Letsshop';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/LetsShopFans';
	}
	public function getAllowedCategory(){
		return array(Category::TABLETS,Category::MOBILE,Category::MOBILE_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://letsshop.in/';
	}

	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::MOBILE){
			return "http://letsshop.in/catalogsearch/result/index/?cat=4&q=$query";
		}else if($category == Category::TABLETS){
			return "http://letsshop.in/catalogsearch/result/index/?cat=4&mobile_type=212&&q=$query";
		}else if($category == Category::MOBILE_ACC){
			$query = str_replace(" ", "-", $query);
			if($subcat == Category::MOB_MEMORY){
				return "http://letsshop.in/catalogsearch/result/index/?cat=77&q=$query";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://letsshop.in/catalogsearch/result/index/?cat=16&q=$query";
			}elseif($subcat == Category::MOB_CAR_ACC){
				return "http://letsshop.in/catalogsearch/result/index/?cat=20&q=$query";
			}else{
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=12";
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=27";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=28";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=29";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=76";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=33";
			}else{
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=27";
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://letsshop.in/catalogsearch/result/?q=$query&cat=34";
			}
		}elseif($category == Category::COMP_LAPTOP){
			return "http://letsshop.in/catalogsearch/result/?q=$query&cat=22";
		}elseif ($category == Category::GAMING){
			if ($subcat == Category::GAMING_ACC_CONSOLES) {
				return "http://letsshop.in/catalogsearch/result/index/?cat=72&q=$query";
			}
		}
		return "http://letsshop.in/catalogsearch/result/?q=$query";
	}
	public function getLogo(){
		return 'http://letsshop.in/media/images/default/letsshop_1_1.png';
	}
	public function getData($html,$query,$category,$subcat=false){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.products-grid')) > 0){
			foreach(pq('ul.products-grid')->children('li') as $div){
				$image = pq($div)->children('a:first')->html();
				$url = pq($div)->children('a:first')->attr('href');
				$name = pq($div)->children('.product-name')->children('a')->html();
				if(sizeof(pq($div)->children('.price-box')->children('.special-price'))){
					$disc_price = pq($div)->children('.price-box')->children('.special-price')->children('.price')->html();
				}else{
					$disc_price = pq($div)->children('.price-box')->children('.regular-price')->children('.price')->html();
				}
				$offer = '';
				$shipping = '';
				$stock = 0;
				$html = pq($div)->children('p.availability')->html();
				$html = strip_tags($html);
				if(strpos($html, 'Out of stock') !== false){
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
}