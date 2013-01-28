<?php
set_time_limit(300000);
require_once 'Parsingcoupon.php';
require_once 'Parsing.php';
require_once 'phpMailer/class.phpmailer.php';
require_once 'phpMailer/class.smtp.php';
require_once 'model/CouponParse.php';

require_once 'detecthtml.php';

require_once 'model/Cache.php';

$parsing = new Parsing();


if($parsing->getCurrentCache() == Parsing::CACHE_DB){
	$cache = new Cache();
	$data = $cache->read();
	foreach($data as $row){
		$hits = $row['hits'];
		$time = $row['time'];

		$days = ($hits + 1) * 7;
		if( time() > $time + $days * 25 * 60 * 60  ){
			$cache->delete(array('id'=>$row['id']));
		}
	}
}

$parsing = new Parsingcoupon();
$sites = $parsing->getCouponWebsites();
$parser = new Parser();

$siteData  = array();
foreach ($sites as $site)
{
	require_once 'Coupon/'.$site.'.php';
	$siteObj = new $site;
	$html = '';
	$url = $siteObj->getUrl();
	if($url){
		$html = $parser->getHtml($url);
	}
	try
	{
		$pagecount = 1;
		if(!empty($html)){
			$a = $siteObj->updateCoupons($html);
			if(empty($siteData)){
				$siteData = $a;
			}else{
				$siteData = array_merge($siteData,$a);
			}
		}
	}
	catch(Exception $e)
	{
		echo"<pre>";
		print_r($e);
		echo"</pre>";
	}
}

//echo $message;
$to = 'manish@excellencetechnologies.in';
$today = date("D M j Y h:i");
$subject = 'Found New Coupons ' . sizeof($siteData) . ' on '.$today;
$message = '';
$mail = new phpmailer();
//$mail->IsSMTP();
//$mail->Host = 'ssl://smtp.gmail.com:465';
//$mail->SMTPAuth   = true;
//$mail->SMTPSecure = "ssl";
//$mail->Host       = "smtp.gmail.com";
//$mail->Port       = 465;
///$mail->Username   = "excellenceseo@gmail.com";
//$mail->Password   = "seo@1234";
$mail->setFrom('excellenceseo@gmail.com', 'PriceGenie');
$mail->Subject    =$subject;
$message = 'Finding Coupon';
$index = 0;
foreach($siteData as $d){
	$message .= $d. '<br/><br/><br/>';
	$index++;
	if($index > 5){
		break;
	}
}
$mail->MsgHTML($message);

$mail->AddAddress($to, "Manish");

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "Message sent!";
}
?>