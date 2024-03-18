<?php
session_start();
$usuario=$_SESSION['usuario_intranet'];

include('../../cn/cn_PDO.php');

$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
}
if($id_postulacion==''){
    echo 'Error al recibir ID';
    exit();
}


$sql_postulante="SELECT 
    p.ID_POSTULACION as id_postulacion,
    p.cod_diploma,
    d.Cod_interno AS ceco,
    d.DIPLOMADO as programa,
    p.FECHA_POST as fecha_postulacion,
    pe.fecha_in AS fecha_aceptada,
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.APELLIDO_MAT,
    CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo,
    p.RUT,
    p.ID_FINANCIAMIENTO,
    d.nom_cordinadora_admision,
	CONCAT_WS(' ',p.DIREC_PARTICULAR, p.numero, if(p.depto_of_par<>'',concat('of/depto ',p.depto_of_par),''),',',com.nombre,',',reg.nombre) direccion,
	p.CELULAR as celular,
	p.TELEFONO as telefono,
	p.EMAIL as email,
    p.NACIONALIDAD as nacionalidad,
    p.RUT_EMPRESA,
    p.RAZON_SOCIAL,
    CONCAT(p.etapa, p.estado) AS ee,
    d.tipo_programa,
    d.modalidad_programa

    FROM 
        unegocios_nuevo.postulacion p 
        INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
        LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION AND concat(pe.etapa,pe.estado)= 2020
        LEFT  JOIN unegocios_nuevo.comunas com ON com.cod_comuna=p.COMUNA
	    LEFT  JOIN unegocios_nuevo.regiones reg ON reg.cod_region=p.region
    WHERE 
        p.ID_POSTULACION=". $id_postulacion;

$stmt_postulante = $con->prepare($sql_postulante);
$stmt_postulante ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulante ->execute();
$num_postulantea =$stmt_postulante ->rowCount();	
//echo '::'.$num_postulantea;

if ($rw_data  = $stmt_postulante ->fetch()){

	$id_postulacion     = $rw_data['id_postulacion'];
    $cod_diploma        = $rw_data['cod_diploma'];
    $ceco               = $rw_data['ceco'];
	$programa           = utf8_encode($rw_data['programa']);
	$fecha_postulacion  = $rw_data['fecha_postulacion'];
    $fecha_aceptada     = $rw_data['fecha_aceptada'];
    $nombres            = $rw_data['NOMBRES'];
    $apellido_pat       = $rw_data['APELLIDO_PAT'];
    $apellido_mat       = $rw_data['APELLIDO_MAT'];
    $nombre_completo    = utf8_encode($rw_data['nombre_completo']);
    $rut                = $rw_data['RUT'];
    $direccion          = utf8_encode($rw_data['direccion']);
    $celular            = utf8_encode($rw_data['celular']);
    $telefono           = utf8_encode($rw_data['telefono']);
    $email              = utf8_encode($rw_data['email']);
    $nacionalidad       = utf8_encode($rw_data['nacionalidad']);
    $qpaga              = $rw_data['ID_FINANCIAMIENTO'];
    $rut_empresa        = $rw_data['RUT_EMPRESA'];
    $razon_social       = utf8_encode($rw_data['RAZON_SOCIAL']);
    $etapa_estado       = $rw_data['ee'];
    $tipo_programa      = $rw_data['tipo_programa'];
    $modalidad_programa = $rw_data['modalidad_programa'];
}

$sql_data_programa="SELECT 
    d.valor_diplomado,
    d.moneda
FROM 
    intranet.diplomados d 
WHERE 
    d.cod_diploma='".$cod_diploma."'";

$stmt_programa = $con->prepare($sql_data_programa);
$stmt_programa ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_programa ->execute();
$num_postulantea =$stmt_programa ->rowCount();	
//echo '::'.$num_postulantea;

if ($rw_programa  = $stmt_programa ->fetch()){

	$valor_programa    = $rw_programa['valor_diplomado'];
    $moneda             = $rw_programa['moneda'];
	
}

$sql_control_decreto="SELECT
    idpostulacion, 
    responsable, 
    alumno, 
    programa, 
    fecha_matricula, 
    GROUP_CONCAT(distinct qpersona SEPARATOR ',') as qpersona, 
    sum(dco_aplicable) dco_aplicable, 
    GROUP_CONCAT(distinct decreto SEPARATOR ',') as decreto, 
    GROUP_CONCAT(distinct decreto_letra SEPARATOR ',') as decreto_letra, 
    corregido
FROM 
    intranet.control_decreto cd
WHERE 
    cd.idpostulacion=".$id_postulacion."
    AND cd.corregido IS null";

    $stmt_cd = $con->prepare($sql_control_decreto);
    $stmt_cd ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_cd ->execute();
    $num_cd =$stmt_cd ->rowCount();	
    //echo '::'.$num_postulantea;
    
    $existe_control=0;

    if ($rw_cd  = $stmt_cd ->fetch()){
    
        $responsable        = $rw_cd['responsable'];
        $alumno             = $rw_cd['alumno'];
        //$programa           = $rw_cd['programa'];
        $fecha_matricula    = $rw_cd['fecha_matricula'];
        $qpersona           = $rw_cd['qpersona'];
        $dsco               = $rw_cd['dco_aplicable'];
        $decreto            = $rw_cd['decreto'];
        $decreto_letra      = $rw_cd['decreto_letra'];
        $corregido          = $rw_cd['corregido'];
        $existe_control=1;
    }
    
$sql_postulacion_data_pagos="SELECT 
	id_postulacion, 
	id_financiamiento, 
	moneda_pago, 
	monto_tc1_link_pago, 
	monto_tc2_link_pago, 
	monto_usd_link_pago, 
	declaracion_jurada
FROM 
	intranet.postulacion_data_pagos pdp
WHERE 
	pdp.id_postulacion=".$id_postulacion;

    $stmt_pdp = $con->prepare($sql_postulacion_data_pagos);
    $stmt_pdp ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_pdp ->execute();
    $num_pdp =$stmt_pdp ->rowCount();	

    if ($rw_pdp  = $stmt_pdp ->fetch()){

        $id_financiamiento      = $rw_pdp['id_financiamiento'];
        $moneda_pago            = $rw_pdp['moneda_pago'];
        $monto_tc1_link_pago    = $rw_pdp['monto_tc1_link_pago'];
        $monto_tc2_link_pago    = $rw_pdp['monto_tc2_link_pago'];
        $monto_usd_link_pago    = $rw_pdp['monto_usd_link_pago'];
        $declaracion_jurada     = $rw_pdp['declaracion_jurada'];  
    }else{
        $declaracion_jurada = '';
        $moneda_pago        = 'CLP';
        $monto_usd_link_pago ='';
    }

    
    $sql_uf="SELECT v.uf FROM intranet.valores_economicos v WHERE v.fecha_valor=CURDATE()";

    $stmt_uf = $con->prepare($sql_uf);
    $stmt_uf ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_uf ->execute();
    $num_uf =$stmt_uf ->rowCount();	

    if ($rw_uf  = $stmt_uf ->fetch()){

        $uf      = $rw_uf['uf'];
        
    }else{
        $uf = '';
    }


    $sql_documentos_generados="SELECT distinct documento FROM intranet.postulacion_documentos d WHERE d.idpostulacion=".$id_postulacion;

    $stmt_documentos_generados = $con->prepare($sql_documentos_generados);
    $stmt_documentos_generados ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_documentos_generados ->execute();
    $num_documentos_generados =$stmt_documentos_generados ->rowCount();	

    $arr_documentos=array();
    while ($rw_doc = $stmt_documentos_generados ->fetch()){
        $arr_documentos[] = $rw_doc['documento'];
    }
    //echo '::<pre>'.print_r($arr_documentos, true).'</pre>';

    
    if (in_array("control_decreto.pdf", $arr_documentos)) {
        //echo "Existe control_decreto.pdf";
        $dir_cp_org="../../../../cdg/postulacion/admision/Fichas/".$id_postulacion."/control_decreto.pdf";
        $dir_cp_new="../../Fichas/".$id_postulacion."/control_decreto.pdf";
        if (file_exists($dir_cp_new)) {
            $dir_cp=$dir_cp_new;
        }else{
            $dir_cp=$dir_cp_org;
        }
    }else{
        //echo "NO Existe control_decreto.pdf";
        $dir_cp="#";
    }


    /*
    if (in_array("contrato_servicio.pdf", $os)) {
        echo "Existe contrato_servicio.pdf";
    }else{
        echo "NO Existe contrato_servicio.pdf"; 
    }
    */

