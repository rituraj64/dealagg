<?php
class Snapdeal extends Parsing{
	public $_code = 'Snapdeal';
	
	public function getWebsiteUrl(){
		return 'http://www.snapdeal.com/';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.snapdeal.com/search?keyword=".$query."&catId=&categoryId=0&suggested=false&vertical=&noOfResults=20&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
	}
	public function getLogo(){
		return "http://i4.sdlcdn.com/img/snapdeal/sprite/snapdeal_logo_tagline.png";
	}
	public function getData($html){
	
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.product_listing_cont') as $div){
			if(sizeof(pq($div)->find('.product-image'))){
				$image = pq($div)->find('.product-image')->html();
				$url = pq($div)->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_listing_heading')->html());
				$org_price = pq($div)->find('.product_listing_price_outer')->find('.originalprice')->html();
				$disc_price = pq($div)->find('.product_listing_price_outer')->find('.product_discount_outer ')->html();
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