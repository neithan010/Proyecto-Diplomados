<?php

#Busqueda de un programa para editar o crear
include_once('cn.php');

#verificar si edita o crea

$nombre_programa = '';
$tipo_programa = $REQUEST['tipo_programa'];
$area = $REQUEST['area_conocimiento'];
$modalidad = $REQUEST['modalidad_programa'];
$tipo = $REQUEST['id'];



$sql_program_to_edit = "SELECT d.ID_DIPLOMA, 
		                       d.tipo_programa,
		                       d.area_conocimiento,
	                           d.modalidad_programa,
		                       d.nivel,
		                       d.realizacion_en,
		                       d.jornada,
		                       d.fecha_inicio,

                               
                        FROM intranet.diplomados d
                        WHERE d.ID_DIPLOMA = .$id;"

$stmt_programa = $con->prepare($sql_program_to_edit);
$stmt_programa->setFetchMode(PDO::FETCH_ASSOC);
$stmt_programa->execute();
$num_programa=$stmt_programa->rowCount();

while ($rw_programa = $stmt_programa->fetch()){
    
    $id                  = $rw_programa['ID_DIPLOMA'];
    $tipo                = $rw_programa['tipo_programa'];
    $area                = utf8_encode($rw_programa['area_conocimiento']);
    $modalidad           = $rw_programa['modalidad_programa'];
    $nivel               = $rw_programa['nivel'];
    $realizacion_en      = $rw_programa['realizacion_en'];
    $horario             = $rw_programa['jornada'];
    $fecha_inicio        = $rw_programa['fecha_inicio'];

}

?>