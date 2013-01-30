<?php
class Rediff extends Parsing{
	public $_code = 'Rediff';
	public function getAllowedCategory(){
		return array(Category::TABLETS,Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC,Category::COMP_LAPTOP,Category::COMP_COMPUTER);
	}

	public function getWebsiteUrl(){
		return 'rediff.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::BOOKS){
			return "http://books.rediff.com/search/$query?&output=xml&src=search_$query";
		}else if($category == Category::MOBILE){
			$query = urldecode($query);
			//return "http://shopping.rediff.com/productv2/$query/cat-mobile phones & accessories|mobile accessories";
			return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|gsm+handsets";
		}else if($category == Category::MOBILE_ACC){
			$query = urldecode($query);
			if($subcat == Category::MOB_OTHERS || $subcat == Category::NOT_SURE){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile phones & accessories|mobile accessories";
			}elseif ($subcat == Category::MOB_BATTERY){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|battery?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_HEADSETS){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|bluetooth?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_CASES){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|carry+cases%2C+pouches?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_CHARGER){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|chargers?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_HANDSFREE || $subcat == Category::MOB_HEADPHONE){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|handsfree?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_SCREEN_GUARD){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|screen+protector?ref_src=inhome_srch|search_screen%20guard";
			}elseif ($subcat == Category::MOB_MEMORY){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|memory+card?ref_src=inhome_srch";
			}elseif ($subcat == Category::MOB_CABLE){
				return "http://shopping.rediff.com/productv2/$query/cat-mobile+phones+%26amp%3B+accessories|mobile+accessories|datacables?ref_src=inhome_srch";
			}
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital cameras";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital cameras";
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital slr cameras";
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|camcorders";
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital cameras";
			}else{
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|digital cameras";
			}
		}else if($category == Category::CAMERA_ACC){
			if($subcat == Category::NOT_SURE){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|camera accessories";
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cbatteries+%26amp%3B+chargers?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Ccamera+bags?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cbatteries+%26amp%3B+chargers?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cother+camera+accessories?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Ccamera+lenses?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Ccamera+lenses?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cmemory+cards?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cother+camera+accessories?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Cother+camera+accessories?ref_src=topnav_Cameras";
			}else if($subcat == Category::CAM_ACC_TRIPODS){
				return "http://shopping.rediff.com/productv2/$query/cat-cameras+%26amp%3B+optics%7Ccamera+accessories%7Ctripods?ref_src=topnav_Cameras";
			}else{
				return "http://shopping.rediff.com/productv2/$query/cat-cameras & optics|camera accessories";
			}
		}elseif ($category == Category::COMP_COMPUTER){
			return "http://shopping.rediff.com/productv2/$query/cat-computers+%26amp%3B+it+peripherals|desktop+pcs?ref_src=topnav_Computer|browse";
		}elseif ($category == Category::COMP_LAPTOP){
			return "http://shopping.rediff.com/productv2/$query/cat-computers+%26amp%3B+it+peripherals|laptops?ref_src=topnav_Computer|browse";
		}elseif($category == Category::TABLETS){
			return "http://shopping.rediff.com/productv2/$query/cat-computers+%26amp%3B+it+peripherals|tablets+%26amp%3B+e-book+readers";
		}else{
			return "http://shopping.rediff.com/shopping/index.html#!".urldecode($query);
		}
	}
	public function getLogo(){
		return "http://books.rediff.com/booksrediff/pix/rediff.png";
	}
	public function getData($html,$query,$category,$subcat){
		if($category == Category::BOOKS){
			$data = array();

			$xmlObj = new SimpleXMLElement($html);
			$match = $xmlObj->QueryMatch->total;
			if($match > 0){
				foreach($xmlObj->QueryMatch->book as $book){
					$name = $book->title."";
					$isbn = $book->isbn."";
					$author = $book->author.'';
					$image = $book->imagesmall.'';
					$disc_price = $book->domesticwebprice.'';
					$url = $book->book_url.'';
					$shipping = $book->despatchleadtime.' Working Days';
					$cat = '';
					$stock = 0;
					$offer = '';
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
							'isbn' => $isbn,
							'cat' => $cat
					);
				}
			}
			$data = $this->cleanData($data, $query);
			$data = $this->bestMatchData($data, $query,$category);
			return $data;
		}else{
			$data = array();
			phpQuery::newDocumentHTML($html);
			if(sizeof(pq('.productresultsWrapper')) > 0){
				foreach(pq('.productresultsWrapper')->children('div') as $div){
					if(sizeof(pq($div)->find('.mitemimg_h4_big:first'))){
						$image = pq($div)->find('.mitemimg_h4_big:first')->children('a')->html();
						$url = pq($div)->find('.mitemimg_h4_big:first')->children('a')->attr('href');
						$name = pq($div)->find('.mitemname_h4:first')->children('a')->html();
						if(sizeof(pq($div)->children('div')->children('div')->children('div:last')->children('div.mitemprice'))){
							$disc_price = pq($div)->children('div')->children('div')->children('div:last')->children('div:last')->html();
						}else{
							$disc_price = pq($div)->children('div')->children('div')->children('div:last')->children('span')->html();
						}
					}else{
						$image = pq($div)->children('.div_z_prodimg:first')->children('a')->html();
						$url = pq($div)->children('.div_z_prodimg:first')->children('a')->attr('href');
						$name = pq($div)->children('.z_mitemname:first')->children('a')->html();
						$disc_price = pq($div)->children('div.div_by')->children('a')->html();
					}
					$offer = '';
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
				$row['image'] = $img;
				$data2[] = $row;
			}
			$data2 = $this->cleanData($data2, $query);
			$data2 = $this->bestMatchData($data2, $query,$category,$subcat);
			return $data2;
		}
	}
public function hasProductdata(){
		return true;
	}
	public function getProductData($html,$price,$stock){
		phpQuery::newDocumentHTML($html);
		$price = pq('#prod_prcs')->html();
		
		$offer =pq('.product_detail_top:first')->find('.arial_12')->html();
		
		
			
	   if(sizeof(pq('.product_detail_top:first')->children('table')->find('img'))){
	   	
	   
	     	$stock=1;
	   }
		   else{
		     $stock=-1;
	   }
		
		
		
		$shipping_time =  pq('.product_detail_top:first')->children('table')->find('.font_gray11:last')->text();
		
         $shipping_cost = pq('.product_detail_top:first')->children('div')->text();
      
      
     
		$warrenty =  pq('.product_detail_top:first')->children('d')->html();

	    $author ='';
		
			
		foreach(pq('.secondary-info') as $div){
			if(pq($div)->children('span')->html() == 'Author:'){
				$author = pq($div)->children('a')->html();
			}
		}
		$attr = array();

		foreach(pq('.sim-prodname') as $div){
			if(!isset($attr['Variants'])){
				$attr['Variants'] = array();
			}
			$attr['Variants'][] = pq($div)->children('a')->html();
		}

		$cat = '';
		foreach(pq('.div_bread')->find('a') as $li){
			$cat .= pq($li)->html().',';
		}


		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => $author,
				'cat' => $cat,
				'warrenty' => $warrenty
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}