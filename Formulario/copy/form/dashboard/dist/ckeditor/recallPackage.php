<?php
$id_postulacion = isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';
$documento = isset($_REQUEST['documento'])?$_REQUEST['documento']:'';
if($id_postulacion=='' || $documento==''){ 
    echo 'Error recibir parametro';
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

//----------------------------------
// packageID
//--------------------------------
$consulta = "SELECT  
    c.packageID
FROM 
    intranet.certinet_upload c 
WHERE 
    c.haserror = 'false'
    AND c.documento='".$documento."'
    AND c.id_postulacion=".$id_postulacion;	

//echo '<pre>'.$consulta.'</pre>';
//exit();

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$num_resultado=$resultado->rowCount();

$packageID='';


if ($rws = $resultado->fetch()){
    $packageID = $rws['packageID'];

}

if($packageID==''){ 
    echo 'Error no se encontro contrato activo, packageID: '.$packageID;
    exit();
}
//---------------------------------------

$conexion = NULL;

//echo 'tiene token: '.$tiene_token.' '.$token.'<p>';

if($tiene_token=='SI'){
    $_SESSION['token'] = $token;

}else{
    include('autenticacion_getDocument.php');
}

//echo '$_SESSION[token]: '.$_SESSION['token'].'<p>';


//======================================================================================


$postfields='{
    "package_id":"'.$packageID.'"
}';

$curl = curl_init();

$httpheader = array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: '.$_SESSION['token']
);


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/recallPackage',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $postfields,
  CURLOPT_HTTPHEADER => $httpheader,
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$data=json_decode($response, true);

//var_dump($data);

if($data['error']=='true'){
    echo 'Error: '.$data['message'];
    $fp = fopen("log_error_recallPackage.txt", "a");
    fwrite($fp, $response);
    fclose($fp);   
}else{



    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $consulta = "UPDATE intranet.certinet_upload
        SET  haserror = 'true',
        descripcion = concat('Correccion - ',descripcion)
    WHERE
        packageID='".$data['packageID']."'";	

    //echo '<pre>'.$consulta.'</pre>';

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();  
    $conexion = NULL;

    echo 'Exito, refresque la pagina y generar el nuevo contrato';
}
?>
