<?php

$conectores = list("de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para");

function generate_siglas($nombre_programa){
    $siglas = '';
    $nombre_sin_conectores = str_replace($conectores, "", $nombre_programa);

    $max_len = strlen($nombre_sin_conectores);
    for($i = 0; $i < $max_len; $i++){
        #Si primer caracter es una letra
        if([$i] == 0){
            if($nombre_sin_conectores[$i] != ' '){
                $siglas .= strtoupper($nombre_sin_conectores[$i]);
            }
        }
        #Si no estamos en la primera letra
        else{
            #Si caracter anterior es un espacio y caracter actual es una letra, la agregamos a las siglas
            if($nombre_sin_conectores[$i-1] == ' ' && $nombre_sin_conectores[$i] != ' '){
                $siglas .= strtoupper($nombre_sin_conectores[$i]);
            }

            #Si tenemos penultimo caracter como letra y ultimo caracter espacio agregamos el penultimo y terminamos.
            else if($nombre_sin_conectores[$i+1] == ' ' && $nombre_sin_conectores[$i] != ' ' && $i+1 < $max_len){
                $siglas .= strtoupper($nombre_sin_conectores[$i]);
                break;
            }
        }
    }   
    return $siglas;
}

function generate_cod_diploma($siglas, $periodo, $jornada, $version){
    $cod_diploma = '';
    $cod_diploma .= $siglas.substr($periodo, 2, 3).substr($periodo, 5, 5).strtoupper($jornada).preg_replace('/[^0-9]/', '', $version);
    if($version == ''){
        $version = 'V1'
        $cod_diploma .= substr($version, 1, 1);
    }

    $cod_diploma = str_replace(' ', '', $cod_diploma);
    return $cod_diploma; 
}

function generate_cod_interno(){}

function generate_DIPLOMADO(){}

function generate_area($area){}