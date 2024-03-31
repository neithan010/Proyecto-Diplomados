<?php
#Este archivo es para procesar una solicitud de otro archivo php 
session_start();

#Si se recibió los datos que se enseñan en la tabla
if(isset($_SESSION['programas_encontrados'])){
    #Capturamos su valor
    #Obtenemos la variable si es que se envia para procesarla
    $programas_encontrados = $_SESSION['programas_encontrados'];
    if(isset($_POST['info'])){
        #Obtenemos el dato y le hacemos un implode y lo devolvemos como una sola cadena de caracteres.
        $array = $programas_encontrados[$_POST['info']]; // Suponiendo que $programas_encontrados es una variable disponible aquí
        $array = implode('|', $array);
        echo $array;
    }
}
?>