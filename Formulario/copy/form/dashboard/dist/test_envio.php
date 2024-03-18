<?php
    if(isset($_POST['programaSeleccionado'])){
        $p = $_POST['programaSeleccionado'];
        if($p == ""){
            echo "Datos no Entregados";
        } else{
            echo $p;
        }
    } else{
        ?>
        <p>No se recibio</p>
        <?php
    }
    ?>