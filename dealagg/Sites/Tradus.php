<?php
class Tradus extends Parsing{
	public $_code = 'Tradus';

	public function getWebsiteUrl(){
		//return 'http://www.tradus.com/deals/';
		return 'http://127.0.0.1/deals.htm';
	}
	
	public function getLogo(){
		return "http://www.tradus.com/sites/all/themes/basic/images/ci_images/tradus_logo/tradus_new_logo.jpg";
	}
	
	public function getAllData()
	{
		$url = $this->getWebsiteUrl();
		$parser = new Parser();
		$html = $parser->getHtml($url);
		phpQuery::newDocumentHTML($html);
		$data = array();
		foreach (pq(".cartList") as $item)
		{
			$class_Discount_bg = pq($item)->find(".Discount_bg");
			$href = pq($class_Discount_bg)->find("a")->attr("href");
			$off_percent = trim(pq($class_Discount_bg)->find(".offDiv_20>span")->text());
			$img_src = pq($class_Discount_bg)->find(".toshiba>img")->attr("src");
			$price = trim(pq($item)->find(".signDiv2")->text());
			$name = trim(pq($item)->find(".DiscountDiv>a")->text());
			$time_left = pq($item)->find(".countdown_row")->text();
			$data[] = array(
				'name'		=>$name,
				'href'		=>$href,
				'price'		=>$price,
				'image'		=>$img_src,
				'off'		=>$off_percent,
				'time_left'	=>$time_left
			);
		}
		return $data;
	}
}