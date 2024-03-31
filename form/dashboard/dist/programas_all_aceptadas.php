<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario_intranet'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_all.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

$id_postulacion = isset($_REQUEST['id'])?$_REQUEST['id']:'';
if($id_postulacion<>''){
  
  $sql_id_programa_buscar="SELECT 
  d.ID_DIPLOMA
  FROM unegocios_nuevo.postulacion p
  INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
  WHERE 
  p.ID_POSTULACION=$id_postulacion";

//echo '<pre>'.$sql_id_programa_buscar.'</pre>';

$stmt_id_programa_buscar = $con->prepare($sql_id_programa_buscar);
$stmt_id_programa_buscar->setFetchMode(PDO::FETCH_ASSOC);
$stmt_id_programa_buscar->execute();

$total_id_programa_buscar = $stmt_id_programa_buscar->rowCount();


if ($row = $stmt_id_programa_buscar->fetch()){
  $id_diploma = $row['ID_DIPLOMA'];
}
}
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
        <!--
        Filtrar en todas: <input type="text" name="" id="filtrar">
          -->


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
                                              Calendario: <a href="../../../cdg/programas/Calendario/calendario_clases.php?id_diploma=<?php echo $programa['id_programa'];?>" target="_blank" style="text-decoration:none"><i class="bi bi-calendar3"></i></a>
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
                    <td>
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
                    
                  <!--  <img src="<?php echo $postulante['foto'];?>" height="24" alt=""> -->
                  </td>
                    <td nowrap><span class="text-hide "><?php echo $postulante['fecha_aceptado'];?></span>
                      <?php echo date("d/m/Y", strtotime($postulante['fecha_aceptado']));?></td>
                    <td nowrap><?php echo $postulante['nombres'];?></td>
                    <td><?php echo $postulante['apellido_pat'];?></td>
                    <td><?php echo $postulante['aprllido_mat'];?></td>
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
                      <a href="ficha_postulante.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>"
                        target="_blank"><i class="fas fa-file-alt"></i></a>
                    </td>

                    <td><?php
                                              if($postulante['cv']<>''){
                                                $url="https://unegocios.uchile.cl/CV/".$postulante['cv'];
                                                //if (false!==file($url)){
                                                  ?>
                      <a href="<?php echo $url;?>" target="_blank" rel="noopener noreferrer"><i
                          class="bi bi-file-person"></i></a>
                      <?php
                                                //}
                                              }
                                                ?>

                    </td>

                    <td align="center">
                      <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_declaracion_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>"
                        target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Declaracion Jurada ID <?php echo $postulante['id_postulacion'];?>"><i
                          class="far fa-file-pdf"></i></a>
                      <?php if($postulante['declaracion_firmado']=='1'){ ?>
                      <img src="img/check.gif" border="0" title="pendiente">
                      <span class="d-none">_dj</span>
                      <?php }
                                                  if($postulante['declaracion_firmado']=='3'){
                                                    ?>
                      <img src="img/exclamacion.png" border="0" title="DECLINED">
                      <span class="d-none">_dj</span>
                      <?php }
                                                    
                                                    ?>
                    </td>
                    <td align="center">
                      <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_contrato_firmada_x_id.php?id=<?php echo $postulante['id_postulacion'];?>"
                        target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Contrato Servicio ID <?php echo $postulante['id_postulacion'];?>"><i
                          class="far fa-file-pdf"></i></a>
                      <?php if($postulante['contrato_ps_firmado']=='1'){ ?>
                      <img src="img/check.gif" border="0" title="pendiente">
                      <span class="d-none">_cs</span>
                      <?php }
                                                    if($postulante['contrato_ps_firmado']=='3'){
                                                      ?>
                      <img src="img/exclamacion.png" border="0" title="DECLINED">
                      <span class="d-none">_cs</span>
                      <?php }
                                                      
                                                      ?>
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
                      <a href="documentar/index.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Documentar ID <?php echo $postulante['id_postulacion'];?>" target="_blank">
                        <i class="fas fa-file-invoice-dollar"></i>
                      </a>

                    </td>
                    <td align="center">
                      <div id="estado_envio_UA_<?php echo $postulante['id_postulacion']; ?>">
                        <?php 
                                                    // ENVIO UA 
                                                    //echo $postulante['ee']; 
                                                    if(($postulante['envio_UA_fecha']=='' || $postulante['envio_UA_estado']=='NULL') && ($postulante['ee'] =='3131' || $postulante['ee']=='3030')){?>

                        <img src="img/btn_fac.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="Registrar envio a UA" class="_cambiar_estado_facturacion"
                          data-fnc="<?php echo $postulante['id_postulacion']; ?>;estado_envio_UA;Enviada;<?php echo $usuario;?>">

                        <?php
                                                    }elseif($postulante['envio_UA_estado']=='Enviada'){
                                                      if($postulante['recibido_UA_fecha']==''){
                                                  ?>
                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['envio_UA_obs'];?>" class="_cambiar_estado_facturacion"
                          data-fnc="<?php echo $postulante['ID_POSTULACION']; ?>;estado_envio_UA;NULL;<?php echo $usuario;?>">
                        <?php
                                                      }else{
                                                    ?>
                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['envio_UA_obs'];?>">
                        <?php						
                                                      }
                                                    }elseif($postulante['envio_UA_estado']=='Rechazada'){
                                                    ?>
                        <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['envio_UA_obs'];?>">
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
                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['recibido_UA_obs'];?>">
                        <?php 
                                                    }
                                                    if($postulante['recibido_UA_estado']=='Rechazada'){
                                                  ?>
                        <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['recibido_UA_obs'];?>"></a>
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
                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['aceptado_UA_obs'];?>">
                        <?php 
                                                    }elseif($postulante['aceptado_UA_estado']=='Rechazada'){
                                                  ?>
                        <img src="img/exclamacion.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['aceptado_UA_obs'];?>">
                        <?php
                                                    }
                                                  }
                                                  ?>
                      </div>
                    </td>
                    <td align="center">
                      <div id="estado_recibido_UA_<?php echo $postulante['id_postulacion']; ?>">
                        <?php 
                                                    // FACTURADO UA 
                                                    if($postulante['facturado_UA_fecha']<>''){?>
                        <img src="img/vobo.png" border="0" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="<?php echo $postulante['facturado_UA_estado'].' '.$postulante['facturado_UA_obs'];?>">
                        <?php
                                                    }
                                                    ?>
                      </div>
                    </td>
                    <td id="td_<?php echo $postulante['id_postulacion']; ?>">
                    <?php echo $postulante['obs']; ?> <button type="button" class="btn btn-primary btn-sm" 
                      data-bs-toggle="modal" 
                      data-bs-target="#exampleModal" 
                      data-bs-txt_obs="<?php echo $postulante['obs']; ?>" 
                      data-bs-whatever="<?php echo $postulante['id_postulacion']; ?>"><i class="far fa-clipboard"></i></button>
                    </td>
                  </tr>
                  <?php
                                            }
                                            
                                            ?>
                </tbody>
              </table>
            </div>
            <p>Pendientes de cierre/Matriculados: <?php echo $pendiente;?></p>
            <p><a
                href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/listado_aceptados_doc.php?usr_ad=<?php echo $usuario; ?>&cod_diploma=<?php echo $programa['cod_diploma'];?>"
                target="_blank">Exportar matriculados</a></p>
                <p><a
                href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/aceptados_no_matriculados_x_programa.php?usr_ad=<?php echo $usuario; ?>&cod_diploma=<?php echo $programa['cod_diploma'];?>"
                target="_blank">Aceptados no matriculados</a></p>
          </div>
        </div>
        <?php


                                            }
                                            ?>

      </div>
      <p><a
          href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/pre_portulaciones_excel.php?usr=<?php echo $usuario; ?>"
          target="_blank" rel="noopener noreferrer">Exportar datos pre-postulaciones</a></p>
      <p><a
          href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/aceptados_no_matriculados.php?usr=<?php echo $usuario; ?>"
          target="_blank">Aceptados no Matriculados</a></p>
      <p><a
          href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/enviados_UA.php?usr=<?php echo $usuario; ?>"
          target="_blank">Enviados a UA</a></p>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Observació ID: </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
            <input type="hidden" name="id_post" id="id_post" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_guardar_obs">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php
