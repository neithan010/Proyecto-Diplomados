<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="C:\laragon\www\form\css\estilo_create_program.css">
<br>
<div class="title">
    <h4>
        Información General
    </h4>
    <hr>
</div>
<br>
<div id = "info_general" name = "info_general">
    <div class="container text-center">
        <div class="row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class="col">
                <div class="">
                    <div id = "nombre_programa" name = "nombre_programa">
                        <label>
                            Nombre Programa:
                            <br>
                            <input name = "nombre_program" id = "nombre_program" type = "text" maxlength = "100" required/>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <div id = "cod_interno" name = "cod_interno">
                        <label>
                            Código Interno:
                            <br>
                            <input name = "nombre_program" id = "nombre_program" type = "text" maxlength = "100" required/>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <div id = "tipo_producto_t" name = "tipo_producto_t">
                        <label>
                            Tipo Producto:
                            <br>
                            <select name = "tipo" id ="tipo_producto">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value= "Diploma" id="Diploma">
                                    DIPLOMA
                                </option>
                                <option value= "Diploma Postitulo" id="Diploma Postitulo">
                                    DIPLOMA POSTITULO
                                </option>
                                <option value= "Curso" id = "Curso">
                                    CURSO
                                </option>
                                <option value = 'otro' id = 'otro' disable = "disable" hidden>
                                    _   
                                </option>
                            </select> 
                        </label>
                        <label id = "curso_conducente" disable = "disable" hidden>
                            <input type="checkbox" id="curso_conducente_box" name ="curso_conducente_box" value="Conducente"/> ¿Es un Curso Conducente?
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <label>
                        Area
                        <br>
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
                    <div class="">
                        <label>
                            Modalidad
                            <br>
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
                    <div class="">
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
                    <div class="">
                        <label>
                            ¿Donde se realizará?
                            <br>
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
                <div class="col" id = "hide-version">
                    <div class="">
                        <label >
                            Versión
                            <br>
                            <select id = "version" name ="version">
                                <option value = "V1" selected = "true" disable = "disable" hidden></option>
                            </select>
                        </label>
                    </div>
                </div>
        </div>
    </div>
</div>
<br>
<br>
<div id = "programa_habilitado_title" name = "programa_habilitado_title">
    <h4>
        Habilitacion de Programa
    </h4>
    <hr>
</div>
<br>
<div id = "programa_habilitado" name ="programa_habilitado">
    <div class="container text-center">
        <div class="">
            <div class="col">
                <div class="">
                    <div id = "habilitado_t" name = "habilitado_t">
                        <label>
                            Habilitado
                            <br>
                            <select id = "habilitado" name ="habilitado" class="text-center">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "0">Si</option>
                                <option value = "1">No</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="p-2">
                    <div id = "web_habilitado" name = "web_habilitado">
                        A
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id = "coste_programa" name = "coste_programa">
    <div id = "valor_diplomado" name = "valor_diplomado">

    </div>
    <div id = "moneda" name = "moneda">

    </div>
    <div id = "meta" name = "meta">

    </div>
    <div id = "valor_meta" name = "valor_meta">

    </div>
</div>
<div id = "vacantes" name = "vacantes">
</div>