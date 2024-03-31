<?php
$_SESSION['can_load'] = false;
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
/* Desde aqui se genera el formulario que se usara exclusivamente para crear un programa, ya sea desde 0 o 
        usando los datos de uno ya existente.
      Consideraciones: 
        1.-No hay requerimientos para el input al momento de buscar, es decir, sin llenar ningún campo se puede enviar el formulario
        y no encontrará ningun programa.

        2.-Las funciones que no estén definidas en este archivo.php estan descritas y documentadas en functions_program.php.

        3.- Para modificar un campo: Se debe cambiar el atributo value por el nombre o valor que se quiera cargar en la base de datos, es decir, 
            si cambian value = 'Diploma' por value = 'DIP' en la base de datos se verá DIP. Tambien se deben modificar otros archivos,
            principalmente funciones, los archivos que se necesitan revisar al momento de modificar un campo de este formulario son los del punto 4
            de las consideraciones(el sig punto).

        4.- Flujos en el que se hacen las funcionalidades:
            create_program.php(Crear Programa) -> create_program_0.php(Crear Programa de 0) -> formulario_program.php  -> post_data.php -> post_program.php
            create_program.php(Crear Programa) -> create_program_1.php(Crear Programa usando uno existente) -> formulario_program.php  -> post_data.php -> post_program.php
*/
?>
<div class = "formulario-create-main">
    <legend id = "legend"></legend>
    <form id = "formulario-create-main-body" method = 'post'> 
        <div class="container text-center">
            <?php
            /*
            row-cols-4 y row-cols-lg-4 determina el número de columnas  que tendra cada fila, es decir, el número de input's que tendrá cada
            fila del formulario.
            */
            ?>
            <div class="row row-cols-4 row-cols-lg-4 g-lg-3">
                <div class="col">
                    <div class="">
                        <label>
                            Nombre Programa:
                            <?php /*Aqui tenemos un input del nombre del programa, sin considerar el tipo de programa que es:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                    o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                    Maxlength: Se adecua campo a campo y se restringe según las condiciones de la base de datos de intranet
                                    Onchange: Lo utilizamos para cuando exista un cambio enste campo, se adaptará el código del diploma, que es
                                        el sig campo dentro del formulario.
                            */?>
                            <input name = "nombre_program" id = "nombre_program" type = "text" maxlength = "100" onchange = 'changeCodDiploma()'/>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <label>
                            Codigo Programa:
                            <?php /*Aqui tenemos un input para el código del diploma:

                                Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                o para verificar algún atributo del input.
                                Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                Maxlength: Se adecua campo a campo y se restringe según las condiciones de la base de datos de intranet

                            */?>
                            <input name = "cod_diploma" id = "cod_diploma" type = "text" maxlength = "25"/>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <label>
                            Tipo Producto:
                            <br>
                            <?php /*Aqui tenemos un select del tipo de producto:

                                Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                o para verificar algún atributo del input.
                                Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).

                                Tiene 5 opciones: CAMPO VACIO, DIPLOMA, DIPLOMA POSTITULO, CURSO y OTRO.
                                De las 5 opciones el usuario solo podrá ver 3 de ellas, las cuales son: DIPLOMA, DIPLOMA POSTITULO y CURSO

                                El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería diploma.
                                El campo "Otro" se utiliza para enseñar un valor que no figura dentro de los parametros de un programa
                                por ejemplo: B-Learning, Charlas, etc.

                                Si el campo seleccionado es el de Curso, se enseña una checkbox debajo del select del tipo de programa, este
                                se enseñará sin chequear preguntando si el programa es un Curso Conducente.

                            */?>
                            <select name = "tipo" id ="tipo_producto" onchange = 'changeCodDiploma()'>
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
                        <?php /*
                            Aqui está la checkbox de Curso conducente, el cual tiene como value Conducente para evitar confusiones, cada vez que
                            se inicie o cargue este formulario estara hidden para evitar confusiones dentro del usuario.
                            Si se carga un dato donde figure el tipo Curso, la checkbox se va a enseñar señalando si dicho programa obtenido es o
                            no un Curso Conducente.
                        */?> 
                        <label id = "curso_conducente" disable = "disable" hidden>
                            <input type="checkbox" id="curso_conducente_box" name ="curso_conducente_box" value="Conducente"/> ¿Es un Curso Conducente?
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <label>
                            Area
                            <br>
                            <?php /*Aqui tenemos un select del area o area de conocimiento:

                                Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                o para verificar algún atributo del input.
                                Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).

                                Tiene 9 opciones: Campo Vacío, INNOVACIÓN Y EMPRENDIMIENTO, FINANZAS E INVERSIONES,MARKETING Y VENTAS,
                                                ESTRATEGIA Y GESTIÓN, PERSONAS Y EQUIPOS, OPERACIONES Y LOGÍSTICA, DIRECCIÓN DE INSTTUCIONES
                                                DE SALUD y Otro.
                                    
                                De estas 9 opciones solo 7 serán elegibles.

                                El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería Innovación y Emprendimiento.
                                El campo "Otro" se utiliza para enseñar un valor que no figura dentro de los parametros de un programa
                                por ejemplo: Cuando se escribe algo que no tenga que ver o sin sentido con una de las 7 areas mencionadas.

                            */?>
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
                            <?php   /*Aqui tenemos un select para la modalidad de un programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).

                                    Tiene 8 opciones: Campo Vacío, Presencial, B-Learning, E-Learning, Virtual, Mixto, Híbrido y Otro.
                                        
                                    De estas 8 opciones solo 6 serán elegibles.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería Presencial.
                                    El campo "Otro" se utiliza para enseñar un valor que no figura dentro de los parametros de un programa
                                    por ejemplo: Cuando se escribe algo que no tenga que ver o sin sentido con una de las 7 areas mencionadas.

                                    */ 
                            ?>
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
                            Periodo
                            <br>
                            <?php   /*Aqui tenemos un select para el periodo de un programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                    Onchange: Lo utilizamos para cuando exista un cambio enste campo, se adaptará el código del diploma.
                                        
                                    Tiene 9 opciones: Campo Vacío, 2022S1, 2022S2, 2023S1, 2023S2, 2024S1, 2024S2, 2025S1, 2025S2.
                                        
                                    De estas 9 opciones solo 8 serán elegibles.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería Presencial.

                                    Descripción: Los campos representan un semestre dado, y estos van a ir cambiando las opciones disponibles y visibles
                                    al usuario según el estado en el que esté el programa, si es que se quiere crear un programa entonces solo se podrá
                                    seleccionar las opcione: 2024S1, 2024S2, 2025S1, 2025S2. Lo anterior se hace para evitar que se puedan crear nuevos
                                    programas en periodos o fechas que ya estén en el pasado.
                                    Los periodos de 2022, 2023, y el primer semestre de 2024(semestre actual) son los que estarán disponibles y habilitados
                                    para cuando un usuario quiera crear un programa, utilizando uno que ya existe, es decir, la regla es que se usaran los
                                    programas que ya se hayan creado en los ultimos 2 años.

                                    Como último detalle, hay otra funcionalidad que se explica más abajo en el script, y es que al momento de escoger cualquier
                                    periodo, el campo fecha de inicio(del programa) se restringe de la sig manera: restringe año y si es primer semestre la fecha
                                    de inicio puede variar entre el mes de enero hasta junio, si es que el periodo es en segundo semestre, entonces se puede esocger
                                    una fecha de inicio que vaya entre el mes de julio hasta diciembre, esta funcionalidad es modificable y se enseñará en que parte
                                    del script de este archivo se puede cambiar. 

                                    */ 
                            ?>
                            <select name = "periodo" id = "periodo" onchange = 'changeCodDiploma()'>
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
                    <div class="">
                        <label>
                            Horario
                            <br>
                            <?php   /* Aqui tenemos un select con la jornada u horario que va a tener un programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                    Onchange: Lo utilizamos para cuando exista un cambio enste campo, se adaptará el código del diploma.

                                    Tiene 5 opciones: Campo Vacío, AM, PM, WK, TD.
                                        
                                    De estas 5 opciones solo 4 serán elegibles, que son todas menos el campo vacío.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería AM.

                                    Cada opción tiene sus diferentes horarios, para comprender mejor cual es el horario para AM, PM, etc, hablar
                                    con Luis Levio o con el encargado de turno.
                                    */ 
                            ?>
                            <select name = "jornada" id = "horario" onchange = 'changeCodDiploma()'>
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
                    <div class="">
                        <label>
                            Nivel
                            <br>
                            <?php   /* Aqui tenemos un select con el nivel que va a tener un programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).

                                    Tiene 5 opciones: Campo Vacío, Inicial, Intermedio, Avanzado y Experto.
                                        
                                    De estas 5 opciones solo 4 serán elegibles, que son todas menos el campo vacío.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería AM.

                                    Cada opción tiene sus diferentes descripciones:

                                    1.- Inicial: Descripción: 
                                                    Entendimiento fundamental del tema.
                                                Características:
                                                    Conocimiento elemental.
                                                    Capacidad para realizar tareas simples y rutinarias.
                                                    Dependencia de instrucciones detalladas.

                                    2.- Intermedio: Descripción: 
                                                        Competencia moderada en el tema.
                                                    Características:
                                                        Comprende conceptos más complejos.
                                                        Habilidad para abordar tareas intermedias.
                                                        Puede trabajar de manera autónoma en situaciones familiares.

                                    3.- Avanzado:   Descripción: 
                                                        Dominio avanzado del tema.
                                                    Características:
                                                        Profundo entendimiento de los conceptos.
                                                        Capacidad para abordar tareas complejas y resolver problemas.
                                                        Puede trabajar de manera independiente en la mayoría de las situaciones.

                                    4.- Experto:    Descripción: 
                                                        Máximo nivel de competencia.
                                                    Características:
                                                        Conocimiento experto y comprensión avanzada.
                                                        Capacidad para abordar tareas altamente especializadas y desafiantes.
                                                        Puede liderar, enseñar y contribuir significativamente al avance del campo.
                                    */ 
                            ?>
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
                            <?php   /*Aqui tenemos un select donde se enseña en que lugar se desarrollará el programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                    
                                    Tiene 6 opciones: Campo Vacío, FEN, FUERA, Oriente, Oriente FEN e Internacional.
                                        
                                    De estas 6 opciones solo 5 serán elegibles, que son todas menos el campo vacío.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería FEN.
                                    */ 
                            ?>
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
                    <div class="">
                        <label>
                            Fecha de Inicio
                            <br>
                            <?php   /* Este es el input que representa la fecha de inicio de un programa, esta se va a restringir según el 
                                    periodo seleccionado por el ususario, si es que primero se escoge la fecha y luego el periodo, esta fecha
                                    se va a ajustar para que quede dentro del margen de dicho periodo, por ejemplo:

                                    Si selecciono como fecha de inicio el 3-3-2024 y luego selecciono como periodo el 2024S2, como estamos fuera
                                    de lo que es el 2do semestre del 2024 la fecha de inicio se cambiará automaticamente a la fecha en la que inicia
                                    o termina el semestre seleccionado, como se tiene ajustado(modificable) que el primer semestre sean los primeros
                                    6 meses, y el segundo semestre los ultimos 6 meses del año, la fecha que quedará marcada va a ser 1-7-2024.

                                    Ocurre lo mismo si es que se escoge un periodo de diferente año.
                                    */
                            ?>
                            <input name = "fecha_de_inicio" type = "date" id = "fecha_de_inicio">
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <label>
                            Ejecutivo de Ventas
                            <br>
                            <?php   /* Aqui tenemos un select donde se enseña la lista de Ejecutivas de Ventas habilitadas para un programa:

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).

                                    Tiene 6 opciones: Campo Vacío, Carolina Ovando, Consuelo Galán, Fallon Gonzalez, Marisol Castro y Nataly Hormazabal.
                                        
                                    De estas 6 opciones solo 5 serán elegibles, que son todas menos el campo vacío.

                                    El campo vacío lo utilizamos para que no se enseñe por default la primera opción, que sería la Carolina Ovando.

                                    Como son unos pocos, se utilizó un select en vez de una llamada a una query.
                                    */
                            ?>
                            <select name = "ejecutivo_ventas_id" id = "ejecutivo_ventas_id">
                                <option value = "" selected = "true" disable = "disable" hidden></option>
                                <option value = "covando" id="covando">
                                    Carolina Ovando
                                </option>
                                <option value = "cgalan" id ="cgalan">
                                    Consuelo Galán
                                </option>
                                <option value = "fgonzalez" id ="fgonzalez">
                                    Fallon Gonzalez
                                </option>
                                <option value = "mcastro" id="mcastro">
                                    Marisol Castro
                                </option>
                                <option value = "nhormazabal" id ="nhormazabal">
                                    Nataly Hormazabal
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col" id = "hide-version">
                    <div class="">
                        <label >
                            Version
                            <?php   /*Este es un select de la versión, el cual funciona de la sig manera:
                                    Si queremos crear un programa de 0, por default tendrá la versión 1 seleccionada, que además, no estará 
                                    visible para el usuario(el campo completo).
                                    
                                    Si se quiere crear un programa en base a uno ya creado entonces se van a agregar una lista de versiones
                                    si es que se coincide con una de ellas(del estilo V# ; #:Número de la versión) entonces al cargar un programa
                                    quedará seleccionada dicha versión.

                                    Id: samos el id para identificar y llamar a un input cuando se desea cambiar su value
                                        o para verificar algún atributo del input.
                                    Name : Lo usamos para cuando debemos validar el envío de los datos(usando isset(name)).
                                    Onchange: Lo utilizamos para cuando exista un cambio enste campo, se adaptará el código del diploma.

                                    OnChange no se aplicará al momento de cargar un programa y se fije un valor en el campo, esto para evitar la 
                                    generación de codigos erroneos.
                                    */
                            ?>
                            <select id = "version" name ="version" onchange = 'changeCodDiploma()'>
                            <option value = "V1" selected = "true" disable = "disable" hidden></option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="p-4">
                        <?php /* Este select siempre se va a mantener escondido del usuario, su función es capturar el estado del formulario, es decir,
                                si estamos creando un progama de 0 entonces se va a dejar seleccionada la opción buscar_create en create_program_0.php dicha opción, pero
                                si estamos buscando un programa con este formulario, se va a seleccionar la opción buscar_edit en create_program_1.php.
                                
                                Esto nos sirve para saber en otros archivos que es lo que estamos haciendo, para discriminar como procesar los datos.*/?>
                        <select name = "buscar_edit/create_program" id = "buscar_edit/create_program" autocomplete = 'off' hidden>
                                <option value = "buscar_edit" id= "buscar_edit" disable = "disable" hidden></option>
                                <option value = "buscar_create" id = "buscar_create" disable = "disable" hidden></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="container text-center">
            <div class="row row-cols-4 row-cols-lg-4 g-lg-3">
                <?php /* En esta sección se pueden ver 2 div con id's submit_form_button y submit_form_button_2, dichos div se usan para
                        Asignar en el mismo espacio botones diferentes según nuestro proposito.
                        Para crear un programa desde 0 se crea y agrega un boton diferente para cuando queremos buscar un programa distinto.
                        */?>
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
            </div>
        </div>
    </form>
