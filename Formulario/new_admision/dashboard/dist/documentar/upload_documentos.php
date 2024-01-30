<?php

function wsUploadArch($Archivo64, $rut, $firmantes, $tag, $ins, $nax, $form_id, $doc_fd){
	
	$fSize=strlen(base64_decode($Archivo64));
	
	
	//$Url = 'http://200.0.156.150/cgi-bin/autentia-docs2.cgi';
	$Url = 'http://dec3.acepta.com/cgi-bin/autentia-docs2.cgi';
	try {
		$ops = array('location' => $Url, 'uri' => 'urn:wsdocs'   // nombre del ws
		            , 'trace' => 1          // para que funcione el __getLastRequest
		);
		$cliente = new SoapClient(null, $ops);
			
		$Reemplazable = new SoapVar( '0', XSD_SHORT );
		$Visible = new SoapVar( '1', XSD_SHORT );
		$Tamano = new SoapVar($fSize, XSD_LONG );		
		$LastY = new SoapVar('0', XSD_INTEGER );
		$nFirmados = new SoapVar('0', XSD_INTEGER );
		



	
	$firma1 = (object)array('Rut' 			=> "$firmantes",
							'NroAudit' 		=> "",
							'FechaFirma' 	=> "",
							'email' 		=> "",
							'Titulo' 		=> "Alumno",
							'FlagMails' 	=> 0,
							'NoFirma' 		=> 0,
							'Visado'		=> 0 );
							
	$firma2 = (object)array('Rut' 			=> "Compart_UCHN",
							'NroAudit' 		=> "",
							'FechaFirma' 	=> "",
							'email' 		=> "",
							'Titulo' 		=> "Alumno",
							'FlagMails' 	=> 0,
							'NoFirma'		=> 1,
							'Visado'		=> 0	);
	
//echo '<pre>'.print_r($firma1,true).'</pre>';
//echo '<pre>'.print_r($firma2,true).'</pre>';
	



	
	
	 $firma1 = new SoapVar($firma1 , SOAP_ENC_OBJECT, null, null, "Firmas" );
	 $firma2 = new SoapVar($firma2 , SOAP_ENC_OBJECT, null, null, "Firmas" );
	
		$Doctos = array(
                    'Reemplazable'  		=> $Reemplazable,
                    'Visible'               => $Visible,
                    'Descrip'               => $nax,
                    'CodPadre'              => "",
                    'Metadata'              => "",
                    'Rut'                   => $rut,
                    'Sistema'               => "UCHNEGOCIOS",
                    'Tamano'                => $fSize,
                    'Archivo64'             => $Archivo64,
                    'md5'					=> "",
                    'Tipo'                  => "pdf",
                    'MimeType'              => "application/pdf",
                    'CodLugar'              => "",
                    'LastY'					=> 0,
                    'nFirmados'             => 0,
                    $firma1,
                    $firma2
 		);	

		
		$Qry = array ('Doc' => (object)$Doctos);
		
	//echo '<pre>'.print_r($Qry,true).'</pre>';			

		$params = array(new SoapParam((object) array(
		'wsUsuario' => "UCHNEGOCIOS",
		'wsClave' => "uchn390c10s",
		'NombreArchivo' => $nax,
		'Institucion' => "UCHNEGOCIOS",
		'Doc'=> (object)$Doctos)
		,'Req'));
		
		
		$SResp = $cliente->__soapCall('wsAddDoc', $params, array('connection_timeout' => 30));
		$Resp = array(
	        'Err' => $SResp['Resultado']->Err,
	        'Glosa' => $SResp['Resultado']->Glosa,
	        'lista' => $SResp['CodigoDoc']
		);
		
		//echo '<pre>'.print_r($Resp, true).'</pre>';
			
		if($SResp['Resultado']->Err != 0){
			echo $SResp['Resultado']->Glosa;
			//echo 1;
			//echo "ERROR";		
		}else{
			echo 'ID: '.$Resp['lista'];
			//echo '<pre>'.print_r($Resp, true).'</pre>';
			//return $Resp['Glosa'];

	//==============================================
	//include("../../../../../Connections/cn_bd_intranet.php");
	$link = mysql_connect('192.168.5.3', 'and32x', '')
    or die('No se pudo conectar: ' . mysql_error());
	mysql_select_db('intranet') or die('No se pudo seleccionar la base de datos');
				
			if($nax=='Declaracion Jurada'){
				$sql_update_data="UPDATE intranet.firma_digital
					SET id_declaracion_64='".$Resp['lista']."'
				where 
					id_postulacion=".$form_id;
			}elseif($nax=='Contrato presatcion de servicios'){
				$sql_update_data="UPDATE intranet.firma_digital
						SET id_contrato_ps_64='".$Resp['lista']."'
				where 
					id_postulacion=".$form_id;			
			}
			//echo '<p>'.$sql_update_data.'</p>';
			echo '.-.';

			mysql_query($sql_update_data) or die('Consulta fallida: ' . mysql_error());
			
	//==============================================

		}

	
	} catch(Exception $e) {
		echo '<p>wsAddDoc: ' . $e -> getMessage() . "</p>";
		return false;
	}
	
}

