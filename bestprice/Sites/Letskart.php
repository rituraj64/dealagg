<?php
class Letskart extends Parsing{

	public $_code = 'Letskart';
	
	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC);
	}
	
	public function getWebsiteUrl(){
		return 'http://www.letskart.com/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://www.letskart.com/index.php?route=product/search&filter_name=".$query;
	}
	public function getLogo(){
		return "http://www.letskart.com/image/data/logo2.png";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.listcontainer'))){
			foreach(pq('.listcontainer') as $div){
				$image = pq($div)->find('.listproduct_image')->children('a')->html();
				$url = pq($div)->find('.listproduct_image')->children('a')->attr('href');
				$name = pq($div)->find('.listproduct_title')->children('a')->html();
				$disc_price = pq($div)->find('.listproduct_price')->children('span')->html();
				$shipping = pq($div)->find('.listproduct_description')->html();
				$offer = '' ;
				$stock = 0;
				$s = pq($div)->find('.listproduct_instock')->html();
				if( strpos(strtolower($s), 'out of stock') !== false ){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$cat ='';
				$author = pq($div)->find('.author')->html();
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