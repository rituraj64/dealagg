<?php
class TheMobileStore extends Parsing{
	public $_code = 'TheMobileStore';

	public function getWebsiteUrl(){
		return 'http://www.themobilestore.in';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.themobilestore.in/home/search?q=".$query;
	}
	public function getData($html){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('.search-result-items') as $div){
			if(sizeof(pq($div)->find('.variant-image'))){
				$image = pq($div)->find('.variant-image')->find('a')->html();
				$url = pq($div)->find('.variant-image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.variant-desc')->find('.variant-title')->find('a')->html());
				$disc_price = strip_tags(pq($div)->find('.variant-desc')->find('.price')->find('.variant-list-price')->html());
				$org_price = strip_tags(pq($div)->find('.variant-desc')->find('.price')->find('.variant-final-price')->html());
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