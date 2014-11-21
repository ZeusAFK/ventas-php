<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	if(isset($_SESSION['currentUser'])){
		$orders = array();
		
		$params = array($_SESSION['currentUser']['id']);
		$results = array('id', 'latitude', 'longitude', 'location', 'description', 'contact', 'date', 'status');
		ExecutePreparedCallableStatement('CALL getUserOrders(?)', 's', $params, $results, function($results){
			global $orders;
			
			$orders[sizeof($orders)] = array(
				'id'			=>	$results['id'],
				'latitude'		=>	$results['latitude'],
				'longitude'		=>	$results['longitude'],
				'location'		=>	$results['location'],
				'description'	=>	$results['description'],
				'contact'		=>	$results['contact'],
				'date'			=>	$results['date'],
				'status'		=>	$results['status'],
				'products'		=>	array()
			);
		});
		
		foreach($orders as $k => $order){
			$orderId = $order['id'];
			
			$params = array($orderId);
			$results = array('id', 'quantity', 'name', 'shortname', 'description', 'price', 'currency');
			ExecutePreparedCallableStatement('CALL getOrderProducts(?)', 'i', $params, $results, function($results){
				global $orders;
				global $k;
				
				$orders[$k]['products'][sizeof($orders[$k]['products'])] = array(
					'id'			=>	$results['id'],
					'quantity'		=>	$results['quantity'],
					'name'			=>	$results['name'],
					'shortname'		=>	$results['shortname'],
					'description'	=>	$results['description'],
					'price'			=>	$results['price'],
					'currency'		=>	$results['currency']
				);
			});
		}
		
		$pagedata['orders'] = $orders;
	}
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>