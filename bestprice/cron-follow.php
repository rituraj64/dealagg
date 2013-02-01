<?php


$total_5min = (24 * 60)/5;


$cur_h = date('h');
$cur_m = date('i');

$min_gone = ($cur_h * 60)/5 +  floor($cur_m/5);
$min_left = $total_5min - $min_gone;

$finish_all = false;
if($cur_h == 24){
	$finish_all = true;
}


require_once 'Parsing.php';
require_once 'model/Follow.php';
require_once 'model/FollowUrl.php';
require_once 'model/History.php';

$parsing = new Parsing();
$websites = $parsing->getWebsites();
$parse_queue = array();
$cache_data = array();

$filelist = array();
$dir = dirname(__FILE__).'/cache';
$index = 0;
if ($handle = opendir($dir)) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != "..") {

			$website = false;
			foreach($websites as $web){
				if(strpos($entry,$web) !== false){
					$website = $web;
					break;
				}
			}
			if($website){
				$filename = $dir.'/'.$entry;
				$data = file_get_contents($filename);
				$web_session_data = json_decode($data,true);
				if(!isset($cache_data[$website])){
					$cache_data[$website] = array();
				}
				foreach($web_session_data as $row){
					$cache_data[$website][] = $row;
				}
				//unlink($filename);
			}
			$index++;
			if($index > 10){
				break;
			}
		}
	}
	closedir($handle);
}
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

			$found = false;
			if(isset($cache_data[$website])){
				$rows = $cache_data[$website];
				foreach($rows as $row1){
					if($row1['name'] == $follow_name){
						if($row1['disc_price'] != $prev_data['disc_price']){
							$follow->report($row['follow_id'],$prev_data,$row1);
							$found = true;
							break;
						}
					}
				}
			}

			if(date('Y-m-d',$last) != date('Y-m-d') && !$found){
				require_once 'Sites/'.$website.'.php';
				$siteObj = new $website;
				if($siteObj->hasProductdata()){

					$parse_queue[] = array(
							'website' => $website,
							'product_name' => $follow_name,
							'product_url' => $follow_url,
							'data' => $prev_data,
							'follow_id' => $follow_id,
							'id' => $row['id'],
							'brand' => $row['follow_brand'],
							'model_no' => $row['follow_modelno']
					);

				}
			}
		}
	}
}
$parse_size = sizeof($parse_queue);

$parse_no = ceil($parse_size/$min_left);

$index = 1;
foreach($parse_queue as $row){
	$url = $row['product_url'];
	$prev_data = $row['data'];
	$id = $row['id'];
	$website = $row['website'];

	require_once 'Sites/'.$website.'.php';
	$siteObj = new $website;
	$follow_url = new FollowUrl();
	$html = $parser->getHtml($url);
	if($html){
		$data = $siteObj->getProductData($html,false,false);
		if($data){
			if($data['price'] != $prev_data['disc_price']){

				$follow->report($row['follow_id'],$prev_data,$data);

				$data['disc_price'] = $data['price'];

				$follow_url->update(array('last_followed'=>time(),'prev_data'=>json_encode($data)),array('id'=>$row['id']));
			}else{
				$follow_url->update(array('last_followed'=>time()),array('id'=>$row['id']));
			}
		}
	}

	$index++;
	if($index >= $parse_no){
		if(!$finish_all){
			break;
		}
	}
}
