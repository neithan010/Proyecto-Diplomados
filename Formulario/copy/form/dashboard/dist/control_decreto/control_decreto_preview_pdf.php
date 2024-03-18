<?php 
/*
echo '::'.dirname(__FILE__, 3);
echo '<hr>';

echo dirname(__FILE__).PHP_EOL;
exit();
*/
// No mostrar los errores de PHP
//error_reporting(0);
error_reporting(E_ALL);

include('../../cn/cn_PDO.php');

$id_postulacion = $_REQUEST['id_postulacion'];
$text_numeral	= $_REQUEST['text_numeral'];
$arr_numeral 	= explode("<br>",$text_numeral);
$totlaDsco 		= $_REQUEST['totlaDsco'];
$fecha_imp		= date('Y-m-d');
$con_firma		= $_REQUEST['con_firma'];

$resolucion		= $_REQUEST['resolucion'];
$fecha_contrato = $_REQUEST['fecha_contrato'];

$sql_data="SELECT 
	p.ID_POSTULACION,
	p.POSTULACION,
	CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo,
	p.RUT,
	d.nom_cordinadora_admision,
	d.valor_diplomado,
	d.moneda,
	d.cod_diploma,
	d.Cod_interno,
	ifnull(d.fecha_inicio,'Por defeinir') fecha_inicio,
	p.FECHA_POST,
	p.ID_FINANCIAMIENTO,
	p.ID_FINANCIAMIENTO,
	CASE
		WHEN p.ID_FINANCIAMIENTO = 'Empresa' 			THEN 'EMP'
		WHEN p.ID_FINANCIAMIENTO = 'Interesado' 		THEN 'INT'
		WHEN p.ID_FINANCIAMIENTO = 'Interesado/Empresa' THEN 'INT/EMP'
		WHEN p.ID_FINANCIAMIENTO = 'Beca' 				THEN 'INT'
		WHEN p.ID_FINANCIAMIENTO = 'Canje'	 			THEN 'INT'
		ELSE 'INT'
	END qpersona
	
FROM 
	unegocios_nuevo.postulacion p 
	INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
WHERE 
	p.ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_data.'</pre>';
//exit();

$stmt_data = $con->prepare($sql_data);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();
$num_data =$stmt_data ->rowCount();	
//echo '::'.$num_convenios;

if ($rw_data = $stmt_data ->fetch()){

	$id_postulacion   = $rw_data['ID_POSTULACION'];
	$programa         = $rw_data['POSTULACION'];
	$nombre_completo  = $rw_data['nombre_completo'];
	$rut              = $rw_data['RUT'];
	$nom_cordinadora_admision = $rw_data['nom_cordinadora_admision'];
	$valor_diplomado  = $rw_data['valor_diplomado'];
	$moneda           = $rw_data['moneda'];
	$fecha_inicio     = $rw_data['fecha_inicio'];
	$FECHA_POST       = $rw_data['FECHA_POST'];
	$cod_diploma      = $rw_data['cod_diploma'];
	$ceco             = $rw_data['Cod_interno'];
	$qpersona         = $rw_data['qpersona'];
	
}

/* VALOR UF */
$sql_uf="SELECT v.uf FROM intranet.valores_economicos v WHERE v.fecha_valor='$fecha_imp'";

//echo '<pre>'.$sql_uf.'</pre>';

$stmt_uf = $con->prepare($sql_uf);
$stmt_uf ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_uf ->execute();
$num_uf =$stmt_uf ->rowCount();	
//echo '::'.$num_convenios;
if ($rw_uf  = $stmt_uf ->fetch()){
	$uf=$rw_uf['uf'];
}
/* VALOR DOLAR USD */
$sql_usd="SELECT * FROM intranet.valor_dolar v WHERE v.fecha<='$fecha_imp'";

//echo '<pre>'.$sql_usd.'</pre>';

