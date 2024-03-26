<?php
session_start();
if(isset($_SESSION['programas_encontrados'])){
    $programas_encontrados = $_SESSION['programas_encontrados'];
    if(isset($_POST['info'])){
        $array = $programas_encontrados[$_POST['info']]; // Suponiendo que $programas_encontrados es una variable disponible aquí
        $array = implode('|', $array);
        echo $array;
    }
}
?>