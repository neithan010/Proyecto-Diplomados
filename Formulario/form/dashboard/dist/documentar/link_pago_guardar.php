<?php

if(isset($_REQUEST['id_postulacion']) && isset($_REQUEST['moneda']) & isset($_REQUEST['monto'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
    $moneda=$_REQUEST['moneda'];
    $monto=str_replace(".","",$_REQUEST['monto']);

}else{
    echo 'Erro';
    exit();
}

include('../../cn/cn_PDO.php');

$sql="DELETE FROM intranet.link_pago
WHERE id_postulacion=$id_postulacion";
$stmt = $con->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();


$sql="INSERT INTO intranet.link_pago
(id_postulacion, moneda, monto)
VALUES
($id_postulacion, '$moneda', '$monto')";

$stmt = $con->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$total_afectado=$stmt->rowCount();

if($total_afectado>0){ 
    echo 'Exito';
}else{
    echo 'Error';
}
?>