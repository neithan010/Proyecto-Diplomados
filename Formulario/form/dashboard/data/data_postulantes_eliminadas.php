<?php
include_once('cn.php');

$id =preg_replace("[^A-Za-z0-9]", "", $_REQUEST['id']);


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
  FROM 
    unegocios_nuevo.postulacion p
    INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
    LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION
  WHERE d.ID_DIPLOMA=".$id."
    AND CONCAT(p.etapa, p.estado) = '1010'

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

//$arr_postulantes=[];
 
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
        "fecha_eliminada" => $row['fecha_in'],
        "estado"         => $row['estado'],
        "foto"           => $url_img
      );

}


?>