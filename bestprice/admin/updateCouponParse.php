<html>
<head>
<script type="text/javascript" src="../js/jQuery.js"></script>
<script>
	$(document).ready(function(){

		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");
		
		$(".read_status").change(function(){
			
			var id=$(this).parent("td").parent("tr").children("td:first-child").html();
			var abc=$(this);
			$.ajax({
		        url: 'updateCouponParse.php?Id='+id,
		        data: 'content=' + this.value,
		        cache: false,
		        success:function(){
					abc.parent("td").parent("tr").hide();
					
				}
		       
		    });  
		});
	});
</script>
</head>
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
if(isset($_REQUEST['status']))
{
	$status=$_REQUEST['status'];
	if($status==1)
	{
		echo BASENAME($_SERVER['PHP_SELF']);
		$user->read = '1';
		$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);
		$array=array('Read'=>'read_stat');
		$usersTable->addCustomColumn($array);
		Function read_stat($row){
		Return 
		"<select class=read_status>
			<option value=1>Read</option>
			<option value=0>Ignore</option>
		</select>";
		}
		$usersTable->sortCol='id'; 
		$usersTable->sorting='desc';
		$table=$usersTable->generateTable($user);
		echo $table;
	}
	else
	{
		echo BASENAME($_SERVER['PHP_SELF']);
		$user->read = '0';
		$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);
		$array=array('Read'=>'read_stat');
		$usersTable->addCustomColumn($array);
		Function read_stat($row){
		Return 
			"<select class=read_status>
				<option value=0>Ignore</option>
				<option value=1>Read</option>
			</select>";
		}
		$usersTable->sortCol='id'; 
		$usersTable->sorting='desc';
		$table=$usersTable->generateTable($user);
		echo $table;
	}
}
?>
</html>