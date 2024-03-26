<p>
    hola pe, esto funciona
</p>

<?php
    if(isset($_POST['data_coordinador_ejecutivo'])){
        echo $_POST['data_coordinador_ejecutivo'];
    } else{
        echo "Datos de encargado perdidos";
    }