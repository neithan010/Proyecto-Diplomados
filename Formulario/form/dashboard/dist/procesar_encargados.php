<?php
    include('functions_program.php');

    if(isset($_GET['input_value'])){
        $input_value = $_GET['input_value'];
        list($tipo, $name) = explode(",", $input_value);
        $data_encargados = get_data_encargados($tipo, $name);

        // Convertir el array a formato JSON
        $json_data_encargados = json_encode($data_encargados);
        echo $json_data_encargados;
    }
?>