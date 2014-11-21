<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	$slider = array();
	
	$params = array();
	$results = array('id', 'filename', 'link', 'status');
	ExecutePreparedCallableStatement('CALL getSliderElements()', '', $params, $results, function($results){
		global $slider;
		
		$slider[sizeof($slider)] = array(
			'id'		=>	$results['id'],
			'filename'	=>	$results['filename'],
			'link'		=>	$results['link'],
			'status'	=>	$results['status']
		);
	});
	
	$categories = array();
	
	$params = array();
	$results = array('id', 'name', 'description', 'picture', 'shortname', 'parent');
	ExecutePreparedCallableStatement('CALL getCategories()', '', $params, $results, function($results){
		global $categories;
		
		if($results['parent'] == 0){
			$categories[$results['id']] = array(
				'id'			=> $results['id'],
				'name'			=> $results['name'],
				'description'	=> $results['description'],
				'picture'		=> $results['picture'],
				'shortname'		=> $results['shortname'],
				'subcategories'	=> array()
			);
		}else{
			$categories[$results['parent']]['subcategories'][sizeof($categories[$results['parent']]['subcategories'])] = array(
				'id'			=> $results['id'],
				'name'			=> $results['name'],
				'description'	=> $results['description'],
				'picture'		=> $results['picture'],
				'shortname'		=> $results['shortname']
			);
		}
	});
	
	$topViewerProducts = array();
	
	$params = array();
	$results = array('productId', 'productName', 'productShortname', 'productDescription', 'productDetails', 'productPrice', 'productViews', 'productCreated', 'currencyId', 'currencySymbol', 'currencyName', 'currencyDescription', 'categoryId', 'categoryName', 'categoryShortname', 'categoryDescription', 'pictureId', 'pictureFile', 'pictureTitle');
	ExecutePreparedCallableStatement('CALL getTopViewedProducts()', '', $params, $results, function($results){
		global $topViewerProducts;
		
		$topViewerProducts[sizeof($topViewerProducts)] = array(
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
	
	$pagedata['slider'] = $slider;
	$pagedata['categories'] = $categories;
	$pagedata['topViewerProducts'] = $topViewerProducts;
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>