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
		$("#status").change(function(){
			
			window.location.href='couponParse.php?status='+this.value;
			
			
		});
		$(".ovalbutton").click(function(){
			var aa=$(this).attr("href");
			var readStatus=$("#read-status").val();

			if(readStatus==0)
			{
				var trail='&status=0';
				aa=aa+trail;
				$(this).attr("href",aa);
			}
			else
			{
				var trail='&status=1';
				aa=aa+trail;
				$(this).attr("href",aa);
			}
		});
		$("#paging-form").submit(function(){
			
			var readStatus=$("#read-status").val();
			if(readStatus==0)
			{
				$(this).append("<input type='hidden' name='status' value='0'></input>");
			}
			else
			{
				$(this).append("<input type='hidden' name='status' value='1'></input>");
			}
		});
	});

</script>

</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

?>

<select style="float:right; width:150px;" id="status">
	<option  value=1>Read</option>
	<option <?php if(isset($_REQUEST['status'])){ if($_REQUEST['status']==0) { ?> selected <?php  }  } ?> value=0>Ignore</option>
</select>
<?php 

$user = new coupon_parse();
if(isset($_REQUEST['status']))
{
	if($_REQUEST['status']==1)
	{
		$user->read = '1';
	}	
	else
	{
		$user->read = '0';
	}
}

else
{
	$user->read = '1';
}

$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

$array=array('Read'=>'read_stat');
$usersTable->addCustomColumn($array);
Function read_stat($row){
	if(isset($_REQUEST['status']))
	{ 
		if($_REQUEST['status']==0)
		{
			Return
			"<select class=read_status>
				<option value=1>Read</option>
				<option selected value=0>Ignore</option>
			</select>";
		}
		else
		{
			Return
			"<select class=read_status>
				<option value=1>Read</option>
				<option value=0>Ignore</option>
			</select>";
			
		}
	}
		else
		{
			Return
			"<select class=read_status>
				<option value=1>Read</option>
				<option value=0>Ignore</option>
			</select>";
		}
}
$usersTable->sortCol='id'; 
$usersTable->sorting='desc';

$table=$usersTable->generateTable($user);
?>
<div id="table">
<?php 
echo $table;
?>
<?php 
	if(isset($_REQUEST['status']))
	{
?>
		<input type="hidden" value="<?php echo $_REQUEST['status']; ?>" name="read-status" id="read-status"></input>
		
<?php 
	}
?>
"
</div>
</html>
