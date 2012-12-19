<?php
class Landmark extends Parsing{
	public $_code = 'Landmark';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::GAMING,Category::MOBILE,Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.landmarkonthenet.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::CAMERA){
			return "http://www.landmarkonthenet.com/cameras/search/?q=".$query;
		}else if($category == Category::BOOKS){
			return "http://www.landmarkonthenet.com/books/search/?q=".$query;
		}else if($category == Category::GAMING){
			return "http://www.landmarkonthenet.com/gaming/search/?q=".$query;
		}else if($category == Category::MOBILE){
			return "http://www.landmarkonthenet.com/mobiles/search/?q=".$query;
		}
		return "http://www.landmarkonthenet.com/search/?q=".$query;
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/img/landmark.png';
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.searchresult') as $div){
			if(sizeof(pq($div)->find('.image'))){
				$image = pq($div)->find('.image')->find('a')->html();
				$url = pq($div)->find('.image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.info')->find('a')->html());
				$disc_price = strip_tags(pq($div)->find('.buttons')->find('.prices')->find('.oldprice')->html());
				$org_price = strip_tags(pq($div)->find('.buttons')->find('.prices')->find('.pricelabel')->html());
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$img = pq('img')->attr('src');
			if(strpos($img, 'http') === false){
				$img = $img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		return $data2;
	}
}