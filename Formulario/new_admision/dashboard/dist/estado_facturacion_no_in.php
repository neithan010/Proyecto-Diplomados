<?php
include('../cn/cn_PDO.php');

$id_postulacion	= $_REQUEST['id_postulacion'];
$valor='estado_envio_UA';


$sql_up_estado="
UPDATE intranet.estado_facturacion
SET
	envio_UA_fecha=NULL, 
	envio_UA_estado=NULL,
	envio_UA_obs=NULL
WHERE
	id_postulacion=".$id_postulacion."
	AND recibido_UA_fecha IS NULL";

    $stmt_up_estados = $con->prepare($sql_up_estado);
    $stmt_up_estados->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_up_estados->execute();
    
    $total_up_estados = $stmt_up_estados->rowCount();
  
    $total_up_estados=1;


if($total_up_estados>0){
    echo '<img src="img/btn_fac.png?'.$id_postulacion.'" border="0" data-bs-toggle="xtooltip" data-bs-placement="top" title="Registrar envio a UA" class="_cambiar_estado_facturacion" >';
}
?>