<?php
require_once dirname(__FILE__).'/../smartmodel/SmartModel.php';
class Follow extends SmartModel{
	public $id;
	public $query_id;
	public $follow_start;
	public $follow_end;
	public $follow_reason;
	public $userid;

	public $_table = "follow";
	public $_fields = array('id','query_id','follow_start','follow_end','follow_reason','userid');

	public function report($id,$prev_data,$new_data,$additional = array()){

		$data = $this->query('select * from follow_url_map where follow_id = '.$id);
		$data = mysql_fetch_assoc($data);

		require_once 'phpMailer/class.phpmailer.php';
		require_once 'model/User.php';

		if(isset($data['userid'])){
			$data = array($data);
		}

		$to = array();

		foreach($data as $row){
			$userid = $row['userid'];

			$user = new User();
			$data1 = $user->read(null,array('id'=>$row['id']));
			if(isset($data1[0])){
				$to[] = array('email'=>$data1[0]['email'],'name'=>$data1[0]['firstname']);
			}

		}

		$subject = 'Follow Pricing Update For '.$prev_data['name'];
		$message = '';
		$today = date("D M j Y h:i");
		$mail = new phpmailer();
		$mail->setFrom($to, 'PriceGenie');
		$mail->Subject    =$subject;
		$message = 'Old Price = '. $prev_data['disc_price'].'<br/>';
		$message .= 'New Price = '. $new_data['disc_price'].'<br/>';
		$message .= 'Product Name = '. $new_data['name'].'<br/>';
		$message .= 'New Product URL = '. $new_data['url'].'<br/>';
		$message .= 'Old Product URL = '. $prev_data['url'].'<br/>';

		if(isset($additional['coupon'])){
			$message .= 'User Coupon = '. print_r($additional['coupon'],true).'<br/>';
		}

		$mail->MsgHTML($message);
		$mail->AddAddress('manish@excellencetechnologies.in', "Manish");
		foreach($to as $t){
			$mail->AddCC($t['email'],$t['name']);
		}


		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
}