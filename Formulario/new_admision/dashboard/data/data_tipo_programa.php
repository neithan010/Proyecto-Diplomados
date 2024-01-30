<?php
include('cn.php');

$sql_tipo_programas="
    SELECT DISTINCT 
        d.tipo_programa 
       -- , d.modalidad_programa
    FROM 
        intranet.diplomados d 
        INNER JOIN intranet.periodos p ON d.Periodo=p.periodo
    WHERE 
        d.usr_cordinador_ad='".$_SESSION['usuario_intranet']."'
        AND p.vigente_adm=1
        AND d.habilitado=0
    ORDER BY d.tipo_programa
";

//echo '<pre>'.$sql_tipo_programas.'</pre>';

$stmt_tipo_programas = $con->prepare($sql_tipo_programas);
$stmt_tipo_programas->setFetchMode(PDO::FETCH_ASSOC);
$stmt_tipo_programas->execute();
$num_tipo_programas=$stmt_tipo_programas->rowCount();	
//echo '::'.$num_convenios;

//$arr_tipo_programas=[];
while ($rw_tipo_programas = $stmt_tipo_programas->fetch()){
    $arr_tipo_programas[]=array(
        "tipo_programa"         => $rw_tipo_programas['tipo_programa']
        //, "modalidad_programa"    => $rw_tipo_programas['modalidad_programa']
    );
}

?>