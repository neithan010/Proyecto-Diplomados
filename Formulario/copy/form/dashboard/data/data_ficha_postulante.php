<?php
include_once('cn.php');


$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
}

$sql_postulante="SELECT 
        p.ID_POSTULACION,
        p.NOMBRES,
        p.APELLIDO_PAT,
        p.APELLIDO_MAT,
        p.es_rut,
        p.RUT,
        concat(p.DIREC_PARTICULAR,' ',p.numero,if(p.depto_of_par<>'',CONCAT(' depto ',p.depto_of_par),''),', ',com.nombre,', ',reg.nombre) direccion,
        p.DIREC_PARTICULAR as calle,
        p.numero,
        p.depto_of_par,
        com.cod_comuna, 
        com.nombre as comuna,
        p.EMAIL,
        p.GENERO,
        p.FECHA_NAC,
        p.NACIONALIDAD,
        p.CARRERA_PRO,
        p.TituloProfesional,
        p.RAZON_SOCIAL,
        p.CARGO,
        p.CV,
        p.TELEFONO,
        p.CELULAR,
        p.EX_ALUMNO,
        p.FECHA_POST AS fecha_postulacion,
        p.ID_FINANCIAMIENTO AS financiamiento, 
        p.MOTIVACION_ESTUDIO AS motivacion,
        p.CARRERA_PRO,
        p.titulado_uni,
        p.TituloProfesional,
        p.UNIVERSIDAD,
        p.r_universitario,
        p.observaciones,


        d.cod_diploma,
        d.Cod_interno AS ceco,
        d.DIPLOMADO,
        d.fecha_inicio,
        d.fecha_termino,

        pd.linkedin, 
        pd.twitter, 
        pd.sin_estudios, 
        pd.tecnico, 
        pd.institucion_tecnica, 
        pd.carrera_tecnica, 
        pd.r_carrera_tec, 
        pd.fecha_tec, 
        pd.magister, 
        pd.universidad_mag, 
        pd.carrera_magister, 
        pd.r_magister, 
        pd.fecha_magister, 
        pd.doctorado, 
        pd.universidad_doc, 
        pd.carrera_doctorado, 
        pd.r_doctorado, 
        pd.fecha_doc, 
        pd.otro_estudio, 
        pd.estudio_1, 
        pd.estudio_2, 
        pd.ultimo_estudio, 
        pd.empleado, 
        pd.busca_empleo, 
        pd.year_posicion, 
        pd.personal_cargo, 
        pd.personas_a_cargo, 
        pd.empleado_publico, 
        pd.experiencia_lab, 
        pd.empresa, 
        pd.industria, 
        pd.actividad, 
        pd.cargo, 
        pd.fecha_ini, 
        pd.fecha_fin, 
        pd.empresa_2, 
        pd.industria_2, 
        pd.actividad_2, 
        pd.cargo_2, 
        pd.fecha_ini_2, 
        pd.fehca_fin_2, 
        pd.empresa_3, 
        pd.industria_3, 
        pd.actividad_3, 
        pd.cargo_3, 
        pd.fecha_ini_3, 
        pd.fecha_fin_3, 
        pd.motivacion_1, 
        pd.motivacion_2, 
        pd.motivacion_3, 
        pd.motivacion_4, 
        pd.carta_recomendacion, 
        pd.certificado_titulo, 
        pd.periodo, 
        pd.certificado_titulo_valida,
        CASE concat(p.etapa,p.estado)
            WHEN '00' THEN 'Post. Nueva'
            WHEN '01' or '02' THEN 'Pre postulacion'
            WHEN '1011' THEN 'Pre postulacion Eliminada'
            WHEN '1010' THEN 'Eliminada'
            WHEN '1030' THEN 'En Evaluacion'
            WHEN '2020' THEN 'Aceptada'
            WHEN '2030' THEN 'Rechazado'
            WHEN '2040' THEN 'Pendiente DA'
            WHEN '3010' THEN 'Retirado'
            WHEN '3030' THEN 'Matriculado'
            WHEN '3131' THEN 'Mat. Pendiente Cierre'
            WHEN '4020' THEN 'Postergado'
            WHEN '99' THEN 'S/I'
            ELSE '*'
        END etapaestado,
        concat(p.etapa,p.estado) ee
    FROM 
        unegocios_nuevo.postulacion p
        LEFT JOIN unegocios_nuevo.comunas com ON p.COMUNA=com.cod_comuna
        LEFT JOIN unegocios_nuevo.regiones reg ON p.region=reg.cod_region
        INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
        LEFT JOIN unegocios_nuevo.postulacion_datos pd ON p.RUT=pd.rut
    WHERE 
        p.ID_POSTULACION=".$id_postulacion;

//echo '<pre>'.$sql_programas.'</pre>';

