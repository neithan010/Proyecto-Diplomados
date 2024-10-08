<?php
include('../../cn/cn_PDO.php');

$id_postulacion		= $_REQUEST['id_postulacion'];
//$id_financiamiento	= $_REQUEST['id_financiamiento'];
//$moneda_pago		= $_REQUEST['moneda_pago'];


//--------------
function eliminar_tildes($cadena){
    $cadena = utf8_encode($cadena);
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}

$sql_datos="SELECT 
		p.NOMBRES, p.APELLIDO_PAT, p.APELLIDO_MAT,
		p.POSTULACION,
		pd.usuario,
		pd.clave,
		p.EMAIL,
		d.mail_envio,
		d.nom_cordinadora_admision,
		d.telefono_cordinadora_admision,
		case
			when d.tipo like 'curso%' THEN 'curso'
			when d.tipo='B-Learing' and LEFT(d.cod_diploma,1)<>'D' THEN 'curso'
			else d.tipo
		end tipo_programa,
		IF(u.genero='masculino','ejecutivo','ejecutiva') AS genero_ej
	FROM 
		intranet.postulacion_descuento pd
		inner join unegocios_nuevo.postulacion p on pd.id_postulacion=p.ID_POSTULACION
		inner join intranet.diplomados d on pd.cod_diploma=d.cod_diploma and p.cod_diploma=d.cod_diploma
		INNER JOIN intranet.usuarios_int u ON (u.usr = d.usr_cordinador_ad)
	WHERE
		pd.id_postulacion=".$id_postulacion;

$stmt_datos = $con->prepare($sql_datos);
$stmt_datos ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_datos ->execute();
$num_datos =$stmt_datos ->rowCount();	
//echo '::'.$num_postulantea;

if ($row_rs_datos  = $stmt_datos ->fetch()){

    $postulacion					= $row_rs_datos['POSTULACION'];
    $nombre_completo				= $row_rs_datos['NOMBRES'].' '.$row_rs_datos['APELLIDO_PAT'];
    $usuario						= $row_rs_datos['usuario'];
    $clave							= $row_rs_datos['clave'];
    $email_postulante				= $row_rs_datos['EMAIL'];
    $mail_ejecutivo					= $row_rs_datos['mail_envio'];
    $nom_cordinadora_admision		= $row_rs_datos['nom_cordinadora_admision'];
    $telefono_cordinadora_admision	= $row_rs_datos['telefono_cordinadora_admision'];
    $tipo_programa					= $row_rs_datos['tipo_programa'];
    $genero_ej						= $row_rs_datos['genero_ej'];

}
if($mail_ejecutivo==''){
	$mail_ejecutivo='llevio@unegocios.cl';
}
//--------------------------------------------------
// TEXTO Redes sociales
//--------------------------------------------------
$redes_sociales='<p>S&iacute;guenos en nuestras redes sociales:<br />
	<a href="https://www.linkedin.com/company/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/linkedin.png" alt="linkedin" title="linkedin" /></a> 
    <a href="https://twitter.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/tweeter.png" alt="twitter" title="twitter" /></a> 
    <a href="https://www.facebook.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/facebook.png" alt="facebook" title="facebook" /></a> 
    <a href="https://plus.google.com/+unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/gplus.png" alt="google plus" title="google plus" /></a> 
    <a href="https://www.youtube.com/user/TvUnegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/youtube.png" alt="youtube" title="youtube" /></a> 
	<a href="https://www.instagram.com/unegocios/" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/instagram.png" alt="instagram" title="instagram" /></a> 
	..
</p>';

