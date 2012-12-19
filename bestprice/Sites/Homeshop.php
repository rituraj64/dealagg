<?php
class Homeshop extends Parsing{
	public $_code = 'Homeshop18';

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::TV,Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://www.homeshop18.com/';
	}
	public function getLogo(){
		return "http://www.homeshop18.com/homeshop18/media/images/homeshop18_2011/header/hs18-logo.png";
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BEAUTY){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3471";
		}else if($category == Category::BOOKS){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:10000";
		}else if($category == Category::CAMERA){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3159";
		}else if($category == Category::COMP_ACC || $category == Category::COMP_LAPTOP || $category == Category::TABLETS){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3254";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3575";
		}else if($category == Category::MOBILE){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3024";
		}else if($category == Category::TV){
			return "http://www.homeshop18.com/$query/search:$query/categoryid:3203";
		}else{
			return "http://www.homeshop18.com/$query/search:$query";
		}
	}
	public function getData($html,$query,$category){
		$data = array();
		phpQuery::newDocumentHTML($html);

		if($category == Category::BOOKS){
			foreach(pq('div.book_rock') as $div){
				
			}		
		}else{
			foreach(pq('div.product_div') as $div){
				if(sizeof(pq($div)->find('.product_image'))){
					$image = pq($div)->find('.product_image')->find('a')->html();
					$url = pq($div)->find('.product_image')->find('a')->attr('href');
					$name = strip_tags(pq($div)->find('.product_title')->find('a')->html());
					$disc_price = strip_tags(pq($div)->find('.product_price')->find('.product_old_price')->html());
					$org_price = strip_tags(pq($div)->find('.product_price')->find('.product_new_price')->html());
					$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
				}
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
		echo '<pre>';
		print_r($data2);
		die;
		return $data2;
	}
}