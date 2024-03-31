<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
$create = true;

#Agregamos el archivo get_data.php
include('get_data.php');

#Lo de más adelante es el menú de Crear Programa.
?>
<div class="container-fluid">
    <h1 class="mt-4">Crear Programa</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
            <li class="breadcrumb-item"><a href = "create_program.php">Crear Programa</a></li>
            <li class="breadcrumb-item"><a href = "create_program_1.php">Buscar Programa</a></li> 
            <li class="breadcrumb-item">Resultados</li>   
    </ol>
</div>
<?php
    #Incluimos el archivo que enseñará los resultados.
    include('display_program_results.php');
    
    include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>