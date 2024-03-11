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
                    <a id ="info_gral" href = "#Información General" onclick = "change_content('Información General','edit_informacion_general.php')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Información General
                        </strong>
                    </a>
                </div>
                <div class="col">
                    <a id = "info_fechas" href = "#Fechas y Horarios" onclick = "change_content('Fechas y Horarios','edit_fechas_horarios.php')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Fechas y Horarios
                        </strong>
                    </a>
                </div>
                <div class="col">
                    <a id ="encargados" href = "#Encargados" onclick = "change_content('Encargados','edit_encargados.php')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
                        <strong>
                            Encargados
                        </strong>
                    </a>
                </div>
                <div class = "col">
                    <a id = "otros" href = "#Otros Datos" onclick = "change_content('Otros','edit_otros_datos.php')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
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
            <iframe id = "contenido_body" src = "edit_informacion_general.php" style="width: 100%; height: 700px;">
            </iframe>
        </div>

        <div id = "save_button">
            <button id = "save_button_element" type = "button" formaction="update_data.php" onclick="display_confirmation_window()">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
<script>
    document.getElementById('selected_option_edit_program').textContent = "Información General";
    function change_content(section, content){
        document.getElementById('contenido_body').src = content;
        document.getElementById('selected_option_edit_program').textContent = section;
    }

    function display_confirmation_window(){
        if(window.confirm('Esta seguro que quiere hacer los cambios?')){
            var button = document.getElementById('save_button_element');
            button.setAttribute('type', 'submit');
        }
    }
</script>