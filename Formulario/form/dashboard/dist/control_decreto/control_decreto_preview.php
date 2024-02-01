<?php require_once('../../cn/cn_PDO.php');
 
//$id=str_replace("data","",$_REQUEST['id']);
$id_postulacion=$_REQUEST['id_postulacion'];
$totlaDsco=str_replace("data","",$_REQUEST['totlaDsco']);
$fecha_imp=date('Y-m-d');

if($id_postulacion==''){
	echo '...cargando';
	exit();
}

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
	p.FECHA_POST	
	
FROM 
	unegocios_nuevo.postulacion p 
	INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
WHERE p.ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_data.'</pre>';

$stmt_data = $con->prepare($sql_data);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();
$num_data =$stmt_data ->rowCount();	
//echo '::'.$num_convenios;

if ($rw_data  = $stmt_data ->fetch()){
	$id_postulacion   = $rw_data['ID_POSTULACION'];
	$programa         = utf8_encode($rw_data['POSTULACION']);
	$nombre_completo  = utf8_encode($rw_data['nombre_completo']);
	$rut              = $rw_data['RUT'];
	$nom_cordinadora_admision = utf8_encode($rw_data['nom_cordinadora_admision']);
	$valor_diplomado  = $rw_data['valor_diplomado'];
	$moneda           = $rw_data['moneda'];
	$fecha_inicio     = $rw_data['fecha_inicio'];
	$FECHA_POST       = $rw_data['FECHA_POST'];
	$cod_diploma      = $rw_data['cod_diploma'];
	$ceco             = $rw_data['Cod_interno'];
	
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
  $valor_diplomado = round($valor_diplomado,0, PHP_ROUND_HALF_UP);
}
?>


<?php
$arr_numerales = array('1','2','3','4','5','6','7','8','9','10','11','12');
$arr_dsco_abierto= array('2viii','3i','7i','7ii','11ii','12i','12ii');

$arr_numeral_con_firma = array('2','3','12');
$arr_dsco_con_firma = array('2vii','2viii','12i','12ii');

$cont=1;
$text_numeral='';
$lleva_firma='no';

foreach($_REQUEST as $campo => $valor ){
	//echo '['.$campo.']: '.var_dump($valor) .'<br>';
	if(in_array($campo, $arr_numerales)){
    if($cont>1){ $text_numeral .= '<br>'; }

    
		$text_numeral .= $cont.'. '.$valor;
		$cont++;
	}else{
		if(in_array($campo, $arr_dsco_abierto) && $valor<>'' && $campo<>'id_postulacion'){
			$text_numeral .= ' '.$valor.'%';
		}else{
			$pos = strpos($valor, 'data');
			if($valor<>'ver' && $pos === false && $campo<>'id_postulacion'){
				$text_numeral .= $valor;
			}
		}
	}

  // lleva firma
  if(in_array($campo, $arr_numeral_con_firma)){
    if(in_array($campo, $arr_dsco_con_firma)){
      $lleva_firma='si';
    }

  }
}
//echo '<hr>';


//exit();


?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Control Decreto</title>
<style>

	
</style>
  </head>
  <body>
    <div id="app" class="container">
    <?php /*    control_decreto_gnerar_pdf.php */ ?>
    
<form name="frm_control_decreto" action="control_decreto_preview_pdf.php" method="post">    
<p align="center"><strong>ANEXO<br>CONTROL CUMPLIMIENTO DECRETOS Y CONDICIONES DE CIERRE DE MATRíCULA</strong></p>

<div class="row">
    <div class="col-3">
      Nombre Responsable: 
    </div>
    <div class="col-3">
      <?php echo $nom_cordinadora_admision; ?>
    </div>
    <div class="col-3">
		<div class="form-check">
            <input type="checkbox" id="confirma" name="confirma"  value="confirma"> 
            <label class="form-check-label" for="confirma">Confirma </label>
		</div>
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      1 Nombre Alumno: 
    </div>
    <div class="col-3">
      <?php echo $nombre_completo; ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      2 Rut: 
    </div>
    <div class="col-3">
      <?php echo $rut; ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      3 Nombre Programa: 
    </div>
    <div class="col-9">
		<?php echo $programa; ?><br>
		<?php echo $cod_diploma.' ('.$ceco.')'; ?>
    </div>
