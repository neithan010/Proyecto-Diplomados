<?php
include('../cn/cn_PDO.php');

$rut            = $_REQUEST['rut'];
$nombre         = utf8_decode($_REQUEST['nombre']);
$apellido_pat   = utf8_decode($_REQUEST['apellido_pat']);
$apellido_mat   = utf8_decode($_REQUEST['apellido_mat']);
$email          = $_REQUEST['email'];
$celular        = $_REQUEST['celular'];
$calle          = utf8_decode($_REQUEST['calle']);
$numero         = $_REQUEST['numero'];
$depto_of       = $_REQUEST['depto_of'];
$comuna         = utf8_decode($_REQUEST['comuna']);
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
$celular        = $_REQUEST['celular'];
$id_postulacion = $_REQUEST['id_postulacion'];
$genero         = $_REQUEST['genero'];
$ex_alumno      = $_REQUEST['ex_alumno'];

$direccion = $calle.' '.$numero;
if($depto_of<>''){
    $direccion .= $depto_of;
}
// $direccion .=$comuna

$sql_update = "UPDATE unegocios_nuevo.postulacion
SET
    RUT='$rut',
    NOMBRES='$nombre',
    APELLIDO_PAT='$apellido_pat',
    APELLIDO_MAT='$apellido_mat',
    DIREC_PARTICULAR='$calle',
    numero='$numero',
    depto_of_par='$depto_of',
    comuna='$comuna', 
    EMAIL='$email', 
    FECHA_NAC='$fecha_nacimiento', 
    CELULAR='$celular'
WHERE
    ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_update.'</pre>';

$stmt_update = $con->prepare($sql_update);
$stmt_update->setFetchMode(PDO::FETCH_ASSOC);
$stmt_update->execute();
$num_update = $stmt_update->rowCount();	

?>
<p class="lh-lg">

  Rut: <?php echo $rut;?><br>
  Nombres: <?php echo utf8_encode($nombre);?><br>
  Apellidos: <?php echo utf8_encode($apellido_pat.' '.$apellido_mat);?><br>
  Genero: <?php echo $genero;?><br>
  Fecha Nacimiento: <?php echo date("d-m-Y", strtotime($fecha_nacimiento));?><br>
  Email: <?php echo $email;?><br>
  Telefono: <?php echo $celular;?><br>
  Direccion: <?php echo utf8_encode($direccion);?><br>
  Ex alumno: <?php if($ex_alumno==1){echo 'Si';}else{echo 'No';} ?><br>
  </p>
  <button class="btn btn-primary btn-sm" id="btn_editar">Editar</button>