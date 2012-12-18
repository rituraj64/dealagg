<?php
class Landmark extends Parsing{
	public $_code = 'Landmark';

	public function getWebsiteUrl(){
		return 'http://www.landmarkonthenet.com/';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.landmarkonthenet.com/search/?q=".$query;
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/img/landmark.png';
	}
	public function getData($html){
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