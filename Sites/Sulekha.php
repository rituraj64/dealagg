<?php
class Sulekha extends Parsing{
	public $_code = 'Sulekha';

	public function getWebsiteUrl(){
		return 'http://shopping.indiatimes.com/';
	}
	public function getLogo(){
		return $_SERVER["SERVER_NAME"].'scrapping/img/sulekha.png';
	}
	public function getSearchURL($query,$category = false){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);
		return "http://deals.sulekha.com/".$query2."_search?q=".$query;
	}
	public function getData($html){

		//this redirects to category page many times so write code for that as well.

		$data = array();
		phpQuery::newDocumentHTML($html);
		echo htmlentities(pq('div.dealBoxContainer')->html());die;
		echo $html;die;
		foreach(pq('div.masonry-brick') as $div){
			echo 1;die;
			if(sizeof(pq($div)->find('.dealimgst'))){
				$image = pq($div)->find('.dealimgst')->find("a")->html();
				$url = pq($div)->find('.dealimgst')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.deallstit')->find('a')->html());
				$org_price = strip_tags(pq($div)->find('.priceglg')->find('.strike')->html());
				$disc_price = strip_tags(pq($div)->find('.priceglg')->find('.hgtlgtorg')->html());
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