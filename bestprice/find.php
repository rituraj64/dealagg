<?php
ini_set('session.cookie_domain', '.pricegenie.in');
session_set_cookie_params(0, '/', '.pricegenie.in');
session_start();
date_default_timezone_set('Asia/Calcutta');
require_once 'Parsing.php';

if(isset($_REQUEST['q'])){
	$query = trim(urlencode($_REQUEST['q']));
	$query2 = trim(urldecode($_REQUEST['q']));
	$subcat = $_REQUEST['subcat'];

	$cat = false;
	if(isset($_REQUEST['cat'])){
		$cat = $_REQUEST['cat'];
		$_SESSION['prev_cat'] = $cat;
	}
	$cache = 1;
	$max = 0;
	$parsing = new Parsing();
	$data = array();
	$ajaxParseSite = array();
	$errorSites = array();
	$emptySites = array();
	$delay = true;
	$sites = $parsing->getWebsites();

	if(isset($_REQUEST['cache'])){
		$cache = $_REQUEST['cache'];
	}

	$query_id = false;
	if(isset($_REQUEST['site'])){
		$delay = false;
		$site = urldecode($_REQUEST['site']);
		$sites = array($site);
		$query_id = $_REQUEST['query_id'];
	}else{
		$query_id = md5($query2.time());
		require_once 'model/Search.php';
		$searchModel = new Search();
		$searchModel->setQuery($query2);
		$searchModel->setCategory($cat);
		$searchModel->setSubcat($subcat);
		$searchModel->query_id = $query_id;
		$searchModel->created_at = time();
		$searchModel->setHits(0);
		$searchModel->insert();
	}
	$untrusted = array();

	//	$sites = array('Flipkart');
	foreach($sites as $site){
		require_once 'Sites/'.$site.'.php';
		$siteObj = new $site;
		if($siteObj->allowCategory($cat)){
			$trust = $siteObj->isTrusted($cat);
			if(isset($_REQUEST['site'])){
				$trust = true;
			}
			if(isset($_REQUEST['query_id'])){
				$trust = true;
			}
			if($trust){
				try{
					$siteObj->setQueryId($query_id);
					$data1 = $siteObj->getPriceData($query,$cat,$subcat,$delay,$cache);
					$resultTime = $siteObj->getResultTime();
					if($resultTime > $max){
						$max = $resultTime;
					}
					if(!$data1 && $delay){
						$ajaxParseSite[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
					}else{
						$data2 = array();
						$count = 0;
						foreach($data1 as $row){
							$name = $row['name'];
							$row['logo'] = $siteObj->getLogo();
							$row['pro'] = $siteObj->hasProductdata();
							$row['searchurl'] = $siteObj->getSearchURL($query,$cat,$subcat);

							$data2[] = $row;
							$count++;
						}
						$data1 = array();
						if(empty($data2)){
							$emptySites[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
						}else{
							if(empty($data)){
								$data = $data2;
							}else{
								$data = array_merge($data,$data2);
							}
						}
					}
				}catch(Exception $e){
					$errorSites[] = array('site'=>$site,'message'=>$e->getMessage(),'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
				}
			}else{
				$untrusted[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
			}
		}
	}
	$site = '';
	if(isset($_REQUEST['site'])){
		$site = $_REQUEST['site'];
	}
	$return = array('untrusted'=>$untrusted,'query_id'=>$query_id,'ajax_parse'=>$ajaxParseSite,'data'=>$data,'result_time'=>date('d/m/y h:i a',$max),'result_number_time'=>$max,'error_sites'=>$errorSites,'empty_sites'=>$emptySites,'site'=>$site);
	
	if(!isset($_REQUEST['silent'])){
		if(isset($_GET['callback'])){
			echo $_GET['callback'] . '(' . json_encode($return) . ')';
		}else{
			echo json_encode($return);
		}
	}
}
?>