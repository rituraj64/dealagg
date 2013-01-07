<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"></link>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>

<script type="text/javascript">
	$(document).ready(function(){
		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");
		
		$(".add_coupon").click(function(event){
			event.preventDefault();
			var id=$(this).parents("tr").children("td:first-child").html();
			alert(id);	
			
			$(".fancybox").fancybox({
				'type'			  	: 'ajax',
				'autoSize'		    : false,
				'width'		   		:500,
				'height'			:250,
				'showOverlay'		:false,
				
			});
			
			$.ajax({
				url:'couponActive.php?id='+id,
				method:'get',
				success:function(xyz){
					$.fancybox(xyz);
				}
			});
		});
		

	});
</script>

</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

$user = new coupon_active();
$orderBy = array('desc'=>'id');
$user->read(null,null,$orderBy);

//code starts here for inserting the coupon into the database
if(isset($_REQUEST['submit_coupon_active']))
{
	$active_from=$_REQUEST['active_from'];
	$active_to=$_REQUEST['active_to'];
	$discount=$_REQUEST['discount'];
	$discount_type=$_REQUEST['discount_type'];
	$category=$_REQUEST['category'];
	$product=$_REQUEST['product'];
	$deal_url=$_REQUEST['deal_url'];
	$deal_type=$_REQUEST['deal_type'];
	$coupon_code=$_REQUEST['coupon_code'];
	$min_amt=$_REQUEST['min_amt'];
	$bank=$_REQUEST['bank'];
	$description=$_REQUEST['description'];
	
	$user->active_from=$active_from;
	$user->active_to=$active_to;
	$user->discount=$discount;
	$user->discount_type=$discount_type;
	$user->category=$category;
	$user->product=$product;
	$user->deal_url=$deal_url;
	$user->deal_type=$deal_type;
	$user->coupon_code=$coupon_code;
	$user->min_amt=$min_amt;
	$user->bank=$bank;
	$user->description=$description;
	$id = $user->insert();
	?>
	<script> window.location.href='index.php';</script>
	<?php 
}
//code ends here for inserting the coupon into the database

if(isset($_REQUEST['update_coupon_active']))
{
	
}


$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

//code starts here for adding a new column to a table
$array=array('Edit'=>'edit_coupon');
$usersTable->addCustomColumn($array);
Function edit_coupon($row)
{
	Return "<a href=# class='add_coupon'>Edit Coupon</a>";
}
//code ends here for adding a new column to a table

//code starts here for sorting the column ID in desc order
$usersTable->sortCol='id'; 
$usersTable->sorting='desc';
//code ends here for sorting the column ID in desc order

$table=$usersTable->generateTable($user);

$field = array('id'=>'ID','active_from'=>'Active From','active_to'=>'Active To','discount'=>'Discount','discount_type'=>'Discount Type','category'=>'Category','product'=>'Product','deal_url'=>'Deal URL','deal_type'=>'Deal Type','coupon_code'=>'Coupon Code','min_amt'=>'Min amount');
$usersTable-> setColumnNameMapping($field);

?>
<div>
	<div style="float:left">
		<a href="index.php" id="add_coupon">Coupon Active</a>
		<a href="couponParse.php" id="add_coupon">Coupon Parse</a>
	</div>
	<div style="float:right; border:solid 1px; margin-bottom:10px; background-color:#494949;border-radius:5px;">
		<a class="add_coupon" style="text-decoration:none;color:white;" href="#">Add Coupon</a>
	</div>
</div>
<?php 
	echo $table;
?>

</div>
</html>