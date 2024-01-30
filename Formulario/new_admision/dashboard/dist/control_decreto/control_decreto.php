<?php
include('../../cn/cn_PDO.php'); ?>
<?php 
$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
	$id_postulacion=$_REQUEST['id_postulacion'];
}

if($id_postulacion==''){
	echo 'Error';
	exit();
}

$sql_data="SELECT 
	p.ID_POSTULACION,
	p.POSTULACION,
	CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo
FROM unegocios_nuevo.postulacion p WHERE p.ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_data.'</pre>';

$stmt_data = $con->prepare($sql_data);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();
$num_data =$stmt_data ->rowCount();	
//echo '::'.$num_convenios;

if ($rw_data  = $stmt_data ->fetch()){
	$id					= $rw_data['ID_POSTULACION'];
	$programa			= utf8_encode($rw_data['POSTULACION']);
	$nombre_completo	= utf8_encode($rw_data['nombre_completo']);
}
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
	#n1, #n2, #n3, #n4, #n5, #n6, #n7, #n8, #n9, #n10, #n11, #n12, #n13, #n14{ display:none;}
	
</style>
  </head>
  <body>
    <div id="app" class="container">

        <h1>Formulario Control Decreto</h1>
        <p><strong><?php echo $programa;?></strong><br>
        <?php echo $nombre_completo;?>
		</p>
<form name="frm_control_decreto" action="../control_decreto/control_decreto_preview.php" method="post" target="_self">
	<input type="hidden" id="id_postulacion" name="id_postulacion" value="<?php echo $id_postulacion;?>" >
	<input type="hidden" id="totlaDsco" name="totlaDsco" value="" >


 <fieldset class="card">
	<div class="form-check">
		<input type="checkbox" id="1" name="1"  value="Numeral I." class="numeral"> 
		<label class="form-check-label" for="1">I. Estimular Mérito Académico </label>
	</div>
	<div id="n1" class="n card-body">
		<input type="radio" class="dsco" name="op1" id="op1i" value="i 25%"> i. 25% Egresado FEN Uchile<br>
		<input type="radio" class="dsco" name="op1" id="op1ii" value="ii 20%"> ii. 20% Egresado Uchile (otras Facultades)<br>
		<input type="radio" class="dsco" name="op1" id="op1iii" value="iii 15%"> iii. 15% Egresado U. Consejo Rectores<br>
		<input type="radio" class="dsco" name="op1" id="op1iv" value="iv 10%"> iv. 10% IP y CFT<br>
		<input type="radio" class="dsco" name="op1" id="op1v" value="v 50%"> v. 50% Segundo programa. Mismo semestre o siguiente<br>
	</div>
 </fieldset>

<fieldset class="card">
<div class="form-check">
    <input type="checkbox" id="2" name="2" value="Numeral II."  class="numeral"> 
    <label class="form-check-label" for="2">II. Equidad / Inclusión</label>
</div>
<div id="n2" class="n card-body">
	<input type="radio" class="dsco" name="op2" id="op2i" value="i 25%"> i. 25% Regiones<br>
    <input type="radio" class="dsco" name="op2" id="op2ii" value="ii 20%"> ii. 20% Extranjero no residentes en chile<br>
    <input type="radio" class="dsco" name="op2" id="op2iii" value="iii 20%"> iii. 20% Pueblos originarios<br>
    <input type="radio" class="dsco" name="op2" id="op2iv" value="iv 20%"> iv. 20% estudios sup. Imcompletos<br>
    <input type="radio" class="dsco" name="op2" id="op2v" value="v 15%"> v. 15% Sin estudios superiores<br>
    <input type="radio" class="dsco" name="op2" id="op2vi" value="vi 35%"> vi. 35% Discapacidad física<br>
    <input type="radio" class="dsco" name="op2" id="op2vii" value="vii 25%"> vii. 25% equidad de género (menor 30% participación / últimos 2 periodos)<br>
    <input type="radio" class="dsco" name="op2" id="op2viii" value="viii"> viii. <input name="2viii" id="2viii" type="number" min="0" max="30" value=""> Situación económica personal<br>
</div>
</fieldset>

<fieldset class="card">
<div class="form-check">
    <input type="checkbox" id="3" name="3" class="numeral"  value="Numeral III."> 
    <label class="form-check-label" for="3">III. Priorizar Desarrollo Programa o Disciplina</label>
