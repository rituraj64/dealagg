<?php
set_time_limit(300000);
require_once 'Parsingcoupon.php';
require_once 'phpMailer/class.phpmailer.php';
require_once 'phpMailer/class.smtp.php';

$fields = array(
		'ac' => 'on',
		'c[0]'=>'China',
		'c[1]'=>'Indonesia',
		'c[2]'=>'Brazil',
		'c[3]'=>'Russian Federation',
		'c[4]'=>'Venezuela',
		'c[5]'=>'United States',
		'c[6]'=>'Thailand',
		'c[7]'=>'Iran',
		'c[8]'=>'Colombia',
		'c[9]'=>'India',
		'c[10]'=>'Ecuador',
		'c[11]'=>'Argentina',
		'c[12]'=>'Peru',
		'c[13]'=>'Ukraine',
		'c[14]'=>'Poland',
		'c[15]'=>'Egypt',
		'c[16]'=>'Bangladesh',
		'c[17]'=>'Chile',
		'c[18]'=>'Turkey',
		'c[19]'=>'Korea, Republic of',
		'c[20]'=>'France',
		'c[21]'=>'Nigeria',
		'c[22]'=>'Serbia',
		'c[23]'=>'Pakistan',
		'c[24]'=>'Germany',
		'c[25]'=>'Iraq',
		'c[26]'=>'Kazakhstan',
		'c[27]'=>'Ghana',
		'c[28]'=>'United Arab Emirates',
		'c[29]'=>'Moldova, Republic of',
		'c[30]'=>'Netherlands',
		'c[31]'=>'Hong Kong',
		'c[32]'=>'Czech Republic',
		'c[33]'=>'Hungary',
		'c[34]'=>'Saudi Arabia',
		'c[35]'=>'Kenya',
		'c[36]'=>'Romania',
		'c[37]'=>'Taiwan',
		'c[38]'=>'Cambodia',
		'c[39]'=>'Taiwan',
		'c[40]'=>'Viet Nam',
		'c[41]'=>'Mexico',
		'c[42]'=>'Spain',
		'c[43]'=>'Philippines',
		'c[44]'=>'Bulgaria',
		'c[45]'=>'Mongolia',
		'c[46]'=>'Malaysia',
		'c[47]'=>'Denmark',
		'c[48]'=>'United Kingdom',
		'c[49]'=>'Canada',
		'c[50]'=>'Nepal',
		'c[51]'=>'Italy',
		'c[52]'=>'Latvia',
		'c[53]'=>'Brunei Darussalam',
		'c[54]'=>'Georgia',
		'c[55]'=>'Albania',
		'c[56]'=>'Sri Lanka',
		'c[57]'=>'Australia',
		'c[58]'=>'Netherlands Antilles',
		'c[59]'=>'Macedonia',
		'c[60]'=>'Guatemala',
		'c[61]'=>'South Africa',
		'c[62]'=>'Palestinian Territory, Occupied',
		'c[63]'=>'Gabon',
		'c[64]'=>'Azerbaijan',
		'c[65]'=>'Reunion',
		'c[66]'=>'Costa Rica',
		'c[67]'=>'Luxembourg',
		'c[68]'=>'Iceland',
		'c[69]'=>'Tajikistan',
		'c[70]'=>'Sudan',
		'c[71]'=>'Zambia',
		'c[72]'=>'Armenia',
		'c[73]'=>'Afghanistan',
		'c[74]'=>'Japan',
		'c[75]'=>'Israel',
		'c[76]'=>'Greece',
		'c[77]'=>'Paraguay',
		'c[78]'=>'Puerto Rico',
		'c[79]'=>'Uruguay',
		'c[80]'=>'Norway',
		'c[81]'=>'Sweden',
		'c[82]'=>'Croatia',
		'c[83]'=>'Botswana',
		'c[84]'=>'Zimbabwe',
		'c[85]'=>'Yemen',
		'c[86]'=>'Bolivia',
		'c[87]'=>'Maldives',
		'c[88]'=>'Slovakia',
		//'p' => '80',
		'pr[0]' => 0,
		'pr[1]' => 2,
		'a[0]' => 4,
		'a[1]' => 3,
		'a[2]' => 2,
		'sp[0]' => 3,
		'ct[0]' => 3,
		's' => '0',
		'o' => '0',
		'pp' => '0',
		'sortBy' => 'date'
);

