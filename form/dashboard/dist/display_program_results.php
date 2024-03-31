<?php
#En este punto obtenemos de los datos de la función get_program el 2do elemento, que es el que contiene
#Los resutados de todos los programas encontrados
$_SESSION['programas_encontrados'] = $programas_encontrados[1];
?>
<head>
    <meta charset="UTF-8">
</head>

<body>
    <div class="container-fluid">
            <div class="table-responsive">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Resultados Encontrados
                </div>
                <div class="card-body">
                    <table class="table table-bordered small" id="dataTableprogramas" width="100%" cellspacing="0">
                        <thead>
                            <tr class ="text-center">
                                <th >SELECCIONAR</th>
                                <th>NOMBRE</th>
                                <th>CODIGO DIPLOMA</th>
                                <th>TIPO PROGRAMA</th>
                                <th>AREA</th>
                                <th>MODALIDAD</th>
                                <th>HORARIO</th>
                                <th>NIVEL</th>
                                <th>REALIZACION</th>
                                <th>VERSION</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class ="text-center">
                                <th>SELECCIONAR</th>
                                <th>NOMBRE</th>
                                <th>CODIGO DIPLOMA</th>
                                <th>TIPO PROGRAMA</th>
                                <th>AREA</th>
                                <th>MODALIDAD</th>
                                <th>HORARIO</th>
                                <th>NIVEL</th>
                                <th>REALIZACION</th>
                                <th>VERSION</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            #Aqui recorremos todos los resultados, y les asignamos los valores más importantes haciendo echo
                            foreach($programas_encontrados[1] as $programa) {
                            ?>
                                <tr>
                                    <td class ="text-center"><input type='radio' name="programa_seleccionado"></td>
                                    <td class = ""> <?php echo $programa['DIPLOMADO'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Codigo_Diploma'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Tipo_Programa'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Area_Conocimiento'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Modalidad'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Horario'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Nivel'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Realización'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Version'];?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                        #Generamos un formulario que va dirigido por default a create_program_0.php, a este archivo se puede llegar
                        #por crear o editar un programa, solo tiene un boton Seleccionar que al hacer click se ejecuta una función
                        #de este mismo archivo
                    ?>
                    <form action = "create_program_0.php" name="frm_periodo" id="frm_periodo" method="POST">
                        <input type="hidden" id="programaSeleccionado" name="programaSeleccionado" value="">
                        <div class ="margin-left">
                            <button value="Enviar" onclick = "select_program()">
                                Seleccionar
                            </button>
                        </div>
                        <script>
                            <?php 
                            #Si es que estamos editando entonces la acción del boton pasa a ir a edit_progrma_0.php
                                if(!$create){
                                    ?>
                                    var frm_periodo = document.getElementById('frm_periodo');
                                    frm_periodo.removeAttribute('action');
                                    frm_periodo.setAttribute('action', 'edit_program_0.php');   
                                    <?php
                                }
                            ?>

                            //Esta es la función que se ejecuta cuando se hace click en Seleccionar
                            function select_program() {
                                //La primera columna es un boton para seleccionar una fila, que es la que esocogeremos para editar o crear
                                var radioButtons = document.getElementsByName('programa_seleccionado');
                                var info = '';

                                //Todos los botones tienen el mismo Name, por lo cual, los recorremos para ver cual es el que fue seleccionado
                                //Obtenemos el id para saber que número de fila es.
                                for (var i = 0; i < radioButtons.length; i++) {
                                    if (radioButtons[i].checked) {
                                        info = i;
                                        break;
                                    }
                                }

                                //Obtenemos el id y hacemos una llamada asincronica con AJAX para poder procesar los datos
                                var xhr = new XMLHttpRequest();

                                xhr.open('POST', 'get_implode_result.php'); // Archivo PHP que realiza el implode
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                //Cuando se reciba un echo
                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        //Se obtiene la respuesta, obtenemos la sección donde guardaremos le program sleeccionado
                                        var result = xhr.responseText;
                                        var programaSeleccionadoInput = document.getElementById('programaSeleccionado');

                                        //Fijamos el valor y hacemos el submit
                                        programaSeleccionadoInput.value = result;
                                        document.getElementById('frm_periodo').submit();
                                    }
                                };
                                //Esto se envia antes de procesar onload
                                xhr.send('info=' + info); // Enviar el valor al servidor
                            }
                        </script>
                    </form>
                </div>
            </div>
        </div>
        <script>
            /*    $( document ).ready(function() {
                $('#dataTableprogramas').DataTable({
                language: {
                url: '../../js/es-mx.json'
                }
            });
        });*/
        </script>
</body>
<?php 
?>