</div>
<div id="n3" class="n card-body">
	<input type="radio" class="dsco" name="op3" id="op3i" value="i"> i. <input name="3i" id="3i" type="number" min="0" max="100" value=""> Aprobado Decano solicitado Director Depto.<br>
    <input type="radio" class="dsco" name="op3" id="op3ii" value="ii 50%"> ii. 50% Evento o charla<br>
    <input type="radio" class="dsco" name="op3" id="op3iii" value="iii 20%"> iii. 20% Promoción focalizada (testimonio, campaña, apoyo comercializacón)<br>
</div>
</fieldset>

<fieldset class="card">
<div class="form-check">
    <input type="checkbox" id="4" name="4" class="numeral"  value="Numeral IV."> 
    <label class="form-check-label" for="4">IV. Favorecer Perfeccionamiento académico personal Uchile</label>
</div>
<div id="n4" class="n card-body">
	<input type="radio" class="dsco" name="op4" id="op4i" value="i 25%"> i. 25% Personal o colaboración Uchile con 22 horas semanales. Antigüedad 1 año. Con Nombramiento<br>
    <input type="radio" class="dsco" name="op4" id="op4ii" value="ii 50%"> ii. 50% Personal o colaboración FEN con 44 horas semanales. Antigüedad 1 año. Aprobación autoridad. Con Nombramiento<br>
    <input type="radio" class="dsco" name="op4" id="op4iii" value="iii 25%"> iii. 25% Personal o colaboración Uchile con 22 horas semanales. Antigüedad 1 año. Sin Nombramiento<br>
    <input type="radio" class="dsco" name="op4" id="op4vi" value="iv 100%"> iv. 100% Personal o colaboración FEN con 44 horas semanales. Antigüedad 1 año. Aprobación. 1 cupo anual por programa<br>
    <input type="radio" class="dsco" name="op4" id="op4v" value="v 20%"> v. 20% Hijos funcionarios. Con certificado familia<br>
</div>
</fieldset>

<fieldset class="card">
<div class="form-check">
    <input type="checkbox"  id="5" name="5" class="numeral"  value="Numeral V."> 
    <label class="form-check-label" for="5">V. Estudiantes institución / ayudantías, docencia</label>
</div>
<div id="n5" class="n card-body">
	<input type="radio" class="dsco" name="op5" id="op5i" value="i 25%"> i. 25% Retribución como investigación, ayudantías, no remunerada, inferior o igual a 15 horas semanales y máximo 6 meses<br>
    <input type="radio" class="dsco" name="op5" id="op5ii" value="ii 35%"> ii. 35% Retribución como investigación, ayudantías, no remunerada, inferior o igual a 15 horas semanales y superior 6 meses<br>
    <input type="radio" class="dsco" name="op5" id="op5iii" value="iii 40%"> iii. 40% Retribución como investigación, ayudantías, no remunerada, superior a 15 horas semanales y máximo 6 meses<br>
    <input type="radio" class="dsco" name="op5" id="op5iv" value="iv 50%"> iv. 50% Retribución como investigación, ayudantías, no remunerada, superior a 15 horas semanales y superior 6 meses<br>
    <input type="radio" class="dsco" name="op5" id="op5v" value="v 100%"> v. 100% Prácticas laborales o profesionales igual o superior a 150 horas, no remunerada<br>
</div>
</fieldset>

<fieldset class="card">
<div class="form-check">
    <input type="checkbox" id="6" name="6" class="numeral"  value="Numeral VI."> 
    <label class="form-check-label" for="6">VI. Formar personal de organismos del estado</label>
</div>
<div id="n6" class="n card-body">
	<input type="radio" class="dsco" name="op6" id="op6i" value="i 20%"> i. 20% Funcionarios de organismos del estado, planta o contrata, 44 horas y 3 años o menos en la institución, acreditar con certificado institución<br>
    <input type="radio" class="dsco" name="op6" id="op6ii" value="ii 25%"> ii. 25% Funcionarios de organismos del estado, planta o contrata, 44 horas y superior 3 años institución, acreditar con certificado instituión<br>
</div>
</fieldset>

