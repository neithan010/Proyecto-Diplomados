<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="title" style = "margin-left: 20px;">
    <h4>
        Información General
    </h4>
    <h5>
        <div id = "nombre_program_title" name = "nombre_program_title">
            <?php
                //nom_diploma 
                echo $data[0];
            ?>
        </div>
    </h5>
</div>
<hr>
<br>
<div id = "info_general" name = "info_general">
    <div class="container text-center">
        <div class="row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class="col">
                <div id = "nombre_programa_t" name = "nombre_programa_t">
                    <label>
                        Nombre Programa:
                        <br>
                        <input style = "width: 300px;
                                                        white-space: nowrap;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;"  
                                                        name = "nombre_program" id = "nombre_program" 
                                                        onchange = 'changeCodDiploma()'
                            type = "text" maxlength = "100"/>
                            <?php 
                                $nombre_programa = $data[0];
                                $l = strlen($nombre_programa);
                                $name = '';
                                for($i = 0; $i < $l; $i++){
                                    //si estamos en un espacio en blano y viene un - quiere decir que todo lo anterior
                                    //es el nombre del programa y lo que viene es el código del diploma.
                                    if($nombre_programa[$i] == ' ' && $nombre_programa[$i+1] == '-'){
                                        break;
                                    } else{
                                        //en otro caso debemos copiar el nombre 
                                        $name .= $nombre_programa[$i]; 
                                    }
                                } 
                            ?>
                            <script>
                              //nombre_diploma
                                var nombre = '<?php echo $name;?>'; 
                                document.getElementById('nombre_program').value = nombre;
                            </script>   
                    </label>
                </div>
            </div>
            <div class="col">
                    <div class="">
                        <label>
                            Codigo Programa:
                            <br>
                            <input name = "cod_diploma" id = "cod_diploma" type = "text" maxlength = "25" required/>
                        </label>
                        <script>
                            document.getElementById('cod_diploma').value = '<?php echo $data[11];?>';
                            </script>
                    </div>
                </div>
            <div class="col">
                <div id = "cod_interno_t" name = "cod_interno_t">
                    <label>
                        Código Interno:
                        <br>
                        <input name = "cod_interno" id = "cod_interno" type = "text" maxlength = "10"/>
                        <script>
                            //Codigo Interno
                            document.getElementById('cod_interno').value = '<?php echo $data[22];?>';
                        </script>
                    </label>
                </div>
            </div>
            <div class="col">
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
                            <option  id = 'otro_tipo_producto' disable = "disable" hidden>
                                   
                            </option>
                        </select>
                    </label>
                    <label id = "curso_conducente" disable = "disable" hidden>
                        <input type="checkbox" id="curso_conducente_box" name ="curso_conducente_box" value="Conducente"/> ¿Es un Curso Conducente?
                    </label>
                    <script> 
                        //Tipo Producto
                        var tipo_programa = '<?php echo $data[1];?>';
                        if(tipo_programa == "Diploma" || tipo_programa == "Diploma Postitulo" || tipo_programa == "Curso"){
                            var tipo_producto = document.getElementById(tipo_programa);
                            tipo_producto.setAttribute("selected","true");
                            

                        } else if(tipo_programa == "Curso Conducente"){
                            var tipo_producto = document.getElementById('Curso');
                            tipo_producto.setAttribute('selected', 'true');

                            var conducente = document.getElementById('curso_conducente');
                            conducente.removeAttribute('hidden');
                            conducente.removeAttribute('disable');

                            var conducente_box = document.getElementById('curso_conducente_box');
                            conducente_box.setAttribute('checked', 'true');
                        } else{
                            var otro = document.getElementById('otro_tipo_producto');
                            otro.value = tipo_programa;
                            otro.textContent = tipo_programa;
                            otro.setAttribute('selected', 'true');
                            otro.removeAttribute('disable');
                        }

                        //agregamos la opcion de curso conducente como un checkbox
                        document.getElementById('tipo_producto').addEventListener('change', function(){
                            var tipo_producto = this.value;
                            var curso_conducente = document.getElementById('curso_conducente');

                            if(tipo_producto == "Curso"){
                                curso_conducente.removeAttribute('disable');
                                curso_conducente.removeAttribute('hidden');
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="col">
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
                        <option name = 'otro' id = 'otro_area' disable = "disable" hidden>
                            
                        </option>
                    </select> 
                </label>
                <script>
                    //area
                    var area_conocimiento = '<?php echo $data[2];?>';
                    if(area_conocimiento == "Innovación y Emprendimiento" || area_conocimiento == "Finanzas e Inversiones" || area_conocimiento == "Marketing y Ventas" || area_conocimiento == "Estrategia y Gestión" ||
                        area_conocimiento == "Personas y Equipos" || area_conocimiento == "Operaciones y Logística" || area_conocimiento == "Dirección de Instituciones de Salud"){
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

                        } else if(area_conocimiento.includes('Operacion')){
                            var area_val = document.getElementById('Operaciones y Logística');
                            area_val.setAttribute('selected', 'true');
                        } else if(area_conocimiento.includes('Operaciones y Logística ')){
                            var area_val = document.getElementById('Operaciones y Logística');
                            area_val.setAttribute('selected', 'true');
                        }
                        else{
                            var area_val = document.getElementById('otro_area');
                            area_val.setAttribute("selected","true");
                            area_val.value = area_conocimiento;
                            area_val.textContent = area_conocimiento;
                            area_val.removeAttribute("disable");
                        }
                    }
                </script>
            </div>
            <div class="col">
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
                        <option id = 'otro_modalidad' disable = "disable" hidden>
                            
                        </option>
                    </select>
                </label>
                <script>
                    //modalidad
                    var modalidad_programa = '<?php echo $data[3];?>';
                    if(modalidad_programa == "Presencial" || modalidad_programa == "B-Learning" || modalidad_programa == "E-Learning" || modalidad_programa == "Virtual" ||
                        modalidad_programa == "Mixto" || modalidad_programa == "Híbrido"){
                            var modalidad = document.getElementById(modalidad_programa);
                            modalidad.setAttribute("selected", "true");
                    } else{
                        if(modalidad_programa == "B-Learing"){
                            var modalidad = document.getElementById('B-Learning');
                            modalidad.setAttribute("selected", "true");
                        } else{
                            var modalidad = document.getElementById('otro_modalidad');
                            modalidad.textContent = modalidad_programa;
                            modalidad.value = modalidad_programa;
                            modalidad.setAttribute('selected', 'true');
                            modalidad.removeAttribute('disable');
                        }
                    }
                </script>
            </div>
            <div class="col">
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
                        <option id = otro_nivel disable = 'disable' hidden>
                        </option>
                    </select>
                </label>
                <script>
                    //nivel
                    var nivel = '<?php echo $data[6];?>';
                    if(nivel == 'Inicial' || nivel == 'Intermedio' || nivel == 'Avanzado' || nivel == 'Experto'){
                        var nivel_val = document.getElementById(nivel);
                        nivel_val.setAttribute("selected", "true");
                    } else{
                        var nivel_val = document.getElementById('otro_nivel');
                        nivel_val.value = nivel;
                        nivel_val.textContent = nivel;
                        
                        var select_nivel = document.getElementById('nivel');
                        select_nivel.setAttribute('placeholder', 'hola');
                    }
                </script>
            </div>
        </div>
        <br>
        <div class="row row-cols-2 row-cols-lg-2 g-lg-2">
            <div class="col">
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
                        <option id = "otro_realizacion" disable = 'disable' hidden>
                        </option>
                    </select>
                </label>
                <script>
                    //realización en:
                    var realizacion_en = '<?php echo $data[7];?>';
                    if(realizacion_en == "FEN" || realizacion_en == "FUERA" || realizacion_en == "INTERNACIONAL" || realizacion_en == "Oriente"){
                        var realizacion = document.getElementById(realizacion_en);
                        realizacion.setAttribute("selected", "true");
                    } else{
                        var otro = document.getElementById('otro_realizacion');
                        otro.value = realizacion_en;
                        otro.textContent = realizacion_en;
                        otro.removeAttribute('disable');
                        otro.setAttribute('selected', 'true');
                    }
                </script>
            </div>
            <div class="col" id = "hide-version">
                <label>
                    Versión
                    <br>
                    <select class="text-center" id = "version" name ="version" onchange = 'changeCodDiploma()'>
                        <option value = "" selected = "true" disable = "disable" hidden></option>
                        <option value = "V1" id = "V1" name ="V1">V1</option>
                        <option value = "V2" id = "V2" name ="V2">V2</option>
                        <option value = "V3" id = "V3" name ="V3">V3</option>
                        <option value = "V4" id = "V4" name ="V4">V4</option>
                        <option value = "V5" id = "V5" name ="V5">V5</option>
                        <option value = "V6" id = "V6" name ="V6">V6</option>
                        <option value = "V7" id = "V7" name ="V7">V7</option>
                        <option value = "V8" id = "V8" name ="V8">V8</option>
                        <option value = "V9" id = "V9" name ="V9">V9</option>
                        <option              id = "otra_version" hidden disbable = 'disable'></option>
                    </select>
                </label>
                <script>
                    //version
                    var version_option = ['V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'V7', 'V8', 'V9'];
                    var version = '<?php echo $data[9];?>';
                    if(version_option.includes(version)){
                        var this_version = document.getElementById(version);
                        this_version.setAttribute('selected', 'true');
                    } else{
                        otra_version = document.getElementById('otra_version');
                        otra_version.value = version;
                        otra_version.textContent = version;
                        otra_version.setAttribute('selected', 'true');
                        otra_version.removeAttribute('disable');
                    }
                </script>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<div id = "programa_habilitado_title" name = "programa_habilitado_title" style = "margin-left: 20px;">
    <h4>
        Habilitación del Programa
    </h4>
</div>
<hr>
<br>
<div id = "programa_habilitado" name ="programa_habilitado">
    <div class="container text-center">
        <div class="row row-cols-2 row-cols-lg-2 g-lg-2">
            <div class="col">
                <div id = "habilitado_t" name = "habilitado_t">
                    <label>
                        Habilitado
                        <br>
                        <select id = "habilitado" name ="habilitado" class="text-center">
                            <option value = "" selected = "true" disable = "disable" hidden></option>
                            <option value = "0" id = "habilitado_0">Si</option>
                            <option value = "1" id = "habilitado_1">No</option>
                        </select>
                    </label>
                    <script>
                        //habilitado
                        document.getElementById("habilitado_"+'<?php echo $data[15];?>').setAttribute('selected', 'true');
                    </script>
                </div>
            </div>
            <div class="col">
                <div id = "web_habilitado_t" name = "web_habilitado_t">
                    <label>
                        Habilitado en la Web
                        <br>
                        <select id = "web_habilitado" name = "web_habilitado" class="text-center">
                            <option value = "" selected = "true" disable = "disable" hidden></option>
                            <option value = "1" id = "web_1">Si</option>
                            <option value = "0" id = "web_0">No</option>
                        </select>
                    </label>
                    <script>
                        //habilitado web
                        document.getElementById("web_"+'<?php echo $data[16];?>').setAttribute('selected', 'true');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<div id = "valor_diplomado_title" name = "valor_diplomado_title" style = "margin-left: 20px;">
    <h4>
        Costo Programa
    </h4>
</div>
<hr>
<br>
<div id = "coste_programa" name = "coste_programa">
    <div class="container text-center">
        <div class="row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class ="col">
                <div id = "valor_diplomado_t" name = "valor_diplomado_t">
                    <label>
                        Valor Diplomado
                        <input id = "valor_diplomado" name = "valor_diplomado" pattern="[0-9]{1,}\.[0-9]{1,}" placeholder = "Ingrese número decimal">
                    </label>
                    <script>
                        //valor diplomado
                        document.getElementById('valor_diplomado').value = '<?php echo $data[33];?>'
                    </script>
                </div>
            </div>
            <div class ="col">
                <div id = "moneda_t" name = "moneda_t">
                    <label>
                        Tipo Moneda
                        <br>
                        <select id = "moneda" name = "moneda" class = "text-center">
                            <option value = "" selected = "true" disable = "disable" hidden></option>
                            <option id = 'CLP' name = "CLP" value = "CLP">CLP</option>
                            <option id = 'USD' name = "USD" value = "USD">USD</option>
                            <option id = 'UF' name = "UF" value = "UF">UF</option>
                            <option id = 'otra_moneda' hidden disable = 'disable'></option>
                        </select>
                    </label>
                    <script>
                        var moneda_d = '<?php echo $data[34];?>';
                        if(moneda_d == 'CLP' || moneda_d == 'USD' || moneda_d == 'UF'){
                            var m = document.getElementById(moneda_d);
                            m.setAttribute('selected', 'true');
                        } else{
                            var m = document.getElementById('otra_moneda');
                            m.value = moneda_d;
                            m.textContent = moneda_d;
                            m.removeAttribute('disable');
                            m.setAttribute('selected', 'true');
                        }
                    </script>
                </div>
            </div>
            <div class ="col">
                <div id = "vacantes_t" name = "vacantes_t">
                    <label>
                        Vacantes
                        <br>
                        <input id = "vacantes" name = "vacantes" placeholder = "Ingrese número vacantes">
                    </label>
                    <script>
                        //vacante
                        var vacantes = '<?php echo $data[20];?>';
                        if(vacantes != ''){
                            document.getElementById('vacantes').value = vacantes;
                        }
                    </script>
                </div>
            </div>
        </div>
        <br>
        <div class = "row row-cols-2 row-cols-lg-2 g-lg-2">
            <div class = "col">
                <div id = "meta_t" name = "meta_t">
                    <label>
                        Meta
                        <br>
                        <input type = 'number' id = "meta" name = "meta" pattern="[0-9]{1,}" placeholder = "Ingrese valor meta">
                    </label>
                    <script>
                        //meta
                        var meta = '<?php echo $data[41];?>';
                        if(meta != ''){
                            document.getElementById('meta').value = meta;
                        }
                    </script>
                </div>
            </div>
            <div class = "col">
                <div id= "valor_meta_t" name = "valor_meta_t">
                    <label>
                        Valor Meta
                        <br>
                        <input type = 'number' id = "valor_meta" name = "valor_meta" pattern="[0-9]{1,}" placeholder = "Ingrese número decimal">
                    </label>
                    <script>
                        //valor meta
                        var val_meta = '<?php echo $data[42];?>';
                        if(val_meta != ''){
                            document.getElementById('valor_meta').value = val_meta;
                        }
                    </script>
                </div>  
            </div>
        </div>
    </div>
</div>