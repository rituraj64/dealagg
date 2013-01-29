<html>
<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){
		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");

		$("#bus table tbody tr td table").prepend("<col width=3%><col width=10%><col width=26%><col width=20%><col width=26%><col width=5%><col width=6%><col width=4%>")
		$(".form").children("col").hide();
		
		$("#bus table tbody tr td table td:nth-child(3)").each(function(i){
			var url=$(this).text();
			$(this).html("<a href="+url+" target=_blank>"+url+"</a>");
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

$data=$user->read(null,null);
//foreach($data as $d)
//{
//	echo $d['html'];
//}

$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

//code starts here for adding a new column to a table
$array=array('Html'=>'view_html');
$usersTable->addCustomColumn($array);
Function view_html($row)
{
	Return "<a href=# class='add_coupon'>View Html</a>";
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