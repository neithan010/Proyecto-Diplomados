<?php

include('../cn/cn_PDO.php');

$ee = $_POST['ee'];

$id_postulacion = $_POST['id_postulacion'];

if($ee==''){
    $arr_sql[]='DELETE FROM intranet.descarga_bruchure
     WHERE id_postulacion='.$id_postulacion;

    $arr_sql[]='DELETE FROM unegocios_nuevo.postulacion
    WHERE ID_POSTULACION='.$id_postulacion;

}

$arr_estado_1011 = array('01','02');
if(in_array($ee, $arr_estado_1011)){
    $arr_sql[]='UPDATE unegocios_nuevo.postulacion
    SET
        etapa=10,
        estado=11
    WHERE ID_POSTULACION='.$id_postulacion;
}

$arr_estado_1010 = array('00','1030','2020','2040');
if(in_array($ee, $arr_estado_1010)){
    $arr_sql[]='UPDATE unegocios_nuevo.postulacion
    SET
        etapa=10,
        estado=10
    WHERE ID_POSTULACION='.$id_postulacion;
}

foreach($arr_sql as $sql){
    $stmt_sql = $con->prepare($sql);
    $stmt_sql->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_sql->execute();
    $num_resultado+=$stmt_sql->rowCount();



}

if($num_resultado_1 > 0){
    echo 'Eliminado';
}else{
    echo '...';
}

?>