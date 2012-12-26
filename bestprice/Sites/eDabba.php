<?php
class eDabba extends Parsing{
	public $_code = 'eDabba';

	public function getAllowedCategory(){
		return array(Category::MOBILE,Category::CAMERA,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.edabba.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::MOBILE){
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5860&f[1]=im_taxonomy_catalog:5921";
		}else if($category == Category::MOBILE_ACC){
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5860&f[1]=im_taxonomy_catalog:5922";
		}else if($category == Category::CAMERA){
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5917"; //digial camera & slr
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5918"; //camcorders
		}else if($category == Category::CAMERA_ACC){
			return "http://www.edabba.com/search/site/$query?f[0]=im_taxonomy_catalog:5861&f[1]=im_taxonomy_catalog:5919";
		}
		return "http://www.edabba.com/search/site/$query";
	}
	public function getLogo(){
		return 'http://d43w3023ueaau.cloudfront.net/sites/default/files/images/logo.png';
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.products-li')) > 0){
			foreach(pq('.products-li') as $div){
				$image = pq($div)->children('.mini-node')->children('.field-image')->children('a')->html();
				$url = pq($div)->children('.mini-node')->children('.field-image')->children('a')->attr('href');
				$name = pq($div)->children('.mini-node')->children('.node-title')->children('a')->html();
				if(sizeof(pq($div)->children('.mini-node')->children('.offer-price')->children('.uc-price'))){
					$disc_price =pq($div)->children('.mini-node')->children('.offer-price')->children('.uc-price')->html();
				}else{
					$disc_price = pq($div)->children('.mini-node')->children('.price:first')->children('span')->html();
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
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}