<?php
	ini_set('display_errors', 'Off');
	define("web_title", "Yuno");
	define("favicon", "img/Logo.png");
	date_default_timezone_set('Asia/Bangkok');
	session_start();
	
	$dbhost = 'db';
	$dbuser = 'root';
	$dbpass = 'MYSQL_ROOT_PASSWORD';
	$dbname = 'streaming';

	$dbcon = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	if(mysqli_error($dbcon)) {
		echo 'ติดต่อฐานข้อมูลไม่สำเร็จ';
	}
	mysqli_query($dbcon,"SET NAMES UTF8");
?>