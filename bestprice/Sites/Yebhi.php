<?php
class Yebhi extends Parsing{
	public $_code = 'Yebhi';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/YebhiIndia';
	}
	public function getAllowedCategory(){
		return array(Category::HOME_APPLIANCE,Category::TV,Category::BEAUTY,Category::MOBILE,Category::TABLETS,Category::MOBILE_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.yebhi.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore(text)=Mobile%20Store,alltypes(text)=Mobiles%20and%20Tablets,product%20type(text)=Mobile%20Phones";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=department(text)=Electronic%20and%20Mobile%20Accessories,bsbstore(text)=Mobile%20Store";
			if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories";
			}elseif ($subcat == Category::MOB_BATTERY){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Battery";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Bluetooth%20Headsets";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Cases%20and%20Pouches";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Charger";
			}elseif ($subcat == Category::MOB_HANDSFREE){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Earphones";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories,product%20type%28text%29=Screen%20Protectors";
			}elseif ($subcat == Category::MOB_HEADPHONE){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=product%20type%28text%29%20=Earphones";
			}else return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=bsbstore%28text%29=Mobile%20Store,alltypes%28text%29=Mobile%20Accessories";
		}elseif ($category == Category::COMP_LAPTOP){
			if($subcat == Category::COMP_LAPTOP){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=product%20type%28text%29=Laptops";
			}elseif($subcat == Category::COMP_COMPUTER){
				return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=product%20type%28text%29=Desktops";
			}
		}elseif($category == Category::TABLETS){
			return "http://www.yebhi.com/searchall.aspx?q=$query&restrictBy=alltypes%28text%29=Mobiles%20and%20Tablets";
		}else{
			return "http://www.yebhi.com/searchall.aspx?q=$query";
		}
	}
	public function getLogo(){
		return "http://www.yebhi.com/template/yebhi/img/ChrisYebhiLogo.jpg";
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.price_Reviews')) > 0){
			foreach(pq('div.price_Reviews') as $div){
				$image = pq($div)->find('.gotopage')->children('div')->html();
				$url = pq($div)->find('.gotopage')->attr('href');
				$name = pq($div)->children('p:first')->children('a')->html();
				$disc_price = pq($div)->children('.priice')->children('.inr')->html();
				$offer = pq($div)->children('.saving:last')->html();
				$shipping = '';
				$stock = 0;
				$author = '';
				$data[] = array(
						'name'=>$name,
						'image'=>$image,
						'disc_price'=>$disc_price,
						'url'=>$url,
						'website'=>$this->getCode(),
						'offer'=>$offer,
						'shipping'=>$shipping,
						'stock'=>$stock,
						'author' => $author,
						'cat' => ''
				);
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