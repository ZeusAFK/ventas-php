<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_POST['data']) || !isset($_SESSION['show_admin_navigation']) || $_SESSION['show_admin_navigation'] != 1){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$config_key = 'tos_text';
	$data = json_decode($_POST['data']);
	$params = array($config_key, $data->tos_text);
	$results = array('result');
	if(!ExecutePreparedCallableStatement('CALL updateConfigurationValue(?,?)', 'ss', $params, $results, function($results) use (&$pagedata){
		$pagedata['result'] = $results['result'];
	})){
		$pagedata['result'] = 0;
	}
	
	echo json_encode($pagedata);
?>