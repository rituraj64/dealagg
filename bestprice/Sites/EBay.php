<?php
class EBay extends Parsing{
	public $_code = 'eBay';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'http://read.ebay.in/';
	}
	public function getLogo(){
		return Parser::SITE_URL.'img/ebay.png';
	}
	public function getSearchURL($query,$category = false,$subcat){
		if($category == Category::BOOKS){
			return "http://read.ebay.in/decksearchresults?frm=1&q=spell:$query&rows=10&key=$query&catid=267";
		}
	}
	public function getData($html,$query,$category,$subcat=false){
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('table')->find('tr') as $div){
			$i = 0;
			$stock = 0;
			$author = '';
			if(sizeof(pq($div)->children('td')) == 3){
				foreach(pq($div)->children('td') as $td){
					if($i == 0){
						$image = pq($td)->find('a')->html();
						$url = pq($td)->find('a')->attr('href');
					}else if($i == 1){
						$name = pq($td)->find('a')->html();
						$name = $this->clearHtml($name);
						if(strpos($name,'by') !== false){
							$name = explode("by", $name);
							$author = $name[1];
							$name = $name[0];
						}
					}else if($i == 2){
						$disc_price = pq($td)->find('tr:first')->find('td:last')->html();
						$offer = '';
						$shipping = pq($td)->find('tr:last')->html();
					}
					$i++;
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
						'cat' => Category::BOOKS
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
		$data2 = $this->cleanData($data2,$query);
		$data2 = $this->bestMatchData($data2,$query,$category,$subcat);
		return $data2;
	}
}