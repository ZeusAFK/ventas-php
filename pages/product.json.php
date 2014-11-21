<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	if(!isset($_GET['data'])){
		die(json_encode(array('token' => $_SESSION['TOKEN'])));
	}
	
	$product = array();
	
	$params = array($_GET['data']);
	$results = array('productId', 'productName', 'productShortname', 'productDescription', 'productDetails', 'productDelivery', 'productPrice', 'productViews', 'productCreated', 'currencyId', 'currencySymbol', 'currencyName', 'currencyDescription', 'categoryId', 'categoryName', 'categoryShortname', 'categoryDescription', 'subcategoryId', 'subcategoryName', 'subcategoryShortname', 'subcategoryDescription');
	ExecutePreparedCallableStatement('CALL getProduct(?)', 's', $params, $results, function($results){
		global $product;
		
		$product = array(
			'id'				=> $results['productId'],
			'name'				=> $results['productName'],
			'shortname'			=> $results['productShortname'],
			'description'		=> $results['productDescription'],
			'details'			=> $results['productDetails'],
			'delivery'			=> $results['productDelivery'],
			'price'				=> $results['productPrice'],
			'views'				=> $results['productViews'],
			'created'			=> $results['productCreated'],
			'currency'			=> array(
				'id'			=> $results['currencyId'],
				'symbol'		=> $results['currencySymbol'],
				'name'			=> $results['currencyName'],
				'description'	=> $results['currencyDescription']
			),
			'category'			=> array(
				'id'				=> $results['categoryId'],
				'name'				=> $results['categoryName'],
				'shortname'			=> $results['categoryShortname'],
				'description'		=> $results['categoryDescription'],
				'parent'		=> array(
					'id'			=> $results['subcategoryId'],
					'name'			=> $results['subcategoryName'],
					'shortname'		=> $results['subcategoryShortname'],
					'description'	=> $results['subcategoryDescription']
				)
			)
		);
	});
	
	if($product['id'] > 0){
		$product['pictures'] = array();
		
		$params = array($product['id']);
		$results = array('id', 'file', 'title');
		ExecutePreparedCallableStatement('CALL getProductPictures(?)', 'i', $params, $results, function($results){
			global $product;
			
			$product['pictures'][sizeof($product['pictures'])] = array(
				'id'		=> $results['id'],
				'file'		=> $results['file'],
				'title'		=> $results['title']
			);
		});
	}
	
	$pagedata['product'] = $product;
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>