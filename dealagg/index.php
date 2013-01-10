<?php
	session_start();
?>
<?php 
	include 'header.html';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
</head>
<body>

<?php 
	require_once 'Parsing.php';
	
	$parsing = new Parsing();//creating object for parsing class
	$sites = $parsing->getWebsites();//get list of websits to be scraped
	foreach ($sites as $site)
	{
		require_once 'Sites/'.$site.'.php';
		$siteObj = new $site;
		try
		{
			$siteData[] = $siteObj->getAllData();//get all the avilable data
		}
		catch(Exception $e)
		{
			echo"<pre>";
			print_r($e);
			echo"</pre>";
		}
		/*
?>
<div id="deals" class="deals-list">
	<div id="inner-deals" class="inner-deals">
			<div class="deal deal-card shop">
				<div class="header-box">
					<div class="header-box-header">
						<h3 class="header-box-header-text">
							<?php echo ?>
							<div class="time-ago">
								<span>2d ago</span>
							</div>
						</h3>
					</div>
					<div class="discount">
						<span class="discount-amount amount">20</span>
						<div class="discount-label">
							<span class="symbol-right">%</span>
						</div>
						<span class="discount-text text">off</span>
					</div>
					<div class="deal-content">
						<a href="/shop/3S/sale/the-spirit-of-sound/"
							class="deal_url deal-thumbnail"><img
							src="//b.yipitcdn.com/cache/delivered_product/2e78117aad1e6844c6e3defb7c22503fd2f1b9f0-1355840587_display_306x268.jpg"
							alt="The Spirit of Sound" class="deal-thumbnail-image"> </a>
						<div class="details">
							<div class="title">
								<a href="/shop/3S/sale/the-spirit-of-sound/" class="deal_url">Focal</a>
							</div>
							<div class="deal-business-info">
								<a target="_blank" href="/shop/3S/sale/the-spirit-of-sound/"
									class="business-name">The Spirit of Sound</a>
							</div>
							<div class="deal-info">
								<div class="time-info">
									<span class="time-info-amount amount">2</span><span
										class="time-info-text text">days left</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php 
*/
	}//end all sites foreach
	/*  echo"<pre>";
	print_r($siteData);
	echo"</pre>";  */
	$dealcount=count($siteData);
	?>
	
	<table class="dealtable">
	
<?php 	
	for($i=0;$i<$dealcount;$i=$i+1){
		//echo $i;
		$dealdata= count($siteData[$i])-2; ?>
	<tr>
	<th colspan="5"><?php echo $siteData[$i]['sitename'];?></th>
	</tr>	
	<tr>
		<th style="width:20%;">Name</th>
		<th>Price With Discount</th>
		<th>Image</th>
		
	</tr>	
	
		<?php for($j=0;$j<$dealdata;$j=$j+1){ ?>
		<tr>
		
		<td>
				<a href="<?php echo $siteData[$i][$j]['href'];?>" target="_blank"><?php echo $siteData[$i][$j]['name'];?></a>
		</td>
		<td>
				Price :<?php echo $siteData[$i][$j]['price'];?><br/>
				Discount :<?php echo $siteData[$i][$j]['off'];?>
		</td>
		<td width="100">
				
				<img src="<?php echo $siteData[$i][$j]['image'];?>" height="100" width="100"/><br/>
				<a href="<?php echo $siteData[$i][$j]['image'];?>" target="_blank">Full Image View</a>
		</td>
		
		</tr>
		<?php } ?>	
	

<?php } ?>
</table>
		
	

</body>
</html>


<?php 
	include 'footer.html';
?>

<style type="text/css">
table.dealtable {background-color:transparent;border-collapse:collapse;width:90%;margin-left: 64px;
    margin-top: 24px;}
table.dealtable th, table.dealtable td {text-align:center;border:1px solid black;padding:5px;}
table.dealtable th {background-color:AntiqueWhite;width: 100px;}

</style>