<html>
<head>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>

<script type="text/javascript">
	$(document).ready(function(){
		
		$(".add_coupon").click(function(event){
			event.preventDefault();
						
			$(".fancybox").fancybox({
				'type'			  	: 'iframe',
				'autoSize'		    : false,
				'width'		   		:500,
				'height'			:250,
				'showOverlay'		:false,
				
			});
			
			$.ajax({
				url:'addCouponParse.php',
				method:'get',
				success:function(xyz){
					$.fancybox(xyz);
				}
			});
		});
		
		$("#bus table tbody tr td table").prepend("<col width=5%><col width=10%><col width=5%><col width=5%><col width=10%><col width=11%><col width=10%><col width=23%><col width=5%><col width=5%><col width=3%><col width=8%>")
		
		$("#bus table tbody tr td table td:nth-child(5)").each(function(i){
			var deal_url=$(this).text();
			if(deal_url==" ")
			{
				$(this).html("<a href=# target=_blank>"+deal_url+"</a>");
			}
			else
			{
				$(this).html("<a href="+deal_url+" target=_blank>"+deal_url+"</a>");
			}
		});

		$("#bus table tbody tr td table td:nth-child(7)").each(function(i){
			var website=$(this).text();
			$(this).html("<a href="+website+" target+_blank>"+website+"</a>");
		});
		
//		$("#bus table tbody tr td table td:nth-child(8)").each(function(i){
//			var title=$(this).text().substr(0,10);
//			$(this).html(title);
//		});

		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");
		
		$(".read_status").change(function(event){
			
			var id=$(this).parent("td").parent("tr").children("td:first-child").html();
			var coupon_code=$(this).parent("td").parent("tr").children("td:nth-child(3)").html();
			var deal_url=$(this).parent("td").parent("tr").find("a").attr("href");
			var readStatus=$("#read-status").val();
			if(readStatus==undefined)
			{
				readStatus="0";
			}
			
			var abc=$(this);
			var status_val=$(this).val();
			
			if(status_val=="2")
			{
				event.preventDefault();
				$(".fancybox").fancybox({
					'type'			  	: 'iframe',
					'autoSize'		    : false,
					'width'		   		:500,
					'height'			:250,
					'showOverlay'		:false,
					
				});

				$.ajax({
			        url: 'couponActive.php?coupon_code='+coupon_code,
			        data: 'deal_url=' +deal_url,
			        cache: false,
			        success:function(xyz){
						$.fancybox(xyz);
						
					}
			    });  
			    return false;
			}
			else
			{
				$.ajax({
			        url: 'updateCouponParse.php?Id='+id,
			        data: 'content=' + this.value,
			        cache: false,
			        success:function(){
						
						if(readStatus!=status_val)
						{
							abc.parent("td").parent("tr").hide();
						}
						
					}
			       
			    });  
			}
		});
		$("#status").change(function(){
			
			window.location.href='couponParse.php?status='+this.value;
			
			
		});
		$(".ovalbutton").click(function(){
			var aa=$(this).attr("href");
			var readStatus=$("#read-status").val();

			if(readStatus==1)
			{
				var trail='&status=1';
				aa=aa+trail;
				$(this).attr("href",aa);
			}
			else
			{
				var trail='&status=0';
				aa=aa+trail;
				$(this).attr("href",aa);
			}
		});
		$("#paging-form").submit(function(){
			
			var readStatus=$("#read-status").val();
			if(readStatus==1)
			{
				$(this).append("<input type='hidden' name='status' value='1'></input>");
			}
			else
			{
				$(this).append("<input type='hidden' name='status' value='0'></input>");
			}
		});

		$(".form-noindent form").submit(function(){
			var readStatus=$("#read-status").val();
			if(readStatus==1)
			{
				$(this).children("table").before("<input type='hidden' name='status' value='1'></input>");
			}
			else
			{
				$(this).children("table").before("<input type='hidden' name='status' value='0'></input>");
			}
		});
	});

