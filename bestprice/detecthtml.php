<?php
$message = 'Problems Found IN <br/>';
require_once dirname(__FILE__).'/model/HtmlDetect.php';
$detect = new HtmlDetect();
$data = $detect->read(null,array('warned'=>0));
$ids = array();
$priority = 0;
foreach($data as $row){
	$ids[] = "'".$row['id']."'";
	if($row['priority'] == 'HIGH'){
		$priority = 1;
	}
}
if(!empty($ids)){
	$detect->query("update html_detect set warned = 1 where ids in (". implode($ids,',') .")");
	
}


$index = 0;
if(sizeof($data) > 0){
	$website = '';
	foreach($data as $row){
		$message .= $row['website'] . ' - ';
		$index++;
		if($index > 5){
			break;
		}
	}
	$to = 'manish@excellencetechnologies.in';
	$today = date("D M j Y h:i");
	$subject = 'Warning: HTML DETECT SYSTEM';
	$mail = new phpmailer();
	//$mail->IsSMTP();
	//$mail->Host = 'ssl://smtp.gmail.com:465';
	//$mail->SMTPAuth   = true;
	//$mail->SMTPSecure = "ssl";
	//$mail->Host       = "smtp.gmail.com";
	//$mail->Port       = 465;
	///$mail->Username   = "excellenceseo@gmail.com";
	//$mail->Password   = "seo@1234";
	$mail->setFrom($to, 'PriceGenie');
	$mail->Subject    =$subject . 'Has Priority = '.$priority;
	$mail->MsgHTML($message);

	$mail->AddAddress($to, "Manish");

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
}