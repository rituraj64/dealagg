<?php
class Simplebooks extends Parsing{
	public $_code = 'Simplebooks';
	public function getFacebookUrl(){
		return 'http://www.facebook.com/simplybooks';
	}
	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://www.simplybooks.in/';
	}
	public function getSearchURL($query,$category = false,$subcat=false){
		return "http://www.simplybooks.in/search.php?search_keyword=$query&x=0&y=0";
	}
	public function getLogo(){
		return "http://www.simplybooks.in/images-new/logo.png";
	}
	public function getData($html,$query,$category,$subcat){
		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('.bookbox_tube'))){
			foreach(pq('.bookbox_tube') as $div){
				$image = pq($div)->find('.center_block2_pic')->children('a')->html();
				$url = pq($div)->find('.center_block2_pic')->children('a')->attr('href');
				$name = pq($div)->find('.heading_box')->find('a')->html();
				$disc_price = pq($div)->find('.product_price')->children('.rupee')->html();
				$shipping = '';
				$offer = '' ;
				$stock = 0;
				$s = pq($div)->find('.buy-btn')->find('.notifyme');
				if(sizeof($s)){
					$stock = -1;
				}else{
					$stock = 1;
				}
				$cat ='';
				$author = pq($div)->find('.book_head_tube')->children('.by');
				foreach($author as $a){
					$author = pq($a)->html();
					break;
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