</div>
<script>
    //Este script es el que siempre se ejecuta cuando se usa este archivo
    //primero capturamos todo el campo de version, y lo escondemos y dejamos disable.
    var version = document.getElementById('hide-version');
    version.setAttribute("hidden","true");
    version.setAttribute("disable", "disable");

    //Si es que en el campo de tipo producto ocurrió un cambio de opción entonces se ejecuta esta función
    document.getElementById('tipo_producto').addEventListener('change', function(){

        //obtenemos el nuevo valor del tipo de producto
        var tipo_producto = this.value;

        //obtenemos la checkbox que representa que un programa sea curso conducente
        var curso_conducente = document.getElementById('curso_conducente');

        //si es que el cambio ocurrió y el tipo de producto fijado es un Curso, entonces se enseñará la checkbox de Curso Conducente
        //esto ocurre principalmente cuando se quiere crear un programa desde 0 , cuando se usa para buscar un programa o cuando se use
        //este formulario para crear un programa usando datos de uno existente y el tipo de producto sea un curso.
        if(tipo_producto == "Curso"){
            curso_conducente.removeAttribute('disable');
            curso_conducente.removeAttribute('hidden');
        }
    })

    //Si es que se cambia el periodo entonces se ejecuta esta función, que tiene como objetivo poder restringir las fechas de inicio según el periodo.
    document.getElementById('periodo').addEventListener('change', function() {

        //obtenemos el periodo selecciondo, el input o elemento de la fecha de inicio.
        var periodo = this.value;
        var fechaInicio = document.getElementById('fecha_de_inicio');

        //Aqui recorremos los posibles peridoso y fijamos las fechas minimas y maximas que contempla dicho periodo, aquí es donde se puede
        //MODIFICAR LAS FECHAS PARA LOS SEMESTRES, ESTOS VALORES SON PRELIMINARES.
        //si es el primer semestre de 2022, entonces, la fecha minima será 2022-01-01 y la maxima 30-06-2022
        if (periodo === '2022S1') {
            fechaInicio.setAttribute('min', '2022-01-01');
            fechaInicio.setAttribute('max', '2022-06-30');
        } //si es el segundo semestre de 2022, entonces, la fecha minima será 2022-07-01 y la maxima 31-12-2022
        else if (periodo === '2022S2') {
            fechaInicio.setAttribute('min', '2022-07-01');
            fechaInicio.setAttribute('max', '2022-12-31');
        } 
        //lo mismo con los demás periodos.
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

        //Si primero se escoge una fecha de inicio y luego un periodo ocurrirá lo que viene a continuación.
        //Si es que la fecha de inicio escogida por el usuario es menor igual a la fecha minima del periodo escogido por el usuario entonces,
        //la fecha de inicio tendra el valor de la fecha minima de dicho periodo
        if (new Date(fechaInicio.value) <= new Date(fechaInicio.min)) {
            fechaInicio.value = fechaInicio.min;
        } //Si en cambio la fecha de inicio es mayor igual a la fecha maima del periodo, la fecha de inicio tendra el valor de la fecha maxima
            //de dicho periodo.
        else if (new Date(fechaInicio.value) >= new Date(fechaInicio.max)) {
            fechaInicio.value = fechaInicio.max;
        }
    });

    //Si es que se cambia la fecha de inicio entonces se ejecuta esta función
    document.getElementById('fecha_de_inicio').addEventListener('change', function() {
        //obtenemos la fecha seleccionada por el usuario, la fecha minima y maxima fijada en la función anterior.
        var fechaSeleccionada = new Date(this.value);
        var fechaMin = new Date(this.min);
        var fechaMax = new Date(this.max);

        //si es que el usuario puso primero el periodo y luego la fecha de inicio entonces se aplicará esto de aqui
        //si la fecha seleccionada es menor igual a la minima, deja la fecha minima como fecha de inicio
        if (fechaSeleccionada <= fechaMin) {
            this.value = this.min;
        } //si la fecha seleccionada es mayor igual a la maxima, deja la fecha maxima como fecha de inicio.
        else if (fechaSeleccionada >= fechaMax) {
            this.value = this.max;
        }
    });
