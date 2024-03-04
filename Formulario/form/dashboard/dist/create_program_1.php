<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
?>
<div class="container-fluid">
    <h1 class="mt-4">Crear Programa</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="diplomados.php">Formulario Diplomados</a></li>
            <li class="breadcrumb-item"><a href = "create_program.php">Crear Programa</a></li>
            <li class="breadcrumb-item"><a href = "create_program_1.php">Buscar Programa</a></li>    
    </ol>
</div>

<?php
include('formulario_program.php');
?>
<script>
    var selectElement = document.getElementById("buscar_edit/create_program");
    selectElement.value = "buscar_create";

    var button = document.createElement("button");
    button.innerHTML = "Buscar";
    button.setAttribute('type', 'submit');
    button.setAttribute('formaction', 'search_results_create.php');
    document.getElementById("submit_form_button").appendChild(button);
</script>   
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>