$sql_firma_documento="SELECT 
    f.declaracion_firmado, 
    f.id_declaracion_64_dec5, 
    f.declaracion_64,

    f.contrato_ps_firmado,
    f.id_contrato_ps_64_dec5, 
    f.contrato_ps_64
FROM 
    intranet.firma_digital f 
WHERE 
    f.id_postulacion='".$id_postulacion."'";

$stmt_firma_documento = $con->prepare($sql_firma_documento);
$stmt_firma_documento ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_firma_documento ->execute();
$num_firma_documento = $stmt_firma_documento ->rowCount();	
//echo '::'.$num_postulantea;

$declaracion_firmado    = '';
$id_declaracion_64_dec5 = '';
$declaracion_64         = '';
$contrato_ps_firmado    = '';
$id_contrato_ps_64_dec5 = '';
$contrato_ps_64         = '';

if ($rw_doc  = $stmt_firma_documento ->fetch()){

    $declaracion_firmado    = $rw_doc['declaracion_firmado'];
    $id_declaracion_64_dec5 = $rw_doc['id_declaracion_64_dec5'];
    $declaracion_64         = $rw_doc['declaracion_64'];
    $contrato_ps_firmado    = $rw_doc['contrato_ps_firmado'];
    $id_contrato_ps_64_dec5 = $rw_doc['id_contrato_ps_64_dec5'];
    $contrato_ps_64         = $rw_doc['contrato_ps_64'];

}
$sql_firma_certinet="SELECT  
    cu.documento,
    cu.packageID,
    cu.documentID
FROM 
	intranet.certinet_upload cu
WHERE 
    cu.id_postulacion=".$id_postulacion."
    AND cu.haserror='false'";

$stmt_firma_certinet = $con->prepare($sql_firma_certinet);
$stmt_firma_certinet ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_firma_certinet ->execute();
$num_firma_certinet = $stmt_firma_certinet ->rowCount();	

$arr_firma_certinet['contrato']=array();
$arr_firma_certinet['declaracion']=array();

    while ($rw_doc  = $stmt_firma_certinet ->fetch()){

        $arr_firma_certinet[$rw_doc['documento']]=array(
            "documento" => $rw_doc['documento'],
            "packageID" => $rw_doc['packageID'],
            "documentI" => $rw_doc['documentID']
        );       

    }   

$sql_comprobante_pago="SELECT 
    cp.id_postulacion,
    cp.n,
    cp.fecha
FROM 
    intranet.comprobante_pago cp
WHERE 
    cp.corregido IS null
    AND cp.id_postulacion='".$id_postulacion."'";

$stmt_comprobante_pago = $con->prepare($sql_comprobante_pago);
$stmt_comprobante_pago ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_comprobante_pago ->execute();
$num_comprobante_pago = $stmt_comprobante_pago ->rowCount();	
//echo '::'.$num_comprobante_pago;
$n='';
if ($rw_cp  = $stmt_comprobante_pago ->fetch()){

    $n                      = $rw_cp['n'];
    $fecha_comprobante_pago = $rw_cp['fecha'];
}

// - - - - - - - - - - -- - - - -  
// Link pago diferidos
// - - - - - - - -- - - - - - - - 

$sql_link_pagos_df="SELECT 
    id_pago, tc, id_postulacion, usuario, clave, nombre, rut, direccion, email, producto, monto, fecha, email_responsable
FROM 
    intranet.pagos_diferido pd
WHERE 
    pd.id_postulacion='".$id_postulacion."'

ORDER BY pd.fecha";

//echo '<pre>'.$sql_link_pagos_df.'</pre>';

$stmt_link_pagos_df = $con->prepare($sql_link_pagos_df);
$stmt_link_pagos_df ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_link_pagos_df ->execute();
$num_link_pagos_df = $stmt_link_pagos_df ->rowCount();	


$arr_link_pagos_df=array();

while ($rw_link_pagos_df  = $stmt_link_pagos_df ->fetch()){
    $arr_link_pagos_df[]=array(
        "id_pago"=> $rw_link_pagos_df['id_pago'],
        "tc"=> $rw_link_pagos_df['tc'],
        "id_postulacion"=> $rw_link_pagos_df['id_postulacion'],
        "usuario"=> $rw_link_pagos_df['usuario'],
        "clave"=> $rw_link_pagos_df['clave'],
        "nombre"=> $rw_link_pagos_df['nombre'],
        "rut"=> $rw_link_pagos_df['rut'],
        "direccion"=> $rw_link_pagos_df['direccion'],
        "email"=> $rw_link_pagos_df['email'],
        "producto"=> $rw_link_pagos_df['producto'],
        "monto"=> $rw_link_pagos_df['monto'],
        "fecha"=> $rw_link_pagos_df['fecha'],
        "email_responsable"=> $rw_link_pagos_df['email_responsable']
    );

}

// - - - - - - - - - - -- - - - -  
// Pagos recibidos
// - - - - - - - -- - - - - - - - 

$sql_pagos_recibidos="SELECT 
    pd.monto,
    pdr.amount,
    pdr.`status`,
    pdr.session_id,
    pdr.authorization_code,
    pdr.card_number,
    pdr.transaction_date,
    pdr.installments_number
FROM 
    intranet.pagos_diferido pd
    INNER JOIN intranet.pagos_diferido_recibidos pdr ON pd.id_postulacion=pdr.id_postulacion AND pdr.id_pago=pd.id_pago
WHERE 
    pdr.corregido IS null
    and pd.id_postulacion='".$id_postulacion."'

ORDER BY pdr.transaction_date";

$stmt_pagos_recibidos = $con->prepare($sql_pagos_recibidos);
$stmt_pagos_recibidos ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_pagos_recibidos ->execute();
$num_pagos_recibidos = $stmt_pagos_recibidos ->rowCount();	
//echo '::'.$num_comprobante_pago;

$arr_pagos_recibidos=array();

while ($rw_pagos_recibidos  = $stmt_pagos_recibidos ->fetch()){
    $arr_pagos_recibidos[]=array(
        "monto" => $rw_pagos_recibidos['monto'],
        "amount" => $rw_pagos_recibidos['amount'],
        "status" => $rw_pagos_recibidos['status'],
        "session_id" => $rw_pagos_recibidos['session_id'],
        "authorization_code" => $rw_pagos_recibidos['authorization_code'],
        "card_number" => $rw_pagos_recibidos['card_number'],
        "transaction_date" => $rw_pagos_recibidos['transaction_date'],
        "num_cuotas" => $rw_pagos_recibidos['installments_number']
    );

}

