<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';
	
	public function getWebsiteUrl(){
		return 'http://www.tradus.com/';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.tradus.com/search?query=".$query;
	}
	public function getData($html){
	
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.prod_main_div') as $div){
			if(sizeof(pq($div)->find('.product_image'))){
				$image = pq($div)->find('.product_image')->children()->html();
				$url = pq($div)->find('.product_image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_name')->find('a')->html());
				$org_price = pq($div)->find('.prod_price_3')->find('.numDiv_right')->html();
				$disc_price = pq($div)->find('.prod_price_3')->find('.numDiv_left')->html();
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$row['image']= pq('img')->attr('data-original');
			$data2[] = $row;
		}
		return $data2;
	}
}