<?php
class Flipkart extends Parsing{
	public $_code = 'Flipkart';

	public function getWebsiteUrl(){
		return 'http://www.flipkart.com';
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/img/flipkart.png';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.flipkart.com/search/a/all?query=".$query."&vertical=all&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&otracker=start&_r=RxkVRuKj3BrMxTJVu9LopA--&_l=pMHn9vNCOBi05LKC_PwHFQ--&ref=fab6e824-24af-4177-b599-75ec8406cf5f&selmitem=All+Categories";
		//return "http://www.flipkart.com/search/a/all?query=".$query."&vertical=all&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&selmitem=All+Categories";
	}
	public function getData($html){

		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.size1of4') as $div){
			if(sizeof(pq($div)->find('.fk-product-thumb'))){
				$image = pq($div)->find('.fk-product-thumb')->children()->html();
				$a_link = pq($div)->find('.fk-anchor-link');
				$name = strip_tags($a_link->html());
				$url = $a_link->attr('href');
				$org_price = 0;
				$disc_price = pq($div)->find('.final-price')->html();
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
			}
		}

		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$row['image']= pq('img')->attr('src');
			$data2[] = $row;
		}
		return $data2;
	}
}