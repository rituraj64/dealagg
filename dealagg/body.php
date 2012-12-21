<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Insert title here</title>
</head>
<frameset>
    <frame>
    <frame>
    <noframes>
    <body>
    <p>This page uses frames. The current browser you are using does not support frames.</p>
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
		}
		echo"<pre>";
		print_r($siteData);
		echo"</pre>";
	?>
    </body>
    </noframes>
</frameset>
</html>