$parser = new Parser();
$html = $parser->getHtml('http://www.hidemyass.com/proxy-list/',$fields);
$data = array();
phpQuery::newDocumentHTML($html);
foreach(pq('#listtable')->find('tr') as $tr){
	if(pq($tr)->attr('id') == 'theader'){
		continue;
	}
	$index = 1;
	foreach(pq($tr)->children('td') as $td){
		if($index == 2){
			if(!sizeof(pq($td)->children('span'))){
				continue;
			}
			$style = pq($td)->children('span')->children('style')->html();
			$style1 = $style;
			$style = explode('.',$style);
			$hide = array();
			foreach($style as $s){
				if(strpos($s,'display:inline') !== false){

				}else{
					$c = substr($s,0,strpos($s,'{'));
					$hide[] = $c;
				}
			}
			$ip = array();
			$span_html = pq($td)->children('span')->text();
			$span_html = str_replace($style1,'',$span_html);
			foreach(pq($td)->children('span')->children() as $span){
				$s_html = pq($span)->html();
				if($s_html == $style1){
					continue;
				}
				if(!empty($span_html) && !empty($s_html)){
					//echo $span_html.'xxxx'.$s_html.'xx'.strpos($span_html,$s_html).'<br>';
					if(strpos($span_html,$s_html) != 0){
						$x = strpos($span_html,$s_html);
						$ip[] = trim(substr($span_html,0,$x));
						$span_html = substr($span_html,$x+strlen($s_html),strlen($span_html));
					}else{
						$span_html = substr($span_html,strlen($s_html),strlen($span_html));
					}
				}
				if(pq($span)->attr('style') == 'display: inline'){
					$ip[] = trim(pq($span)->html());
				}else {
					$class = pq($span)->attr('class');
					if(!empty($class)){
						if(!in_array($class,$hide)){
							$ip[] = trim(pq($span)->html());
						}
					}
				}
			}
			if(!empty($span_html)){
				$ip[] = $span_html;
			}
			$ip1 = '';
			foreach($ip as $x){
				$ip1 .=$x;
			}
			$ip = $ip1;
		}else if($index == 3){
			$port = pq($td)->text()*1;
		}else if($index == 4){
			$country = pq($td)->text();
		}else if($index == 5){
			$speed = pq($td)->children('div')->children('div')->attr('class');
		}else if($index == 6){
			$connection = pq($td)->children('div')->children('div')->attr('class');
		}else if($index == 7){
			$type = pq($td)->html();
		}
		$index++;
	}
	if($speed == 'fast' && $connection == 'fast'){
		$data[] = array('ip'=>$ip,'port'=>$port,'country'=>$country,'speed'=>$speed,'connection'=>$connection,'type'=>$type);
	}
}
$try = 0;
foreach($data as $row){
	$parser->_noProxy = false;
	$parser->_proxy = $row['ip'].':'.$row['port'];
	try{
		$time = time();
		$parser->_timeout = 30;
		$parser->getHtml('www.flipkart.com');
		$time_taken = (time() - $time);
		//echo $time_taken.'sec by' .$parser->_proxy.'<br/>';

		if($time_taken > 60){
			echo 'Worked';
			$row['time'] = $time_taken;
			print_r($row);
			/*
			 require_once 'model/Proxy.php';
			$proxy = new Proxy();
			$proxy->delete();

			$proxy->proxy = $row['ip'].':'.$row['port'];
			$proxy->data = json_encode($row);
			$proxy->insert();

			$to = 'manish@excellencetechnologies.in';
			$today = date("D M j Y h:i");
			$subject = 'Proxy: New IP';
			$mail = new phpmailer();
			$mail->setFrom('excellenceseo@gmail.com', 'PriceGenie');
			$mail->Subject    =$subject;
			$mail->MsgHTML(print_r($row,true));

			$mail->AddAddress($to, "Manish");

			if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			echo "Message sent!";
			}
			*/
			die;
		}
	}catch(Exception $e){
		echo $e->getMessage().'xx'.print_r($row).'<br/>';
	}

	$try++;
	if($try > 3){
		break;
	}
}
