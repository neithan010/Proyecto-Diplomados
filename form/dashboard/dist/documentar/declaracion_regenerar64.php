<?php
include('../../cn/cn_PDO.php');	

$id_postulacion=$_REQUEST['form_id'];

$sql_postulante="SELECT 
    UPPER(d.DIPLOMADO) as programa,
    CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo,
    p.RUT,
    p.cod_diploma
FROM 
    unegocios_nuevo.postulacion p 
    INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
WHERE 
    p.ID_POSTULACION=". $id_postulacion;

//echo '<pre>'.$sql_postulante.'</pre>';

$stmt_postulante = $con->prepare($sql_postulante);
$stmt_postulante ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulante ->execute();
$num_postulantea =$stmt_postulante ->rowCount();	
//echo '::'.$num_postulantea;

if ($rw_data  = $stmt_postulante ->fetch()){
    $programa           = mb_strtoupper(utf8_encode($rw_data['programa']));
    $nombre_completo    = mb_strtoupper(utf8_encode($rw_data['nombre_completo']));
    $rut                = $rw_data['RUT'];
    $cod_diploma        = $rw_data['cod_diploma'];
    
}

//echo $programa;
//exit();


//--------------------------------------------------
// TEXTO diplomas con apuntes de nievelacion
//--------------------------------------------------
$array_nivelacion=array('XX','DF','DIMF','DAE','DEAE','DGCo','DMV','DDM','DMR','DGDCo','DMDCE', 'DICDM','DGCD');

$arr_cod_diploma=explode(".",$cod_diploma);



if(array_search($arr_cod_diploma[0],$array_nivelacion)>0){ 
    $fp = fopen("cartas/declaracion_apuntes.txt","r");
}elseif($arr_cod_diploma[0]=='DP'){
    $fp = fopen("cartas/declaracion_DGPro.txt","r");
}elseif($arr_cod_diploma[0]=='DEGP'){
    $fp = fopen("cartas/declaracion_DEGP.txt","r");
}else{
    $fp = fopen("cartas/declaracion.txt","r");
}

while ($linea= fgets($fp,1024)){

    $texto = str_replace("!NOMBRE_COMPLETO!",strtoupper($nombre_completo),$linea);
    $texto = str_replace("!NR!",$rut,$texto);
    $texto = str_replace("!DIPLOMA!",strtoupper($programa),$texto);
}	

setlocale(LC_ALL,"es_ES");
//echo strftime("%A %d de %B del %Y");
$fecha_imp = strftime("%d de %B del %Y");
//$fecha_imp=date('d').' de '.date('F Y');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaracion Jurada</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <form action="" id="form1" name="form1" method="POST">
        <div class="row align-items-start ">
            <div class="col col-12 text-center my-5">
                <h1 >DECLARACIÓN</h1>
            </div>
            <div class="col col-12 text-justify my-5">
            <p>
            <textarea name="texto_declaracion" id="texto_declaracion" class="form-control" rows="10"><?php echo $texto;?></textarea>
            </p>
            <input type="text" name="fecha_imp" id="fecha_imp" value="<?php echo $fecha_imp;?>">
            </div>

        </div>
        <div class="text-center">
            
            
            <button class="btn btn-primary" id="btn_imp" >Re Generar documento</button> 
            
            
        </div>
        <input type="hidden" name="form_id" id="form_id" value="<?php echo $id_postulacion;?>">
        <input type="hidden" name="rut" id="rut" value="<?php echo $rut;?>">
    </form>

    <div id="result" class="alert alert-info" role="alert"></div>

    </div>

<script src="../js/jquery-3.5.1.min.js"></script>
<script>
$( document ).ready(function() {
 
    $("#result").hide();

    $("#btn_imp" ).click(function(){
        event.preventDefault();

           //$("#form1").attr('action','declaracion_df.php');
		   //console.log(':: '+$("#form1").attr('action'));
		   //$("#form1").submit();
        $.post( "../../../../cdg/postulacion/admision/firma_digital/declaracion_df.php", 
		{ 

			form_id: document.getElementById('form_id').value,
			texto_declaracion : document.getElementById('texto_declaracion').value,
			fecha_imp : document.getElementById('fecha_imp').value,
            RUT : document.getElementById('rut').value,
			
			
			doc_fd : 'dj'
				
		})
			.done(function( data ) {
			//alert( "Contrato Generado DEC: " + data );
            $("#result").show(300);
            $("#result").html("(Documente re generado) " + data);
            /*
			$.post( "../certinet/crear_declaracion.php", 
			{ 

                id_postulacion: document.getElementById('form_id').value
					
			})
				.done(function( data ) {
				//alert( "Declaracion Generada DEC: " + data );
                $("#result").show(300);
                $("#result").html("Declaracion Generada CERTINET: " + data);
				
			});
            */
		});
    });

    
});

</script>
</body>
</html>