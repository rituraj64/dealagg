<?php
require_once 'Parsingcoupon.php';

$parsing = new Parsingcoupon();
$sites = $parsing->getCouponWebsites();

foreach ($sites as $site)
{
	require_once 'Coupon/'.$site.'.php';
	$siteObj = new $site;
	try
	{
		$pagecount = 1;
		$siteData[] = $siteObj->getAllData($pagecount);
	}
	catch(Exception $e)
	{
		echo"<pre>";
		print_r($e);
		echo"</pre>";
	}
	
	echo"<pre>";
	print_r($siteData);
	echo"</pre>";
}
