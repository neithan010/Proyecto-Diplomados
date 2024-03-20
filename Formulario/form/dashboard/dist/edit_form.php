<?php
//posible  solucion:
//dejar todo en un documento, generando funcion que al hacer click deje de esconder cierta información
//la idea es que se tenga todo en un mismo archivo.
//el objetivo principal es que pueda obtener los datos del programa a editar(seleccionado).
    //obtenemos los datos antes de cargar cualquier archivo.
    if(isset($_SESSION['can_load'])){
        if(isset($_POST['programaSeleccionado'])){
            $data = $_POST['programaSeleccionado'];
            echo $data;
            $data =  explode('|', $data);
            echo $data[42];
        }
    }
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="C:\laragon\www\form\css\estilo_create_program.css">
<div name = "formulario_edit_program" id = "formulario_edit_program" class = "">
    <div id = "barra_superior" name = "barra_superior">
        <hr>
        <div class="text-center">
            <div class="row" style="margin: -10px; margin-right: 100px">
                <div class="col" >
                    <a id ="info_gral" href = "#Información General" onclick = "change_content('informacion_general')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Información General
                        </strong>
                    </a>
                </div>
                <div class="col">
                    <a id = "info_fechas" href = "#Fechas y Horarios" onclick = "change_content('fechas_horarios')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Fechas y Horarios
                        </strong>
                    </a>
                </div>
                <div class="col">
                    <a id ="encargados" href = "#Encargados" onclick = "change_content('encargados')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Encargados
                        </strong>
                    </a>
                </div>
                <div class = "col">
                    <a id = "otros" href = "#Otros Datos" onclick = "change_content('otros_datos')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Otros
                        </strong>
                    </a>
                </div>
            </div>
        </div>
        <hr>
    </div>  
    <form id = "form_edit_program" name = "form_edit_program" method = "post">
        <div id = "contenido" name = "contenido">
            <div id = "save_button" style ="margin-left: 900px; margin-bottom: 15px;">
                <button id = "save_button_element" type = "button" formaction="update_data.php" onclick="display_confirmation_window()">
                    Guardar Cambios
                </button>
            </div>

            <div id = "include">
                <div id = "informacion_general">
                    <?php include('edit_informacion_general.php')?>
                </div>
                <div id = "fechas_horarios" hidden>
                    <?php include('edit_fechas_horarios.php')?>
                </div>
                <div id = "encargados" hidden>
                    <?php include('edit_encargados.php')?>
                </div>
                <div id = "otros_datos" hidden>
                    <?php include('edit_otros_datos.php')?>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    
    function change_content(section){
        document.getElementById(section).removeAttribute('hidden');
        var include = document.getElementById('include');
        while(include.firstChild){
            include.removeChild(include.firstChild);
        }
    }
    function display_confirmation_window(){
        if(window.confirm('Esta seguro que quiere hacer los cambios?')){
            var button = document.getElementById('save_button_element');
            button.setAttribute('type', 'submit');
        }
    }
</script>