<?php
class Infibeam extends Parsing{
	public $_code = 'Infibeam';

	public function getWebsiteUrl(){
		return 'http://www.infibeam.com';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.infibeam.com/search?q=".$query;
	}
	public function getData($html){

		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('ul.srch_result') as $div){
			foreach(pq($div)->find('li') as $div){
				$image = pq($div)->find('a')->html();
				$url = pq($div)->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.title')->html());
				$disc_price = pq($div)->find('.price')->find('.normal')->html();
				$org_price = pq($div)->find('.price')->find('.scratch ')->html();
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