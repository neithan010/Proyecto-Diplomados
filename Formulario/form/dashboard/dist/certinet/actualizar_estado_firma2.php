
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Actualizacion Estados</title>
  </head>
  <body>
  <div class="container">
    <h1>Actualizacion estados Certinet - Firma digital</h1>
    <div class="fs-6">
<?php
session_start();
include_once ('cn.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();
/*
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
*/
include('autenticacion_getDocument.php');

$sql_postulaciones_sin_firmar="SELECT 
cu.id_postulacion,
cu.documento,
cu.packageID, 
cu.documentID,
if(cu.documento='declaracion', 
(SELECT fd2.declaracion_firmado from intranet.firma_digital fd2 WHERE fd2.id_postulacion = cu.id_postulacion), 
(SELECT fd2.contrato_ps_firmado from intranet.firma_digital fd2 WHERE fd2.id_postulacion = cu.id_postulacion)
 ) AS firmado

FROM 
intranet.certinet_upload cu
INNER JOIN intranet.firma_digital fd  ON fd.id_postulacion=cu.id_postulacion
INNER JOIN unegocios_nuevo.postulacion p ON p.ID_POSTULACION=cu.id_postulacion
INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
WHERE 
cu.packageID<>0
AND cu.haserror='false'
and cu.documentID<>0

--   AND d.fecha_inicio>=DATE_ADD(CURDATE(), INTERVAL -1 month)
AND d.fecha_inicio>=DATE_ADD(CURDATE(), INTERVAL -1 week)
-- AND d.fecha_inicio>=CURDATE()
AND cu.documento IS NOT NULL
AND (if(cu.documento='declaracion', 
(SELECT fd2.declaracion_firmado from intranet.firma_digital fd2 WHERE fd2.id_postulacion = cu.id_postulacion), 
(SELECT fd2.contrato_ps_firmado from intranet.firma_digital fd2 WHERE fd2.id_postulacion = cu.id_postulacion)
 ))=0 

 
    ORDER BY fd.id_postulacion DESC LIMIT 3


";


$rs_psf = $conexion->prepare($sql_postulaciones_sin_firmar);
$rs_psf->execute();
$num_psf=$rs_psf->rowCount();

while ($rws = $rs_psf->fetch()){
    $arr_data[]=array(
        "id_postulacion" => $rws['id_postulacion'],
        "documento"      => $rws['documento'],
        "packageID"      => $rws['packageID'],
        "documentID"     => $rws['documentID']
    );
}



// Inicializar el gestor cURL
$multiHandle = curl_multi_init();

// Array para almacenar los recursos cURL individuales
$curlHandles = [];

foreach($arr_data as $data){

        //===========================================
        $postfields='{
            "package_id":"'.$data['packageID'].'",
            "document_id":"'.$data['documentID'].'"
        }  ';

        $httpheader = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: '.$_SESSION['token']
            );

        $curlHandle  = curl_init();

        curl_setopt_array($curlHandle , array(
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

        curl_multi_add_handle($multiHandle, $curlHandle);
        $curlHandles[] = $curlHandle;

}

       
$running = null;
do {
    curl_multi_exec($multiHandle, $running);
} while ($running > 0);

// Procesar las respuestas
$responses = [];
foreach ($curlHandles as $curlHandle) {
    $response = curl_multi_getcontent($curlHandle);
    $responses[] = $response;
    curl_multi_remove_handle($multiHandle, $curlHandle);
}

// Cerrar el gestor cURL
curl_multi_close($multiHandle);

// Imprimir las respuestas
foreach ($responses as $response) {
    //echo $response . "\n";
    $data_response=json_decode($response, true);
    
    echo $data_response['error'].' '.$data_response['message'].'<br>';
}



echo '</div><hr>';






$conexion = NULL;
$conexion2 = NULL;

?>
</div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>