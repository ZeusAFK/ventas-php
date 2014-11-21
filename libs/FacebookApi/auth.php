<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	if(!isset($importing_module) || !$importing_module)
		header('Content-type: application/json');
	
	$provider = 'facebook';
	
	require(LIBS_DIR.'FacebookApi/autoload.php');
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	
	$client_id = $config['LOGIN']['FACEBOOK']['CLIENT_ID'];
	$client_secret = $config['LOGIN']['FACEBOOK']['CLIENT_SECRET'];
	$redirect_url = $config['SITE']['WEBROOT']."auth_json/$provider/";
	
	FacebookSession::setDefaultApplication($client_id, $client_secret);
	$helper = new FacebookRedirectLoginHelper($redirect_url);
	
	if(isset($_GET['code'])){
		$session = $helper->getSessionFromRedirect();
		if ($session){
			$request = new FacebookRequest($session, 'GET', '/me' );
			$response = $request->execute();
			$userinfo = $response->getGraphObject()->asArray();
			
			$request = new FacebookRequest($session, 'GET', '/me/picture', array(
				'redirect' => false,
				'type'     => 'square'
			));
			$response = $request->execute();
			$userpicture = $response->getGraphObject()->asArray();
			
			$userid = $userinfo['id'];
			$useremail = $userinfo['email'];
			$username = $userinfo['name'];
			$userpicture = $userpicture['url'];
			
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
		}
	}else{
		$pagedata['response'] = array(
			'status'	=> 0,
			'auth_url'	=> utf8_encode($helper->getLoginUrl(array('public_profile', 'email')))
		);
	}
	
	if(!isset($importing_module) || !$importing_module)
		echo json_encode($pagedata);
?>