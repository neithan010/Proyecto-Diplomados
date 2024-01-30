<?php
$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
}
if($id_postulacion==''){ 
    echo 'Error';
    exit();
}

$nombre_pdf='declaracion.pdf';

$dir_pdf = dirname(__FILE__, 3).'/Fichas/'.$id_postulacion;

if(file_exists($dir_pdf.'/'.$nombre_pdf)){
	$oldname=$dir_pdf.'/'.$nombre_pdf;
	$newname=$dir_pdf.'/BK/'.rand(000, 999).'_'.$nombre_pdf;

    if(!file_exists($dir_pdf.'/BK/')){
        if(mkdir($dir_pdf.'/BK/', 0777, true)) {
            rename($oldname,$newname);
            echo 'Borrado';

            include('../../cn/cn_PDO.php');	
            $sql_postulacion_data_pagos="UPDATE intranet.postulacion_data_pagos pdp
            SET 
                pdp.declaracion_jurada=''
            WHERE 
                pdp.id_postulacion=".$id_postulacion;
        
            $stmt_pdp = $con->prepare($sql_postulacion_data_pagos);
            $stmt_pdp ->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_pdp ->execute();

        }else{
            echo 'Error al borrar';
        }
    }else{
        rename($oldname,$newname);
        echo 'Borrado';

        include('../../cn/cn_PDO.php');	
        $sql_postulacion_data_pagos="UPDATE intranet.postulacion_data_pagos pdp
        SET 
            pdp.declaracion_jurada=''
        WHERE 
            pdp.id_postulacion=".$id_postulacion;
    
        $stmt_pdp = $con->prepare($sql_postulacion_data_pagos);
        $stmt_pdp ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_pdp ->execute();
    }
}


?>