<?php
class BuyThePrice extends Parsing{
	public $_code = 'BuyThePrice';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://www.buytheprice.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=75&bid=0";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=78&bid=0";
		}else if($category == Category::TABLETS){
			return "http://www.buytheprice.com/ext_cache/get_search_data_listings_1.php?search=$query&ssc=78&bid=0";
		}
		return "http://www.buytheprice.com/search__".$query;
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/bestprice/img/buytheprice.png';
	}
	public function getData($html,$query,$category){

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
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}