$sql_envio_link_pago="SELECT
    fecha_email, 
    log_envio
FROM 
    intranet.postulacion_descuento pd 
WHERE pd.id_postulacion=".$id_postulacion;

$stmt_envio_link_pago = $con->prepare($sql_envio_link_pago);
$stmt_envio_link_pago ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_envio_link_pago ->execute();
$num_envio_link_pago = $stmt_envio_link_pago ->rowCount();	

$fecha_email='';
$log_envio='';

if ($rw_envio_link_pago  = $stmt_envio_link_pago ->fetch()){
    
    $fecha_email=$rw_envio_link_pago['fecha_email'];
    $log_envio=$rw_envio_link_pago['log_envio'];
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
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" type="text/css" href="../css/colorbox.css"/>
    <style>
        #header{
            height: 60px;
            background-color: #AED6F1;
        }
    </style>
</head>
<body>
<div id="header">

</div>    
<div class="container">
    <div class="row align-items-start">
        <div class="col col-2 text-end">
        ID:
        </div>
        <div class="col col-10">
        <?php echo $id_postulacion;?>
        </div>
    </div> 

    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Programa: 
        </div>
        <div class="col col-10">
        <?php echo $programa;?>
        </div>
    </div>    
    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Cod Programa: 
        </div>
        <div class="col col-2">
        <?php echo $cod_diploma;?>
        </div>
        <div class="col col-2 text-end">
        CECO: 
        </div>
        <div class="col col-2">
        <?php echo $ceco;?>
        </div>
    </div> 

    <div class="row align-items-start mt-2">
        <div class="col col-2 text-end">
        Nombre: 
        </div>
        <div class="col col-10">
        <?php echo $nombre_completo;?>
        </div>
    </div> 

    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Rut/Pasaporte: 
        </div>
        <div class="col col-2">
        <?php echo $rut;?>
        </div>
        <div class="col col-2 text-end">
        Nacionalidad: 
        </div>
        <div class="col col-4">
        <?php echo $nacionalidad;?>
        </div>
    </div> 

    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Dirección: 
        </div>
        <div class="col col-10">
        <?php echo $direccion;?>
        </div>
    </div>

    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Celular: 
        </div>
        <div class="col col-10">
        <?php echo $celular;?>
        </div>
    </div>

    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Email: 
        </div>
        <div class="col col-10">
        <?php echo $email;?>
        </div>
    </div>
    <div class="row align-items-start mt-2">
        <div class="col col-2 text-end">
            Financiamiento:
        </div>
        <div class="col col-10">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="qpaga" id="rd_int" data="<?php echo $id_postulacion;?>" value="Interesado" <?php if($qpaga=='Interesado'){echo 'checked';}?>>
                <label class="form-check-label" for="rd_int">Interesado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="qpaga" id="rd_emp" data="<?php echo $id_postulacion;?>" value="Empresa" <?php if($qpaga=='Empresa'){echo 'checked';}?>>
                <label class="form-check-label" for="rd_emp">Empresa</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="qpaga" id="rd_intemp" data="<?php echo $id_postulacion;?>" value="Interesado/Empresa" <?php if($qpaga=='Interesado/Empresa'){echo 'checked';}?>>
                <label class="form-check-label" for="rd_intemp">Mixto</label>
            </div>
            
        </div>
    </div>




    <div class="row align-items-start p-5">
        <div class="col"><i class="fas fa-file-alt"></i>
        <a href="https://unegocios.uchile.cl/wp-content/uploads/2020/12/Reglamento-Curso-Unegocios_VERSION-FINAL.nov_.2020.pdf" target="_blank"> reglamento</a>
        <i class="bi bi-download"></i>
    </div>

        <div class="col"  id="div_cs">       
        <?php 
        if(count($arr_firma_certinet['contrato'])>0){
        ?>
        <i class="fas fa-file-alt"></i>
            <a href="../certinet/get_document.php?id_postulacion=<?php echo $id_postulacion;?>&documento=contrato" target="_blank" id="lnk_cs_gen">Contrato</a> 
            <span class="text-success"><i class="bi bi-download primary"></i></span>
            <span style="color: red;"><i class="bi bi-trash" id="dell_cs"></i></span>
        <?php

        }elseif($id_contrato_ps_64_dec5<>''){

        ?>
            <i class="fas fa-file-alt"></i>
            <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_doc_x_id_documento.php?id_documento=<?php echo $id_contrato_ps_64_dec5;?>" target="_blank" id="lnk_cs_gen">Contrato</a>
            <span class="text-success"><i class="bi bi-download primary"></i></span>
            <!-- <i class="bi bi-trash" id="dell_cs"></i> -->
        <?php 
        }elseif(!in_array("contrato_servicio.pdf", $arr_documentos)){
            if($tipo_programa=='Curso' || $tipo_programa=='Curso Conducente'){
                ?>
                <i class="fas fa-file-alt"></i>
                <a href="../contrato/contrato_curso_frm.php?form_id=<?php echo $id_postulacion;?>" target="_blank" id="lnk_cs">Contrato</a> 
            <?php
            }else{
                ?>
                <i class="fas fa-file-alt"></i>
                <a href="../contrato/contrato_prestacion_servicio_frm.php?form_id=<?php echo $id_postulacion;?>" target="_blank" id="lnk_cs">Contrato</a> 
            <?php
            }
             
    
            }else{ ?>        
            <i class="fas fa-file-alt"></i>
            <a href="../../Fichas/<?php echo $id_postulacion;?>/Contrato_servicio.pdf" target="_blank" id="lnk_cs_gen">Contrato</a>
            <i class="bi bi-download"></i> <i class="bi bi-trash" id="dell_cs"></i>
        <?php } ?>
        </div>        
        <div class="col" id="div_dj">
            <?php
            if(count($arr_firma_certinet['declaracion'])>0){
                ?>
                <i class="fas fa-file-alt"></i>
                    <a href="../certinet/get_document.php?id_postulacion=<?php echo $id_postulacion;?>&documento=declaracion" target="_blank" id="lnk_dj_gen">Declaracion</a> 
                    <span class="text-success"><i class="bi bi-download primary"></i></span> 
                    <span style="color: red;"><i class="bi bi-trash" id="dell_dj_digital"></i></span>

                <?php
        
                }elseif($id_declaracion_64_dec5<>''){
            ?>
                <i class="fas fa-file-alt"></i>
                <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_doc_x_id_documento.php?id_documento=<?php echo $id_declaracion_64_dec5;?>" target="_blank" id="lnk_cs_gen">Declaracion Jurada</a> 
                <span class="text-success"><i class="bi bi-download primary"></i></span>
                <!-- <i class="bi bi-trash" id="dell_cs"></i> -->
            <?php 
            }elseif($declaracion_jurada==0){?>
                <i class="fas fa-file-alt"></i>
                <a href="declaracion.php?form_id=<?php echo $id_postulacion;?>" target="_blank"  id="lnk_dj">Declaracion Jurada</a>
            <?php }else{ ?>
                <i class="fas fa-file-alt"></i>
                <a href="../../Fichas/<?php echo $id_postulacion;?>/declaracion_jurada.pdf?<?php echo date('YmdHis');?>" target="_blank"  id="lnk_dj_gen">Declaracion Jurada</a>
                <i class="bi bi-download"></i> <i class="bi bi-trash" id="dell_dj"></i>
            <?php } ?>
        </div>

        <div class="col" id="div_cd">
            <?php //if($existe_control==0){ 
            if(!in_array("control_decreto.pdf", $arr_documentos)){
            ?>
            <i class="fas fa-file-alt"></i>
            <a href="../control_decreto/control_decreto.php?id_postulacion=<?php echo $id_postulacion;?>" target="_blank" id="lnk_cd">Control decreto</a>
            
            <!--
            <button id="btn_refresh_cd" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i> control decreto</button>
            -->
            <?php }else{ ?>
            <i class="fas fa-file-alt"></i>
            <a href="<?php echo $dir_cp;?>" target="_blank" id="lnk_cd2">Control decreto</a>
            <i class="bi bi-download"></i> <i class="bi bi-trash" id="dell_cd"></i>
        <?php }?>  

        </div>
        <div class="col">

        <i class="fas fa-file-alt"></i>
            <a target="_blank" href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/g_documentos/frm_carta.php?nombre=<?php echo $nombres;?>&nombre_completo=<?php echo $nombre_completo;?>&diploma=<?php echo $programa;?>&ID=<?php echo $id_postulacion;?>&periodo=<?php echo $periodo;?>&cod_diploma=<?php echo $cod_diploma;?>" target="_blank" id="lnk_cd2">Carta compromiso</a>
        </i>
        </div>
        <form action="" id="frm_documentos" name="frm_documentos">
            <input type="hidden" name="id_postulacion" id="id_postulacion" value="<?php echo $id_postulacion;?>">
        </form>

    </div>

    <div class="row align-items-start">
        <div class="col col-12" id="div_link_firma">
        <?php
        include('valida_exista_dj_cs.php');
        ?>
        </div>
    </div>

    <div class="row align-items-start">
        <div class="col col-2">
            <p>Moneda de pago</p>
      </div>
      <div class="col col-10">
        <div class="form-check form-check-inline">
            <input class="form-check-input rd_pago" type="radio" name="rd_pago" id="rd_pago_clp" value="CLP" <?php if($moneda_pago=='CLP'){ echo 'checked';} ?>>
            <label class="form-check-label" for="inlineRadio1">CLP</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input rd_pago" type="radio" name="rd_pago" id="rd_pago_usd" value="USD" <?php if($moneda_pago=='USD'){ echo 'checked';} ?>>
            <label class="form-check-label" for="inlineRadio2">USD</label>
        </div>
      </div>
    </div>
