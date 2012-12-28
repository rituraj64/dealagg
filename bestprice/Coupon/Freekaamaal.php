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
				$data[] = array(
						'id' => $id,
						'text' => $text,
						'href' => $href,
						'span' => $should['1']
						);
			}
		}
		return $data;
	}
}