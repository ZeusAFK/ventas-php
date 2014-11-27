<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_GET['data']) || !isset($_SESSION['show_admin_navigation']) || $_SESSION['show_admin_navigation'] != 1){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$params = array($_GET['data']);
	$results = array('result');
	if(!ExecutePreparedCallableStatement('CALL removeProductPicture(?)', 'i', $params, $results, function($results) use (&$pagedata){
		$pagedata['result'] = $results['result'];
	})){
		$pagedata['result'] = 0;
	}
	
	echo json_encode($pagedata);
?>