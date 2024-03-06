<?php
$_SESSION['can_load'] = false;
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="C:\laragon\www\form\css\estilo_create_program.css">
<div class = "formulario-create-main">
    <legend id = "legend"></legend>
    <form id = "formulario-create-main-body" method = 'post'> 
        <div class="container text-center">
            <div class="row row-cols-3 row-cols-lg-4 g-lg-3">
                <div class="col">
                    <div class="p-2">
                        <label>
                            Nombre Programa:
                            <input name = "nombre_program" id = "nombre_program" type = "text" maxlength = "100" required/>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            Tipo Producto:
                            <select name = "tipo" id ="tipo_producto">
                                <option value = "" selected = "true"  id= 'none' name = 'none' disable = "disable" hidden></option>
                                <option value= "Diploma" id="Diploma">
                                    DIPLOMA
                                </option>
                                <option value= "Diploma Postitulo" id="Diploma Postitulo">
                                    DIPLOMA POSTITULO
                                </option>
                                <option value= "Curso" id = "Curso" name = 'Curso'>
                                    CURSO
                                </option>
                                <option value = 'otro' id = 'otro' disable = "disable" hidden>
                                    _   
                                </option>
                            </select> 
                        </label>
                        <label hidden disable="disable" id = "Curso Conducente" name = "Curso Conducente">
                            <input type="checkbox" id="cbox1" value="first_checkbox">
                            ¿Es un Curso Conducente?
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            Area
                            <select name = "area" id = "area">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value= "Innovación y Emprendimiento" id = "Innovación y Emprendimiento">
                                    Innovación y Emprendimiento
                                </option>
                                <option value= "Finanzas e Inversiones" id ="Finanzas e Inversiones">
                                    Finanzas e Inversiones
                                </option>
                                <option value= "Marketing y Ventas" id="Marketing y Ventas">
                                    Marketing y Ventas
                                </option>
                                <option value = "Estrategia y Gestión" id ="Estrategia y Gestión">
                                    Estrategia y Gestión
                                </option>
                                <option value = "Personas y Equipos" id= "Personas y Equipos">
                                    Personas y Equipos
                                </option>
                                <option value = "Operaciones y Logística" id= "Operaciones y Logística">
                                    Operaciones y Logística
                                </option>
                                <option value = "Dirección de Instituciones de Salud" id="Dirección de Instituciones de Salud">
                                    Dirección de Instituciones de Salud
                                </option>   
                                <option name = 'otro' id = 'otro' disable = "disable" hidden>
                                    
                                </option>
                            </select> 
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-4">
                        <label>
                            Modalidad
                            <select name = "modalidad" id = "modalidad">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "Presencial" id = "Presencial">
                                    Presencial
                                </option>
                                <option value = "B-Learning" id="B-Learning">
                                    B-Learning
                                </option>
                                <option value = "E-Learning" id="E-Learning">
                                    E-Learning
                                </option>
                                <option value = "Virtual" id="Virtual">
                                    Virtual
                                </option>
                                <option value = "Mixto" id="Mixto">
                                    Mixto
                                </option>
                                <option value = "Híbrido" id="Híbrido">
                                    Híbrido
                                </option>
                                <option name = 'otro' id = 'otro' disable = "disable" hidden>
                                    
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-1">
                        <label>
                            Periodo
                            <select name = "periodo" id = "periodo">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value= "2022S1" id = "2022S1" disable = "disable" hidden>
                                    Primer Semestre 2022
                                </option>
                                <option value= "2022S2" id= "2022S2" disable = "disable" hidden>
                                    Segundo Semestre 2022
                                </option>
                                <option value= "2023S1" id="2023S1" disable = "disable" hidden>
                                    Primer Semestre 2023
                                </option>
                                <option value= "2023S2" id="2023S2" disable = "disable" hidden>
                                    Segundo Semestre 2023
                                </option>
                                <option value= "2024S1" id="2024S1">
                                    Primer Semestre 2024
                                </option>
                                <option value= "2024S2" id="2024S2">
                                    Segundo Semestre 2024
                                </option>
                                <option value= "2025S1" id="2025S1">
                                    Primer Semestre 2025
                                </option>
                                <option value= "2025S2" id ="2025S2">
                                    Segundo Semestre 2025
                                </option>
                            </select> 
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-1">
                        <label>
                            Horario
                            <br>
                            <select name = "jornada" id = "horario">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "AM" id ="AM">
                                    AM
                                </option>
                                <option value = "PM" id ="PM">
                                    PM
                                </option>
                                <option value = "WK" id ="WK">
                                    WK
                                </option>
                                <option value = "TD" id="TD">
                                    TD
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-1">
                        <label>
                            Nivel
                            <br>
                            <select name = "nivel" id = "nivel">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "Inicial" id= "Inicial">
                                    Inicial
                                </option>
                                <option value = "Intermedio" id="Intermedio">
                                    Intermedio
                                </option>
                                <option value = "Avanzado" id= "Avanzado">
                                    Avanzado
                                </option>
                                <option value = "Experto" id="Experto">
                                    Experto
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            ¿Donde se realizará?
                            <select name = "realizacion_en" id = "realizacion_en">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "FEN" id="FEN">
                                    FEN
                                </option>
                                <option value = "FUERA" id ="FUERA">
                                    FUERA
                                </option>
                                <option value = "Oriente" id ="Oriente">
                                    Oriente
                                </option>
                                <option value = "OrienteFen" id="OrienteFen">
                                    Oriente FEN
                                </option>
                                <option value = "INTERNACIONAL" id ="INTERNACIONAL">
                                    INTERNACIONAL 
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            Ejecutivo de Ventas
                            <select name = "ejecutivo_ventas_id" id = "ejecutivo_ventas_id">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "covando" id = "covando">
                                    Carolina Ovando
                                </option>   
                                <option value ="cgalan" id = "cgalan">
                                    Consuelo Galán
                                </option>
                                <option value ="fgonzalez" id = "fgonzalez">
                                    Fallon Gonzalez
                                </option>
                                <option value = "mcastro" id = "mcastro">
                                    Marisol Castro
                                </option>
                                <option value = "nhormazabal" id = "nhormazabal">
                                    Nataly Hormazabal
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            Fecha de Inicio
                            <input name = "fecha_de_inicio" type = "date" id = "fecha_de_inicio">
                        </label>
                    </div>
                </div>
                <div class="col" id = "hide-version">
                    <div class="p-2">
                        <label >
                            Version
                            <select id = "version" name = "version">
                            <option value = "V1" name = "V1" id = "V1" selected = "true" disable = "disable" hidden>V1</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-4">
                        <div id = "submit_form_button">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="p-4">
                        <div id = "submit_form_button_2">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="p-4">
                        <select name = "buscar_edit/create_program" id = "buscar_edit/create_program" autocomplete = 'off' hidden>
                                <option value = "buscar_edit" disable = "disable" hidden></option>
                                <option value = "buscar_create" disable = "disable" hidden></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var version = document.getElementById('hide-version')
    version.setAttribute("hidden","true");
    version.setAttribute("disable", "disable");

    var curso = document.getElementById('Curso');
    if(curso.getAttribute('selected')){
        var curso_conducente = document.getElementById('Curso Conducente');
        curso_conducente.removeAttribute('hidden');
        curso_conducente.removeAttribute('disable');
    }
