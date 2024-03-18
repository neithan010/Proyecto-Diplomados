<?php 
//echo 'Atenticacion<p>';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/authenticate',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'grant_type=password&
client_id=API_unegocios_admision&
client_secret=EB41B7CCC3AD060F894B6A9DA07D5FD24F468BBC64F6186DB6E2791EFD0D8335&
username=admsdf.fen@unegocios.cl&
password=unegocios2022.,',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/x-www-form-urlencoded; charset=utf-8'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$data=json_decode($response, true);
if(isset($data['error'])){
  if($data['error']===true){
    echo 'Error '.$data['message'].' '.$data['details'];
    exit();
  }
}

include_once ('cn.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "INSERT INTO intranet.certinet_authenticate_document 
        (access_token, token_type, expires_in) 
    VALUES
        ('".$data['access_token']."','".$data['token_type']."','3600')";	
//('".$data['access_token']."','".$data['token_type']."','".$data['expires_in']."')";	
//echo '<pre>'.$consulta.'</pre>';

$resultado = $conexion->prepare($consulta);
$resultado->execute();  

$_SESSION['token'] = $data['access_token'];

//$conexion = NULL;

?>