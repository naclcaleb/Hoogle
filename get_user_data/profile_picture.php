<?php
session_start();
include 'profile_api.php';

if (validate()){
	$user = new User();
	
	$img = $user->getImage();
	
	$ret_image = fopen($img, 'rb');
	
	header("Content-Type: image/png");
	header("Content-Length: " . filesize(str_replace("http://localhost","/var/www/html",$img)));
	fpassthru($ret_image);
	exit;
}else {
	echo "ERROR";
}
?>