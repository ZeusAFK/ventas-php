<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	// DATABASE CONFIGURATION

	$config['DB']['HOST'] = 'localhost';
	$config['DB']['PORT'] = '3306';
	$config['DB']['USR'] = 'root';
	$config['DB']['PSW'] = '';
	$config['DB']['NAME'] = 'ventas 20141021';
	
	// SITE CONFIGURATION

	$config['SITE']['TITLE'] = 'Sistema de ventas online';
	$config['SITE']['VERSION'] = '1.0';
	$config['SITE']['DESCRIPTION'] = '';
	$config['SITE']['DEBUG'] = TRUE;
	$config['SITE']['TIMEZONE'] = 'America/La_Paz';
	$config['SITE']['WEBHOST'] = 'localhost';
	$config['SITE']['PATHROOT'] = '/ventas/';
	$config['SITE']['CACHE_TIME'] = 1200;

	// LOGIN CONFIGURATION

	$config['LOGIN']['SHA1'] = TRUE;
	$config['LOGIN']['USE_SEED'] = TRUE;
	$config['LOGIN']['SEED'] = 'xxxxxxxxxx-xxxxxxxxx-xxxxxxxxxxx-xxxxxxxxxx';
	$config['LOGIN']['GOOGLE']['CLIENT_ID'] = 'xxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com';
	$config['LOGIN']['GOOGLE']['CLIENT_SECRET'] = 'xxxxxxxxxxxxxxxxxxxxx';
	$config['LOGIN']['FACEBOOK']['CLIENT_ID'] = 'xxxxxxxxxxxxxxx';
	$config['LOGIN']['FACEBOOK']['CLIENT_SECRET'] = 'xxxxxxxxxxxxxxxxxxxxxx';
	
	// IMPLEMENTATION CONSTRAINTS
	$config['SITE']['WEBROOT'] = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.(preg_match('/www/', $_SERVER['HTTP_HOST']) ? 'www.' : '').$config['SITE']['WEBHOST'].$config['SITE']['PATHROOT'];
?>