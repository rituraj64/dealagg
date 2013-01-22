<?php
class Greendust extends Parsing{
	public $_code = 'Greendust';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/GreenDustShopping';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::COMP_COMPUTER,Category::COMP_LAPTOP,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://www.greendust.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE || $category == Category::TABLETS){
			return "http://www.greendust.com/advanced_search_result.php?cata_id=105&product_list=$query&keywords=&x=0&y=0";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.greendust.com/advanced_search_result.php?cata_id=106,126,127,128,129,130,131&product_list=$query&keywords=&x=0&y=0";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=137,144,147&product_list=$query&keywords=&x=0&y=0";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=147&product_list=$query&keywords=&x=0&y=0";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=144&product_list=$query&keywords=&x=0&y=0";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=137&product_list=$query&keywords=&x=0&y=0";
			}else {
				return "http://www.greendust.com/advanced_search_result.php?cata_id=137,144,147&product_list=$query&keywords=&x=0&y=0";
			}
		}elseif ($category == Category::COMP_LAPTOP){
			if($subcat == Category::COMP_LAPTOP){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=142%2C146%2C150%2C153%2C155%2C157%2C159%2C162%2C164%2C166&product_list=$query&keywords=&x=10&y=18";
			}elseif ($subcat == Category::COMP_COMPUTER){
				return "http://www.greendust.com/advanced_search_result.php?cata_id=133%2C135%2C138%2C140%2C141%2C145%2C148%2C149%2C152%2C154%2C258%2C260%2C261%2C156%2C215%2C216%2C263&product_list=$query&keywords=&x=0&y=0";
			}
		}
		else{
			return "http://www.greendust.com/advanced_search_result.php?cata_id=0&product_list=$query&keywords=&x=0&y=0";
		}
	}
	public function getLogo(){
		return "http://www.greendust.com/templates/gdnew/images/logo.png";
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.product-dis')) > 0){
			foreach(pq('div.product-dis') as $div){
				$image = pq($div)->find('img')->parent('a')->html();
				$url = pq($div)->find('img')->parent('a')->attr('href');
				$name = pq($div)->children('div.product-dis-link')->children('a')->html();
				$disc_price = pq($div)->children('.price-hold')->children('.price')->html();
				$offer = '';
				$shipping = pq($div)->children('.free-s')->html();
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