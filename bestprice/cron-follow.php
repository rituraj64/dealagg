<?php
require_once 'Parsing.php';

$parser = new Parser();

$follow = new Follow();
$data = $follow->read(null,array('follow_end'=>0));

foreach($data as $row){
	$follow_id = $row['id'];

	$follow_url = new FollowUrl();
	$data = $follow_url->read(null,array('follow_id'=>$follow_id));
	if(sizeof($data)){
		foreach($data as $row){
			$website = $row['follow_website'];
			$last = $row['last_followed'];
			$follow_name = $row['follow_name'];
			$follow_url = $row['follow_url'];
			$prev_data = $row['prev_data'];
			$prev_data = json_decode($prev_data,true);

			if(date('Y-m-d',$last) == date('Y-m-d')){
				require_once 'Sites.'.$website.'.php';
				$siteObj = new $website;
				if($siteObj->hasProductdata()){
					$html = $parser->getHtml($follow_url);
					if($html){
						$data = $siteObj->getProductData();
						if($data['disc_price'] != $prev_data['disc_price']){
								echo 'price has changed';
						}
					}
				}
			}
		}
	}
}