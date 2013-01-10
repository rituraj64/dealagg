<?php
class FutureBazar extends Parsing{

	public $_code = 'FutureBazar';

	public function getWebsiteUrl(){
		return 'http://www.futurebazaar.com/';
		//return 'http://127.0.0.1/deals.htm';
	}

	public function getLogo(){
		return "http://www.futurebazaar.com/media/images/futurebazaar-logo.png";
	}

	public function getAllData()
	{
		$url = $this->getWebsiteUrl();
		$parser = new Parser();
		$html = $parser->getHtml($url);
		phpQuery::newDocumentHTML($html);
		$data = array();
		$data['logo'] = $this->getLogo();
		$data['sitename']="FutureBazaar.com";
		foreach (pq(".greed_inner") as $item)
		{
			$class_Discount_bg = pq($item)->find(".item_img");
			$href = pq($item)->find("a")->attr("href");
			$href="http://www.futurebazaar.com".$href;
			$off_percent = trim(pq($class_Discount_bg)->find(".home_sprite>span>strong")->text());
			$img_src = pq($class_Discount_bg)->find(".imgbottom>img")->attr("src");
			$img_src="http://www.futurebazaar.com".$img_src;
			$price = trim(pq($item)->find(".offer_price")->text());
			$name = trim(pq($item)->find("h3>a")->text());
		//	$time_left = pq($item)->find(".countdown_row")->text();
			$data[] = array(
				'name'		=>$name,
				'href'		=>$href,
				'price'		=>$price,
				'image'		=>$img_src,
				'off'		=>$off_percent,
			//	'time_left'	=>$time_left
			);
		}
		return $data;
	}
}