<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	if(!isset($importing_module) || !$importing_module)
		header('Content-type: application/json');
		
	$config_key = 'tos_text';
	$params = array($config_key);
	$results = array('config_value');
	ExecutePreparedCallableStatement('CALL getConfigurationValue(?)', 's', $params, $results, function($results) use (&$pagedata, $config_key){
		$pagedata[$config_key] = $results['config_value'];
	});
	
	if(!isset($importing_module) || !$importing_module)
		echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>