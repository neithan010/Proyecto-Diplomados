<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
$create = false;
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
    include('display_program_results.php');
    include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>