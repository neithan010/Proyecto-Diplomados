<?php
include('../../cn/cn_PDO.php');

$id_postulacion		= $_REQUEST['id_postulacion'];
$id_financiamiento	= $_REQUEST['id_financiamiento'];
$moneda_pago		= $_REQUEST['moneda_pago'];

$monto_tc1_link_pago='';
if(isset($_REQUEST['monto_tc1_link_pago'])){
    $monto_tc1_link_pago = str_replace(".","",$_REQUEST['monto_tc1_link_pago']);
}
$monto_tc2_link_pago='';
if(isset($_REQUEST['monto_tc2_link_pago'])){
    $monto_tc2_link_pago = str_replace(".","",$_REQUEST['monto_tc2_link_pago']);
}

$monto_usd_link_pago='';
if(isset($_REQUEST['monto_usd_link_pago'])){
    $monto_usd_link_pago = str_replace(".","",$_REQUEST['monto_usd_link_pago']);
    $monto_usd_link_pago = str_replace(",",".",$monto_usd_link_pago);
}

$num_link_tc=0;
if(isset($_REQUEST['num_link_tc'])){
    $num_link_tc = $_REQUEST['num_link_tc'];

}
//-----------------------------
$sql_data = "INSERT INTO intranet.postulacion_data_pagos
		(id_postulacion, id_financiamiento, moneda_pago, monto_tc1_link_pago, monto_tc2_link_pago, monto_usd_link_pago)
	VALUES
		(".$id_postulacion.", '".$id_financiamiento."', '".$moneda_pago."', '".$monto_tc1_link_pago."', '".$monto_tc2_link_pago."', '".$monto_usd_link_pago."')
	ON DUPLICATE KEY UPDATE
    	id_financiamiento='".$id_financiamiento."', 
    	moneda_pago='".$moneda_pago."', 
    	monto_tc1_link_pago='".$monto_tc1_link_pago."',
    	monto_tc2_link_pago='".$monto_tc2_link_pago."', 
    	monto_usd_link_pago='".$monto_usd_link_pago."'";

$sql_data = str_replace("''","NULL", $sql_data);
$sql_data = str_replace("'undefined'","NULL", $sql_data);


echo '<pre>'.$sql_data.'</pre>';

$stmt_data = $con->prepare($sql_data);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();
$num_stmt_data =$stmt_data ->rowCount();	

//-----------------------------------------
$sql_existe_registro="SELECT GROUP_CONCAT(pd.id_pago SEPARATOR ',') as ids_pagos
FROM 
	intranet.pagos_diferido pd 
	inner JOIN intranet.pagos_diferido_recibidos pdr ON pdr.id_pago=pd.id_pago AND pdr.`status`='AUTHORIZED' AND pdr.corregido IS null
WHERE 
pd.id_postulacion=".$id_postulacion;

//echo '<pre>'.$sql_existe_registro.'</pre>';

$stmt_existe_registro = $con->prepare($sql_existe_registro);
$stmt_existe_registro ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_existe_registro ->execute();
$num_existe_registro =$stmt_existe_registro ->rowCount();	


$ids_pagos='';
if ($row_existe_registro  = $stmt_existe_registro ->fetch()){
	$ids_pagos=$row_existe_registro ['ids_pagos'];
}


$sql_data_postulante="SELECT 
	p.RUT AS usuario,
	MD5(CONCAT('wp',p.ID_POSTULACION)) AS clave,
	CONCAT_WS(' ',p.NOMBRES, p.APELLIDO_PAT, p.APELLIDO_MAT) AS nombre,
	p.RUT AS rut,
	CONCAT_WS(' ',p.DIREC_PARTICULAR, '#', p.numero,', ', com.nombre,', ', reg.nombre) AS direccion,
	p.EMAIL AS email,
	p.POSTULACION AS programa,
	d.mail_envio AS email_responsable,
	pdr.status
FROM 
	unegocios_nuevo.postulacion p 
	LEFT JOIN unegocios_nuevo.comunas com ON p.COMUNA=com.cod_comuna
	LEFT JOIN unegocios_nuevo.regiones reg ON p.region=reg.cod_region
	INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
	LEFT JOIN intranet.pagos_diferido pd ON pd.id_postulacion=p.ID_POSTULACION
	LEFT JOIN intranet.pagos_diferido_recibidos pdr ON pdr.id_postulacion=pd.id_postulacion AND pdr.id_pago=pd.id_pago and pdr.corregido is null
