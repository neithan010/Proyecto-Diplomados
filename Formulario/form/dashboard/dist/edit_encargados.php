<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="style" type="text/css" href="C:\laragon\www\form\css\estilo_create_program.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="C:\laragon\www\form\css\estilo_create_program.css">
<div class="encargados_title" style ="margin-left: 20px;">
        <h4>
            Encargados
        </h4>
</div>
<hr>    
<br>
<div id = "encargados-3" name = "encargados-3">
    <div class = "container text-center">
        <div class = "row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class = "col">
                <div id = "coordinador_ejecutivo_t" name = "coordinador_ejecutivo_t">
                    <label>
                        Coordinador Ejecutivo
                        <br>
                        <label>
                            Nombre
                            <input id = 'nombre_cordinador_ejecutivo' name = 'nombre_cordinador_ejecutivo' type = 'text' maxlength = '100'>
                        </label>
                        <label>
                            Telefono
                            <input id = 'telefono_cordinador_ejecutivo' name = 'telefono_cordinador_ejecutivo' type = 'tel' maxlength = '15'>
                        </label>
                    </label>
                </div>
            </div>
            <div class = "col">
                <div id = "director_academico_t" name = "director_academico_t">
                    <label>
                        Director Academico
                        <br>
                        <label>
                            Nombre
                            <input id = 'nombre_director_academico' name = 'nombre_director_academico' type = 'text' maxlength = '60'>
                        </label>
                        <label>
                            E-mail
                            <input  id = 'email_director_academico' name = 'email_director_academico' type = 'email' 
                                pattern=".+@unegocios.cl" maxlength="100" placeholder = 'example@unegocios.cl'>
                        </label>
                    </label>
                    </label>
                </div>
            </div>
            <div class = "col">
                <div id = "coordinador_docente_t" name = "coordinador_docente_t">
                <label>
                        Coordinador Docente
                        <br>
                        <label>
                            Nombre
                            <input id = 'nombre_cordinador_docente' name = 'nombre_cordinador_docente' type = 'text' maxlength = '100'>
                        </label>
                        <label>
                            Telefono
                            <input id = 'telefono_cordinador_docente' name = 'telefono_cordinador_docente' type = 'tel' maxlength = '15'>
                        </label>
                        <label>
                            E-mail
                            <input  id = 'email_cordinador_docente' name = 'email_cordinador_docente' type = 'email' 
                                pattern=".+@unegocios.cl" maxlength="100" placeholder = 'example@unegocios.cl'>
                        </label>
                    </label>
                </div>
            </div>
        </div>
        <div class = "row row-cols-2 row-cols-lg-2 g-lg-2">
            <div class = "col">
                <div id = "secretaria_t" name = "secretaria_t">
                    <label>
                        secretaria
                        <select>
                        </select>
                    </label>
                </div>
            </div>
            <div class = "col">
                <div id = "coordinador_comercial_t" name = "coordinador_comercial_t">
                    <label>
                        Coordinador Comercial
                        <select>
                        </select>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //coordinador ejecutivo
    var nombre_cordinador_ejecutivo = '<?php echo $data[45];?>';
    var telefono_cordinador_ejecutivo = '<?php echo $data[46];?>';

    document.getElementById('nombre_cordinador_ejecutivo').value = nombre_cordinador_ejecutivo;
    document.getElementById('telefono_cordinador_ejecutivo').value = telefono_cordinador_ejecutivo;

    //director academico
    var nombre_director_academico = '<?php echo $data[26];?>';
    var email_director_academico = '<?php echo $data[27];?>';

    document.getElementById('nombre_director_academico').value = nombre_director_academico;
    document.getElementById('email_director_academico').value = email_director_academico;

    //coordinador docente
    var nombre_cordinador_docente = '<?php echo $data[29];?>';
    var telefono_cordinador_docente = '<?php echo $data[32];?>';
    var email_cordinador_docente = '<?php echo $data[31];?>';

    document.getElementById('nombre_cordinador_docente').value = nombre_cordinador_docente;
    document.getElementById('telefono_cordinador_docente').value = telefono_cordinador_docente;
    document.getElementById('email_cordinador_docente').value = email_cordinador_docente;

    //secretaria es un id: buscar de donde sale ese id para traerlas al formulario
    //cordinador comercial: no hay desde los ultimos 2 años hasta la fecha
</script>