<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_GET['data']) || !isset($_SESSION['show_admin_navigation']) || $_SESSION['show_admin_navigation'] != 1){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$pagedata['result'] = 0;
	
	$params = array($_GET['data']);
	$results = array('result');
	$success = ExecutePreparedCallableStatement('CALL removeCategory(?)', 'i', $params, $results, function($results){
		global $pagedata;
		
		$pagedata['result'] = $results['result'];
	});
	
	echo json_encode($pagedata);
?>