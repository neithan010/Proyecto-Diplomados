<?php require_once('../../cn/cn_PDO.php'); ?>

<?php
//header("Content-type: text/html; charset=iso-8859-1");

$fecha=date('d');
switch(date('m')){
	case '01':
		$fecha.=' Enero ';
		break;
	case '02':
		$fecha.=' Febrero ';
		break;
	case '03':
		$fecha.=' Marzo ';
		break;
	case '04':
		$fecha.=' Abril ';
		break;
	case '05':
		$fecha.=' Mayo ';
		break;
	case '06':
		$fecha.=' Junio ';
		break;
	case '07':
		$fecha.=' Julio ';
		break;
	case '08':
		$fecha.=' Agosto ';
		break;
	case '09':
		$fecha.=' Septiembtre ';
		break;
	case '10':
		$fecha.=' Octubre ';
		break;
	case '11':
		$fecha.=' Noviembre ';
		break;
	case '12':
		$fecha.=' Diciembre ';
		break;
}
$fecha.=' de '.date('Y');

	
		
function caracteres_especiales($s) {
	$s = str_replace("á","&aacute;",$s);
	$s = str_replace("Á","A",$s);
	$s = str_replace("É","&eacute;",$s);
	$s = str_replace("É","E",$s);
	$s = str_replace("í","&iacute;",$s);
	$s = str_replace("Í]","I",$s);
	$s = str_replace("ó","&oacute;",$s);
	$s = str_replace("Ó","O",$s);
	$s = str_replace("ú","&uacute;",$s);
	$s = str_replace("ü","&uuml;",$s);
	$s = str_replace("Ú","U",$s);
	$s = str_replace("ñ","&ntilde;",$s);
	$s = str_replace("Ñ","&Ntilde;",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}	
$form_id='';	
if(isset($_REQUEST['form_id'])){
	$form_id=$_REQUEST['form_id'];
}
if($form_id==''){
	echo 'Error';
	exit();
}

//$sql = "SELECT * FROM unegocios_nuevo.postulacion WHERE ID_POSTULACION = ".$_REQUEST['form_id'];
$sql= "
		SELECT 
		  p.ID_POSTULACION,
		  UCASE(p.POSTULACION) POSTULACION,
		  UCASE(p.NOMBRES) NOMBRES,
		  UCASE(p.APELLIDO_PAT) APELLIDO_PAT,
		  UCASE(p.APELLIDO_MAT) APELLIDO_MAT,
		  p.RUT,
		  p.NACIONALIDAD,
		  UCASE(p.DIREC_PARTICULAR) direccion,
		  p.numero,
		  p.depto_of_par,
		  UCASE(ifnull(c.nombre,'')) comuna,
		  
		  UCASE(p.CARRERA_PRO) CARRERA_PRO,
		  UCASE(if(p.TituloProfesional<>'',p.TituloProfesional,p.CARRERA_PRO)) TituloProfesional,
		  DATE_FORMAT(d.fecha_inicio,'%d-%m-%Y') mes_inicio,
		  DATE_FORMAT(d.fecha_inicio,'%Y') year_inicio,
		  ROUND(d.valor_diplomado,0) valor_diplomado,
		  d.moneda,
		  d.periodo,
		  p.email,
		  d.cod_diploma,
		  d.usr_cordinador_ad as cordinador,
		  d.nom_cordinadora_admision,
		  p.ID_FINANCIAMIENTO
		  
FROM
	unegocios_nuevo.postulacion p 
	left join unegocios_nuevo.comunas c on p.comuna=c.cod_comuna
	left join intranet.diplomados d on p.cod_diploma=d.cod_diploma
WHERE
	  p.ID_POSTULACION =".$form_id;
//echo '<pre>'.$sql.'</pre>';

//$rs_datos = mysql_query($sql, $cn_intranet) or die(mysql_error());
//$row_rs_datos = mysql_fetch_assoc($rs_datos);

	$stmt_data = $con->prepare($sql);
	$stmt_data->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data->execute();

if ($row_rs_datos = $stmt_data->fetch()){

	$direccion=utf8_encode($row_rs_datos['direccion'].' '.$row_rs_datos['numero']);
	
	if($row_rs_datos['depto_of_par']!=''){
		$direccion=$direccion.', Depto. '.utf8_encode($row_rs_datos['depto_of_par']);
	}
	$direccion=$direccion.', '.utf8_encode($row_rs_datos['comuna']);
	$nombre_completo=utf8_encode($row_rs_datos['NOMBRES'].' '.$row_rs_datos['APELLIDO_PAT'].' '.$row_rs_datos['APELLIDO_MAT']);
	$carreraPro=utf8_encode($row_rs_datos['CARRERA_PRO']);
	
	$postulacion=utf8_encode($row_rs_datos['POSTULACION']);
	
	
	
	$arr_cod_diploma=explode(".",$row_rs_datos['cod_diploma']);
	$periodo_mod=$arr_cod_diploma[1].'.'.$arr_cod_diploma[2];
	$periodo_num=$arr_cod_diploma[1].$arr_cod_diploma[2];

	$mes_inicio=$row_rs_datos['mes_inicio'];
	$year_inicio=$row_rs_datos['year_inicio'];

	$rut=$row_rs_datos['RUT'];
	$nacionalidad=utf8_encode($row_rs_datos['NACIONALIDAD']);

	
	$quien_paga = $row_rs_datos['ID_FINANCIAMIENTO'];
	
}



function mes_es($fecha){
	//echo substr($fecha,3,2);
	$fecha_imp='';
	switch(substr($fecha,3,2)){
		case '01':
			$fecha_imp=' Enero ';
			break;
		case '02':
			$fecha_imp=' Febrero ';
			break;
		case '03':
			$fecha_imp=' Marzo ';
			break;
		case '04':
			$fecha_imp=' Abril ';
			break;
		case '05':
			$fecha_imp=' Mayo ';
			break;
		case '06':
			$fecha_imp=' Junio ';
			break;
		case '07':
			$fecha_imp=' Julio ';
			break;
		case '08':
			$fecha_imp=' Agosto ';
			break;
		case '09':
			$fecha_imp=' Septiembtre ';
			break;
		case '10':
			$fecha_imp=' Octubre ';
			break;
		case '11':
			$fecha_imp=' Noviembre ';
			break;
		case '12':
			$fecha_imp=' Diciembre ';
			break;
	}
	return $fecha_imp;
}

function limpiar_caracteres_especiales($s) {
	//$s = str_replace("IÃ³","O",$s);
/*
	$s = preg_replace("[áàâãª]","a",$s);
	$s = preg_replace("[ÁÀÂÃ]","A",$s);
	$s = preg_replace("[éèê]","e",$s);
	$s = preg_replace("[ÉÈÊ]","E",$s);
	$s = preg_replace("[íìî]","i",$s);
	$s = preg_replace("[ÍÌÎ]","I",$s);
	
	$s = preg_replace("[ÓÒÔÕ]","O",$s);
	$s = preg_replace("[úùû]","u",$s);
	$s = preg_replace("[ÚÙÛ]","U",$s);

	$s = preg_replace("ñ","n",$s);
	$s = preg_replace("ó","o",$s);
	$s = preg_replace("Ñ","N",$s);
	$s = preg_replace("±","",$s);

*/	
	
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
} 

/**** CARGA DATOS DECANO o SUBROGANCIA **/
$sql_decano= "select 
		sb.rut,
		sb.titulo, 
		sb.nombre 
	from 
		intranet.subrogancia sb
	where	
		ifnull(curdate() between sb.fecha_ini and sb.fecha_fin, curdate()>=sb.fecha_ini)";
//echo $sql_sr.'<p>';

//$rs_decano	= mysql_query($sql_decano, $cn_intranet) or die(mysql_error());
//$row_decano = mysql_fetch_assoc($rs_decano);
	$stmt_decano = $con->prepare($sql_decano);
	$stmt_decano->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_decano->execute();

	$titulo_decano	= 'Decano';
	$rut_decano		= '7.040.498-2';
	$nombre_decano	= 'JOSE DE GREGORIO REBECO';

if ($row_decano = $stmt_decano->fetch()){
	
	$titulo_decano	= $row_decano['titulo'];
	$rut_decano		= $row_decano['rut'];
	$nombre_decano	= $row_decano['nombre'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">


</head>
<body>


<div id="wrap" class="container">
<?php

function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("m/d/Y", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    return $date_result;
}




?>
<div id="menuhoriz">

<?php 
//echo 'url_back: '.$_REQUEST['url_back'];
$url_back="../documentar/index.php?id_postulacion=".$form_id;

?> 
<!-- 
<a href="<?php echo $url_back;?>" class="btn btn-primary">Volver</a>
-->
</div>
<div id="contrato_servicio">
<form action="" method="get" name="form1">
<input id="form_id" name="form_id" type="hidden" value="<?php echo $_REQUEST['form_id'];?>"/>
<input id="email" name="email" type="hidden" value="<?php echo $email;?>"/>
<input id="cod_diploma" name="cod_diploma" type="hidden" value="<?php echo $cod_diploma;?>"/>
<input type="hidden" name="descuento_su_empresa" id="descuento_su_empresa" value="" size="5" maxlength="5" />
<input type="hidden" name="descuento_alum_empresa" id="descuento_alum_empresa" value="" size="5" maxlength="5" />

<input type="hidden" name="titulo_decano" id="titulo_decano" value="<?php echo $titulo_decano;?>">
<input type="hidden" name="nombre_decano" id="nombre_decano" value="<?php echo $nombre_decano;?>">
<input type="hidden" name="rut_decano" id="rut_decano" value="<?php echo $rut_decano;?>">


<p class="titulo">CONTRATO DE PRESTACI&Oacute;N DE SERVICIOS EDUCACIONALES</p>
<div class="interlineado">
<p>En Santiago, a <input id="fecha_imp" name="fecha_imp" type="text" value="<?php echo $fecha;?>"/>,, entre la FACULTAD DE ECONOMÍA Y NEGOCIOS DE LA UNIVERSIDAD DE CHILE, rol único tributario número 60.910.000-1, a través de la Unidad de Extensión del Departamento de Administración y don(ña) <input id="nombre_completo" name="nombre_completo" type="text" value="<?php echo $nombre_completo;?>" size="30" />, de nacionalidad <input id="NACIONALIDAD" name="NACIONALIDAD" type="text" value="<?php echo $nacionalidad;?>" />, de profesión 
<?php $size_titulo=strlen($row_rs_datos['TituloProfesional'])+5;
 if($size_titulo==''){
	 $size_titulo=15;
}
 ?>
 <input id="CARRERA_PRO" name="CARRERA_PRO" type="text" value="<?php echo utf8_encode($row_rs_datos['TituloProfesional']);?>" size="<?php echo $size_titulo;?>" /> , cédula de identidad número <input id="RUT" name="RUT" type="text" value="<?php echo $rut;?>" />, domiciliado(a) <input id="DIREC_PARTICULAR" name="DIREC_PARTICULAR" type="text" value="<?php echo utf8_encode($direccion);?>" size="40" />, en adelante indistintamente el &ldquo;Alumno&ldquo;, se ha convenido el presente Contrato de Prestación de Servicios Educacionales:</p>

<p>PRIMERO: El Alumno ha sido aceptado y matriculado en el <strong>&quot;<?php echo $postulacion;?>&quot;</strong><input type="hidden" name="diploma" id="diploma" value="<?php echo utf8_encode($postulacion);?>"  />, impartido por la Unidad de Extensión del Departamento de Administración de la Facultad de Economía y Negocios de la Universidad de Chile. </p>

<p>Dicho programa se inicia en el mes de <input name="ini_programa" id="ini_programa" type="text" value="<?php echo strtoupper(limpiar_caracteres_especiales(mes_es($row_rs_datos['mes_inicio']))).' de '. substr($row_rs_datos['mes_inicio'],6,4) ?>" /> 
y se encuentra regido, en general, por el Decreto Exento (DEX) Nº 0011180, de fecha 23 de abril de 2020, modificado mediante DEX N° 20977 de 2020, la Resolución Exenta (REX) N° 197.20, de 2020, modificada mediante REX N°302.20, y en especial, por el Reglamento para Cursos de Extensión del Departamento de Administración, y los Términos y Condiciones de Programas, todos documentos disponibles en el sitio web https://unegocios.uchile.cl/reglamento/. El Alumno declara conocer, aceptar y estar dispuesto a acatar, cabalmente y en todas sus partes, dichos reglamentos y demás normativas que se encuentre vigente durante el desarrollo del Curso, las que para todos los efectos forman parte integrante del presente contrato.</p>

<p>SEGUNDO: El Alumno acepta las políticas para la dictación de los diplomas que se señalan a continuación:</p>

<p>a) Existirá un Comité Académico que fijará, discrecionalmente, las políticas relativas a: contenidos, evaluación, duración del Curso, así como la asignación de los profesores y selección de alumnos y, en general, todas las políticas globales del funcionamiento de cada Curso.</p>
<p>b) El alumno que postule a un Curso deberá ser previamente aceptado por la Unidad de Extensión. La aceptación de un postulante a cualquier Curso dependerá del cumplimiento de los distintos requisitos que para cada programa se exijan, tales como conocimientos previos, experiencia laboral, títulos profesionales o técnicos y cualquier otro que la Unidad de Extensión, a su solo arbitrio, estime prudente para un buen desempeño tanto del alumno, como para el enriquecimiento del Curso.</p>
<p>c) Por situaciones de caso fortuito o fuerza mayor, o por razones académicas y/o administrativas de mejor servicio y calidad de los programas, la Unidad de Extensión podrá modificar los contenidos e información del Curso, tales como su malla curricular, horarios, días de clases, profesores y relatores. Desde ya, el Alumno acepta las eventuales modificaciones que puedan realizarse al Curso como una medida necesaria para el desarrollo del programa, por lo que se exime a la Unidad de Extensión, al Departamento de Administración, a la Facultad de Economía y Negocios y a la Universidad de Chile, de todo tipo de responsabilidad por los daños y perjuicios de cualquier naturaleza que se puedan producir debido a cambios o modificaciones en los Cursos, no procediendo por ello, en caso alguno, pago de ningún tipo de indemnización por este motivo.</p>
<p>d) Asimismo, la Unidad de Extensión podrá decidir suspender o bien no dictar algún Curso, por carecer del mínimo de alumnos inscritos o matriculados necesarios para su dictación. El número de alumnos necesario para cada Curso o Diploma es fijado en forma discrecional por el Comité Académico de cada uno de ellos. En este caso, la Unidad de Extensión informará mediante cualquier forma idónea al Alumno, indicándole la causa de la suspensión o no dictación del Diplomado. El Alumno exime a la Unidad de Extensión, al Departamento de Administración, a la Facultad de Economía y Negocios y a la Universidad de Chile, de todo tipo de responsabilidad por los daños y perjuicios de cualquier naturaleza que se puedan producir debido a la suspensión y/o no dictación del Curso, no procediendo, en caso alguno, pago de ningún tipo de indemnización por este motivo.</p>