</script>
<?php

//Nos aseguramos de que la variable global este definida
if(isset($_SESSION['can_load'])){
    $getted_program = $_SESSION['can_load'];
    //nos aseguramos de que se haya seleccionado un programa y que se haya enviado.
    if(isset($_POST['programaSeleccionado'])){
        $getted_program = true;
        if($getted_program){
            //obtenemos la data de un programa ya existente
            $data = $_POST['programaSeleccionado'];
            $array_data = explode(", ", $data);
            echo '<pre>'.print_r($array_data, true).'</pre>';
            ?>
            <script>
                //obtendremos los datos que necesitamos
                var nom_diploma = '<?php echo $array_data[0];?>';
                var tipo_programa = '<?php echo $array_data[1];?>';
                var area_conocimiento = '<?php echo $array_data[2];?>';
                var modalidad_programa = '<?php echo $array_data[3];?>';
                var periodo = '<?php echo $array_data[4];?>';
                var horario = '<?php echo $array_data[5];?>';
                var nivel = '<?php echo $array_data[6];?>';
                var realizacion_en = '<?php echo $array_data[7];?>';
                var fecha_de_inicio = '<?php echo $array_data[8];?>';
                var version = '<?php echo $array_data[9];?>';
                var siglas = '<?php echo $array_data[10];?>';
                var cod_diploma = '<?php echo $array_data[11];?>';
                var area_negocios = '<?php echo $array_data[12];?>';
                
                var DIPLOMADO = '<?php echo $array_data[13];?>';
                var mail_envio = '<?php echo $array_data[14];?>';
                var habilitad = '<?php echo $array_data[15];?>';
                var web_habilitado = '<?php echo $array_data[16];?>';
                var marca = '<?php echo $array_data[17];?>';
                var horario_web = '<?php echo $array_data[18];?>';
                var area = '<?php echo $array_data[19];?>';
                var vacantes = '<?php echo $array_data[20];?>';
                var usr_ejecutivo_ventas = '<?php echo $array_data[21];?>';


                //display nombre programa encontrado
                var new_nom_diploma = "";
                for(var i = 0; i<nom_diploma.length ; i++){
                    if(nom_diploma[i] == ' ' && nom_diploma[i+1] == '-'){
                        break;
                    } else{
                        new_nom_diploma = new_nom_diploma + nom_diploma[i];
                    }
                }
                //pondremos los valores en los campos
                var nombre_program = document.getElementById('nombre_program');
                nombre_program.value = new_nom_diploma;

                //display tipo programa si es que coincide
                if(tipo_programa == "Diploma" || tipo_programa == "Diploma Postitulo" || tipo_programa == "Curso"){
                        var tipo_producto = document.getElementById(tipo_programa);
                        tipo_producto.setAttribute("selected","true");
                }

                //display area del programa si es que coincide
                if(area_conocimiento == "Innovación y Emprendimiento" || area_conocimiento == "Finanzas e Inversiones" || area_conocimiento == "Marketing y Ventas" || area_conocimiento == "Estrategia y Gestión" ||
                area_conocimiento == "Personas y Equipos" || area_conocimiento == "Operaciones y Logística" || area_conocimiento == "Dirección de Instituciones de Salud" || area_conocimiento == "Operaciones y Logistica"){
                    var area_val = document.getElementById(area_conocimiento);
                    area_val.setAttribute("selected", "true");
                } else{
                    if(area_conocimiento == "Finanzas"){
                        var area_val = document.getElementById('Finanzas e Inversiones');
                        area_val.setAttribute("selected", "true");

                    } else if(area_conocimiento == "Innovación"){
                        var area_val = document.getElementById('Innovación y Emprendimiento');
                        area_val.setAttribute("selected", "true");

                    } else if(area_conocimiento == "Dirección de Personas y Equipos"){
                        var area_val = document.getElementById('Personas y Equipos');
                        area_val.setAttribute("selected","true");

                    } else if(area_conocimiento == 'Estrategia y Gestión de Negocios'){
                        var area_val = document.getElementById('Estrategia y Gestión');
                        area_val.setAttribute("selected", "true");

                    } else if(area_conocimiento == 'Gestión de Instituciones de Salud'){
                        var area_val = document.getElementById('Dirección de Instituciones de Salud');
                        area_val.setAttribute('selected', 'true');

                    } else if(area_conocimiento == 'Marketing y Venta'){
                        var area_val = document.getElementById('Marketing y Ventas');
                        area_val.setAttribute('selected', 'true');

                    } else if(area_conocimiento == 'Operaciones y Logística\n'){
                        var area_val = document.getElementById('Operaciones y Logí')
                    }
                    else{
                        var area_val = document.getElementById('otro');
                        area_val.setAttribute("selected","true");
                        area_val.value = area_conocimiento;
                        area_val.removeAttribute("disable");
                        area_val.removeAttribute("hidden");
                    }
                }

                //display modalidad si es que coincide
                if(modalidad_programa == "Presencial" || modalidad_programa == "B-Learning" || modalidad_programa == "E-Learning" || modalidad_programa == "Virtual" ||
                    modalidad_programa == "Mixto" || modalidad_programa == "Híbrido"){
                        var modalidad = document.getElementById(modalidad_programa);
                        modalidad.setAttribute("selected", "true");
                } else{
                    if(modalidad_programa == "B-Learing"){
                        var modalidad = document.getElementById('B-Learning');
                        modalidad.setAttribute("selected", "true");
                    }

                }

                //display periodo si es de los ultimos 2 años
                if(periodo == '2022S1' || periodo == '2022S2' || periodo == '2023S1' || periodo == '2023S2' || periodo =='2024S1' ||
                    periodo == '2024S2'){
                        var periodo_select = document.getElementById(periodo);
                        periodo_select.setAttribute("selected", "true");
                        var fecha_inicio = document.getElementById('fecha_de_inicio');
                        fecha_inicio.value = fecha_de_inicio;
                }

                //display realizacion si es que coincide con las actuales
                if(realizacion_en == "FEN" || realizacion_en == "FUERA" || realizacion_en == "INTERNACIONAL" || realizacion_en == "Oriente"){
                    var realizacion = document.getElementById(realizacion_en);
                    realizacion.setAttribute("selected", "true");
                }
                
                //display nivel
                if(nivel == 'Inicial' || nivel == 'Intermedio' || nivel == 'Avanzado' || nivel == 'Experto'){
                    var nivel_val = document.getElementById(nivel);
                    nivel_val.setAttribute("selected", "true");
                }

                //display horario si es que coincide
                if(horario == 'AM' || horario == 'PM' || horario == 'WK' || horario == 'TD'){
                    var horario_val = document.getElementById(horario);
                    horario_val.setAttribute("selected", "true");
                }
                
                //creamos opciones de versiones y si es que coincide con una se enseña, si no queda V1 default
                var version_option = ['V2', 'V3', 'V4', 'V5', 'V6', 'V7', 'V8', 'V9'];

                var show_version = document.getElementById('hide-version')
                show_version.removeAttribute("hidden");
                show_version.removeAttribute("disable");
                var v1_version = document.getElementById('V1');
                v1_version.removeAttribute('hidden');
                v1_version.removeAttribute('disable');
                v1_version.removeAttribute('selected');

                var version_select = document.getElementById('version');
                
                for (var i = 0; i < version_option.length; i++){
                    var opcion = document.createElement("option");
                    opcion.setAttribute("id", version_option[i]);
                    opcion.setAttribute("name", version_option[i]);
                    opcion.setAttribute("value", version_option[i]);
                    opcion.text = version_option[i];
                    version_select.appendChild(opcion);

                    if(version_option[i] == version){
                        var this_version = document.getElementById(version);
                        this_version.setAttribute('selected', 'true');
                    }
                }

                //display usr_coordinador_ejecutivo
                if(usr_ejecutivo_ventas == 'covando' || usr_ejecutivo_ventas == 'cgalan' ||
                    usr_ejecutivo_ventas== 'fgonzalez' || usr_ejecutivo_ventas == 'mcastro' || usr_ejecutivo_ventas == 'nhormazabal'){
                        var select_ejecutivo = document.getElementById(usr_ejecutivo_ventas);
                        select_ejecutivo.setAttribute('selected', 'true');
                }
            </script>
            <?php
        }
    } 
}
?>