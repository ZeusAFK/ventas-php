<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	if(!isset($_GET['data'])){
		die(json_encode(array('token' => $_SESSION['TOKEN'])));
	}
	
	$category = array();
	
	$params = array($_GET['data']);
	$results = array('id', 'name', 'description', 'picture', 'shortname', 'parentId','parentName', 'parentShortname');
	ExecutePreparedCallableStatement('CALL getCategory(?)', 's', $params, $results, function($results){
		global $category;
		
		$category = array(
			'id'				=> $results['id'],
			'name'				=> $results['name'],
			'description'		=> $results['description'],
			'picture'			=> $results['picture'],
			'shortname'			=> $results['shortname'],
			'parentId'			=> $results['parentId'],
			'parentName'		=> $results['parentName'],
			'parentShortname'	=> $results['parentShortname']
		);
	});
	
	if(isset($category['id']) && $category['id'] > 0){
		$category['subcategories'] = array();
		
		$params = array($category['id']);
		$results = array('id', 'name', 'description', 'picture', 'shortname');
		ExecutePreparedCallableStatement('CALL getSubCategories(?)', 'i', $params, $results, function($results){
			global $category;
			
			$category['subcategories'][sizeof($category['subcategories'])] = array(
				'id'				=> $results['id'],
				'name'				=> $results['name'],
				'description'		=> $results['description'],
				'picture'			=> $results['picture'],
				'shortname'			=> $results['shortname']
			);
		});
		
		$category['products'] = array();
		
		$params = array($category['id']);
		$results = array('productId', 'productName', 'productShortname', 'productDescription', 'productDetails', 'productPrice', 'productViews', 'productCreated', 'currencyId', 'currencySymbol', 'currencyName', 'currencyDescription', 'categoryId', 'categoryName', 'categoryShortname', 'categoryDescription', 'pictureId', 'pictureFile', 'pictureTitle');
		ExecutePreparedCallableStatement('CALL getCategoryProducts(?)', 'i', $params, $results, function($results){
			global $category;
			
			$category['products'][sizeof($category['products'])] = array(
				'id'			=> $results['productId'],
				'name'			=> $results['productName'],
				'shortname'		=> $results['productShortname'],
				'description'	=> $results['productDescription'],
				'details'		=> $results['productDetails'],
				'price'			=> $results['productPrice'],
				'views'			=> $results['productViews'],
				'created'		=> $results['productCreated'],
				'currency'		=> array(
					'id'			=> $results['currencyId'],
					'symbol'		=> $results['currencySymbol'],
					'name'			=> $results['currencyName'],
					'description'	=> $results['currencyDescription']
				),
				'category'		=> array(
					'id'			=> $results['categoryId'],
					'name'			=> $results['categoryName'],
					'shortname'		=> $results['categoryShortname'],
					'description'	=> $results['categoryDescription']
				),
				'picture'		=> array(
					'id'			=> $results['pictureId'],
					'file'			=> $results['pictureFile'],
					'title'			=> $results['pictureTitle']
				)
			);
		});
	}
	
	$pagedata['category'] = $category;
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>