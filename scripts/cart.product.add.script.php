<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_GET['data']) || !is_numeric($_GET['data']) || !isset($_SESSION['currentUser'])){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$product = $_GET['data'];
	
	$params = array($_SESSION['currentUser']['id'], $product);
	$results = array('result');
	ExecutePreparedCallableStatement('CALL addProductToCart(?,?)', 'si', $params, $results, function($results){
		global $pagedata;
		
		$pagedata['result'] = $results['result'];
	});
	
	$params = array($_SESSION['currentUser']['id']);
	$results = array('quantity');
	ExecutePreparedCallableStatement('CALL getCartQuantity(?)', 's', $params, $results, function($results){
		global $pagedata;
		
		$pagedata['quantity'] = $results['quantity'];
	});
	
	echo json_encode($pagedata);
?>