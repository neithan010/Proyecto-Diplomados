<?php
include_once('cn.php');
include_once('../dist/include/funciones.php');

$id =$_REQUEST['id'];

if($id==''){
  $id=0;
}

$sql_postulantes="SELECT 

    p.ID_POSTULACION,
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.APELLIDO_MAT,
    p.RUT,
    p.CV,
    max(pe.fecha_in) fecha_in,
    CONCAT(p.etapa, p.estado) estado,
    
    fd.declaracion_firmado,
    fd.id_declaracion_64_dec5,
    fd.contrato_ps_firmado,
  	fd.id_contrato_ps_64_dec5,
	 
    ef.envio_UA_fecha,
    ef.envio_UA_estado,
    ef.envio_UA_obs,	
    ef.recibido_UA_fecha,
    ef.recibido_UA_estado,
    ef.recibido_UA_obs,	
    ef.aceptado_UA_fecha,
    ef.aceptado_UA_estado,
    ef.aceptado_UA_obs,
    ef.facturado_UA_fecha,
    ef.facturado_UA_estado,
    ef.facturado_UA_obs,
    p.es_rut
	 
  FROM 
    unegocios_nuevo.postulacion p
    INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
    LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION
	  LEFT JOIN intranet.firma_digital fd ON fd.id_postulacion=p.ID_POSTULACION
	  LEFT JOIN intranet.facturas_alumno fa ON fa.id_postulacion=p.ID_POSTULACION
	  LEFT JOIN intranet.estado_facturacion ef  on p.ID_POSTULACION=ef.id_postulacion

  WHERE d.ID_DIPLOMA=".$id."
    AND CONCAT(p.etapa, p.estado) IN (2020,3131)

    GROUP BY p.ID_POSTULACION,
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.APELLIDO_MAT,
    p.RUT";

//echo '<pre>'.$sql_postulantes.'</pre>';

$stmt_postulantes = $con->prepare($sql_postulantes);
$stmt_postulantes->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulantes->execute();

$total_postulantes = $stmt_postulantes->rowCount();


while ($row = $stmt_postulantes->fetch()){

  $url_img='https://intranet.unegocios.cl/fotos/upload_pic/'.$row['RUT'].'.jpg';
  //if(!is_readable($url_img)){
  if(false){
    $url_img='https://intranet.unegocios.cl/fotos/upload_pic/1-0.jpg';
  }
  
  $id_post = $row['ID_POSTULACION'];
  
  if($row['es_rut']==1){
      $es_rut_valido = valida_rut($row['RUT']);
  }else{
    $es_rut_valido = true;
  }

  $arr_postulantes[]=array(
        "id_postulacion"        => $id_post,
        "nombres"               => utf8_encode($row['NOMBRES']),
        "apellido_pat"          => utf8_encode($row['APELLIDO_PAT']),
        "aprllido_mat"          => utf8_encode($row['APELLIDO_MAT']),
        "rut"                   => $row['RUT'],
        "cv"                   => $row['CV'],
        "fecha_aceptado"        => $row['fecha_in'],
        "estado"                => $row['estado'],
        "foto"                  => $url_img,
        "declaracion_firmado"   => $row['declaracion_firmado'],
        "id_declaracion_64_dec5"=> $row['id_declaracion_64_dec5'],
        "contrato_ps_firmado"   => $row['contrato_ps_firmado'],
        "id_contrato_ps_64_dec5"=> $row['id_contrato_ps_64_dec5'],
        "envio_UA_fecha"        => $row['envio_UA_fecha'],
        "envio_UA_estado"       => $row['envio_UA_estado'],
        "envio_UA_obs"          => $row['envio_UA_obs'],
        "recibido_UA_fecha"     => $row['recibido_UA_fecha'],
        "recibido_UA_estado"    => $row['recibido_UA_estado'],
        "recibido_UA_obs"       => $row['recibido_UA_obs'],
        "aceptado_UA_fecha"     => $row['aceptado_UA_fecha'],
        "aceptado_UA_estado"    => $row['aceptado_UA_estado'],
        "aceptado_UA_obs"       => $row['aceptado_UA_obs'],
        "facturado_UA_fecha"    => $row['facturado_UA_fecha'],
        "facturado_UA_estado"   => $row['facturado_UA_estado'],
        "facturado_UA_obs"      => $row['facturado_UA_obs'],
        "es_rut"=> $row['es_rut'],
        "es_rut_valido" => $es_rut_valido
      );

  $sql_firma_certinet="SELECT 
    cu.documento,
    cu.haserror
  FROM 
    intranet.certinet_upload cu
  WHERE 
    cu.id_postulacion=".$id_post;

  $stmt_firma_certinet = $con->prepare($sql_firma_certinet);
  $stmt_firma_certinet->setFetchMode(PDO::FETCH_ASSOC);
  $stmt_firma_certinet->execute();

  $total_firma_certinet = $stmt_firma_certinet->rowCount();
//echo $total_firma_certinet.' :: '.$id_post.'<br>';

$arr_firma_certinet[$id_post]=array();

  while ($rows = $stmt_firma_certinet->fetch()){
    $arr_firma_certinet[$id_post][]=array(
      "documento"=>$rows['documento'],
      "haserror"=>$rows['haserror']
    );
  }



}



?>