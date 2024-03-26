<?php
include('../../cn/cn_PDO.php');

$idpostulacion=isset($_POST['id_postulacion'])?$_POST['id_postulacion']:'';

if($idpostulacion == ''){
    echo 'error';
    exit();
}

$sql_dell="DELETE FROM 
        intranet.postulacion_documentos 
    WHERE 
        documento='control_decreto.pdf'
        AND idpostulacion=$idpostulacion";

$stmt_dell = $con->prepare($sql_dell);
$stmt_dell ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_dell ->execute();
$num_dell = $stmt_dell ->rowCount();	

$sql_up_control_decreto="UPDATE intranet.control_decreto
SET
    corregido = 1
WHERE 
    idpostulacion = $idpostulacion";

$stmt_up_control_decreto = $con->prepare($sql_up_control_decreto);
$stmt_up_control_decreto ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_up_control_decreto ->execute();
$num_up_control_decreto = $stmt_up_control_decreto ->rowCount();	

$sql_up_postulacion_descuento="UPDATE intranet.postulacion_descuento
SET
    total_descuento = 0
WHERE 
    id_postulacion = $idpostulacion";

$stmt_up_postulacion_descuento = $con->prepare($sql_up_postulacion_descuento);
$stmt_up_postulacion_descuento ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_up_postulacion_descuento ->execute();
$num_up_postulacion_descuento = $stmt_up_postulacion_descuento ->rowCount();	


if($num_dell>0){
    //echo 'Eliminado '.$num_dell;
    ?>
    <i class="fas fa-file-alt"></i>
    <a href="../control_decreto/control_decreto.php?id_postulacion=<?php echo $idpostulacion;?>" target="_blank" id="lnk_cd">Control decreto</a>
            
    <?php
}
?>