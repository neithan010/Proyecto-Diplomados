<?php
session_start();

include_once('include/header.php');
include_once('../data/data_postulantes_rechazadas.php');
include_once('../data/data_programa_x_id.php');


//echo ':: <pre>'.print_r($arr_postulantes, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?php echo $tipo_programa;?> Rechazadas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Tipo de Programas</a></li>
                            <li class="breadcrumb-item"><a href="programas.php?tipo=<?php echo $tipo_programa;?>&modalidad=<?php echo $modalidad_programa;?>"><?php echo $tipo_programa.' '.$modalidad_programa;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $programa;?></li>
                        </ol>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="postulantes.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Aceptadas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="postulantes_pre_post.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Pre Postulacion</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="postulantes_nuevas.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Nuevas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="postulantes_eva.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">En Evaluación</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Rechazadas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="postulantes_pendientes.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Pendientes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="postulantes_eliminadas.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Eliminadas</a>
  </li>
</ul>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                <?php echo '['.$ceco.']';?> <?php echo $programa;?> <?php echo '['.$cod_diploma.']';?><br>Inicio: <?php echo date("d/m/y", strtotime($fecha_inicio));?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>FECHA ACEPTADO</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO PAT</th>
                                                <th>APELLIDO MAT</th>
                                                <th>RUT</th>
                                                <th></th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>FECHA ACEPTADO</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO PAT</th>
                                                <th>APELLIDO MAT</th>
                                                <th>RUT</th>
                                                <th></th>
                                             
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            foreach($arr_postulantes as $postulante){
                                            ?>
                                            <tr>
                                                <td><a href="postulantes.php?id=<?php echo $postulante['id_postulacion'];?>" target="_self"><?php echo $postulante['id_postulacion'];?></a></td>
                                                <td ><img src="<?php echo $postulante['foto'];?>" height="24" alt="" ></td>
                                                <td nowrap><span class="text-hide "><?php echo $postulante['fecha_aceptado'];?></span> <?php echo date("d/m/Y", strtotime($postulante['fecha_aceptado']));?></td>
                                                <td nowrap><?php echo $postulante['nombres'];?></td>
                                                <td ><?php echo $postulante['apellido_pat'];?></td>
                                                <td><?php echo $postulante['aprllido_mat'];?></td>
                                                <td><?php echo $postulante['rut'];?></td>
                                                <td align="center">
                                                  <a href="ficha_postulante.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>"><i class="fas fa-file-alt"></i></a>
                                                </td>
                                               
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


<?php
include_once('include/footer.php');
?> 
<script>
$( document ).ready(function() {


    
});
</script>