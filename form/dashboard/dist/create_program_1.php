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
#Incluimos el formulario y lo modificamos para buscar un programa.
include('formulario_program.php');
?>
<script>
    //Creamos un boton Buscar de tipo submit que nos lleva al archivo search_results_create.php cuando se hace click
    //lo agregamos al div en formulario_program.php llamado submit_form_button
    var button = document.createElement("button");
    button.innerHTML = "Buscar";
    button.setAttribute('type', 'submit');
    button.setAttribute('formaction', 'search_results_create.php');
    document.getElementById("submit_form_button").appendChild(button);
    
    //creamos otro boton para borrar los datos de busqueda, y los agregamos en el div llamado submit_form_button_2
    var button_remover = document.createElement("button");
    button_remover.innerHTML = "Borrar";
    button_remover.setAttribute("type", "reset");
    document.getElementById("submit_form_button_2").appendChild(button_remover);

    //Como estamos buscando un programa, obtenemos las opciones que contemplen 2 años atras
    var j20221 = document.getElementById('2022S1');
    var j20222 = document.getElementById('2022S2');
    var j20231 = document.getElementById('2023S1');
    var j20232 = document.getElementById('2023S2');

    //Hacemos que las opciones de periodos esten disponibles y visibles al ususario.
    j20221.removeAttribute('hidden');
    j20221.removeAttribute('disable');

    j20222.removeAttribute('hidden');
    j20222.removeAttribute('disable');

    j20231.removeAttribute('hidden');
    j20231.removeAttribute('disable');

    j20232.removeAttribute('hidden');
    j20232.removeAttribute('disable');

    //Seleccionamos el 2do semestre 2024 y el año 2025 para en cambio esconder y deshabilitar esas opciones al usuario
    var j20242 = document.getElementById('2024S2');
    var j20251 = document.getElementById('2025S1');
    var j20252 = document.getElementById('2025S2');

    j20242.setAttribute("hidden","true");
    j20242.setAttribute("disable", "disable");

    j20251.setAttribute("hidden","true");
    j20251.setAttribute("disable", "disable");

    j20252.setAttribute("hidden","true");
    j20252.setAttribute("disable", "disable");

    //asignamos la opción buscar_create a la parte del formulario, para cuando se envien los datos saber que estamos buscando.
    var selectedElement = document.getElementById("buscar_create");
    selectedElement = document.setAttribute("selected", "true");
    
</script>   
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>