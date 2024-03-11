<?php
include('../../cn/cn_PDO.php');

$id_postulacion		= $_REQUEST['id_postulacion'];

$num_envio_link_pago= ($_REQUEST['num_envio_link_pago']+1);


$monto_tc1_link_pago='';
if(isset($_REQUEST['monto_tc1'])){
    $monto_tc1_link_pago = str_replace(".","",$_REQUEST['monto_tc1']);
}
/*
$monto_tc2_link_pago='';
if(isset($_REQUEST['monto_tc2_link_pago'])){
    $monto_tc2_link_pago = str_replace(".","",$_REQUEST['monto_tc2_link_pago']);
}
*/
$sql_data="SELECT 
    p.RUT AS usuario,
    md5(concat(p.ID_POSTULACION,'wp',".$num_envio_link_pago.")) AS clave,
    CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,p.APELLIDO_MAT) AS nombre,
    p.RUT,
    CONCAT(
        p.DIREC_PARTICULAR,' ',
        p.numero,' ',
        if(p.depto_of_par<>'',CONCAT('depto.', p.depto_of_par,', '),','),
        com.nombre,', ',
        reg.nombre
        ) AS direccion,
    p.EMAIL,
    p.POSTULACION,
    d.mail_envio AS email_esponsable

FROM 
    unegocios_nuevo.postulacion p
    INNER JOIN unegocios_nuevo.comunas com ON p.COMUNA=com.cod_comuna
    INNER JOIN unegocios_nuevo.regiones reg ON p.region=reg.cod_region
    INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
WHERE 
    p.ID_POSTULACION=".$id_postulacion;

    $rs = $con->prepare($sql_data);
$rs->execute();
$num_rs=$rs->rowCount();


if ($rws = $rs->fetch()){

    $usuario=$rws['usuario'];
    $clave=$rws['clave'];
    $nombre=$rws['nombre'];
    $rut=$rws['RUT'];
    $direccion=$rws['direccion'];
    $email=$rws['EMAIL'];
    $producto=$rws['POSTULACION'];
    $email_responsable=$rws['email_esponsable'];
   
}

$sql_in="INSERT INTO intranet.pagos_diferido (
    tc, id_postulacion, usuario, clave, nombre, rut, direccion, email, producto, monto, fecha, email_responsable
) VALUES (
    $num_envio_link_pago,
    $id_postulacion,
    '$usuario',
    '$clave',
    '$nombre',
    '$rut',
    '$direccion',
    '$email',
    '$producto', 
    $monto_tc1_link_pago, 
    NOW(), 
    '$email_responsable'

)";

echo '<pre>'.$sql_in.'</pre>';

$rs_in = $con->prepare($sql_in);
$rs_in->execute();
$num_in=$rs_in->rowCount();

?>