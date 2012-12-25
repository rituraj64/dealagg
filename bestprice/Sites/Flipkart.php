<?php
class Flipkart extends Parsing{
	public $_code = 'Flipkart';

	//need to integrate flipkart offers and cashback

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.flipkart.com';
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/bestprice/img/flipkart.png';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.flipkart.com/mobiles/pr?sid=tyy%2C4io&q=$query&query=$query";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.flipkart.com/mobile-accessories/pr?sid=tyy%2C4mr&q=$query&query=$query";
		}else if($category == Category::BOOKS){
			return "http://www.flipkart.com/search-books?query=$query&searchGroup=books-stationeries&ref=6695f070-3c76-4c61-92bd-7bedc39b8873";
		}else if($category == Category::CAMERA){
			return "http://www.flipkart.com/search/a/cameras?query=".$query."&vertical=cameras&dd=0&autosuggest%5Bas%5D=off&autosuggest%5Bas-submittype%5D=entered&autosuggest%5Bas-grouprank%5D=0&autosuggest%5Bas-overallrank%5D=0&autosuggest%5Borig-query%5D=&autosuggest%5Bas-shown%5D=off&Search=%C2%A0&otracker=start&_r=RsuiHvNUWzIGQmMYN5OGLg--&_l=Tnndui8JdMVk7CZmDKIfXQ--&ref=6fb555e9-d5cf-4aae-8c6b-e004173ec1d7&selmitem=Cameras";
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
	public function getData($html,$query,$category){

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
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}