$stmt_usd = $con->prepare($sql_usd);
$stmt_usd ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_usd ->execute();
$num_usd =$stmt_usd ->rowCount();	
//echo '::'.$num_convenios;

$dolar=0;
if ($rw_usd  = $stmt_usd ->fetch()){
	$dolar=$rw_usd['valor'];
}

//echo $moneda.' '.$uf.'*'.$valor_diplomado.'<br>';

if($moneda=='UF'){
	$precio_final = round($uf*$valor_diplomado*(1-($totlaDsco/100)),0, PHP_ROUND_HALF_UP);
}elseif($moneda=='USD'){
	$precio_final = round($dolar*$valor_diplomado*(1-($totlaDsco/100)),0, PHP_ROUND_HALF_UP);
}else{
	$precio_final = round($valor_diplomado*(1-($totlaDsco/100)),0, PHP_ROUND_HALF_UP);
}

//echo ' :: '.$programa;

//exit();



require('../include/fpdf.php');



//------------------------------------------------
$pdf=new FPDF();
$pdf->AddPage();

//---------------------------------------------------------
$pdf->Image('logocdg2017.jpg',10,5,25);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(80);
$pdf->Cell(20,0,'ANEXO','0',1,'C');
$pdf->Ln(4);

$pdf->Cell(80);
$pdf->Cell(20,0, utf8_decode('CONTROL CUMPLIMIENTO DECRETOS Y CONDICIONES DE CIERRE DE MATRÍCULA') ,'0',1,'C');
$pdf->Ln(14);

//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Nombre Responsable: ','0',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5, $nom_cordinadora_admision ,'0',0,'L');

$pdf->SetFont('Symbol','',14);
$pdf->Cell(8,5, '['.chr(214).'] ' ,'0',0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,5, 'Confirma' ,'0',0,'L');

$pdf->Ln(4);

//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'1 Nombre Alumno: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $nombre_completo ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'2 Rut: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $rut ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'3 Nombre Programa: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $programa ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,' ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $cod_diploma ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'ID:','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $id_postulacion ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Precio lista Programa: ','0',0,'L');
$pdf->SetFont('Arial');
if($moneda=='CLP'){
	$pdf->Cell(80,5, number_format($valor_diplomado, 0, ",", ".").'.- '.$moneda ,'0',0,'L');
  }else{
	$pdf->Cell(80,5, number_format($valor_diplomado, 2, ",", ".").'.- '.$moneda ,'0',0,'L');
  }

$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Fecha Postulacion: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, date("d/m/Y H:i:s", strtotime($FECHA_POST)) ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Fecha Contrato: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, date("d/m/Y", strtotime($fecha_contrato))  ,'0',0,'L');
$pdf->Ln(4);
//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Fecha Inicio Programa: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, date("d/m/Y", strtotime($fecha_inicio)) ,'0',0,'L');
$pdf->Ln(10);

//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Resolucion: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $resolucion ,'0',0,'L');
$pdf->Ln(10);

//---------------------------------------------------------
foreach($arr_numeral as $numeral){

  $pdf->SetFont('Arial');
  $pdf->Cell(80,5, $numeral ,'0',0,'L');
  $pdf->Ln(4);

}
$pdf->Ln(5);

