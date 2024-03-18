<?php
include('cn/cn_PDO.php');

$usr_cordinador_ad=$_REQUEST['usuario'];
$tipo_programa=$_REQUEST['tipo'];
$modalidad_programa=$_REQUEST['modalidad'];



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
        AND d.tipo_programa='".$tipo_programa."'
        AND d.modalidad_programa='".$modalidad_programa."'
        AND d.periodo in ('2021S1','2021S2')
    ORDER BY d.fecha_inicio
";

//echo '<pre>'.$sql_programas.'</pre>';

$stmt_programas = $con->prepare($sql_programas);
$stmt_programas->setFetchMode(PDO::FETCH_ASSOC);
$stmt_programas->execute();
$num_programas=$stmt_programas->rowCount();	
//echo '::'.$num_convenios;

$arr_programas=[];
while ($rw_programas = $stmt_programas->fetch()){
    $arr_programas[]=array(
        "id_programa"   => $rw_programas['ID_DIPLOMA'],
        "Cod_interno"   => $rw_programas['Cod_interno'],
        "cod_diploma"   => $rw_programas['cod_diploma'],
        "programa"      => utf8_encode($rw_programas['DIPLOMADO']),
        "fecha_inicio"  => $rw_programas['fecha_inicio'],
        "fecha_termino" => $rw_programas['fecha_termino']
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="js/moment.js"></script>

    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/estilo.css">
<style>
.hide {
    display:none; 
}
.contador{
    color: #e1eaf0;
}
</style>
</head>
<body>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>CECO</th>
                <th>Cod_Diploma</th>
                <th>PROGRAMA</th>
                <th>FECHA INICIO</th>
                <th>FECHA TERMINO</th>
            </tr>
        </thead>
        <tbody>
            
    <?php
    foreach($arr_programas as $programas){
        
        ?>
        <tr>
                <td class="contador"></td>
                <td><?php echo $programas['Cod_interno'];?></td>
                <td><?php echo $programas['cod_diploma'];?></td>
                <td><?php echo $programas['programa'];?></td>
                <td><span class='hide'><?php echo date("Ymd", strtotime($programas['fecha_inicio']));?></span><?php echo date("d/m/Y", strtotime($programas['fecha_inicio']));?></td>
                <td><span class='hide'><?php echo date("Ymd", strtotime($programas['fecha_termino']));?></span><?php echo date("d/m/Y", strtotime($programas['fecha_termino']));?></td>
            </tr>
        <?php
    }
    ?>
    </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>CECO</th>
                <th>Cod_Diploma</th>
                <th>PROGRAMA</th>
                <th>FECHA INICIO</th>
                <th>FECHA TERMINO</th>
            </tr>
        </tfoot>
    </table>

<script src="js/jquery-3.5.1.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
/*
$(document).ready(function() {
    moment.locale('es');
    $('#example').DataTable({
        "pageLength": 50
        
    });
} );
*/
$(document).ready(function() {
    var t = $('#example').DataTable( {
        language: {
            url: 'js/es-mx.json'
        },
        "pageLength": 50,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 4, 'asc' ]]
        
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


} );
</script>
</body>
</html>