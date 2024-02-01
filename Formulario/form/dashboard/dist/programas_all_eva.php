<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_all_prepostulacion.php');

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

                        <form action="#" name="frm_periodo" id="frm_periodo" method="POST">
                        <div class="row align-items-start p-3">
                          <div class="col-3">Semestre: 
                            <select class="form-select form-select-sm " id="periodo" name="periodo" aria-label=".form-select-sm ">
                              <option selected>Seleccione un semestre</option>
                              <?php foreach($arr_periodos as $periodo_cmb){ ?>
                              <option value="<?php echo $periodo_cmb;?>" <?php if($periodo_cmb==$periodo){echo 'selected';} ?> ><?php echo $periodo_cmb;?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-9"></div>
                        </div>
                        </form>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                DataTable Programas
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                Filtrar en todas: <input type="text" name="" id="filtrar">
                                            <?php
                                            foreach($arr_programas as $programa){
                                            ?>
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
                                              ?>
                                              </div>

                                            <?php

                                            
?>
<div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small display" id="" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>FECHA<br><sub>pre-postulacíon</sub></th>
                                                <th>NOMBRE</th>
                                                
                                                <th>RUT</th>
                                                <th></th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>FECHA<br><sub>pre-postulacíon</sub></th>
                                                <th>NOMBRE</th>
                                                
                                                <th>RUT</th>
                                                <th></th>
                                                                                            
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php

                                            $arr_postulantes = _data_postulantes($programa['id_programa']);

                                            $pendiente=0;
                                            
                                            foreach($arr_postulantes as $postulante){
                                            ?>
                                            <tr>
                                                <td><?php echo $postulante['id_postulacion'];?></td>
                                                <td >
                                                  <?php //echo $postulante['tiempo_dias']; 
                                                  switch ($postulante['tiempo_dias']) {
                                                    case 0:
                                                        $bg_barra='bg-success';
                                                        $porcentaje_barra=25;
                                                        
                                                        break;
                                                    case 1:
                                                        $bg_barra='bg-success';
                                                        $porcentaje_barra=25;
                                                        break;
                                                    case 2:
                                                      $bg_barra='bg-warning';
                                                      $porcentaje_barra=50;
                                                        break;
                                                    case 3:
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
                                                    <div class="progress-bar <?php echo $bg_barra;?>" role="progressbar" style="width: <?php echo $porcentaje_barra;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $postulante['tiempo_dias'].' días';?></div>
                                                  </div>
                                                </td>
                                                <td nowrap><span class="text-hide "><?php echo $postulante['fecha_aceptado'];?></span> <?php echo date("d/m/Y", strtotime($postulante['fecha_aceptado']));?></td>
                                                <td nowrap><?php echo $postulante['nombres'].' '. $postulante['apellido_pat'].' '.$postulante['aprllido_mat'];?></td>
                                                
                                                <td nowrap><?php 
                                                    echo $postulante['rut'];
                                                    if(!$postulante['es_rut_valido']){
                                                      ?>
                                                      <spam data-bs-toggle="tooltip" data-bs-placement="top" title="Rut no valido">⚠
                                                      </spam>
                                                      <?php  
                                                      }
                                                      ?>
                                                </td>
                                                <td align="center">
                                                <button class="btn btn-success btn-sm">Enviar mail</button>
                                                </td>
                                                
                                               
                                            </tr>
                                            <?php
                                            }
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                        <?php


                                            }
                                            ?>

                                </div>
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/pre_portulaciones_excel.php?usr=<?php echo $usuario; ?>" target="_blank" rel="noopener noreferrer">Exportar datos pre-postulaciones</a></p>
                                
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

    $("#periodo" ).change(function() {
       
       console.log( "Change periodo! " + $(this).val());
         
       $("#frm_periodo").submit();
                
     });

});
</script>