<p>&nbsp;</p>
<p>TERCERO: Uno. El precio total del Curso asciende a la suma de <input id="valor_programa" name="valor_programa" type="text" value="<?php echo $row_rs_datos['valor_diplomado'];?>" size="10" maxlength="7" /> 
<?php 
	if($row_rs_datos['moneda']=='UF'){ 
		echo $datos_moneda='Unidades de Fomento, en su equivalente en pesos a la fecha efectiva de pago ';
	}elseif($row_rs_datos['moneda']=='CLP'){
		echo $datos_moneda='Pesos';
	}else{
		echo $datos_moneda=$row_rs_datos['moneda'].', en su equivalente en pesos a la fecha efectiva de pago';
	}
?>
<input type="hidden" name="datos_moneda" id="datos_moneda" value="<?php echo $datos_moneda;?>" />, menos los descuentos eventuales que procedan en conformidad a lo establecido en la Resolución Exenta N° 197.20 y a la REX N°302.20 que la modifica, y se señalen expresamente en el anexo denominado &ldquo;Control Cumplimiento Decretos y Condiciones de Cierre de Matrícula&ldquo; (en adelante, el &ldquo;Anexo&ldquo;), el que debidamente firmado por el Alumno es parte integrante del presente contrato para todos los efectos. El precio se pagará en el número de cuotas y en los plazos que se indican en el Anexo.</p>

