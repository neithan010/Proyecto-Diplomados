<?php
/** 27-03-2023 12:46 LL */
/*
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
    CONCAT(p.etapa, p.estado) ee,
    p.es_rut
    ,db.fecha AS fecha_descarga_bruchure
     ,max(ep.fecha) femail_pre_postulacion
,p.periodo
,
(
SELECT
GROUP_CONCAT(p2.POSTULACION SEPARATOR '|') as otra_pos
  
FROM
   intranet.descarga_bruchure db2
   inner JOIN intranet.diplomados d2 ON db2.cod_diploma=d2.cod_diploma
   INNER JOIN unegocios_nuevo.postulacion p2 ON p2.ID_POSTULACION=db2.id_postulacion
   LEFT JOIN intranet.email_pre_postulacion ep2 on ep2.id_postulacion=p2.ID_POSTULACION
where
   p2.RUT=p.RUT
   AND p2.periodo=p.periodo
   AND d2.ID_DIPLOMA<>d.ID_DIPLOMA
    ) AS otra_pos
    
  FROM
      intranet.descarga_bruchure db
      inner JOIN intranet.diplomados d ON db.cod_diploma=d.cod_diploma
      INNER JOIN unegocios_nuevo.postulacion p ON p.ID_POSTULACION=db.id_postulacion
      LEFT JOIN intranet.email_pre_postulacion ep on ep.id_postulacion=p.ID_POSTULACION
 where
      d.ID_DIPLOMA=".$id."
      
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
          "email"                => $row['EMAIL'],
          "celular"              => $row['CELULAR'],
          "fecha_aceptado"       => $row['fecha_in'],
          "estado"               => $row['estado'],
          "tiempo_dias"          => $row['tiempo_dias'],
          "ee"                   => $row['ee'],
          "es_rut"               => $row['es_rut'],
          "es_rut_valido"        => $es_rut_valido,
          "fecha_descarga_bruchure" => $row['fecha_descarga_bruchure'],
          "femail_pre_postulacion" => $row['femail_pre_postulacion'],
          "otra_pos"               => $row['femail_pre_postulacion']
        );

  }

  return $arr_postulantes;
}
*/
function _data_postulantes_brouchure($id){

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
        CONCAT(p.etapa, p.estado) ee,
        p.es_rut
        ,db.fecha AS fecha_descarga_bruchure
         ,max(ep.fecha) femail_pre_postulacion
  ,p.periodo
  ,
  (
  SELECT
    GROUP_CONCAT(p2.POSTULACION SEPARATOR '|') as otra_pos
      
   FROM
       intranet.descarga_bruchure db2
       inner JOIN intranet.diplomados d2 ON db2.cod_diploma=d2.cod_diploma
       INNER JOIN unegocios_nuevo.postulacion p2 ON p2.ID_POSTULACION=db2.id_postulacion
       LEFT JOIN intranet.email_pre_postulacion ep2 on ep2.id_postulacion=p2.ID_POSTULACION
  where
       p2.RUT=p.RUT
       AND p2.periodo=p.periodo
       AND d2.ID_DIPLOMA<>d.ID_DIPLOMA
        ) AS otra_pos
        
      FROM
          intranet.descarga_bruchure db
          inner JOIN intranet.diplomados d ON db.cod_diploma=d.cod_diploma
          INNER JOIN unegocios_nuevo.postulacion p ON p.ID_POSTULACION=db.id_postulacion
          LEFT JOIN intranet.email_pre_postulacion ep on ep.id_postulacion=p.ID_POSTULACION
     where
          d.ID_DIPLOMA=".$id."
          
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

    
    $arr_postulantes= array();
    while ($row = $stmt_postulantes->fetch()){
      
      $url_img='https://intranet.unegocios.cl/fotos/upload_pic/'.$row['RUT'].'.jpg';
      //if(!is_readable($url_img)){
      if(false){
        $url_img='https://intranet.unegocios.cl/fotos/upload_pic/1-0.jpg';
      }

      if($row['es_rut']==1){
        //$rut = preg_replace("[^A-Za-z0-9]", "", $row['RUT']);
        $rut = trim(preg_replace('/[^0-9kK]/','',$row['RUT']));
        if($rut<>''){
          $es_rut_valido = valida_rut($rut);
        }else{
          $es_rut_valido = false;
        }
      }else{
        $es_rut_valido = true;
      }

      
      switch ($row['ee']) {
        case '01':
        case '02':
          $estado = "Pre postulacion";
            break;
        case '00':
          $estado = "Nueva";
            break;
        case '1030':
          $estado = "En evaluacion";
            break;
        case '1010':
          $estado = "Eliminada";
            break;
        case '2020':
          $estado = "Aceptado";
          break;
        case '2030':
          $estado = "Rechazado";
          break;
        case '2040':
            $estado = "Pendiente Entrevista";
            break;
          case '3030':
            $estado = "Matriculado";
              break;
          case '3131':
            $estado = "Matriculado pendiente cierre";
              break;
        default:
          $estado = $row['ee'];
      }
      $arr_postulantes[]=array(
            "id_postulacion" => $row['ID_POSTULACION'],
            "nombres"        => utf8_encode($row['NOMBRES']),
            "apellido_pat"   => utf8_encode($row['APELLIDO_PAT']),
            "aprllido_mat"   => utf8_encode($row['APELLIDO_MAT']),
            "rut"            => $row['RUT'],
            "email"          => $row['EMAIL'],
            "celular"        => $row['CELULAR'],
            "fecha_aceptado" => $row['fecha_descarga_bruchure'],
            "estado"         => $estado,
       
           
            "es_rut"         => $row['es_rut'],
            "es_rut_valido"        => $es_rut_valido,
            "cv"             => $row['CV'],
            "fecha_descarga_bruchure" => $row['fecha_descarga_bruchure'],
            "femail_pre_postulacion" => $row['femail_pre_postulacion'],
            "otra_pos"               => utf8_encode($row['otra_pos'])
          );

    }

    $sql_descarga2="SELECT 

    d.id_postulacion, 
    d.cod_diploma, 
    d.programa, 
    d.rut, 
    d.nombres, 
    d.apellidos, 
    d.rut_ejc_admision, 
    d.email, 
    d.celular, 
    d.fecha,
    
    ( select GROUP_CONCAT(d2.programa SEPARATOR '|') as otra_descarga 
      FROM intranet.descarga_bruchure d2
  
     
     WHERE 
    d2.fecha>='2023-06-23 15:07:30'
    AND d.cod_diploma <> d2.cod_diploma
    AND d.email = d2.email
    
    ) as otra_descarga 
    
     FROM intranet.descarga_bruchure d
     LEFT JOIN unegocios_nuevo.postulacion p ON p.RUT=d.rut AND d.cod_diploma=p.cod_diploma
     INNER JOIN intranet.diplomados dp ON dp.cod_diploma=d.cod_diploma 
     WHERE d.fecha>='2023-06-23 15:07:30'
     AND dp.ID_DIPLOMA=".$id;

    $stmt_postulantes2 = $con->prepare($sql_descarga2);
    $stmt_postulantes2->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_postulantes2->execute();

    $total_postulantes2 = $stmt_postulantes2->rowCount();

    while ($row = $stmt_postulantes2->fetch()){
      $arr_postulantes[]=array(
        "id_postulacion" => $row['id_postulacion'],
        "nombres"        => utf8_encode($row['nombres']),
        "apellido_pat"   => utf8_encode($row['apellidos']),
        "aprllido_mat"   => '',
        "rut"            => $row['rut'],
        "email"          => $row['email'],
        "celular"        => $row['celular'],
        "fecha_aceptado" => $row['fecha'],
        "estado"         => '',
   
       
        "es_rut"         => '',
        "es_rut_valido"        => '',
        "cv"             => '',
        "fecha_descarga_bruchure" => $row['fecha'],
        "femail_pre_postulacion" => '',
        "otra_pos"               => utf8_encode($row['otra_descarga'])
      );
    }




//echo '<pre>'.print_r($arr_postulantes, true).'</pre>';
    return $arr_postulantes;
}

?>