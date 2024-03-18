<?php

$id_postulacion = isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';
if($id_postulacion==''){ 
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
//----------------------------------
// Data base 64
//--------------------------------
$consulta = "SELECT 
    p.RUT,
    p.es_rut,
    CONCAT_WS(' ', p.NOMBRES, p.APELLIDO_PAT, p.APELLIDO_MAT) nombre,
    p.EMAIL,
    f.declaracion_64 
FROM 
    unegocios_nuevo.postulacion p 
    left join intranet.firma_digital f ON p.ID_POSTULACION=f.id_postulacion
WHERE 
    f.id_postulacion=".$id_postulacion;	

//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$num_resultado=$resultado->rowCount();

$declaracion_64='';


if ($rws = $resultado->fetch()){
    $declaracion_64 = $rws['declaracion_64'];
    $rut            = $rws['RUT'];
    $es_rut         = $rws['es_rut'];
    $nombre         = $rws['nombre'];
    $email          = $rws['EMAIL'];
}

if($declaracion_64==''){ 
    echo 'Error no se encontro declaracion';
    exit();
}else{
    $documento = $declaracion_64;
}

//---------------------------------------



$conexion = NULL;

//echo 'tiene token: '.$tiene_token.' '.$token.'<p>';

if($tiene_token=='SI'){
    $_SESSION['token'] = $token;

}else{
    include('autenticacion.php');
}

//echo '$_SESSION[token]: '.$_SESSION['token'].'<p>';

//echo 'inicio creacion documento a firmar';
//======================================================================================
$nombre_documento = "Declaracion Jurada ID ".$id_postulacion." ".date('YmdHmi');
$gestor = "admsdf.fen@unegocios.cl";

//------------------------------
if($es_rut==1){
    $postfields='{
        "nombre_documento":"'.$nombre_documento.'",
        "gestor":"'.$gestor.'",
        "tipo_documento":"declaracion Jurada",
        "plantilla":"declaracion Jurada",
        "firmantes":{
        "no_registrados":[
            {
                
                "rut":"'.$rut.'",
                "tipo":"A",
                "notificacion_email":"no",
                "nombre":"'.$nombre.'",
                "email":"'.$email.'"
            }
        ]
        },
        "documento":"'.$documento.'"
    }';
}else{
    $postfields='{
        "nombre_documento":"'.$nombre_documento.'",
        "gestor":"'.$gestor.'",
        "tipo_documento":"declaracion Jurada",
        "plantilla":"declaracion Jurada",
        "firmantes":{
           "no_registrados":[
              {
                 
                 "tipo":"A",
                 "notificacion_email":"no",
                 "nombre":"'.$nombre.'",
                 "email":"'.$email.'"
              }
           ]
        },
        "documento":"'.$documento.'"
     }';
}
$curl = curl_init();

$httpheader = array(
    'Accept: application/json',
    'Content-Type: application/json; charset=utf-8',
    'Authorization: '.$_SESSION['token']
);


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/upload',
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
//echo $response;

$data=json_decode($response, true);

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "INSERT INTO intranet.certinet_upload 
        (id_postulacion, documento, haserror, cod, descripcion, packageID, documentID) 
    VALUES
        ($id_postulacion, 'declaracion', '".$data['hasError']."','".$data['code']."','".$data['message']."','".$data['packageID']."','".$data['documentID']."')";	

//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();  
$conexion = NULL;

if($data['hasError']=='true'){
    $fp = fopen("log_error_upload.txt", "a");
    fwrite($fp, $response);
    fclose($fp);   
    echo 'Error '.$data['message']; 
}else{
    echo 'packageID: '.$data['packageID'].", documentID: ".$data['documentID'];
}

?>
<!--
<a href="link_integracion.php?id_postulacion=<?php echo $id_postulacion?>">Siguiente</a>
-->