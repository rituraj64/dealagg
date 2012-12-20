<?php
require_once 'Parsing.php';

$parsing = new Parsing();//creating object for parsing class
$sites = $parsing->getWebsites();//get list of websits to be scraped
foreach ($sites as $site)
{
	require_once 'Sites/'.$site.'.php';
	$siteObj = new $site;
	try
	{
		$siteData = $siteObj->getAllData();//get all the avilable data
	}
	catch(Exception $e)
	{
		echo"<pre>";
		print_r($e);
		echo"</pre>";
	}
}
echo"<pre>";
print_r($siteData);
echo"</pre>";