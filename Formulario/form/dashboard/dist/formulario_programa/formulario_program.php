<?php

$buscar = $_POST['buscar'];
$getted_program = $_POST['getted_program'];
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class = "formulario-create-main">
    <legend id = "legend"></legend>
    <form id = "formulario-create-main-body" method = 'post'>
        <p>
            <p>
                <label>
                    Nombre Programa:
                    <input name = "nombre_programa" type = "text" maxlength = "100" required/>
                </label>

            </p>
            <p>
                <label>
                    Tipo Producto:
                    <select name= "tipo_producto" required>
                        <option value= "diplomados">
                            DIPLOMADOS
                        </option>
                        <option value= "diplomados_postitulo">
                            DIPLOMADOS_POSTITULO
                        </option>
                        <option value= "cursos">
                            CURSOS
                        </option>
                    </select> 
                </label>
            </p>
            <p>
                <label>
                    Area
                    <select name = "area" required>
                        <option value= "innovación">
                            Innovación
                        </option>
                        <option value= "finanza-inversión">
                            Finanzas e Inversiones
                        </option>
                        <option value= "marketing-ventas">
                            Marketing y Ventas
                        </option>
                        <option value = "estrategia">
                            Estrategia
                        </option>
                        <option value = "personas-equipos">
                            Personas y Equipos
                        </option>
                        <option value = "operaciones-logísticas">
                            Operaciones y Logística
                        </option>
                        <option value = "dirección-instituciones-salud">
                            Dirección de Instituciones de Salud
                        </option>   
                    </select> 
                </label>
            </p>
        </p>
        <p>
            <p>
                <label>
                    Tipo Programa:
                    <select name = "tipo_programa" required>
                        <option value = "">
                            COMPLETAR
                        </option>

                    </select>
                </label>
            </p>
            <p>
                <label>
                    Modalidad
                    <select name = "modalidad" required>
                        <option value = "presencial">
                            Presencial
                        </option>
                        <option value = "b-learning">
                            B-Learning
                        </option>
                        <option value = "e-learning">
                            E-Learning
                        </option>
                        <option value = "virtual">
                            Virtual
                        </option>
                        <option value = "mixto">
                            Mixto
                        </option>
                        <option value = "híbrido">
                            Híbrido
                        </option>
                    </select>
                </label>
            </p>
            <p>
                <label>
                    Periodo
                    <select name= "periodo" required>
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
            </p>
        </p> 
        <p>
            <p>
                <label>
                    Horario
                    <select name = "horario" required>
                        <option value = "am">
                            AM
                        </option>
                        <option value = "pm">
                            PM
                        </option>
                        <option value = "wk">
                            WK
                        </option>
                        <option value = "td">
                            TD
                        </option>
                    </select>
                </label>
            </p>
            <p>
                <label>
                    Nivel
                    <select name = "nivel" required>
                        <option value = "inicial">
                            Inicial
                        </option>
                        <option value = "intermedio">
                            Intermedio
                        </option>
                        <option value = "avanzado">
                            Avanzado
                        </option>
                        <option value = "experto">
                            Experto
                        </option>
                    </select>
                </label>
            </p>
            <p>
                <label>
                    ¿Donde se realizará?
                    <select name = "realización_en" required>
                        <option value = "fen">
                            FEN
                        </option>
                        <option value = "fuera">
                            FUERA
                        </option>
                        <option value = "oriente">
                            Oriente
                        </option>
                        <option value = "oriente-fen">
                            Oriente FEN
                        </option>
                        <option value = "internacional">
                            INTERNACIONAL 
                        </option>
                    </select>
                </label>
            </p>
        </p>
        <p>
            <label>
                Fecha de Inicio
                <input type = "date" name = "fecha_de_inicio" required>
            </label>
        </p>
        <input type="hidden" name="buscar" value="<?php echo $buscar; ?>">
    </form>
</div>

<script>
    var tipo_producto = document.getElementById('tipo_producto');
    var area = document.getElementById('area');
    var tipo_programa = document.getElementById('tipo_programa');
    var modalidad = document.getElementById('modalidad');
    var periodo = document.getElementById('periodo');
    var horario = document.getElementById('horario');
    var nivel = document.getElementById('nivel');
    var realización_en = document.getElementById('realización_en');
    var fecha_de_inicio = d = document.getElementById('fecha_de_inicio');

    var getted_program = <?php echo $getted_program; ?>;
    var buscar = <?php echo $buscar;?>;
    if(buscar){
        tipo_producto.removeAttribute('required');
        area.removeAttribute('required');
        tipo_programa.removeAttribute('required');
        modalidad.removeAttribute('required');
        periodo.removeAttribute('required');
        horario.removeAttribute('required');
        nivel.removeAttribute('required');
        realización_en.removeAttribute('required');
        fecha_de_inicio.removeAttribute('required');

        include('formulario_buttons/buscar_button.php');
    }

    else{
        if(getted_program){
            //Agregar versión obtenida de get_program
            version_option = ['V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'V7', 'V8', 'V9'];
            var formulario = document.getElementById("formulario-create-main-body");
            var version = document.createElement("select");
            version.name = "version";

            for (var i = 0; i < version_option.length; i++) {
                var opcion = document.createElement("option");
                opcion.value = "V" + (i + 1);
                opcion.text = "V" + (i + 1);
                version.appendChild(opcion);
            }            
            formulario.appendChild(version);

            var version = document.getElementById('version');
            var version_data = new FormData();
            version_data.append('version', version);

            // Hacer la solicitud para list_campos_no_vacios
            fetch('get_or_post_data.php', {
            method: 'POST',
            body: version_data
            })
            .catch(error => {
            // Manejar errores
            });
        }

        var buscar_data = new FormData();
        buscar_data.append('buscar', buscar);

        // Hacer la solicitud para list_campos_no_vacios
        fetch('get_or_post_data.php', {
        method: 'POST',
        body: buscar_data
        })
        .catch(error => {
        // Manejar errores
        });

        var getted_program_2_data = new FormData();
        getted_program_2_data.append('getted_program_2', getted_program);

        // Hacer la solicitud para list_campos_no_vacios
        fetch('get_or_post_data.php', {
        method: 'POST',
        body: getted_program_2_data
        })
        .catch(error => {
        // Manejar errores
        });
        
        include('formulario_buttons/create_buttons.php');
    }
</script>