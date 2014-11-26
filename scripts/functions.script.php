<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	function stringURLSafe($string){
        $str = str_replace('-', ' ', $string);
        $str = str_replace('_', ' ', $string);
        $str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);
        $str = trim(strtolower($str));
        return $str;
    }
	
	$default_mailer = function () use($config){
		require(LIBS_DIR.'PHPMailer/PHPMailerAutoload.php');
		
		$mail = new PHPMailer;
	
		$mail->isSMTP();
		$mail->Host = $config['MAIL']['HOST'];
		$mail->SMTPAuth = $config['MAIL']['AUTH'];
		$mail->Username = $config['MAIL']['USER'];
		$mail->Password = $config['MAIL']['PASSWORD'];
		if($config['MAIL']['SECURE']){
			$mail->SMTPSecure = 'ssl';
		}
		$mail->Port = $config['MAIL']['PORT'];
		
		$mail->From = $config['MAIL']['USER'];
		$mail->FromName = $config['SITE']['TITLE'];
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		
		return $mail;
	}
?>