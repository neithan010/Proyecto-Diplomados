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
                            <select name = "tipo" id = "tipo_producto">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value= "Diplomados">
                                    DIPLOMADOS
                                </option>
                                <option value= "Diplomados Postitulo">
                                    DIPLOMADOS_POSTITULO
                                </option>
                                <option value= "Cursos">
                                    CURSOS
                                </option>
                                <option name = 'otro' id = 'otro'>
                                    OTROS
                                </option>
                            </select> 
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2">
                        <label>
                            Area
                            <select name = "area" id = "area">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value= "Innovación">
                                    Innovación
                                </option>
                                <option value= "Finanzas e Inversión">
                                    Finanzas e Inversiones
                                </option>
                                <option value= "Marketing y Ventas">
                                    Marketing y Ventas
                                </option>
                                <option value = "Estrategia">
                                    Estrategia
                                </option>
                                <option value = "Personas y Equipos">
                                    Personas y Equipos
                                </option>
                                <option value = "Operaciones y Logística">
                                    Operaciones y Logística
                                </option>
                                <option value = "Dirección de Instituciones de Salud">
                                    Dirección de Instituciones de Salud
                                </option>   
                            </select> 
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2 margin-left">
                        <label>
                            Tipo Programa:
                            <br>
                            <select name = "tipo_programa" id = "tipo_programa" style="width">
                                <option value = "Curso">
                                    COMPLETAR
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
                                <option value = "Presencial">
                                    Presencial
                                </option>
                                <option value = "B-Learning">
                                    B-Learning
                                </option>
                                <option value = "E-Learning">
                                    E-Learning
                                </option>
                                <option value = "Virtual">
                                    Virtual
                                </option>
                                <option value = "Mixto">
                                    Mixto
                                </option>
                                <option value = "Híbrido">
                                    Híbrido
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
                                <option value= "2024S1">
                                    Primer Semestre 2024
                                </option>
                                <option value= "2024S2">
                                    Segundo Semestre 2024
                                </option>
                                <option value= "2025S1">
                                    Primer Semestre 2025
                                </option>
                                <option value= "2025S2">
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
                                <option value = "AM">
                                    AM
                                </option>
                                <option value = "PM">
                                    PM
                                </option>
                                <option value = "WK">
                                    WK
                                </option>
                                <option value = "TD">
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
                                <option value = "Inicial">
                                    Inicial
                                </option>
                                <option value = "Intermedio">
                                    Intermedio
                                </option>
                                <option value = "Avanzado">
                                    Avanzado
                                </option>
                                <option value = "Experto">
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
                            <select name = "realizacion_en" id = "realización_en" autocomplete = 'off'>
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "FEN">
                                    FEN
                                </option>
                                <option value = "FUERA">
                                    FUERA
                                </option>
                                <option value = "ORIENTE">
                                    Oriente
                                </option>
                                <option value = "ORIENTE FEN">
                                    Oriente FEN
                                </option>
                                <option value = "INTERNACIONAL">
                                    INTERNACIONAL 
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
<?php
//Nos aseguramos de que la variable global este definida
if(isset($_SESSION['can_load'])){
    $getted_program = $_SESSION['can_load'];
    //nos aseguramos de que se haya seleccionado un programa y que se haya enviado
    if(isset($_POST['programaSeleccionado'])){
        $getted_program = true;
        if($getted_program){
            //obtenemos la data de un programa ya existente
            $data = $_POST['programaSeleccionado'];
            $array_data = explode(", ", $data);
            echo "<script>fill_fields();</script>";
        }
    }
}

?>
<script>
    function fill_fields(){
        var getted_program = <?php echo $getted_program;?>;
    <? echo $data;?>;
    if(getted_program){
        //obtendremos los datos que necesitamos
        var nom_diploma = <?php echo $array_data[0];?>;
        var tipo_programa = <?php echo $array_data[1];?>;
        var area_conocimiento = <?php echo $array_data[2];?>;
        var tipo = <?php echo $array_data[3];?>;
        var modalidad_programa = <?php echo $array_data[4];?>;
        var periodo = <?php echo $array_data[5];?>;
        var horario = <?php echo $array_data[6];?>;
        var nivel = <?php echo $array_data[7];?>;
        var realizacion_en = <?php echo $array_data[8];?>;
        var fecha_de_inicio = <?php echo $array_data[9];?>;
        var version = <?php echo $array_data[10];?>;
        var siglas = <?php echo $array_data[11];?>;
        var cod_diploma = <?php echo $array_data[12];?>;
        var area_negocios = <?php echo $array_data[13];?>;
        
        var DIPLOMADO = <?php echo $array_data[14];?>;
        var mail_envio = <?php echo $array_data[15];?>;
        var habilitad = <?php echo $array_data[16];?>;
        var web_habilitado = <?php echo $array_data[17];?>;
        var marca = <?php echo $array_data[18];?>;
        var horario_web = <?php echo $array_data[19];?>;
        var area = <?php echo $array_data[20];?>;
        var vacantes = <?php echo $array_data[21];?>;

        //Agregar versión obtenida de get_program
        var version_option = ['V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'V7', 'V8', 'V9'];
        var formulario = document.getElementById("formulario-create-main-body");
        var version = document.createElement("select");
        version.name = "version";

        for (var i = 0; i < version_option.length; i++) {
            var opcion = document.createElement("option");
            opcion.value = version_option[i];
            opcion.text = version_option[i];
            version.appendChild(opcion);
        }            
        formulario.appendChild(version);
    }
    }
</script>