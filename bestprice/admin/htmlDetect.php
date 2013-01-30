<html>
<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){
		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");

		$("#bus table tbody tr td table").prepend("<col width=3%><col width=6%><col width=22%><col width=20%><col width=32%><col width=5%><col width=6%><col width=6%>")
		$(".form").children("col").hide();
		
		$("#bus table tbody tr td table td:nth-child(3)").each(function(i){
			var url=$(this).text();
			$(this).html("<a href="+url+" target=_blank>"+url+"</a>");
		});
		
		$(".view_html").click(function(e){
			e.preventDefault();
			var id=$(this).parent("td").parent("tr").children("td:first-child").html();
			window.open("htmlDetect.php?Id="+id);

		});
		$(".delete_data").click(function(e){
			e.preventDefault();
			var id=$(this).parent("td").parent("tr").children("td:first-child").html();
			var conf=confirm("Are you sure you want to Delete this Data");
			if(conf==true)
			{
				window.location.href="htmlDetect.php?deleteId="+id;
			}
			else
			{
				return false;
			}
		});
	});
	</script>	
	<style type="text/css">
	
	#bus table tbody tr td table
	{
		table-layout:fixed;
	}
	
	#bus table tbody tr td table td:nth-child(1n+1)
	{
		overflow:hidden;
		word-wrap:break-word;
	}
	
</style>
</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

$user = new html_detect();

if(isset($_REQUEST['Id']))
{
	$id=$_REQUEST['Id'];
	$user->id = $id;
	$html_read=$user->read();
	foreach($html_read as $code)
	{
		echo $code['html'];
	}
	die;
}
if(isset($_REQUEST['deleteId']))
{
	$id=$_REQUEST['deleteId'];
	$user->id = $id;
	$user->delete();
	echo "<script>window.location.href='htmlDetect.php';</script>";
}
?>
<div style="float:left">
	<a href="index.php" id="add_coupon">Coupon Active</a>
	<a href="couponParse.php" id="add_coupon">Coupon Parse</a>
	<a href="htmlDetect.php">View HTML</a>
</div>
<?php 
$orderBy=array('asc'=>'priority');
$data=$user->read(null,null,$orderBy);
$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

//code starts here for adding a new column to a table
$array=array('Html'=>'view_html');
$usersTable->addCustomColumn($array);
Function view_html($row)
{
	Return "<a href='#' target='_blank' class='view_html'>View Html</a><br><a href='#' class='delete_data'>Remove</a>";
}
//code ends here for adding a new column to a table

//code starts here for sorting the column ID in desc order
$usersTable->sortCol='priority'; 
//code ends here for sorting the column ID in desc order

$array=array('html');
$usersTable-> setHideColumn($array);

$table=$usersTable->generateTable($user);
echo $table;
?>
</html>