<fieldset class="card">
    <div class="form-check">
        <input type="checkbox" id="7" name="7" class="numeral"  value="Numeral VII."> 
        <label class="form-check-label" for="7">VII. Convenio organismos públicos y privadas</label>
    </div>
    <div id="n7" class="n card-body">
        <input type="radio" class="dsco" name="op7" id="op7i" value="i">
        <input name="7i" id="7i" type="number" min="0" max="50" value=""> Respectivo convenio, extensivo a cónyuges e hijos
        <br>
        <input type="radio" class="dsco" name="op7" id="op7ii" value="ii">
        <input name="7ii" id="7ii" type="number" min="0" max="100" value=""> Para ciertos cupos pactados entre las partes
        <br>
    </div>
</fieldset>


<fieldset class="card">
<div class="form-check">
    <input type="checkbox" id="8" name="8" class="numeral"  value="Numeral VIII."> 
    <label class="form-check-label" for="8">VIII. Matrícula Anticipada</label>
</div>
<div id="n8" class="n card-body">
	<input type="radio" class="dsco" name="op8" id="op8i" value="i 30%"> i 30% 90 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8ii" value="ii 25%"> ii 25% 60 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8iii" value="iii 20%"> iii 20% 30 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8iv" value="iv 15%"> iv 15% 15 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8v" value="v 10%"> v 10% 10 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8vi" value="vi 5%"> vi 5% 3 días antes postulación del inicio programa<br>
    <input type="radio" class="dsco" name="op8" id="op8vii" value="vii 3%"> vii 3% Charla o evento promocional<br>
    <input type="radio" class="dsco" name="op8" id="op8viii_a" value="viii_a 25%"> viii 25% Descuento por volúmen: a) 2 alumnos de una misma organizacion *<br>
    <input type="radio" class="dsco" name="op8" id="op8viii_b" value="viii_b 30%"> viii 30% Descuento por volúmen: b) 3 a 10 alumnos de una misma organizacion *<br>
    (*) sin importar si el pago lo hace el alumno, la empresa o es cofinanciado
</div>
</fieldset>

<fieldset class="card">
    <div class="form-check">
        <input type="checkbox" id="9" name="9" class="numeral"  value="Numeral IX."> 
        <label class="form-check-label" for="9">IX. Incentivar el pago del arancel al contado.</label>
    </div>
    <div id="n9" class="n card-body">
        <input type="radio" class="dsco" name="op9" id="op9i" value="i 7%"> i 7% Pago contado ya sea en 1, 2 o 3 cuotas *<br>
        (*) este se acumula con todo el decreto
    </div>
</fieldset>

<fieldset class="card">
    <div class="form-check">
        <input type="checkbox" id="10" name="10" class="numeral"  value="Numera X."> 
        <label class="form-check-label" for="10">X. Materializar propuestas que se efectúen en el marco de la Ley Nº 19.886.</label>
    </div>
    <div id="n10" class="n card-body">
        <input type="radio" class="dsco" name="op10" id="op10i" value="i"> i La Facultad se encuentra facultada para ofertar en mercado público.<br>
        <input type="radio" class="dsco" name="op10" id="op10ii" value="ii"> ii En caso de convenio marco las
     condiciones comerciales de los mismos se publicarán en el respectivo catálogo
    electrónico, y se mantendrán vigentes por todo el período de duración del respectivo
    convenio marco<br>
        <input type="radio" class="dsco" name="op10" id="op10iii" value="iii"> iii Se podrá entregar descuento variable a las respectivas institiciones, mientras se asegure la correcta operación de cada proyecto<br>
    </div>
</fieldset>
 
