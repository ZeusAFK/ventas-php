<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	if(isset($_SESSION['currentUser'])){
		$userinfo = $_SESSION['currentUser'];
		
		$params = array($userinfo['id']);
		$results = array('quantity');
		ExecutePreparedCallableStatement('CALL getCartQuantity(?)', 's', $params, $results, function($results){
			global $pagedata;
			
			$pagedata['cart'] = array(
				'quantity'	=>	$results['quantity']
			);
		});
		
		$pagedata['status'] = 1;
		$pagedata['userinfo'] = array(
			'id'				=>	utf8_encode($userinfo['id']),
			'email'				=>	utf8_encode($userinfo['email']),
			'name'				=>	utf8_encode($userinfo['name']),
			'picture'			=>	utf8_encode($userinfo['picture']),
			'access_provider'	=>	utf8_encode($userinfo['access_provider'])
		);
	}else{
		$pagedata['status'] = 0;
	}
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>