<p>Con la finalidad de facilitar el pago de las cuotas señaladas, y sin que ello implique novación de ningún tipo, se autoriza al Alumno a efectuar el pago correspondiente a través de los siguientes medios:</p>

<p>
<ul>
	<li>Vía sistema webpay en un máximo de 6 cuotas. según lo acordado previamente con el Ejecutivo de Admisión, de lo cual quedará el correspondiente registro en el Anexo.</li>
	<li>Tarjeta de Crédito Bancarias. (Hasta 6 cuotas sin interés).</li>
	<li>Paypal</li>
	<li>Paypal.</li>
	<li>PAT con un máximo de 6 cuotas.</li>
</ul>
</p>

<p>El alumno que se acoja al pago del arancel en cuotas y no cumpla oportunamente con el pago de cualquiera de ellas, deberá concurrir a la Facultad a regularizar sus compromisos financieros, ya sea pagando la deuda o repactándola en las condiciones que establezcan las partes en conformidad a la reglamentación interna de la Universidad.</p>
<p>Una vez verificado el retardo en el pago de una o más cuotas, la Facultad remitirá al alumno una comunicación escrita, vía correo electrónico, dando cuenta de la(s) cuota(s) adeudada(s) e informando el nombre y datos del funcionario con el cual deberá contactarse con el objeto de regularizar su situación, dentro del plazo de 10 días hábiles, contados desde el envío de dicha comunicación.</p>
<p>Si trascurrido el plazo señalado en el párrafo anterior, el alumno no regulariza su situación financiera, se efectuará una segunda comunicación, vía carta certificada firmada por el Coordinador Administrativo del Departamento de Administración, reiterando el requerimiento y confiriendo el plazo perentorio de 10 días hábiles, contados desde la recepción de la carta para efectuar la regularización de la deuda.</p>
<p>Expirado el plazo perentorio señalado precedentemente, se entenderá debidamente realizada la gestión útil, sin cargo para el deudor, que establece el inciso 3° del artículo 37 de la Ley No 19.496 LPC, y frente a la mora o simple retardo en el pago de cualquiera de las cuotas pactadas por parte del alumno, la Facultad podrá:</p>
<p>1) Exigir el pago total del saldo de precio que se encontrare insoluto a esa fecha, que se considerará de plazo vencido, más el interés máximo convencional por el saldo insoluto.</p>
<p>2)  Cobrar en forma directa o a través de una empresa de cobranza externa que se informará al alumno, los gastos de cobranza extrajudicial sobre las deudas morosas o atrasadas de acuerdo a lo establecido en el artículo 37 de la citada Ley No 19.496. El monto por concepto de cobranza no podrá superar los siguientes porcentajes aplicados sobre el monto de la deuda vencida a la fecha del atraso, y conforme a la siguiente escala progresiva:</p>
<ul>
	<li>En obligaciones de hasta 10 unidades de fomento, 9%.</li>
	<li>Por la parte que exceda a 10 unidades de fomento y hasta 50 unidades de fomento, 6%.</li>
	<li>Por la parte que exceda a 50 unidades de fomento, 3%.</li>
