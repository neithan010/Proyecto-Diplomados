<?php
include_once('cn.php');


$usr_cordinador_ad= isset($_SESSION['usuario_intranet'])?$_SESSION['usuario_intranet']:'';
//$tipo_programa= isset($_REQUEST['tipo'])?$_REQUEST['tipo']:'';
//$modalidad_programa= isset($_REQUEST['modalidad'])?$_REQUEST['modalidad']:'';

$periodo=isset($_POST['periodo'])?$_POST['periodo']:'';
//if($periodo==''){ $periodo=end($arr_periodos); }
if($periodo == ''){
    if($periodo_vigente <> ''){
        $periodo = $periodo_vigente;
    }else{
        $periodo = end($arr_periodos);
    }
     
}

$sql_programas="
    SELECT 
        d.ID_DIPLOMA,
        d.Cod_interno,
        d.cod_diploma,
        d.DIPLOMADO,
        d.fecha_inicio,
        d.fecha_termino
    FROM 
        intranet.diplomados d 
  
    WHERE 
        d.usr_cordinador_ad='".$usr_cordinador_ad."'
  
        AND d.habilitado=0
        AND d.web_habilitado=0
        
        AND d.Periodo='$periodo'

    ORDER BY d.fecha_inicio
";

//echo '<pre>'.$sql_programas.'</pre>';

$stmt_programas = $con->prepare($sql_programas);
$stmt_programas->setFetchMode(PDO::FETCH_ASSOC);
$stmt_programas->execute();
$num_programas=$stmt_programas->rowCount();	
//echo '::'.$num_convenios;

//$arr_programas=[];
while ($rw_programas = $stmt_programas->fetch()){

    $sql_resumen="SELECT
        sum(if(CONCAT(p.etapa, p.estado)IN('01','02','03'),1,0)) pre_post,
        sum(if(CONCAT(p.etapa, p.estado)IN('00'),1,0)) nuevas,
        sum(if(CONCAT(p.etapa, p.estado)IN('1030'),1,0)) en_eva,
        sum(if(CONCAT(p.etapa, p.estado)IN('2020','3131'),1,0)) aceptadas,
        sum(if(CONCAT(p.etapa, p.estado)IN('3131','3030'),1,0)) mat_pend,
        sum(if(CONCAT(p.etapa, p.estado)IN('2030'),1,0)) rechazadas,
        sum(if(CONCAT(p.etapa, p.estado)IN('2040'),1,0)) pendientes,
        sum(if(CONCAT(p.etapa, p.estado)IN('1010'),1,0)) eliminadas

        
        
    FROM unegocios_nuevo.postulacion p

    WHERE p.cod_diploma='".$rw_programas['cod_diploma']."'";

    $stmt_resumen = $con->prepare($sql_resumen);
    $stmt_resumen->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_resumen->execute();
    $num_resumen=$stmt_resumen->rowCount();	
    //echo '::'.$num_convenios;

        $pre_post   = '0';
        $nuevas     = '0';
        $en_eva     = '0';
        $aceptadas  = '0';
        $mat_pend   = '0';
        $eliminadas = '0';   
    
    if ($rw_resumen = $stmt_resumen->fetch()){
        $pre_post   = $rw_resumen['pre_post'];
        $nuevas     = $rw_resumen['nuevas'];
        $en_eva     = $rw_resumen['en_eva'];
        $aceptadas  = $rw_resumen['aceptadas'];
        $mat_pend   = $rw_resumen['mat_pend'];
        $rechazadas = $rw_resumen['rechazadas'];
        $pendientes = $rw_resumen['pendientes'];
        $eliminadas = $rw_resumen['eliminadas'];
    }
    
    if($pre_post    ==''){$pre_post     = 0;}
    if($nuevas      ==''){$nuevas       = 0;}
    if($en_eva      ==''){$en_eva       = 0;}
    if($aceptadas   ==''){$aceptadas    = 0;}
    if($mat_pend    ==''){$mat_pend     = 0;}
    if($rechazadas  ==''){$rechazadas   = 0;}
    if($pendientes  ==''){$pendientes   = 0;}
    if($eliminadas  ==''){$eliminadas   = 0;}


    $arr_programas[]=array(
        "id_programa"   => $rw_programas['ID_DIPLOMA'],
        "Cod_interno"   => $rw_programas['Cod_interno'],
        "cod_diploma"   => $rw_programas['cod_diploma'],
        "programa"      => utf8_encode($rw_programas['DIPLOMADO']),
        "fecha_inicio"  => $rw_programas['fecha_inicio'],
        "fecha_termino" => $rw_programas['fecha_termino'],
        "pre_post"      => $pre_post,
        "nuevas"        => $nuevas,
        "en_eva"        => $en_eva,
        "aceptadas"     => $aceptadas,
        "mat_pend"      => $mat_pend,
        "rechazadas"    => $rechazadas,
        "pendientes"    => $pendientes,
        "eliminadas"    => $eliminadas
    );
}
?>