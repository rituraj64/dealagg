<?php
require_once dirname(__FILE__).'/../facebook/src/facebook.php';
require_once dirname(__FILE__).'/../facebook/src/base_facebook.php';
require_once dirname(__FILE__).'/../model/FacebookParse.php';
class FacebookSites extends Parsingcoupon{
	public $_code = 'FacebookSites';

	const APP_ID = '467986553238213';
	const APP_SECREY = 'a95428b215f24ecf135a94f3c2fc61ad';

	public function getUrl(){
		return false;
	}
	public function updateCoupons($html){

		$sites = $this->getWebsites();


		$return = array();


		$facebook = new Facebook(array(
				'appId'  => self::APP_ID,
				'secret' => self::APP_SECREY,
		));

		foreach($sites as $site){
			require_once dirname(__FILE__).'/../Sites/'.$site.'.php';
			$siteObj = new $site;
			$facebookURL = $siteObj->getFacebookUrl();
			if($facebookURL && !empty($facebookURL)){
				$facebookURL = str_replace('http://www.facebook.com/','',$facebookURL);
				$facebookURL = str_replace('facebook.com/','',$facebookURL);
				$facebookURL = str_replace('http://facebook.com/','',$facebookURL);
				$facebookURL = str_replace('www.facebook.com/','',$facebookURL);
					
				$fb_id = 0;
				$fbparse = new FacebookParse();
				$fbparse->website = $site;
				$data = $fbparse->read();
				$last_id = 0;
				if(sizeof($data) > 0){
					$last_id = $data[0]['last_id'];
					$fbparse->smartAssign($data[0]);
				}

				$first_fb_id = 0;
				$last_id_found = 0;
				$attempt = 0;
				$fb_graph_url = $facebookURL.'/posts';

				while($last_id_found != 1 && $attempt < 5){

					try{
						$result = $facebook->api($fb_graph_url);
					}catch(Exception $e){
						echo $e->getMessage().'xxx'.$fb_graph_url;die;
					}
					if(!isset($result['data'])){
						echo '<pre>';
						print_r($result);
						echo $fb_graph_url;
					}
					foreach($result['data'] as $data){
						$fb_id = $data['id'];
						if($first_fb_id == 0){
							$first_fb_id = $fb_id;
						}
						if($fb_id == $last_id){
							$last_id_found = 1;
							break;
						}
						if(isset($data['message'])){
							$message = $data['message'];
						}else{
							$message = '';
						}
						if(isset($data['link'])){
							$link = $data['link'];
						}else{
							$link = '';
						}
						if(isset($data['picture'])){
							$picture = $data['picture'];
						}else{
							$picture = '';
						}
						//echo  $message.'<br/>';

						if($this->isCoupon($message)){
							$cp = new CouponParse();
							$cp->uniq_id = $fb_id;
							$data = $cp->read();
							if(!sizeof($data)){
								$cp->deal_url = $link;
								$cp->title = $message;
								$cp->desc = $picture;
								$cp->code = $this->_code.' - '.$site;
								$id = $cp->insert();
								$return[] = $id;
							}
						}


					}
					$attempt++;
					if(isset($result['paging']) && isset($result['paging']['next'])){
						$fb_graph_url = $result['paging']['next'];
						$fb_graph_url=str_replace('https://graph.facebook.com/','',$fb_graph_url);
					}else{
						$last_id_found = 1;
					}

				}
				$fbparse->last_id = $first_fb_id;
				if(isset($fbparse->id) && $fbparse->id > 0){
					$fbparse->update(array('last_id'=>$fbparse->last_id),array('id'=>$fbparse->id));
				}else{
					$fbparse->insert();
				}
			}
		}
		return $return;
	}
}