<?php
class Seventymm extends Parsing{
	public $_code = 'Seventymm';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://shop.seventymm.com/';
	}
	public function getSearchURL($query,$category = false){
		$q = urldecode($query);
		$q = str_replace(" ", '-', $q);
		$q = trim(preg_replace("![^0-9a-z-]+!i", "", $q));
		if($category == Category::MOBILE){
			return "http://shop.seventymm.com/Search/$q/Tablets-and-Mobiles/2829/Mobiles/2369/All-Price/0/Any/0/Any/0/1/1/3/Go";
		}else if($category == Category::MOBILE_ACC){
			return "http://shop.seventymm.com/Search/microsd-card/Tablets-and-Mobiles/2829/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go";
		}
		return "http://shop.seventymm.com/Search/$q/All-Categories/0/All-Classification/0/All-Price/0/Any/0/Any/0/1/1/3/Go";
	}
	public function getLogo(){
		return 'http://staticcontent.seventymm.com/Images/SiteMasterV4/LogoC.png';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.Search_Panel')) > 0){
			//http://images.seventymm.com/Img/Item/ItemRegular/43262.jpg
			foreach(pq('.Search_Panel')->children('.MT10')->children('.MT20')->children('div') as $div){
				$image = pq($div)->children('img')->attr('do');
				$url = pq($div)->children('a')->attr('href');
				$name = pq($div)->children('a')->html();
				$disc_price = pq($div)->attr('sp');
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
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query,$category);
		return $data;
	}
}