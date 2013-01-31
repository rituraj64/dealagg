<?php
if(!isset($_SESSION)){
	ini_set('session.cookie_domain', '.pricegenie.in');
	session_set_cookie_params(0, '/', '.pricegenie.in');
	session_start();
	if(isset($_REQUEST[session_name()]) && $_REQUEST[session_name()] != session_id()){
		$request_id = $_REQUEST[session_name()];
		session_id($request_id);
	}
}
$return = array();
if(isset($_REQUEST['query_id']) && isset($_SESSION['userid'])){
	$query_id = $_REQUEST['query_id'];
	require_once 'model/Search.php';
	$search = new Search();
	$search->update(array('is_followed'=>1),array('query_id'=>$query_id));

	require_once 'model/Follow.php';
	$follow = new Follow();
	$follow->query_id = $query_id;
	$follow->follow_start = time();
	$follow->userid = 1;
	$follow->insert();
	$follow_id = $follow->lastInsertId();

	$data = $search->read(null,array('query_id'=>$query_id));
	if(isset($data[0])){
		$row = $data[0];
		$website_data = $row['website_data'];
		$website_cache = json_decode($row['website_cache'],true);

		$website_data = explode('$',$website_data);

		$websites_order = array();

		foreach($website_data as $web){
			if(empty($web)){
				continue;
			}
			$web = explode(':',$web);
			if(!isset($websites_order[$web[1]])){
				$websites_order[$web[1]] = array();
			}
			$websites_order[$web[1]][] = $web[0];
		}
		$index = 0;
		foreach($websites_order['RESULT'] as $website){
			$row = $website_cache[$website];
			require_once 'model/FollowUrl.php';
			$followUrl = new FollowUrl();
			$followUrl->follow_url = $row['url'];
			$followUrl->follow_website = $website;
			$followUrl->prev_data = json_encode($row);
			$followUrl->last_followed = time();
			$followUrl->insert();
			$id = $followUrl->lastInsertId();
				
			$followUrl->query('insert into follow_url_map values(0,'.$follow_id.','.$id.')');
		}
	}

	$return['error'] = 0;
}else{
	$return['error'] = 1;
}

if(!isset($_REQUEST['silent'])){
	echo json_encode($return);
}