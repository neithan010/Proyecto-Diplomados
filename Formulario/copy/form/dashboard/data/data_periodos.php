<?php
include_once('cn.php');

$sql_periodo="SELECT 
    p.periodo, 
    p.vigente 
FROM 
    intranet.periodos p 
WHERE 
    p.vigente_adm=1
ORDER BY 
    p.periodo desc";

$stmt_periodos = $con->prepare($sql_periodo);
$stmt_periodos->setFetchMode(PDO::FETCH_ASSOC);
$stmt_periodos->execute();
$num_periodos=$stmt_periodos->rowCount();	

while ($rw_periodos = $stmt_periodos->fetch()){
    $arr_periodos[]=$rw_periodos['periodo'];
    if($rw_periodos['vigente']==1){
        $periodo_vigente=$rw_periodos['periodo'];
    }
}
?>

