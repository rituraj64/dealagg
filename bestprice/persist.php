<?php
ini_set('session.cookie_domain', '.pricegenie.in');
session_set_cookie_params(0, '/', '.pricegenie.in');
session_start();
if(isset($_REQUEST[session_name()]) && $_REQUEST[session_name()] != session_id()){
	$request_id = $_REQUEST[session_name()];
	session_id($request_id);
}
require_once 'model/Search.php';

if(isset($_REQUEST['query_id'])){
	$query_id = $_REQUEST['query_id'];
	$time_taken = -1;
	if(isset($_REQUEST['time_taken'])){
		$time_taken = $_REQUEST['time_taken'];
	}
	$website_data_request = urldecode($_REQUEST['website_data']);

	$website_data = explode('$',$website_data_request);

	$websites_order = array();

	$website_cache_data = array();

	foreach($website_data as $web){
		$web = explode(':',$web);
		$website = $web[0];
		$type = $web[1];
		if($type == 'RESULT' || $type == 'BAD'){
			$index = $web[2];
			$filename = 'cache/'.$website.'-'.$query_id;
			if(file_exists($filename)){
				$content = file_get_contents($filename);
				$web_session_data = json_decode($content,true);
				foreach($web_session_data as $row){
					if($row['index'] == $index){
						$website_cache_data[$website] = $row;
						break;
					}
				}
			}
			/*
			 if(isset($_SESSION[$website][$query_id])){
			$web_session_data = $_SESSION[$website][$query_id];
			foreach($web_session_data as $row){
			if($row['index'] == $index){
			$website_cache_data[$website] = $row;
			break;
			}
			}
			}
			*/
		}
	}
	$website_cache_data = json_encode($website_cache_data);
	//$_SESSION = array();


	$searchModel = new Search();
	$searchModel->query_id = $query_id;
	$data = $searchModel->read(null,array('query_id'=>$query_id));
	if(sizeof($data) > 0){
		$row = $data[0];
		if($time_taken == -1){
			if(empty($website_cache_data)){
				$searchModel->update(array('website_data' => $website_data_request),array('id'=>$row['id']));
			}else{
				$searchModel->update(array('website_data' => $website_data_request,'website_cache_data'=>$website_cache_data),array('id'=>$row['id']));
			}
		}else{
			if(empty($website_cache_data)){
				$searchModel->update(array('time_taken'=>$time_taken,'website_data' => $website_data_request),array('id'=>$row['id']));
			}else{
				$searchModel->update(array('time_taken'=>$time_taken,'website_data' => $website_data_request,'website_cache_data'=>$website_cache_data),array('id'=>$row['id']));
			}
		}
		$return[] = array('success'=>'Updated',session_name() => session_id(),'session'=>$_SESSION);
	}else{
		$return[] = array('error'=>'Query ID NOT FOUND');
	}
}else{
	$return[] = array('error'=>'Invalid Request');
}
if(isset($_GET['callback'])){
	echo $_GET['callback'] . '(' . json_encode($return) . ')';
}else{
	echo json_encode($return);
}
