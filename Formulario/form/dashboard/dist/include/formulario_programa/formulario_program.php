<?php

$buscar = $_POST['buscar'];
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class = "formulario-create-main">
    <legend> Crear Programa </legend>
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
                        <option value = "tu-decides">
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

    if(var buscar = <?php echo $buscar; ?>; == 'true'){
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
        include('formulario_buttons/create_buttons.php');
    }
</script>