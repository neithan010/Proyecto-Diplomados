
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="encargados_title" style ="margin-left: 20px;">
        <h4>
            Encargados
        </h4>
</div>
<hr>    
<br>
<div id = "encargados-3" name = "encargados-3">
    <div class = "container">
        <div class = "row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class = "col">
                <div id = "coordinador_ejecutivo_t" name = "coordinador_ejecutivo_t">
                    <label>
                        <?php
                            #Sección que representa a un Coordinador Ejecutivo
                            #Tiene como input el nombre, ususario, telefono y email, que son las necesarias en un programa
                            #El usuario del coordinador ejecutivo es un campo escondido que se llena sin que el usuario se de cuenta de ello

                            #El email está restringido a correos @unegocios.cl y @hotmail.com, pueden agregarse más

                            #Tiene un boton para buscar coordinadores ejecutivos, que al hacer click se ejecuta una función(display_search_ejecutivo)
                        ?>
                        <div class = 'text-center'>
                            Coordinador Ejecutivo
                        </div>
                        <label>
                            Nombre
                            <input id = 'nombre_cordinador_ejecutivo' name = 'nombre_cordinador_ejecutivo' type = 'text' maxlength = '100'>
                            <input id = 'usr_cordinador_ejecutivo' name = 'usr_cordinador_ejecutivo' type = 'text' maxlength = '100' hidden>
                            <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("coordinador ejecutivo")'>
                        </label>
                        <label>
                            Telefono
                            <input id = 'telefono_cordinador_ejecutivo' name = 'telefono_cordinador_ejecutivo' type = 'tel' maxlength = '15'>
                        </label>
                        <label>
                            E-mail
                            <input  id = 'email_cordinador_ejecutivo' name = 'email_cordinador_ejecutivo' type = 'email' 
                            pattern=".+@unegocios\.cl|.+@hotmail\.com |.+@fen.uchile.cl" maxlength="100" placeholder = 'example@unegocios.cl'>
                        </label>
                    </label>
                    <script>
                        //asignamos los valores obtenidos de seleccionar un programa sobre un coordinador ejecutivo
                        var nombre_cordinador_ejecutivo = '<?php echo $data[45];?>';
                        var telefono_cordinador_ejecutivo = '<?php echo $data[46];?>';
                        var email_cordinador_ejecutivo = '<?php echo $data[14];?>';

                        document.getElementById('nombre_cordinador_ejecutivo').value = nombre_cordinador_ejecutivo;
                        document.getElementById('telefono_cordinador_ejecutivo').value = telefono_cordinador_ejecutivo;
                        document.getElementById('email_cordinador_ejecutivo').value = email_cordinador_ejecutivo;
                    </script>
                </div>
            </div>
            <div class = "col">
                <div id = "director_academico_t" name = "director_academico_t">
                    <label>
                        <?php
                            #Sección que representa a un Director Academico
                            #Tiene como input el nombre, id y email, que son las necesarias en un programa
                            #El id de un Director Academico es un campo escondido que se llena sin que el usuario se de cuenta de ello

                            #Tiene un boton para buscar un director academico, que al hacer click se ejecuta una función(display_search_ejecutivo)
                        ?>
                        <div class = 'text-center'>
                            Director Academico
                        </div>
                        <label>
                            Nombre
                            <input id = 'nombre_director_academico' name = 'nombre_director_academico' type = 'text' maxlength = '60'>
                            <input id = 'id_director_academico' name = 'id_director_academico' type = 'text' maxlength = '60' hidden>
                            <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("director academico")'>
                        </label>
                        <label>
                            E-mail
                            <input  id = 'email_director_academico' name = 'email_director_academico' type = 'email' 
                            pattern=".+@unegocios\.cl|.+@hotmail\.com |.+@fen.uchile.cl" maxlength="100" placeholder = 'example@unegocios.cl'>
                        </label>
                    </label>
                    <script>
                        //asignamos los valores obtenidos de seleccionar un programa sobre un director academico
                        var nombre_director_academico = '<?php echo $data[26];?>';
                        var id_director_academico = '<?php echo $data[25];?>';
                        var email_director_academico = '<?php echo $data[27];?>';

                        document.getElementById('nombre_director_academico').value = nombre_director_academico;
                        document.getElementById('email_director_academico').value = email_director_academico;
                        document.getElementById('id_director_academico').value =id_director_academico;
                    </script>   
                </div>
            </div>
            <div class = "col">
                <div id = "coordinador_docente_t" name = "coordinador_docente_t">
                    <label> 
                        <?php
                            #Sección que representa a un Coordinador Docente
                            #Tiene como input el nombre, ususario, telefono y email, que son las necesarias en un programa
                            #El usuario del coordinador docente es un campo escondido que se llena sin que el usuario se de cuenta de ello

                            #El email está restringido a correos @unegocios.cl y @hotmail.com, pueden agregarse más

                            #Tiene un boton para buscar coordinadores docente, que al hacer click se ejecuta una función(display_search_ejecutivo)
                        ?>
                        <div class = 'text-center'>
                            Coordinador Docente
                        </div>
                        <label>
                            Nombre
                            <input id = 'nombre_cordinador_docente' name = 'nombre_cordinador_docente' type = 'text' maxlength = '100'>
                            <input id = 'usr_cordinador_docente' name = 'usr_cordinador_docente' type = 'text' maxlength = '100' hidden>
                            <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("coordinador docente")'>
                        </label>
                        <label>
                            Telefono
                            <input id = 'telefono_cordinador_docente' name = 'telefono_cordinador_docente' type = 'tel' maxlength = '15'>
                        </label>
                        <label>
                            E-mail
                            <input  id = 'email_cordinador_docente' name = 'email_cordinador_docente' type = 'email' 
                            pattern=".+@unegocios\.cl|.+@hotmail\.com |.+@fen.uchile.cl" maxlength="100" placeholder = 'example@unegocios.cl'>
                        </label>
                    </label>
                </div>
                <script>
                    //asignamos los valores obtenidos de seleccionar un programa sobre un coordinador docente
                    var nombre_cordinador_docente = '<?php echo $data[29];?>';
                    var telefono_cordinador_docente = '<?php echo $data[32];?>';
                    var email_cordinador_docente = '<?php echo $data[31];?>';

                    document.getElementById('nombre_cordinador_docente').value = nombre_cordinador_docente;
                    document.getElementById('telefono_cordinador_docente').value = telefono_cordinador_docente;
                    document.getElementById('email_cordinador_docente').value = email_cordinador_docente;
                </script>
            </div>
        </div>
    </div>
    <div class = "row row-cols-2 row-cols-lg-2 g-lg-2">
        <div class = "col">
            <div id = "secretaria_t" name = "secretaria_t">
                <label>
                <?php
                    #Sección que representa a una secretaria
                    #Tiene como input el nombre e id, que son las necesarias en un programa
                    #El id de la secretaria es un campo escondido que se llena sin que el usuario se de cuenta de ello

                    #Tiene un boton para buscar coordinadores ejecutivos, que al hacer click se ejecuta una función(display_search_ejecutivo)
                ?>
                    <div class = 'text-center'>
                        Secretaria
                    </div>
                    <label>
                        Nombre
                        <input id = 'nombre_secretaria' name = 'nombre_secretaria' type = 'text' maxlength = '100'>
                        <input id = 'id_secretaria' name = 'id_secretaria' type = 'text' maxlength = '100' hidden>
                        <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("secretaria")'>
                    </label>
                </label>
                <?php
                    //asignamos los valores obtenidos de seleccionar un programa sobre un coordinador docente, si el nombre de la secretaria no es
                    //vacio se agrega el nombre completo
                    $id = $data[49];
                    $nombre_secretaria='';
                    if($id != ''){
                        $nombre = get_secretaria($id);
                        $nombre_completo = $nombre[0]['Nombre_Secretaria']." ".$nombre[0]['Apellido_Paterno']." ".$nombre[0]['Apellido_Materno'];
                    }
                ?>
                <script>
                    //aqui se asigna el nombre, antes se define para luego capturarlo
                    var nombre_secretaria = '<?php echo $nombre_secretaria?>';
                    document.getElementById('nombre_secretaria').value = nombre_secretaria;
                </script>
            </div>
        </div>
        <div class = "col">
            <div id = "coordinador_comercial_t" name = "coordinador_comercial_t">
                <label>
                    <?php
                        #Sección que representa a un Coordinador Comercial
                        #Tiene como input el nombre y ususario , que son las necesarias en un programa
                        #El usuario del coordinador comercial es un campo escondido que se llena sin que el usuario se de cuenta de ello

                        #Tiene un boton para buscar coordinadores docente, que al hacer click se ejecuta una función(display_search_ejecutivo)
                    ?>
                    <div class = 'text-center'>
                        Coordinador Comercial
                    </div>
                    Nombre
                    <input id = 'nombre_coordinador_comercial' name = 'nombre_coordinador_comercial' type = 'text' maxlength = '100'>
                    <input id = 'usr_coordinador_comercial' name = 'usr_coordinador_comercial' type = 'text' maxlength = '100' hidden>
                    <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("coordinador comercial")'>
                </label>
                <?php 
                    #Se obtiene el usuario y el nombre, si el usuario no es vacio obtenemos el nombre completo
                    $usr_cord_comercial = $data[58];
                    $nombre_cord_comercial = '';
                    if($usr_cord_comercial !=''){
                        $nombre = get_cord_comercial($usr_cord_comercial);
                        $nombre_cord_comercial = $nombre[0]['Nombre_Cord_Comercial'].' '.$nombre[0]['Apellido'];
                    }
                ?>
                <script>
                    //Fijamos el nombre del cordinador comercial
                    var nombre_cord_comercial = '<?php echo $nombre_cord_comercial?>';
                    document.getElementById('nombre_coordinador_comercial').value = nombre_cord_comercial;
                </script>
            </div>
        </div>
    </div>
