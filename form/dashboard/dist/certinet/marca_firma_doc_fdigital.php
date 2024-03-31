<?php 
$id_postulacion = isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';

if($id_postulacion==''){
  echo 'Error al recibir parametro';
  exit();
}



include_once ('cn.php');
$obj = new Conexion();
$conex = $obj->Conectar();

$sql_update = "UPDATE intranet.firma_digital
SET 
declaracion_firmado=1,
contrato_ps_firmado=1
WHERE
id_postulacion=$id_postulacion";
        
//echo '<pre>'.$sql_update.'</pre>';

$smt_rs = $conex->prepare($sql_update);
if($smt_rs->execute()){
  echo 'actualizado '.$id_postulacion;
}else{
  echo ':: Error';
  
}
$conex = NULL;

?>