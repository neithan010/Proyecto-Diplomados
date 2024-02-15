<?php
include('../header.php');
?>
<div class="container-fluid">
    <h1 class="mt-4">Programas</h1>
</div>

<div class = "options-create/edit_program">
        <div class="panel-body">
            <h3>
                <a class="panel_panel-default_panel-icon_panel-secondary" href="create_program.php">
                Crear Programa
                </a>
            </h3>
            <p class="text-create-program">Puedes crear un programa desde cero o crearlo en base a uno ya existente</p>
        </div>

    <a class="panel_panel-default_panel-icon_panel-secondary" href="edit_program.php">
        <div class="panel-body">
            <h3>Editar Programa</h3>
            <p class="text-edit-program">Puedes editar un Programa ya existente</p>
        </div>
    </a>
</div>

<?php
include_once('../footer.php');
?>