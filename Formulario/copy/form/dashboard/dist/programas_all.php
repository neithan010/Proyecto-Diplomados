<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_all.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Todos los Programas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Tipo de Programas</a></li>
                            <li class="breadcrumb-item active">Todos los programas</li>
                        </ol>

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
                                            <table class="table">
                                            <tr>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['id_programa'];?></a></td>
                                                <td nowrap><?php echo $programa['Cod_interno'];?></td>
                                                <td nowrap><?php echo $programa['cod_diploma'];?></td>
                                                <td ><?php echo $programa['programa'];?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_inicio'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_inicio']));?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_termino'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_termino']));?></td>
                                                <!--
                                                <td><a href="postulantes_pre_post.php?id=<?php echo $programa['id_programa'];?>" target="_self"><?php echo $programa['pre_post'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['nuevas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['en_eva'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['aceptadas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['mat_pend'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['rechazadas'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['pendientes'];?></a></td>
                                                <td><a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>" target="_self"><?php echo $programa['eliminadas'];?></a></td>
                                            -->
                                            </tr>
                                            </table>
                                           
                                            <?php

                                            
?>
<div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small display" id="" width="100%" cellspacing="0">
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
                                                <th>Envio UE</th>
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
                                                <th>Envio UE</th>
                                                <th>Recibido UA</th>
                                                <th>Aceptado UA</th>
                                                <th>Facturado UA</th>
                                                
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
                                                <td ><img src="<?php echo $postulante['foto'];?>" height="24" alt="" ></td>
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

                                                <td align="center">
                                                  <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_declaracion_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Declaracion Jurada ID <?php echo $postulante['id_postulacion'];?>"><i class="far fa-file-pdf"></i></a>  
                                                  <?php if($postulante['declaracion_firmado']=='1'){ ?>
                                                      <img src="img/check.gif" border="0" title="pendiente">
                                                      <span class="d-none">_dj</span>
                                                  <?php }?>
                                                </td>
                                                <td align="center">
                                                    <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_contrato_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Contrato Servicio ID <?php echo $postulante['id_postulacion'];?>"><i class="far fa-file-pdf"></i></a>  
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
                                                    // ENVIO UA 
                                                    //echo $postulante['ee']; 
                                                    if(($postulante['envio_UA_fecha']=='' || $postulante['envio_UA_estado']=='NULL') && ($postulante['ee'] =='3131' || $postulante['ee']=='3030')){?>
                                                            
                                                      <img src="img/btn_fac.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar envio a UA" class="_cambiar_estado_facturacion" data-fnc="<?php echo $postulante['id_postulacion']; ?>;estado_envio_UA;Enviada;<?php echo $usuario;?>">
                                                          
                                                  <?php
                                                    }elseif($postulante['envio_UA_estado']=='Enviada'){
                                                      if($postulante['recibido_UA_fecha']==''){
                                                  ?>
                                                          <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $postulante['envio_UA_obs'];?>" class="_cambiar_estado_facturacion" data-fnc="<?php echo $postulante['ID_POSTULACION']; ?>;estado_envio_UA;NULL;<?php echo $usuario;?>">
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
                                                  // RECIBIDO UA 
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
                                                  // ACEPTADO UA 
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
                                                    // FACTURADO UA 
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
                                <p><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/listado_aceptados_doc.php?usr_ad=<?php echo $usuario; ?>&cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank">Exportar matriculados</a></p>
                                
                            </div>
                        
                        <?php


                                            }
                                            ?>

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
 
    var table = $('table.display').DataTable({
            language: {
            url: '../../js/es-mx.json'
            },
        });



    $('#filtrar').on( 'keyup', function () {
        table.search( this.value ).draw();
    });

    $("#periodo" ).change(function() {
       
       console.log( "Change periodo! " + $(this).val());
         
       $("#frm_periodo").submit();
                
     });
/*
    $( "#addEscala" ).click(function() {
       
       //console.log( "nueva_dimension! " + $("#nueva_dimension").val());
       
   
       $.post( "escala_nueva_guardar.php")
         .done(function( data ) {
         alert( "Escala creada");

         if(data!=0){
           
            location.reload(); // kuek!!
         }else{
           alert( "Ocurrio un error " + data );
         }
       });
   

       
   });
    
 

   
   $( ".btn_del" ).click(function() {
       
       console.log( "delete Item! " + $(this).attr('id'));
       var data= $(this).attr('id').replace("btn_delItem", "").split("_");
       
       console.log( "data: " + data[0]+' : '+data[1]);

       var id_escala=data[0];
       var num_item=data[1];

       if(confirm('Esta seguro de eliminar el Item?')){
        $.post( "escala_item_elimina.php", { id_escala: id_escala, num_item: num_item })
          .done(function( data ) {
          alert( "Item eliminado");
 
          if(data!=0){
               //$(this).parent().parent().remove(); // <-- funciona
               location.reload(); // kuek!!
          }else{
            alert( "Ocurrio un error " + data );
          }
        });
       }
        
    }); 
*/   
});
</script>