<?php
require_once dirname(__FILE__).'/../model/CouponParse.php';
class CouponDunia extends Parsingcoupon{
	public $_code = 'CouponDunia';

	public function getUrl()
	{
		return 'http://www.coupondunia.in/stores';
	}
	public function updateCoupons($html){
		
		$return = array();
		
		$p = new Parsing();
		$htmls = array();

		$parser = new Parser();
		$sites = $p->getWebsites();
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('#storeCollection')->children('li') as $div){
			$href = pq($div)->children('a')->attr('href');
			foreach($sites as $site){
				if(strpos(strtolower($href),strtolower($site)) !== false){
					$html = $parser->getHtml($href);
					$htmls[$href] = $html;
				}
			}
			if(sizeof($htmls)){
				//break;
			}
		}
		foreach($htmls as $href => $html){
			phpQuery::newDocumentHTML($html);
			if(sizeof(pq('.coupon'))){
				foreach(pq('.coupon') as $div){
					$id = pq($div)->attr('id');
					
					$nid = $this->removeAlpha($id,false);
					
					$crux = pq($div)->find('.crux:first');
					$title = pq($crux)->children('a:first')->html();
					$details = pq($div)->find('.detail:first')->children('p:first')->html();
					$coupon_code = '';
					$type = 'CODE';
					$deal_url = '';
					if(sizeof(pq($crux)->children('a.dealButton'))){
						$type = 'LINK';
						$deal_url = pq($crux)->children('a.dealButton')->attr('href');;
					}else{
						$coupon_code = pq($crux)->children('div.tooltip')->children('strong')->attr('code');
					}
					$website_url = '';
					if(pq($div)->find('.specialLink')){
						$website_url = pq($div)->find('.specialLink')->children('a')->attr('href');
					}
					
					$success = pq($div)->find('.couponstatcontainer:first')->find('em:first')->html();

					$cp = new CouponParse();
					$cp->uniq_id = $id;

					$data = $cp->read();
					if(!sizeof($data)){
						$cp->coupon_code = $coupon_code;
						$cp->website_landing = $website_url;
						$cp->deal_url = $deal_url;
						$cp->title = $title;
						$cp->desc = $details;
						$cp->coupon_type = $type;
						$cp->website = $href;
						$cp->success = $success;
						$cp->code = $this->_code;
						$id = $cp->insert();
						$return[] = $id;
					}
				}
			}else{
				
			}
		}
		return $return;
	}

}