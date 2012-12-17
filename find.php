<?php
require_once 'Parsing.php';
if(isset($_REQUEST['q'])){
	$query = urlencode($_REQUEST['q']);
	$parsing = new Parsing();
	$data = array();
	$ajaxParseSite = array();
	$errorSites = array();
	$emptySites = array();
	$delay = true;
	$sites = $parsing->getWebsites();
	
	if(isset($_REQUEST['site'])){
		$delay = false;
		$site = urldecode($_REQUEST['site']);
		$sites = array($site);
	}
	
	foreach($sites as $site){
		require_once 'Sites/'.$site.'.php';
		$siteObj = new $site;
		try{
			$data1 = $siteObj->getPriceData($query,false,$delay);
			if(!$data1){
				$ajaxParseSite[] = $site;
			}else{
				if(empty($data)){
					$data = $data1;
				}else{
					if(empty($data1)){
						$emptySites[] = array('site'=>$site);
					}else{
						$data = array_merge($data,$data1);
					}
				}
			}
		}catch(Exception $e){
			$errorSites[] = array('site'=>$site,'message'=>$e->getMessage());
		}
		continue;
	}
	$return = array('ajax_parse'=>$ajaxParseSite,'data'=>$data,'error_sites'=>$errorSites,'empty_sites'=>$emptySites);
	echo json_encode($return);
}
?>