<?php
session_start();

$usuario=$_SESSION['usuario'];

include_once('include/header.php');
//include_once('../data/data_periodos.php');



include_once('../data/data_programas_hist.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Bases de Datos Historica <?php echo $periodo;?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="tipo_programas.php">Bases de Datos Historica</a></li>
                            <li class="breadcrumb-item active"><?php echo $periodo;?></li>
                        </ol>
                        <form action="#" name="frm_periodo" id="frm_periodo" method="POST">
                            <input type="hidden" name="tipo" value="<?php echo $tipo_programa;?>">
                            <input type="hidden" name="modalidad" value="<?php echo $modalidad_programa;?>">

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
                                               
                                                <th>ACEP</th>
                                                <th>MAT</th>
                                                <th>RECH</th>
                                               
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
                                               
                                                <th>ACEP</th>
                                                <th>MAT</th>
                                                <th>RECH</th>
                                               
                                                <th>ELIM</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            foreach($arr_programas as $programa){
                                            ?>
                                            <tr>
                                                <td><?php echo $programa['id_programa'];?></td>
                                                <td nowrap><?php echo $programa['Cod_interno'];?></td>
                                                <td nowrap><?php echo $programa['cod_diploma'];?></td>
                                                <td ><?php echo $programa['programa'];?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_inicio'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_inicio']));?></td>
                                                <td nowrap><span class="text-hide "><?php echo $programa['fecha_termino'];?></span> <?php echo date("d/m/Y", strtotime($programa['fecha_termino']));?></td>
                                                <td>
                                                <?php
                                                if($programa['pre_post']>0){
                                                ?>  
                                                <a href="bbdd/pre_postulaciones.php?cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank"><?php echo $programa['pre_post'];?></a>
                                              <?php
                                              }
                                              ?>
                                              </td>
                                                
                                                <td>
                                                <?php if($programa['aceptadas']>0){
                                                  ?>
                                                <a href="bbdd/aceptados_no_matriculados.php?cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank"><?php echo $programa['aceptadas'];?></a>
                                                <?php
                                                }
                                                ?>
                                                  
                                                </td>
                                                <td>
                                                <?php if($programa['mat_pend']>0){
                                                  ?>  
                                                <a href="bbdd/matriculados.php?cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank"><?php echo $programa['mat_pend'];?></a>
                                                <?php
                                                }
                                                ?>
                                                </td>
                                                
                                                <td>
                                                <?php if($programa['rechazadas']>0){
                                                  ?>  <a href="bbdd/rechazadas.php?cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank"><?php echo $programa['rechazadas'];?></a>
                                                  <?php
                                                }
                                                ?>
                                                </td>

                                                <td>
                                                <?php if($programa['eliminadas']>0){
                                                  ?>
                                                  <a href="bbdd/eliminadas.php?cod_diploma=<?php echo $programa['cod_diploma'];?>" target="_blank"><?php echo $programa['eliminadas'];?></a>
                                                  <?php
                                                }
                                                ?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p></p>
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
                { "type": "html-num" }
            
        ]    
   
     
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