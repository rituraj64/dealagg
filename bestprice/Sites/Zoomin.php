<?php
class Zoomin extends Parsing{
	public $_code = 'Zoomin';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/zoomin';
	}
	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::MOBILE,Category::CAMERA_ACC,Category::MOBILE_ACC);
	}
	public function isTrusted($category){
		if($category == Category::CAMERA){
			return true;
		}
	}
	public function getWebsiteUrl(){
		return 'http://camera.zoomin.com';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		if($category == Category::MOBILE){
			return 'http://camera.zoomin.com/index.php/search/ajax/query?r=select&q='.$query.'&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D'.$query.'&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356259576033&fq=category%3A%22Phones%22&wt=json&json.wrf=_prototypeJSONPCallback_2';
		}else if($category == Category::MOBILE_ACC){
			return 'http://camera.zoomin.com/index.php/search/ajax/query?r=select&q='.$query.'&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D'.$query.'&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356413422571&wt=json&json.wrf=_prototypeJSONPCallback_4';
		}else if($category == Category::CAMERA){
			if($subcat == Category::NOT_SURE){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356677157906&wt=json&json.wrf=_prototypeJSONPCallback_4";
			}else if($subcat == Category::CAM_DIGITAL_CAMERA){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Compact%20Cameras%22&wt=json&json.wrf=_prototypeJSONPCallback_26"; //digital camera
			}else if($subcat == Category::CAM_DIGITAL_SLR){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22DSLR%20Cameras%22&wt=json&json.wrf=_prototypeJSONPCallback_78"; //digital slr
			}else if($subcat == Category::CAM_CAMCORDER){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Digital%20Video%20Cameras%22&wt=json&json.wrf=_prototypeJSONPCallback_18"; //camcorders
			}else if($subcat == Category::CAM_MIRRORLESS){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&facet=true&facet.field=oemname_facets%2Ccategory&defType=dismax&timestamp=1356597696131&qf=name_varchar%20oemname_int%20&wt=json&json.wrf=_prototypeJSONPCallback_61"; //mirror less and compact
			}else{
				return '';
			}
		}else if($category == Category::CAMERA_ACC){

			if($subcat == Category::NOT_SURE){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Accessories%22&wt=json&json.wrf=_prototypeJSONPCallback_6"; // acc, this is parent
			}else if($subcat == Category::CAM_ACC_ADAPTER_CHARGES){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Batteries%20%26%20Chargers%22&wt=json&json.wrf=_prototypeJSONPCallback_10"; //battery
			}else if($subcat == Category::CAM_ACC_BAGS){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Bags%20%26%20Cases%22&wt=json&json.wrf=_prototypeJSONPCallback_38"; //bags
			}else if($subcat == Category::CAM_ACC_BATTERY){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Batteries%20%26%20Chargers%22&wt=json&json.wrf=_prototypeJSONPCallback_10"; //battery
			}else if($subcat == Category::CAM_ACC_FLASH_LIGHTS){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Flashes%20%26%20Lighting%22&wt=json&json.wrf=_prototypeJSONPCallback_66"; // flash and lighting
			}else if($subcat == Category::CAM_ACC_LENSEFILTER){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356677316883&fq=category%3A%22Lens%20Accessories%22&wt=json&json.wrf=_prototypeJSONPCallback_2";
			}else if($subcat == Category::CAM_ACC_LENSES){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356499583280&fq=category%3A%22Lenses%22&wt=json&json.wrf=_prototypeJSONPCallback_10"; //lenses
			}else if($subcat == Category::CAM_ACC_MEMORY_AND_STORAGE){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&facet=true&facet.field=oemname_facets%2Ccategory&defType=dismax&timestamp=1356597696131&qf=name_varchar%20oemname_int%20&wt=json&json.wrf=_prototypeJSONPCallback_13"; //memory & Storage
			}else if($subcat == Category::CAM_ACC_OTHER_ACC){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Accessories%22&wt=json&json.wrf=_prototypeJSONPCallback_6"; // acc, this is parent
			}else if($subcat == Category::CAM_ACC_SCREEN_PROTECTOR){
				return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=$query&json.nl=map&rows=24&fl=name_varchar%2Cimage_varchar%2Cproducts_id%2Cdescription_text&qf=name_varchar%20oemname_int%20&spellcheck=true&currentUrl=http%3A%2F%2Fcamera.zoomin.com%2Fsearch%2F%3Fq%3D$query&spellcheck.collate=true&facet=true&facet.field=category&defType=dismax&timestamp=1356597696127&fq=category%3A%22Screen%20Protectors%20%22&wt=json&json.wrf=_prototypeJSONPCallback_30"; //screen protectors
			}else if($subcat == Category::CAM_ACC_TRIPODS){
			}else{
				return '';
			}
		}else{
			return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=".$query."&json.nl=map&facet=true&facet.field=oemname_facets%2Ccategory&defType=dismax&timestamp=1355584673850&qf=name_varchar%20oemname_int%20&wt=json&json.wrf=_prototypeJSONPCallback_1";
		}
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/zoomin.png';
	}
	public function getData($html,$query,$category,$subcat){

		$data = array();
		$json = $this->jsonp_decode($html,true);
		$records = $json['response']['numFound'];
		if($records > 0){
			foreach($json['response']['docs'] as $item){
				$name = $item['name_varchar'];
				$id = $item['products_id'];
				$image = $json['response']['product_info'][$id]['image_url'];
				$url = $json['response']['product_info'][$id]['product_url'];
				$org_price = 0;
				$disc_price = $json['response']['product_info'][$id]['final_price'];
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());

			}
		}
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query,$category,$subcat);
		return $data;
	}

	public function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
		if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
			$jsonp = substr($jsonp, strpos($jsonp, '('));
		}
		return json_decode(trim($jsonp,'();'), $assoc);
	}
	public function getProductData($html,$price,$stock){
		phpQuery::newDocumentHTML($html);
		$price = pq('.price:first')->html();
		$offer = pq('.description-text')->html() + " + Zoomin Freebies";
		if(sizeof(pq('product-availability')->children('.available'))){
			$stock = 1;
		}else{
			$stock = -1;
		}
		$shipping_cost = pq('.freeShippingLabel')->html();
		$shipping_time = pq('.product-availability')->children('span')->html();

		$attr = array();
		$cat = '';
		foreach(pq('.breadcrumbs')->children('a') as $li){
			$cat .= pq($li)->html().',';
		}

		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => '',
				'cat' => $cat
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}