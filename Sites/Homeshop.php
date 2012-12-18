<?php
class Homeshop extends Parsing{
	public $_code = 'Homeshop18';
	
	public function getWebsiteUrl(){
		return 'http://www.homeshop18.com/';
	}
	public function getLogo(){
		return "http://www.homeshop18.com/homeshop18/media/images/homeshop18_2011/header/hs18-logo.png";
	}
	public function getSearchURL($query,$category = false){
		return "http://www.homeshop18.com/$query/search:$query";
	}
	public function getData($html){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.product_div  ') as $div){
			if(sizeof(pq($div)->find('.product_image'))){
				$image = pq($div)->find('.product_image')->find('a')->html();
				$url = pq($div)->find('.product_image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_title')->find('a')->html());
				$disc_price = strip_tags(pq($div)->find('.product_price')->find('.product_old_price')->html());
				$org_price = strip_tags(pq($div)->find('.product_price')->find('.product_new_price')->html());
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
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		return $data2;
	}
}