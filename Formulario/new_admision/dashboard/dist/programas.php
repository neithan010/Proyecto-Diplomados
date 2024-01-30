<?php
session_start();

$usuario=$_SESSION['usuario'];

include_once('include/header.php');
include_once('../data/data_periodos.php');
include_once('../data/data_programas.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?php echo $tipo_programa;?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Tipo de Programas</a></li>
                            <li class="breadcrumb-item active"><?php echo $tipo_programa.' '.$modalidad_programa;?></li>
                        </ol>
                        <form action="#" name="frm_periodo" id="frm_periodo" method="POST">
                            <input type="hidden" name="tipo" value="<?php echo $_REQUEST['tipo'];?>">
                            <input type="hidden" name="modalidad" value="<?php echo $_REQUEST['modalidad'];?>">

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
                                    <table class="table table-bordered small" id="dataTableprogramas" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>CECO</th>
                                                <th>CODIGO</th>
                                                <th>PROGRAMA</th>
                                                <th>FECHA INICIO</th>
                                                <th>FECHA TERMINO</th>
                                                <th>PRE</th>
                                                <th>NUEVAS</th>
                                                <th>EVA</th>
                                                <th>ACEP</th>
                                                <th>MAT</th>
                                                <th>RECH</th>
                                                <th>PEND</th>
                                                <th>ELIM</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>CECO</th>
                                                <th>CODIGO</th>
                                                <th>PROGRAMA</th>
                                                <th>FECHA INICIO</th>
                                                <th>FECHA TERMINO</th>
                                                <th>PRE</th>
                                                <th>NUEVAS</th>
                                                <th>EVA</th>
                                                <th>ACEP</th>
                                                <th>MAT</th>
                                                <th>RECH</th>
                                                <th>PEND</th>
                                                <th>ELIM</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            foreach($arr_programas as $programa){
                                            ?>
                                            <tr>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['id_programa'];?></a></td>
                                                <td nowrap><?php echo $programa['Cod_interno'];?></td>
                                                <td nowrap><?php echo $programa['cod_diploma'];?></td>
                                                <td ><?php echo $programa['programa'];?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_inicio'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_inicio']));?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_termino'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_termino']));?></td>
                                                <td><a href="postulantes_pre_post.php?id=<?php echo $programa['id_programa'];?>" target="_self"><?php echo $programa['pre_post'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['nuevas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['en_eva'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['aceptadas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['mat_pend'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['rechazadas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['pendientes'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['eliminadas'];?></a></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/pre_portulaciones_excel.php?usr=<?php echo $usuario; ?>" target="_blank" rel="noopener noreferrer">Exportar datos pre-postulaciones</a></p>
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/aceptados_no_matriculados.php?usr=<?php echo $usuario; ?>" target="_blank">Aceptados no Matriculados</a></p>
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/enviados_UA.php?usr=<?php echo $usuario; ?>" target="_blank">Enviados a UA</a></p>
                            </div>
                        </div>
                    </div>


<?php
include_once('include/footer.php');
?> 
<script>


$( document ).ready(function() {
    $('#dataTableprogramas').DataTable({
    language: {
      url: '../../js/es-mx.json'
    },
    columns: [
            
                { "type": "html-num" },
                null,
                null,
                null,
                null,
                null,
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" },
                { "type": "html-num" }
            
        ]    
   
     
  });

  
  $("#periodo" ).change(function() {
       
     console.log( "Change periodo! " + $(this).val());
       
     $("#frm_periodo").submit();
              
   });
  
});
</script>