</script>
<style>

	#bus table tbody tr td table
	{
		table-layout:fixed;
	}
	
	#bus table tbody tr td table td:nth-child(1n+1)
	{
		width:30px !important;
		overflow:hidden;
		word-wrap:break-word;
	}
	#bus table tbody tr td table th:nth-child(1n+1)
	{
		width:30px !important;
		overflow:hidden;
		word-wrap:break-word;
	}
	#bus table tbody tr td table td:last-child
	{
		width:60px !important;
		word-wrap:break-word;
	}
	#bus table tbody tr td table td:nth-child(8)
	{
		width:900px !important;
		word-wrap:break-word;
	}
	#bus table tbody tr td table td:nth-child(6)
	{
		width:200px !important;
		word-wrap:break-word;
	}
	
</style>


</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

?>
<div>
	<div style="float:left">
			<a href="index.php" id="add_coupon">Coupon Active</a>
			<a href="couponParse.php" id="add_coupon">Coupon Parse</a>
	</div>
	
	<div>
		<select style="float:right; width:150px;" id="status">
			<option  value=0>Read</option>
			<option <?php if(isset($_REQUEST['status'])){ if($_REQUEST['status']==1) { ?> selected <?php  }  } ?> value=1>Ignore</option>
		</select>
		<div style="float:right; border:solid 1px; margin-bottom:10px; background-color:#494949;border-radius:5px;">
			<a class="add_coupon" style="text-decoration:none;color:white;" href="#">Add Coupon</a>
		</div>
	</div>
	
</div>
<?php 

$user = new coupon_parse();

if(isset($_REQUEST['submit_coupon_parse']))
{
	$uniq_id=$_REQUEST['uniq_id'];
	$coupon_code=$_REQUEST['coupon_code'];
	$coupon_type=$_REQUEST['coupon_type'];
	$deal_url=$_REQUEST['deal_url'];
	$title=$_REQUEST['title'];
	$website=$_REQUEST['website'];
	$desc=$_REQUEST['desc'];
	$success=$_REQUEST['success'];
	$code=$_REQUEST['code'];
	$status=$_REQUEST['status'];
	
	$user->uniq_id=$uniq_id;
	$user->coupon_code=$coupon_code;
	$user->coupon_type=$coupon_type;
	$user->deal_url=$deal_url;
	$user->title=$title;
	$user->website=$website;
	$user->desc=$desc;
	$user->success=$success;
	$user->code=$code;
	$user->status=$status;
	$id = $user->insert();
	?>
	<script> window.location.href='couponParse.php';</script>
	<?php 
}

$orderBy=array('desc'=>'id');
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
	$user->read = '0';
}

$data=$user->read(null,null,$orderBy);

$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

//code starts here for adding a new column to a table
$array=array('Read'=>'read_stat');
$usersTable->addCustomColumn($array);
Function read_stat($row){
	if(isset($_REQUEST['status']))
	{ 
		if($_REQUEST['status']==1)
		{
			Return
			"<select class=read_status>
				<option value=0>Read</option>
				<option selected value=1>Ignore</option>
				<option value=2>Add Coupon</option>
			</select>";
		}
		else
		{
			Return
			"<select class=read_status>
				<option value=0>Read</option>
				<option value=1>Ignore</option>
				<option value=2>Add Coupon</option>
			</select>";
			
		}
	}
	else
	{
		Return
		"<select class=read_status>
			<option value='0'>Read</option>
			<option value='1'>Ignore</option>
			<option value='2'>Add Coupon</option>
		</select>";
	}
}
//code ends here for adding a new column to a table

//code starts here for sorting the column ID in descending order
$usersTable->sortCol='id'; 
$usersTable->sorting='desc';
//code ends here for sorting the column ID in descending order

$table=$usersTable->generateTable($user);

//code starts here for hiding the column read
//$hide=array('id');
//$usersTable->setColumnNameMapping($hide);
//code ends here for hiding the column read

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

</div>
</html>
