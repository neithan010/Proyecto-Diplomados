<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');

#Esta es la pagina principal donde se plantean las opciones de crear un programa o de editar un programa
?>
    <div class="container-fluid">
        <h1 class="mt-4">Crear Programas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
        </ol>
        <div class = "options-create/edit_program">
            <div class="panel-body">
                <div class="crear-program-body">
                    <a class="panel_panel-default_panel-icon_panel-secondary" href="create_program.php">
                        <div class="panel-body">
                            <h3>Crear Programa</h3>
                            <p class="text-edit-program">Puedes crear un programa desde cero o crearlo en base a uno ya existente</p>
                        </div>
                    </a>
                </div>
                <div class="edit-program-body">
                    <a class="panel_panel-default_panel-icon_panel-secondary" href="edit_program.php">
                        <div class="panel-body">
                            <h3>Editar Programa</h3>
                            <p class="text-edit-program">Puedes editar un Programa ya existente</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
     
<?php
include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>

