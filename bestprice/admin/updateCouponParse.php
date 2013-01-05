
<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

$user = new coupon_parse();

if(isset($_REQUEST['content']))
{
	$ID=$_REQUEST['Id'];
	$read=$_REQUEST['content'];

	$user->sql_tracking=true;
	$set=array("read"=>$read);
	$where = array("id"=>$ID);
	$user->update($set,$where);
} 

?>
