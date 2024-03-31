<?php 
include('../../cn/cn_PDO.php');

$id_postulacion=$_REQUEST['id_postulacion'];

$sql_valida="SELECT 
    f.declaracion_64, 
    f.id_declaracion_64_dec5,
    cu.documento,
    cu.packageID,
    cu.documentID
    FROM
        intranet.firma_digital f
        LEFT JOIN intranet.certinet_upload cu ON f.id_postulacion=cu.id_postulacion
    WHERE 
        cu.documento IN ('contrato','declaracion')
    AND cu.haserror='false'
    AND f.id_postulacion=$id_postulacion";

    $stmt_valida = $con->prepare($sql_valida);
	$stmt_valida->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_valida->execute();

    $arr_doc['contrato']=array();
    $arr_doc['declaracion']=array();

while ($row_valida = $stmt_valida->fetch()){
    
    $arr_doc[$row_valida['documento']][] = $row_valida['packageID'];
    
}    
//echo '<pre>'.print_r($arr_doc['contrato'],true).'</pre>';
//echo '<pre>'.print_r($arr_doc['declaracion'],true).'</pre>';

if(!empty($arr_doc['contrato'])){
    if($arr_doc['contrato'][0]<>''){
        ?>
        <button class="btn btn-success" id="btn_link_firma"> Link firma documentos <i class="bi bi-envelope"></i></button>
    <?php
    }
}elseif(!empty($arr_doc['declaracion'])){
    if($arr_doc['declaracion'][0]<>''){
    ?>
        <button class="btn btn-success" id="btn_link_firma"> Link firma documentos <i class="bi bi-envelope"></i></button>
    <?php
    }
}


/*
if(($arr_doc['contrato'][0]<>'') and ($arr_doc['declaracion'][0]<>'')){
    ?>
    <button class="btn btn-success" id="btn_link_firma"> Link firma documentos <i class="bi bi-envelope"></i></button>
<?php
}
*/
?>