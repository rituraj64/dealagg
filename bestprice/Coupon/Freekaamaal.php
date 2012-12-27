<?php
class Freekaamaal extends Parsingcoupon
{
	public $_code = 'Freekaamaal';
	
	public function getUrl()
	{
		return 'http://freekaamaal.com/discuss/';
	}
	
	public function shouldParse($text,$span)
	{
		$text = strtolower($text);
		$span = strtolower($span);
		$sites = $this->getWebsites();
		$sites = array_map('strtolower', $sites);
		foreach($sites as $site)
		{
			/* echo "***site".$site;
			echo "***text".$text;
			echo "***span".$span; */
			if(!strpos($span, $site))
			{
				if(strpos($text, $site) || strpos($text, $site)===0)
					return TRUE;
			}
			else return TRUE;
		}
		return FALSE;
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
			$text = pq($items)->text();
			$span = pq($items)->siblings("span")->text();
			$should = $this->shouldParse($text,$span);
			if($should)
			{
				$id = pq($items)->attr("id");
				$href = $this->getUrl().pq($items)->attr("href");
				$data[] = array(
						'id' => $id,
						'hrf' => $href,
						'text' => $text,
						'span' => $span
						);
			}
		}
		return $data;
	}
}