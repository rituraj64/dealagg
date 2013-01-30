<?php

ini_set('session.cookie_domain', '.pricegenie.in');
session_set_cookie_params(0, '/', '.pricegenie.in');
session_start();
if(isset($_REQUEST[session_name()]) && $_REQUEST[session_name()] != session_id()){
	$request_id = $_REQUEST[session_name()];
	session_id($request_id);
}

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