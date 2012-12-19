<?php
class Croma extends Parsing{
	public $_code = 'Croma';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV);
	}

	public function getWebsiteUrl(){
		return 'http://www.cromaretail.com/';
	}
	public function getLogo(){
		return 'http://www.cromaretail.com/images/logo.jpg';
	}
	public function getSearchURL($query,$category = false){
		return "http://www.cromaretail.com/productsearch.aspx?txtSearch=$query&x=0&y=0";
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('ul.grid_view li') as $div){
			if(sizeof(pq($div)->find('.content_block'))){
				$image = pq($div)->find('.content_block')->find('a')->html();
				$url = pq($div)->find('.content_block-image')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.content_block')->find('.view-content')->find('a')->html());
				$disc_price = strip_tags(pq($div)->find('.content_block')->find('.view-price')->find('.price')->html());
				$org_price = 0;
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
		$data2 = $this->cleanData($data2,$query);
		$data2 = $this->bestMatchData($data2,$query);
		return $data2;
	}
}