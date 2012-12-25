<?php
class Infibeam extends Parsing{
	public $_code = 'Infibeam';

	public function getAllowedCategory(){
		return array(Category::BOOKS,Category::MOBILE,Category::MOBILE_ACC);
	}

	public function getWebsiteUrl(){
		return 'http://www.infibeam.com';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://www.infibeam.com/Books/search?q=".$query;
		}else if($category == Category::MOBILE){
			return "http://www.infibeam.com/Mobiles/search?q=".$query;
		}else if($category == Category::MOBILE_ACC){
			return "http://www.infibeam.com/Mobile_Accessories/search?q=$query";
		}else{
			return "http://www.infibeam.com/search?q=".$query;
		}
	}
	public function getLogo(){
		return "http://www.infibeam.com/assets/skins/common/images/logo.png";
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		if(sizeof(pq('div.boxinner')) > 0){
			foreach(pq('div.boxinner') as $div){
				$cat = pq($div)->children('a:first')->html();
				$cat = $this->removeNum($this->clearHtml($cat));
				foreach(pq($div)->find('ul.srch_result') as $div){
					foreach(pq($div)->find('li') as $div){
						$image = pq($div)->find('a')->html();
						$url = pq($div)->find('a')->attr('href');
						$name = strip_tags(pq($div)->find('.title')->html());
						$disc_price = pq($div)->find('.price')->find('.normal')->html();
						$org_price = pq($div)->find('.price')->find('.scratch ')->html();
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
								'cat' => $cat
						);
					}
				}
			}
		}else if(sizeof(pq('ul.search_result')->children('li')) > 0){
			foreach(pq('ul.search_result')->children('li') as $div){
				$image = pq($div)->find('.img')->find('a')->html();
				$url = pq($div)->find('.img')->find('a')->attr('href');
				$name = pq($div)->find('.title')->children('h2')->html();
				$disc_price = pq($div)->find('.price')->find('b')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				foreach(pq($div)->find('span') as $span){
					$html = pq($span)->html();
					$html = $this->clearHtml($html);
					if(strpos($html, 'Ships') !== false){
						$shipping = $html;
						if(strpos($html, '.') !== false){
							$shipping = substr($html, strpos($html, '.') + 1,strlen($html));
						}
					}
					if(strpos($html, 'Out Of Stock') !== false){
						$stock = -1;
					}else{
						$stock = 1;
					}
				}
				$author = '';
				if($category == Category::BOOKS){
					$author = pq($div)->find('.title')->children('a')->html();
				}
				$cat ='';
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
		}else if(pq('ul.srch_result')->children('li')){
			foreach(pq('ul.srch_result')->children('li') as $div){
				$url = pq($div)->children('a:first')->attr('href');
				$name = pq($div)->children('a:first')->children('.title')->html();
				$disc_price = pq($div)->children('.price')->children('.normal')->html();
				$offer = '';
				$shipping = '';
				$stock = 0;
				$author = '';
				pq($div)->children('a:first')->children()->remove('span');
				$image = pq($div)->children('a:first')->html();
				$cat = pq('#resultsPane')->find('h1:first')->html();
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
			if(strpos($img, 'http') === false){
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		$data2 = $this->cleanData($data2, $query);
		$data2 = $this->bestMatchData($data2, $query,$category);
		return $data2;
	}
}