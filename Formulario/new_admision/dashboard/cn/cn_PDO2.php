<?php

// BBDD INTRANET

$hostname = '172.16.206.12';
//$hostname = '192.168.5.3';
$database = 'intranet';
$username = 'and32x';
$password = '';
/*
   $hostname = 'localhost';
   $database = 'intranet';
   $username = 'root';
   $password = '';
 */
   //Conexión mediante PDO
   try{
   // $con = new PDO('mysql:host='.$hostname_cn_form.';dbname='.$database_cn_form, $username_cn_form, $password_cn_form);
    $con = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION SQL_BIG_SELECTS=1'));
   }catch(PDOException $e){
      print "¡Error conexion intranet!: " . $e->getMessage() . "";
      die();}
//echo $hostname.'<br>';
?>
