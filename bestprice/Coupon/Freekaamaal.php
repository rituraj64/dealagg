<?php
class Freekaamaal extends Parsingcoupon
{
	public $_code = 'Freekaamaal';

	public function getUrl()
	{
		return 'http://freekaamaal.com/discuss/';
	}

	public function updateCoupons($pagecount)
	{
		$return = array();
		$count = 'Forum-discount-coupons?page='.$pagecount;
		$url = $this->getUrl().$count;
		$parser = new Parser();
		$html = $parser->getHtml($url);
		phpQuery::newDocumentHTML($html);
		$data = array();
		$data['code'] = $this->_code;
		foreach(pq(".subject_new") as $items)
		{
			$text = pq($items)->text();
			$span = pq($items)->siblings("span")->text();
			$should = $this->shouldParse($text,$span);
			if($should['0'])
			{
				$id = pq($items)->attr("id");
				$href = $this->getUrl().pq($items)->attr("href");
				
				
				$cp = new CouponParse();
				$cp->uniq_id = $id;
				$data = $cp->read();
				if(!sizeof($data)){
					$cp->deal_url = $href;
					$cp->title = $text;
					$cp->desc = $span;
					$cp->code = $this->_code;
					$id = $cp->insert();
					$return[] = $id;
				}
			}
		}
		return $return;
	}
}