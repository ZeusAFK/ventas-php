<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	$providers = array();
	
	$importing_module = TRUE;
	
	unset($pagedata['response']);
	
	require(LIBS_DIR.'GoogleApi/auth.php');
	
	if(isset($pagedata['response'])){
		$providers[sizeof($providers)] = array(
			'name'			=> 	'Google Oauth2',
			'description'	=>	'Conectate con tu cuenta Google+',
			'module'		=>	'googleplus',
			'style'			=>	'googleoauth2',
			'icon'			=>	'icon-googleplus',
			'image'			=>	'sign-in-with-google.png',
			'auth_url'		=>	$pagedata['response']['auth_url']
		);
	}
	
	unset($pagedata['response']);
	
	require(LIBS_DIR.'FacebookApi/auth.php');
	
	if(isset($pagedata['response'])){
		$providers[sizeof($providers)] = array(
			'name'			=> 	'Facebook Login',
			'description'	=>	'Facebook login para sitios web',
			'module'		=>	'facebook',
			'style'			=>	'facebookoauth2',
			'icon'			=>	'icon-facebook',
			'image'			=>	'facebook_rect-f93008b667bd663e62ea3553738d13c0.png',
			'auth_url'		=>	$pagedata['response']['auth_url']
		);
	}
	
	$pagedata['status'] = 1;
	$pagedata['providers'] = $providers;
	
	unset($pagedata['response']);
	
	echo json_encode($pagedata);
?>