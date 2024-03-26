<?php
$obs            = isset($_POST['obs'])?htmlspecialchars(addslashes($_POST['obs'])):'';
$usuario        = isset($_POST['usuario'])?htmlspecialchars(addslashes($_POST['usuario'])):'';
$idpostulacion  = isset($_POST['idpostulacion'])?htmlspecialchars(addslashes($_POST['idpostulacion'])):'';


if($obs<>'' && $idpostulacion<>''){

    include('../cn/cn_PDO.php');

    $sql_obs="INSERT INTO intranet.postulacion_obs
    (obs, usuario, fecha, idpostulacion)
    VALUES
    ('".utf8_decode($obs)."', '$usuario', NOW(), $idpostulacion)
    ON DUPLICATE KEY UPDATE obs='".utf8_decode($obs)."',
    fecha=NOW()
    ";

    $stmt_obs = $con->prepare($sql_obs);
    $stmt_obs->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_obs->execute();
    $arr_error=$stmt_obs->errorInfo();

    $id_obs = $con->lastInsertId();

    if($id_obs=='' || $arr_error[2]<>''){ 
        echo 'Error';
        echo '<p>'.$arr_error[2].'</p><pre>'.$sql_in.'</pre>';
        exit();
    }else{
        echo $obs.' <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-txt_obs="'.$obs.'" data-bs-whatever="'.$idpostulacion.'"><i class="far fa-clipboard"></i></button>';
    }
}

?>