if($tipo_programa=='B-Learing' || $tipo_programa=='curso'){
	
	$email='<p>Estimado(a) '.eliminar_tildes($nombre_completo).'</p>
	<p><strong>&#161;Bienvenido a Unegocios de la Universidad de Chile!</strong></p>

	<p>Hemos recibido tus antecedentes correctamente, y has sido <strong>ACEPTADO</strong> en nuestro programa.</p>
	<p>Los pasos  para quedar matriculado y asegurar tu cupo, son:</p>
	<p>1. Firmar los documentos enviados a tu correo en forma digital vía DEC </p>
	<p>Los documentos para firma digital fueron enviados a tu correo , de no haberlos recibido comuníquese con el ejecutivo a cargo. </p>
	<p>2.- Después de firmar los documentos ingresar al link webpay para hacer el pago del programa y así asegurar tu cupo</p>

	<p>Existen distintas <strong>Formas de Pago</strong> y puedes escoger la que m&aacute;s te acomode:</p>
	<p>1. <strong>Webpay</strong>, te invitamos a pagar tu matr&iacute;cula de forma segura y c&oacute;moda a trav&eacute;s de Webpay, para ello debes ingresar al siguiente link https://pagos.unegocios.cl/ con el usuario <strong>'.$usuario.'</strong> y la clave <strong>'.$clave.'</strong><br />
	<strong>Debes completar el proceso, descargar y conservar tu comprobante.</strong></p>
	<p><strong>* Te informamos que debido a la cantidad de transacciones que se realizan con los programas, es posible que el sistema tenga intermitencia, esto significa que al realizar el pago puede que la página indique error o bien se muestre en blanco. Esto no quiere decir que el pago no se haya realizado, por lo que te solicitamos contactarte inmediatamente con tu ejecutivo para que se revise internamente y confirmar, por favor no insistir en la transacción ya que puede quedar duplicado el cobro.</strong></p>
	
	<p>2. V&iacute;a <strong>Transferencia Bancaria</strong> a la cuenta corriente del banco Santander de la Universidad de Chile, n&uacute;mero 67114949, Rut 60.910.000-1 y enviar comprobante de pago a '.eliminar_tildes($nom_cordinadora_admision).'. </p>
	<p>3.- Si la inscripción es financiada por tu empresa debes solicitar al ejecutivo a cargo del curso el envío del  proceso de pago empresa,  datos para OC y envío de formato Carta Compromiso</p>
	<p>Ante cualquier <strong>comentario o consulta</strong>, no dudes en contactar a tu '.ucfirst($genero_ej).' '.eliminar_tildes($nom_cordinadora_admision).' al tel&eacute;fono '.$telefono_cordinadora_admision.' y/o al correo electr&oacute;nico '.$mail_ejecutivo.' para que te pueda ayudar a la brevedad ¡ Y no te quedes sin tu cupo !</p>
	<p>Para conocer la <strong>normativa que rige nuestros programas,</strong> puedes revisar en este link el Reglamento: <a href="https://unegocios.uchile.cl/reglamento/" target="_blank">ver reglamento</a>.<br />
	Al momento de concretar el pago aceptas todas las condiciones de nuestro reglamento y contrato.</p>
	<p>El Centro de Desarrollo Gerencial, est&aacute; adem&aacute;s comprometido con el medio ambiente, es por esto que la Facultad en conjunto a ECOFEN, est&aacute;n impulsando el proyecto de Campus Sustentable. Algunas de las medidas que el Centro ha adoptado es la no entrega de bibliograf&iacute;a impresa, entre otras actividades, las cuales puedes informarte aqu&iacute;. (<a href="https://unegocios.uchile.cl/ecofen/" target="_blank">https://unegocios.uchile.cl/ecofen/</a>)</p>
	<p>&nbsp;</p>
	<p>Recibe un muy cordial saludo.</p>
	<p>Atentamente,<br />
	  UNEGOCIOS - FEN<br />
	  Universidad de Chile.</p>'.$redes_sociales;
	
}else{
	$email='<p>Estimado(a) '.eliminar_tildes($nombre_completo).'</p>
	<p><strong>&#161;Bienvenido a Unegocios de la Universidad de Chile!</strong></p>
	<p>Hemos recibido tus antecedentes correctamente, por lo que te invitamos a pagar tu matr&iacute;cula de forma segura y c&oacute;moda a trav&eacute;s de webpay, 
	para ello debes ingresar al siguiente link https://pagos.unegocios.cl/ 
	con el usuario <strong>'.$usuario.'</strong> y la clave <strong>'.$clave.'</strong><br>
	Es importante que una vez finalizado el proceso de pago, descargues y env&iacute;es el comprobante a tu '.$genero_ej.'.</p>

	<p><strong>* Te informamos que debido a la cantidad de transacciones que se realizan con los programas, es posible que el sistema tenga intermitencia, esto significa que al realizar el pago puede que la página indique error o bien se muestre en blanco. Esto no quiere decir que el pago no se haya realizado, por lo que te solicitamos contactarte inmediatamente con tu ejecutivo para que se revise internamente y confirmar, por favor no insistir en la transacción ya que puede quedar duplicado el cobro.</strong></p>
	 
		  <p>
		  Tambi&eacute;n puedes pagar v&iacute;a transferencia bancaria a la cuenta corriente del banco Santander  de la Universidad de Chile, n&uacute;mero 67114949, Rut 60.910.000-1 
		  y enviar comprobante de pago a <a href="mailto:'.$mail_ejecutivo.'">'.$mail_ejecutivo.'</a>.
		  </p>
		  
		  <p>
		  Ante cualquier comentario o consulta, no dudes en contactar tu  '.$genero_ej.' '.eliminar_tildes($nom_cordinadora_admision).' al tel&eacute;fono '.$telefono_cordinadora_admision.' y/o al correo  electr&oacute;nico 
		  <a href="mailto:'.$mail_ejecutivo.'">'.$mail_ejecutivo.'</a>.<br>
		  <br>
		  Recibe un muy cordial saludo.<br>
		  <br>
		  Atentamente,<br>
		  Centro de Desarrollo  Gerencial<br>
		Universidad de Chile.</p>'.$redes_sociales;
}

	$destinatiario	= $email_postulante;//"llevio@unegocios.cl";
	//$destinatiario	= "llevio@unegocios.cl";
	
	//$asunto		= "Información Postulación: ".$programa.", Universidad de Chile";
	$asunto		= "Link de Pago WEBPAY – Universidad de Chile";
	//$asunto		= "=?UTF-8?B?".base64_encode($asunto)."=?=";
	
	
	$remite			= $mail_ejecutivo; //"intranet@unegocios.cl";
	$remitente		= $mail_ejecutivo; //"intranet@unegocios.cl";
	$cc				= $mail_ejecutivo; 

		$para  = $destinatiario; 
		 
		// Asunto<>
		$titulo		= "=?UTF-8?B?".base64_encode($asunto)."=?=";
		 
		// Cuerpo o mensaje
		
		
		$mensaje 	="<font face=\"Arial\">".$email."<p></font>";
		 
		// Cabecera que especifica que es un HMTL
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		 
		// Cabeceras adicionales

		$cabeceras .= "From:".$remitente."<".$remite.">". "\r\n";
	   	$cabeceras .= 'Cc:'.$cc.'' . "\r\n";
		//$cabeceras .= 'Bcc: intranet@fen.uchile.cl,anunez@unegocios.cl,fvaldes@unegocios.cl' . "\r\n";
		$cabeceras .= 'Bcc: intranet@unegocios.cl' . "\r\n";
		
	if(mail($para, $titulo, $mensaje, $cabeceras)){
		echo '- envio ok: '.$para.'<br>';
		$sql_update="UPDATE 
			intranet.postulacion_descuento
		SET 
			fecha_email=NOW(),
			log_envio='envio ok: ".$para."' 
		where id_postulacion=".$id_postulacion;

		//mysql_query($sql_update, $cn_intranet) or die(mysql_error());
		$stmt_update = $con->prepare($sql_update);
		$stmt_update ->setFetchMode(PDO::FETCH_ASSOC);
		$stmt_update ->execute();
		$num_update =$stmt_update ->rowCount();	
		
	}else{
		echo 'envio ERROR: '.$para.'<br>';

		$sql_update="UPDATE 
				intranet.postulacion_descuento
			SET 
				fecha_email=".date('%Y-%m-%d')."
				log_envio='envio ERROR: ".$para."' 
			where id_postulacion=".$id_postulacion;
			//mysql_query($sql_update, $cn_intranet) or die(mysql_error());
			
			$stmt_update = $con->prepare($sql_update);
			$stmt_update ->setFetchMode(PDO::FETCH_ASSOC);
			$stmt_update ->execute();
			$num_update =$stmt_update ->rowCount();	

		//--------------------------------------
		// Si existe error en el envio me aviso.
		//--------------------------------------	
		mail("llevio@unegocios.cl", "Error envio clave pago webpay", "Error envio clave pago webpay para ".$para);
		
	}


?>