<form action="" name="frm_postulacion_data_pagos" id="frm_postulacion_data_pagos">
</form>


    <hr>

    <div class="row align-items-start">
        <div class="col col-2">
            <p>Datos de pago</p>
      </div>
      </div>
      <div class="row align-items-start">
        <div class="col col-2 text-end">
        Valor UF:
        </div>
        <div class="col col-10">
            <input type="text" name="valor_uf" id="valor_uf" value="<?php echo $uf;?>">
        </diV>
        </diV>
      <div class="row align-items-start">
        
        <div class="col col-2 text-end">
        Valor lista:
        </div>
        <div class="col col-10">
        <?php 
        if($moneda=='CLP'){
            echo number_format($valor_programa, 0, ",", ".").' '.$moneda;

        }else{
            echo number_format($valor_programa, 2, ",", ".").' '.$moneda;
        }
        
        ?>
        <input type="hidden" name="moneda" id="moneda" value="<?php echo $moneda;?>">
        </div>
    </div>
    <div class="row align-items-start">
        <div class="col col-2 text-end">
        Descuento:
        </div>
        <div class="col col-10">
        <?php echo $dsco.' %';?>
        </div>
    </div>   
    <div class="row align-items-start">
        <div class="col col-2 text-end">
            Valor a Pagar:
        </div>
        <div id="div_valor_pagar" class="col col-2">
            <?php 
            if($moneda=='UF'){
                $valor_pagar = $uf*$valor_programa*(1-$dsco/100);
            }else{
                $valor_pagar = $valor_programa*(1-$dsco/100);
            }

            
            echo number_format($valor_pagar, 0, ",", ".").' CLP'; ?> 
            <input type="hidden" name="valor_pagar" id="valor_pagar" value="<?php echo $valor_pagar?>">
        </div>
        <div class="col col-6">
            <div id="pagar_usd">
                valor en USD (1.000,25) <input type="text" class="monto_usd" name="valor_pagar_usd" id="valor_pagar_usd" value="<?php echo $monto_usd_link_pago; ?>" maxlength="13" placeholder="1.000,25"> <button class="btn btn-primary btn-sm" id="btn_valor_pagar_usd">Guardar monto</button>
            </div>
        </div>
    </div>

    <p>&nbsp;</p>
    <hr>
    <input type="hidden" name="num_envio_link_pago" id="num_envio_link_pago" value="<?php echo $num_link_pagos_df;?>">
<?php
// Link pagos enviados
if(!empty($arr_link_pagos_df)){
    ?>
    <div class="row align-items-start">
        <div class="col col-2">
            <p>Link pago webpay enviados</p>
        </div>
    </div>
    <div class="row align-items-start p-3 mb-2 bg-light text-dark">
            <div class="col col-1 text-center">
            Link
            </div>
            <div class="col col-3 text-center">
                Email
            </diV>
            <div class="col col-2 text-center">
            Monto
            </diV>
            <div class="col col-2 text-center">
            Fecha envio
            </diV>
            <div class="col col-2 text-center">
                <i class="bi bi-mail"></i>
            </diV>
        </diV>
    <?php
    foreach($arr_link_pagos_df as $link_pagos_df){
?>

<div class="row align-items-start border border-light">
      
            <div class="col col-1 text-center">
                <?php echo $link_pagos_df['tc'];?>
            </diV>
            <div class="col col-3 text-center">
                <?php echo $link_pagos_df['email'];?>
            </diV>
            <div class="col col-2 text-end">
                <?php echo number_format($link_pagos_df['monto'], 0, ",", ".");?>
            </diV>
            <div class="col col-2 text-center">
                <?php echo date("d-m-Y H:i:s", strtotime($link_pagos_df['fecha']));?>
            </diV>
            <div class="col col-2">
                <button class="btn btn-success btn-sm btn_re_envio_mail" id="<?php echo $link_pagos_df['tc'];?>"><i class="bi bi-send"></i> Re enviar </button>
            </diV>
        </diV>
<p></p>
<?php
    }
}
?>
    <div class="row align-items-start">
        <div class="col col-2">
            <p>Pagos recibidos</p>
      </div>
      </div>
      <?php
      $total_recibido=0;

      if(!empty($arr_pagos_recibidos)){
        ?>
        <div class="row align-items-start p-3 mb-2 bg-light text-dark">
            <div class="col col-2 text-end">
            Monto
            </div>
            <div class="col col-2">
                Estatus
            </diV>
            <div class="col col-2">
            Numero operacion
            </diV>
            <div class="col col-2">
            Codigo Autorizacion
            </diV>
            <div class="col col-2">
            Numero tarjeta
            </diV>
            <div class="col col-2">
            Fecha
            </diV>
        </diV>
    <?php
        
        foreach($arr_pagos_recibidos as $pagos_recibidos){
      ?>
      
        <div class="row align-items-start">
            <div class="col col-2 text-end">
            <?php 
            $total_recibido = $total_recibido+$pagos_recibidos['amount'];
            echo number_format($pagos_recibidos['amount'], 0, ",", ".");?>
            </div>
            <div class="col col-2">
                <?php echo $pagos_recibidos['status'];?>
            </diV>
            <div class="col col-2">
                <?php echo $pagos_recibidos['session_id'];?>
            </diV>
            <div class="col col-2">
                <?php echo $pagos_recibidos['authorization_code'];?>
            </diV>
            <div class="col col-2">
                <?php echo $pagos_recibidos['card_number'];?>
            </diV>
            <div class="col col-2">
                <?php echo date("d-m-Y H:i:s", strtotime($pagos_recibidos['transaction_date']));?>
            </diV>
        </diV>
        <?php
        }
      }
      ?>
    <div class="row align-items-start">
            <div class="col col-2 text-end fw-bold bg-light text-dark">
            <?php echo number_format($total_recibido, 0, ",", ".");?>
            </div>
            <div class="col col-10">
                
            </diV>
        </diV>
      <input type="hidden" name="num_link_tc" id="num_link_tc" value="<?php echo count($arr_link_pagos_df)+1; ?>">  

 
      
      <p>&nbsp;</p>
    <hr>
      
    
