<?php
	define('ROOT_ACCESS', 1);

	require('config.php');

	define('DEBUG', $config['SITE']['DEBUG']);
	error_reporting(DEBUG ? E_ALL : 0);
	date_default_timezone_set($config['SITE']['TIMEZONE']);

	session_start();

	define('SCRIPTS_DIR', './scripts/');
	define('PAGES_DIR', './pages/');
	define('LIBS_DIR', './libs/');

	require(SCRIPTS_DIR.'functions.script.php');
	require(SCRIPTS_DIR.'mysql_connect.script.php');
	
	$page = isset($_GET['page']) ? $_GET['page'] : 'home';

	$token = isset($_POST['token']) ? $_POST['token'] === $_SESSION['TOKEN'] ? true : false : false;
	$_SESSION['TOKEN'] = sha1(rand(time(), true));
	
	require_once(LIBS_DIR.'Twig/Autoloader.php');
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem('./templates');
	$twig = new Twig_Environment($loader, array(
		'cache' => false,
		'charset' => 'utf-8' 
	));

	$cached_pages = array(
		'shop_json',
		'category_json',
		'product_json'
	);
	
	$pagedata = array();
	$pagedata['webroot'] = $config['SITE']['WEBROOT'];
	$pagedata['pathroot'] = $config['SITE']['PATHROOT'];
	$pagedata['token'] = $_SESSION['TOKEN'];
	
	$request_data = implode('-', $_GET);
	$cachefile = './cache/'.md5($request_data).'.json';
	
	if(isset($_SESSION['currentUser'])){
		$pagedata['logged'] = 1;
		
		$params = array($_SESSION['currentUser']['id']);
		$results = array('result');
		ExecutePreparedCallableStatement('CALL checkSiteAdmin(?)', 's', $params, $results, function($results){
			global $pagedata;
			$pagedata['siteadmin'] = $results['result'];
		});
	}else{
		$pagedata['logged'] = 0;
		$pagedata['siteadmin'] = 0;
	}
	
	$pagedata['show_admin_navigation'] = $pagedata['logged'] == 1 && $pagedata['siteadmin'] == 1 && isset($_SESSION['show_admin_navigation']) ? $_SESSION['show_admin_navigation'] : 0;
	
	if(in_array($page, $cached_pages) && !isset($_SESSION['show_admin_navigation'])) {
		$cachetime = $config['SITE']['CACHE_TIME'];
		
		if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
			$fp = fopen($cachefile, 'r');
			$pagedata = json_decode(fread($fp, filesize($cachefile)), TRUE);
			fclose($fp);
			
			$pagedata['webroot'] = $config['SITE']['WEBROOT'];
			$pagedata['pathroot'] = $config['SITE']['PATHROOT'];
			$pagedata['token'] = $_SESSION['TOKEN'];
			
			if(isset($_SESSION['currentUser'])){
				$pagedata['logged'] = 1;
				
				$params = array(&$_SESSION['currentUser']['id']);
				$results = array('result');
				ExecutePreparedCallableStatement('CALL checkSiteAdmin(?)', 's', $params, $results, function($results){
					global $pagedata;
					$pagedata['siteadmin'] = $results['result'];
				});
			}else{
				$pagedata['logged'] = 0;
				$pagedata['siteadmin'] = 0;
			}
			
			header('Content-type: application/json');
			echo json_encode($pagedata);
			return;
		}
	}
	
	switch($page){
		case 'home':
			require(PAGES_DIR.'home.page.php'); break;
		case 'administrator':{
			if($pagedata['logged'] == 1 && $pagedata['siteadmin'] == 1){
				if(isset($_GET['data'])){
					$_SESSION['show_admin_navigation'] = $_GET['data'] == 'on' ? 1 : 0;
				}
				if(isset($_GET['data2'])){
					header('Location: '.$config['SITE']['WEBROOT'].str_replace('ISSEPARATOR', '/', $_GET['data2']));
				}else{
					header('Location: '.$config['SITE']['WEBROOT']);
				}
			}else{
				header('Location: '.$config['SITE']['WEBROOT']);
			}
		} break;
		case 'shop_json':
			require(PAGES_DIR.'shop.json.php'); break;
		case 'category_json':
			require(PAGES_DIR.'category.json.php'); break;
		case 'product_json':
			require(PAGES_DIR.'product.json.php'); break;
		case 'cart_json':
			require(PAGES_DIR.'cart.json.php'); break;
		case 'billing_json':
			require(PAGES_DIR.'billing.json.php'); break;
		case 'products_most_viewed_json':
			require(PAGES_DIR.'products.most.viewed.json.php'); break;
		case 'products_news_json':
			require(PAGES_DIR.'products.news.json.php'); break;
		case 'auth_json':{
			$method = isset($_GET['data']) ? $_GET['data'] : 'manual';
			switch($method){
				case 'googleplus': 
					require(LIBS_DIR.'GoogleApi/auth.php'); break;
				case 'facebook': 
					require(LIBS_DIR.'FacebookApi/auth.php'); break;
				case 'providers':
					require(PAGES_DIR.'auth.providers.json.php'); break;
				case 'current':{
					require(PAGES_DIR.'user.info.json.php'); break;
				} break;
			}
		} break;
		case 'addcart_script':
			require(SCRIPTS_DIR.'cart.product.add.script.php'); break;
		case 'removecart_script':
			require(SCRIPTS_DIR.'cart.product.remove.script.php'); break;
		case 'updatecart_script':
			require(SCRIPTS_DIR.'cart.update.script.php'); break;
		case 'docheckout_script':
			require(SCRIPTS_DIR.'cart.checkout.script.php'); break;
		case 'category_cover_change_script':
			require(SCRIPTS_DIR.'category.cover.change.script.php'); break;
		case 'category_add_script':
			require(SCRIPTS_DIR.'category.add.script.php'); break;
		case 'category_update_script':
			require(SCRIPTS_DIR.'category.update.script.php'); break;
		case 'category_remove_script':
			require(SCRIPTS_DIR.'category.remove.script.php'); break;
		case 'product_add_script':
			require(SCRIPTS_DIR.'product.add.script.php'); break;
		case 'product_image_add_script':
			require(SCRIPTS_DIR.'product.image.add.script.php'); break;
		case 'product_update_script':
			require(SCRIPTS_DIR.'product.update.script.php'); break;
		case 'product_remove_script':
			require(SCRIPTS_DIR.'product.remove.script.php'); break;
		case 'slider_image_change_script':
			require(SCRIPTS_DIR.'slider.image.change.script.php'); break;
		case 'logout':{
			foreach($_SESSION as $k => $v)
				unset($_SESSION[$k]);
			session_destroy();
			
			header('Location: '.$config['SITE']['WEBROOT']);
		} break;
		default:
			require(PAGES_DIR.'home.page.php');
	}
	
	if(in_array($page, $cached_pages)){
		$cachefile = './cache/'.md5($request_data).'.json';
		$fp = fopen($cachefile, 'w');
		fwrite($fp, json_encode($pagedata));
		fclose($fp);
	}
?>