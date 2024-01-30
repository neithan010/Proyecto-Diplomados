<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario_intranet'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_en_evaluacion.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Todos los Programas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Tipo de Programas</a></li>
                            <li class="breadcrumb-item active">Todos los programas</li>
                        </ol>


<div class="p-3">
  <?php include('menu_estados.php'); ?>
</div>



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        DataTable Programas
    </div>
    <div class="card-body">
        <div class="table-responsive">

        
<?php


                                            foreach($arr_programas as $programa){
                                            ?>
<div id="<?php echo $programa['id_programa'];?>" class="div_programa_detalle">
  <div class="container-sm bg-info bg-gradientt p-3 rounded-3 m-3 shadow-sm" style="--bs-bg-opacity: .1;">
  (<a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['id_programa'];?></a>) 
                                                <?php echo $programa['programa'];?> <br>
                                                CECO: <?php echo $programa['Cod_interno'];?> <br>
                                                Cod Diploma: <?php echo $programa['cod_diploma'];?><br>
                                                Inicio: <?php 
                                              if($programa['fecha_inicio']<>''){
                                                echo date("d/m/Y", strtotime($programa['fecha_inicio']));
                                              }else{ echo 'Por definir'; } ?> <br> 
                                              Termino: <?php 
                                              if($programa['fecha_termino']<>''){
                                                echo date("d/m/Y", strtotime($programa['fecha_termino']));
                                              }else{
                                                echo 'Por definir';
                                              }
                                              ?><br>
                                            <span id="td_mail<?php echo $programa['id_programa'];?>">
                                                <button class="btn btn-sm btn-info btn_mail_re_enviar"
                                                    data_id="<?php echo $programa['id_programa'];?>|<?php echo $programa['cod_diploma'];?>|<?php echo $programa['programa'];?>|<?php echo $_SESSION['usuario_intranet'];?>">re enviar a DA <i class="bi bi-envelope"></i></button>
                                              </div>
                                            </span>

                                            <?php
  $arr_postulantes = _data_postulante($programa['id_programa'],'1030');
                                            
?>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small display" id="" width="100%" cellspacing="0">
                                    <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>Tiempo</th>
                                                <th>NOMBRE</th>
                                                <th>RUT</th>
                                                <th>Nacionalidad</th>
                                                <th>Dirección</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>Tiempo</th>
                                                <th>NOMBRE</th>
                                                <th>RUT</th>
                                                <th>Nacionalidad</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                            
                                        <tbody>
                                            <?php
                                          if(!empty($arr_postulantes)){
                                            foreach($arr_postulantes as $postulante){
                                            ?>
                                            <tr>
                                                <td><?php echo $postulante['id_postulacion'];?></td>
                                                <td ><img src="<?php echo $postulante['foto'];?>" height="24" alt="" ></td>
                                                <td>
                                                <?php //echo $postulante['tiempo_dias']; 
                                                  switch ($postulante['tiempo_dias']) {
                                                    case 0:
                                                        $bg_barra='bg-success';
                                                        $porcentaje_barra=25;
                                                        
                                                        break;
                                                    
                                                    case 1:
                                                      $bg_barra='bg-warning';
                                                      $porcentaje_barra=50;
                                                        break;
                                                    
                                                    default:
                                                        $bg_barra='bg-danger';
                                                          $porcentaje_barra=100;
                                                          break;
                                                }
                                                  ?>
                      <div class="progress">
                        <div class="progress-bar <?php echo $bg_barra;?>" role="progressbar"
                          style="width: <?php echo $porcentaje_barra;?>%" aria-valuenow="25" aria-valuemin="0"
                          aria-valuemax="100"><?php echo $postulante['tiempo_dias'].' días';?></div>
                      </div>

                                                </td>
                                                <td nowrap><?php echo $postulante['nombres'].' '.$postulante['apellido_pat'].' '.$postulante['aprllido_mat'];?></td>
                                                <td><?php echo $postulante['rut'];?></td>
                                                <td><?php echo $postulante['nacionalidad'];?></td>
                                                <td><?php echo $postulante['direccion'];?></td>
                                                <td align="center">
                                                  <a href="ficha_postulante.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>" target="_blank"><i class="fas fa-file-alt"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                          }else{
                                            $no_boton_mail[]=$programa['id_programa'];
                                          }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
</div>
                        <?php


                                            }
                                            ?>

                                </div>
                                <p>
                                  <!-- 
                                    <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/pre_portulaciones_excel.php?usr=<?php echo $usuario; ?>" target="_blank" rel="noopener noreferrer">Exportar datos pre-postulaciones</a>
                                          -->
                                        </p>
                                
                            </div>
                        </div>
                    </div>


<?php
include_once('include/footer.php');
?> 
<script>


$( document ).ready(function() {
 
    var table = $('table.display').DataTable({
            language: {
            url: '../../js/es-mx.json'
            },
            paging: false,

        });



    $('#filtrar').on( 'keyup', function () {
        table.search( this.value ).draw();
    });


    /* COMBOBOX PERIODOS  */
    $("#periodo" ).change(function() {
       
    // console.log( "Change periodo! " + $(this).val());
         
       $("#frm_periodo").submit();
                
     });


     $("body").on("click", ".btn_mail_re_enviar", function () {
            //$( ".btn_mail" ).click(function() {
            event.preventDefault();
            var ctrl = $(this).parent();
            $(ctrl).empty();
            var arr_data = $(this).attr('data_id').split("|");
            var cod_diploma = arr_data[1];
            var programa = arr_data[2];
            var usuario = arr_data[3];


            $.post("../../../cdg/postulacion/admision/postulaciones_re_enviar_DA.php", {
                  cod_diploma: cod_diploma,
                  diplomas: programa,
                  frm: 2,
                  usuario: usuario,
                    nocache: Math.random()
                })
                .done(function (data) {
                    $(ctrl).html('<div class="alert alert-success" role="alert">'+data+'</div>');

                });
                
        });
<?php
foreach($no_boton_mail as $no_boton){
  echo '$("#td_mail'.$no_boton.'").hide();';

}
?>
        

});
</script>

