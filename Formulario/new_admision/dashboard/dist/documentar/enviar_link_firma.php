<?php
$redes_sociales='<p>S&iacute;guenos en nuestras redes sociales:<br />
<a href="https://www.linkedin.com/company/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/linkedin.png" alt="linkedin" title="linkedin" /></a> 
<a href="https://twitter.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/tweeter.png" alt="twitter" title="twitter" /></a> 
<a href="https://www.facebook.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/facebook.png" alt="facebook" title="facebook" /></a> 
<a href="https://plus.google.com/+unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/gplus.png" alt="google plus" title="google plus" /></a> 
<a href="https://www.youtube.com/user/TvUnegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/youtube.png" alt="youtube" title="youtube" /></a> 
<a href="https://www.instagram.com/unegocios/" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/instagram.png" alt="instagram" title="instagram" /></a> 
..
</p>';


$id_postulacion = isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';

if($id_postulacion == ''){
    echo 'Error';
    exit();
}

include('../../cn/cn_PDO.php');

$sql_data="SELECT 
    CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT) nombre_completo,
    p.EMAIL,
    d.mail_envio,
    d.DIPLOMADO,
    d.nom_cordinadora_admision,
    GROUP_CONCAT(cu.packageID SEPARATOR ',') as packageID
FROM
    unegocios_nuevo.postulacion p
    INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
    INNER JOIN intranet.certinet_upload cu ON p.id_postulacion=cu.id_postulacion
WHERE 
    p.ID_POSTULACION=$id_postulacion
GROUP BY
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.EMAIL,
    d.mail_envio,
    d.DIPLOMADO,
    d.nom_cordinadora_admision";

//echo '<pre>'.$sql_data.'</pre>';

$stmt_data = $con->prepare($sql_data);
$stmt_data->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data->execute();
$num_data = $stmt_data->rowCount();

if($num_data==0){
    echo 'Error';
    exit();
}

if ($row_data = $stmt_data->fetch()){

    $nombre_completo          = utf8_encode($row_data['nombre_completo']);
    $email_postulante         = $row_data['EMAIL'];
    $nom_cordinadora_admision = utf8_encode($row_data['nom_cordinadora_admision']);
    $programa                 = utf8_encode($row_data['DIPLOMADO']);

    $mail_envio               = $row_data['mail_envio'];


    $mensaje   = '<p>Estimado(a) '.$nombre_completo.'.</p>
	<p>Tiene disponible sus documentos para iniciar su proceso de matr&iacute;cula,  '.$programa.'.
	Para revisar y firmar de manera electr&oacute;nica debe ingresar a estos link: </p>
    <ol>
    <li><a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=declaracion" target="_blank" rel="noopener noreferrer">Declaracion Jurada</a></li>
	<li><a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=contrato" target="_blank" rel="noopener noreferrer">Contrato prestaci&oacute;n de servicio</a></li>
    </ol>
	<p>Luego de firmar cada documento de forma digital, debes seleccionar el bot&oacute;n <strong>CLOSE</strong> en la parte superior derecha de tu pantalla para que se genere el pdf final.</p>
	<p>Si tienen problemas con el link comunicate con tu ejecutivo(a) '.$nom_cordinadora_admision.'</p>
	<p>Saludos</p>'.$redes_sociales;


    //===============================================
	$para	= $email_postulante;
	
	$asunto		= "Firma documentos proceso matricula Unegocios";
	
	$remite			= $mail_envio;
	$remitente		= $mail_envio;
	$cc				= $mail_envio; 

	// Asunto<>
	$titulo		= "=?UTF-8?B?".base64_encode($asunto)."=?=";
	 
	// Cuerpo o mensaje
		
		
    $mensaje 	="<font face=\"Arial\">".$mensaje."<p></font>";
        
    // Cabecera que especifica que es un HMTL
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
    // Cabeceras adicionales

    $cabeceras .= "From:".$remitente."<".$remite.">". "\r\n";
    $cabeceras .= 'Cc:'.$cc.'' . "\r\n";
	$cabeceras .= 'Bcc: llevio@fen.uchile.cl,fvaldes@unegocios.cl' . "\r\n";
		
	if(mail($para, $titulo, $mensaje, $cabeceras)){
		echo '- envio ok: '.$para.' '.date('d-m-Y H:i:s').'<br>';
		
        $sql_update="UPDATE 
			intranet.postulacion_descuento
		SET 
			fecha_email=NOW(),
			log_envio='envio ok: ".$para."' 
		where id_postulacion=".$id_postulacion;

	
		$stmt_update = $con->prepare($sql_update);
		$stmt_update ->setFetchMode(PDO::FETCH_ASSOC);
		$stmt_update ->execute();
		$num_update =$stmt_update ->rowCount();	
		
	}else{
        echo 'Error '.date('d-m-Y H:i:s');
    }

}else{
    echo 'Error';
}

?>
