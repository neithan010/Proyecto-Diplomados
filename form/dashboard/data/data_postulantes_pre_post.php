<?php
/** 27-03-2023 12:46 LL */
include_once('cn.php');

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
    max(pe.fecha_in) fecha_in,
    CONCAT(p.etapa, p.estado) estado
    , (unix_timestamp(NOW()) - unix_timestamp(max(pe.fecha_in)))/(24*60*60) dias
    ,ep.fecha femail_pre_postulacion
  FROM 
    unegocios_nuevo.postulacion p
    INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
    LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION
    left join intranet.email_pre_postulacion ep on ep.id_postulacion=p.ID_POSTULACION
  WHERE d.ID_DIPLOMA=".$id."
    AND CONCAT(p.etapa, p.estado) IN (01,02,03)

  GROUP BY p.ID_POSTULACION,
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.APELLIDO_MAT,
    p.RUT
    
  ORDER BY p.FECHA_POST DESC";

//echo '<pre>'.$sql_postulantes.'</pre>';

$stmt_postulantes = $con->prepare($sql_postulantes);
$stmt_postulantes->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulantes->execute();

$total_postulantes = $stmt_postulantes->rowCount();


while ($row = $stmt_postulantes->fetch()){
  $arr_postulantes[]=array(
        "id_postulacion" => $row['ID_POSTULACION'],
        "nombres"        => utf8_encode($row['NOMBRES']),
        "apellido_pat"   => utf8_encode($row['APELLIDO_PAT']),
        "aprllido_mat"   => utf8_encode($row['APELLIDO_MAT']),
        "rut"            => $row['RUT'],
        "fecha_aceptado" => $row['fecha_in'],
        "estado"         => $row['estado'],
        "dias"           => $row['dias'],
        "femail_pre_postulacion" => $row['femail_pre_postulacion']
      );

}


?>