</div>
<div class="row">
    <div class="col-3">
      ID: 
    </div>
    <div class="col-3">
      <?php echo $id_postulacion; ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      Precio lista Programa: 
    </div>
    <div class="col-3">
      <?php 
      if($moneda=='CLP'){
        echo number_format($valor_diplomado, 0, ",", ".").'.- '.$moneda; 
      }else{
        echo number_format($valor_diplomado, 2, ",", ".").'.- '.$moneda; 
      }
      ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      Fecha Postulacion: 
    </div>
    <div class="col-3">
      <?php echo date("d/m/Y H:i:s", strtotime($FECHA_POST)); ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      Fecha Contrato: 
    </div>
    <div class="col-3">
      
    <input type="date" name="fecha_contrato" id="fecha_contrato" value="<?php echo date('Y-m-d') ?>">
      
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<div class="row">
    <div class="col-3">
      Fecha Inicio Programa: 
    </div>
    <div class="col-3">
      <?php echo date("d/m/Y", strtotime($fecha_inicio)); ?>
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>  
<p></p>
<div class="row">
    <div class="col-3">
      Resolucion: 
    </div>
    <div class="col-3">
      197.20 / 302.20 / 523.21
      <input type="hidden" name="resolucion" id="resolucion" value="197.20 / 302.20 / 523.21">
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<p></p>
<?php echo $text_numeral; ?> 
 <input type="hidden" name="text_numeral" value="<?php echo $text_numeral; ?>">
<p></p>
<div class="row">
    <div class="col-3">
      Descuento Total:
    </div>
    <div class="col-3">
      <?php echo $totlaDsco; ?>%
      <input type="hidden" name="totlaDsco" id="totlaDsco" value="<?php echo $totlaDsco; ?>">
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
<p></p>
<!--
<div class="row">
    <div class="col-3">
      Precio Final:
    </div>
    <div class="col-3">
      $ <?php // echo number_format($precio_final, 0, ",", ".");?>.-
    </div>
    <div class="col-3">
      
    </div>
    <div class="col-3">
 
    </div>
</div>
    -->
<?php
if(false){ 
//if($lleva_firma=='si'){ ?>
<p></p>

<p><strong>Autoriza</strong></p>
<p></p>
<p></p>
<div class="row">
    <div class="col-6 text-center">
    <img src="ctrol_decreto_anunez.png" width="100" height="107"><br>
      Subdirectora de Educación Ejecutiva
    </div>
    <div class="col-6 text-center">
    <img src="ctrol_decreto_garrate.png" width="100" height="107"><br>
      Director Unidad de Extensión
    </div>
</div>
<p></p>
<p></p>
<div class="row">
    <div class="col-6 text-center">
    <img src="punto.png" width="100" height="107"><br>
      Director Departamento
    </div>
    <div class="col-6 text-center">
    <img src="punto.png" width="100" height="107"><br>
      Firma Estudiante
    </div>
</div>
<?php } ?>
<p></p>
<div class="row">
    <div class="col-12 text-center">
    <input type="hidden" name="id_postulacion" id="id_postulacion" value="<?php echo $id_postulacion; ?>" >
    <input type="hidden" name="con_firma" id="con_firma" value="<?php echo $lleva_firma; ?>" >
		<input type="submit" id="btn_guardar" name="guardar" class="btn btn-primary" value="Guardar" disabled> 
    <a href="control_decreto.php?id_postulacion=<?php echo $id_postulacion ?>" class="btn btn-danger">Cancelar</a>
    <!-- <button name="cancelar" class="btn btn-danger" onClick="window.close();">Cancelar</button> -->
	</div>
</div>

</form>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
	<script src="../../../../../bootstrap_4.4.1/js/bootstrap.min.js"></script>
    <script>
$(document).ready(function(){
  
  $("#confirma").click(function() {
    if( $(this).is(':checked') ) {
      $("#btn_guardar").removeAttr('disabled');
    }else{
      $("#btn_guardar").attr('disabled','disabled');
    }
  });

});			 
	</script>
  </body>
</html>