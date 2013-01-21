<?php
require_once 'model/Search.php';

if(isset($_REQUEST['query_id'])){
	$query_id = $_REQUEST['query_id'];
	$time_taken = -1;
	if(isset($_REQUEST['time_taken'])){
		$time_taken = $_REQUEST['time_taken'];
	}
	$website_data = urldecode($_REQUEST['website_data']);

	$searchModel = new Search();
	$searchModel->query_id = $query_id;
	$data = $searchModel->read(null,array('query_id'=>$query_id));
	if(sizeof($data) > 0){
		$row = $data[0];
		if($time_taken != -1){
			$searchModel->update(array('website_data' => $website_data),array('id'=>$row['id']));
		}else{
			$searchModel->update(array('time_taken'=>$time_taken,'website_data' => $website_data),array('id'=>$row['id']));
		}
		$return[] = array('success'=>'Updated');
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
