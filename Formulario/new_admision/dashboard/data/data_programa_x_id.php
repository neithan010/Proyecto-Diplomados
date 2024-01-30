<?php
include_once('cn.php');

$id =$_REQUEST['id'];

if($id==''){
  $id=0;
}

$sql_programa="SELECT 
        d.Cod_interno,
        d.cod_diploma,
        d.DIPLOMADO,
        d.fecha_inicio,
        d.fecha_termino,
        d.tipo_programa,
        d.modalidad_programa
    FROM 
	    intranet.diplomados d 
    WHERE 
    d.ID_DIPLOMA=".$id;

//echo '<pre>'.$sql_programas.'</pre>';

$stmt_programa = $con->prepare($sql_programa);
$stmt_programa->setFetchMode(PDO::FETCH_ASSOC);
$stmt_programa->execute();
$num_programa=$stmt_programa->rowCount();	
//echo '::'.$num_convenios;

if ($rw_programa = $stmt_programa->fetch()){
    
        $ceco               = $rw_programa['Cod_interno'];
        $cod_diploma        = $rw_programa['cod_diploma'];
        $programa           = utf8_encode($rw_programa['DIPLOMADO']);
        $fecha_inicio       = $rw_programa['fecha_inicio'];
        $fecha_termino      = $rw_programa['fecha_termino'];
        $tipo_programa      = $rw_programa['tipo_programa'];
        $modalidad_programa = $rw_programa['modalidad_programa'];
    
}
?>

