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
    <div class = "container">
        <div class = "row row-cols-3 row-cols-lg-3 g-lg-3">
            <div class = "col">
                <div id = "coordinador_ejecutivo_t" name = "coordinador_ejecutivo_t">
                    <label>
                        <div class = 'text-center'>
                            Coordinador Ejecutivo
                        </div>
                        <label>
                            Nombre
                            <input id = 'nombre_cordinador_ejecutivo' name = 'nombre_cordinador_ejecutivo' type = 'text' maxlength = '100'>
                            <input type = 'button' value = 'Buscador' onclick = 'display_search_encargados("coordinador ejecutivo")'>
                        </label>
                        <label>
                            Telefono
                            <input id = 'telefono_cordinador_ejecutivo' name = 'telefono_cordinador_ejecutivo' type = 'tel' maxlength = '15'>
                        </label>
                    </label>
                    <script>
                        //coordinador ejecutivo
                        var nombre_cordinador_ejecutivo = '<?php echo $data[45];?>';
                        var telefono_cordinador_ejecutivo = '<?php echo $data[46];?>';

                        document.getElementById('nombre_cordinador_ejecutivo').value = nombre_cordinador_ejecutivo;
                        document.getElementById('telefono_cordinador_ejecutivo').value = telefono_cordinador_ejecutivo;
                    </script>
                </div>
            </div>
            <div class = "col">
                <div id = "director_academico_t" name = "director_academico_t">
                    <label>
                        <div class = 'text-center'>
                            Director Academico
                        </div>
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
                    <script>
                        //director academico
                        var nombre_director_academico = '<?php echo $data[26];?>';
                        var email_director_academico = '<?php echo $data[27];?>';

                        document.getElementById('nombre_director_academico').value = nombre_director_academico;
                        document.getElementById('email_director_academico').value = email_director_academico;
                    </script>   
                </div>
            </div>
            <div class = "col">
                <div id = "coordinador_docente_t" name = "coordinador_docente_t">
                <label> 
                    <div class = 'text-center'>
                        Coordinador Docente
                    </div>
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
                <script>
                    //coordinador docente
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
                        <div class = 'text-center'>
                            Secretaria
                        </div>
                        <label>
                            Nombre
                            <input id = 'nombre_secretaria' name = 'nombre_secretaria' type = 'text' maxlength = '100'>
                        </label>
                    </label>
                    <?php
                        //secretaria
                        $id = $data[49];
                        $nombre_secretaria='';
                        if($id != ''){
                            $nombre = get_secretaria($id);
                            $nombre_completo = $nombre[0]['Nombre_Secretaria']." ".$nombre[0]['Apellido_Paterno']." ".$nombre[0]['Apellido_Materno'];
                        }
                    ?>
                    <script>
                        var nombre_secretaria = '<?php echo $nombre_secretaria?>';
                        document.getElementById('nombre_secretaria').value = nombre_secretaria;
                    </script>
                </div>
            </div>
            <div class = "col">
                <div id = "coordinador_comercial_t" name = "coordinador_comercial_t">
                    <label>
                        <div class = 'text-center'>
                            Coordinador Comercial
                        </div>
                        Nombre
                        <input id = 'coordinador_comercial' name = 'coordinador_comercial' type = 'text' maxlength = '100'>
                    </label>
                    <?php 
                        $usr_cord_comercial = $data[58];
                        $nombre_cord_comercial = '';
                        if($usr_cord_comercial !=''){
                            $nombre = get_cord_comercial($usr_cord_comercial);
                            $nombre_cord_comercial = $nombre[0]['Nombre_Cord_Comercial'].' '.$nombre[0]['Apellido'];
                        }
                    ?>
                    <script>
                        var nombre_cord_comercial = '<?php echo $nombre_cord_comercial?>';
                        document.getElementById('coordinador_comercial').value = nombre_cord_comercial;
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div style ="margin-left: 20px;" id = 'buscador_encargados' hidden>
    <h5 id = 'title_buscador'>
    </h5>
    <hr>    
    <br>
    <div id = 'buscador'>
        <div class = 'container'>
            <div class = 'row '>
                <div class = 'col'>
                    <label>
                        <div class = 'text-center'>
                            Nombre
                        </div>
                    </label>
                    <input id = 'buscar_name_encargado' name = 'buscar_name_encargado' type = 'text' maxlength = '100'>
                    <input type = 'button' id = 'button_buscar_encargados'>

</div>
<script>

    function display_search_encargados(tipo){
        var buscador_encargados = document.getElementById('buscador_encargados');

        if(tipo == 'coordinador ejecutivo'){
            if(buscador_encargados.hasAttribute('hidden')){
                console.log('hola pe');
                var title_buscador = document.getElementById('title_buscador');
                var value_button = document.getElementById('button_buscar_encargados');
                var input_name = document.getElementById('buscar_name_encargado');

                buscador_encargados.removeAttribute('hidden');
                title_buscador.textContent = 'Buscar Coordinador Ejecutivo';
                value_button.value = 'Buscar Coord. Ejec.';
                input_name.placeholder = 'Nombre Cord. Ejec.';
            } else{
                buscador_encargados.setAttribute('hidden', 'true');
            }
        }
    }
    /*function display_table_encargados(tipo){
        var datos = get_data_encargados(tipo);*/
</script>