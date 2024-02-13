<?php

#obtener todos los campos rellenados en la busqueda
$list_campos_data = $_POST['list_campos_data'];
$list_nombres = ['nombre_programa','tipo_producto','area','modalidad','periodo','horario','nivel','realización_en','fecha_de_inicio','version'];

#Discriminamos para saber que valores fueron entregados en el formulario
?>
<script>
    var list_campos_data = <?php echo $list_campos_data;?>;
    var list_nombres = <?php echo $list_nombres;?>;
    var L = list_campos_data.length;
    if(L < 10){
        list_campos_data.
    }
    for (var i = 0; i < L; i++){
        
    }
</script>
<?php
'SELECT *
FROM intranet.diplomados d
WHERE'
function get_program($list_campos_no_vacios, $list_nombres_no_vacios){
    if(isset($nombre_programa)){

        $nombre_programa = trim($_POST['nombre_programa']);

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
}
include('display_program_results.php')

?>