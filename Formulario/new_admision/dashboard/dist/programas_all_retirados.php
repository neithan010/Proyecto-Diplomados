<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario_intranet'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_x_estado_id_diploma.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Retirados <sub>Todos los Programas</sub></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="programas_all_aceptadas.php">Postulaciones</a></li>
                            <li class="breadcrumb-item active">Retirados</li>
                        </ol>

<form action="#" name="frm_periodo" id="frm_periodo" method="POST">
    <div class="row align-items-start p-3">
        <div class="col-3">Semestre:
            <select class="form-select form-select-sm " id="periodo" name="periodo" aria-label=".form-select-sm ">
                <option selected>Seleccione un semestre</option>
                <?php foreach($arr_periodos as $periodo_cmb){ ?>
                <option value="<?php echo $periodo_cmb;?>" <?php if($periodo_cmb==$periodo){echo 'selected';} ?>>
                    <?php echo $periodo_cmb;?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-9"></div>
    </div>
</form>
<!--
<div class="row align-items-start p-3">
<div class="col-7">
Filtrar en todas: <input type="text" name="" id="filtrar">
</div>
        <div class="col-5"></div>
</div>
                -->
        <div class="row align-items-start p-3">
        <div class="col-7">Programas:
            <select class="form-select form-select-sm " id="cmb_programa" name="cmb_programa" aria-label=".form-select-sm ">
                <option selected>Seleccione un Programa</option>
                <option value="">Mostrar Todos los programas </option>
                                            <?php
foreach($arr_programas as $programa){
?>
                <option value="<?php echo $programa['id_programa'];?>" >
                    <?php echo $programa['programa'];?></option>
<?php } ?>
            </select>
        </div>
        <div class="col-5"></div>
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
                                              ?>
                                              </div>

                                            <?php
  $arr_postulantes = _data_postulante($programa['id_programa'],'4020');
                                            
?>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small display" id="" width="100%" cellspacing="0">
                                    <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
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


    /* COMBOBOX PERIODOS  */
    $("#periodo" ).change(function() {
       
    // console.log( "Change periodo! " + $(this).val());
         
       $("#frm_periodo").submit();
                
     });



});
</script>