<fieldset class="card">
    <div class="form-check">
        <input type="checkbox" id="11" name="11" class="numeral"  value="Numeral XI."> 
        <label class="form-check-label" for="11">XI. Postergación o renuncia.</label>
    </div>
    <div id="n11" class="n card-body">
        <input type="radio" class="dsco" name="op11" id="op11i" value="i 100%"> i 100% Para programas que tengan una duración superior a 1 mes, quedarán
    exentos del pago del 100% del arancel, siempre y cuando la renuncia se
    realice antes o dentro de la primera semana de iniciadas las clases.<br>
        <input type="radio" class="dsco" name="op11" id="op11ii" value="ii"> ii <input name="11ii" id="11ii" type="number" min="0" max="100" value=""> En el caso de los alumnos que soliciten la renuncia fundada con
    posterioridad a la primera semana de iniciadas las clases, se les podrá
    rebajar el remanente del arancel, en la proporción correspondiente al
    tiempo que falte para el término del programa, para lo cual deberán
    adjuntar los antecedentes que le sirvan de respaldo.<br>
        <input type="radio" class="dsco" name="op11" id="op11iii" value="iii 100%"> iii 100% Para aquellos programas que tengan una duración inferior a 1 mes, podrán
    quedar exentos del pago del 100% del arancel, siempre y cuando la
    renuncia se realice antes de iniciadas las clases.<br>
    </div>
</fieldset> 


<fieldset class="card">
	<div class="form-check">
		<input type="checkbox" id="12" name="12" class="numeral"  value="Numeral XII."> 
		<label class="form-check-label" for="12">XII. Caso fortuito o fuerza mayor.</label>
	</div>
	<div id="n12" class="n card-body">
		<input type="radio" class="dsco" name="op12" id="op12i" value="i"> i <input name="12i" id="12i" type="number" min="0" max="100" value=""> Decano aprueba resolución con casos debidamente acreditados y solicitados por el director depto. Se puede usar mientras se tramita resolución.<br>
		* se acumula con todo el decreto<br>
		<input type="radio" class="dsco" name="op12" id="op12ii" value="ii"> ii <input name="12ii" id="12ii" type="number" min="0" max="40" value=""> Descuento caso fortuito o fuerza mayor hasta 40% autorizado por director depto. Válido hasta que termine estado emergencia.<br>
		* se acumula con todo el decreto<br>
		<p>Asimismo, frente a cualquier nueva situación de caso fortuito o fuerza mayor que se presente, que requiera adoptar medidas para incentivar la matrícula a los programas, el Director de cada Departamento volverá a quedar habilitado para hacer uso de la facultad de ofrecer descuentos de hasta un 40% adicional a las rebajas establecidas en el presente acto administrativo.</p>
		
	</div>
</fieldset> 

<fieldset class="card">
	<div class="form-check">
		<input type="checkbox" id="13" name="13" class="numeral"  value="0. Numeral N/A 0%"> 
    	<label class="form-check-label" for="13">No Aplica.</label>
	</div>
</fieldset>

<p>Total descuento: <span id="span_total_desc"></span></p>     
<div class="row">
    <div class="col-12 text-center">
<input class="btn btn-primary" type="submit" name="ver" value="ver" formtarget="_self">
	</div>
</div>
</form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
	<!--
	<script src="../../../../../bootstrap_4.4.1/js/bootstrap.min.js"></script>
	-->
    <script>
