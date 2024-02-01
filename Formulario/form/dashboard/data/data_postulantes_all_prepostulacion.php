<?php


function _data_postulantes($id){

  include('cn.php');
  include_once('../dist/include/funciones.php');

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
      p.EMAIL,
      p.CELULAR,
      max(pe.fecha_in) fecha_in,
      if(TIMEDIFF(date_format(NOW(),'%H:%i:%s'),date_format(max(pe.fecha_in),'%H:%i:%s'))<0,
			DATEDIFF(NOW(),max(pe.fecha_in))-1,DATEDIFF(NOW(),max(pe.fecha_in))) tiempo_dias,

      CONCAT(p.etapa, p.estado) estado,
      


      CONCAT(p.etapa, p.estado) ee,
      p.es_rut
      ,ep.fecha femail_pre_postulacion
    FROM 
      unegocios_nuevo.postulacion p
      INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
      LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION
      LEFT JOIN intranet.email_pre_postulacion ep on ep.id_postulacion=p.ID_POSTULACION
      
    WHERE d.ID_DIPLOMA=".$id."
      AND CONCAT(p.etapa, p.estado) IN (01,02,03)
      

      GROUP BY p.ID_POSTULACION,
      p.NOMBRES,
      p.APELLIDO_PAT,
      p.APELLIDO_MAT,
      p.RUT
      
      ORDER BY p.ID_POSTULACION DESC";

  //echo '<pre>'.$sql_postulantes.'</pre>';

  $stmt_postulantes = $con->prepare($sql_postulantes);
  $stmt_postulantes->setFetchMode(PDO::FETCH_ASSOC);
  $stmt_postulantes->execute();

  $total_postulantes = $stmt_postulantes->rowCount();

  //$arr_postulantes=[];
  $arr_postulantes=array();
  
  while ($row = $stmt_postulantes->fetch()){

    

    if($row['es_rut']==1){
      $es_rut_valido = valida_rut($row['RUT']);
    }else{
      $es_rut_valido = true;
    }
    
    $arr_postulantes[]=array(
          "id_postulacion"       => $row['ID_POSTULACION'],
          "nombres"              => utf8_encode($row['NOMBRES']),
          "apellido_pat"         => utf8_encode($row['APELLIDO_PAT']),
          "aprllido_mat"         => utf8_encode($row['APELLIDO_MAT']),
          "rut"                  => $row['RUT'],
          "cv"                   => $row['CV'],
          "fecha_aceptado"       => $row['fecha_in'],
          "estado"               => $row['estado'],
          "tiempo_dias"          => $row['tiempo_dias'],
          "ee"                   => $row['ee'],
          "es_rut"               => $row['es_rut'],
          "es_rut_valido"        => $es_rut_valido,
          "femail_pre_postulacion" => $row['femail_pre_postulacion'],
          "email"                 => $row['EMAIL'],
          "celular"               => $row['CELULAR']
        );

  }

  return $arr_postulantes;
}

function _data_postulantes_nuevos($id){

  include('cn.php');
  include_once('../dist/include/funciones.php');

  if($id==''){
    $id=0;
  }

      $sql_postulantes="SELECT 
      p.ID_POSTULACION,
      p.NOMBRES,
      p.APELLIDO_PAT,
      p.APELLIDO_MAT,
      p.RUT,
      max(pe.fecha_in) fecha_in,
      CONCAT(p.etapa, p.estado) estado,
      concat(p.DIREC_PARTICULAR,' ',p.numero,if(p.depto_of_par<>'',CONCAT(' depto ',p.depto_of_par),''),', ',com.nombre,', ',reg.nombre) direccion,
      com.nombre AS comuna,
      reg.nombre AS region,
      p.NACIONALIDAD,
      p.es_rut,
      p.CV,
      p.EMAIL,
      p.CELULAR
    FROM 
      unegocios_nuevo.postulacion p
      INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
      LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION
      LEFT JOIN intranet.comunas com ON com.cod_comuna=p.COMUNA
      LEFT JOIN  intranet.regiones reg ON reg.cod_region=p.region
    WHERE 
      d.ID_DIPLOMA=".$id."
      AND CONCAT(p.etapa, p.estado) ='00'

    GROUP BY 
      p.ID_POSTULACION,
      p.NOMBRES,
      p.APELLIDO_PAT,
      p.APELLIDO_MAT,
      p.RUT";

    //echo '<pre>'.$sql_postulantes.'</pre>';

    $stmt_postulantes = $con->prepare($sql_postulantes);
    $stmt_postulantes->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_postulantes->execute();

    $total_postulantes = $stmt_postulantes->rowCount();

    
    $arr_postulantes= array();
    while ($row = $stmt_postulantes->fetch()){
      
      $url_img='https://intranet.unegocios.cl/fotos/upload_pic/'.$row['RUT'].'.jpg';
      //if(!is_readable($url_img)){
      if(false){
        $url_img='https://intranet.unegocios.cl/fotos/upload_pic/1-0.jpg';
      }

      $arr_postulantes[]=array(
            "id_postulacion" => $row['ID_POSTULACION'],
            "nombres"        => utf8_encode($row['NOMBRES']),
            "apellido_pat"   => utf8_encode($row['APELLIDO_PAT']),
            "aprllido_mat"   => utf8_encode($row['APELLIDO_MAT']),
            "rut"            => $row['RUT'],
            "fecha_aceptado" => $row['fecha_in'],
            "estado"         => $row['estado'],
            "foto"           => $url_img,
            "direccion"      => $row['direccion'],
            "nacionalidad"   => $row['NACIONALIDAD'],
            "es_rut"         => $row['es_rut'],
            "cv"             => $row['CV'],
            "email"          => $row['EMAIL'],
            "celular"        => $row['CELULAR']
          );

    }
    return $arr_postulantes;
}

?>