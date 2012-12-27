<?php
class Freekaamaal extends Parsingcoupon
{
	public $_code = 'Freekaamaal';
	
	public function getUrl()
	{
		return 'http://freekaamaal.com/discuss/';
	}
	
	public function getAllData($pagecount)
	{
		$count = 'Forum-discount-coupons?page='.$pagecount;
		$url = $this->getUrl().$count;
		$parser = new Parser();
		$html = $parser->getHtml($url);
		phpQuery::newDocumentHTML($html);
		$data = array();
		foreach(pq(".subject_new") as $items)
		{
			$id = pq($items)->attr("id");
			$href = $this->getUrl().pq($items)->attr("href");
			$text = pq($items)->text();
			$data[] = array(
					'id' => $id,
					'hrf' => $href,
					'text' => $text
					);
		}
		return $data;
	}
}