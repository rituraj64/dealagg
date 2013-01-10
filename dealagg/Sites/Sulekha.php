<?php
class Sulekha extends Parsing{

	public $_code = 'Sulekha';

	public function getWebsiteUrl(){
		return 'http://deals.sulekha.com/';
		//return 'http://127.0.0.1/deals.htm';
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
		$data['logo'] = $this->getLogo();
		$data['sitename']="Sulekha.com";
		foreach (pq(".box") as $item)
		{
			$class_Discount_bg = pq($item)->find(".dealimgst");
			$href = pq($class_Discount_bg)->find("a")->attr("href");
			$href='http://deals.sulekha.com'.$href;
			$actual_price = trim(pq($item)->find(".dlpristrk")->text());
			$actual_price= (int)preg_replace( '~\D~', '', $actual_price );
			
			$img_src = pq($class_Discount_bg)->find("img")->attr("src");
			$price = trim(pq($item)->find(".hgtlgtorg")->text());
			$price=(int)preg_replace( '~\D~', '', $price );
			$off_percent=($actual_price)-($price);
			$off_percent=number_format($off_percent)."/-";
			$price=number_format($price)."/-";
			$name = trim(pq($item)->find(".deallstit>a")->text());
			//$time_left = pq($item)->find(".countdown_row")->text();
			$data[] = array(
				'name'		=>$name,
				'href'		=>$href,
				'price'		=>'Rs.'.$price,
				'image'		=>$img_src,
				'off'		=>'Rs.'.$off_percent,
				//'time_left'	=>$time_left
			);
		}
		
		return $data;
	}
}