<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	header('Content-type: application/json');
	
	$products = array();
	$total_price = 0;
	
	if(isset($_SESSION['currentUser'])){
		$params = array($_SESSION['currentUser']['id']);
		$results = array(
			'productId',
			'productName',
			'productShortname',
			'productDescription',
			'productDetails',
			'productPrice',	
			'productViews',
			'productCreated',
			'currencyId',
			'currencySymbol',
			'currencyName',
			'currencyDescription',
			'categoryId',
			'categoryName',
			'categoryShortname',
			'categoryDescription',
			'pictureId',
			'pictureFile',
			'pictureTitle',
			'cartElementId',
			'productQuantity'
		);
		ExecutePreparedCallableStatement('CALL getCartProducts(?)', 's', $params, $results, function($results){
			global $products;
			global $total_price;
			
			$total_price += $results['productPrice'] * $results['productQuantity'];
			$products[sizeof($products)] = array(
				'id'			=> $results['productId'],
				'name'			=> $results['productName'],
				'shortname'		=> $results['productShortname'],
				'description'	=> $results['productDescription'],
				'details'		=> $results['productDetails'],
				'price'			=> $results['productPrice'],
				'views'			=> $results['productViews'],
				'created'		=> $results['productCreated'],
				'cartid'		=> $results['cartElementId'],
				'quantity'		=> $results['productQuantity'],
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
	
	$pagedata['products'] = $products;
	$pagedata['total_price'] = $total_price;
	
	echo json_encode($pagedata, JSON_UNESCAPED_UNICODE);
?>