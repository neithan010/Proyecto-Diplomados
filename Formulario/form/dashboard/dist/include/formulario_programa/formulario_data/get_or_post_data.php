<?php
include('cn/cn_PDO.php');

$nombre_programa = $_POST['nombre_programa'];
$nombre_programa = htmlspecialchars(addslashes($_POST['nombre_programa']))
$tipo_producto = $_POST['tipo_producto'];
$area = $_POST['area'];
$tipo_programa = $_POST['tipo_programa'];
$modalidad = $_POST['modalidad'];
$periodo = $_POST['periodo'];
$jornada = $_POST['horario'];
$nivel = $_POST['nivel'];
$realizacion_en = $_POST['realización_en'];
$fecha_de_inicio = $_POST['fecha_de_inicio'];
$getted_program = false;

echo "<script>  var campo_nombre_programa = '$nombre_programa';
                var campo_tipo_producto = '$tipo_producto';
                var campo_area = '$area';
                var campo_tipo_programa = '$tipo_programa';
                var campo_modalidad = '$modalidad';
                var campo_periodo = '$periodo';
                var campo_jornada = '$jornada';
                var campo_nivel = '$nivel';
                var campo_realizacion_en = '$realizacion_en';
                var campo_fecha_de_inicio = '$fecha_de_inicio';
                var getted_program = '$getted_program';
                var buscar = '$buscar';</script>";
?>

<script>
    if(buscar){
        var list_campos = [['nombre_programa',campo_nombre_programa], ['tipo_producto',campo_tipo_producto], ['area',campo_area], 
            ['tipo_programa',campo_tipo_programa], ['modalidad',campo_modalidad], ['periodo',campo_periodo], ['horario',campo_horario],
            ['nivel',campo_nivel], ['realización_en',campo_realizacion_en], ['fecha_de_inicio',campo_fecha_de_inicio]];

        var list_campos_no_vacios = [];
        var list_nombres_no_vacios = [];
        for (var i = 0; i < list_campos.length; i++) {
            if(list_campos[i][1] != ''){
                list_campos_no_vacios.push(list_campos[i][1]);
                list_nombres_no_vacios.push(list_campos[i][0]);
            }
        }
        // Crear un objeto FormData para enviar los datos
        var formData = new FormData();
        formData.append('list_campos_no_vacios', list_campos_no_vacios);

        // Hacer la solicitud para list_campos_no_vacios
        fetch('get_program.php', {
        method: 'POST',
        body: formData
        })
        .catch(error => {
        // Manejar errores
        });

        var formData2 = new FormData();
        formData2.append('list_nombres_no_vacios', list_nombres_no_vacios);

        fetch('get_program.php', {
        method: 'POST',
        body: formData2
        })
        .catch(error => {
        // Manejar errores
        });
    }
</script>

<?php
#Si estamos en modo busqueda de un programa
if($buscar){
    $getted_program = true;
    $buscar = false;
    include('get_program.php');
}

#Si estamos en modo, ingresar un nuevo programa
else{
    $getted_program = false;
    include('post_program.php');
}
?>