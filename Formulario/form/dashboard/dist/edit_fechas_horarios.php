<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="C:\laragon\www\form\css\estilo_create_program.css">
<body>
    <div class="title" style ="margin-left: 20px;">
        <h4>
            Fechas y Horarios
        </h4>
    </div>
    <hr>    
    <br>
    <div id = "fecha_y_horarios" name = "fecha_y_horarios">
        <div class = "container text-center">
            <div id = "fechas" name = "fechas">
                <div class = "row row-cols-2 row-cols-lg-2 g-lg-2">
                    <div class = "col">
                        <div id = "periodo_t" name = "periodo_t">
                            <label>
                                Periodo
                                <br>
                                <select name = "periodo" id = "periodo" required>
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
                    <div class = "col">
                        <div id = "jornada_t" name = "jornada_t">
                            <label>
                                Horario
                                <br>
                                <select name = "jornada" id = "horario" required>
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
                    <div class = "col">
                        <div id = "fecha_inicio_t" name = "fecha_inicio_t">
                            <label>
                                Fecha de Inicio
                                <br>
                                <input name = "fecha_de_inicio" type = "date" id = "fecha_de_inicio" required>
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "fecha_termino_t" name = "fecha_termino_t">
                            <label>
                                Fecha de Termino    
                                <br>
                                <input name = "fecha_de_termino" type = "date" id = "fecha_de_termino" required>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id ="horas_title" name = "horas_title" style ="margin-left: 20px;">
            <h4>
                Horario
            </h4>
        </div>
        <hr>
        <br>
        <div class = "container text-center">
            <div id = horas name = "horas">
                <div class ="row row-cols-2 row-cols-lg-2 g-lg-2">
                    <div class = "col">
                        <div id = "hora_inicio_t" name = "hora_inicio_t">
                            <label>
                                Hora Inicio
                                <br>
                                <input required type = "time" id = "hora_inicio" name = "hora_inicio" required>
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "hora_final_t" name = "hora_final_t">
                            <label>
                                Hora Final
                                <br>
                                <input required type = "time" id = "hora_final" name = "hora_final" required>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id = "horas_mas" name = "horas_mas">
                <div class ="row row-cols-3 row-cols-lg-3 g-lg-3">
                    <div class = "col">
                        <div id = "horas_t" name = "horas_t">
                            <label>
                                Horas Totales
                                <br>
                                <input required id = "hora_inicio" name = "hora_inicio" pattern="[0-9]" placeholder = "Ingrese Horas Totales">
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horas_online_t" name = "horas_online_t">
                            <label>
                                Hora Totales Online
                                <input requiered id = "hora_inicio" name = "hora_inicio" pattern="[0-9]" placeholder = "Ingrese Horas Totales Online">
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horas_pedagogicas_t" name = "horas_pedagogicas_t">
                            <label>
                                Horas Pedagogicas
                                <input required id = "hora_inicio" name = "hora_inicio" pattern="[0-9]" placeholder = "Ingrese Horas Pedagogicas ">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id = "info_web" name = "info_web">
                <div class ="row row-cols-2 row-cols-lg-2 g-lg-2">
                    <div class ="col">
                        <div id = "nombre_web_t" name = "nombre_web_t">
                            <label>
                                Nombre Web Programa
                                <input required style = "width: 300px;" name = "nombre_web" id = "nombre_web" type = "text" maxlength = "110" required/>
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horario_web_t" name = "horario_web_t">
                            <label>
                                Horario Web Programa
                                <input required style = "width: 300px;" name = "horario_web" id = "horario_web" type = "text" maxlength = "255" required/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
<script>
</script>