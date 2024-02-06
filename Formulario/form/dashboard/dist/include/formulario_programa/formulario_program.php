<?php

session_start();

if(buscar == 1){
    formulario-create-main-body
}
?>
<form action="tu_archivo.php" method="<?php echo ($condicion) ? 'post' : 'get'; ?>">
    <!-- Aquí van los campos del formulario -->
</form>


<div class = "formulario-create-main">
    <legend> Crear Programa </legend>
    <form id = "formulario-create-main-body" action = "get_or_post_data.php" method = "<?php echo ($buscar) ? 'get' : 'post'; ?>">
        <p>
            <p>
                <label>
                    Nombre Programa:
                    <input type = "text" maxlength = "100" required/>
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
                    <select name= "area" required>
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
                        <option value= "2023S1">
                            Primer Semestre 2023
                        </option>
                        <option value= "2023S2">
                            Segundo Semestre 2023
                        </option>
                        <option value= "2024S1">
                            Primer Semestre 2024
                        </option>
                        <option value= "2024S2">
                            Segundo Semestre 2024
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
                    <select name = "realización-en" required>
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
                            OrienteFEN
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
                <input type = "date" name = "fecha-de-inicio" required>
            </label>
        </p>
        <p> 
            <p>
                <button type = "submit"> Guardar </button>
            </p>
            <p>
                <button type = "reset"> Limpiar Formulario </button>
            </p>
        </p>
    </form>
</div>