//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Descuento Total: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, $totlaDsco .' %','0',0,'L');
$pdf->Ln(10);
//---------------------------------------------------------
/*
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Precio Final: ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5, '$ '.number_format($precio_final, 0, ",", ".").'.-' ,'0',0,'L');
$pdf->Ln(10);
*/
//---------------------------------------------------------
// Con Firma? 
// Solo firman en caso de II viii, III i, XII i y ii
//if($con_firma=='si'){
	if(false){
//---------------------------------------------------------


	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(40,5,'Autoriza ','0',0,'L');
	$pdf->Ln(10);


	//---------------------------------------------------------
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	//$pdf->Cell(40,5,'X '.$x.' Y '.$y,'0',0,'L');

	$pdf->Image('ctrol_decreto_anunez2.png',40,$y,30);

	//---------------------------------------------------------
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	//$pdf->Cell(40,5,'X '.$x.' Y '.$y,'0',0,'L');

	$pdf->Image('ctrol_decreto_garrate2.png',120,$y,30);

	//---------------------------------------------------------

	$pdf->Ln(20);
	$pdf->Cell(20);
	$pdf->Cell(40,5,utf8_decode('Subdirectora de Educación Ejecutiva'),'0',0,'L');
	$pdf->Cell(50);
	$pdf->Cell(40,5,utf8_decode('Director Unidad de Extensión'),'0',0,'L');

	//---------------------------------------------------------

	$pdf->Ln(40);
	$pdf->Cell(30);
	$pdf->Cell(40,5,utf8_decode('Director Departamento '),'0',0,'L');
	$pdf->Cell(50);
	$pdf->Cell(40,5,utf8_decode('Firma Estudiante '),'0',0,'L');


//---------------------------------------------------------
}
//---------------------------------------------------------
$pdf->SetXY(20,265);
    //Arial italic 8
    $pdf->SetFont('Arial','I',6);
    //Número de página
	$pdf->SetTextColor(123,123,132);
    $pdf->Cell(0,10,$id_postulacion.'-'.date('Ymd-H.i.s'),0,0,'C');

//---------------------------------------------------------


//$pdf->Output();


/////////////////////


//$dir='../../Fichas/'.$id_postulacion.'/';
$dir_pdf='/negocios/new_admision/dashboard/Fichas/'.$id_postulacion.'/';
$dir_bk='/negocios/new_admision/dashboard/Fichas/'.$id_postulacion.'/BK';


error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
$strServer = "200.89.73.98";
$strServerPort = "4322";
$strServerUsername = "negocios";
$strServerPassword = "Neg44QWyub:;";

$connection = ssh2_connect($strServer, $strServerPort);
ssh2_auth_password($connection, $strServerUsername, $strServerPassword);
    
$sftp = ssh2_sftp($connection);

if(!file_exists($dir)){
    ssh2_sftp_mkdir($sftp, $dir);
}


if(file_exists($dir.'control_decreto.pdf')){
	$oldname=$dir.'control_decreto.pdf';
	$newDir=$dir.'BK/';
	if(!is_dir($newDir)){
		//if(!mkdir($newDir, 0777, true)){
			ssh2_sftp_mkdir($sftp, $newDir);	
		//	die('[2]Fallo al crear las carpetas...');
		//}
	}
	//else{
	//	chmod($newDir, 0777);
	//}

	$newname=$newDir.date('Ymd-His').'_control_decreto.pdf';
	//rename($oldname,$newname);
	ssh2_sftp_rename($sftp, $oldname,$newname);
}

$pdfcode = $pdf->Output('S');
$archivo='control_decreto.pdf';
 
$stream = fopen("ssh2.sftp://$sftp$dir/$archivo", 'w');

fwrite($stream, $pdfcode);
fclose($stream); 

//$pdf->Output('control_decreto.pdf','F');
*/



if (!file_exists($dir_pdf)) {
    mkdir($dir_pdf, 0777, true);
}elseif(file_exists($dir_pdf.'/control_decreto.pdf')){
    if (!file_exists($dir_bk)) {
        mkdir($dir_bk, 0777, true);
    }
    copy($dir_pdf.'/control_decreto.pdf',$dir_bk.'/'.date('ymdhis').'_control_decreto.pdf');
    unlink($dir_pdf.'/control_decreto.pdf');
}

$pdf->Output($dir_pdf.'control_decreto.pdf','F');
$pdf->Output('I','control_decreto.pdf');


$sql="INSERT INTO intranet.postulacion_documentos
		(idpostulacion,
		documento,
		fecha_generacion)
		VALUES
		(
		'".$id_postulacion."',
		'control_decreto.pdf',
		NOW()
		)";

	//echo '<pre>'.$sql.'</pre>';
	//echo 'arr_numeral:<pre>'.print_r($arr_numeral, true).'</pre>';
	
	$stmt_data = $con->prepare($sql);
	$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data ->execute();

