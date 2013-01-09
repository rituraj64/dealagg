<?php
$site = $_REQUEST['website'];
$url = urldecode($_REQUEST['url']);
$price = $_REQUEST['price'];
$stock = $_REQUEST['stock'];

require_once 'Sites/'.$site.'.php';
$siteObj = new $site;

$parser = new Parser();
$html = $parser->getHtml($url);

$data = $siteObj->getProductData($html,$price,$stock);
print_r($data);