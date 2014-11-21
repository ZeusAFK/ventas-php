<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_POST['data'])){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$cartItems = json_decode($_POST['data']);
	
	foreach($cartItems as $id => $quantity){
		$params = array($_SESSION['currentUser']['id'], $id, $quantity);
		$results = array('result');
		ExecutePreparedCallableStatement('CALL updateProductInCartQuantity(?,?,?)', 'sii', $params, $results, function($results){
			global $pagedata;
			
			$pagedata['result'] = $results['result'];
		});
	}
	
	echo json_encode($pagedata);
?>