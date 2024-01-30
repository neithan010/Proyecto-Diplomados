<?php

$id_form=isset($_REQUEST['id_form'])?$_REQUEST['id_form']:'';
$archivo=$_REQUEST['archivo'];

if($id_form=='' || $archivo==''){
    echo 'Error al recibir los datos';
    exit();
}

$strServer = "192.168.5.5";
$strServerPort = "4322";
$strServerUsername = "intranet";
$strServerPassword = "INtqwer55p.,";

$connection = ssh2_connect($strServer, $strServerPort);
if(ssh2_auth_password($connection, $strServerUsername, $strServerPassword)){
    $sftp = ssh2_sftp($connection);
    $dir='/intranet/apps/cdg/postulacion/admision/Fichas/'.$id_form.'/'.$archivo;
    if(ssh2_sftp_unlink($sftp, $dir)){
        echo 'Eliminado';
    }
}else{
    echo 'No ha sido posible conectar con el servidor';
}


?>