foreach($arr_numeral as $data_numeral){

	$arr_data=explode(" ",$data_numeral);

	if(!empty($arr_data[2])){ 
		$numeral_descuento=$arr_data[2].' ';
	}else{ 
		$numeral_descuento='N/A';
	}
	if(!empty($arr_data[3])){ 
		$descuento_numeral=str_replace("%","",$arr_data[3]); 
	}else{ 
		$descuento_numeral=0;
	}
	
	$sql_in[]="('".$id_postulacion."',
	'".utf8_decode($nom_cordinadora_admision)."',
	'".utf8_decode($nombre_completo)."',
	'".$programa."',
	'".$fecha_imp."',
	'".$qpersona."',
	'".$descuento_numeral."',
	'".$resolucion."',
	'".$numeral_descuento."')";

}


	$sql="INSERT INTO intranet.control_decreto
	(idpostulacion,
	responsable,
	alumno,
	programa,
	fecha_matricula,
	qpersona,
	dco_aplicable,
	decreto,
	decreto_letra)
	VALUES
	".implode(",",$sql_in);

	//echo '<pre>'.$sql.'</pre>';
	$stmt_data = $con->prepare($sql);
	$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data ->execute();

	$sql_data_dsc="select 
		cd.idpostulacion,
		p.cod_diploma,
		p.POSTULACION,
		d.valor_diplomado,
		d.moneda,
		sum(cd.dco_aplicable) total_descuento,
		now() fecha,
		p.RUT usr,
		concat('wbp',cd.idpostulacion) clave
	from 
		intranet.control_decreto cd
		inner join unegocios_nuevo.postulacion p on cd.idpostulacion=p.ID_POSTULACION
		inner join intranet.diplomados d on p.cod_diploma=d.cod_diploma
	where 
		-- cd.qpersona='INT' and 
		cd.corregido is null
		and cd.idpostulacion=".$id_postulacion;

//echo '<pre>'.$sql_postulacion_descuento.'</pre>';
$stmt_data_dsc = $con->prepare($sql_data_dsc);
$stmt_data_dsc ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data_dsc ->execute();

if ($rw_data_dsc  = $stmt_data_dsc ->fetch()){

	$idpostulacion		= $rw_data_dsc['idpostulacion'];
	$cod_diploma		= $rw_data_dsc['cod_diploma'];
	$postulacion		= $rw_data_dsc['POSTULACION'];
	$valor_diplomado	= $rw_data_dsc['valor_diplomado'];
	$moneda				= $rw_data_dsc['moneda'];
	$total_descuento	= $rw_data_dsc['total_descuento'];
	$fecha				= $rw_data_dsc['fecha'];
	$usr				= $rw_data_dsc['usr'];
	$clave				= $rw_data_dsc['clave'];
}


	$sql_postulacion_descuento="INSERT INTO intranet.postulacion_descuento
	(id_postulacion, cod_diploma, diploma, valor, moneda, total_descuento, fecha, usuario, clave)
	VALUES
	(	$id_postulacion, 
		'$cod_diploma', 
		'$postulacion', 
		'$valor_diplomado', 
		'$moneda', 
		'$total_descuento', 
		'$fecha', 
		'$usr', 
		'$clave')
	ON DUPLICATE KEY UPDATE
	cod_diploma	= '$cod_diploma', 
	diploma		= '$postulacion', 
	valor		= '$valor_diplomado', 
	moneda		= '$moneda', 
	total_descuento = '$total_descuento', 
	fecha		= '$fecha', 
	usuario		= '$usr', 
	clave		= '$clave'
	";

	//echo '<pre>'.$sql_postulacion_descuento.'</pre>';
	$stmt_data = $con->prepare($sql_postulacion_descuento);
	$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data ->execute();

	$pdf->Output('I',$archivo);


?>
