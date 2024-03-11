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
    </ol>
</div>

<?php
include('formulario_program.php');
?>
<script>
    var button = document.createElement("button");
    button.innerHTML = "Buscar";
    button.setAttribute('type', 'submit');
    button.setAttribute('formaction', 'search_results_edit.php');
    document.getElementById("submit_form_button").appendChild(button);

    var button_remover = document.createElement("button");
    button_remover.innerHTML = "Borrar";
    button_remover.setAttribute("type", "reset");
    document.getElementById("submit_form_button_2").appendChild(button_remover);
    
        //enseñamos los 2 ultimos años
    var j20221 = document.getElementById('2022S1');
    var j20222 = document.getElementById('2022S2');
    var j20231 = document.getElementById('2023S1');
    var j20232 = document.getElementById('2023S2');

    j20221.removeAttribute('hidden');
    j20221.removeAttribute('disable');

    j20222.removeAttribute('hidden');
    j20222.removeAttribute('disable');

    j20231.removeAttribute('hidden');
    j20231.removeAttribute('disable');

    j20232.removeAttribute('hidden');
    j20232.removeAttribute('disable');

    //escondemos los 2 años siguientes, manteniendo el semestre actual como opcion de busqueda
    var j20242 = document.getElementById('2024S2');
    var j20251 = document.getElementById('2025S1');
    var j20252 = document.getElementById('2025S2');

    j20242.setAttribute("hidden","true");
    j20242.setAttribute("disable", "disable");

    j20251.setAttribute("hidden","true");
    j20251.setAttribute("disable", "disable");

    j20252.setAttribute("hidden","true");
    j20252.setAttribute("disable", "disable");

    var selectedElement = document.getElementById("buscar_edit");
    selectedElement = document.setAttribute("selected", "true");
</script>
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>