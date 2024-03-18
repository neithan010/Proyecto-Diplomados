<?php
	$hostname = '172.16.206.12';
	//$hostname = '192.168.5.3';
	$database = 'intranet';
	$username = 'and32x';
	$password = '';

	//Conexión mediante PDO
	try{
	// $con = new PDO('mysql:host='.$hostname_cn_form.';dbname='.$database_cn_form, $username_cn_form, $password_cn_form);
	 $con = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8;', $username, $password);
	}catch(PDOException $e){
	   print "¡Error!: " . $e->getMessage() . "";
	   die();}

?>