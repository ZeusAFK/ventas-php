<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_GET['data']) || !isset($_POST['data']) || !isset($_SESSION['show_admin_navigation']) || $_SESSION['show_admin_navigation'] != 1){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$pagedata['result'] = 0;
	
	$data = json_decode($_POST['data']);
	
	$alias = stringURLSafe($data->productName);
	
	$productName = $data->productName;
	$productPrice = $data->productPrice;
	$productDescription = $data->productDescription;
	$productDetails = $data->productDetails;
	$productDelivery = $data->productDelivery;
	
	$params = array($_GET['data'], $productName, $productPrice, $alias, $productDescription, $productDetails, $productDelivery);
	$results = array('newAlias');
	ExecutePreparedCallableStatement('CALL updateProduct(?,?,?,?,?,?,?)', 'isdssss', $params, $results, function($results){
		global $pagedata;
		global $newAlias;
		
		$pagedata['alias'] = $results['newAlias'];
		$pagedata['result'] = 1;
	});
	
	echo json_encode($pagedata);
?>