<?php

session_start();

include('include/header.php');
include('../data/data_tipo_programa.php');

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Postulaciones</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tipos de Programas</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Tipos 
                            </div>
                            <div class="card-body">
                                <div class="table">
                                <div class="row">
                                    <?php
                                    foreach($arr_tipo_programas as $tipo_programas){
                                    ?>
                                    <div class="col-sm-5">
                                        <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $tipo_programas['tipo_programa'] ?></h5>
                                            <p class="card-text"><?php // echo $tipo_programas['modalidad_programa'] ?></p>
                                            <a href="programas.php?tipo=<?php echo $tipo_programas['tipo_programa'] ?>&modalidad=<?php // echo $tipo_programas['modalidad_programa'] ?>" class="btn btn-primary">IR</a>
                                        </div>
                                        </div>
                                    </div>
                                    <?php

                                    }
                                    ?>

                                    <div class="col-sm-5">
                                        <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Todos los Programas</h5>
                                            <p class="card-text">Todos los tipos</p>
                                            <a href="programas_all.php" class="btn btn-primary">IR</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/resumen_control_decreto.php" target="_blank">Resumen control Decreto <i class="fas fa-file-alt"></i></a>
                    </div>


<?php
include_once('include/footer.php');
?> 
<script>
$( document ).ready(function() {


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
});
</script>