$(document).ready(function(){
	/* primera carga -----------------------------*/
	
	$(".numeral").each(function(index, element) {
		var ctrl = "#n"+$(this).attr('id');
		if($(this).is(':checked') ) {
			$(ctrl).show(300); //oculto mediante id
		}else{
			$(ctrl).hide(300); //oculto mediante id
		}

        
    });
	/* ----------------------------------- */		
	
		$(".numeral").on( "click", function() {
			
			console.log($(this).attr('id'));
			
			var ctrl = "#n"+$(this).attr('id');
			var ctrl_input = "input[name=\"op"+$(this).attr('id')+"\"]";
		
			if($(this).is(':checked') ) {
				$(ctrl).show(300); //oculto mediante id
				$(ctrl_input).attr('required', 'required');
				
				if($(this).attr('id')==9 ){
					$(ctrl_input).prop('checked', true);
				}
				
			}else{
				$(ctrl).hide(300); //oculto mediante id
				$(ctrl_input).prop('checked', false);
				$(ctrl_input).removeAttr('required');
				
				if($(this).attr('id')==2 ){
					$("#2viii").val('');
					$("#2viii").removeAttr('required');
				}
				if($(this).attr('id')==3 ){
					$("#3i").val('');
					$("#3i").removeAttr('required');
				}
				
				if($(this).attr('id')==7 ){
					$("#7i").val('');
					$("#7ii").val('');
					$("#7i").removeAttr('required');
					$("#7ii").removeAttr('required');
				}
				
				if($(this).attr('id')==11 ){
					$("#11ii").val('');
					$("#11ii").removeAttr('required');
				}
				
				if($(this).attr('id')==12 ){
					$("#12i").val('');
					$("#12ii").val('');
					$("#12i").removeAttr('required');
					$("#12ii").removeAttr('required');
				}
				
			}
			
			_calculo_total_dsco();
			
/*			
			if(($(this).attr('id')!=2 ) && ($("#1").is(':checked') || $("#3").is(':checked') || $("#4").is(':checked') || $("#5").is(':checked') || $("#6").is(':checked') || $("#7").is(':checked') || $("#8").is(':checked') || $("#9").is(':checked') || $("#10").is(':checked') || $("#11").is(':checked') || $("#12").is(':checked'))){
				_on_off_2i_vii(true);
			}
			if(($(this).attr('id')==2 ) && !$("#1").is(':checked') && !$("#3").is(':checked') && !$("#4").is(':checked') && !$("#5").is(':checked') && !$("#6").is(':checked') && !$("#7").is(':checked') && !$("#8").is(':checked') && !$("#9").is(':checked') && !$("#10").is(':checked') && !$("#11").is(':checked') && !$("#12").is(':checked')){
				_on_off_2i_vii(false);
			}else{
				_on_off_2i_vii(true);
			}
			
			if(($(this).attr('id')!=3 ) && ($("#1").is(':checked') || $("#2").is(':checked') || $("#4").is(':checked') || $("#5").is(':checked') || $("#6").is(':checked') || $("#7").is(':checked') || $("#8").is(':checked') || $("#9").is(':checked') || $("#10").is(':checked') || $("#11").is(':checked') || $("#12").is(':checked'))){
				_on_off_3ii_iii(true);
				console.log('_on_off_3ii_iii(true)');
			}
			if(($(this).attr('id')==3 ) && !$("#1").is(':checked') && !$("#2").is(':checked') && !$("#4").is(':checked') && !$("#5").is(':checked') && !$("#6").is(':checked') && !$("#7").is(':checked') && !$("#8").is(':checked') && !$("#9").is(':checked') && !$("#10").is(':checked') && !$("#11").is(':checked') && !$("#12").is(':checked')){
				_on_off_3ii_iii(false);
				console.log('_on_off_3ii_iii(false)');
			}else{
				_on_off_3ii_iii(true);
				console.log('_on_off_3ii_iii(true)');
			}			

			if(($(this).attr('id')!=12 ) && ($("#1").is(':checked') || $("#2").is(':checked') || $("#4").is(':checked') || $("#5").is(':checked') || $("#6").is(':checked') || $("#7").is(':checked') || $("#8").is(':checked') || $("#9").is(':checked') || $("#10").is(':checked') || $("#11").is(':checked') || $("#3").is(':checked'))){
				_on_off_12i(true);
				console.log('_on_off_12i(true)');
			}
			if(($(this).attr('id')==12 ) && !$("#1").is(':checked') && !$("#2").is(':checked') && !$("#4").is(':checked') && !$("#5").is(':checked') && !$("#6").is(':checked') && !$("#7").is(':checked') && !$("#8").is(':checked') && !$("#9").is(':checked') && !$("#10").is(':checked') && !$("#11").is(':checked') && !$("#3").is(':checked')){
				_on_off_12i(false);
				console.log('_on_off_12i(false)');
			}else{
				_on_off_12i(true);
				console.log('_on_off_12i(true)');
			}			
			
		$("#1").attr("disabled",false);
		$("#4").attr("disabled",false);
		$("#5").attr("disabled",false);
		$("#6").attr("disabled",false);
		$("#7").attr("disabled",false);
		$("#8").attr("disabled",false);
		$("#10").attr("disabled",false);
		$("#11").attr("disabled",false);
		
		if($(this).attr('id')==1 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
	
		if($(this).attr('id')==4 && $(this).is(':checked') ){
			$("#1").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
	
		if($(this).attr('id')==5 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#1").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
		if($(this).attr('id')==6 && $(this).is(':checked') ){
			console.log('6:: '+$(this).is(':checked'))
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#1").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
		if($(this).attr('id')==7 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#1").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
		if($(this).attr('id')==8 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#1").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
		if($(this).attr('id')==10 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#1").attr("disabled",true);
			$("#11").attr("disabled",true);
		}
		
		if($(this).attr('id')==11 && $(this).is(':checked') ){
			$("#4").attr("disabled",true);
			$("#5").attr("disabled",true);
			$("#6").attr("disabled",true);
			$("#7").attr("disabled",true);
			$("#8").attr("disabled",true);
			$("#10").attr("disabled",true);
			$("#1").attr("disabled",true);
		}

*/
		 });
		 
		 var arr_dsco_abierto = ['2viii','3i','7i','7ii','11ii','12i','12ii'];
		 
		 $(".dsco").on( "click", function() {
		
			_calculo_total_dsco();

		 });

		function _calculo_total_dsco(){
			var total_dsco = 0; 
			 
			$(".dsco").each(function() {
				
				//console.log(':: '+$(this).attr('id'));
				
				if($(this).is(':checked') ) {
					
					var id=$(this).attr('id').replace("op","");
	
					//console.log('ID: '+id);
					//console.log('esta en aray? '+jQuery.inArray( id, arr_dsco_abierto ));
					
					if(jQuery.inArray( id, arr_dsco_abierto )>=0){
						var ctrl_input = "#"+id;
						//console.log('ctrl_input: '+ctrl_input);
						total_dsco=Number(total_dsco) + Number($(ctrl_input).val());
					}else{
						total_dsco=Number(total_dsco) + Number((this.value + '').replace(/[^0-9]/g, ''));
					}
				}
            });
			console.log('total_dsco: '+total_dsco);
			$("#span_total_desc").html(total_dsco+'%');
			$("#totlaDsco").val('data'+total_dsco);
			
		}

		 $("#2viii").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#3i").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#7i").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#7ii").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#11ii").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#12i").on( "change", function() {
			_calculo_total_dsco();

		 });
		 $("#12ii").on( "change", function() {
			_calculo_total_dsco();

		 });
		/* -------------------------- */ 		 		 		 		 
		
		 
		 $("input[name='op12']").on( "click", function() {

			 $("#12i").removeAttr('required');
			 $("#12ii").removeAttr('required');
			 
			 var ctrl = "#"+$(this).attr('id').replace("op","");
			 $(ctrl).attr('required', 'required');

		 });
		 
		 $("input[name='op2']").on( "click", function() {

			 $("#2viii").removeAttr('required');
			 
			 var ctrl = "#"+$(this).attr('id').replace("op","");
			 $(ctrl).attr('required', 'required');

		 });		 

		 $("input[name='op3']").on( "click", function() {

			 $("#3i").removeAttr('required');
			 
			 var ctrl = "#"+$(this).attr('id').replace("op","");
			 $(ctrl).attr('required', 'required');

		 });
		 $("input[name='op7']").on( "click", function() {

			 $("#7i").removeAttr('required');
			 $("#7ii").removeAttr('required');
			 
			 console.log($(this).attr('id'));
			 var ctrl = "#"+$(this).attr('id').replace("op","");
			 $(ctrl).attr('required', 'required');

		 });
		 
		 $("input[name='op11']").on( "click", function() {

			 $("#11ii").removeAttr('required');
			 
			 var ctrl = "#"+$(this).attr('id').replace("op","");
			 $(ctrl).attr('required', 'required');

				console.log("#"+$(this).attr('id').replace("op",""));

		 });		 

/*		 
		function _on_off_2i_vii(tof){
				$("#op2i").attr("disabled",tof);
				$("#op2ii").attr("disabled",tof);
				$("#op2iii").attr("disabled",tof);
				$("#op2iv").attr("disabled",tof);
				$("#op2v").attr("disabled",tof);
				$("#op2vi").attr("disabled",tof);
				$("#op2vii").attr("disabled",tof);			
		}
		
		function _on_off_3ii_iii(tof){
				$("#op3ii").attr("disabled",tof);
				$("#op3iii").attr("disabled",tof);
				console.log('_on_off_3ii_iii('+tof+') ejecutado');
		}
		function _on_off_12i(tof){
				$("#op12i").attr("disabled",tof);
				$("#12i").attr("disabled",tof);
				
				console.log('_on_off_12ii_iii('+tof+') ejecutado');
		}
*/		
		 
});			 
	</script>
  </body>
</html>