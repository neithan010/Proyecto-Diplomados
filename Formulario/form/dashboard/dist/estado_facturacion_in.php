<?php
include('../cn/cn_PDO.php');

$id_postulacion	= $_REQUEST['id_postulacion'];
$valor='Enviada';


$sql_up_estado="
INSERT INTO intranet.estado_facturacion
		(id_postulacion,
		envio_UA_fecha, 
		envio_UA_estado,
		envio_UA_obs
)VALUES(
		".$id_postulacion.",
		NOW(),
		'".$valor."',
		concat('".$valor." ',date_format(now(),'%d-%m-%Y %H:%i:%s')))
ON DUPLICATE KEY UPDATE 
	envio_UA_fecha=NOW(),
	envio_UA_estado='".$valor."',
	envio_UA_obs=concat(if(envio_UA_obs is null,'',concat(envio_UA_obs,'<br>')),concat('Enviado ',date_format(now(),'%d-%m-%Y %H:%i:%s')))";

    $stmt_up_estados = $con->prepare($sql_up_estado);
    $stmt_up_estados->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_up_estados->execute();
    
    $total_up_estados = $stmt_up_estados->rowCount();
    
    $total_up_estados=1;


if($total_up_estados>0){
    echo '<img src="img/vobo.png?'.$id_postulacion.'" border="0" class="_cambiar_estado_facturacion_deshacer">';
}
?>