<?php 
include('../../cn/cn_PDO.php');

$id_postulacion=$_REQUEST['id_postulacion'];

$sql_valida="SELECT 
    f.contrato_ps_64, 
    f.id_contrato_ps_64_dec5,
    cu.packageID,
    cu.documentID
FROM
    intranet.firma_digital f
    LEFT JOIN intranet.certinet_upload cu ON f.id_postulacion=cu.id_postulacion
WHERE 
	cu.documento='contrato'
    AND cu.haserror='false'
   and f.id_postulacion=$id_postulacion";

$stmt_valida = $con->prepare($sql_valida);
	$stmt_valida->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_valida->execute();

$id_contrato_ps_64_dec5='';

if ($row_valida = $stmt_valida->fetch()){
    $contrato_ps_64         = $row_valida['contrato_ps_64']; 
    $id_contrato_ps_64_dec5 = $row_valida['id_contrato_ps_64_dec5'];
    $packageID              = $row_valida['packageID'];
    $documentID             = $row_valida['documentID'];
}    

if($packageID<>''){
    ?>
    
    <i class="fas fa-file-alt"></i>
    <a href="../cetinet/get_document.php?id_postulacion=<?php echo $id_postulacion;?>&documento=contrato" target="_blank" id="lnk_cs_gen">Contrato</a> 
    <i class="bi bi-download"></i> <!-- <i class="bi bi-trash" id="dell_cs"></i> -->
    <?php
}elseif($id_contrato_ps_64_dec5<>''){
?>

<i class="fas fa-file-alt"></i>
<a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_doc_x_id_documento.php?id_documento=<?php echo $id_declaracion_64_dec5;?>" target="_blank" id="lnk_cs_gen">Contrato</a> 
<i class="bi bi-download"></i> <!-- <i class="bi bi-trash" id="dell_cs"></i> -->
<?php
}else{
?>
<i class="fas fa-file-alt"></i>
<a href="../contrato/contrato_prestacion_servicio_frm.php?form_id=<?php echo $id_postulacion; ?>" target="_blank" id="lnk_cs">Contrato</a> 
<?php
}
?>