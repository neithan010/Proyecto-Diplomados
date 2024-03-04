<?php
    #podria recibir solo un nombre de programa
    if (isset($_POST['nombre_program'])) {

        $nombre_program = $_POST['nombre_program'];
        $name_program = htmlspecialchars(addslashes($nombre_program));

        if(isset($_POST['tipo_producto'])){
            $tipo_producto = $_POST['tipo_producto'];
        } else{$tipo_producto= "";}
            
        if(isset($_POST['area'])){
            $area = $_POST['area'];
        } else{$area ='';}

        if(isset($_POST['tipo_programa'])){
            $tipo_programa = $_POST['tipo_programa'];
        } else{$tipo_programa = '';}

        if(isset($_POST['modalidad'])){
            $modalidad = $_POST['modalidad'];
        } else{$modalidad ='';}

        if(isset($_POST['periodo'])){
            $periodo = $_POST['periodo'];
        } else{$periodo ='';}

        if(isset($_POST['horario'])){
            $jornada = $_POST['horario'];
        } else{$jornada = '';}

        if(isset($_POST['nivel'])){
            $nivel = $_POST['nivel'];
        } else{$nivel ='';}

        if(isset($_POST['realización_en'])){
            $realizacion_en = $_POST['realización_en'];
        } else{$realizacion_en ='';}

        if(isset($_POST['fecha_de_inicio'])){
            $fecha_de_inicio = $_POST['fecha_de_inicio'];
        } else{$fecha_de_inicio = '';}

        if(isset($_POST['buscar_edit/create_program'])){
            $edit_create = $_POST['buscar_edit/create_program'];
        } else{$edit_create = '';}
            
        if(isset($_POST['version'])){
            $version = isset($_POST['version']);
        } else{$version = '';}

        $list_campos = [['nombre_program',$name_program], ['tipo_producto',$tipo_producto], ['area',$area], 
        ['tipo_programa',$tipo_programa], ['modalidad',$modalidad], ['periodo',$periodo], ['horario',$jornada],
        ['nivel',$nivel], ['realización_en',$realizacion_en], ['fecha_de_inicio',$fecha_de_inicio], 
        ['version', $version]];
        $list_nombres_r = ['nombre_program','tipo_producto','area','tipo_programa','modalidad','periodo','horario','nivel','realización_en','fecha_de_inicio','version'];
        $L = count($list_campos) - 1;
        $list_nombres = [];

        //recorremos los datos, si encontramos uno vacio entonces eliminamos el nombre y el valor de dicha variable.
        //aqui se filtran los datos, para solo dejar los entregados por el usuario.
        for ($i = $L; $i >= 0; $i--) {
            if ($list_campos[$i][1] === '') {
                unset($list_campos[$i]);
            }
        }
    } else {
        //No recibimos el dato obligatorio: el nombre a buscar.
        echo "Error Inesperado, datos perdidos";
    }
    include('functions_program.php');
    #sacamos el par(N, array) con el numero de filas en el array encontrado
    $programas_encontrados = get_program($list_campos, $edit_create);
?>