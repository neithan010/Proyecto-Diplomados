<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                    <option  id = 'otro_periodo' disable = "disable" hidden>
                                   
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
                                    <option  id = 'otro_jornada' disable = "disable" hidden>
                                   
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
                                <input name = "fecha_de_inicio" type = "date" id = "fecha_de_inicio">
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "fecha_termino_t" name = "fecha_termino_t">
                            <label>
                                Fecha de Termino    
                                <br>
                                <input name = "fecha_de_termino" type = "date" id = "fecha_de_termino">
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
                                <input type = "time" id = "hora_inicio" name = "hora_inicio">
                            </label>
                            <script>
                                var hora_inicio = '<?php echo $data[39];?>';
                                document.getElementById('hora_inicio').value = hora_inicio;
                            </script>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "hora_final_t" name = "hora_final_t">
                            <label>
                                Hora Final
                                <br>
                                <input type = "time" id = "hora_final" name = "hora_final">
                            </label>
                            <script>
                                var hora_termino = '<?php echo $data[40];?>';
                                document.getElementById('hora_final').value = hora_termino;
                            </script>
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
                                <input id = "hora_totales" name = "hora_totales" placeholder = "Ingrese Horas Totales">
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horas_online_t" name = "horas_online_t">
                            <label>
                                Hora Totales Online
                                <br>
                                <input id = "hora_online" name = "hora_online" placeholder = "Ingrese Horas Totales Online">
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horas_pedagogicas_t" name = "horas_pedagogicas_t">
                            <label>
                                Horas Pedagogicas
                                <br>
                                <input id = "hora_pedagogicas" name = "hora_pedagogicas" placeholder = "Ingrese Horas Pedagogicas ">
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
                                <br>
                                <input style = "width: 300px;
                                                        white-space: nowrap;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;" 
                                                        name = "nombre_web" id = "nombre_web" type = "text" maxlength = "110"/>
                            </label>
                        </div>
                    </div>
                    <div class = "col">
                        <div id = "horario_web_t" name = "horario_web_t">
                            <label>
                                Horario Web Programa
                                <br>
                                <input style = "width: 300px;
                                                        white-space: nowrap;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;"  
                                                        name = "horario_web" id = "horario_web" type = "text" maxlength = "255"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    //periodo
    var periodo = '<?php echo $data[4];?>';
    if(periodo == '2022S1' || periodo == '2022S2' || periodo == '2023S1' || periodo == '2023S2' || periodo =='2024S1' ||
        periodo == '2024S2'){
        var periodo_select = document.getElementById(periodo);
        periodo_select.setAttribute("selected", "true");
        var fecha_inicio = document.getElementById('fecha_de_inicio');
        fecha_inicio.value = fecha_de_inicio;
    } else{
        var otro_periodo = document.getElementById('otro_periodo');
        otro_periodo.removeAttribute('disable');
        otro_periodo.setAttribute('selected', 'true');
        otro_periodo.textContent = periodo;
        otro_periodo.value = periodo;
    }

    //jornada horario
    var horario = '<?php echo $data[5];?>';
    if(horario == 'AM' || horario == 'PM' || horario == 'WK' || horario == 'TD'){
        var horario_val = document.getElementById(horario);
        horario_val.setAttribute("selected", "true");
    } else{
        var otro_jornada = document.getElementById('otro_jornada');
        otro_jornada.removeAttribute('disable');
        otro_jornada.setAttribute('selected', 'true');
        otro_jornada.textContent = horario;
        otro_jornada.value = horario;
    }

    //fecha de inicio 
    var fecha_de_inicio = '<?php echo $data[8];?>';
    document.getElementById('fecha_de_inicio').value = fecha_de_inicio;

    //Restringimos fechas seleccionadas por semestre.
    document.getElementById('periodo').addEventListener('change', function() {
        var periodo = this.value;
        var fechaInicio = document.getElementById('fecha_de_inicio');
        var fechaActual = new Date();

        if (periodo === '2022S1') {
            fechaInicio.setAttribute('min', '2022-01-01');
            fechaInicio.setAttribute('max', '2022-06-30');
        } else if (periodo === '2022S2') {
            fechaInicio.setAttribute('min', '2022-07-01');
            fechaInicio.setAttribute('max', '2022-12-31');
        } 

        if (periodo === '2023S1') {
            fechaInicio.setAttribute('min', '2023-01-01');
            fechaInicio.setAttribute('max', '2023-06-30');
        } else if (periodo === '2023S2') {
            fechaInicio.setAttribute('min', '2023-07-01');
            fechaInicio.setAttribute('max', '2023-12-31');
        } 

        if (periodo === '2024S1') {
            fechaInicio.setAttribute('min', '2024-01-01');
            fechaInicio.setAttribute('max', '2024-06-30');
        } else if (periodo === '2024S2') {
            fechaInicio.setAttribute('min', '2024-07-01');
            fechaInicio.setAttribute('max', '2024-12-31');
        }

        if (periodo === '2025S1') {
            fechaInicio.setAttribute('min', '2025-01-01');
            fechaInicio.setAttribute('max', '2025-06-30');
        } else if (periodo === '2025S2') {
            fechaInicio.setAttribute('min', '2025-07-01');
            fechaInicio.setAttribute('max', '2025-12-31');
        } 

        if (new Date(fechaInicio.value) < new Date(fechaInicio.min)) {
            fechaInicio.value = fechaInicio.min;
        } else if (new Date(fechaInicio.value) > new Date(fechaInicio.max)) {
            fechaInicio.value = fechaInicio.max;
        }
    });

    document.getElementById('fecha_de_inicio').addEventListener('change', function() {
        var fechaSeleccionada = new Date(this.value);
        var fechaMin = new Date(this.min);
        var fechaMax = new Date(this.max);

        if (fechaSeleccionada < fechaMin) {
            this.value = this.min;
        } else if (fechaSeleccionada > fechaMax) {
            this.value = this.max;
        }
    });

    //fecha de termino 
    var fecha_de_termino = '<?php echo $data[35];?>';
    document.getElementById('fecha_de_termino').value = fecha_de_termino;

    //Restricción de fecha
    //condición: fecha de incio <= fecha de termino

    /*if(fecha_de_termino < fecha_de_inico){
        document.getElementById('fecha_de_termino').value = fecha_de_inicio;
    } else{
        document.getElementById('fecha_de_termino').value = fecha_de_termino;
    }*/

    //horas totales, online y pedagogicas
    var hora_totales = '<?php echo $data[36];?>';
    var hora_online = '<?php echo $data[37];?>';
    var hora_pedagogicas = '<?php echo $data[38];?>';

    document.getElementById('hora_totales').value =  hora_totales;
    document.getElementById('hora_online').value = hora_online;
    document.getElementById('hora_pedagogicas').value = hora_pedagogicas;

    //nombre web
    var nombre_web = '<?php echo $data[24];?>';
    document.getElementById('nombre_web').value = nombre_web;

    var horario_web = '<?php echo $data[18];?>';
    document.getElementById('horario_web').value = horario_web;
</script>