<?php
session_start();
include('C:/laragon/www/form/dashboard/dist/include/header.php');

#Aqui solo se escribe el menú con sus respectivos nombres
#Se enseñan las opciones de crear un programa desde 0 o crear uno usando uno existente
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="container-fluid">
        <h1 class="mt-4">Crear Programa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
            <li class="breadcrumb-item"><a href = "create_program.php">Crear Programa</a></li>
        </ol>
        <div name = 'crear_programa_0_1' id = 'crear_programa'>
            <div class="panel-body">
                <div>
                    <a id="crear_program_0_si" class="panel_panel-default_panel-icon_panel-secondary" href="create_program_0.php" >
                        <div class="panel-body">
                            <h3>Crear Programa desde 0</h3>
                            <p class="text-edit-program">Se crea programa sin datos pre definidos</p>
                        </div>
                    </a>
                </div>
                <div>
                    <a id="crear_programa_0_no" class="panel_panel-default_panel-icon_panel-secondary" href="create_program_1.php">
                        <div class="panel-body">
                            <h3>Buscar Programa</h3>
                            <p class="text-edit-program">Se crea programa usando uno ya existente</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>