</ul>
<p>Los porcentajes indicados se aplicarán una vez transcurridos los primeros veinte días de atraso.</p>
<p>3) Iniciar la cobranza judicial de la deuda.</p>
<p>4) Condicionar la rendición de exámenes u otras evaluaciones al previo pago de los aranceles adeudados por el alumno.</p>
<p>5) Suspender el servicio, lo que impedirá al alumno poder continuar con el programa hasta solucionar su deuda para con la Facultad.</p>
<p>Por último, si el alumno pacta cuotas en sistema WebPay o PAT, estas cuotas deberán estar canceladas en su totalidad al día de la entrega de certificados de aprobación, de lo contrario quedará pendiente la entrega de este documento para el siguiente período. El alumno podrá prepagar las cuotas pendientes al día indicado de la ceremonia si así lo decide</p>
<p>Dos. El precio del Diploma será pagado de la siguiente manera (marcar sólo el cuadro que corresponda):</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47" valign="top"><p><input type="radio" name="quien_paga" id="alumno" value="alumno" <?php if($quien_paga=='Interesado' || $quien_paga==''){ echo 'checked';} ?>></p></td>
    <td width="542" valign="top"><p>Por el alumno en su totalidad.</p></td>
  </tr>
  <tr>
    <td width="47" valign="top"><p><input type="radio" name="quien_paga" id="su_empresa" value="su_empresa" <?php if($quien_paga=='Empresa'){ echo 'checked';} ?>></p></td>
    <td width="542" valign="top"><p>Por su empleador en su totalidad, para lo cual el Alumno entrega en este acto Orden de Compra y/o Carta de Compromiso de su empleador.</p></td>
  </tr>
  <tr>
    <td width="47" valign="top"><p><input type="radio" name="quien_paga" id="alumno_empresa" value="alumno_empresa" <?php if($quien_paga=='Interesado/Empresa'){ echo 'checked';} ?>></p></td>
    <td width="542" valign="top"><p>En parte por su empleador y en parte por el Alumno, para lo cual éste entrega en este acto Orden de Compra y/o Carta de Compromiso de su empleador, e indica en qué porcentajes será pagado el programa por cada uno de ellos.</p></td>
  </tr>