</script>
<?php
//Esta sección es para cuando ya se selecciono un programa para crear uno usando sus datos
//Nos aseguramos de que la variable global este definida, de ser así obtenemos su valor
if(isset($_SESSION['can_load'])){
    $getted_program = $_SESSION['can_load'];

    //nos aseguramos de que se haya seleccionado un programa y que se haya enviado a este formulario, si es así entonces:
    if(isset($_POST['programaSeleccionado'])){

        //si entramos aqui entonces sabemos que obtenimos un programa, y deseamos cargar los datos en los distintos campos
        $getted_program = true;
        if($getted_program){

            //obtenemos la data de un programa ya existente seleccionado por el usuario, la data viene con sus datos separados por "|"
            //por lo tanto debemos crear el array data haciendo un explode a la cadena obtenida.
            $data = $_POST['programaSeleccionado'];
            $array_data = explode("|", $data);
            ?>
            <script>
                //obtendremos los datos que necesitamos según el orden fijado, dicho orden esta en el archivo functions_program.php en la función
                //get_program
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
                var ejecutivo_ventas_id = '<?php echo $array_data[21];?>';
                var tipo = '<?php echo $array_data[22];?>';
                var cod_diploma = '<?php echo $array_data[23];?>';

                //luego de obtener los datos, debemos procesarlos, aqui obtenemos el nombre del programa de la sig manera: Nombre - Cod_Programa
                //Por lo cual obtenemos solo el Nombre en esta sección.
                var new_nom_diploma = "";
                for(var i = 0; i<nom_diploma.length ; i++){
                    if(nom_diploma[i] == ' ' && nom_diploma[i+1] == '-'){
                        break;
                    } else{
                        new_nom_diploma = new_nom_diploma + nom_diploma[i];
                    }
                }

                //Obtenemos el input en donde va el nombre del programa y el nombre obtenido anteriormente lo dejamos como su nuevo valor.
                var nombre_program = document.getElementById('nombre_program');
                nombre_program.value = new_nom_diploma;

                //Para el tipo de programa discriminamos que sea una de las opciones dentro del formulario
                if(tipo_programa == "Diploma" || tipo_programa == "Diploma Postitulo" || tipo_programa == "Curso"){
                        //obtenemos la opcion que sea el tipo de producto obtenida de los datos y la dejamos seleccionada
                        var tipo_producto = document.getElementById(tipo_programa);
                        tipo_producto.setAttribute("selected","true");

                        //si el tipo de producto es un Curso
                        if(tipo_programa == 'Curso'){
                            //Obtenemos la seccion de curso conducente(checkbox) y la hacemos visible al usuario
                            var conducente = document.getElementById('curso_conducente');
                            conducente.removeAttribute('hidden');
                            conducente.removeAttribute('disable');

                            //Si además el tipo, que es diferente al tipo de producto dice Curso Conducente, entonces la checkbox quedará con un ticket.
                            if(tipo == "Curso Conducente"){
                            var conducente_box = document.getElementById('curso_conducente_box');
                            conducente_box.setAttribute('checked', 'true');
                            }
                        }
                }

                //Si el area de conocimiento es una de las opciones del formulario entonces obtenemos la opción y la dejamos seleccionada
                if(area_conocimiento == "Innovación y Emprendimiento" || area_conocimiento == "Finanzas e Inversiones" || area_conocimiento == "Marketing y Ventas" || area_conocimiento == "Estrategia y Gestión" ||
                area_conocimiento == "Personas y Equipos" || area_conocimiento == "Operaciones y Logística" || area_conocimiento == "Dirección de Instituciones de Salud"){
                    var area_val = document.getElementById(area_conocimiento);
                    area_val.setAttribute("selected", "true");
                } //Si no es una de las opciones hay variantes de la misma, la cual se ven caso a caso, se documentará una pero ahi estan las demas. 
                else{
                    //Si el area de conocimiento es Finanzas entonces deja seleccionada la opción Finanzas e Inveriones.
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
                    }
                    //Si es que es un caso especial y no es una de ellas
                    else{  
                        //obtenemos la opción otro del select, la dejamos seleccionada y fijamos su atributo como el area de conocimiento obtenida
                        //eso se hace para que el usuario pueda visualizar que area es la original del programa usado para crear uno nuevo y así
                        //se pueda discriminar cual de las opciones disponibles es la que debe escoger.
                        var area_val = document.getElementById('otro');
                        area_val.setAttribute("selected","true");
                        area_val.value = area_conocimiento;
                        area_val.removeAttribute("disable");
                        area_val.removeAttribute("hidden");
                    }
                }

                //Si la modalidad es una de las opciones del formulario esta queda seleccionada
                if(modalidad_programa == "Presencial" || modalidad_programa == "B-Learning" || modalidad_programa == "E-Learning" || modalidad_programa == "Virtual" ||
                    modalidad_programa == "Mixto" || modalidad_programa == "Híbrido"){
                        var modalidad = document.getElementById(modalidad_programa);
                        modalidad.setAttribute("selected", "true");
                } else{
                    //De no ser así solo si es que es B-Learing la opcion B-Learning queda seleccionada dentro del formulario.
                    if(modalidad_programa == "B-Learing"){
                        var modalidad = document.getElementById('B-Learning');
                        modalidad.setAttribute("selected", "true");
                    }

                }

                //Si el periodo es uno de las opciones del campo entonces lo dejamos seleccionado
                //Además obtnemos la fecha de inicio y tambien la dejamos con el valor obtenido de los datos.
                if(periodo == '2022S1' || periodo == '2022S2' || periodo == '2023S1' || periodo == '2023S2' || periodo =='2024S1' ||
                    periodo == '2024S2'){
                        var periodo_select = document.getElementById(periodo);
                        periodo_select.setAttribute("selected", "true");
                        var fecha_inicio = document.getElementById('fecha_de_inicio');
                        fecha_inicio.value = fecha_de_inicio;
                }
                
                //Si la realizacion es una de las opciones del formulario esta queda seleccionada
                if(realizacion_en == "FEN" || realizacion_en == "FUERA" || realizacion_en == "INTERNACIONAL" || realizacion_en == "Oriente"){
                    var realizacion = document.getElementById(realizacion_en);
                    realizacion.setAttribute("selected", "true");
                }
                
                //Si el nivel es una de las opciones del formulario esta queda seleccionada
                if(nivel == 'Inicial' || nivel == 'Intermedio' || nivel == 'Avanzado' || nivel == 'Experto'){
                    var nivel_val = document.getElementById(nivel);
                    nivel_val.setAttribute("selected", "true");
                }

                //Si el horario es una de las opciones del formulario esta queda seleccionada
                if(horario == 'AM' || horario == 'PM' || horario == 'WK' || horario == 'TD'){
                    var horario_val = document.getElementById(horario);
                    horario_val.setAttribute("selected", "true");
                }
                
                //Para la versión generamos algunas opciones en esta lista
                var version_option = ['V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'V7', 'V8', 'V9'];

                //obtenemos la sección completa de la verisón y la hacemos visible al usuario
                var show_version = document.getElementById('hide-version')
                show_version.removeAttribute("hidden");
                show_version.removeAttribute("disable");
                
                //obtenemos el select o elemento que fija la version
                var version_select = document.getElementById('version');
                
                //recorremos las opciones creadas para poder agregarlas al select de versiones
                for (var i = 0; i < version_option.length; i++){
                    var opcion = document.createElement("option");
                    opcion.setAttribute("id", version_option[i]);
                    opcion.value = version_option[i];
                    opcion.text = version_option[i];
                    version_select.appendChild(opcion);
                }   

                //si es que la version recibida es una de las versiones de la lista creada, entonces fija esa version como la seleccionada 
                //en el formulario.
                if(version_option.includes(version)){
                    var this_version = document.getElementById(version);
                    this_version.setAttribute('selected', 'true');
                }
                
                //Si es que el usr de ejecutivo de ventas obtenido es una de las opciones entonces se fija ese usuario como la seleccionada.
                if(ejecutivo_ventas_id == 'covando' || ejecutivo_ventas_id == 'fgonzalez' ||
                    ejecutivo_ventas_id == 'nhormazabal' || ejecutivo_ventas_id == 'cgalan' || ejecutivo_ventas_id == 'mcastro'){
                        var ejecutivo_ventas_select = document.getElementById(ejecutivo_ventas_id);
                        ejecutivo_ventas_select.setAttribute('selected', 'true');
                    }
                
                //Se obtiene el input del codigo del diploma, se fija en solo lectura y se pone el valor obtenido para que el usuario lo pueda visualizar.
                input_cod_diploma =document.getElementById('cod_diploma');
                input_cod_diploma.readonly = true;
                input_cod_diploma.value =cod_diploma;
            </script>
            <?php
        }

        ?>
        <script>
            //Esta función se encarga de cambiar el codigo del diploma
            //Esto ocurre cuando se modifica: el nombre del programa, tipo programa, periodo, versión, jornada/horario.
            function changeCodDiploma(){
                //obtenemos el input del codigo del diploma
                var input_cod_diploma =document.getElementById('cod_diploma');

                //obtenemos todos los valores necesarios para crear el nuevo codigo del diploma.
                var nombre_program = document.getElementById('nombre_program').value;
                var periodo =document.getElementById('periodo').value;
                var jornada =document.getElementById('horario').value;
                var version = document.getElementById('version').value;
                var tipo =document.getElementById('tipo_producto').value;

                //para esto debemos comparar el nombre antiguo,siglas antiguas obtenidas por el programa seleccionado.
                var old_nom_diploma = "";
                var old_siglas = '';

                //obtenemos el tipo programa del programa seleccionado
                var old_tipo = '<?php echo $array_data[1];?>';

                //si es que hhabiamos obtenido un programa entonces 
                var getted_program = <?php echo $getted_program?>;
                if(getted_program){
                    //debemos obtener le nombre - codigo y debemos solo obtener el nombre nuevamente
                    var nom_diploma = '<?php echo $array_data[0];?>';

                    //obtenemos las siglas que tenia el programa al ser seleccionado
                    old_siglas = '<?php echo $array_data[10];?>';

                    for(var i = 0; i<nom_diploma.length ; i++){
                        if(nom_diploma[i] == ' ' && nom_diploma[i+1] == '-'){
                            break;
                        } else{
                            //en old_nom_diploma se guarda el nombre antiguo del programa
                            old_nom_diploma = old_nom_diploma + nom_diploma[i];
                        }
                    }
                }

                //debemos enviar de forma asincronica los datos para que sean procesados para generar el nuevo codigo del programa
                var xhttp = new XMLHttpRequest();

                //se envian como tipo get al archivo procesar_data.php, se envia solo una variable
                //la variable se llama: input_cod_diploma
                //el contenido de la variable se ve como el "old_nom_diploma,nombre_program,..."

                xhttp.open('GET', 'procesar_data.php?input_cod_diploma='+ old_nom_diploma+','+nombre_program+','+periodo+','+jornada+','+version+','+old_siglas+','+tipo+','+old_tipo, true);
                xhttp.send();
                
                //esperando un echo como respuesta
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        //Obtenemos la respuesta que va a ser el nuevo codigo y lo dejamos como el nuevo codigo en el input que obtuvimos anteriormente.
                        var respuesta = this.responseText;
                        input_cod_diploma.value = respuesta;
                    }
                };
            }
        </script>
        <?php
    } 
}
?>
