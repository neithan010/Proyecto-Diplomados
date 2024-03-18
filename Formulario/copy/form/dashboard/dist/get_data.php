<?php
    #podria recibir solo un nombre de programa
    if (isset($_POST['nombre_program'])) {

        $nombre_program = $_POST['nombre_program'];
        $name_program = htmlspecialchars(addslashes($nombre_program));
    
        if(isset($_POST['tipo'])){
            $tipo_producto = $_POST['tipo'];
        } else{$tipo_producto= "";}

        if(isset($_POST['area'])){
            $area = $_POST['area'];
        } else{$area ='';}

        if(isset($_POST['modalidad'])){
            $modalidad = $_POST['modalidad'];
        } else{$modalidad ='';}

        if(isset($_POST['periodo'])){
            $periodo = $_POST['periodo'];
        } else{$periodo ='';}

        if(isset($_POST['jornada'])){
            $jornada = $_POST['jornada'];
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
            
        if(isset($_POST['ejecutivo_ventas_id'])){
            $usr_ejecutivo_ventas = $_POST['ejecutivo_ventas_id'];
        } else{
            $usr_ejecutivo_ventas = '';
        }

        /*
        if(isset($_POST['version'])){
            $version = $_POST['version'];
        } else{
            $version = '';
        }
        */

        $conducente = false;
        if($tipo_producto == 'Curso'){
            if(isset($_POST['curso_conducente_box'])){
                if($_POST['curso_conducente_box'] == 'Conducente'){
                    $conducente = true;
                }
            }
        }
        $list_campos = [['nombre_program',$name_program], ['tipo_programa',$tipo_producto], ['area',$area], 
        ['modalidad',$modalidad], ['periodo',$periodo], ['horario',$jornada],
        ['nivel',$nivel], ['realización_en',$realizacion_en], ['fecha_de_inicio',$fecha_de_inicio],
         ['usr_cordinador_ej', $usr_ejecutivo_ventas] /*,['version', $version]*/, ['conducente', $conducente]];

        $list_nombres_r = ['nombre_program','tipo_programa  ','area','modalidad','periodo','horario','nivel','realización_en','fecha_de_inicio',
                           'usr_cordinador_ej' /*,'version'*/, 'conducente'];

        $L = count($list_campos) - 1;
        $list_nombres = [];

        //recorremos los datos, si encontramos uno vacio entonces eliminamos el nombre y el valor de dicha variable.
        //aqui se filtran los datos, para solo dejar los entregados por el usuario.
        for ($i = $L; $i >= 0; $i--) {
            //si no es curso conducente lo sacamos de los campos
            if($i == $L){
                if(!$list_campos[$i][1]){
                    unset($list_campos[$i]);
                }
            } else{
                if($list_campos[$i][1] === ''){
                    unset($list_campos[$i]);
                }
            }
        }

        include('functions_program.php');
        #sacamos el par(N, array) con el numero de filas en el array encontrado
        $programas_encontrados = get_program($list_campos, $create);
    } else {
        //No recibimos el dato obligatorio: el nombre a buscar.
        echo "Error Inesperado, datos perdidos xd";
    }
?>