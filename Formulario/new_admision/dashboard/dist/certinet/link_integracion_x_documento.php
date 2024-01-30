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
	intranet.certinet_authenticate c
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
    include('autenticacion.php');
}


$consulta = "SELECT  
    cu.id_postulacion,
    cu.documento, 
    cu.haserror, 
    cu.cod, 
    cu.descripcion, 
    cu.packageID, 
    cu.documentID,
    p.EMAIL
FROM 
	intranet.certinet_upload cu
	INNER JOIN unegocios_nuevo.postulacion p ON cu.id_postulacion=p.ID_POSTULACION
WHERE 
    cu.haserror='false'
    AND cu.documento='$documento'
    AND cu.id_postulacion=".$id_postulacion;	

//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$num_resultado=$resultado->rowCount();

$packageID='';


if ($rws = $resultado->fetch()){
    $packageID=$rws['packageID'];
    $documento=$rws['documento'];
    $email=$rws['EMAIL'];
    
}
if($num_resultado==0){
    echo 'Error al optener datos upload.';
    exit();
}
$conexion = NULL;

//echo 'inicio link integracion <p>';

$i=0;



    //$callback_url='https://intranet.unegocios.cl/apps/certinet/';
    $callback_url='https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/firma_exito.php';

    $postfields='{
        "package_id":"'.$packageID.'",
        "language":"en-US",
        "user_email":"'.$email.'",
        "callback_url":"'.$callback_url.'",
        "collapse_panels":"true"
    }';

    $httpheader = array(
        'Accept: application/json',
        'Content-Type: application/json; charset=utf-8',
        'Authorization: '.$_SESSION['token']
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/integration',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
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
    
    //echo '<pre>'.$response.'</pre>';

    $data=json_decode($response, true);
    
   
if(!$data['error']){
    header('Location: '.$data['integration_url']);
    exit;
}else{
?>    
   <p>Error: <?php echo $data["message"];?> :: <?php echo $data['details']?></p>

<?php
}
    
?>