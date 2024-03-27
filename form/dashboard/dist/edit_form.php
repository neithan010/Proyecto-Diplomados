<?php
    include('functions_program.php');
//posible  solucion:
//dejar todo en un documento, generando funcion que al hacer click deje de esconder cierta información
//la idea es que se tenga todo en un mismo archivo.
//el objetivo principal es que pueda obtener los datos del programa a editar(seleccionado).
    //obtenemos los datos antes de cargar cualquier archivo.
    if(isset($_SESSION['can_load'])){
        if(isset($_POST['programaSeleccionado'])){
            $data = $_POST['programaSeleccionado'];
            $data =  explode('|', $data);
        }
    }
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a id ="encargados" href = "#Encargados" onclick = "change_content('encargados_data')" style="text-decoration: none; text-emphasis-position: 5px; padding: 3px;">
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
            <div id = "save_button" style ="margin-left: 20px; margin-bottom: 15px;">
                <button id = "save_button_element" type = "button" formaction="update_data.php" onclick="display_confirmation_window()">
                    Guardar Cambios
                </button>
            </div>
            <input type = 'text' id = 'programa_base' name = 'programa_base' hidden>
            <script>
                var programa_base = '<?php echo implode('|', $data);;?>';
                document.getElementById('programa_base').value = programa_base;

            </script>
            
            <div id = "show_info">
                <div id = "informacion_general">
                    <?php include('edit_informacion_general.php')?>
                </div>
                <div id = "fechas_horarios" hidden>
                    <?php include('edit_fechas_horarios.php')?>
                </div>
                <div id = "encargados_data" hidden>
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
        
        if(section == 'informacion_general'){
            document.getElementById('fechas_horarios').setAttribute('hidden', 'true');
            document.getElementById('encargados_data').setAttribute('hidden', 'true');
            document.getElementById('otros_datos').setAttribute('hidden', 'true');

        } else if(section == 'fechas_horarios'){
            document.getElementById('informacion_general').setAttribute('hidden', 'true');
            document.getElementById('encargados_data').setAttribute('hidden', 'true');
            document.getElementById('otros_datos').setAttribute('hidden', 'true');

        } else if(section == 'otros_datos'){
            document.getElementById('informacion_general').setAttribute('hidden', 'true');
            document.getElementById('encargados_data').setAttribute('hidden', 'true');
            document.getElementById('fechas_horarios').setAttribute('hidden', 'true');

        } else if(section == 'encargados_data'){
            document.getElementById('informacion_general').setAttribute('hidden', 'true');
            document.getElementById('otros_datos').setAttribute('hidden', 'true');
            document.getElementById('fechas_horarios').setAttribute('hidden', 'true');

        }
    }

    function display_confirmation_window(){
        if(window.confirm('Esta seguro que quiere hacer los cambios?')){
            var button = document.getElementById('save_button_element');
            button.setAttribute('type', 'submit');
            button.setAttribute('formaction', 'get_edited_program.php');
        }
    }

    function changeCodDiploma(){
        var input_cod_diploma =document.getElementById('cod_diploma');

        var nombre_program = document.getElementById('nombre_program').value;
        var periodo =document.getElementById('periodo').value;
        var jornada =document.getElementById('horario').value;
        var version = document.getElementById('version').value;
        var tipo =document.getElementById('tipo_producto').value;

        var old_nom_diploma = "";
        var old_siglas = '';

        var can_load = <?php isset($_SESSION['can_load'])?>;
        var programaSeleccionado = <?php isset($_POST['programaSeleccionado'])?>;

        if(can_load && programaSeleccionado){
            var nom_diploma = '<?php echo $data[0];?>';
            old_siglas = '<?php echo $data[10];?>';

            for(var i = 0; i<nom_diploma.length ; i++){
                if(nom_diploma[i] == ' ' && nom_diploma[i+1] == '-'){
                    break;
                } else{
                    old_nom_diploma = old_nom_diploma + nom_diploma[i];
                }
            }
        }

        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', 'procesar_data.php?input_cod_diploma='+ old_nom_diploma+','+nombre_program+','+periodo+','+jornada+','+version+','+old_siglas+','+tipo, true);
        xhttp.send();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Aquí puedes manejar la respuesta del servidor
                var respuesta = this.responseText;
                console.log(respuesta);
                input_cod_diploma.value = respuesta;
            }
        };
    }
</script>