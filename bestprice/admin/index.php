<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"></link>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>

<script type="text/javascript">

	$(document).ready(function(){
		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");

		$("#bus table tbody tr td table").prepend("<col width=4%><col width=6%><col width=6%><col width=7%><col width=7%><col width=9%><col width=8%><col width=9%><col width=22%><col width=18%><col width=10%><col width=6%><col width=6%><col width=8%><col width=7%><col width=6%><col width=8%>")
		$(".form").children("col").hide();
		$(".add_coupon").fancybox();

		$(".add_coupon").click(function(event){

			var id=$(this).parents("tr").children("td:first-child").html();
			var active_from=$(this).parents("tr").children("td:nth-child(2)").text();
			var active_to=$(this).parents("tr").children("td:nth-child(3)").text();
			var discount=$(this).parents("tr").children("td:nth-child(4)").text();
			var max_discount=$(this).parents("tr").children("td:nth-child(5)").text();
			var discount_type=$(this).parents("tr").children("td:nth-child(6)").text();
			var category=$(this).parents("tr").children("td:nth-child(7)").text();
			var product=$(this).parents("tr").children("td:nth-child(8)").text();
			var description=$(this).parents("tr").children("td:nth-child(9)").text();
			var deal_url=$(this).parents("tr").children("td:nth-child(10)").text();
			var website=$(this).parents("tr").children("td:nth-child(11)").text();
			var deal_type=$(this).parents("tr").children("td:nth-child(12)").text();
			var coupon_code=$(this).parents("tr").children("td:nth-child(13)").text();
			var min_amt=$(this).parents("tr").children("td:nth-child(14)").text();
			var bank=$(this).parents("tr").children("td:nth-child(15)").text();
			var image=$(this).parents("tr").children("td:nth-child(16)").text();
			var cat=category.split(',');

			if(active_from!="")
			{
				active_from=new Date(active_from*1000);
				active_from=('0'+active_from.getFullYear()).substr(-2,2)+'-'+('0'+active_from.getMonth()+1).substr(-2,2)+'-'+('0'+active_from.getDate()).substr(-2,2);
			}
			if(active_to!="")
			{
				active_to=new Date(active_to*1000);
				active_to=('0'+active_to.getFullYear()).substr(-2,2)+'-'+('0'+active_to.getMonth()+1).substr(-2,2)+'-'+('0'+active_to.getDate()).substr(-2,2);
			}
			$("#hidden_id").val(id);
			$("#active_from").val(active_from);
			$("#active_to").val(active_to);
			$("#discount").val(discount);
			$("#max_discount").val(max_discount);
			$("#discount_type").val(discount_type);
			$("#category").val(cat);
			$("#product").val(product);
			$("#description").val(description);
			$("#deal_url").val(deal_url);
			$("#website").val(website);
			$("#deal_type").val(deal_type);
			$("#coupon_code").val(coupon_code);
			$("#min_amt").val(min_amt);
			$("#bank").val(bank);
			$("#image").val(image);
		});
		
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
		 
		$("#bus table tbody tr td table td:nth-child(10)").each(function(i){
			var deal_url=$(this).text();
			
			if(deal_url=="")
			{
				$(this).html("<a href=# target=_blank>"+deal_url+"</a>");
			}
			else
			{
				$(this).html("<a href="+deal_url+" target=_blank>"+deal_url+"</a>");
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
	
	

   .ui-datepicker { width: 12em; padding: .2em .2em 0; display: none; }
   .ui-datepicker table {width: 100%; font-size: .7em; border-collapse: collapse; margin:0 0 .4em; }
   .ui-datepicker .ui-datepicker-title select { font-size:15px; margin:1px 0; }
</style>

</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';
require_once '../smartmodel/FileUtil.php';

$fileutil=new FileUtil();
$user = new coupon_active();
$user_parse = new coupon_parse();
$orderBy = array('desc'=>'id');
$user->read(null,null,$orderBy);

//code starts here for inserting the coupon into the database
if(isset($_REQUEST['submit_coupon_active']))
{
	$id=$_REQUEST['hidden_id'];
	$active_from=strtotime($_REQUEST['active_from']);
	$active_to=strtotime($_REQUEST['active_to']);
	$discount=$_REQUEST['discount'];
	$discount_type=$_REQUEST['discount_type'];
	$product=$_REQUEST['product'];
	$deal_url=$_REQUEST['deal_url'];
	$deal_type=$_REQUEST['deal_type'];
	$coupon_code=$_REQUEST['coupon_code'];
	$min_amt=$_REQUEST['min_amt'];
	$bank=$_REQUEST['bank'];
	$description=$_REQUEST['description'];
	$image=$_REQUEST['image'];
	$max_discount=$_REQUEST['max_discount'];
	$website=$_REQUEST['website'];
	if(isset($_REQUEST['category']))
	{
		$category=$_REQUEST['category'];
		$cat_values=join(',',$category);
	}
	else
	{
		$cat_values=-1;
	}
	if(($id=="undefined")||($id==""))
	{
		$user->active_from=$active_from;
		$user->active_to=$active_to;
		$user->discount=$discount;
		$user->discount_type=$discount_type;
		$user->category=$cat_values;
		$user->product=$product;
		$user->deal_url=$deal_url;
		$user->deal_type=$deal_type;
		$user->coupon_code=$coupon_code;
		$user->min_amt=$min_amt;
		$user->bank=$bank;
		$user->description=$description;
		$user->image=$image;
		$user->max_discount=$max_discount;
		$user->website=$website;
		$id = $user->insert();
		?>
		<script> window.location.href='index.php';</script>
		<?php 
	}
	else
	{
		$set=array("active_from"=>$active_from,"active_to"=>$active_to,"discount"=>$discount,"discount_type"=>$discount_type,"category"=>$cat_values,"product"=>$product,"deal_url"=>$deal_url,"deal_type"=>$deal_type,"coupon_code"=>$coupon_code,"min_amt"=>$min_amt,"bank"=>$bank,"description"=>$description,"image"=>$image,"max_discount"=>$max_discount,"website"=>$website);
		$where = array("id"=>$id);
		$user->update($set,$where);
	}
	if(isset($_REQUEST['parse_id']))
	{
		if($_REQUEST['parse_id']!="")
		{
			$parse_id=$_REQUEST['parse_id'];
			$read=1;
		
			$set=array("read"=>$read);
			$where = array("id"=>$parse_id);
			$user_parse->update($set,$where);
		}
	}
	
}
//code ends here for inserting the coupon into the database

$usersTable=new TableUI($user,UI::STYLE_LIGHT_GREY);

//code starts here for adding a new column to a table
$array=array('Edit'=>'edit_coupon');
$usersTable->addCustomColumn($array);
Function edit_coupon($row)
{
	Return "<a href=#data class='add_coupon'>Edit Coupon</a>";
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

<!--code starts here for adding a new coupon-->

<div style="display:none" name="data" id="data">
<?php 

require_once '../Parsing.php';



?>
<form method="post" action="index.php">

	<table>
		<tr>
			<td><label>Active From</label></td>
			<td><input type="text"  name="active_from" id="active_from"></input></td>
			<td><span id="active_fromErr"></span></td>
		</tr>
		<tr>
			<td><label>Active To</label></td>
			<td><input type="text"  name="active_to" id="active_to"></input></td>
			<td><span id="active_toErr"></span></td>
		</tr>
		<tr>
			<td><label>Discount</label></td>
			<td><input type="text"  name="discount" id="discount"></input></td>
			<td><span id="discountErr"></span></td>
		</tr>
		<tr>
			<td><label>Max Discount</label></td>
			<td><input type="text"  name="max_discount" id="max_discount"></input></td>
			<td><span id="max_discountErr"></span></td>
		</tr>
		<tr>
			<td><label>Discount Type</label></td>
			<td>
				<select required="true" name="discount_type" id="discount_type">
					<option value="">Select</option>
					<option value="percentage">Percentage</option>
					<option value="fixed">Fixed</option>
				</select>
			</td>
			<td><span id="discount_typeErr"></span></td>
		</tr>
		<tr>
			<td><label>Category</label></td>
			<td>
				<select multiple name="category[]" id="category">
					<option selected value="-1">Select</option>
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
			<td><input type="text"  name="product" id="product"></input></td>
			<td><span id="productErr"></span></td>
		</tr>
		
		<tr>
			<td><label>Deal URL</label></td>
			<td><input type="text"  name="deal_url" id="deal_url"></input></td>
			<td><span id="deal_urlErr"></span></td>
		</tr>
		<tr>
			<td><label>Website</label></td>
			<td>
				
				<?php $p = new Parsing();
					  $sites = $p->getWebsites();
				?>
				<select name="website" required="true" id="website">
					<option value="">Select</option>
					<?php foreach($sites as $site)  {?>
					
					
						
					<option value="<?php echo $site; ?>"><?php echo $site; ?></option>
					<?php } ?>
				</select>
			</td>
			<td><span id="min_amtErr"></span></td>
		</tr>
		<tr>
			<td><label>Deal Type</label></td>
			<td>
				<select name="deal_type" id="deal_type">
					<option>Select</option>
					<option  value="Fixed">Fixed</option>
					<option  value="Upto">Upto</option>
					<option  value="Conditions">Conditions</option>
				</select>
			<td><span id="deal_typeErr"></span></td>
		</tr>
		<tr>
			<td><label>Coupon Code</label></td>
			<td><input type="text"  name="coupon_code" id="coupon_code"></input></td>
			<td><span id="coupon_codeErr"></span></td>
		</tr>
		<tr>
			<td><label>Minimim Amount</label></td>
			<td><input type="text"  name="min_amt" id="min_amt"></input></td>
			<td><span id="min_amtErr"></span></td>
		</tr>
		<tr>
			<td>Bank</td>
			<td>
				<select name="bank" id="bank">
					<option value="None">Select</option>
					<option value="HDFC">HDFC</option>
					<option value="PNB">PNB</option>
					<option value="ICICI">ICICI</option>
					<option value="SBI">SBI</option>
					<option value="HSBC">HSBC</option>
					<option value="CANARA">Canara</option>
					<option value="CITY_BANK">City Bank</option>
					<option value="Axis">Axis</option>
					<option value="Bank of Baroda">Bank of Baroda</option>
					<option value="Bank of India">Bank of India</option>
					<option value="Corporation">Corporation Bank</option>
					<option value="Dena">Dena</option>
					<option value="IDBI">IDBI</option>
					<option value="United Bank of India">United Bank of India</option>
					<option value="Kotak Mahindra">Kotak Mahindra Bank</option>
					<option value="YES">Yes Bank</option>
					<option value="Federal">Federal Bank</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Image</label></td>
			<td><input type="text" name="image"  id="image"></input></td>
			<td><span id="imageErr"></span></td>
		</tr>
		<tr>
			<td><label>Description</label></td>
			<td>
				<textarea rows="10" cols="30" name="description" id="description"></textarea>
			</td>
			<td><span id="descriptionErr"></span></td>
		</tr>
		<tr>
			
			<td colspan="3"><input type="submit" name="submit_coupon_active" id="submit_coupon_active" value="Submit"></input></td>
			
			<td><input type="hidden" id="hidden_id" name="hidden_id"></input></td>
		</tr>
	</table>
	
</form>
</div>

<!--code ends here for adding a new coupon-->

<div>
	<div style="float:left">
		<a href="index.php" id="add_coupon">Coupon Active</a>
		<a href="couponParse.php" id="add_coupon">Coupon Parse</a>
	</div>
	<div style="float:right; border:solid 1px; margin-bottom:10px; background-color:#494949;border-radius:5px;">
		<a class="add_coupon" style="text-decoration:none;color:white;" href="#data">Add Coupon</a>
	</div>
</div>
<?php 
	echo $table;
?>

</html>