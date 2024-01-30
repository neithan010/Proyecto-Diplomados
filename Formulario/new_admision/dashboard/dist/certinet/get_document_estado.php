<?php

$id_postulacion=isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';
$documento=isset($_REQUEST['documento'])?$_REQUEST['documento']:'';
if($id_postulacion=='' || $documento==''){
    echo 'Error al recibir parametro';
    exit();
}

session_start();
include_once ('cn.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT
    if(DATE_ADD(c.fecha, INTERVAL c.expires_in SECOND)> NOW(),'SI','NO') tiene_token, 
    c.access_token 
FROM 
	intranet.certinet_authenticate_document c
ORDER BY c.fecha DESC
LIMIT 1";	

//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$num_resultado=$resultado->rowCount();

$tiene_token='';
$token='';

if ($rw_token = $resultado->fetch()){
    $tiene_token=$rw_token['tiene_token'];
    $token=$rw_token['access_token'];
}
//echo 'tiene token: '.$tiene_token.' '.$token.'<p>';

if($tiene_token=='SI'){
    $_SESSION['token'] = $token;

}else{
    include('autenticacion_getDocument.php');
}

$consulta = "SELECT  
    cu.id_postulacion,
    cu.documento, 
    cu.haserror, 
    cu.cod, 
    cu.descripcion, 
    cu.packageID, 
    cu.documentID
FROM 
	intranet.certinet_upload cu
	
WHERE 
    cu.documento='$documento'
    AND cu.haserror='false'
    AND cu.id_postulacion=".$id_postulacion;	

//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$num_resultado=$resultado->rowCount();

$packageID='';
$documentID='';

if ($rws = $resultado->fetch()){
    $packageID=$rws['packageID'];
    $documentID=$rws['documentID'];

}else{
    echo 'Error al optener datos para consultar documento.';
    exit();
}
$conexion = NULL;
//===========================================
$postfields='{
    "package_id":"'.$packageID.'",
    "document_id":"'.$documentID.'"
 }  ';

$httpheader = array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: '.$_SESSION['token']
    );

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/getDocument',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$postfields,
  CURLOPT_HTTPHEADER => $httpheader,
));

$response = curl_exec($curl);

curl_close($curl);
//echo var_dump($response);
$data=json_decode($response, true);

//header('Content-Type: application/pdf');
//echo base64_decode($data['archivo']);

echo $data['status'];

?>