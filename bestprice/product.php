<?php
require_once 'Parsing.php';
$site = urldecode($_REQUEST['website']);
$url = urldecode($_REQUEST['url']);
$price = urldecode($_REQUEST['price']);
$stock = urldecode($_REQUEST['stock']);

require_once 'Sites/'.$site.'.php';
$siteObj = new $site;

$parser = new Parser();
try{
	$html = $parser->getHtml($url);

	$data = $siteObj->getProductData($html,$price,$stock);
}catch(Exception $e){
	$data = array();
	$data['website'] = $site;
	$data['error'] = $e->getMessage();
}

if(isset($_GET['callback'])){
	echo $_GET['callback'] . '(' . json_encode($data) . ')';
}else{
	echo json_encode($data);
}