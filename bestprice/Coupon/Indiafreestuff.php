<?php
class Indiafreestuff extends Parsingcoupon
{
	public $_code = 'Indiafreestuff';

	public function getUrl()
	{
		return 'http://indiafreestuff.in/forum/index.php/forum/6-coupon-forum/page__prune_day__100__sort_by__Z-A__sort_key__last_post__topicfilter__all';
	}

	public function updateCoupons($pagecount)
	{
		$return = array();
		$append = '';
		if($pagecount>1)
		{
			$append = "__st__".(($pagecount-1)*30);
		}
		$url = $this->getUrl().$append;
		$parser = new Parser();
		$html = $parser->getHtml($url);
		phpQuery::newDocumentHTML($html);
		$data = array();
		$data['code'] = $this->_code;
		foreach (pq(".col_f_content") as $item)
		{
			$anchor = pq($item)->find("a");
			$title = pq($anchor)->attr("title");
			$span = pq($anchor)->children("span")->text();
			$should = $this->shouldParse($title,$span);
			if($should[0])
			{
				$href = pq($anchor)->attr("href");
				$id = pq($anchor)->attr("id");


				$cp = new CouponParse();
				$cp->uniq_id = $id;
				$data = $cp->read();
				if(!sizeof($data)){
					$cp->deal_url = $href;
					$cp->title = $title;
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