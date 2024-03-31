<?php
    session_start();
    include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');
    #Si es que recibimos todos los datos para crear un programa desde 0, hacemos una verificación de que los datos fueron recibidos correctamente.
    #Si es que algún campo no fue entregado, no va entrar y no se encargará de cargar el programa en la base de datos.
    if (isset($_POST['nombre_program']) and isset($_POST['tipo'])            and isset($_POST['area'])                  and
        isset($_POST['modalidad'])      and isset($_POST['periodo'])         and isset($_POST['jornada'])               and isset($_POST['nivel'])   and
        isset($_POST['realizacion_en']) and isset($_POST['fecha_de_inicio']) and isset($_POST['ejecutivo_ventas_id'])   and isset($_POST['version'])){
            
        #Si se recibieron todos los datos, los capturamos en variables
        $nombre_programa = $_POST['nombre_program'];

        #Limpiamos el Nombre en caso de tener caracteres especiales entre medio.
        $name_program = htmlspecialchars(addslashes($nombre_programa));
        $tipo_producto = $_POST['tipo'];
        $area = $_POST['area'];
        $modalidad = $_POST['modalidad'];
        $periodo = $_POST['periodo'];
        $jornada = $_POST['jornada'];
        $nivel = $_POST['nivel'];
        $realizacion_en = $_POST['realizacion_en'];
        $fecha_de_inicio = $_POST['fecha_de_inicio'];
        $usr_cordinador_ej = $_POST['ejecutivo_ventas_id'];
        $version = $_POST['version'];

        #Debemos verificar por separado si es que el progrma a crear es un Curso Conducente
        $conducente = false;
        
        #Si el tipo de producto es Curso y el valor de la  checkbox es Conducente, entonces sabremos que es conducente.
        if($tipo_producto == 'Curso'){
            if(isset($_POST['curso_conducente_box'])){
                if($_POST['curso_conducente_box'] == 'Conducente'){
                    $conducente = true;
                }
            }
        }

        //se debe revisar la version
        //si se esta tomando un programa ya existente, se deben comparar los periodos
        //si es el mismo periodo, entonces se mantiene la version escogido
        //si no son del mismo periodo y no hay otro programa con el mismo nombre, entonces queda como version 1.

        //incluimos las funciones que se usan para crear o editar un programa.
        include('functions_program.php');
        
        //Obtenemos por separados a los ejecutivos de venta y rescatamos el Nombre, telefono y mail de envio del
        #ejecutivo de venta
        include('get_ejecutivo_ventas.php');
        $nom_ejecutivo_admision = $arr_ejecutivo[0]['Nombre'];
        $telefono_ejecutivo_admision = str_replace(" ", "",$arr_ejecutivo[0]['Telefono']);
        $mail_envio = $arr_ejecutivo[0]['Email'];
        
        #Generamos la columna DIPLOMADO del programa a Crear.
        $DIPLOMADO = generate_DIPLOMADO($name_program, $tipo_producto);

        #Generamos el tipo del programa, que es diferente al tipo_programa
        #tipo producto == tipo_programa; tipo == tipo_producto - modalidad
        $tipo_programa = generate_tipo_programa($tipo_producto,$modalidad, $conducente);

        #Generamos las siglas del area segun se haya escogido una de las opciones.
        $siglas_area = generate_area($area);

        #Generamos las siglas del nombre del programa
        $siglas = generate_siglas($DIPLOMADO, $conectores);

        #Generamos las siglas del tipo de producto.
        $sigla_tipo = generate_sigla_tipo($tipo_producto);

        #Revisamos que la versión obtenida este correcta
        $version = aprobe_version($version, $periodo, $DIPLOMADO);

        #Generamos el codigo del diploma con los datos generados recientemente
        $new_cod_diploma = generate_cod_diploma($siglas, $periodo, $jornada, $version, $sigla_tipo);

        #Generamos el nombre del diploma.
        $nom_diploma = generate_nom_diploma($name_program, $new_cod_diploma);

        #Incluimos el archivo post_program.php que se encarga de crear el nuevo programa con los datos ya procesados.
        include('post_program.php');
        
    } else {
        //se puede poner algo diferente.
        echo "Error Inesperado, datos perdidos";
    }

?>
<div class="container-fluid">
    <h1 class="mt-4">Crear Programas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Programa Creado</li>
        </ol>
        <div id = "resultado_post_program">
            <h3>
                El programa fue creado e ingresado correctamente
            </h3>
        </div>
        <div id = "volver al menu principal">
            <a href = "diplomados.php">
                Volver al menu Principal
            </a>    
        </div>
</div>
<?php
    #Si no ocurren errores antes de esto, entonces el programa fue cargado en la base de datos de forma exitosa.
    if(true){
        #se cargo correctamente el programa en la base de datos
        ?>
        <script>
            var parrafo = document.createElement("p");
            parrafo.body.appendChild("Programa Cargado correctamente");
            document.getElementById("resultado_post_program").appendChild(parrafo);
        </script>
        <?php
    }
?>
<?php
include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>