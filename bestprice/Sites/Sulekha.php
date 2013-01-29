<?php
class Sulekha extends Parsing{
	public $_code = 'Sulekha';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/Sulekhadotcom';
	}
	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS);
	}

	public function getWebsiteUrl(){
		return 'http://deals.sulekha.com/';
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/sulekha.png';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		$query2 = urldecode($query);
		$query2 = preg_replace("![^a-z0-9]+!i", "-", $query2);
		return "http://deals.sulekha.com/".$query2."_search?q=".$query;
	}
	public function getData($html,$query,$category,$subcat){

		//this redirects to category page many times so write code for that as well.


		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.productlistout')->children('.box') as $div){
			if(sizeof(pq($div)->find('.dealimgst'))){
				$image = pq($div)->find('.dealimgst')->find("a")->html();
				$url = pq($div)->find('.dealimgst')->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.deallstit')->find('a')->html());
				$disc_price = strip_tags(pq($div)->find('.priceglg')->find('.hgtlgtorg')->html());
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
	
public function hasProductdata(){
		return true;
	}
	public function getProductData($html,$price,$stock){
		phpQuery::newDocumentHTML($html);
		foreach(pq('.delproprgt')->find('span') as $span){
			if(pq($span)->attr('itemprop') == 'price'){
				$price = pq($span)->html();
				break;
			}
		}
		//$offer = pq('.bordottpbt')->children('.extxt')->html();
		$stock = pq('.otstkbt')->html();
		if($stock == 'OUT OF STOCK'){
			$stock = -1;
		}else{
			$stock = 1;
		}
		$shipping_cost = pq('.norhgtx')->html();
		$shipping_time = pq('.stoshptx')->html();

		$attr = array();
		$cat = '';
		foreach(pq('.breadcrumbnw')->children('ul:first')->children('li') as $li){
			$cat .= pq($li)->children('span')->children('a')->children('span')->html().',';
		}

		$warrenty = '';

		foreach(pq('.delkeysmlt')->children('li') as $li){
			if(empty($warrenty)){
				$warrenty .= pq($li)->html();
			}else{
				$warrenty .= ' + ' . pq($li)->html();
			}
		}
       $offer =$warrenty;
		$data = array(
				'price' => $price,
				'offer' => $offer,
				'stock' => $stock,
				'shipping_cost' => $shipping_cost,
				'shipping_time' => $shipping_time,
				'attr' => $attr,
				'author' => '',
				'cat' => $cat,
				'warrenty' => ''
		);

		$data = $this->cleanProductData($data);
		return $data;
	}
}