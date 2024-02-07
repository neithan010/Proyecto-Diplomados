<?php

function generate_siglas($nombre_programa){
    $siglas = '';
    $max_len = strlen($nombre_programa);
    for($i = 0; $i < $max_len; $i++){
        #Si primer caracter es una letra
        if([$i] == 0){
            if($nombre_programa[$i] != ' '){
                $siglas .= strtoupper($nombre_programa[$i]);
            }
        }
        #Si no estamos en la primera letra
        else{
            #Si caracter anterior es un espacio y caracter actual es una letra, la agregamos a las siglas
            if($nombre_programa[$i-1] == ' ' && $nombre_programa[$i] != ' '){
                $siglas .= strtoupper($nombre_programa[$i]);
            }

            #Si tenemos penultimo caracter como letra y ultimo caracter espacio agregamos el penultimo y terminamos.
            else if($nombre_programa[$i+1] == ' ' && $nombre_programa[$i] != ' ' && $i+1 < $max_len){
                $siglas .= strtoupper($nombre_programa[$i]);
                break;
            }
        }
    }   
    return $siglas;
}


function generate_cod_diploma($siglas, $modalidad){
    $cod_diploma = '';
    $cod_diploma .= $siglas.'.'.substr($modalidad, 2, 3).substr($modalidad, 5, 5);
    return $cod_diploma;
}

function generate_cod_interno(){}

function generate_DIPLOMADO(){}

function generate_area($area){}