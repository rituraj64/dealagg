<?php
class Indiatimes extends Parsing{
	public $_code = 'Indiatimes';
	
	public function getWebsiteUrl(){
		return 'http://shopping.indiatimes.com/';
	}
	public function getLogo(){
		return "http://shopping.indiatimes.com/images/images/shopping-indiatimes.png";
	}
	public function getSearchURL($query,$category = false){
		return "http://shopping.indiatimes.com/control/mtkeywordsearch?SEARCH_STRING=".$query;
	}
	public function getData($html){
	
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.ProductList') as $div){
			if(sizeof(pq($div)->find('.productthumb'))){
				$image = pq($div)->find('.productthumb')->find("a")->html();
				$url = pq($div)->find('.productthumb')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.productdetail')->find('a')->html());
				$org_price = 0;
				$disc_price = pq($div)->find('.productdetail')->find('.price')->html();
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