</table>
<input type="hidden" name="descuento_su_empresa" id="descuento_su_empresa" value="" size="5" maxlength="5" />
<input type="hidden" name="descuento_alum_empresa" id="descuento_alum_empresa" value="" size="5" maxlength="5" />
<p>&nbsp;</p>

<p>El Alumno podrá solicitar el cambio del financiamiento, sólo dentro del período en que se dicte el Curso. En el evento de hacer uso de esta facultad, el Alumno desde ya acepta que, si el cambio de financiamiento le hace perder la calidad o algunos de los requisitos que le permitieron acceder a los descuentos, aquellos que se hubieren efectuado al momento de haberse matriculado quedarán sin efecto, por lo que acepta que se recalcule el valor final del Diploma, debiendo someterse a lo dictado por la Unidad de Extensión del Departamento de Administración. Lo anterior, de conformidad a lo dispuesto en el artículo 4° de la Resolución Exenta N° 197.20.</p>

<p>CUARTO: Uno. Las partes acuerdan que el Alumno podrá desistirse de cursar el Curso, para lo cual deberá notificar dicha determinación a la Universidad, mediante carta dirigida al Director de la Unidad de Extensión del Departamento de Administración de la Facultad de Economía y Negocios de la Universidad de Chile. En dicho caso, se aplicará lo dispuesto en el numeral XI del artículo 1° de la Resolución Exenta N° 197.20, según se detalla a continuación:</p>
<ol type="i">
	<li>Para programas que tengan una duración superior a 1 mes, quedarán exentos del pago del 100% del arancel, siempre y cuando la renuncia se realice antes o dentro de la primera semana de iniciadas las clases.</li>
	<li>En el caso de los alumnos que soliciten la renuncia fundada con posterioridad a la primera semana de iniciadas las clases, se les podrá rebajar el remanente del arancel, en la proporción correspondiente al tiempo que falte para el término del programa, para lo cual deberán adjuntar los antecedentes que le sirvan de respaldo.</li>
	<li>Para aquellos programas que tengan una duración inferior a 1 mes, podrán quedar exentos del pago del 100% del arancel, siempre y cuando la renuncia se realice antes de iniciadas las clases.</li>
