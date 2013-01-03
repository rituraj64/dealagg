<?php
class Saholic extends Parsing{
	public $_code = 'Saholic';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/mysaholic';
	}
	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA);
	}

	public function getWebsiteUrl(){
		return 'http://www.saholic.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010:Mobile+Phones";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010:Mobile+Accessories";
		}else if($category == Category::TABLETS){
			return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010:Tablets";
		}else if($category == Category::CAMERA){
			if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010%3ACameras&fq=F_50011:DSLR+Cameras";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA || $subcat == Category::CAM_MIRRORLESS){
				return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010%3ACameras&fq=F_50011:Compact+Cameras";
			}else if($subcat == Category::NOT_SURE){
				return "http://www.saholic.com/search?q=$query&category=10000&fq=F_50010:Cameras";
			}
		}
		return "http://www.saholic.com/search?q=".$query."&category=10000";
	}
	public function getLogo(){
		return "http://www.saholic.com/images/saholic-logo-5648.jpg";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('li.search-deals-items') as $div){
			if(sizeof(pq($div)->find('.productItem'))){
				$image = pq($div)->find('.productImg')->find("a")->html();
				$url = pq($div)->find('.productImg')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.productDetails')->find('.title')->find('a')->html());
				$org_price = 0;
				$disc_price = pq($div)->find('.productPrice')->find('.newPrice')->html();
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
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}