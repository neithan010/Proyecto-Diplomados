<?php
//Definimos los conectores como precaución e incluimos las funciones dentro de este archivo.
$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];
    include('functions_program.php');

    //Si es que estamos buscando un encargado, debemos llegar a esta parte del codigo
    if(isset($_GET['input_value'])){
        //Rescatamos en una variable el valor recibido y lo separamos en tipo y nombre
        $input_value = $_GET['input_value'];
        list($tipo, $name) = explode(",", $input_value);
        
        //obtenemos la data de los encargados segun estos parametros, este es un array.
        $data_encargados = get_data_encargados($tipo, $name);

        // Convertir el array a formato JSON y hacemos echo como respuesta al archivo edit_encargados.php
        $json_data_encargados = json_encode($data_encargados);
        echo $json_data_encargados;
    }

    //Si es que obtuvimos un input_cod_diploma, quiere decir que se esta modificando el codigo del programa al momento de estar creando un programa
    //ya sea desde 0 o usando uno ya existente.
    //Tambien si es que al momento de editar se esta cambiando algun parametro que altere el codigo del diploma tambien entra dentro de esta categoria.
    if(isset($_GET["input_cod_diploma"])){
        //obtenemos el string de la forma "old_nom_diploma,nombre_program,..."
        $input_cod_diploma = $_GET["input_cod_diploma"];

        //hacemos un exlpode para separar los datos del progrma
        list($old_nom_diploma,$nombre_program, $periodo, $jornada, $version, $old_siglas, $tipo, $old_tipo) = explode(",", $input_cod_diploma);

        //si es que el nombre antiguo cambio(usuario cambio el nombre en el input)
        if($old_nom_diploma != $nombre_program){
            //las siglas del nombre se van a generar con el nuevo nombre
            $siglas = generate_siglas($nombre_program, $conectores);
        }
        //si no se cambio el nombre
        else{
            //las siglas las obtendremos sacando todo menos la sigla que representa el tipo de producto
            $siglas = substr($old_siglas,1,strlen($old_siglas)-1);
        }

        //si el usurio cambio el tipo de producto 
        if($old_tipo != $tipo){
            //generamos las siglas del tipo de producto con el nuevo tipo
            $siglas_tipo = generate_sigla_tipo($tipo);
        } //si el usuario no cambio el tipo de producto
        else{
            //generamos las siglas del tipo de producto con el tipo antiguo
            $siglas_tipo = generate_sigla_tipo($old_tipo);
        }

        //hacemos echo para dar respuesta al envio de datos que hicimos en formulario_program.php o edit_form.php
        //dando como respuesta generar el codigo del diploma con las siglas, periodo, jornada, version y las siglas del tipo de programa
        echo generate_cod_diploma($siglas, $periodo, $jornada, $version, $siglas_tipo);
    }
?>