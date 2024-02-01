
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

//if($tiene_token=='SI'){
//    $_SESSION['token'] = $token;

//}else{
    include('autenticacion_getDocument.php');
//}

//include('autenticacion_getDocument.php');

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


 
-- ORDER BY fd.id_postulacion DESC LIMIT 25


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
        $data_response=json_decode($response, true);

        //header('Content-Type: application/pdf');
        //echo base64_decode($data_response['archivo']);
    if($data_response['status']=='COMPLETED'){
        echo $data['id_postulacion'].' '.$data['documento'].': <span style="color:#00ff7f">'.$data_response['status'].'</span><br>';
        if($data['documento']=='declaracion'){
            $arr_declaracion[]=$data['id_postulacion'];
        }
        if($data['documento']=='contrato'){
            $arr_contrato[]=$data['id_postulacion'];
        }
    
    }elseif($data_response['status']=='DECLINED'){
        echo $data['id_postulacion'].' '.$data['documento'].': <span style="color:#ff0000">'.$data_response['status'].'</span><br>';
        if($data['documento']=='declaracion'){
            $arr_declaracion_rech[]=$data['id_postulacion'];
        }
        if($data['documento']=='contrato'){
            $arr_contrato_rech[]=$data['id_postulacion'];
        }
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
echo '</div><hr>';
//echo '<pre>'.print_r($arr_sql_up, true).'</pre>';
/*
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
*/

$objeto2 = new Conexion();
$conexion2 = $objeto2->Conectar();

if(!empty($arr_declaracion)){
    $sql_up_declaracion="UPDATE intranet.firma_digital
    SET
        declaracion_firmado=1
    WHERE
        id_postulacion in (".implode(",", $arr_declaracion).")";

    echo '<pre>'.$sql_up_declaracion.'</pre>';

    /*
    $rs_up = $conexion->prepare($sql_up);
    $rs_up->execute();
    */

    $resultado = $conexion2->prepare($sql_up_declaracion);
    $resultado->execute();
    $num_resultado=$resultado->rowCount();


    if($num_resultado > 0){
        echo "<div class='content alert alert-primary' >
                Gracias: $num_resultado registro ha sido actualizado </div>";
    }else{
        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro </div>";
        print_r($resultado->errorInfo()); 
    }
}
/*
if($ok === TRUE){
    echo " :: Cambios guardados<br>";
}else{ echo " :: No se pudo actualizar.<br>";
     print_r($conexion->errorInfo()); #No olvides quitar esto cuando funcione
}
*/
// -----------------------------------------------
if(!empty($arr_contrato)){
    $sql_up_contrato="UPDATE intranet.firma_digital
    SET
        contrato_ps_firmado=1
    WHERE
        id_postulacion in (".implode(",", $arr_contrato).")";

    echo '<pre>'.$sql_up_contrato.'</pre>';


    $resultado_1 = $conexion2->prepare($sql_up_contrato);
    $resultado_1->execute();
    $num_resultado_1=$resultado_1->rowCount();


    if($num_resultado_1 > 0){

        echo "<div class='content alert alert-primary' >
                Gracias: $num_resultado_1 registro ha sido actualizado </div>";
    }else{
        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro </div>";
        print_r($resultado_1->errorInfo()); 
    }

}


if(!empty($arr_declaracion_rech)){
    $sql_up_declaracion="UPDATE intranet.firma_digital
    SET
        declaracion_firmado=3
    WHERE
        id_postulacion in (".implode(",", $arr_declaracion_rech).")";

    echo '<pre>'.$sql_up_declaracion.'</pre>';

    /*
    $rs_up = $conexion->prepare($sql_up);
    $rs_up->execute();
    */

    $resultado = $conexion2->prepare($sql_up_declaracion);
    $resultado->execute();
    $num_resultado=$resultado->rowCount();


    if($num_resultado > 0){
        echo "<div class='content alert alert-primary' >
                Gracias: $num_resultado registro ha sido actualizado </div>";
    }else{
        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro </div>";
        print_r($resultado->errorInfo()); 
    }
}

// -----------------------------------------------
if(!empty($arr_contrato_rech)){
    $sql_up_contrato="UPDATE intranet.firma_digital
    SET
        contrato_ps_firmado=3
    WHERE
        id_postulacion in (".implode(",", $arr_contrato_rech).")";

    echo '<pre>'.$sql_up_contrato.'</pre>';


    $resultado_1 = $conexion2->prepare($sql_up_contrato);
    $resultado_1->execute();
    $num_resultado_1=$resultado_1->rowCount();


    if($num_resultado_1 > 0){

        echo "<div class='content alert alert-primary' >
                Gracias: $num_resultado_1 registro ha sido actualizado </div>";
    }else{
        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro </div>";
        print_r($resultado_1->errorInfo()); 
    }

}

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