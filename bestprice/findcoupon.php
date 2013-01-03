<?php
require_once 'Parsingcoupon.php';
require_once 'phpMailer/class.phpmailer.php';
require_once 'phpMailer/class.smtp.php';

$parsing = new Parsingcoupon();
$sites = $parsing->getCouponWebsites();

$parser = new Parser();

$siteData  = array();
foreach ($sites as $site)
{
	require_once 'Coupon/'.$site.'.php';
	$siteObj = new $site;
	$html = $parser->getHtml($siteObj->getUrl());
	try
	{
		$pagecount = 1;
		$a = $siteObj->updateCoupons($html);
		if(empty($siteData)){
			$siteData = $a;
		}else{
			$siteData = array_merge($siteData,$a);
		}
	}
	catch(Exception $e)
	{
		echo"<pre>";
		print_r($e);
		echo"</pre>";
	}
}

if(sizeof($siteData) > 0){
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

	//echo $message;
	$to = 'manish@excellencetechnologies.in';
	$today = date("D M j Y");
	$subject = 'Found New Coupons ' . $siteData . ' on '.$today;
	$message = '';
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

	$mail->AddAddress($to, "Manish");

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
}
?>