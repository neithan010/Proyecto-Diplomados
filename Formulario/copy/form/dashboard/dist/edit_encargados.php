<div id = "title" style="margin-left: 15px;">
    <h4>
        Encargados
    </h4>
</div>
<hr>
<div class="container" style="margin-top: 15px;">
  <div class="row align-items-start">
  <div class="col">
        <div id = "coordinador_ejecutivo_t">
            <label class="text-center">
                Coordinador Ejecutivo
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex" action = 'edit_encargados.php'>
                            <input class="form-control me-2" type = 'text' id = 'coordinador_ejecutivo' name = 'coordinador_ejecutivo' maxlength = "100">
                            <input class="form-control me-2" type="search" aria-label="Search" placeholder = "Buscar Coordinador Ejecutivo" id = "nombre_coordinador_ejecutivo" name = "nombre_coordinador_ejecutivo" required>
                            <input class="form-control me-2" type='text' id = 'data_coordinador_ejecutivo' name = 'data_coordinador_ejecutivo' value = 'data_coordinador_ejecutvo' hidden required>
                            <button class="btn btn-outline-success" type="submit" id = 'buscar_coordinador_Docente'>Buscar</button>
                        </form>
                    </div>
                </nav>
            </label>
        </div>
    </div>  
    <div class="col">
        <div id = "director_academico_t" name = "director_academico_t">
            <label class="text-center">
                Director Academico
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex">
                        <input class="form-control me-2" type = 'text' id = 'director_academico' name = 'director_academico' maxlength = "60">
                        <br>
                        <input class="form-control me-2" type="search" placeholder="Buscar Director Académico" aria-label="Search">
                        <br>
                        <input class="form-control-me-2" type='text' id = 'data_director_academico' name = 'data_director_academico' value = 'data_director_academico' hidden>
                        <button class="btn btn-outline-success" type="submit" id = 'buscar_director_academico' onclick="display_encargados()">Buscar</button>
                        </form>
                    </div>
                </nav>
            </label>
        </div>
    </div>
    <div class="col">
        <div id = "coordinador_docente_t" name = "coordinador_docente_t">
            <label class="text-center">
                Coordinador Docente
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex">
                        <input class="form-control me-2" type = 'text' id = 'coordinador_docente' name = 'coordinador_docente' maxlength = "100">
                        <input class="form-control me-2" type="search" placeholder="Buscar Coordinador Docente" aria-label="Search">
                        <input class="form-control-me-2" type='text' id = 'data_coordinador_docente' name = 'data_coordinador_docente' value = 'data_coordinador_docente' hidden>
                        <button class="btn btn-outline-success" type="submit" id = 'buscar_coordinador_Docente' onclick="display_encargados()">Buscar</button>
                        </form>
                    </div>
                </nav>
            </label>
        </div>
    </div> 
  </div>
</div>

<div class="container" style="margin-top: 15px;">
  <div class="row align-items-start">
  <div class="col">
        <div id = "secretaria_t" name = "secretaria_t">
            <label class="text-center">
                Secretaria
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex">
                            <input class="form-control me-2" type = 'text' id = 'secretaria' name = 'secretaria' maxlength = "100"        >
                            <input class="form-control me-2" type="search" aria-label="Search" placeholder = "Buscar Secretaria" id = "nombre_secretaria">
                            <input class="form-control-me-2" type='text' id = 'data_secretaria' name = 'data_secretaria' value = 'data_secretaria' hidden>
                            <button class="btn btn-outline-success" type="submit" id = 'buscar_secretaria' onclick="display_encargados()">Buscar</button>
                        </form>
                    </div>
                </nav>
            </label>
        </div>
    </div>  
    <div class="col">
        <div id = "coordinador_comercial_t" name = "coordinador_comercial_t">
            <label class="text-center">
                Coordinador Comercial
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex">
                        <input class="form-control me-2" type = 'text' id = 'coordinador_comercial' name = 'coordinador_comercial' maxlength = "60">
                        <br>
                        <input class="form-control me-2" type="search" placeholder="Buscar Coordinador Comercial" aria-label="Search">
                        <br>
                        <input class="form-control-me-2" type='text' id = 'data_coordinador_comercial' name = 'data_coordinador_comercial' value = 'data_coordinador_comercial' hidden>
                        <button class="btn btn-outline-success" type="submit" id = 'buscar_coordinador_comercial' onclick="display_encargados()">Buscar</button>
                        </form>
                    </div>
                </nav>
            </label>
        </div>
    </div>
  </div>
</div>

<div id = "secretaria" name = "secretaria">

</div>
<div id = "coordinador_comercial" name = "coordinador_comercial">

</div>
<div id = "results_search_encargados" hidden>
    
    <?php include('display_encargados_results.php');?>
</div>

<script>
    function display_encargados(){

        //revelamos los resultados
        var results = document.getElementById('results_search_encargados');
        if(results.hasAttribute('hidden')){
            results.removeAttribute('hidden');
        } else{
            results.setAttribute('hidden', 'true');
        }
        event.preventDefault();
    }
</script>