<?php
$id_form='00';



$structure = '../../../cdg/postulacion/admision/Fichas/'.$id_form;

$path='../../../cdg/postulacion/admision/Fichas/';

$dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos . y .. que tienen todas las carpetas
        if( $elemento != "." && $elemento != ".."){
            // Si es una carpeta
            if( is_dir($path.$elemento) ){
                // Muestro la carpeta
				if($elemento>91000 && substr(sprintf('%o',fileperms($path.$elemento)), -4)<>'0777'){
                	echo "<p><strong>CARPETA: ". $elemento ."</strong> ".substr(sprintf('%o',fileperms($path.$elemento)), -4). "</p>";
				}
            // Si es un fichero
            } else {
                // Muestro el fichero
                echo "<br />". $elemento;
            }
        }
    }

?>