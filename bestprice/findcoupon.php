<?php
require_once 'Parsingcoupon.php';
require_once 'phpMailer/class.phpmailer.php';
require_once 'phpMailer/class.smtp.php';

$parsing = new Parsingcoupon();
$sites = $parsing->getCouponWebsites();

foreach ($sites as $site)
{
	require_once 'Coupon/'.$site.'.php';
	$siteObj = new $site;
	try
	{
		$pagecount = 1;
		$siteData[] = $siteObj->getAllData($pagecount);
	}
	catch(Exception $e)
	{
		echo"<pre>";
		print_r($e);
		echo"</pre>";
	}
}
$message = '';
$message .= "
<style>
<!--
*{margin: 0;padding: 0;}
h4{display: inline;}
h5{display: inline;}
.eachsite{margin-top:30px;}
.item{ margin-left: 20px;}
-->
</style>
 ";

foreach ($siteData as $eachSiteData)
{
	$message .= "<div class='eachsite'><h4><u>".$eachSiteData['code']."</u></h4><br><br>";
	foreach ($eachSiteData as $oneItem)
	{
		if(!is_array($oneItem))
			continue;
		
	$message .="<div class='item'>
					<h4>".$oneItem['span']." :</h4>
					<h5>
						<a id='".$oneItem['id']."' href='".$oneItem['href']."'>
							".$oneItem['text']."
						</a>
					</h5>
					<br>
				</div>";
	}
	$message .="</div>";
}
//echo $message;
$to = 'isvarified@gmail.com';
$today = date("D M j Y");
$subject = 'coupons parsed on '.$today;

$mail = new phpmailer();
$mail->IsSMTP();
//$mail->Host = 'ssl://smtp.gmail.com:465';
$mail->SMTPAuth   = true;                 
$mail->SMTPSecure = "ssl";                
$mail->Host       = "smtp.gmail.com";     
$mail->Port       = 465; 
$mail->Username   = "isvarified@gmail.com";
$mail->Password   = "alpha1-1";
$mail->setFrom('isvarified@yourdomain.com', 'First Last');
$mail->Subject    =$subject;
$mail->MsgHTML('123');

$address = "isvarified@gmail.com";
$mail->AddAddress($address, "hugo mishra");

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
// $headers = 'From: webmaster@example.com';
// mail($to, $subject, $message, $headers);
	/*  echo"<pre>";
	print_r($siteData);
	echo"</pre>";  */
?>