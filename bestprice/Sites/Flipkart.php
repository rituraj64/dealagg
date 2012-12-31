<?php
class Flipkart extends Parsing{
	public $_code = 'Flipkart';

	public function isTrusted($category){
		return true;
	}

	//need to integrate flipkart offers and cashback

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::CAMERA_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.flipkart.com';
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/flipkart.png';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return "http://www.flipkart.com/mobiles/pr?sid=tyy%2C4io&q=$query&query=$query";
		}else if($category == Category::MOBILE_ACC){
			//return "http://www.flipkart.com/mobile-accessories/pr?sid=tyy%2C4mr&q=$query&query=$query";
			if ($subcat == Category::MOB_SCREEN_GUARD){
				return "www.flipkart.com/mobile-accessories/screen-guards/pr?sid=tyy%2C4mr%2Clrv&q=$query";
			}elseif ($subcat == Category::MOB_HANDSFREE){
				return "http://www.flipkart.com/mobile-accessories/headsets/wired-headsets/pr?sid=tyy%2C4mr%2Cyhg%2C8d4&layout=grid&q=$query";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://www.flipkart.com/mobile-accessories/headsets/bluetooth-headsets/pr?sid=tyy%2C4mr%2Cyhg%2Cqtx&q=$query";
			}elseif ($subcat == Category::MOB_BATTERY){
				return "http://www.flipkart.com/mobile-accessories/batteries/pr?sid=tyy%2C4mr%2Cw65&q=$query";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://www.flipkart.com/mobile-accessories/chargers/pr?sid=tyy%2C4mr%2Ctp2&q=$query";
			}elseif ($subcat == Category::MOB_SPEAKER){
				return "http://www.flipkart.com/mobile-accessories/speakers/pr?sid=tyy%2C4mr%2C5ev&q=$query";
			}elseif ($subcat == Category::MOB_CABLE){
				return "http://www.flipkart.com/mobile-accessories/cables/pr?sid=tyy%2C4mr%2C3nu&q=$query";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://www.flipkart.com/mobile-accessories/cases-and-covers/pr?sid=tyy%2C4mr%2Cq2u&q=$query";
			}elseif ($subcat == Category::MOB_OTHERS){
				return "http://www.flipkart.com/mobile-accessories/pr?sid=tyy%2C4mr&q=$query&otracker=from-multi&ref=5f05d1cc-662f-416b-9e01-6888bfc0603f&query=$query";
			}else {
				return "";
			}
		}else if($category == Category::BOOKS){
			return "http://www.flipkart.com/search-books?query=$query&searchGroup=books-stationeries&ref=6695f070-3c76-4c61-92bd-7bedc39b8873";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.flipkart.com/cameras/pr?sid=jek%2Cp31&q=$query&query=$query"; //all cam and acc
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.flipkart.com/cameras/pr?p%5B%5D=facets.type%255B%255D%3DPoint%2B%2526%2BShoot&sid=jek%2Cp31&layout=grid&q=$query";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.flipkart.com/cameras/pr?p%5B%5D=facets.type%255B%255D%3DSLR&sid=jek%2Cp31&layout=grid&q=$query";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.flipkart.com/cameras/pr?p%5B%5D=facets.type%255B%255D%3DMirrorless&sid=jek%2Cp31&layout=grid&q=$query";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.flipkart.com/cameras/pr?p%5B%5D=facets.type%255B%255D%3DCamcorder&sid=jek%2Cp31&layout=grid&q=$query";
			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://www.flipkart.com/camera-accessories/pr?sid=jek%2Cp31&q=$query&query=$query";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://www.flipkart.com/camera-accessories/battery-chargers/pr?sid=jek%2C6l2%2Ckrc&layout=grid&q=$query&ajax=true";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://www.flipkart.com/camera-accessories/camera-bags/pr?sid=jek%2C6l2%2C6ts&layout=grid&q=$query"; //memory cards
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://www.flipkart.com/camera-accessories/batteries/pr?sid=jek%2C6l2%2Cw65&layout=grid&q=$query";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://www.flipkart.com/camera-accessories/flashes/pr?sid=jek%2C6l2%2Cmx9&layout=grid&q=$query";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://www.flipkart.com/camera-accessories/filters/pr?sid=jek%2C6l2%2Cowv&layout=grid&q=$query";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://www.flipkart.com/camera-accessories/lenses/pr?sid=jek%2C6l2%2Ce9y&layout=grid&q=$query";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://www.flipkart.com/camera-accessories/memory-cards/pr?sid=jek%2C6l2%2C7y6&layout=grid&q=$query";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://www.flipkart.com/camera-accessories/pr?sid=jek%2Cp31&q=$query&query=$query";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://www.flipkart.com/camera-accessories/pr?sid=jek%2Cp31&q=$query&query=$query";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://www.flipkart.com/camera-accessories/tripods/pr?sid=jek%2C6l2%2Cce6&layout=grid&q=$query";
			}else{
				return '';
			}
		}else if($category == Category::COMP_ACC || $category == Category::COMP_LAPTOP || $category == Category::TABLETS){
			return "http://www.flipkart.com/search/a/computers?query=".$query."&vertical=computers&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&otracker=start&_r=RsuiHvNUWzIGQmMYN5OGLg--&_l=Tnndui8JdMVk7CZmDKIfXQ--&ref=de3e3b97-e0c3-4810-b670-fed8e7f132bd&selmitem=Computers";
		}else if($category == Category::GAMING){
			return "http://www.flipkart.com/search/a/games?query=".$query."&vertical=games&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=default-search&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&otracker=start&_r=F7RHLcm3kzA6g5uio1jyrw--&_l=dPxEw4fkCcmDR6VWspVbMg--&ref=12124740-3d86-450c-ae16-30639a87e713&selmitem=Games+%26+Consoles";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://www.flipkart.com/home-kitchen/pr?sid=j9e&q=".$query."&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&selmitem=Home+%26+Kitchen&otracker=start&_l=Tnndui8JdMVk7CZmDKIfXQ--&_r=RsuiHvNUWzIGQmMYN5OGLg--&ref=b4322868-5f32-4a39-90fe-37e2a0c57191";
		}else if($category == Category::TV){
			return "http://www.flipkart.com/tvs-audio-video-players/tv-video/pr?sid=ckf,see&q='.$query.'&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&selmitem=TVs+%26+Video+Players&otracker=start&_l=Tnndui8JdMVk7CZmDKIfXQ--&_r=RsuiHvNUWzIGQmMYN5OGLg--&ref=5ec4254d-f08f-40ce-b1b3-81854d37bbb6";
		}else if($category == Category::BEAUTY){
			return "http://www.flipkart.com/beauty-and-personal-care/pr?sid=t06&q=".$query."&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&selmitem=Beauty+%26+Personal+Care&otracker=start&_l=dY2Vv7%20dT%20BcojM7Q0aWCA--&_r=pKHhEYwirnApk1HHs4pVyQ--&ref=97822d89-acb5-42bd-bf53-a47f4112fa1d";
		}else{
			return "http://www.flipkart.com/search/a/all?query=".$query."&vertical=all&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&otracker=start&_r=RxkVRuKj3BrMxTJVu9LopA--&_l=pMHn9vNCOBi05LKC_PwHFQ--&ref=fab6e824-24af-4177-b599-75ec8406cf5f&selmitem=All+Categories";
		}
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		phpQuery::newDocumentHTML($html);

		if(sizeof(pq('#noresults_info')) > 0){
			return $data;
		}
		if(pq('.noSearchMatching-text')){
			$html = pq('.noSearchMatching-text')->html();
			if(strpos($html, 'No Results found for') !== false){
				return $data;
			}
		}

		if(sizeof(pq('div.search_results_preview_box')) > 0){
			foreach(pq('div.search_results_preview_box') as $box){
				$cat = pq($box)->find('.title')->find('a')->html();
				$cat = $this->removeNum($cat);
				foreach(pq($box)->find('div.size1of4') as $div){
					if(sizeof(pq($div)->find('.fk-product-thumb'))){
						$image = pq($div)->find('.fk-product-thumb')->children('a.prd-img')->html();
						$a_link = pq($div)->find('.fk-anchor-link');
						$name = strip_tags($a_link->html());
						$url = $a_link->attr('href');
						$disc_price = pq($div)->find('.final-price')->html();
						$offer = pq($div)->find('.fk-search-page-offers')->html();
						$stock = 0;
						$shipping = '';
						$author = '';
						if($cat == 'Books'){
							$author = pq($div)->find('.fk-item-category')->html();
							$author = $this->clearHtml($author);
						}
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
								'cat' => $cat
						);
					}
				}
			}
		}else{
			if(sizeof(pq('div.fk-srch-item')) > 0){
				$cat = pq('div.search_info')->find('b')->html();
				foreach(pq('div.fk-srch-item') as $div){
					$image = pq($div)->find('.fk-sitem-image-section')->find('a')->html();
					$url = pq($div)->find('.fk-sitem-image-section')->find('a')->attr('href');
					$name = pq($div)->find('.fk-srch-item-title')->find('a')->html();
					$org_price = 0;
					$disc_price = pq($div)->find('.fk-sitem-info-section')->find('.final-price')->html();
					$offer = '';
					$shipping = pq($div)->find('.fk-sitem-info-section')->find('.shipping-period')->html();
					$author = pq($div)->find('.fk-item-authorinfo-text')->find('a')->html();
					$stock = pq($div)->find('.fk-sitem-info-section')->find('.search-shipping')->html();
					if($stock){
						if(strpos('Out Of Stock', $stock) !== false){
							$stock = -1;
						}else{
							$stock = 1;
						}
					}
					$data[] = array(
							'name'=>$name,
							'image'=>$image,
							'org_price'=>$org_price,
							'disc_price'=>$disc_price,
							'url'=>$url,
							'website'=>$this->getCode(),
							'offer'=>$offer,
							'shipping'=>$shipping,
							'stock'=>$stock,
							'author' => $author,
							'cat' => $cat
					);
				}
			}else if(sizeof(pq('div.product')) > 0){
				foreach(pq('div.product') as $div){
					$image = pq($div)->find('.fk-product-thumb')->children('a.prd-img')->html();
					$a_link = pq($div)->find('.fk-anchor-link');
					$name = strip_tags($a_link->html());
					$url = $a_link->attr('href');
					$disc_price = pq($div)->find('.final-price')->html();
					$offer = pq($div)->find('.fk-search-page-offers')->html();
					$stock = 0;
					$shipping = '';
					$author = '';
					if($category == 'Books'){
						$author = pq($div)->find('.fk-item-category')->html();
						$author = $this->clearHtml($author);
					}
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
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$row['image']= pq('img')->attr('data-src');
			if(empty($row['image'])){
				$row['image'] = pq('img')->attr('src');
			}
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}