<?php

session_start();

$nombre_programa = '';
$tipo_programa = $REQUEST['tipo_programa'];
$area = $REQUEST['area_conocimiento'];
$modalidad = $REQUEST['modalidad_programa'];

if(isset($_REQUEST['nombre_programa'])){

    $nombre_programa = trim($_REQUEST['tnombre_programa']);

    if(strlen($nombre_programa)> 0 ){

        $buscar_nombre = '%'.str_replace(" ","%",$nombre_programa).'%';

        $sql_buscar_programa ="SELECT * 
                               FROM intranet.diplomados d
                               WHERE d.nom_diploma LIKE '%_%' AND 
                                     d.tipo_programa LIKE '%_%' AND 
                                     d.area_conocimiento LIKE '%_%' AND
                                     d.modalidad_programa LIKE '%B_%' AND
                                     d.Periodo LIKE '%_%'";

        $stmt_buscar = $con->prepare($sql_buscar_programa);
        $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_buscar ->execute();
        $num_buscar =$stmt_buscar ->rowCount();	

        while($row_buscar = $stmt_buscar -> fetch()){

            $arr_buscar[] = array(

                "id_programa" => $row_buscar['']
                
            )
        }
    }
}