<?php
if(count($arr_link_pagos_df) < 2){
    ?>
    <button id="link_pago_total" class="btn btn-success m-2">Enviar link pago 1 sola tarjeta (total) </button> <br>
    <?php
}
if(count($arr_link_pagos_df) < 1){
    ?>
    <button id="link_2_tc" class="btn btn-success  m-2">Link 2 trajetas indicando monto</button>
    <?php
}
//echo '$arr_link_pagos_df :: '.count($arr_link_pagos_df);
if(count($arr_link_pagos_df) < 2){
?>

<div id="div_link_2_tc">
    
    <div class="row align-items-start">
        <div class="col col-12">
            <p>Link de pago</p>
      </div>
    </div>

    <div class="row align-items-start" id="div_link_tc">
        <div class="col col-2">
            <p><strong>Tarjeta Credito o WEBPAY</strong></p>

        </div>
        <div class="contenedor d-flex flex-row align-items-center" style="">
            <div class="mx-2"  style="">
                <p>1&deg;  tarjeta monto: <input type="text" name="monto_tc1" id="monto_tc1" class="monto"></p>
               <!-- <p>2&deg;  tarjeta monto: <input type="text" name="monto_tc2" id="monto_tc2" class="monto"></p>-->
            </div>
            <div class="" style="">
                <button class="btn btn-primary text-start" id="btn_link_pago">Enviar <i class="bi bi-box-arrow-in-right"></i></button>
            </div>
        </div>
    </div>    
</div>



<?php } ?>      
    <div class="row align-items-start" id="div_link_paypal">
        <div class="col col-2">
            <p><strong>Paypal</strong></p>
        </div>
        <div class="contenedor d-flex flex-row align-items-center" style="">
            <div class="mx-2">
                <p>Monto USD: <input type="text" name="monto_paypal" id="monto_paypal" class="monto"></p>
            </div>
            <div class="mx-2">
                <button class="btn btn-primary" id="btn_link_pagoUsd">Enviar <i class="bi bi-box-arrow-in-right"></i></button>
            <?php
            if($fecha_email<>''){
                echo 'Ultimo '.$log_envio.' '.date("d-m-Y H:i:s", strtotime($fecha_email));
            }
            ?>
            </div>
        </div>
    </div>
    
    <div class="row align-items-start" id="div_link_paypal_emp">
        <div class="col col-2">
            <p><strong>Paypal (Empresa)</strong></p>
        </div>
        <div class="contenedor d-flex flex-row align-items-center" style="">
            <div class="mx-2">
                <p>Monto USD: <input type="text" name="monto_paypal" id="monto_paypal" class="monto"></p>
            </div>
            <div class="mx-2">
                <button class="btn btn-primary" id="btn_link_pagoUsd">Enviar <i class="bi bi-box-arrow-in-right"></i></button>
            </div>
        </div>
    </div>


    <div id="div_postulacion_data_pagos"></div>
<hr>
<form action="comprobante_pago.php" name="comprobante_pago" id="comprobante_pago" target="_blank">
    <input type="hidden" name="id_postulacion" id="id_postulacion" value="<?php echo $id_postulacion;?>">

    <input type="hidden" name="total_descuento" id="total_descuento" value="<?php echo $dsco;?>">
    <input type="hidden" name="total_pagar" id="total_pagar" value="<?php echo $valor_pagar;?>">
    <input type="hidden" name="atendido" id="atendido" value="<?php echo $usuario;?>">

    <!--<input type="hidden" name="fecha_imp" id="fecha_imp" value="<?php echo date('Y-m-d');?>">-->
    <input type="hidden" name="uf" id="uf" value="<?php echo $uf;?>">
    <input type="hidden" name="valor_programa" id="valor_programa" value="<?php echo $valor_programa;?>">
    
<?php

foreach($arr_pagos_recibidos as $pagos_recibidos){
    ?>
    <input type="hidden" name="check_int[]" value="webpay_diferido">
    <input type="hidden" name="banco_wp_df[]" value="Otro">
    <input type="hidden" name="num_tc_wp_df[]" value="<?php echo $pagos_recibidos['card_number'];?>">
    <input type="hidden" name="num_cuotas_df[]" value="<?php echo $pagos_recibidos['num_cuotas'];?>">
    <input type="hidden" name="monto_tc_df[]" value="<?php echo $pagos_recibidos['amount'];?>">
    <input type="hidden" name="fecha_voucher_df[]" value="<?php echo $pagos_recibidos['transaction_date'];?>">
    <input type="hidden" name="num_operacion_df[]" value="<?php echo $pagos_recibidos['session_id'];?>">
    <input type="hidden" name="cod_autorizacion_df[]" value="<?php echo $pagos_recibidos['authorization_code'];?>">
<?php
}