$stmt_postulante = $con->prepare($sql_postulante);
$stmt_postulante->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulante->execute();
$num_postulante = $stmt_postulante->rowCount();	
//echo '::'.$num_convenios;

//$arr_programas=[];
while ($rw_postulante = $stmt_postulante->fetch()){
    
    
    $url_img='https://intranet.unegocios.cl/fotos/upload_pic/'.$rw_postulante['RUT'].'.jpg';
    //if(!is_readable($url_img)){
    if(false){
      $url_img='https://intranet.unegocios.cl/fotos/upload_pic/1-0.jpg';
    }
    
    $nombre         = utf8_encode($rw_postulante['NOMBRES']);
    $apellido_pat   = utf8_encode($rw_postulante['APELLIDO_PAT']);
    $apellido_mat   = utf8_encode($rw_postulante['APELLIDO_MAT']);
    $rut            = $rw_postulante['RUT'];
    $direccion      = utf8_encode($rw_postulante['direccion']);

    $calle          = utf8_encode($rw_postulante['calle']);
    $numero         = $rw_postulante['numero'];
    $depto_of_par   = $rw_postulante['depto_of_par'];
    $comuna         = utf8_encode($rw_postulante['comuna']);
    $cod_comuna     = $rw_postulante['cod_comuna'];

    $email          = $rw_postulante['EMAIL'];
    $fecha_nac      = $rw_postulante['FECHA_NAC'];
    $nacionalidad   = $rw_postulante['NACIONALIDAD'];
    
    $carrera_pro    = utf8_encode($rw_postulante['CARRERA_PRO']);
    $titulo         = utf8_encode($rw_postulante['TituloProfesional']);
    $r_universitario= $rw_postulante['r_universitario'];
    $genero         = $rw_postulante['GENERO'];

    $es_rut             = $rw_postulante['es_rut'];
    $RAZON_SOCIAL       = utf8_encode($rw_postulante['RAZON_SOCIAL']);
    $CARGO              = utf8_encode($rw_postulante['CARGO']);
    $CV                 = $rw_postulante['CV'];
    $telefono           = $rw_postulante['TELEFONO'];
    $celular            = $rw_postulante['CELULAR'];
    $ex_alumno          = $rw_postulante['EX_ALUMNO'];
    $fecha_postulacion  = $rw_postulante['fecha_postulacion'];
    $CARRERA_PRO        = utf8_encode($rw_postulante['CARRERA_PRO']);
    $titulado_uni       = utf8_encode($rw_postulante['titulado_uni']);
    $TituloProfesional  = utf8_encode($rw_postulante['TituloProfesional']);
    $UNIVERSIDAD        = utf8_encode($rw_postulante['UNIVERSIDAD']);
    $cod_diploma        = $rw_postulante['cod_diploma'];
    $ceco               = $rw_postulante['ceco'];
    $programa           = utf8_encode($rw_postulante['DIPLOMADO']);
    $fecha_inicio       = $rw_postulante['fecha_inicio'];
    $fecha_termino      = $rw_postulante['fecha_termino'];

    $etapaestado      = utf8_encode($rw_postulante['etapaestado']);
    $observaciones      = utf8_encode($rw_postulante['observaciones']);
    
    $financiamiento     = $rw_postulante['financiamiento'];
    $motivacion     = utf8_encode($rw_postulante['motivacion']);
    

    $linkedin           = $rw_postulante['linkedin'];
    $twitter            = $rw_postulante['twitter'];
    $sin_estudios       = $rw_postulante['sin_estudios'];
    
    $tecnico            = $rw_postulante['tecnico'];
    $institucion_tecnica= utf8_encode($rw_postulante['institucion_tecnica']);
    $carrera_tecnica    = utf8_encode($rw_postulante['carrera_tecnica']);
    $r_carrera_tec      = $rw_postulante['r_carrera_tec'];
    $fecha_tec          = $rw_postulante['fecha_tec'];
    
    $magister           = $rw_postulante['magister'];
    $universidad_mag    = utf8_encode($rw_postulante['universidad_mag']);
    $carrera_magister   = utf8_encode($rw_postulante['carrera_magister']);
    $r_magister         = $rw_postulante['r_magister'];
    $fecha_magister     = $rw_postulante['fecha_magister'];
    
    $doctorado          = $rw_postulante['doctorado'];
    $universidad_doc    = $rw_postulante['universidad_doc'];
    $carrera_doctorado  = $rw_postulante['carrera_doctorado'];
    $r_doctorado        = $rw_postulante['r_doctorado'];
    $fecha_doc          = $rw_postulante['fecha_doc'];
    
    $otro_estudio       = $rw_postulante['otro_estudio'];
    $estudio_1          = utf8_encode($rw_postulante['estudio_1']);
    $estudio_2          = utf8_encode($rw_postulante['estudio_2']);
    $ultimo_estudio     = $rw_postulante['ultimo_estudio'];
    
    $empleado           = $rw_postulante['empleado'];
    $busca_empleo       = $rw_postulante['busca_empleo'];
    $year_posicion      = $rw_postulante['year_posicion'];
    $personal_cargo     = $rw_postulante['personal_cargo'];
    $personas_a_cargo   = $rw_postulante['personas_a_cargo'];
    $empleado_publico   = $rw_postulante['empleado_publico'];
    
    $experiencia_lab    = $rw_postulante['experiencia_lab'];
    $empresa            = utf8_encode($rw_postulante['empresa']);
    $industria          = utf8_encode($rw_postulante['industria']);
    $actividad          = utf8_encode($rw_postulante['actividad']);
    $cargo              = utf8_encode($rw_postulante['cargo']);
    $fecha_ini          = $rw_postulante['fecha_ini'];
    $fecha_fin          = $rw_postulante['fecha_fin'];
    
    $empresa_2          = utf8_encode($rw_postulante['empresa_2']);
    $industria_2        = utf8_encode($rw_postulante['industria_2']);
    $actividad_2        = utf8_encode($rw_postulante['actividad_2']);
    $cargo_2            = $rw_postulante['cargo_2'];
    $fecha_ini_2        = $rw_postulante['fecha_ini_2'];
    $fehca_fin_2        = $rw_postulante['fehca_fin_2'];
    $empresa_3          = $rw_postulante['empresa_3'];
    $industria_3        = $rw_postulante['industria_3'];
    $actividad_3        = $rw_postulante['actividad_3'];
    $cargo_3            = $rw_postulante['cargo_3'];
    $fecha_ini_3        = $rw_postulante['fecha_ini_3'];
    $fecha_fin_3        = $rw_postulante['fecha_fin_3'];
    
    $motivacion_1       = $rw_postulante['motivacion_1'];
    $motivacion_2       = $rw_postulante['motivacion_2'];
    $motivacion_3       = $rw_postulante['motivacion_3'];
    $motivacion_4       = $rw_postulante['motivacion_4'];
    $carta_recomendacion= $rw_postulante['carta_recomendacion'];
    $certificado_titulo = $rw_postulante['certificado_titulo'];
    $periodo            = $rw_postulante['periodo'];
    $certificado_titulo_valida=$rw_postulante['certificado_titulo_valida'];
    $ee = $rw_postulante['ee'];
}

