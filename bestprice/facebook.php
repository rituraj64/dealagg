<?php
require 'facebook/src/facebook.php';
require_once 'Parser.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
		'appId'  => Parser::FB_APPKEY,
		'secret' => Parser::FB_APPSEC,
));

$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.

		$timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

		$user_profile = $facebook->api('/me');
		require_once 'model/User.php';
		$user = new User();
		$user->email = $user_profile['email'];
		$user->fb_id = $user_profile['id'];

		$data = $user->read(null,array('fb_id'=>$user_profile['id']));
		if(sizeof($data) == 0){
			$user->firstname = $user_profile['first_name'];
			if(isset($user_profile['last_name'])){
				$user->lastname = $user_profile['last_name'];
			}
			$user->time = time();
			$user->insert();
			$user_id = $user->lastInsertId();
			$name = $user->firstname;
			if($user->lastname){
				$name .= ' '.$user->lastname;
			}
		}else{
			$user->smartAssign($data[0]);
			$user_id = $data[0]['id'];
			$name = $user->firstname;
			if($user->lastname){
				$name .= ' '.$user->lastname;
			}
		}
		session_set_cookie_params(0, '/', '.pricegenie.in');
		session_start();
		$_SESSION['userid'] = $user_id;
		$_SESSION['name'] = $name;
		
		if(isset($_REQUEST['query_id'])){
			$query_id = $_REQUEST['query_id'];
			
		}
		
		if(isset($_REQUEST['redirect'])){
			header('Location: '.$_REQUEST['redirect']);
		}else{
			header('Location: '.Parser::SITE_URL.'index.php');
		}
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
		header('Location: '.Parser::SITE_URL.'index.php?error'.$e->getMessage());
	}
}
