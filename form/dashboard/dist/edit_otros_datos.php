<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div style="margin-left: 20px;">
    <h4>
        Otros Datos
    </h4>
</div>
<hr>
<br>
<div id = "otros" name = "otros">
    <div class = "container text-center">
        <div id = "salas" name = "salas">
            <div class = "row row-cols-2 row-cols-lg-2 g-lg-2">
                <div class = "col">
                    <div id = "sala_t" name = "sala_t">
                        <label>
                            Código Sala
                            <br>
                            <input  maxlength = "20" type = "text" id = "cod_sala" name = "cod_sala">
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "sala_coffee_t" name = "sala_coffee_t">
                        <label>
                            Sala Café
                            <br>
                            <input  maxlength = "20" type = "text" id = "sala_cafe" name = "sala_cafe">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id = "addons" name = "addons">
            <div class = "row row-cols-3 row-cols-lg-3 g-lg-3">
                <div class = "col">
                    <div id = "pc_t" name = "pc_t">
                        <label>
                            <input type="checkbox" id="pc" name ="pc" value="1"/> ¿El programa necesita computadores?
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "nivelacion_t" name = "nivelacion_t">
                        <label>
                            <input type="checkbox" id="nivelacion" name ="nivelacion" value="1"/> ¿El programa necesita nivelación?
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "intro_DA_t" name = "intro_DA_t">
                        <label>
                            <input type="checkbox" id="intro_DA" name ="intro_DA" value="1"/> ¿El programa necesita una introducción?
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "cierre_t" name = "cierre_t">
                        <label>
                            <input type="checkbox" id="cierre" name ="cierre" value="1"/> ¿El programa necesita un cierre?
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "encuesta_t" name = "encuesta_t">
                        <label>
                            <input type="checkbox" id="encuesta" name ="encuesta" value="1"/> ¿El programa necesita una encuesta?
                        </label>
                    </div>
                </div>
                <div class = "col">
                    <div id = "reglamento_t" name = "reglamento_t">
                        <label>
                            <input type="checkbox" id="reglamento" name ="reglamento" value="1"/> ¿El programa se rige por el reglamento?
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //se asigna el codigo de sala
    var codigo_sala = '<?php echo $data[48];?>';
    document.getElementById('cod_sala').value = codigo_sala;

    //se asigna la sala de cafe
    var sala_cafe = '<?php echo $data[50];?>';
    document.getElementById('sala_cafe').value = sala_cafe;

    //se asigna si se necesita pc si es 1
    var pc = '<?php echo $data[52];?>';
    if(pc == '1'){
        document.getElementById('pc').setAttribute('checked', 'true');
    }

    //se asigna nivelacion si es 1
    var nivelacion = '<?php echo $data[53];?>';
    if(nivelacion == '1'){
        document.getElementById('nivelacion').setAttribute('checked', 'true');
    }

    //se asigna introduccion si es 1
    var introduccion = '<?php echo $data[54];?>';
    if(introduccion == '1'){
        document.getElementById('intro_DA').setAttribute('checked', 'true');
    }

    //se asigna cierre si es 1
    var cierre = '<?php echo $data[55];?>';
    if(cierre == '1'){
        document.getElementById('cierre').setAttribute('checked', 'true');
    }

    //se asigna encuesta si es 1
    var encuesta = '<?php echo $data[56];?>';
    if(encuesta == '1'){
        document.getElementById('encuesta').setAttribute('checked', 'true');
    }

    //se asigna reglamento si es 1
    var reglamento = '<?php echo $data[57];?>';
    if(reglamento == '1'){
        document.getElementById('reglamento').setAttribute('checked', 'true');
    }
</script>