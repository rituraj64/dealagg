<?php
class Royalimages extends Parsing{
	public $_code = 'Royalimages';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/RoyalImages.in';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.royalimages.in/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.royalimages.in/catalogsearch/result/index/?cat=13&q=$query";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.royalimages.in/catalogsearch/result/index/?cat=15&q=$query";
			if($subcat == Category::MOB_HANDSFREE){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=19&q=$query";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=21&q=$query";
			}elseif($subcat == Category::MOB_SPEAKER){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=24&q=$query";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=17&q=$query";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=16&q=$query";
			}elseif ($subcat == Category::MOB_MEMORY){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=22&q=$query";
			}elseif ($subcat == Category::MOB_HEADPHONE){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=18&q=$query";
			}elseif ($subcat == Category::MOB_OTHERS){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=15&q=$query";
			}else{
				return "";
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=32&q=$query";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=33&q=$query";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=35&q=$query";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=37&q=$query";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.royalimages.in/catalogsearch/result/index/?cat=32&q=$query";
			}else{
				return '';
			}
		}
		return "http://www.royalimages.in/catalogsearch/result/?q=$query";
	}
	public function getLogo(){
		return 'http://www.royalimages.in/skin/frontend/default/royalimages/images/Royalimages.jpg';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('ul.products-grid')) > 0){
			foreach(pq('ul.products-grid') as $div){
				foreach(pq($div)->children('li.item') as $div){
					$image = pq($div)->children('a:first')->html();
					$url = pq($div)->children('a:first')->attr('href');
					$name = pq($div)->children('.product-name')->children('a')->html();
					$disc_price = pq($div)->children('.info')->children('.price-box')->find('.price')->html();
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