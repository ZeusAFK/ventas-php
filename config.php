<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	// DATABASE CONFIGURATION

	$config['DB']['HOST'] = 'localhost';
	$config['DB']['PORT'] = '3306';
	$config['DB']['USR'] = 'root';
	$config['DB']['PSW'] = '';
	$config['DB']['NAME'] = 'ventas_20141121';
	
	// SITE CONFIGURATION

	$config['SITE']['TITLE'] = '';
	$config['SITE']['VERSION'] = '1.0';
	$config['SITE']['DESCRIPTION'] = '';
	$config['SITE']['DEBUG'] = TRUE;
	$config['SITE']['TIMEZONE'] = 'America/La_Paz';
	$config['SITE']['WEBHOST'] = 'localhost';
	$config['SITE']['PATHROOT'] = '/ventas/';
	$config['SITE']['CACHE_TIME'] = 1200;
	
	// MAIL SMTP CONFIGURATION
	
	$config['MAIL']['HOST'] = 'localhost';
	$config['MAIL']['PORT'] = 465;
	$config['MAIL']['AUTH'] = TRUE;
	$config['MAIL']['SECURE'] = TRUE;
	$config['MAIL']['USER'] = 'noreply@domain.com';
	$config['MAIL']['PASSWORD'] = '';
	$config['MAIL']['NAME'] = 'Store';

	// LOGIN CONFIGURATION

	$config['LOGIN']['SHA1'] = TRUE;
	$config['LOGIN']['USE_SEED'] = TRUE;
	$config['LOGIN']['SEED'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	$config['LOGIN']['GOOGLE']['CLIENT_ID'] = 'xxxxxxxxxxxxxx-xxxxxxxxxxxxx.apps.googleusercontent.com';
	$config['LOGIN']['GOOGLE']['CLIENT_SECRET'] = 'xxxxxxxx_xxx_xxxxxx';
	$config['LOGIN']['FACEBOOK']['CLIENT_ID'] = 'xxxxxxxxxx';
	$config['LOGIN']['FACEBOOK']['CLIENT_SECRET'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
	
	// IMPLEMENTATION CONSTRAINTS
	$config['SITE']['WEBROOT'] = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.(preg_match('/www/', $_SERVER['HTTP_HOST']) ? 'www.' : '').$config['SITE']['WEBHOST'].$config['SITE']['PATHROOT'];
	$config['free_mysql_result'] = FALSE;
?>