<?php
class Amegabooks extends Parsing{
	public $_code = 'Amegabooks';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.amegabooks.com/';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.amegabooks.com/search/ALL/".$query;
	}
	public function getLogo(){
		return "http://www.amegabooks.com/images/logo.png";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('form') as $div){
			$action = pq($div)->attr('action');
			if(strpos($action, 'cart.html') !== false){
				$image = "http://www.amegabooks.com/images/products/thumbnails/".pq($div)->children('input[name=pro_image]')->val();
				$url = pq($div)->children('input[name=pro_url]')->val();
				$name = pq($div)->children('input[name=pro_name]')->val();
				$disc_price = pq($div)->children('input[name=pro_price]')->val();
				$shipping = pq($div)->find('.normal:last')->html();
				$offer = '' ;
				$stock = 0;
				$s = pq($div)->find('.stock')->html();;
				if( strpos(strtolower($s), 'out of stock') !== false ){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$cat ='';
				$author = pq($div)->find('.prohead')->children('span')->html();
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
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query,$category);
		return $data;
	}
}