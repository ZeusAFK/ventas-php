<?php
	if (!defined('ROOT_ACCESS') || ROOT_ACCESS != 1) die();

	header('Content-type: application/json');
	
	if(!isset($_SESSION['currentUser']) || !isset($_GET['data']) || !isset($_SESSION['show_admin_navigation']) || $_SESSION['show_admin_navigation'] != 1){
		$pagedata['result'] = 0;
		die(json_encode($pagedata));
	}
	
	$pagedata['result'] = 0;
	
	$error_messages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Tipo de archivo no permitido',
        'max_number_of_files' => 'Maximum number of files exceeded',
        'max_width' => 'Image exceeds maximum width',
        'min_width' => 'Image requires a minimum width',
        'max_height' => 'Image exceeds maximum height',
        'min_height' => 'Image requires a minimum height',
        'abort' => 'File upload aborted',
        'image_resize' => 'Failed to resize image'
    );
	
	if(isset($_FILES['image'])){
		$filename = $_FILES['image']['tmp_name'];
		$image_info = getimagesize($filename);
		$type = $image_info[2];
		if($type == IMAGETYPE_JPEG || $type == IMAGETYPE_GIF || $type == IMAGETYPE_PNG){
			$image = null;
			
			if($type == IMAGETYPE_JPEG){   
				$image = imagecreatefromjpeg($filename); 
			}
			else if($type == IMAGETYPE_GIF){
				$image = imagecreatefromgif($filename); 
			}
			else if($type == IMAGETYPE_PNG){ 
				$image = imagecreatefrompng($filename); 
			}
			
			$ratio = 800 / imagesx($image);
			$height = imagesy($image) * $ratio;
			$new_image = imagecreatetruecolor(800, $height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, 800, $height, imagesx($image), imagesy($image));
			
			ob_start();
			if($type == IMAGETYPE_JPEG){
				imagejpeg($new_image, null, 90); 
			}
			else if($type == IMAGETYPE_GIF){
				imagegif($new_image, null); 
			}
			else if($type == IMAGETYPE_PNG){ 
				imagepng($new_image, null);
			}
			$image = ob_get_contents();
			ob_end_clean();
			
			$filename = $_SESSION['TOKEN'].'.'.($type == IMAGETYPE_JPEG ? 'jpg' : $type == IMAGETYPE_GIF ? 'gif' : $type == IMAGETYPE_PNG ? 'png' : 'jpg');
			$filepath = './images/products/';
			
			$fp = fopen($filepath.$filename, 'w');
			fwrite($fp, $image);
			fclose($fp);
			
			$params = array($_GET['data'], $filename);
			$results = array();
			ExecutePreparedCallableStatement('CALL addProductPicture(?,?)', 'is', $params, $results, function($results){});
			
			$pagedata['filename'] = $filename;
			$pagedata['result'] = 1;
		}else{
			$pagedata['result'] = $error_messages['accept_file_types'];
			die(json_encode($pagedata));
		}
	}else{
		$pagedata['result'] = 0;
		$pagedata['error'] = 'Error al recibir el archivo';
	}
	
	echo json_encode($pagedata);
?>