</ol>

<p>Lo señalado precedentemente es aplicable exclusivamente para el caso de retiro del Alumno del Curso en forma voluntaria, el que deberá efectuarse en la forma indicada (y no procede en caso alguno cuando se trata de reincorporaciones por reprobación, las que operan de conformidad a lo estipulado en el Reglamento para cursos de Extensión).</p>
<p>Dos. En caso de retiro voluntario, reprobación y/o expulsión del Alumno del Curso, éste perderá todo beneficio o derecho a los que hubiere accedido por haber poseído la calidad de alumno de la Universidad, tales como invitaciones a conferencias, charlas, membresías, suscripciones a revistas, etcétera. </p>
<p>Tres. El Alumno podrá realizar la postergación del curso antes del inicio académico de este, pudiendo reintegrarse hasta dentro de dos semestres consecutivos después, siempre y cuando el programa esté disponible dentro de la oferta. Esta postergación será procedente sólo en casos de fuerza mayor, enfermedad grave o situaciones laborales impostergables. Para hacer uso de este requerimiento se debe enviar una carta dirigida al Director de la Unidad de Extensión del Departamento de Administración de la Facultad de Economía y Negocios de la Universidad de Chile, adjuntando los respaldos necesarios para ello (certificados médicos, carta de empresa sobre traslados, finiquito, entre otros casos). En este caso, el Director de la Unidad emitirá un pronunciamiento fundado, aceptando o rechazando la postergación, sin que ello dé derecho a reclamo alguno por parte del Alumno.</p>
<p>Si la postergación del Diploma es aceptada, la Facultad podrá otorgar al alumno la exención de un porcentaje del arancel en los términos establecidos en el número uno precedente, según lo dispuesto en el artículo 1° numeral XI de la Resolución Exenta N° 197.20. En todo caso, una vez que el alumno se reincorpore Al curso, deberá pagar a la Universidad el arancel de reincorporación cuyo monto será proporcional al tiempo que le falte para terminar el curso, más un 1% del valor del arancel del programa por concepto de gastos de administración. En el caso que la nueva versión del curso tenga un arancel superior al curso postergado, el participante deberá pagar, adicionalmente, la diferencia de valor.</p>
<p>QUINTO: Las partes acuerdan que en caso de fuerza mayor o caso fortuito, que haga imposible la dictación de todo o parte del Curso en las dependencias de la Unidad de Extensión en formato presencial, éste podrá ser impartido en otras sedes, lugares o bien en forma virtual, mediante plataforma electrónica o vía internet, ello a criterio exclusivo de la Universidad y la Unidad de Extensión, sin que por esto proceda indemnización de ningún tipo por ningún concepto, por tratarse de un caso fortuito o fuerza mayor. Esto no afectará la certificación del programa, en cuanto a horas y desarrollo de contenidos.</p>
<p>SEXTO: Al momento de postular, el Alumno quedará registrado en un formulario especial, el que contendrá sus datos personales esenciales, los que serán ingresados a la base de datos del programa en caso de completar el proceso de matrícula.</p>
<p>Los datos de carácter personal que el Alumno proporcione, solo podrán ser utilizados o tratados por la Facultad para fines relacionados con los objetivos, desarrollo y ejecución de este Contrato, encuestas, o para enviar al Alumno publicidad de sus programas.</p>
<p>El Alumno autoriza en este acto y de forma expresa a la Facultad para el uso y tratamiento de dichos datos, los que podrán ser entregados a terceros para los efectos de obtención, distribución y entrega de beneficios o servicios asociados a su calidad de alumno de la Unidad de Extensión, en conformidad a la Ley N° 19.628 sobre Protección de la Vida Privada.</p>
<p>SÉPTIMO: Las partes fijan como domicilio la comuna de Santiago, prorrogando la competencia para ante sus Tribunales Ordinarios de Justicia.</p>
<p>El presente contrato se firma en dos (2) ejemplares de igual tenor y fecha, quedando uno (1) en poder de la Universidad y uno (1) en poder del Alumno.</p>

