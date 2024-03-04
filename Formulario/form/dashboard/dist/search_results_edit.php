<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
include('get_data.php');
?>
<div class="container-fluid">
    <h1 class="mt-4">Editar Programa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
        <li class="breadcrumb-item"><a href = "edit_program.php">Buscar Programa</a></li>
        <li class="breadcrumb-item">Resultados</li>
    </ol>
</div>
<?php
    $getted_program = true;
    //deberia enseñar la tabla con los datos obtenidos segun la query
    include('display_program_results.php');
    ?>
    <script>
        //ignorar
        var edit_create = <?php echo $edit_create;?>;
        //Aqui nos aseguramos de poner la opcion correcta en la barra superior
        //Para eso, desde editar o crear enviamos un valor booleano que representa si es uno o el oto
        if(edit_create == 'buscar_edit'){
            edit_or_create_section.setAttribute("href","edit_program.php");
        } elseif(edit_create == 'buscar_create'){
            edit_or_create_section.setAttribute("href","create_program.php");
        }
        edit_or_create_section.appendChild("Buscar Programa");
    </script>
    <?
    include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>