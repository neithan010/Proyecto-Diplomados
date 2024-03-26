<?php
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


$sql_postulaciones_sin_firmar="SELECT 
    cu.id_postulacion,
    cu.documento,
    cu.packageID, 
    cu.documentID,
    fd.declaracion_firmado,
    fd.contrato_ps_firmado
FROM 
    intranet.certinet_upload cu
    INNER JOIN intranet.firma_digital fd ON cu.id_postulacion=fd.id_postulacion
    INNER JOIN unegocios_nuevo.postulacion p ON p.ID_POSTULACION=cu.id_postulacion
    INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
WHERE 
    cu.haserror='false'
    AND d.fecha_inicio>=DATE_ADD(CURDATE(), INTERVAL -1 month)
    AND cu.documento IS NOT NULL
    AND (fd.declaracion_firmado = 0 OR fd.contrato_ps_firmado = 0)



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

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sdf.certinet.cl/SDF-FEN/v1/getDocument',
        CURLOPT_RETURNTRANSFER => true,
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
        $data_response=json_decode($response, true);

        //header('Content-Type: application/pdf');
        //echo base64_decode($data_response['archivo']);
    if($data_response['status']=='COMPLETED'){
        echo $data['id_postulacion'].' '.$data['documento'].': <span style="color:#00ff7f">'.$data_response['status'].'</span><br>';
    }else{
        echo $data['id_postulacion'].' '.$data['documento'].': '.$data_response['status'].'<br>';
    }
    

        if($data_response['status']=='COMPLETED'){
            if($data['documento']=='declaracion'){
                $sql_up="UPDATE intranet.firma_digital
                SET
                    declaracion_firmado=1
                WHERE
                    id_postulacion=".$data['id_postulacion'];
            }
            if($data['documento']=='contrato'){
                $sql_up="UPDATE intranet.firma_digital
                SET
                    contrato_ps_firmado=1
                WHERE
                    id_postulacion=".$data['id_postulacion'];
            }
            $arr_sql_up[]=$sql_up;

        }


}
echo '<hr>';
//echo '<pre>'.print_r($arr_sql_up, true).'</pre>';

foreach($arr_sql_up as $sql_up){

    $rs_up = $conexion->prepare($sql_up);
    $ok = $rs_up->execute();
    
    echo '<pre>'.print_r($sql_up, true).'</pre>';
    if($ok === TRUE){
        echo " :: Cambios guardados<br>";
    }else{ echo " :: No se pudo actualizar.<br>";
         print_r($conexion->errorInfo()); #No olvides quitar esto cuando funcione
    }
}

$conexion = NULL;









?>