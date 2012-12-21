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
			$siteData = $siteObj->getAllData();//get all the avilable data
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
	echo"<pre>";
	print_r($siteData);
	echo"</pre>";
?>

</body>
</html>


<?php 
	include 'footer.html';
?>