if ($total_recibido <> $valor_pagar) {

?>
<div id="interesado">
    <div class="row align-items-start">
        <div class="col col-12">
            <p><strong>Desglose Pago Interesado:</strong> </p>
      </div>

    </div>
    <div class="row align-items-start">
        <div class="col col-2 text-end">
       
        </div>
        <div class="col col-10">
  
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_tx" name="check_int[]" value="tx">
            <label class="form-check-label" for="check_tx">Transferencia </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_tc" name="check_int[]" value="tc">
            <label class="form-check-label" for="check_tc">Tarjeta Crédito </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_webpay" name="check_int[]" value="webpay">
            <label class="form-check-label" for="check_webpay">WEBPAY  </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_paypal" name="check_int[]" value="paypal">
            <label class="form-check-label" for="check_paypal">Paypal</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_pat" name="check_int[]" value="pat">
            <label class="form-check-label" for="check_pat">PAT  </label>
        </div> 
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_pac" name="check_int[]" value="pac">
            <label class="form-check-label" for="check_pac">PAC  </label>
        </div>        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_oc" name="check_int[]" value="oc" disabled>
            <label class="form-check-label" for="check_oc">Orden de Compra </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_vv" name="check_int[]" value="vv">
            <label class="form-check-label" for="check_vv">Vale Vista </label>
        </div>        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_ch" name="check_int[]" value="ch" disabled>
            <label class="form-check-label" for="check_ch">Cheque</label>
        </div>        
        
        </div>
    </div> 
<!-- DESGLOSE PAGO -->   
<!-- TX -->   
    <div class="row align-items-start" id="div_tx">
        <div class="col">
            <p><strong>Transferencia</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-1">Banco</div>
            <div class="col col-2">
                <select name="banco_tx" id="banco_tx">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>        
        <div class="row align-items-start">
            <div class="col col-1">Monto</div>
            <div class="col col-2"><input type="text" class="monto" id="monto_tx" name="monto_tx" maxlength="10"></div>
        </div>
    </div>

 <!-- TC -->   
    <div class="row align-items-start" id="div_tc">
        <div class="col">
            <p><strong>Tarjeta de Credito</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Banco</div>
            <div class="col col-2">
                <select name="banco_tc" id="banco_tc">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>   
        <div class="row align-items-start">
            <div class="col col-2">Tarjeta</div>
            <div class="col">
                <select name="nom_tc" id="nom_tc">
                    <option value="Visa">Visa</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="American Express">American Express</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero tarjeta<br><sub>ultimos 4 digitos</sub></div>
            <div class="col col-2"><input type="text" class="" id="num_tc" name="num_tc" maxlength="4"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Monto</div>
            <div class="col col-2 calCuota"><input type="text" class="monto" id="monto_tc" name="monto_tc" maxlength="10"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero Cuotas</div>
            <div class="col col-3 monto calCuota"><input type="text" class="" id="num_cuotas" name="num_cuotas" maxlength="2"></div>
            <div class="col col-3">Valor cuota: <span id="valor_cuota"></span></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Fecha</div>
            <div class="col col-2"><input type="date" class="" id="fecha_voucher" name="fecha_voucher" value="<?php echo date('Y-m-d')?>"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Hora</div>
            <div class="col col-2"><input type="time" class="" id="hora_voucher" name="hora_voucher" value="<?php echo date('H:i')?>"></div>
        </div>


        <div class="row align-items-start">
            <div class="col col-2">Numero operacion</div>
            <div class="col col-2"><input type="text" class="" id="num_operacion" name="num_operacion" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Codigo Autorizacion</div>
            <div class="col col-2"><input type="text" class="" id="cod_autorizacion" name="cod_autorizacion" maxlength="20"></div>
        </div>
</div>
<!-- WEBPAY -->   
    <div class="row align-items-start" id="div_webpay">
        <div class="col">
            <p><strong>WEBPAY</strong></p>
        </div>        
        <div class="row align-items-start">
            <div class="col col-2">Banco</div>
            <div class="col col-2">
                <select name="banco_wp" id="banco_wp">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>   
        <div class="row align-items-start">
            <div class="col col-2">Tarjeta</div>
            <div class="col">
                <select name="nom_tc_wp" id="nom_tc_wp">
                    <option value="Visa">Visa</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="American Express">American Express</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Numero tarjeta<br><sub>ultimos 4 digitos</sub></div>
            <div class="col col-2"><input type="text" class="" id="num_tc_wp" name="num_tc_wp" maxlength="4"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Monto</div>
            <div class="col col-2 calCuota"><input type="text" class="monto" id="monto_tc_wp" name="monto_tc_wp" maxlength="10"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero Cuotas</div>
            <div class="col col-3 monto calCuota"><input type="text" class="" id="num_cuotas_wp" name="num_cuotas_wp" maxlength="2"></div>
            <div class="col col-3">Valor cuota: <span id="valor_cuota_wp"></span></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Fecha</div>
            <div class="col col-2"><input type="date" class="" id="fecha_voucher_wp" name="fecha_voucher_wp" value="<?php echo date('Y-m-d')?>"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Hora</div>
            <div class="col col-2"><input type="time" class="" id="hora_voucher_wp" name="hora_voucher_wp" value="<?php echo date('H:i')?>"></div>
        </div>


        <div class="row align-items-start">
            <div class="col col-2">Numero operacion</div>
            <div class="col col-2"><input type="text" class="" id="num_operacion_wp" name="num_operacion_wp" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Codigo Autorizacion</div>
            <div class="col col-2"><input type="text" class="" id="cod_autorizacion_wp" name="cod_autorizacion_wp" maxlength="20"></div>
        </div>

    
    </div>
<!-- PAYPAL -->   
    <div class="row align-items-start" id="div_paypal">
        
        <div class="col">
            <p><strong>PAYPAL</strong></p>
        
        <div class="row align-items-start">
        <div class="col col-2">ID</div><div class="col col-2"><input type="text" class="" id="id_paypal" name="id_paypal" maxlength="20"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto_usd" id="monto_paypal" name="monto_paypal" maxlength="10"></div>
        </div>

        </div>
    </div>
<!-- PAT -->   
    <div class="row align-items-start" id="div_pat">
        <div class="col">

        <div class="col">
            <p><strong>PAT</strong></p>
        
        <div class="row align-items-start">
        <div class="col col-2">ID PAT</div><div class="col col-2"><input type="text" class="" id="id_pat" name="id_pat" maxlength="20"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_pat" name="monto_pat" maxlength="10"></div>
        </div>

        </div>

        </div>
    </div>
<!-- PAC -->   
<div class="row align-items-start" id="div_pac">
        <div class="col">

        <div class="col">
            <p><strong>PAC</strong></p>
            <div class="row align-items-start">
            <div class="col col-2">Banco</div>
            <div class="col col-2">
                <select name="banco_pac" id="banco_pac">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>
        

        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_pac" name="monto_pac" maxlength="10"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Numero cuotas</div><div class="col col-2"><input type="text" class="" id="ncuota_pac" name="ncuota_pac" maxlength="2"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Monto cuotas</div><div class="col col-2"><input type="text" class="" id="monto_cuota_pac" name="monto_cuota_pac" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">N° Cuenta Corriente</div><div class="col col-2"><input type="text" class="" id="ctacte_pac" name="ctacte_pac" maxlength="20"></div>
        </div>


        </div>

        </div>
    </div>
<!-- OC -->   
    <div class="row align-items-start" id="div_oc">
    <div class="col">
            <p><strong>Orden de Compra</strong></p>
        
        <div class="row align-items-start">
        <div class="col col-2">Orden de compra</div><div class="col col-2"><input type="text" class="" id="text_oc" name="text_oc" maxlength="20"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Rut Empresa</div><div class="col col-2"><input type="text" class="" id="rut_emp" name="rut_emp" maxlength="20" value="<?php echo $rut_empresa;?>"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Razon Social</div><div class="col col-2"><input type="text" class="" id="razon_social" name="razon_social" maxlength="200" value="<?php echo $razon_social;?>"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Direccion</div><div class="col col-2"><input type="text" class="" id="dir_emp" name="dir_emp" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Giro</div><div class="col col-2"><input type="text" class="" id="giro" name="giro" maxlength="20"></div>
        </div>

        
        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_oc" name="monto_oc" maxlength="10"></div>
        </div>
 </div>
    </div>
<!-- VV -->   
    <div class="row align-items-start" id="div_vv">
        <div class="col">
            <p><strong>Vale Vista</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-1">Banco</div>
            <div class="col col-2">
                <select name="banco_vv" id="banco_vv">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>        
        <div class="row align-items-start">
            <div class="col col-1">Monto</div>
            <div class="col col-2"><input type="text" class="monto" id="monto_vv" name="monto_vv" maxlength="10"></div>
        </div>

        
    </div>
<!-- CH -->   
    <div class="row align-items-start" id="div_ch">
        <div class="col">
            <P>div_ch</P>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero aperiam fuga numquam asperiores id labore unde a reprehenderit quas maiores molestiae non autem, necessitatibus vero atque est eaque iure nesciunt?
        </div>
    </div>

</div>
<hr>
<div class="col col-12">
            <p><strong>Datos Empresa:</strong></p>
      </div>
<!-- PAGO MEPRESA -->
<div id="empresa">
    <div class="row align-items-start">
        <div class="col col-2 text-end">
            Empresa: 
        </div>
        <div class="col col-10">
            <input type="text" name="nombre_empresa" id="nombre_empresa" class="col col-8" value="<?php echo $razon_social;?>">
        </div>
    </div>
    <div class="row align-items-start">
        <div class="col col-2 text-end">
          Rut Empresa: 
        </div>
        <div class="col col-10">
            <input type="text" name="rut_empresa" id="rut_empresa" class="col col-8" value="<?php echo $rut_empresa;?>">
        </div>
    </div>
    <div class="row align-items-start">
        <div class="col col-2 text-end">
          Dirección: 
        </div>
        <div class="col col-10">
            <input type="text" name="direccion_empresa" id="direccion_empresa" class="col col-8" value="<?php // echo $empresa;?>">
        </div>
    </div>



    <div class="row align-items-start">


        <div class="col col-12">
            <p><strong>Desglose Pago Empresa:</strong> </p>
      </div>

    </div>
    <div class="row align-items-start">
        <div class="col col-2 text-end">
       
        </div>
        <div class="col col-10">
  
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_tx_emp" name="check_emp[]" value="tx_emp">
            <label class="form-check-label" for="check_tx_emp">Transferencia </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_tc_emp" name="check_emp[]" value="tc_emp">
            <label class="form-check-label" for="check_tc_emp">Tarjeta Crédito </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_webpay_emp" name="check_emp[]" value="webpay_emp">
            <label class="form-check-label" for="check_webpay_emp">WEBPAY  </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_paypal_emp" name="check_emp[]" value="paypal_emp">
            <label class="form-check-label" for="check_paypal_emp">Paypal</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_pat_emp" name="check_emp[]" value="pat_emp">
            <label class="form-check-label" for="check_pat_emp">PAT  </label>
        </div>        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_oc_emp" name="check_emp[]" value="oc_emp">
            <label class="form-check-label" for="check_oc_emp">Orden de Compra </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_vv_emp" name="check_emp[]" value="vv_emp">
            <label class="form-check-label" for="check_vv_emp">Vale Vista </label>
        </div>        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check_ch_emp" name="check_emp[]" value="ch_emp" disabled>
            <label class="form-check-label" for="check_ch_emp">Cheque</label>
        </div>        
        
        </div>
    </div> 
<!-- DESGLOSE PAGO -->   
<!-- TX -->   
    <div class="row align-items-start" id="div_tx_emp">
        <div class="col">
            <p><strong>Transferencia</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-1">Banco</div>
            <div class="col col-2">
                <select name="banco_tx_emp" id="banco_tx_emp">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>        
        <div class="row align-items-start">
            <div class="col col-1">Monto</div>
            <div class="col col-2"><input type="text" class="monto" id="monto_tx_emp" name="monto_tx_emp" maxlength="10"></div>
        </div>
    </div>

 <!-- TC -->   
    <div class="row align-items-start" id="div_tc_emp">
        <div class="col">
            <p><strong>Tarjeta de Credito</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Banco</div>
            <div class="col col-2">
                <select name="banco_tc_emp" id="banco_tc_emp">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>   
        <div class="row align-items-start">
            <div class="col col-2">Tarjeta</div>
            <div class="col">
                <select name="nom_tc_emp" id="nom_tc_emp">
                    <option value="Visa">Visa</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="American Express">American Express</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero tarjeta<br><sub>ultimos 4 digitos</sub></div>
            <div class="col col-2"><input type="text" class="" id="num_tc_emp" name="num_tc_emp" maxlength="4"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Monto</div>
            <div class="col col-2 calCuota"><input type="text" class="monto" id="monto_tc_emp" name="monto_tc_emp" maxlength="10"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero Cuotas</div>
            <div class="col col-3 monto calCuota"><input type="text" class="" id="num_cuotas_emp" name="num_cuotas_emp" maxlength="2"></div>
            <div class="col col-3">Valor cuota: <span id="valor_cuota_emp"></span></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Fecha</div>
            <div class="col col-2"><input type="date" class="" id="fecha_voucher_emp" name="fecha_voucher_emp" value="<?php echo date('Y-m-d')?>"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Hora</div>
            <div class="col col-2"><input type="time" class="" id="hora_voucher_emp" name="hora_voucher_emp" value="<?php echo date('H:i')?>"></div>
        </div>


        <div class="row align-items-start">
            <div class="col col-2">Numero operacion</div>
            <div class="col col-2"><input type="text" class="" id="num_operacion_emp" name="num_operacion_emp" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Codigo Autorizacion</div>
            <div class="col col-2"><input type="text" class="" id="cod_autorizacion_emp" name="cod_autorizacion_emp" maxlength="20"></div>
        </div>
</div>
<!-- WEBPAY -->   
    <div class="row align-items-start" id="div_webpay_emp">
        <div class="col">
            <p><strong>WEBPAY</strong></p>
        </div>        
        <div class="row align-items-start">
            <div class="col col-2">Banco</div>
            <div class="col col-2">
                <select name="banco_wp_emp" id="banco_wp_emp">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>   
        <div class="row align-items-start">
            <div class="col col-2">Tarjeta</div>
            <div class="col">
                <select name="nom_tc_wp_emp" id="nom_tc_wp_emp">
                    <option value="Visa">Visa</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="American Express">American Express</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Numero tarjeta<br><sub>ultimos 4 digitos</sub></div>
            <div class="col col-2"><input type="text" class="" id="num_tc_wp_emp" name="num_tc_wp_emp" maxlength="4"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Monto</div>
            <div class="col col-2 calCuota"><input type="text" class="monto" id="monto_tc_wp_emp" name="monto_tc_wp_emp" maxlength="10"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Numero Cuotas</div>
            <div class="col col-3 monto calCuota"><input type="text" class="" id="num_cuotas_wp_emp" name="num_cuotas_wp_emp" maxlength="2"></div>
            <div class="col col-3">Valor cuota: <span id="valor_cuota_wp_emp"></span></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Fecha</div>
            <div class="col col-2"><input type="date" class="" id="fecha_voucher_wp_emp" name="fecha_voucher_wp_emp" value="<?php echo date('Y-m-d')?>"></div>
        </div>

        <div class="row align-items-start">
            <div class="col col-2">Hora</div>
            <div class="col col-2"><input type="time" class="" id="hora_voucher_wp_emp" name="hora_voucher_wp_emp" value="<?php echo date('H:i')?>"></div>
        </div>


        <div class="row align-items-start">
            <div class="col col-2">Numero operacion</div>
            <div class="col col-2"><input type="text" class="" id="num_operacion_wp_emp" name="num_operacion_wp_emp" maxlength="20"></div>
        </div>
        <div class="row align-items-start">
            <div class="col col-2">Codigo Autorizacion</div>
            <div class="col col-2"><input type="text" class="" id="cod_autorizacion_wp_emp" name="cod_autorizacion_wp_emp" maxlength="20"></div>
        </div>

    
    </div>
<!-- PAYPAL -->   
    <div class="row align-items-start" id="div_paypal_emp">
        
        <div class="col">
            <p><strong>PAYPAL</strong></p>
        
        <div class="row align-items-start">
        <div class="col col-2">ID</div><div class="col col-2"><input type="text" class="" id="id_paypal_emp" name="id_paypal_emp" maxlength="20"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_paypal_emp" name="monto_paypal_emp" maxlength="10"></div>
        </div>

        </div>
    </div>
<!-- PAT -->   
    <div class="row align-items-start" id="div_pat_emp">
        <div class="col">

        <div class="col">
            <p><strong>PAT</strong></p>
        
        <div class="row align-items-start">
        <div class="col col-2">ID PAT</div><div class="col col-2"><input type="text" class="" id="id_pat_emp" name="id_pat_emp" maxlength="20"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_pat_emp" name="monto_pat_emp" maxlength="10"></div>
        </div>

        </div>

        </div>
    </div>
<!-- OC -->   
    <div class="row align-items-start" id="div_oc_emp">
    <div class="col">
            <p><strong>Orden de Compra</strong></p>
<!--        
        <div class="row align-items-start">
        <div class="col col-2">Orden de compra</div><div class="col col-2"><input type="text" class="" id="text_oc_emp" name="text_oc_emp" maxlength="200"></div>
        </div>

        <div class="row align-items-start">
        <div class="col col-2">Rut Empresa</div><div class="col col-2"><input type="text" class="" id="rut_emp_emp" name="rut_emp_emp" maxlength="200" value="<?php echo $rut_empresa;?>"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Razon Social</div><div class="col col-2"><input type="text" class="" id="razon_social_emp" name="razon_social_emp" maxlength="200" value="<?php echo $razon_social;?>"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Direccion</div><div class="col col-2"><input type="text" class="" id="dir_emp_emp" name="dir_emp_emp" maxlength="200"></div>
        </div>
        <div class="row align-items-start">
        <div class="col col-2">Giro</div><div class="col col-2"><input type="text" class="" id="giro_emp" name="giro_emp" maxlength="200"></div>
        </div>
-->
        
        <div class="row align-items-start">
        <div class="col col-2">Monto</div><div class="col col-2 calCuota"><input type="text" class="monto" id="monto_oc_emp" name="monto_oc_emp" maxlength="10"></div>
        </div>
 </div>
    </div>
<!-- VV -->   
    <div class="row align-items-start" id="div_vv_emp">
        <div class="col">
            <p><strong>Vale Vista</strong></p>
        </div>
        <div class="row align-items-start">
            <div class="col col-1">Banco</div>
            <div class="col col-2">
                <select name="banco_vv_emp" id="banco_vv_emp">
                    <option value="Banco Bilbao Vizcaya - BBVA"> Banco Bilbao Vizcaya - BBVA</option>
                    <option value="Banco del Desarrollo"> Banco del Desarrollo</option>
                    <option value="Scotiabank Sud Americano"> Scotiabank Sud Americano</option>
                    <option value="Banco Santander Santiago"> Banco Santander Santiago</option>
                    <option value="Citibank - Chile"> Citibank - Chile</option>
                    <option value="BancoEstado"> BancoEstado</option>
                    <option value="Banco de Chile"> Banco de Chile</option>
                    <option value="ABN AMRO - Chile"> ABN AMRO - Chile</option>
                    <option value="Asociacion de Bancos e Instituciones Financieras de Chile"> Asociacion de Bancos e Instituciones Financieras de Chile</option>
                    <option value="Banco Central de Chile"> Banco Central de Chile</option>
                    <option value="Banco BCI"> Banco BCI</option>
                    <option value="Banco Security"> Banco Security</option>
                    <option value="Banco ITAU"> Banco ITAU</option>
                    <option value="Banco Corpbanca"> Banco Corpbanca</option>
                    <option value="Banco Falabella"> Banco Falabella</option>
                    <option value="Banco Ripley"> Banco Ripley</option>
                    <option value="Banco Paris"> Banco Paris</option>
                    <option value="Otro"> Otro</option>
                </select>
            </div>
        </div>        
        <div class="row align-items-start">
            <div class="col col-1">Monto</div>
            <div class="col col-2"><input type="text" class="monto" id="monto_vv_emp" name="monto_vv_emp" maxlength="10"></div>
        </div>

        
    </div>
<!-- CH -->   
    <div class="row align-items-start" id="div_ch_emp">
        <div class="col">
            <P>div_ch</P>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero aperiam fuga numquam asperiores id labore unde a reprehenderit quas maiores molestiae non autem, necessitatibus vero atque est eaque iure nesciunt?
    </div>
    </div>





</div>  

<?php
}

