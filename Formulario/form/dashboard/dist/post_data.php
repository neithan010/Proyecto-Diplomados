<?php
    session_start();
    include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');
    #podria recibir solo un nombre de programa
    if (isset($_POST['nombre_program']) and isset($_POST['tipo_producto'])  and isset($_POST['area'])      and isset($_POST['tipo_programa']) and
        isset($_POST['modalidad'])      and isset($_POST['periodo'])        and isset($_POST['horario'])   and isset($_POST['nivel'])   and
        isset($_POST['realización_en']) and isset($_POST['fecha_de_inicio'])) {

        $nombre_programa = $_POST['nombre_program'];
        $name_program = htmlspecialchars(addslashes($nombre_programa));
        $tipo_producto = $_POST['tipo_producto'];
        $area = $_POST['area'];
        $tipo_programa = $_POST['tipo_programa'];
        $modalidad = $_POST['modalidad'];
        $periodo = $_POST['periodo'];
        $jornada = $_POST['horario'];
        $nivel = $_POST['nivel'];
        $realizacion_en = $_POST['realización_en'];
        $fecha_de_inicio = $_POST['fecha_de_inicio'];
        $version = '';

        include('functions_program.php');
        $siglas = generate_siglas($name_program, $conectores);
        $cod_diploma = generate_cod_diploma($siglas, $periodo, $jornada, $version);
        $DIPLOMADO = generate_DIPLOMADO($nombre_programa, $tipo_programa);
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
    if($stmt_insert_program->execute()){
        #se cargo correctamente el programa en la base de datos
        ?>
        <script>
            var parrafo = document.createElement("p");
            parrafo.body.appendChild("Programa Cargado correctamente");
            document.getElementById("resultado_post_program").appendChild(parrafo);
        </script>
        <?php
    }

    else{
        #no se cargo correctamente el programa en la base de datos
        ?>
        <script>
            var parrafo = document.createElement("p");
            parrafo.body.appendChild("El programa no se ha cargado correctamente, intente de nuevo.");
            document.getElementById("resultado_post_program").appendChild(parrafo);
        </script>
        <?php
    }
?>
<?php
include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>