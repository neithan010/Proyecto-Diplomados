<?php
include('../header.php');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form id = "mini-formulario" method = 'post' href = formulario_program.php>
    <p>
        <p>
            <label>
                ¿Desea crear un programa usando uno ya existente? 
                <select name = 'crear_programa_0_1' id = 'crear_programa' required>
                    <option value= 'si'>
                        Si
                    </option>
                    <option value= 'no'>
                        No
                    </option>
                </select>
            </label>
        </p>
        <p>
            <button type = "submit" href = 'formulario_program.php'> CLICK ME </button>
        </p>
    </p>
</form>

<script>
    var buscar = false;
    var xhttp = new XMLHttpRequest();

    document.getElementById('crear_programa').addEventListener('change', function() {
        var seleccionado = this.value;
        if(seleccionado  === 'si'){
            buscar = true;
        }
        else{
            buscar = false;
        }
        
        xhttp.open("POST", "formulario_program.php?buscar=" + seleccionado, true);
        xhttp.setRequestHeader("boolean", "application/response");
        xhttp.send();
    });
</script>
<?php
include_once('../footer.php');
?>