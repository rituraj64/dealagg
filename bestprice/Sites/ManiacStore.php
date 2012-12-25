<?php
class ManiacStore extends Parsing{
	public $_code = 'ManiacStore';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.maniacstore.com';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore(text)=Mobile Store,alltypes(text)=Mobiles and Tablets,product type(text)=Mobile Phones";
		}else{
			return "http://www.yebhi.com/searchall.aspx?q=$query";
		}
	}
	public function getLogo(){
		return "http://www.yebhi.com/template/yebhi/img/ChrisYebhiLogo.jpg";
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.price_Reviews')) > 0){
			foreach(pq('div.price_Reviews') as $div){
				$image = pq($div)->find('.gotopage')->children('div')->html();
				$url = pq($div)->find('.gotopage')->attr('href');
				$name = pq($div)->children('p:first')->children('a')->html();
				$disc_price = pq($div)->children('.priice')->children('.inr')->html();
				$offer = pq($div)->children('.saving:last')->html();
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