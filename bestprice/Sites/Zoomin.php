<?php
class Zoomin extends Parsing{
	public $_code = 'Zoomin';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::MOBILE);
	}

	public function getWebsiteUrl(){
		return 'http://camera.zoomin.com';
	}
	public function getSearchURL($query,$category = false){
		return "http://camera.zoomin.com/index.php/search/ajax/query?r=select&q=".$query."&json.nl=map&facet=true&facet.field=oemname_facets%2Ccategory&defType=dismax&timestamp=1355584673850&qf=name_varchar%20oemname_int%20&wt=json&json.wrf=_prototypeJSONPCallback_1";
	}
	public function getLogo(){
		return 'http://'.$_SERVER["SERVER_NAME"].'/scrapping/img/zoomin.png';
	}
	public function getData($html,$query,$category){

		$data = array();
		$json = $this->jsonp_decode($html,true);
		$records = $json['response']['numFound'];
		if($records > 0){
			foreach($json['response']['docs'] as $item){
				$name = $item['name_varchar'];
				$id = $item['products_id'];
				$image = $json['response']['product_info'][$id]['image_url'];
				$url = $this->getWebsiteUrl().$item['url_path_varchar'];
				$org_price = 0;
				$disc_price = $item['price_decimal'];
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());

			}
		}
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query);
		return $data;
	}

	public function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
		if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
			$jsonp = substr($jsonp, strpos($jsonp, '('));
		}
		return json_decode(trim($jsonp,'();'), $assoc);
	}
}