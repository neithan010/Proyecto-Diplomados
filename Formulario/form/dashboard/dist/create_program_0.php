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
    </ol>
</div>
<?php

include('formulario_program.php');
?>
<script>
    var tipo_producto = document.getElementById("tipo_producto");
    var area = document.getElementById("area");
    var modalidad = document.getElementById("modalidad");
    var periodo = document.getElementById("periodo");
    var horario = document.getElementById("horario");
    var nivel = document.getElementById("nivel");
    var realización_en = document.getElementById("realizacion_en");
    var fecha_de_inicio = d = document.getElementById("fecha_de_inicio");

    tipo_producto.setAttribute('required', "true");
    area.setAttribute('required', "true");
    modalidad.setAttribute('required', "true");
    periodo.setAttribute('required', "true");
    horario.setAttribute('required', "true");
    nivel.setAttribute('required', "true");
    realización_en.setAttribute('required', "true");
    fecha_de_inicio.setAttribute('required', "true");

    var button_guardar = document.createElement("button");
    button_guardar.innerHTML = "Guardar";
    button_guardar.setAttribute("type", "submit");
    button_guardar.setAttribute("formaction","post_data.php");
    document.getElementById("submit_form_button").appendChild(button_guardar);

    var button_remover = document.createElement("button");
    button_remover.innerHTML = "Borrar";
    button_remover.setAttribute("type", "reset");
    document.getElementById("submit_form_button_2").appendChild(button_remover);
</script>
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>