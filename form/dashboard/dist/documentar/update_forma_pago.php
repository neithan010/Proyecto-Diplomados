<?php
include_once('../../cn/cn_PDO.php');

$id_postulacion = isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';
$qpaga = isset($_REQUEST['qpaga'])?$_REQUEST['qpaga']:'';

if($id_postulacion=='' || $qpaga==''){
    echo 'Error al recibir parametro';
    exit();
}

$sql_update="UPDATE unegocios_nuevo.postulacion
    SET
        ID_FINANCIAMIENTO='$qpaga'
    WHERE
        ID_POSTULACION=$id_postulacion";

//echo $sql_update;
$stmt_up = $con->prepare($sql_update);
$stmt_up->setFetchMode(PDO::FETCH_ASSOC);
$stmt_up->execute();
if($stmt_up->rowCount() > 0){
    $count_stmt_up = $stmt_up -> rowCount();
    echo "$count_stmt_up registro ha sido actualizado";
}
?>