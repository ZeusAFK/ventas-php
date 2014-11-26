<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_POST['data'])){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$pagedata['result'] = 0;
	
	$geolocation = json_decode($_POST['data']);
	$description = '';
	$contact = $geolocation->contact;
	
	$params = array(
		$_SESSION['currentUser']['id'],
		$geolocation->latitude,
		$geolocation->longitude,
		$geolocation->geocode,
		$description,
		$contact
	);
	
	$results = array();
	
	$result = ExecutePreparedCallableStatement('CALL checkOutCart(?,?,?,?,?,?)', 'sddsss', $params, $results, function($results){});
	
	$pagedata['result'] = $result ? 1 : 0;
	
	if($result){
		$importing_module = true;
		require(PAGES_DIR.'billing.json.php');
		
		$template = $twig->loadTemplate('billing.mail.template.html');
		
		$pagedata['user'] = $_SESSION['currentUser'];
		$pagedata['site'] = $config['SITE']['TITLE'];
		
		$mail = $default_mailer();
		$mail->addAddress('sales@domain.com', 'Sales');
		$mail->addReplyTo('sales@domain.com', 'Sales');
		$mail->Subject = '[domain] Nuevo pedido - '.$_SESSION['currentUser']['name'];
		$mail->Body = $template->render($pagedata);
		if(!$mail->send()){
			$pagedata['mail_error'] = $mail->ErrorInfo;
		}
	}
	
	echo json_encode($pagedata);
?>