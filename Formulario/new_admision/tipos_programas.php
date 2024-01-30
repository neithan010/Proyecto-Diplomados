<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<ol>
    <?php
    foreach($arr_tipo_programas as $tipo_programas){
?>
<li><a href="programas_x_tipo.php?usuario=fbastardo&tipo=<?php echo $tipo_programas['tipo_programa']?>&modalidad=<?php echo $tipo_programas['modalidad_programa']?>"><?php echo $tipo_programas['tipo_programa'].' '.$tipo_programas['modalidad_programa']?></a></li>
<?php
    }
    ?>
    </ol>
</body>
</html>