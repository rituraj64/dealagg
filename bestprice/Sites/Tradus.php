<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://www.tradus.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BEAUTY){
			return "http://www.tradus.com/search?query=$query&cat=7763";
		}else if($category == Category::BOOKS){
			return "http://www.tradus.com/search?query=$query&cat=375";
		}else if($category == Category::CAMERA){
			return "http://www.tradus.com/search?query=$query&cat=7666";
		}else if($category == Category::COMP_LAPTOP){
			return "http://www.tradus.com/search?query=$query&cat=7684";
		}else if($category == Category::TABLETS){
			return "http://www.tradus.com/search?query=$query&cat=7684";
		}else if($category == Category::COMP_ACC){
			return "http://www.tradus.com/search?query=$query&cat=7684";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://www.tradus.com/search?query=$query&cat=10000";
		}else if($category == Category::MOBILE){
			return "http://www.tradus.com/search?query=$query&cat=7756";
		}else if($category == Category::TV){
			return "http://www.tradus.com/search?query=$query&cat=7698";
		}else if($category == Category::GAMING){
			return "http://www.tradus.com/search?query=$query&cat=7666";
		}else{
			return "http://www.tradus.com/search?query=".$query;
		}
	}
	public function getLogo(){
		return "http://www.tradus.com/sites/all/themes/basic/images/ci_images/tradus_logo/tradus_new_logo.jpg";
	}
	public function getData($html,$query,$category){

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