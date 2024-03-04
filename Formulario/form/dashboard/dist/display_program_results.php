<?php
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
                                <th>TIPO</th>
                                <th>HORARIO</th>
                                <th>NIVEL</th>
                                <th>REALIZACION</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class ="text-center">
                                <th>SELECCIONAR</th>
                                <th>NOMBRE</th>
                                <th>CODIGO DIPLOMA</th>
                                <th>TIPO PROGRAMA</th>
                                <th>AREA</th>
                                <th>TIPO</th>
                                <th>HORARIO</th>
                                <th>NIVEL</th>
                                <th>REALIZACION</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach($programas_encontrados[1] as $programa) {
                            ?>
                                <tr>
                                    <td class ="text-center"><input type='radio' name="programa_seleccionado"></td>
                                    <td class = ""> <?php echo $programa['DIPLOMADO'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Codigo Diploma'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Tipo Programa'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Area Conocimiento'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Tipo'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Horario'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Nivel'];?></td>
                                    <td class ="text-center"> <?php echo $programa['Realización'];?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <form action="create_program_0.php" name="frm_periodo" id="frm_periodo" method="POST">
                        <input type="hidden" id="programaSeleccionado" name="programaSeleccionado" value="">
                        <div class ="margin-left">
                            <button value="Enviar" onclick = "select_program()">
                                Enviar
                            </button>
                        </div>
                    </form>
                    <script>
                        function select_program() {
                            var radioButtons = document.getElementsByName('programa_seleccionado');
                            var info = '';
                            for (var i = 0; i < radioButtons.length; i++) {
                                if (radioButtons[i].checked) {
                                    info = i;
                                    break;
                                }
                            }
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'get_implode_result.php'); // Archivo PHP que realiza el implode
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    var result = xhr.responseText;
                                    var programaSeleccionadoInput = document.getElementById('programaSeleccionado');
                                    programaSeleccionadoInput.value = result; // Establecer el valor obtenido en el input
                                    document.getElementById('frm_periodo').submit();
                                }
                            };
                            xhr.send('info=' + info); // Enviar el valor al servidor
                        }
                    </script>
                </div>
            </div>
        </div>
</body>