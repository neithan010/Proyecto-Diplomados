<?php
session_start();

echo 'Hola';
if($_SESSION["usuario"] === null){
    header("Location: ".$url_."../login.html");
}else{
    header("Location: ".$url_."index.php");
}

?>