WHERE p.ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_data_postulante.'</pre>';

$stmt_data_postulante = $con->prepare($sql_data_postulante);
$stmt_data_postulante ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data_postulante ->execute();
$num_data_postulante =$stmt_data_postulante ->rowCount();	
//echo '::'.$num_data_postulante;

$status='';
if ($row_data_postulante  = $stmt_data_postulante ->fetch()){
	$usuario	= $row_data_postulante['usuario'];
	$clave		= $row_data_postulante['clave'];
	$nombre		= $row_data_postulante['nombre'];
	$rut		= $row_data_postulante['rut'];
	$direccion	= utf8_decode($row_data_postulante['direccion']);
	$email		= $row_data_postulante['email'];
	$producto	= $row_data_postulante['programa'];
	
	$email_responsable=$row_data_postulante['email_responsable'];
	$status	= $row_data_postulante['status'];
	
}
if($status=='' || $status<>'AUTHORIZED'){
	$sql_dell="DELETE FROM intranet.pagos_diferido 
		WHERE id_postulacion=".$id_postulacion."
		AND id_pago NOT IN (".$ids_pagos.")";
		
	$stmt_dell = $con->prepare($sql_dell);
	$stmt_dell ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_dell ->execute();
}

if($moneda_pago <> 'USD'){
	$sql_data = "INSERT INTO intranet.pagos_diferido
			(tc, id_postulacion, usuario, clave, nombre, rut, direccion, email, producto, monto, fecha, email_responsable)
		VALUES
		($num_link_tc, $id_postulacion, '".$usuario."','".$clave."','".$nombre."','".$rut."','".$direccion."','".$email."','".$producto."','".$monto_tc1_link_pago."',NOW(),'".$email_responsable."')";
	/*
	if($monto_tc2_link_pago > 0){
		$sql_data .=",($id_postulacion, '".$usuario."','".$clave."','".$nombre."','".$rut."','".$direccion."','".$email."','".$producto."','".$monto_tc2_link_pago."',NOW(),'".$email_responsable."')";
	}
	*/

	$sql_data = str_replace("''","NULL", $sql_data);
	$sql_data = str_replace("'undefined'","NULL", $sql_data);


	//echo '<pre>'.$sql_data.'</pre>';

	$stmt_data = $con->prepare($sql_data);
	$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data ->execute();
	$num_stmt_data =$stmt_data ->rowCount();	
}
//----------------------------------------------------

if($moneda_pago=='USD'){
	

	$sql_postulacion_desceunto="INSERT INTO intranet.postulacion_descuento
	(id_postulacion, cod_diploma, diploma, moneda, valor, desc_promocion, desc_aplicable, DE_aplicable, letra_aplicable, desc_excepcional, DE_excepcional, letra_excepcional, desc_excep2, DE_excep2, letra_excep2, total_descuento, orden_compra, fecha, usuario, clave)
		SELECT 
			p.ID_POSTULACION,
			p.cod_diploma,
			p.POSTULACION,
			'$moneda_pago' AS moneda, 
			'$monto_usd_link_pago' AS monto, 
			0, 
			0, 
			0,
			0, 
			0, 
			0, 
			0, 
			0, 
			0, 
			0, 
			0, 
			0, 
			NOW(), 
			p.rut,
			CONCAT('pay',p.ID_POSTULACION) AS clave
		FROM unegocios_nuevo.postulacion p 
		WHERE p.ID_POSTULACION=$id_postulacion
	ON DUPLICATE KEY UPDATE
		moneda='USD', 
		valor='$monto_usd_link_pago', 
		desc_promocion=0, 
		desc_aplicable=0, 
		DE_aplicable=0, 
		letra_aplicable=0, 
		desc_excepcional=0, 
		DE_excepcional=0, 
		letra_excepcional=0, 
		desc_excep2=0, 
		DE_excep2=0, 
		letra_excep2=0, 
		total_descuento=0, 
		orden_compra=0, 
		fecha =NOW() 
	";
	echo '<pre>'.$sql_postulacion_desceunto.'</pre>';

	$stmt_pd = $con->prepare($sql_postulacion_desceunto);
	$stmt_pd ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_pd ->execute();
	$stmt_pd =$stmt_pd ->rowCount();	

}


?>