</div>
<br>
<?php
#Sección que representa el buscador generico de un encargado, todo esto se mantiene escondido hasta que se hace click en el buscador de algún
#encargado, el cual despliega un buscador con los nombres o titulos dependiendo del boton del encargado que se haga click.
#Esta sección tambien se esconde cuando se selecciona un encargado que queremos cambiar luego de buscar y encontrar el que queremos
?>
<div style ="margin-left: 20px;" id = 'buscador_encargados' hidden>
    <h5 id = 'title_buscador'>
    </h5>
    <hr>    
    <br>
    <div id = 'buscador'>
        <div class = 'container'>
            <div class = 'row '>
                <div class = 'col'>
                    <div>
                        Nombre
                    </div>
                    <?php
                        #Creamos un formulario donde se tiene un input para buscar un nombre, un input para el tipo de encargado y un boton
                        #el id lo usamos para encontrar de forma especifica un tipo de coordinador en especifico
                    ?>
                    <form id="search">
                        <input id = 'buscar_name_encargado' name = 'buscar_name_encargado' type = 'text' maxlength = '100'>
                        <input id = 'tipo_encargado' name = 'tipo_encargado' type = 'text' hidden>
                        <button type="button" id='button_buscar_encargados'>
                    </form>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php #Aqui tenemos una tabla donde se enseñaran todos los resultados de utilizar el buscador anterior, esta tabla se mantiene escondida
        #hasta que se busque un nombre, tambien se esconde cuando se vuelve a presioanar algun boton de buscador de algun encargado
    ?>
    <div id = 'table_results' hidden>
        <div class="container-fluid">
            <div class="table-responsive">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Resultados Encontrados
                </div>
                <br>
                <div class ="margin-left">
                    <?php #Aqui esta el boton que se encarga de seleccionar un encargado cuando lo encontramos
                    ?>
                    <form>
                        <button type="button" id = 'select_encargado'>
                            Seleccionar
                        </button>
                    </form>
                </div>
                <?php   #Tabla donde se enseñan los encargados encontrados en un buscador, se tienen 3 columnas con id por que van cambiando
                        #segun el tipo de encargado que se busque, ya que no todos necesitan los mismos datos, por ello el id secretaria permanecerá
                        #oculto hasta que se busque un encargado que sea secretaria.
                        ?>
                <div class="card-body">
                    <table class="table table-bordered small" id="dataTableEncargados" width="100%" cellspacing="0">
                        <thead>
                            <tr class ="text-center">
                                <th>SELECCIONAR</th>
                                <th id = 'id_secretaria_column' hidden>ID</th>
                                <th>NOMBRE</th>
                                <th id = 'telefono_column'>TELEFONO</th>
                                <th id = 'email_column'>EMAIL</th>
                            </tr>
                        </thead>
                        <tbody id = 'tableBody'>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    //Función que se encarga de enconder y resetear el contenido de tablas, buscador, nombre botones, etc
    function hide_search_content(){

        //Obtenemos la sección completa del buscador, el input para buscar con un nombre, el titulo del buscador, el boton para buscar un encargado,
        //la tabla de encargados(el cuerpo) y la tabla completa de encargados.
        var buscador_encargados = document.getElementById('buscador_encargados');
        var input_name = document.getElementById('buscar_name_encargado');
        var title_buscador = document.getElementById('title_buscador');
        var value_button = document.getElementById('button_buscar_encargados');
        var tabla_encargados = document.getElementById('tableBody');
        var contenido_completo = document.getElementById('table_results');

        //Escondemos el buscador completo al igual que la tabla, lo hacemos por separado para que cuando se quiera volver a buscar un encargado
        //al hacer click este vuelva a enseñar solo el buscador, excluyendo la tabla creada que estará vacía.
        buscador_encargados.setAttribute('hidden', 'true');
        contenido_completo.setAttribute('hidden', 'true');

        //Dejamos el contenido y valores de los demás elementos en vacio para volver a agregarlos cuando se quiera volver a agregar un encargado
        title_buscador.textContent = '';
        value_button.value = '';
        input_name.placeholder = '';
        input_name.value = '';
        tabla_encargados.innerHTML = '';
    }

    //funcion que enseña el buscador por nombre de los encargados, si ya se esta enseñando el buscador y/o los resultados, entonces los esconde.
    //esta funcion se aplica cada vez que se haga click en un boton que diga Buscador, normalmente ubicados al lado del nombre de cada encargado.
    function display_search_encargados(tipo){

        //obtenemos el buscador de encargados, el input del nombre, el titulo para el buscador, el boton para buscar y
        //la tabla con los resultados encontrados.
        var buscador_encargados = document.getElementById('buscador_encargados');
        var value_button = document.getElementById('button_buscar_encargados');
        var input_name = document.getElementById('buscar_name_encargado');

        value_button.setAttribute('onclick','showResultsEncargados("' + tipo + '")');
        //si ya estamos viendo el buscador y/o la tabla entonces escondemos el contenido y limpiamos el buscador y la tabla
        if(!buscador_encargados.hasAttribute('hidden')){
            hide_search_content();
        }
        //si no estamos viendo nada, quiere decir que queremos enseñar el buscador de un encargado en especifico
        else{
            //enseñamos el buscador
            buscador_encargados.removeAttribute('hidden');

            //discrimianos para ver que tipo de encargado es el que queremos buscar
            //si es coordinador ejecutivo, se asignan nombres al:
            //titulo del buscador, al nombre del boton y a un placeholder como guia
            if(tipo == 'coordinador ejecutivo'){
                title_buscador.textContent = 'Buscar Coordinador Ejecutivo';
                value_button.textContent = 'Buscar Coord. Ejec.';
                input_name.placeholder = 'Ej: Nombre Apellido';
            } 
            //si es directorr academico repetimos el proceso
            else if(tipo == 'director academico'){
                title_buscador.textContent = 'Buscar Director Academico';
                value_button.textContent = 'Buscar Dir. Acad.';
                input_name.placeholder = 'Ej: Nombre Apellido';
            }
            //si es coordinador docente
            else if(tipo == 'coordinador docente'){
                title_buscador.textContent = 'Buscar Coordinador Docente';
                value_button.textContent = 'Buscar Cord. Doc.';
                input_name.placeholder = 'Ej: Nombre Apellido';
            } else if(tipo == 'secretaria'){
                title_buscador.textContent = 'Buscar Secretaria';
                value_button.textContent = 'Buscar Secretaria';
                input_name.placeholder = 'Ej: Nombre Apellido';
            } else if(tipo == 'coordinador comercial'){
                title_buscador.textContent = 'Buscar Coordinador Comercial';
                value_button.textContent = 'Buscar Cord. Comerc.';
                input_name.placeholder = 'Ej: Nombre Apellido';
            }
        }
    }

    //esta función se encarga de llamar a los resultados según el nombre apellido que se haya ingresado
    //dicha funcion se aplica al presionar el boton que diga Buscar X, donde X son los distintos tipos de encargados
    //este boton es el que está en el buscador.
    function showResultsEncargados(tipo){
        //Obtenemos el input y si es que el valor no es vacio
        var inputName = document.getElementById('buscar_name_encargado');

        if(inputName.value != ''){  
            //Hacemos un envio AJAX para procesar el input ingresado por el usuario para encontrar a todos los encargados según el nombre
            var xhttp = new XMLHttpRequest();

            //Se envia como get a procesar_data como input_value, le enviamos el tipo y el nombre a buscar para saber donde buscar.
            xhttp.open('GET', 'procesar_data.php?input_value='+ tipo+','+inputName.value, true);
            xhttp.send();
            
            //Esperando una respuesta de procesar_data.php
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Aquí  se recibe la respuesta o echo del otro archivo
                    var respuesta = this.responseText;

                    //Hacemos un parse par
                    respuesta = JSON.parse(respuesta);

                    //Llamamos a esta función que enseña los resultados en la tabla creada usando el tipo y el array.
                    display_results_encargados(tipo, respuesta);
                }
            };
        }
    }
    
    //Función que se encarga de enseñar el resultado de los encargados encontrados segun su tipo
    function display_results_encargados(tipo, data_encargados) {

        //Ahora el boton para seleccionar una de las filas que hay como opciones de los encargados
        //tendrá una función asociada cuando se le haga click.
        var select =document.getElementById('select_encargado');
        select.setAttribute('onclick', 'change_input("' + tipo + '")');

        //obtenemos la tabla completa y el cuerpo de la tabla, el cuerpo nos aseguramos de que esté vacio
        var tableResults =document.getElementById('table_results');
        var tabla_encargados = document.getElementById('tableBody');
        tabla_encargados.innerHTML = '';

        //recorremos todos los tipos de encargados
        //segun el tipo seran las columnas que usaremos para agregar los datos
        if(tipo == 'secretaria'){

            //obtenemos las columnas necesarias, ya sea para agregar el dato o por que se deban esconder.
            var id_secretaria_column =document.getElementById('id_secretaria_column');
            var telefono_column = document.getElementById('telefono_column');
            var email_column = document.getElementById('email_column');

            //enseñamos la columna id secretaria, y escondemos telefono y email que no los usa
            id_secretaria_column.removeAttribute('hidden');
            telefono_column.setAttribute('hidden', 'true');
            email_column.setAttribute('hidden', 'true');
            
            //recorremos todo el array de encargados encontrados
            data_encargados.forEach(function(encargado){
                //generamos una nueva fila y centramos el texto
                var newRow = tabla_encargados.insertRow(-1);
                newRow.classList.add('text-center');

                // Crear celdas en la fila y asignar los valores de los encargados
                var cellSeleccionar = newRow.insertCell(0);
                var cellID = newRow.insertCell(1);
                var cellNombre = newRow.insertCell(2);

                // Agregar los datos de los encargados a las celdas
                cellSeleccionar.innerHTML = '<input type="radio" name="programa_seleccionado">';
                cellID.innerHTML = encargado.ID;
                cellNombre.innerHTML = encargado.Nombre+' '+encargado.Apellido;
            });

            //repetimos para director academico
        } else if(tipo == 'director academico'){
            //enseñamos al usuario la columna id secretaira y escondemos la columna telefono
            var id_secretaria_column =document.getElementById('id_secretaria_column');
            var telefono_column = document.getElementById('telefono_column');

            id_secretaria_column.removeAttribute('hidden');
            telefono_column.setAttribute('hidden', 'true');

            data_encargados.forEach(function(encargado){
                //creamos la fila y las distintas celdas
                var newRow = tabla_encargados.insertRow(-1);
                newRow.classList.add('text-center');

                // Crear celdas en la fila y asignar los valores de los encargados
                var cellSeleccionar = newRow.insertCell(0);
                var cellID = newRow.insertCell(1);
                var cellNombre = newRow.insertCell(2);
                var cellEmail = newRow.insertCell(3);

                // Agregar los datos de los encargados a las celdas
                cellSeleccionar.innerHTML = '<input type="radio" name="programa_seleccionado">';
                cellID.innerHTML = encargado.ID;
                cellNombre.innerHTML = encargado.Nombre;
                cellEmail.innerHTML = encargado.Email;
            });

            //Repetimos con cordinador comercial
        } else if(tipo == 'coordinador comercial'){
            //escondemos telefono y email
            var telefono_column = document.getElementById('telefono_column');
            var email_column =document.getElementById('email_column');

            telefono_column.setAttribute('hidden', 'true');
            email_column.setAttribute('hidden', 'true');

            data_encargados.forEach(function(encargado){
                //creamos una fila para los datos necesarios de dicho encargado
                var newRow = tabla_encargados.insertRow(-1);
                newRow.classList.add('text-center');
                // Crear celdas en la fila y asignar los valores de los encargados
                var cellSeleccionar = newRow.insertCell(0);
                var cellNombre = newRow.insertCell(1);
                var cellusr = newRow.insertCell(2);

                //escondemos el usuario del cordinador comercial para el usuario en pantalla, pero sabemos que
                //aun existe ese campo.
                cellusr.setAttribute('hidden', 'true');
                cellusr.innerHTML = encargado.Usr;

                // Agregar los datos de los encargados a las celdas
                cellSeleccionar.innerHTML = '<input type="radio" name="programa_seleccionado">';
                cellNombre.innerHTML = encargado.Nombre;
            });
        }
        else{
            //Este else representa todos los casos que no son especiales y que pueden usar la tabla creada
            //tal cual está
            //nos aseguramos de esconder el id secretaria y de enseñar telefono y email, que son las columnas que
            //se esconden en los casos anteriores
            var id_secretaria_column =document.getElementById('id_secretaria_column');
            var telefono_column = document.getElementById('telefono_column');
            var email_column = document.getElementById('email_column');

            id_secretaria_column.setAttribute('hidden', 'true');
            telefono_column.removeAttribute('hidden');
            email_column.removeAttribute('hidden');

            //recorremos los datos
            data_encargados.forEach(function(encargado) {
                //por cada fila creamos una fila
                var newRow = tabla_encargados.insertRow(-1);
                newRow.classList.add('text-center');

                //Creamos las columnas para dicha fila
                // Crear celdas en la fila y asignar los valores de los encargados
                var cellSeleccionar = newRow.insertCell(0);
                var cellNombre = newRow.insertCell(1);
                var cellTelefono = newRow.insertCell(2);
                var cellEmail = newRow.insertCell(3);

                //Como son otros cordinadores hay un caso, es que ambos cordinadores tambien reciben un id
                //esto se hizo asi para poder extenderse a otros tipos de encargados en el futuro
                //si son estos tipos entonces creamos tambien eul usuario pero lo dejamos escondido al ususario en pantalla.
                if(tipo == 'coordinador docente' || tipo == 'coordinador ejecutivo'){
                    var cellusr = newRow.insertCell(4);
                    cellusr.setAttribute('hidden', 'true');

                    cellusr.innerHTML = encargado.Usr;
                }

                // Agregar los datos de los encargados a las celdas
                cellSeleccionar.innerHTML = '<input type="radio" name="programa_seleccionado">';
                cellNombre.innerHTML = encargado.Nombre;
                cellTelefono.innerHTML = encargado.Telefono;
                cellEmail.innerHTML = encargado.Email;
            });
        }

        //si la tabla esta escondida entonces la enseñamos, esto es un metodo de precaución solamente.
        if(tableResults.hasAttribute('hidden')){
            tableResults.removeAttribute('hidden');
        }
    }
    
    //esta función es la encargada de luego de seleccionar una fila de la tabla(es decir los resultados encontrados)
    //se cambie los datos existentes del formulario por los nuevos seleccionados, dependiendo del encargado es que datos se cambiarán.
    //es decir, cuando un usuario escoge un encargado de la tabla y le hace click al boton seleccionar dejara los datos de dicho encargado como
    //los nuevos datos de dicho encargado en el formulario donde se esta editando.
    function change_input(tipo){

        //obtenemos todos los botones radiales de cada fila en la tabla, como tambien el id de la tabla
        var radioButtons = document.getElementsByName('programa_seleccionado');
        var table = document.getElementById('dataTableEncargados');
        var buscador_encargados = document.getElementById('buscador_encargados');
        //id donde tenemos la fila seleccionada
        var info = '';

        //hacemos un for para encontrar el id o fila que se haya seleccionado.
        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                info = i;
                break;
            }
        }

        //segun el tipo de encargado es que dato vamos a buscar y agregar en nuestros datos a editar
        if(tipo == 'coordinador ejecutivo'){
            //obtenemos nombre, telefono y email del coordinador ejecutivo
            var nombre_completo = table.rows[info+1].cells[1].innerHTML;
            var telefono = table.rows[info+1].cells[2].innerHTML;
            var email = table.rows[info+1].cells[3].innerHTML;
            var usr = table.rows[info+1].cells[4].innerHTML;

            //obtenemos los input's donde van el nombre, telefono y email del coordinador ejecutivo.
            var nombre_cord_ejecutivo = document.getElementById('nombre_cordinador_ejecutivo');
            var telefono_cord_ejecutivo = document.getElementById('telefono_cordinador_ejecutivo');
            var email_cord_ejecutivo = document.getElementById('email_cordinador_ejecutivo');
            var usr_cordinador_ejecutivo =document.getElementById('usr_cordinador_ejecutivo');

            //les asignamos los nuevos valores seleccionados o mejor dicho el personal que tendrá dicho cargo.
            nombre_cord_ejecutivo.value = nombre_completo;
            telefono_cord_ejecutivo.value = telefono;
            email_cord_ejecutivo.value = email;
            usr_cordinador_ejecutivo.value = usr;

        } else if(tipo == 'director academico'){
            //obtenemos nombre, telefono y email del coordinador ejecutivo
            var nombre_completo = table.rows[info+1].cells[2].innerHTML;
            var email = table.rows[info+1].cells[3].innerHTML;
            var id = table.rows[info+1].cells[1].innerHTML;

            var nombre_director_academico = document.getElementById('nombre_director_academico');
            var email_director_academico = document.getElementById('email_director_academico');
            var id_director_academico =document.getElementById('id_director_academico');

            nombre_director_academico.value = nombre_completo;
            email_director_academico.value = email;
            id_director_academico.value = id;

        } else if(tipo == 'coordinador docente'){

            //obtenemos nombre, telefono y email del coordinador ejecutivo
            var nombre_completo = table.rows[info+1].cells[1].innerHTML;
            var telefono = table.rows[info+1].cells[2].innerHTML;
            var email = table.rows[info+1].cells[3].innerHTML;
            var usr = table.rows[info+1].cells[4].innerHTML;

            //obtenemos los input's donde van el nombre, telefono y email del coordinador ejecutivo.
            var nombre_cord_docente = document.getElementById('nombre_cordinador_docente');
            var telefono_cord_docente = document.getElementById('telefono_cordinador_docente');
            var email_cord_docente = document.getElementById('email_cordinador_docente');
            var usr_cordinador_docente =document.getElementById('usr_cordinador_docente');

            //les asignamos los nuevos valores seleccionados o mejor dicho el personal que tendrá dicho cargo.
            nombre_cord_docente.value = nombre_completo;
            telefono_cord_docente.value = telefono;
            email_cord_docente.value = email;
            usr_cordinador_docente.value = usr;

        } else if(tipo == 'secretaria'){
            var nombre_completo = table.rows[info+1].cells[2].innerHTML;
            var id = table.rows[info+1].cells[1].innerHTML;
            
            var nombre_secretaria = document.getElementById('nombre_secretaria');
            var id_secretaria =document.getElementById('id_secretaria');
            
            nombre_secretaria.value = nombre_completo;
            id_secretaria.value = id;

        } else if(tipo == 'coordinador comercial'){
            //obtenemos nombre, telefono y email del coordinador ejecutivo
            var nombre_completo = table.rows[info+1].cells[1].innerHTML;
            var usr = table.rows[info+1].cells[2].innerHTML;

            //obtenemos los input's donde van el nombre, telefono y email del coordinador ejecutivo.
            var usr_cordinador_comercial =document.getElementById('usr_coordinador_comercial');
            var nombre_coordinador_comercial =document.getElementById('nombre_coordinador_comercial');

            //les asignamos los nuevos valores seleccionados o mejor dicho el personal que tendrá dicho cargo.
            usr_cordinador_comercial.value = usr;
            nombre_coordinador_comercial.value =nombre_completo;
        }
        
        //si ya estamos viendo el buscador y/o la tabla entonces escondemos el contenido y limpiamos el buscador y la tabla
        if(!buscador_encargados.hasAttribute('hidden')){
            hide_search_content();
        }
    }
</script>