//============================================================================

//include("../../../../../Connections/cn_bd_intranet.php");
	$link = mysql_connect('192.168.5.3', 'and32x', '')
    or die('No se pudo conectar: ' . mysql_error());
	mysql_select_db('intranet') or die('No se pudo seleccionar la base de datos');


$form_id=$_REQUEST['form_id'];
if($form_id==''){

	$form_id=10469;
}

$sql_data="select 
	fd.id_postulacion,
	fd.declaracion_64,
	fd.contrato_ps_64
from 
	intranet.firma_digital fd
where 
	fd.id_postulacion=".$form_id;

//echo $sql_data.'<p>';

$result = mysql_query($sql_data) or die('Consulta fallida: ' . mysql_error());
$row_rs_sql = mysql_fetch_array($result, MYSQL_ASSOC);


$diploma=$row_rs_sql['id_postulacion'];



$Archivo64=$row_rs_sql['declaracion_64'];
$Archivo64_CPS=$row_rs_sql['contrato_ps_64'];

//---------------------------
//Rut firmante largo 12
//---------------------------
$rut_firmante="000000000000".str_replace(".","",str_replace(" ","",$_REQUEST['RUT']));
$firmantes=substr($rut_firmante,-12,12);//"0017029148-4";
$firmantes_dec5=str_replace(".","",str_replace(" ","",$_REQUEST['RUT']));
//---------------------------
// Rut propietario         //
//---------------------------
   $rut="0013216541-6";
//   $rut="17029148-4";
//---------------------------

$tag=$form_id;
$ins="UCHNEGOCIOS";
$nax="Declaracion Jurada"; //nombre documento

$nax2="Contrato presatcion de servicios"; //nombre documento

$doc_fd=$_REQUEST['doc_fd'];
if($doc_fd=='dj'){
	/* ---------------------------------- */
	/* wsUploadArch                       */
	/* DEC3 dado de baja, se migro a DEC5 */
	//wsUploadArch($Archivo64, $rut, $firmantes, $tag, $ins, $nax, $form_id, $doc_fd);
	//if($firmantes=='0013216541-6' || $firmantes=='0019063941-K'){
		include("../dec5/crear_declaracion_jurada.php");
	//}

}
if($doc_fd=='cs'){
	//echo ':: '.$rut.', '.$firmantes.', '.$tag.', '.$ins.', '.$nax2.', '.$form_id;
	/* ---------------------------------- */
	/* wsUploadArch                       */
	/* DEC3 dado de baja, se migro a DEC5 */
	//wsUploadArch($Archivo64_CPS, $rut, $firmantes, $tag, $ins, $nax2, $form_id);
	
	//if($firmantes_dec5=='13216541-6' || $firmantes_dec5=='19063941-K'){
		include("../dec5/crear_contrato_p_servicio.php");
	//}	
}

?>
