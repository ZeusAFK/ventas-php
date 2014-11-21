<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	if(!isset($importing_module) || !$importing_module)
		header('Content-type: application/json');
	
	$provider = 'googleplus';
	
	require(LIBS_DIR.'GoogleApi/autoload.php');
	require(LIBS_DIR.'GoogleApi/src/Google/Service/Oauth2.php');
	
	$client_id = $config['LOGIN']['GOOGLE']['CLIENT_ID'];
	$client_secret = $config['LOGIN']['GOOGLE']['CLIENT_SECRET'];
	$redirect_url = $config['SITE']['WEBROOT']."auth_json/$provider/";
	
	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_url);
	$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
	$client->addScope("https://www.googleapis.com/auth/userinfo.email");
	
	$plus = new Google_Service_Oauth2($client);
	
	if(isset($_GET['code'])){
		$client->authenticate($_GET['code']);
		
		$userinfo = $plus->userinfo->get();
		
		$userid = $userinfo['id'];
		$useremail = $userinfo['email'];
		$username = $userinfo['name'];
		$userpicture = $userinfo['picture'];
		
		$params = array($userid, $useremail, $username, $provider);
		$results = array('result');
		ExecutePreparedCallableStatement('CALL authenticateUser(?,?,?,?)', 'ssss', $params, $results, function($results){
			global $userid;
			global $useremail;
			global $username;
			global $userpicture;
			global $provider;
			
			if($results['result'] == 1){
				$_SESSION['currentUser'] = array(
					'id'				=>	$userid,
					'email'				=>	$useremail,
					'name'				=>	$username,
					'picture'			=>	$userpicture,
					'access_provider'	=>	$provider
				);
			}else{
				unset($_SESSION['currentUser']);
			}
		});
		
		header('Location: '.$config['SITE']['WEBROOT']);
		return;
	}else{
		$pagedata['response'] = array(
			'status'	=> 0,
			'auth_url'	=> utf8_encode($client->createAuthUrl())
		);
	}
	
	if(!isset($importing_module) || !$importing_module)
		echo json_encode($pagedata);
?>