<html>
<head>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"></link>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>

<script>
	$(document).ready(function(){
		$("#active_from" ).datepicker({
		   dateFormat: 'yy-mm-dd',
		   changeMonth:true,
		   changeYear:true,
		 });
		$("#active_to" ).datepicker({
		   dateFormat: 'yy-mm-dd',
		   changeMonth:true,
		   changeYear:true,
		 });
		
	});
</script>
<style type="text/css">
   .ui-datepicker { width: 12em; padding: .2em .2em 0; display: none; }
   .ui-datepicker table {width: 100%; font-size: .7em; border-collapse: collapse; margin:0 0 .4em; }
   .ui-datepicker .ui-datepicker-title select { font-size:15px; margin:1px 0; }
</style>

</head>

<body>
<?php 
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';

$coupon_id="";
$active_from="";
$active_to="";
$discount="";
$discount_type="";
$category="";
$product="";
$deal_url="";
$deal_type="";
$coupon_code="";
$min_amt="";
$bank="";
$description="";
$image="";
	
if(isset($_REQUEST['deal_url']))
{
	$deal_url=$_REQUEST['deal_url'];
}
if(isset($_REQUEST['coupon_code']))
{
	$coupon_code=$_REQUEST['coupon_code'];
}
if(isset($_REQUEST['description']))
{
	$description=$_REQUEST['description'];
}
if(isset($_REQUEST['id']))
{
	if($_REQUEST['id']!="undefined")
	{
		$coupon_id=$_REQUEST['id'];
		$user = new coupon_active();
		$user->id = $coupon_id;
		$data=$user->read();
		
		$active_from=$data[0]['active_from'];
		$active_to=$data[0]['active_to'];
		$discount=$data[0]['discount'];
		$discount_type=$data[0]['discount_type'];
		$category=$data[0]['category'];
		$product=$data[0]['product'];
		$deal_url=$data[0]['deal_url'];
		$deal_type=$data[0]['deal_type'];
		$coupon_code=$data[0]['coupon_code'];
		$min_amt=$data[0]['min_amt'];
		$bank=$data[0]['bank'];
		$description=$data[0]['description'];
		$image=$data[0]['image'];
	}
}

?>
	<form method="post" action="index.php">
		<table>
			<tr>
				<td><label>Active From</label></td>
				<td><input type="text" value="<?php echo $active_from; ?>" name="active_from" id="active_from"></input></td>
				<td><span id="active_fromErr"></span></td>
			</tr>
			<tr>
				<td><label>Active To</label></td>
				<td><input type="text" value="<?php echo $active_to; ?>" name="active_to" id="active_to"></input></td>
				<td><span id="active_toErr"></span></td>
			</tr>
			<tr>
				<td><label>Discount</label></td>
				<td><input type="text" value="<?php echo $discount; ?>" name="discount" id="discount"></input></td>
				<td><span id="discountErr"></span></td>
			</tr>
			<tr>
				<td><label>Discount Type</label></td>
				<td>
					<select name="discount_type" id="discount_type">
						<option value="0">Select</option>
						<option <?php if($discount_type=="percentage"){ ?> selected<?php } ?> value="percentage">Percentage</option>
						<option <?php if($discount_type=="fixed"){ ?> selected<?php } ?> value="fixed">Fixed</option>
					</select>
				</td>
				<td><span id="discount_typeErr"></span></td>
			</tr>
			<tr>
				<td><label>Category</label></td>
				<td>
					<select name="category" id="category">
						<option value="0">Select</option>
						<?php
			  	 			require_once '../Category.php';
			  	 			$catObj = new Category();
			  	 			$cats = $catObj->getStoreCategory();
			  	 			
			  	 			foreach($cats as $key => $cat){
			  	 				if(is_array($cat)){$cat = key($cat);}
			  	 		?>
						<option <?php if($category==$key){ ?> selected <?php } ?> value="<?php echo $key;?>"><?php echo $cat;?></option>
		  	 		<?php } ?>
					</select>
				</td>
				
				<td><span id="categoryErr"></span></td>
			</tr>
			<tr>
				<td><label>Product</label></td>
				<td><input type="text" value="<?php echo $product; ?>" name="product" id="product"></input></td>
				<td><span id="productErr"></span></td>
			</tr>
			
			<tr>
				<td><label>Deal URL</label></td>
				<td><input type="text" value="<?php echo $deal_url; ?>" name="deal_url" id="deal_url"></input></td>
				<td><span id="deal_urlErr"></span></td>
			</tr>
			<tr>
				<td><label>Deal Type</label></td>
				<td><input type="text" value="<?php echo $deal_type; ?>" name="deal_type" id="deal_type"></input></td>
				<td><span id="deal_typeErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Code</label></td>
				<td><input type="text" value="<?php echo $coupon_code; ?>" name="coupon_code" id="coupon_code"></input></td>
				<td><span id="coupon_codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Minimim Amount</label></td>
				<td><input type="text" value="<?php echo $min_amt; ?>" name="min_amt" id="min_amt"></input></td>
				<td><span id="min_amtErr"></span></td>
			</tr>
			<tr>
				<td>Bank</td>
				<td>
					<select name="bank">
						<option value="None">Select</option>
						<option <?php if($bank=="HDFC"){ ?>selected<?php } ?> value="HDFC">HDFC</option>
						<option <?php if($bank=="PNB"){ ?>selected<?php } ?> value="PNB">PNB</option>
						<option <?php if($bank=="ICICI"){ ?>selected<?php } ?> value="ICICI">ICICI</option>
						<option <?php if($bank=="SBI"){ ?>selected<?php } ?> value="SBI">SBI</option>
						<option <?php if($bank=="HSBC"){ ?>selected<?php } ?> value="HSBC">HSBC</option>
						<option <?php if($bank=="CANARA"){ ?>selected<?php } ?> value="CANARA">Canara</option>
						<option <?php if($bank=="CITY_BANK"){ ?>selected<?php } ?> value="CITY_BANK">City Bank</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label>Image</label></td>
				<td><input type="text" name="image" value="<?php echo $image; ?>" id="image"></input></td>
				<td><span id="imageErr"></span></td>
			</tr>
			<tr>
				<td><label>Description</label></td>
				<td>
					<textarea rows="10" cols="30" name="description" id="description"><?php echo $description; ?></textarea>
				</td>
				<td><span id="descriptionErr"></span></td>
			</tr>
			<tr>
				<?php if(isset($_REQUEST['id'])) { ?>
				<td colspan="3"><input type="submit" name="update_coupon_active" id="update_coupon_active" value="Update"></input></td>
				<?php } else { ?>
				<td colspan="3"><input type="submit" name="submit_coupon_active" id="submit_coupon_active" value="Submit"></input></td>
				<?php } ?>
				<td><input type="hidden" name="hidden_id" value="<?php echo $coupon_id; ?>"></input></td>
			</tr>
		</table>
	
	</form>
</body>
</html>