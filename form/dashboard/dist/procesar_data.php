<?php
$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];
    include('functions_program.php');

    if(isset($_GET['input_value'])){
        $input_value = $_GET['input_value'];
        list($tipo, $name) = explode(",", $input_value);
        
        $data_encargados = get_data_encargados($tipo, $name);

        // Convertir el array a formato JSON
        $json_data_encargados = json_encode($data_encargados);
        echo $json_data_encargados;
    }

    if(isset($_GET["input_cod_diploma"])){
        $input_cod_diploma = $_GET["input_cod_diploma"];
        list($old_nom_diploma,$nombre_program, $periodo, $jornada, $version, $old_siglas, $tipo, $old_tipo) = explode(",", $input_cod_diploma);

        if($old_nom_diploma != $nombre_program){
            $siglas = generate_siglas($nombre_program, $conectores);
        }else{
            $siglas = substr($old_siglas,1,strlen($old_siglas)-1);
        }

        if($old_tipo != $tipo){
            $siglas_tipo = generate_sigla_tipo($tipo);
        } else{
            $siglas_tipo = generate_sigla_tipo($old_tipo);
        }

        echo generate_cod_diploma($siglas, $periodo, $jornada, $version, $siglas_tipo);
    }
?>