$sql_doc_firmados="SELECT 
    f.id_declaracion_64_dec5, 
    f.declaracion_firmado,
    f.id_contrato_ps_64_dec5,
    f.contrato_ps_firmado
FROM 
    intranet.firma_digital f 
WHERE 
    f.id_postulacion=".$id_postulacion;

$stmt_doc_firmados = $con->prepare($sql_doc_firmados);
$stmt_doc_firmados->setFetchMode(PDO::FETCH_ASSOC);
$stmt_doc_firmados->execute();
$num_doc_firmados = $stmt_doc_firmados->rowCount();	

//echo '::'.$num_doc_firmados;

//$arr_programas=[];
if ($rw_doc_firmados = $stmt_doc_firmados->fetch()){
    $id_declaracion_64_dec5 = $rw_doc_firmados['id_declaracion_64_dec5']; 
    $declaracion_firmado    = $rw_doc_firmados['declaracion_firmado'];
    $id_contrato_ps_64_dec5 = $rw_doc_firmados['id_contrato_ps_64_dec5'];
    $contrato_ps_firmado    = $rw_doc_firmados['contrato_ps_firmado'];
}

$sql_doc_adj="SELECT 
 distinct documento
FROM 
 intranet.postulacion_documentos WHERE idpostulacion=".$id_postulacion;

$stmt_doc_adj = $con->prepare($sql_doc_adj);
$stmt_doc_adj->setFetchMode(PDO::FETCH_ASSOC);
$stmt_doc_adj->execute();
$num_doc_adj = $stmt_doc_adj->rowCount();	

//echo '::'.$num_doc_adj;

//$arr_programas=[];
while ($rw_doc_adj = $stmt_doc_adj->fetch()){
 $arr_documentos[] = $rw_doc_adj['documento']; 
 
}


$sql_comunas="SELECT 
    c.cod_comuna,
    c.nombre,
    c.cod_region
FROM 
    unegocios_nuevo.comunas c
ORDER BY 
    c.nombre";

$stmt_comunas = $con->prepare($sql_comunas);
$stmt_comunas->setFetchMode(PDO::FETCH_ASSOC);
$stmt_comunas->execute();
$num_comunas = $stmt_comunas->rowCount();	


while ($rw_comunas = $stmt_comunas->fetch()){
    $arr_comunas[$rw_comunas['cod_comuna']] = utf8_encode($rw_comunas['nombre']); 
}
//echo '<pre>'.print_r($arr_comunas, true).'</pre>';
?>