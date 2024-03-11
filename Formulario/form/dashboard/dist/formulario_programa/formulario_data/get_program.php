<?php
#obtener todos los campos rellenados en la busqueda
$list_campos_data = $_POST['list_campos_data'];
$list_nombres_r = ['nombre_programa','tipo_producto','area','modalidad','periodo','horario','nivel','realización_en','fecha_de_inicio','version'];

#Discriminamos para saber que valores fueron entregados en el formulario
?>
<script>
    var list_campos_data = <?php echo $list_campos_data;?>;
    var list_nombres_r = <?php echo $list_nombres_r;?>;
    var L = list_campos_data.length;
    var list_nombres = [];

    //recorremos los datos, si encontramos uno vacio entonces eliminamos el nombre y el valor de dicha variable.
    for (var i = 0; i < L; i++){
        if(isset(list_campos_data[i][1])){
            $list_nombres.push(list_nombres_r[i]);
        }
        else{
            $list_campos_data.splice(i,1);
        }
    }

</script>
<?php

function get_program($list_campos_data){
    L= $list_campos_data.length;

    $conditions = ""
    #Creamos las condiciones de la sig forma: d.area = AREA AND...
    for(var i = 1; i < L; i++){
            $conditions .= "d.".$list_campos_data[i][0]." = ".$list_campos_data[i][1]." AND ";
    }

    $sql_buscar_programa =  "SELECT "
                            #Escogemos los atributos con los que buscamos
                            .implode(', '.'d.', $list_nombres_r)
                            . ","
                            #Obtenemos otros atributos
                            . "d.DIPLOMADO 
                            FROM intranet.diplomados d
                            WHERE "
                                #Le agregamos las condiciones para que filtre segun el usuario buscó.
                                .$conditions
                                #Le agregamos las condiciones necesarias para que filtre segun nombres y variantes
                                ."INSERTAR CONDICIONES"

    $stmt_buscar = $con->prepare($sql_buscar_programa);
    $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_buscar ->execute();
    $num_buscar =$stmt_buscar ->rowCount();

    $arr_programas = array();

    while($row = $stmt_buscar->fetch()){
        $arr_programas[] = array(
            #Obtenemos atributos del formulario
            for(var i = 1; i < L; i++){
                $list_nombres_r[i] => $row[$list_nombres_r[i]];
            }
            #Obtenemos otros atributos.
            "DIPLOMADO" => $row['DIPLOMADO'];
        );
    }

    $arr_f = array($num_buscar, $arr_programas);
    return $arr_f;
}

#sacamos el par(N, array) con el numero de filas en el array encontrado
$programas_encontrados = get_program($list_campos_data);
include('display_program_results.php');
?>