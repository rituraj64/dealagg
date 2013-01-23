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
		return array(Category::GAMING,Category::TABLETS,Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC,Category::CAMERA,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'http://www.snapdeal.com/';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=364&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
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
				return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=290&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail="; //all
			}

		}else if($category == Category::CAMERA_ACC){
			//echo 'Implemente JSON for snap deal';die;
			if($subcat == Category::NOT_SURE || $subcat == Category::CAM_ACC_OTHER_ACC){
				/*non-json*/ return "http://www.snapdeal.com/search?keyword=$query&catId=290&categoryId=296&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=true&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ABattery%2520Chargers%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_BAGS){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ACamera%2520Bags%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_BATTERY){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ABatteries%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253AFlashes%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253AFilters%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_LENSES){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ALenses%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				/*non-json*/	return "http://www.snapdeal.com/search?keyword=$query&catId=290&categoryId=304&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$memory&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				/*json*/	return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ATripod%2520Ball%2520Head%255E%2520Tripods%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}else{
				/*non-json*/	return "http://www.snapdeal.com/search?keyword=$query&catId=290&categoryId=296&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=true&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}
			return "http://www.snapdeal.com/json/product/get/search/296/0/20?q=Type%253ABattery%2520Chargers%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";

		}else if($category == Category::MOBILE){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=175&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::MOBILE_ACC){
			if($subcat == Category::NOT_SURE){
				/*non-json*/		return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=29&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}elseif ($subcat == Category::MOB_BATTERY){
				/*json*/		return "http://www.snapdeal.com/json/product/get/search/29/0/20?q=Type%253ABatteries%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}elseif ($subcat == Category::MOB_HEADSETS){
				/*json*/		return "http://www.snapdeal.com/json/product/get/search/29/0/20?q=Type%253ABluetooth%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}elseif ($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				/*json*/		return "http://www.snapdeal.com/search?keyword=nokia+battery&catId=12&categoryId=29&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}elseif($subcat == Category::MOB_CAR_ACC){
				/*json*/		return "http://www.snapdeal.com/json/product/get/search/29/0/20?q=Type%253ACar%2520Accessories%257C&sort=rlvncy&keyword=$query&clickSrc=searchOnSubCat&viewType=Grid";
			}elseif($subcat == Category::MOB_MEMORY ){
				/*non-json*/	return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=228&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}elseif($subcat == Category::MOB_SPEAKER){
				/*json*/		return "http://www.snapdeal.com/json/product/get/search/29/0/20?q=Type%253AMobile%2520Speakers%257C&sort=rlvncy,rlvncy&keyword=$query&clickSrc=go_header&viewType=Grid";
			}else {
				/*non-json*/return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=29&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=29&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}

		}elseif ($category == Category::COMP_LAPTOP){
			if($subcat == Category::COMP_LAPTOP){
				return "http://www.snapdeal.com/search?keyword=$query&catId=21&categoryId=57&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=57&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
			}elseif($subcat == Category::COMP_COMPUTER){
				return "http://www.snapdeal.com/search?keyword=$query&catId=21&categoryId=55&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=57&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
			}
		}elseif($category == Category::TABLETS){
			return "http://www.snapdeal.com/search?keyword=$query&catId=12&categoryId=133&suggested=false&vertical=p&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else{
			return "http://www.snapdeal.com/search?keyword=".$query."&catId=12&categoryId=0&suggested=false&vertical=&noOfResults=20&clickSrc=searchOnSubCat&lastKeyword=$query&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}
	}

	public function getLogo(){
		return "http://i4.sdlcdn.com/img/snapdeal/sprite/snapdeal_logo_tagline.png";
	}

	public function getData($html,$query,$category,$subcat=false){
		$data = array();

		$data = json_decode($html,true);
		if(is_array($data)){
			if(isset($data['productDtos'])){
				$data2 = array();
				foreach($data['productDtos'] as $row){
					$stock = 1;
					if($row['soldOut'] == 1){
						$stock = -1;
					}
					$data2[] = array(
							'name'=>$row['name'],
							'image'=>'http://i1.sdlcdn.com/'.$row['image'],
							'disc_price'=>$row['displayPrice'],
							'url'=>'http://www.snapdeal.com/'.$row['pageUrl'],
							'website'=>$this->getCode(),
							'offer'=>'',
							'shipping'=>'',
							'stock'=>$stock,
							'author' => '',
							'cat' => ''
					);
				}
			}
		}else{

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
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
		return $data2;
	}

	public function hasProductdata(){
		return true;
	}
	public function getProductData($html,$price,$stock){
		phpQuery::newDocumentHTML($html);
		$price = pq('#selling-price-id')->html();
		$offer = pq('.freebie_text')->html();
		if(sizeof(pq('.buybutton-wrapper')->children('.prodbuy-button')) > 0){
			$stock = 1;
		}else{
			$stock = -1;
		}
		$i = 0;
		foreach (pq('.shippingSpace') as $div){
			if($i == 0){
				$shipping_cost = pq($div)->html();
			}elseif($i == 1){
				$shipping_time = pq($div)->html();
			}
			$i++;
		}

		$attr = array();
		$cat = '';
		foreach(pq('.bread-crumb')->children('.bread-cont') as $li){
			$cat .= pq($li)->children('a')->children('span')->html().',';
		}

		$warrenty = pq('.prod-warranty-text:first')->html();
		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => '',
				'cat' => $cat,
				'warrenty' => $warrenty
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}