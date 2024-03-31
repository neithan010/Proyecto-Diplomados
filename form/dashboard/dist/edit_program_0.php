<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');

?>
<div class="container-fluid">
    <h1 class="mt-4">Editar Programa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
        <li class="breadcrumb-item"><a href = "edit_program.php">Buscar Programa</a></li>
        <li class="breadcrumb-item"><a href = '#'>Resultados</a></li>
        <li class="breadcrumb-item">Editar Programa</li>
        <li class= "breadcrumb-item" id = "selected_option_edit_program"></li>
    </ol>
</div>
<?php 
    #SE agrega el formulario para editar los datos de un programa Seleccionado
    include('edit_form.php');
    include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>