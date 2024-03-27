<?php
    session_start();
    include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');
    #crear programa nuevo, uno no existente
    if (isset($_POST['nombre_program']) and isset($_POST['tipo'])            and isset($_POST['area'])                  and
        isset($_POST['modalidad'])      and isset($_POST['periodo'])         and isset($_POST['jornada'])               and isset($_POST['nivel'])   and
        isset($_POST['realizacion_en']) and isset($_POST['fecha_de_inicio']) and isset($_POST['ejecutivo_ventas_id'])   and isset($_POST['version'])){
            
        $nombre_programa = $_POST['nombre_program'];
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
        $conducente = false;

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
        include('functions_program.php');
        
        include('get_ejecutivo_ventas.php');
        $nom_ejecutivo_admision = $arr_ejecutivo[0]['Nombre'];
        $telefono_ejecutivo_admision = str_replace(" ", "",$arr_ejecutivo[0]['Telefono']);
        $mail_envio = $arr_ejecutivo[0]['Email'];
        
        $DIPLOMADO = generate_DIPLOMADO($name_program, $tipo_producto);
        $tipo_programa = generate_tipo_programa($tipo_producto,$modalidad, $conducente);
        $siglas_area = generate_area($area);
        $siglas = generate_siglas($DIPLOMADO, $conectores);
        $sigla_tipo = generate_sigla_tipo($tipo_producto);
        
        $cod_diploma_first = generate_cod_diploma($siglas, $periodo, $jornada, $version, $sigla_tipo);
        $version = aprobe_version($version, $periodo, $DIPLOMADO);

        $new_cod_diploma = generate_cod_diploma($siglas, $periodo, $jornada, $version, $sigla_tipo);
        $nom_diploma = generate_nom_diploma($name_program, $new_cod_diploma);
        include('post_program.php');
        
    } else {
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