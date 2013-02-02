<?php
$return = array();
if(isset($_REQUEST['term'])){
	$term = $_REQUEST['term'];
	$sql = "SELECT *,MATCH(full_name) AGAINST ('".mysql_real_escape_string($term)."') AS score FROM product WHERE MATCH(full_name) AGAINST('".mysql_real_escape_string($term)."') ORDER BY score DESC,prod_order asc";
	require_once 'model/Product.php';
	$product = new Product();
	$data = $product->query($sql);
	$data = mysql_fetch_assoc($data);
	if(isset($data['id'])){
		$data = array($data);
	}
	$return['data'] = array();
	foreach($data as $row){
		$return['data'][] = array('name'=>$row['full_name'],'brand'=>$row['brand'],'category_id'=>$row['category'],'img'=>Parser::SITE_URL.'img/fb.png','id'=>$row['id']);
	}
}else{
	$return['data'] = array();
}
echo json_enode($return);