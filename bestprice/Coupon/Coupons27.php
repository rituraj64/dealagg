<?php
require_once dirname(__FILE__).'/../model/CouponParse.php';
class Coupons27 extends Parsingcoupon{
	public $_code = 'Coupons27';

	public function getUrl()
	{
		return 'http://www.27coupons.com/stores/';
	}
	public function updateCoupons($html){

		$return = array();

		$p = new Parsing();
		$htmls = array();

		$parser = new Parser();
		$sites = $p->getWebsites();
		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('ul.stores') as $ul){
			foreach(pq($ul)->children('li') as $div){
				$href = pq($div)->children('a')->attr('href');
				foreach($sites as $site){
					if(strpos(strtolower($href),strtolower($site)) !== false){
						$html = $parser->getHtml($href);
						$htmls[$href] = $html;
					}
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

					$id = $this->removeAlpha($id,false);

					$crux = pq($div)->find('.item-panel:first');
					$title = pq($crux)->children('h2:first')->children('a')->html();
					$details = pq($crux)->find('p.desc')->html();
					$coupon_code = '';
					$type = 'CODE';
					$deal_url = '';
					$coupon_code = pq($crux)->children('div.couponAndTip')->children('div.link-holder')->children('a')->attr('data-rel');
					if($coupon_code == 'Click to Redeem'){
						$type == 'LINK';
						$coupon_code = '';
						$deal_url = pq($crux)->children('div.couponAndTip')->children('div.link-holder')->children('a')->attr('href');
					}else{
						$deal_url = pq($crux)->find('a.more:first')->attr('href');
					}

					$website_url = '';
						

					$success = pq($div)->find('.stripe-badge:first')->find('.percent')->html();

					$cp = new CouponParse();
					$cp->uniq_id = $id;

					$data = $cp->read();
					if(!sizeof($data)){
						$cp->website_landing = $website_url;
						$cp->deal_url = $deal_url;
						$cp->coupon_code = $coupon_code;
						$cp->title = $title;
						$cp->desc = $details;
						$cp->coupon_type = $type;
						$cp->website = $href;
						$cp->success = $success;
						$cp->code = $this->_code;
						$id = $cp->insert();
						$return[] = $title. '     '.$deal_url;
					}
				}
			}else{

			}
		}
		return $return;
	}

}