?>
    <div class="mb-3">
        <label for="comentario" class="form-label">Comentario</label>
        <textarea class="form-control" id="comentario" rows="3" name="comentario"></textarea>
    </div>
    <div class="mb-3">
        <label for="fecha_imp" class="form-label">Fecha impresion</label>
        <input type="text" name="fecha_imp" id="fecha_imp" class="" value="<?php echo date('d-m-Y H:i');?>">
    </div>
<?php
if($n<>''){
?>
    <div class="row align-items-center p-5">
        <div class="col col-12 text-center" id="div_btn_cp">
        <a href="http://intranet.unegocios.cl/apps/cdg/postulacion/admision/Fichas/<?php echo $id_postulacion; ?>/comprobante_ingreso.pdf?r=<?php echo date('ymdhis')?>" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-file-alt"></i> comprobante de Pago <i class="bi bi-download primary"></i>
        </a>
        </div>
    </div>

<?php    
}
?>
    <div class="row align-items-center p-5">
        <div class="col col-12 text-center" id="div_btn_cp">
            <button class="btn btn-primary" type="submit" id="btn_cp">Generar comprobante</button>
        </div>
    </div>
</form>

<p> </p>
<form id="frm_matricula">
    <div id="div_msj_matricula"></div>
</form>
<?php
//echo 'etapa_estado: '.$etapa_estado;

