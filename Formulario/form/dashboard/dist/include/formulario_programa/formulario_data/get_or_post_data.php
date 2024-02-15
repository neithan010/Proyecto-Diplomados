<?php
include('cn/cn_PDO.php');
include('functions_program.php');
include('../header.php');

$nombre_programa = htmlspecialchars(addslashes($_POST['nombre_programa']));
$tipo_producto = $_POST['tipo_producto'];
$area = $_POST['area'];
$tipo_programa = $_POST['tipo_programa'];
$modalidad = $_POST['modalidad'];
$periodo = $_POST['periodo'];
$jornada = $_POST['horario'];
$nivel = $_POST['nivel'];
$realizacion_en = $_POST['realización_en'];
$fecha_de_inicio = $_POST['fecha_de_inicio'];
$version = '';

$buscar = $_POST['buscar'];

#En caso de que ya hayamos obtenido el programa, veremos que getted_program_2 deberia ser true
#el objetivo es obtener la version, que se solicita cuando se toma un programa ya creado.
$getted_program_2 = $_POST['getted_program_2'];

if($getted_program_2){
    $version = $_POST['version'];
} 

$getted_program = false;
?>
<script>
    var getted_program_2 = <?php echo $getted_program_2;?>;
    var buscar = <?php echo $buscar;?>;

    if(buscar){
        var campo_nombre_programa = <?php echo $nombre_programa;?>;
        var campo_tipo_producto = <?php echo $tipo_producto;?>;
        var campo_area = <?php echo $area;?>;
        var campo_tipo_programa = <?php echo $tipo_programa;?>;
        var campo_modalidad = <?php echo $modalidad;?>;
        var campo_periodo = <?php echo $periodo;?>;
        var campo_jornada = <?php echo $jornada;?>;
        var campo_nivel = <?php echo $nivel;?>;
        var campo_realizacion_en = <?php echo $realizacion_en;?>;
        var campo_fecha_de_inicio = <?php echo $fecha_de_inicio;?>;
        var campo_version = <?php echo $version;?>;

        var list_campos = [['nombre_programa',campo_nombre_programa], ['tipo_producto',campo_tipo_producto], ['area',campo_area], 
            ['tipo_programa',campo_tipo_programa], ['modalidad',campo_modalidad], ['periodo',campo_periodo], ['horario',campo_horario],
            ['nivel',campo_nivel], ['realización_en',campo_realizacion_en], ['fecha_de_inicio',campo_fecha_de_inicio], 
            ['version', campo_version]];
        
        // Crear un objeto FormData para enviar los datos
        var list_campos_data = new FormData();
        list_campos_data.append('list_campos_data', list_campos);

        // Hacer la solicitud para list_campos_no_vacios
        fetch('get_program.php', {
        method: 'POST',
        body: list_campos_data
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

#Si estamos en modo desde 0, ingresar un nuevo programa
else{
    $getted_program = false;
    include('post_program.php');
}

include_once('../footer.php');
?>