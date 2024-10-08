<?php

$id_postulacion=isset($_REQUEST['id_postulacion'])?$_REQUEST['id_postulacion']:'';

session_start();
$usuario=$_SESSION['usuario'];

include_once('include/header.php');
include_once('../data/data_postulantes.php');
include_once('../data/data_programa_x_id.php');


//echo ':: <pre>'.print_r($arr_postulantes, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?php echo $tipo_programa;?> Aceptados</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Tipo de Programas</a></li>
                            <li class="breadcrumb-item"><a href="programas.php?tipo=<?php echo $tipo_programa;?>"><?php echo $tipo_programa;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $programa;?></li>
                        </ol>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Aceptadas</a>
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
    <a class="nav-link" href="postulantes_rechazadas.php?id=<?php echo $id;?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>">Rechazadas</a>
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
                                    <table class="table table-bordered small display" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>FECHA ACEPTADO</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO PAT</th>
                                                <th>APELLIDO MAT</th>
                                                <th>RUT</th>
                                                <th>F</th>
                                                <th>CV</th>
                                                <th>DJ</th>
                                                <th>CS</th>
                                                <th>M</th>
                                                <th>DOCUMENTAR</th>
                                                <th>Envio UA</th>
                                                <th>Recibido UA</th>
                                                <th>Aceptado UA</th>
                                                <th>Facturado UA</th>
                                                
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
                                                <th>F</th>
                                                <th>CV</th>
                                                <th>DJ</th>
                                                <th>CS</th>
                                                <th>M</th>
                                                <th>DOCUMENTAR</th>
                                                <th>Envio UA</th>
                                                <th>Recibido UA</th>
                                                <th>Aceptado UA</th>
                                                <th>Facturado UA</th>
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $pendiente=0;
                                            foreach($arr_postulantes as $postulante){
                                            ?>
                                            <tr>
                                                <td><?php echo $postulante['id_postulacion'];?></td>
                                                <td >
                                                <?php
                                                $arr_url_foto=explode("/",$postulante['foto']);
                                                $url_foto='../../../../fotos/upload_pic/'.end($arr_url_foto);
                                                
                                                if(!file_exists($url_foto)){
                                                ?>
                                                <a href="https://intranet.unegocios.cl/fotos/index.php?rut_alumno=<?php echo $postulante['rut'];?>" target="_blank">
                                                            <img src="../../../cdg/img/matriculados/1.jpg" width="16px" height="24px" border="0">
                                                          </a>
                                                <?php
                                                }else{
                                                ?>
                                                  <img src="<?php echo $postulante['foto'];?>" height="24" alt="" >
                                                <?php
                                                }
                                                ?>  
                                                
                                                </td>
                                                <td nowrap><span class="text-hide "><?php echo $postulante['fecha_aceptado'];?></span> <?php echo date("d/m/Y", strtotime($postulante['fecha_aceptado']));?></td>
                                                <td nowrap><?php echo $postulante['nombres'];?></td>
                                                <td ><?php echo $postulante['apellido_pat'];?></td>
                                                <td><?php echo $postulante['aprllido_mat'];?></td>
                                                <td nowrap><?php echo $postulante['rut'];?></td>
                                                <td align="center">
                                                  <a href="ficha_postulante.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>" target="_blank"><i class="fas fa-file-alt"></i></a>
                                                </td>
                                                
                                                <td><?php
                                              if($postulante['cv']<>''){
                                                $url="https://unegocios.uchile.cl/CV/".$postulante['cv'];
                                                //if (false!==file($url)){
                                                  ?>
                                                  <a href="<?php echo $url;?>" target="_blank" rel="noopener noreferrer"><i class="bi bi-file-person"></i></a>  
                                                  <?php
                                                //}
                                              }
                                                ?>
                                              
                                              </td>

                                                <td nowrap>
                                                  <?php
                                                if(!empty($arr_firma_certinet[$postulante['id_postulacion']])){
                                                  $arr=$arr_firma_certinet[$postulante['id_postulacion']];
                                                  //var_dump($arr);
                                                  if($arr[0]['documento']=='declaracion' || $arr[1]['documento']=='declaracion'){
                                                    ?>
                                                    
                                                      <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/get_document.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>&documento=declaracion" target="_blank" rel="noopener noreferrer"><i class="far fa-file-pdf"></i></a>
                                                    
                                                    <?php
                                                  }  
                                                }else{
                                                    ?>
                                                  <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_declaracion_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Declaracion Jurada ID <?php echo $postulante['id_postulacion'];?>"><i class="far fa-file-pdf"></i></a>  
                                                  <?php
                                                  }
                                                
                                                  ?>
                                                  <?php if($postulante['declaracion_firmado']=='1'){ ?>
                                                      <img src="img/check.gif" border="0" title="pendiente">
                                                      <span class="d-none">_dj</span>
                                                  <?php }?>
                                                </td>
                                                <td nowrap>
                                                
                                                  <?php
                                                if(!empty($arr_firma_certinet[$postulante['id_postulacion']])){
                                                  if($arr[0]['documento']=='declaracion' || $arr[1]['documento']=='declaracion'){
                                                    ?>
                                                    
                                                    <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/get_document.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>&documento=contrato" target="_blank" rel="noopener noreferrer"><i class="far fa-file-pdf"></i></a>
                                                    
                                                    <?php
                                                  }
                                                }else{
                                                    ?>
                                                    <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_contrato_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Contrato Servicio ID <?php echo $postulante['id_postulacion'];?>"><i class="far fa-file-pdf"></i></a>  
                                                    <?php 
                                                  }
                                                 ?>
                                                  
                                                    <?php if($postulante['contrato_ps_firmado']=='1'){ ?>
                                                      <img src="img/check.gif" border="0" title="pendiente">
                                                      <span class="d-none">_cs</span>
                                                    <?php }?>
                                                </td>
                                                <td align="center">
                                                  <?php
                                                    if($postulante['estado']=='3030' || $postulante['estado']=='3131'){
                                                      echo '<img src="img/pendiente.jpg" border="0" title="pendiente">';
                                                      echo '<span class="d-none">_cierre</span>';
                                                      $pendiente++;
                                                    }  
                                                  ?>
                                                  
                                                </td>
                                                <td align="center"><?php echo '';?>
                                                  <a href="documentar/index.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Documentar ID <?php echo $postulante['id_postulacion'];?>" target="_blank">
                                                  <i class="fas fa-file-invoice-dollar"></i>
                                                  </a>
                                                  
                                                </td>
                                                <td align="center">
                                                  <div id="estado_envio_UA_<?php echo $postulante['id_postulacion']; ?>">
                                                  <?php 
                                                    /* ENVIO UA */
                                                    //echo $postulante['ee']; 
                                                    if(($postulante['envio_UA_fecha']=='' || $postulante['envio_UA_estado']=='NULL') && ($postulante['estado'] =='3131' || $postulante['estado']=='3030')){?>
                                                    
                                                    <img src="img/btn_fac.png?<?php echo $postulante['id_postulacion']; ?>" border="0" data-bs-toggle="xtooltip" data-bs-placement="top" title="Registrar envio a UA" class="_cambiar_estado_facturacion" data="<?php echo $postulante['id_postulacion']; ?>;estado_envio_UA;Enviada;<?php echo $usuario;?>">
                                                  <?php
                                                    }elseif($postulante['envio_UA_estado']=='Enviada'){
                                                      if($postulante['recibido_UA_fecha']==''){
                                                  ?>
                                                          <img src="img/vobo.png?<?php echo $postulante['id_postulacion']; ?>" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['envio_UA_obs'];?>" class="_cambiar_estado_facturacion_deshacer" data="<?php echo $postulante['ID_POSTULACION']; ?>;estado_envio_UA;NULL;<?php echo $usuario;?>">
                                                  <?php
                                                      }else{
                                                    ?>
                                                          <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['envio_UA_obs'];?>">
                                                  <?php						
                                                      }
                                                    }elseif($postulante['envio_UA_estado']=='Rechazada'){
                                                    ?>
                                                      <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['envio_UA_obs'];?>">
                                                    <?php				
                                                    }else{
                                                    ?>	
                                                         
                                                    <?php
                                                    }
                                                    ?>
                                                      </div>
                                                </td>
                                                <td align="center">
                                                  <div id="estado_recibido_UA_<?php echo $postulante['ID_POSTULACION']; ?>">
                                                  <?php 
                                                  /* RECIBIDO UA */
                                                  if($postulante['recibido_UA_fecha']<>''){
                                                     if($postulante['recibido_UA_estado']=='Recibida'){?>
                                                       <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['recibido_UA_obs'];?>">
                                                  <?php 
                                                    }
                                                    if($postulante['recibido_UA_estado']=='Rechazada'){
                                                  ?>
                                                       <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['recibido_UA_obs'];?>"></a>
                                                  <?php
                                                    }
                                                  }
                                                    ?>
                                                  </div>
                                                </td>
                                                <td align="center">
                                                  <div id="aceptado_UA_<?php echo $postulante['id_postulacion']; ?>">
                                                    <?php 
                                                  /* ACEPTADO UA */
                                                  if($postulante['aceptado_UA_fecha']<>''){
                                                    if($postulante['aceptado_UA_estado']=='Recibida'){?>
                                                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['aceptado_UA_obs'];?>">
                                                <?php 
                                                    }elseif($postulante['aceptado_UA_estado']=='Rechazada'){
                                                  ?>
                                                    <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['aceptado_UA_obs'];?>">
                                                <?php
                                                    }
                                                  }
                                                  ?>
                                                  </div>
                                                </td>
                                                <td align="center">
                                                  <div id="estado_recibido_UA_<?php echo $postulante['ID_POSTULACION']; ?>">
                                                        <?php 
                                                    /* FACTURADO UA */
                                                    if($postulante['facturado_UA_fecha']<>''){?>
                                                       <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['facturado_UA_estado'].' '.$postulante['facturado_UA_obs'];?>">
                                                  <?php
                                                    }
                                                    ?>
                                                  </div>                                                  
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p>Pendientes de cierre/Matriculados: <?php echo $pendiente;?></p>
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/listado_aceptados_doc.php?usr_ad=<?php echo $usuario; ?>&cod_diploma=<?php echo $cod_diploma;?>" target="_blank">Exportar matriculados</a></p>
                                
                            </div>
                        </div>
                    </div>


<?php
include_once('include/footer.php');
?> 

<script>
$( document ).ready(function() {
  var table = $('table.display').DataTable();

<?php
  if($id_postulacion<>''){
    echo 'table.search('.$id_postulacion.').draw();';
  }
  ?> 





  
    $('#dataTable tbody').on('click', '._cambiar_estado_facturacion', function () {
      
      var data = this.src.split("?")
      var id=data[1];
        
      if(confirm('Esta seguro de cambiar el estado \na enviado a Facturacion del ID: '+id +' ?')){

        $.post( "estado_facturacion_in.php", { 
          id_postulacion: id })
          .done(function( data ) {
            var ctrl="#estado_envio_UA_"+id;
          $(ctrl).empty().html(data); 
        });
      }
    } );
    

    $('#dataTable tbody').on('dblclick', '._cambiar_estado_facturacion_deshacer', function () {
      
      var data = this.src.split("?")
      var id=data[1];
      

      $.post( "estado_facturacion_no_in.php", { 
        id_postulacion: id })
        .done(function( data ) {
          var ctrl="#estado_envio_UA_"+id;
         $(ctrl).empty().html(data);
         
         //onmouseover="Tip(\'Enviada '.date('%d-%m-%Y %H:%i:%s').'\')" onmouseout="UnTip()"
      });
        

    } );
});
</script>