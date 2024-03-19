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
                    <form action = "create_program_0.php" name="frm_periodo" id="frm_periodo" method="POST">
                        <input type="hidden" id="programaSeleccionado" name="programaSeleccionado" value="">
                        <div class ="margin-left">
                            <button value="Enviar" onclick = "select_program()">
                                Seleccionar
                            </button>
                        </div>
                    </form>
                    <script>
                        <?php 
                            echo "creando rimas";
                            if(!$create){
                                echo $create;
                                ?>
                                var frm_periodo = document.getElementById('frm_periodo');
                                frm_periodo.removeAttribute('action');
                                frm_periodo.setAttribute('action', 'edit_program_0.php');   
                                <?php
                            }
                        ?>
                        function select_program() {
                            var radioButtons = document.getElementsByName('programa_seleccionado');
                            var info = '';
                            for (var i = 0; i < radioButtons.length; i++) {
                                if (radioButtons[i].checked) {
                                    info = i;
                                    break;
                                }
                            }

                            var data = '<?php echo $programas_encontrados;?>';
                            var value = data[info];

                            var formulario = document.getElementById('frm_periodo');
                            var programa_selected = document.getElementById('programaSeleccionado');

                            programa_selected.value = value;
                            formulario.submit();
                        }
                    </script>
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
echo '<pre>'.print_r($programas_encontrados[1], true).'</pre>';
?>