<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	function stringURLSafe($string){
        $str = str_replace('-', ' ', $string);
        $str = str_replace('_', ' ', $string);
        $str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);
        $str = trim(strtolower($str));
        return $str;
    }
	
?>