<?php
include('cn/cn_PDO.php');

$nombre_programa = $_GET['nombre_programa'];
$tipo_producto = $_GET['tipo_producto'];
$area = $_GET['area'];
$tipo_programa = $_GET['tipo_programa'];
$modalidad = $_GET['modalidad'];
$periodo = $_GET['periodo'];
$jornada = $_GET['horario'];
$nivel = $_GET['nivel'];
$realizacion_en = $_GET['realización_en'];
$fecha_de_inicio = $_GET['fecha_de_inicio'];

#Si estamos en modo busqueda de un programa(get)
if($buscar){
    include('get_program.php');
}

#Si estamos en modo, ingresar un nuevo programa(post)
else{
    include('post_program.php');
}
?>

