<?php
require_once 'model/Product.php';
require_once 'Parsing.php';
$return = array();
if(isset($_REQUEST['term'])){
	$term = $_REQUEST['term'];
	$product = new Product();
	//$sql = "SELECT *,MATCH(full_name) AGAINST ('".mysql_escape_string($term)."') AS score FROM product WHERE MATCH(full_name) AGAINST('".mysql_escape_string($term)."') ORDER BY score DESC,prod_order asc";
	$sql = "select * from product where full_name like '%".mysql_escape_string($term)."%' ORDER BY prod_order asc";
	$data = $product->query($sql);
	$return['data'] = array();
	while($row = mysql_fetch_assoc($data)){
		$return['data'][] = array('name'=>$row['full_name'],'brand'=>$row['brand'],'img'=>Parser::SITE_URL.'img/fb.png','id'=>$row['id'].'#'.$row['category_id']);
	}
}else{
	$return['data'] = array();
}
echo json_encode($return);