include_once('include/footer.php');
?>
<script>
  $(document).ready(function () {

    var table = $('table.display').DataTable({
      language: {
        url: '../../js/es-mx.json'
      },
      aLengthMenu: [ [10, 25, 50, -1], 
                  [10, 25, 50, "All"] ], 
      iDisplayLength: -1,

    });



    $('#filtrar').on('keyup', function () {
      table.search(this.value).draw();
    });

    $("#periodo").change(function () {

      console.log("Change periodo! " + $(this).val());

      $("#frm_periodo").submit();

    });

<?php
if($id_postulacion<>''){
?>
          $(".div_programa_detalle").hide(300);

          var ctr_div = "#<?php echo $id_diploma;?>";
          $(ctr_div).show(100);
          console.log('Ejecutado!!')

<?php
}
?>



  
//$('#dataTable tbody').on('click', '._cambiar_estado_facturacion', function () {
$('.table tbody').on('click', '._cambiar_estado_facturacion', function () {
  //console.log('_cambiar_estado_facturacion '+ $(this).attr('data-fnc'));
      
      //var data = this.src.split("?")
      //var id=data[1];
      var data = $(this).attr('data-fnc').split(";")
      var id=data[0];

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
      //console.log('_cambiar_estado_facturacion_deshacer');
      //var data = this.src.split("?")
      //var id=data[1];
      var data = $(this).attr('data-fnc').split(";")
      var id=data[0];

      $.post( "estado_facturacion_no_in.php", { 
        id_postulacion: id })
        .done(function( data ) {
          var ctrl="#estado_envio_UA_"+id;
         $(ctrl).empty().html(data);
         
         //onmouseover="Tip(\'Enviada '.date('%d-%m-%Y %H:%i:%s').'\')" onmouseout="UnTip()"
      });
        

    } );
    


        
      
        
 

       
       $( "#btn_guardar_obs" ).click(function() {
        //$( "#btn_guardar_obs" ).on( "click", function() {

          console.log("add_obs! " + $("#id_post").val());
          
          var id = $("#id_post").val();
          var ctrl_td = "#td_"+id;
          
          $.post( "add_obs.php", {  
              obs: $("#message-text").val(), 
              usuario: '<?php echo $usuario; ?>',
              idpostulacion: id, })
            .done(function( data ) {
              
                $(ctrl_td).html(data);
                $('#exampleModal').modal('hide')
            });
           
            
        }); 
  




  });
</script>

<script>
  var exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  var txt_obs = button.getAttribute('data-bs-txt_obs')

  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal.querySelector('.modal-title')
  var modalBodytextarea = exampleModal.querySelector('.modal-body textarea')
  var modalBodyid_post = exampleModal.querySelector('.modal-body input')

  

  modalTitle.textContent = 'Observació ID: ' + recipient;
  modalBodytextarea.value = txt_obs;
  modalBodyid_post.value = recipient;
})
</script>