</div>
<table class="firma" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="center" valign="top"><strong>JOSE DE GREGORIO.</strong><br>
DECANO<br>
FACULTAD DE ECONOMÍA Y NEGOCIOS UNIVERSIDAD DE CHILE
</td>
    <td width="50%" align="center" valign="top">ALUMNO</td>
  </tr>
  <tr>
    <td width="50%" align="center">&nbsp;</td>
    <td width="50%" align="center">&nbsp;</td>
  </tr>
</table>
</form>
</div>
<p align="center">
	<button class="btn btn-primary" id="btn_imp_fd" >Regenerar Documento</button> 
	

</p>
<div id="div_loading">
            <img src="../img/loading.gif" alt="">
</div>
	<div id="imp_doc">
	</div>
	<div id="fd_cs">
	</div>
	<div id="fd_up">
	</div>

	<div id="result" class="alert alert-info" role="alert"></div>
	</div>
	<p>&nbsp;</p>
</div>
<script src="../js/jquery-3.5.1.min.js"></script>
<script>
$( document ).ready(function() {
    
	$("#result").hide();
	$("#div_loading").hide();



    $("#btn_imp_fd" ).click(function(){
        $("#div_loading").show();

		$.post( "../../../../cdg/postulacion/admision/g_documentos/contratos/contrato_cursos_pdf_fd.php", 
		{ 

			diploma: document.getElementById('diploma').value,
			nombre_completo : document.getElementById('nombre_completo').value,
			fecha_imp : document.getElementById('fecha_imp').value,
			
			RUT : document.getElementById('RUT').value,
			form_id : document.getElementById('form_id').value,
			valor_programa : document.getElementById('valor_programa').value,

			moneda : document.getElementById('datos_moneda').value,

			NACIONALIDAD : document.getElementById('NACIONALIDAD').value,
			fecha_inicio : document.getElementById('ini_programa').value,
			ini_programa : document.getElementById('ini_programa').value,


			direc_particular : document.getElementById('DIREC_PARTICULAR').value,
			
			email : document.getElementById('email').value,
			cod_diploma : document.getElementById('cod_diploma').value,

			titulo_decano : document.getElementById('titulo_decano').value,
			rut_decano : document.getElementById('rut_decano').value,
			nombre_decano : document.getElementById('nombre_decano').value,

			quien_paga : $('input:radio[name=quien_paga]:checked').val(),

			descuento_su_empresa : document.getElementById('descuento_su_empresa').value,
			descuento_alum_empresa : document.getElementById('descuento_alum_empresa').value,
			doc_fd : 'doc_fd'
				
		})
			.done(function( data ) {
				//$("#result").show(300);
                //$("#result").html("Contrato Generada CERTINET: " + data);
				$("#div_loading").hide(300);
				$("#result").show(300);
                $("#result").html("(Contrato Re generado) " + data);
			/*
			$.post( "../certinet/crear_contrato_curso.php", 
			{ 

				id_postulacion : document.getElementById('form_id').value
					
			})
				.done(function( data ) {

				$("#div_loading").hide(300);
				//alert( "Contrato Generado CERTINET: " + data );
				$("#result").show(300);
                $("#result").html("Contrato Generada CERTINET: " + data);
			});
			*/
		});

    });
});
	

	

</script>


</body>
</html>