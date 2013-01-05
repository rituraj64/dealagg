<?php
class Snapdeal extends Parsing{
	public $_code = 'Snapdeal';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/SnapDeal';
	}
	public function isTrusted($category){
		return true;
	}

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.snapdeal.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=364&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$querycream&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=290&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; //all
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=291&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; // digital camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=292&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; // digital srls
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=293&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; // camcorder
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=291&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; // digital camera
			}else{
				return '';
			}

		}else if($category == Category::CAMERA_ACC){
			echo 'Implemente JSON for snap deal';die;
			return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ABattery%2520Chargers%257C&sort=rlvncy&keyword=nikon&clickSrc=searchOnSubCat&viewType=Grid";

			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=296&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; //acc
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=304&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; //memory card
		}else if($category == Category::MOBILE){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=175&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=29&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; //acc
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=228&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; // memory cards
			/*
			 * for mobile acc catogeries later
			 * 
			 * if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "";
			}elseif ($subcat == Category::MOB_BATTERY){
				return "";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "";
			}elseif ($subcat == Category::MOB_CASES){
				return "";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "";
			}elseif ($subcat == Category::MOB_HANDSFREE){
				return "";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "";
			}elseif ($subcat == Category::MOB_HEADPHONE){
				return "";
			}else return "";
			 */
		}elseif ($category == Category::COMP_COMPUTER){
			return "http://www.snapdeal.com/search?keyword=$query&catId=21&categoryId=55&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=57&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://www.snapdeal.com/search?keyword=$query&catId=21&categoryId=57&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=57&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else{
			return "http://www.snapdeal.com/search?keyword=".$query."&catId=12&categoryId=0&suggested=false&vertical=&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}
	}
	public function getLogo(){
		return "http://i4.sdlcdn.com/img/snapdeal/sprite/snapdeal_logo_tagline.png";
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('#filter-no-results-message')) > 0){
			//return $data;  this div shows always
		}
		if(sizeof(pq('div.product_listing_cont'))){
			foreach(pq('div.product_listing_cont') as $div){
				if(sizeof(pq($div)->find('.product-image'))){
					$image = pq($div)->find('.product-image')->html();
					$url = pq($div)->find('a')->attr('href');
					$name = strip_tags(pq($div)->find('.product_listing_heading')->html());
					$disc_price = pq($div)->find('.product_listing_price_outer')->find('.product_discount_outer ')->html();
					$offer = '';
					$shipping = '' ;
					$stock = 0;
					$cat ='';
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
							'cat' => $cat
					);
				}
			}
		}else{
			if(sizeof(pq('.product_grid_cont'))){
				foreach(pq('.product_grid_cont') as $div){
					if(sizeof(pq($div)->find('.product-image'))){
						$image = pq($div)->find('.product-image')->html();
						$url = pq($div)->children('a:first')->attr('href');
						$name = pq($div)->find('.product_grid_cont_heading')->html();
						$org_price = $disc_price = pq($div)->find('.product_grid_cont_price_outer')->children('.product_price')->children('.originalprice ')->html();
						$org_price = $this->clearHtml($org_price);
						$disc_price = pq($div)->find('.product_grid_cont_price_outer')->children('.product_price')->html();;
						$disc_price = $this->clearHtml($disc_price);
						$disc_price = str_replace($org_price, '', $disc_price);
						$offer = '';
						$shipping = '';
						$stock = 0;
						$cat ='';
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
								'cat' => $cat
						);
					}
				}
			}else{
				if(sizeof(pq('.container'))){
					foreach(pq('.container') as $div){
						$image = pq($div)->find('.imgCont:first')->html();
						$url = pq($div)->children('a:first')->attr('href');
						$name = pq($div)->find('.product_listing_heading:first')->html();
						pq($div)->find('.product_price')->children('.originalprice')->html('');
						$disc_price = pq($div)->find('.product_price')->html();
						$offer = '';
						$shipping = '';
						$stock = 0;
						$cat ='';
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
								'cat' => $cat
						);
					}
				}else {
					if(sizeof(pq('div.product_list_view_cont'))){
						foreach(pq('div.product_list_view_cont') as $div){
							$image = pq($div)->children('.product_image_wrapper')->children('a')->children('.product-image')->html();
							$url = pq($div)->children('.product_image_wrapper')->children('a')->attr('href');
							$name = pq($div)->find('.product_list_view_info_cont')->children('a')->html();
							$disc_price = pq($div)->find('.product_list_view_info_cont')->children('.product_list_view_price_outer')->find('.redText')->html();
							$offer = pq($div)->find('.product_list_view_info_cont')->children('.overhid:first')->children('.freebie_text_wrapper')->html();
							$shipping = pq($div)->find('.product_list_view_info_cont')->children('.overhid:eq(2)')->children('.product_list_view_shipped')->html();;
							$stock = 0;
							$cat ='';
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
									'cat' => $cat
							);
						}
					}
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
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}
}