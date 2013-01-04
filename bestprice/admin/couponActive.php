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

	<form method="post" action="index.php">
		<table>
			<tr>
				<td><label>Active From</label></td>
				<td><input type="text" name="active_from" id="active_from"></input></td>
				<td><span id="active_fromErr"></span></td>
			</tr>
			<tr>
				<td><label>Active To</label></td>
				<td><input type="text" name="active_to" id="active_to"></input></td>
				<td><span id="active_toErr"></span></td>
			</tr>
			<tr>
				<td><label>Discount</label></td>
				<td><input type="text" name="discount" id="discount"></input></td>
				<td><span id="discountErr"></span></td>
			</tr>
			<tr>
				<td><label>Discount Type</label></td>
				<td>
					<select name="discount_type" id="discount_type">
						<option value="0">Select</option>
						<option value="percentage">Percentage</option>
						<option value="fixed">Fixed</option>
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
						<option value="<?php echo $key;?>"><?php echo $cat;?></option>
		  	 		<?php } ?>
					</select>
				</td>
				
				<td><span id="categoryErr"></span></td>
			</tr>
			<tr>
				<td><label>Product</label></td>
				<td><input type="text" name="product" id="product"></input></td>
				<td><span id="productErr"></span></td>
			</tr>
			<tr>
				<td><label>Deal URL</label></td>
				<td><input type="text" name="deal_url" id="deal_url"></input></td>
				<td><span id="deal_urlErr"></span></td>
			</tr>
			<tr>
				<td><label>Deal Type</label></td>
				<td><input type="text" name="deal_type" id="deal_type"></input></td>
				<td><span id="deal_typeErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Code</label></td>
				<td><input type="text" name="coupon_code" id="coupon_code"></input></td>
				<td><span id="coupon_codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Minimim Amount</label></td>
				<td><input type="text" name="min_amt" id="min_amt"></input></td>
				<td><span id="min_amtErr"></span></td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" name="submit_coupon_active" id="submit_coupon_active" value="Submit"></input></td>
			</tr>
		</table>
	
	</form>
</body>
</html>