<?php

session_start();

include('include/header.php');
?>
<div class="container-fluid">
    <h1 class="mt-4">Programas</h1>
</div>


<div class = "options-create/edit_program">
    <a class="panel_panel-default_panel-icon_panel-secondary" href="create_program.php">
        <div class="panel-body">
            <h3>Crear Programa</h3>
            <p class="text-create-program">Puedes crear un programa desde cero o crearlo en base a uno ya existente</p>
        </div>
    </a>

    <a class="panel_panel-default_panel-icon_panel-secondary" href="edit_program.php" <link>texto-con-fondo</link>>
        <div class="panel-body">
            <h3>Editar Programa</h3>
            <p class="text-edit-program">Puedes editar un Programa ya existente</p>
        </div>
    </a>
</div>

<?php
include_once('include/footer.php');
?>