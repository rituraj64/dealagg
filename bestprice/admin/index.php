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

		
		$(".add_coupon").fancybox();

		$(".add_coupon").click(function(event){

			var id=$(this).parents("tr").children("td:first-child").html();
		});
		
//		$(".add_coupon").click(function(event){
//			event.preventDefault();
//			var id=$(this).parents("tr").children("td:first-child").html();
//			
//			$(".fancybox").fancybox({
//				'type'			  	: 'iframe',
//				'autoSize'		    : false,
//				'width'		   		:500,
//				'height'			:250,
//				'showOverlay'		:false,
//				
//			});
//			
//			$.ajax({
//				url:'couponActive.php?id='+id,
//				method:'get',
//				success:function(xyz){
//					$.fancybox(xyz);
//				}
//			});
//		});
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
		$("#bus table tbody tr td table td:nth-child(9)").each(function(i){
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
		
	});
</script>

<style type="text/css">
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
$orderBy = array('desc'=>'id');
$user->read(null,null,$orderBy);

//code starts here for inserting the coupon into the database
if(isset($_REQUEST['submit_coupon_active']))
{
	$active_from=strtotime($_REQUEST['active_from']);
	$active_to=strtotime($_REQUEST['active_to']);
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
	$image=$_REQUEST['image'];
	$max_discount=$_REQUEST['max_discount'];
	$website=$_REQUEST['website'];
	
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
	$user->image=$image;
	$user->max_discount=$max_discount;
	$user->website=$website;
	$id = $user->insert();
	?>
	<script> window.location.href='index.php';</script>
	<?php 
	
}
//code ends here for inserting the coupon into the database

if(isset($_REQUEST['update_coupon_active']))
{
	$active_from=strtotime($_REQUEST['active_from']);
	$active_to=strtotime($_REQUEST['active_to']);
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
	$id=$_REQUEST['hidden_id'];
	$image=$_REQUEST['image'];
	$max_discount=$_REQUEST['max_discount'];
	$website=$_REQUEST['website'];
	//$user->sql_tracking=true;
	$set=array("active_from"=>$active_from,"active_to"=>$active_to,"discount"=>$discount,"discount_type"=>$discount_type,"category"=>$category,"product"=>$product,"deal_url"=>$deal_url,"deal_type"=>$deal_type,"coupon_code"=>$coupon_code,"min_amt"=>$min_amt,"bank"=>$bank,"description"=>$description,"image"=>$image,"max_discount"=>$max_discount,"website"=>$website);
	$where = array("id"=>$id);
	$user->update($set,$where);
	
}

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
$max_discount="";
$website="";
	
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
		$max_discount=$data[0]['max_discount'];
		$website=$data[0]['website'];
	}
}

?>
<form method="post" action="index.php">

	<table>
		<tr>
			<td><label>Active From</label></td>
			<td><input type="text" value="<?php if($active_from!=""){ echo date("Y-m-d",$active_from);} ?>" name="active_from" id="active_from"></input></td>
			<td><span id="active_fromErr"></span></td>
		</tr>
		<tr>
			<td><label>Active To</label></td>
			<td><input type="text" value="<?php if($active_to!=""){ echo date("Y-m-d",$active_to);} ?>" name="active_to" id="active_to"></input></td>
			<td><span id="active_toErr"></span></td>
		</tr>
		<tr>
			<td><label>Discount</label></td>
			<td><input type="text" value="<?php echo $discount; ?>" name="discount" id="discount"></input></td>
			<td><span id="discountErr"></span></td>
		</tr>
		<tr>
			<td><label>Max Discount</label></td>
			<td><input type="text" value="<?php echo $max_discount; ?>" name="max_discount" id="max_discount"></input></td>
			<td><span id="max_discountErr"></span></td>
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
				<select multiple name="category" id="category">
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
			<td><label>Website</label></td>
			<td>
				<?php $p = new Parsing();
					  $sites = $p->getWebsites();
				?>
				<select name="website">
					<option value="0">Select</option>
					
					<?php foreach($sites as $site)  {?>
					
					<?php if(isset($_REQUEST['deal_url'])) 
					{
						
						 if(preg_match("/".$site."/i",$_REQUEST['deal_url']))
						 {
						 	$website=$site;
						 }
					}
					
					?>
						
					<option <?php if($website==$site){ ?>selected<?php } ?> value="<?php echo $site; ?>"><?php echo $site; ?></option>
					<?php } ?>
				</select>
			</td>
			<td><span id="min_amtErr"></span></td>
		</tr>
		<tr>
			<td><label>Deal Type</label></td>
			<td>
				<select name="deal_type">
					<option>Select</option>
					<option <?php if($deal_type=="Fixed"){ ?> selected <?php } ?> value="Fixed">Fixed</option>
					<option <?php if($deal_type=="Upto"){ ?> selected <?php } ?> value="Upto">Upto</option>
					<option <?php if($deal_type=="Conditions"){ ?> selected <?php } ?> value="Conditions">Conditions</option>
				</select>
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
</div>

<!--code ends here for adding a new coupon-->

<div>
	<div style="float:left">
		<a href="index.php" id="add_coupon">Coupon Active</a>
		<a href="couponParse.php" id="add_coupon">Coupon Parse</a>
	</div>
	<div style="float:right; border:solid 1px; margin-bottom:10px; background-color:#494949;border-radius:5px;">
		<a class="add_coupon" style="text-decoration:none;color:white;" href="#data?ID=1">Add Coupon</a>
	</div>
</div>
<?php 
	echo $table;
?>

	

</html>