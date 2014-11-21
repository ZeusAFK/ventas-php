<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();
	
	$template = $twig->loadTemplate('main.template.html');
	
	$pagedata['title'] = $config['SITE']['TITLE'];
	$pagedata['version'] = $config['SITE']['VERSION'];
	$pagedata['description'] = $config['SITE']['DESCRIPTION'];
	
	echo $template->render($pagedata);
?>