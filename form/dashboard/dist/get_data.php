<?php
    #Los únicos requisitos para procesar los datos son obtener un nombre y codigo de diploma
    if (isset($_POST['nombre_program']) && isset($_POST['cod_diploma'])) {

        #Capturamos el nombre y lo procesamos
        $nombre_program = $_POST['nombre_program'];
        $name_program = htmlspecialchars(addslashes($nombre_program));
    
        #Capturamos el codigo del diploma
        $cod_diploma = $_POST['cod_diploma'];

        //Como los demás campos son opcionales para la busqueda, debemos revisar si es que hay un dato recibido
        //Si se recibio un dato sobre el tipo de programa, entonces lo almacenamos en una variable
        //En caso contrario la variable representa una cadena vacia.
        //Esto se repite con todos los campos del formulario que no sean el nombre o el codigo del diploma
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

        if(isset($_POST['version'])){
            $version = $_POST['version'];
        } else{
            $version = '';
        }

        //Volvemos a revisar si es un curso conducente, de la misma forma que cuando creamos un programa desde 0
        $conducente = false;
        if($tipo_producto == 'Curso'){
            if(isset($_POST['curso_conducente_box'])){
                if($_POST['curso_conducente_box'] == 'Conducente'){
                    $conducente = true;
                }
            }
        }
        
        //Como todos los datos tienen un valor(aunque sea vacio) necesitamos saber cuales son vacios para cuando queramos
        #Construir las condiciones de busqueda de los programas.
        #Creamos una lista donde se tiene el nombre del parametro y su valor.
        $list_campos = [['nombre_program',$name_program],['cod_diploma', $cod_diploma], ['tipo_programa',$tipo_producto], ['area',$area], 
        ['modalidad',$modalidad], ['periodo',$periodo], ['horario',$jornada],
        ['nivel',$nivel], ['realización_en',$realizacion_en], ['fecha_de_inicio',$fecha_de_inicio],
        ['usr_cordinador_ej', $usr_ejecutivo_ventas] /*,['version', $version]*/, ['conducente', $conducente]];

        //Si es que la fecha de inicio es '' la eliminamos de la lista
        if($list_campos[9][1] === ''){
            unset($list_campos[9]);
        } //En caso contrario
        else{
            //Verificamos la fecha, esta función esta en functions_program.php
            if(verify_date($fecha_de_inicio)){
                //si es menor a la fecha actual, cambiamos a la fecha actual el campo respectivo de la lista
                $list_campos[9][1] = get_this_date();
            }
        }

        #Lo generamos como un array de valores y obtenemos el largo de la lista
        $list_campos = array_values($list_campos);
        $L = count($list_campos) - 1;

        //recorremos los datos, si encontramos uno vacio entonces eliminamos el nombre y el valor de dicha variable.
        //aqui se filtran los datos, para solo dejar los entregados por el usuario.
        for ($i = $L; $i >= 0; $i--) {
            //si no es curso conducente lo sacamos de los campos
            if($i == $L){
                if(!$list_campos[$i][1]){
                    unset($list_campos[$i]);
                }
            } else{
                if($list_campos[$i][1] == ''){
                    unset($list_campos[$i]);
                }
            }
        }

        include('functions_program.php');

        #Luego de saber que datos debemos usar para buscar el programa llamamos a la función get_program y
        #sacamos el par(N, array) con el numero de filas en el array encontrado
        $programas_encontrados = get_program($list_campos, $create);
    } else {
        //No recibimos el dato obligatorio: el nombre a buscar.
        echo "Error Inesperado, datos perdidos xd";
    }
?>