if($etapa_estado <>'3030' && $etapa_estado <> '3131'){
?>


<div class="row align-items-center p-5">
        <div class="col col-6 text-center">
            <button class="btn btn-primary btn-matricula" id="btn_pendiente_cierre">Pendiente Cierre</button>
        </div>
        <div class="col col-6 text-center">
            <button class="btn btn-primary btn-matricula" id="btn_cierre_matricula">Cerrar Matricula</button>
        </div>
    </div>
<?php
}elseif($etapa_estado == '3131'){
?>
<div class="row align-items-center p-5">
        <div class="col col-4 text-center">
            Estado: Pendiente Cierre</button>
        </div>
        <div class="col col-4 text-center">
            <button class="btn btn-secondary btn-matricula" id="btn_pendiente_cierre">Pendiente Cierre <i class="bi bi-arrow-repeat"></i></button>
        </div>
        <div class="col col-4 text-center">
                <button class="btn btn-secondary btn-matricula" id="btn_cierre_matricula">Cerrar Matricula <i class="bi bi-arrow-repeat"></i></button>
            </div>
    </div>
<?php    
}else{
    ?>
    <div class="row align-items-center p-5">
            <div class="col col-4 text-center">
                Estado: Matricula Cerrada</button>
            </div>
            <div class="col col-4 text-center">
                <button class="btn btn-secondary btn-matricula" id="btn_pendiente_cierre">Pendiente Cierre <i class="bi bi-arrow-repeat"></i></button>
            </div>
            <div class="col col-4 text-center">
                <button class="btn btn-secondary btn-matricula" id="btn_cierre_matricula">Cerrar Matricula <i class="bi bi-arrow-repeat"></i></button>
            </div>
        </div>
    <?php    
    }
?>

<p>
</p>

</div>
<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="index.js?v=0.0.1.3.06"></script>
<script>

$( document ).ready(function() {

    $("body").on("click","#link_2_tc",function(){
        console.log('clik div_link_2_tc');
        $( "#div_link_2_tc" ).toggle();
        
    });
   
    <?php if(count($arr_link_pagos_df)==0){
        echo '$( "#div_link_2_tc" ).hide();';
    } ?>

    $("body").on("click",".btn-matricula",function(){
        event.preventDefault();


        var accion = $(".btn-matricula").attr("id").replace("btn_", "");
        console.log('clik '+accion);
       
        
        var formData = new FormData(document.getElementById("frm_matricula"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            formData.append("accion", accion);
            $.ajax({
                url: "cierre_matricual.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_msj_matricula").html(data);
			
		});
    });



});
</script>
</body>
</html>