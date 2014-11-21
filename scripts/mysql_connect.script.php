<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	$mysqli = new mysqli($config['DB']['HOST'], $config['DB']['USR'], $config['DB']['PSW'], $config['DB']['NAME'], $config['DB']['PORT']);
	
	if($mysqli->connect_errno){
		if(DEBUG) die("Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		else die();
	}
	
	function ExecutePreparedCallableStatement($query, $types, $params, $results, $callback){
		global $mysqli;
		
		$stmt = $mysqli->prepare($query);
		
		$referencedParams = array();
		foreach($params as $k => $param){
			$referencesParams[$k] = &$params[$k];
		}
		
		if(sizeof($params) > 0){
			call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $referencesParams));
		}
		
		$executed = $stmt->execute();
		
		if(!$executed){
			global $pagedata;
			$pagedata['mysqli_error'] = $mysqli->error;
		}
		
		$formattedResults = array();
		$valuesContainer = array();
		foreach($results as $k => $value){
			$valuesContainer[$k] = null;
			$formattedResults[$value] = &$valuesContainer[$k];
		}
		
		if(sizeof($results) > 0){
			call_user_func_array(array($stmt, "bind_result"), $formattedResults);
		}
		
		if(function_exists('mysqli_fetch_all')){
			do {
				$stmt->store_result();
				while($stmt->fetch()){
					$callback($formattedResults);
				}
			} while ($stmt->more_results() && $stmt->next_result());
		}else{
			$stmt->store_result();
			while($stmt->fetch()){
				$callback($formattedResults);
			}
			$stmt->free_result();
			$stmt->close();
			while ($mysqli->more_results()){
				$mysqli->next_result();
				$result = $mysqli->use_result();
				if ($result instanceof mysqli_result) {
					$result->free();
				}
			}
		}
		
		return $executed ? true : false;
	}
?>