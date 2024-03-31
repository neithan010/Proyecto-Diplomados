<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');

//Lo que viene es la barra superior de opciones, la cual enseña que es loq ue estamos haciendo y en que etapa estamos
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

//Incluyo todas las funciones que se necesitan para crear un programa desde 0.
include('formulario_program.php');
?>
<script>
    //Estas instrucciones son las que ocurren cuando queremos crear un boton desde 0
    //Lo primero que hacemos es crear un boton de tipo submit que se llama Guardar, el cual al hacer click en él nos llevará al archivo
    //post_data.php, dicho boton se agrega al div mencionado que se llama "submit_form_button"
    var button_guardar = document.createElement("button");
    button_guardar.innerHTML = "Guardar";
    button_guardar.setAttribute("type", "submit");
    button_guardar.setAttribute("formaction","post_data.php");
    document.getElementById("submit_form_button").appendChild(button_guardar);

    //Creamos otro boton de tipo reset que se llama Borrar, el cual se encarga de limpiar los campos del formulario, este boton se agrega
    //al div mencionado anteriormente que se llama "submit_form_button_2.
    var button_remover = document.createElement("button");
    button_remover.innerHTML = "Borrar";
    button_remover.setAttribute("type", "reset");
    document.getElementById("submit_form_button_2").appendChild(button_remover);

    //Como estamos creando un programa desde 0, el formulario creado contiene todos los requisitos(mínimos) para poder crear un programa, por lo
    //cual, se necesita que sean un requisito antes de hacer click en Guardar.
    //Obtenemos todos los elementos del formulario.
    var nombre_programa = document.getElementById('nombre_program');
    var cod_diploma = document.getElementById('cod_diploma');
    var tipo_producto = document.getElementById("tipo_producto");
    var area = document.getElementById("area");
    var modalidad = document.getElementById("modalidad");
    var periodo = document.getElementById("periodo");
    var horario = document.getElementById("horario");
    var nivel = document.getElementById("nivel");
    var realización_en = document.getElementById("realizacion_en");
    var fecha_de_inicio = document.getElementById("fecha_de_inicio");
    var ejecutivo_venta = document.getElementById("ejecutivo_ventas_id");
    var version = document.getElementById('version');

    //les fijamos el atributo required a los campos del formulario, para que si el usuario desea crear un programa y hay
    //algún campo vacío este no pueda crearse y le avise que tiene campos vacios.
    nombre_programa.setAttribute('required', 'true');
    cod_diploma.setAttribute('required','true');
    tipo_producto.setAttribute('required', "true");
    area.setAttribute('required', "true");
    modalidad.setAttribute('required', "true");
    periodo.setAttribute('required', "true");
    horario.setAttribute('required', "true");
    nivel.setAttribute('required', "true");
    realización_en.setAttribute('required', "true");
    fecha_de_inicio.setAttribute('required', "true");
    ejecutivo_venta.setAttribute('required', 'true');
    version.setAttribute('required','true');
</script>
<?php
include('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>