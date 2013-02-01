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

	$data = $follow->read(null,array('query_id'=>$query_id));
	$found = false;
	if(isset($data[0])){
		$follow_id = $data[0]['id'];
		$data = $follow->query('select * from follow_url_map where follow_id = '.$follow_id);
		$data = mysql_fetch_assoc($data);
		foreach($data as $row){
			if($row['userid'] == $_SESSION['userid']){
				$found = true;
				$return['error'] = 3;
				break;
			}
		}

	}else{
		$follow->follow_start = time();
		$follow->insert();
		$follow_id = $follow->lastInsertId();
	}
	if(!$found){
		$data = $search->read(null,array('query_id'=>$query_id));
		if(isset($data[0])){
			$row = $data[0];
			$website_data = $row['website_data'];
			$website_cache = json_decode($row['website_cache_data'],true);

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
				$followUrl->follow_name = $row['name'];
				$followUrl->follow_website = $website;
				$followUrl->prev_data = json_encode($row);
				$followUrl->last_followed = time();
				$followUrl->follow_id = $follow_id;
				$followUrl->insert();
				$id = $followUrl->lastInsertId();
			}

			$followUrl->query('insert into follow_url_map values(0,'.$follow_id.','.$_SESSION['userid'].')');
		}

		$return['error'] = 0;
	}
}else{
	$return['error'] = 1;
}

if(!isset($_REQUEST['silent'])){
	echo json_encode($return);
}