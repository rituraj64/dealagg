<head>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"></link>

<script type="text/javascript">
	$(document).ready(function(){
		
		$(".add_coupon").fancybox();
		
		$("#bus table tbody tr td table").prepend("<col width=3%><col width=5%><col width=5%><col width=5%><col width=10%><col width=14%><col width=14%><col width=23%><col width=5%><col width=5%><col width=3%><col width=8%>")
		$(".form").children("col").hide();
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
			$(this).html("<a href="+website+" target=_blank>"+website+"</a>");
		});
		
//		$("#bus table tbody tr td table td:nth-child(8)").each(function(i){
//			var title=$(this).text().substr(0,10);
//			$(this).html(title);
//		});

		$("#bus table tbody tr td table td").attr("align","center");
		$("#bus table").attr("border","1");
		$(".form").attr("border","0");

		$(".fancylink").fancybox();
		
		$(".read_status").change(function(event){
			
			var id=$(this).parent("td").parent("tr").children("td:first-child").html();
			var coupon_code=$(this).parent("td").parent("tr").children("td:nth-child(3)").text();
			var dscription=$(this).parent("td").parent("tr").children("td:nth-child(8)").text();
			var website=$(this).parent("td").parent("tr").children("td:nth-child(7)").text();
			
			var deal_url=$(this).parent("td").parent("tr").find("a").attr("href");
			deal_url=deal_url.trim();
			coupon_code=coupon_code.trim();
			var readStatus=$("#read-status").val();
			if(readStatus==undefined)
			{
				readStatus="0";
			}
			
			var abc=$(this);
			var status_val=$(this).val();
			
			if(status_val=="2")
			{
				
				$("a.fancylink").trigger("click");
				$("#coupon_code").val(coupon_code);
				$("#description").val(dscription);
				$("#deal_url").val(deal_url);
				$("#parse_id").val(id);
				$("#website").val("");
				$("#bank").val("None");
				$("#discount_type").val("");
				
				$(".website_option").each(function(){
					var option_value=$(this).val();
					optionValue=option_value.toLowerCase();
					website=website.toLowerCase();
					var n=website.indexOf(optionValue);
					if(n!=-1)
					{
						$("#website").val(option_value);
					}
				});
				var check_website=$("#website").val();
				if(check_website=="")
				{
					$(".website_option").each(function(){
						
						var option_value=$(this).val();
						optionValue=option_value.toLowerCase();
						deal_url=deal_url.toLowerCase();
						var n=deal_url.indexOf(optionValue);
						if(n!=-1)
						{
							$("#website").val(option_value);
						}
					});
				}
				
				$(".bank_option").each(function(i){
					
					var bank_value=$(this).val();
					bankValue=bank_value.toLowerCase();
					dscription=dscription.toLowerCase();
					var search=dscription.indexOf(bankValue);
					if(search!=-1)
					{
						$("#bank").val(bank_value);
					}
				});
				
					
				dscription=dscription.toLowerCase();
				var search_discount=dscription.indexOf('%');
				if(search_discount!=-1)
				{
					$("#discount_type").val("percentage");
				}
				
			    
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
		$("#parse_data").attr("border","0");
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
	
   .ui-datepicker { width: 12em; padding: .2em .2em 0; display: none; }
   .ui-datepicker table {width: 100%; font-size: .7em; border-collapse: collapse; margin:0 0 .4em; }
   .ui-datepicker .ui-datepicker-title select { font-size:15px; margin:1px 0; }

	
</style>

</head>

<?php
require_once 'couponClass.php';
require_once '../smartmodel/UI.php';
require_once '../smartmodel/UI/Util/UIUtil.php';

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
			<a class="add_coupon" style="text-decoration:none;color:white;" href="#parse_data">Add Coupon</a>
		</div>
	</div>
	
</div>
<?php 

$user = new coupon_parse();
$util=new UIUtil();
if(isset($_REQUEST['submit_coupon_parse']))
{
	$uniq_id=$_REQUEST['uniq_id'];
	$coupon_code=$_REQUEST['parse_coupon_code'];
	$coupon_type=$_REQUEST['coupon_type'];
	$deal_url=$_REQUEST['parse_deal_url'];
	$title=$_REQUEST['title'];
	$website=$_REQUEST['parse_website'];
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
?>
	<div style="display:none"><a href="#pdata" class="fancylink">Click</a></div>
<?php 


//code starts here for sorting the column ID in descending order
$usersTable->sortCol='id'; 
$usersTable->sorting='desc';
//code ends here for sorting the column ID in descending order

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
</div>
<div style="clear:both;"></div>

<!--code starts here for adding a new coupon to coupon parse table-->
<div  name="parse_data" >
	
		<table style="display:none" id="parse_data">
			<form method="post" name="add_parse" action="couponParse.php">
			<tr>
				<td><label>Unique ID</label></td>
				<td><input type="text" name="uniq_id" id="uniq_id"></input></td>
				<td><span id="uniq_idErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Code</label></td>
				<td><input type="text" name="parse_coupon_code" id="parse_coupon_code"></input></td>
				<td><span id="parse_coupon_codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Type</label></td>
				<td><input type="text" name="coupon_type" id="coupon_type"></input></td>
				<td><span id="coupon_typeErr"></span></td>
			</tr>
			<tr>
				<td><label>Deal URL</label></td>
				<td><input type="text" name="parse_deal_url" id="parse_deal_url"></input></td>
				<td><span id="parse_deal_urlErr"></span></td>
			</tr>
			<tr>
				<td><label>Title</label></td>
				<td><input type="text" name="title" id="title"></input></td>
				
				<td><span id="titleErr"></span></td>
			</tr>
			<tr>
				<td><label>Website</label></td>
				<td><input type="text" name="parse_website" id="parse_website"></input></td>
				<td><span id="parse_websiteErr"></span></td>
			</tr>
			<tr>
				<td><label>Description</label></td>
				<td>
					<textarea rows="10" cols="30" name="desc" id="desc"></textarea>
				</td>
				<td><span id="descErr"></span></td>
			</tr>
			<tr>
				<td><label>Success</label></td>
				<td><input type="text" name="success" id="success"></input></td>
				<td><span id="successErr"></span></td>
			</tr>
			<tr>
				<td><label>Code</label></td>
				<td><input type="text" name="code" id="code"></input></td>
				<td><span id="codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Status</label></td>
				<td>
					<select id="status" name="status">
						<option value="0">Read</option>
						<option value="1">Ignore</option>
					</select>
				</td>
				<td><span id="statusErr"></span></td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" name="submit_coupon_parse" id="submit_coupon_parse" value="Submit"></input></td>
			</tr>
			</form>
		</table>
		
</div>

<!--code ends here for adding a new coupon to coupon parse table-->


<!--code starts here for adding a new coupon to coupon active table-->
<div style="display:none" name="pdata1" id="pdata">
<?php 

require_once '../Parsing.php';

?>
<form method="post" name="add_parse" action="index.php">

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
				<select name="discount_type" required="true" id="discount_type">
					<option class="discount_option" value="">Select</option>
					<option class="discount_option" value="percentage">Percentage</option>
					<option class="discount_option" value="fixed">Fixed</option>
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
					
					
					<option class="website_option" value="<?php echo $site; ?>"><?php echo $site; ?></option>
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
			</td>
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
					<option class="bank_option" value="None">Select</option>
					<option class="bank_option" value="HDFC">HDFC</option>
					<option class="bank_option" value="PNB">PNB</option>
					<option class="bank_option" value="ICICI">ICICI</option>
					<option class="bank_option" value="SBI">SBI</option>
					<option class="bank_option" value="HSBC">HSBC</option>
					<option class="bank_option" value="CANARA">Canara</option>
					<option class="bank_option" value="CITY_BANK">City Bank</option>
					<option class="bank_option" value="Axis">Axis</option>
					<option class="bank_option" value="Bank of Baroda">Bank of Baroda</option>
					<option class="bank_option" value="Bank of India">Bank of India</option>
					<option class="bank_option" value="Corporation">Corporation Bank</option>
					<option class="bank_option" value="Dena">Dena</option>
					<option class="bank_option" value="IDBI">IDBI</option>
					<option class="bank_option" value="United Bank of India">United Bank of India</option>
					<option class="bank_option" value="Kotak Mahindra">Kotak Mahindra Bank</option>
					<option class="bank_option" value="YES">Yes Bank</option>
					<option class="bank_option" value="Federal">Federal Bank</option>
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
			<td><input type="hidden" id="parse_id" name="parse_id"></input></td>
		</tr>
	</table>
	
</form>
</div>
<!--code ends here for adding a new coupon to coupon active table-->
