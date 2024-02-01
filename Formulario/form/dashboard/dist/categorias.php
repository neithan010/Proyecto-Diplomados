<?php
session_start();

include_once('include/header.php');
include_once('../data/data_categorias.php');

//echo ':: <pre>'.print_r($arr_escalas, true).'</pre>';

?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Categorias</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Categorias</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                DataTable Categorias
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Categoria</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Categoria</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $i=0;
                                            foreach($arr_categorias as $categoria){
                                            ?>
                                            <tr>
                                                <td>
                                                
                                                    <a href="escala_detalle.php?id=<?php echo $categoria['id'];?>" target="_self"><?php echo $categoria['id'];?></a>
                                                
                                                </td>
                                                <td>
                                                    


            <div class="form-group" id="divtextItem<?php echo $i;?>">
              <span id="textItem<?php echo $i;?>"><?php echo $categoria['categoria'];?></span><br>
              <button id="btn_editItem<?php echo $i;?>" class="btn_edit"><i class="fas fa-edit"></i></button>
              <button id="btn_delItem<?php echo $categoria['categoria'];?>" class="btn_del"><i class="fas fa-trash-alt"></i></button>
            </div>
            <div class="form-group divtextareaItem" id="divtextareaItem<?php echo $i;?>">
              <textarea class="form-control" id="textareaItem<?php echo $i;?>" rows="2"><?php echo $categoria['categoria'];?></textarea>
              <input type="hidden" id="data_edit<?php echo $i;?>" value="<?php echo $categoria['id'];?>"/>
              <button class="btn_saveItem" id="btn_saveItem<?php echo $categoria['id'];?>"><i class="fas fa-save"></i></button> <button class="btn_cancel" id="btn_cancelItem<?php echo $i;?>"><i class="fas fa-redo"></i></button>
            </div> 

                                                </td>
                                                <td><!--
                                                    <button class="btn btn-primary">Editar</button> <button class="btn btn-danger">Eliminar</button>
                                                    -->
                                                    
                                                </td>
                                                
                                            </tr>
                                            <?php
                                            $i++;
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

  $( ".divtextareaItem" ).hide();
  
  
    //console.log( "ready!" );
    $( ".btn_edit" ).click(function() {
        
        var ctrl_div = '#divtextarea'+$(this).attr("id").replace("btn_edit", "");
        var ctrl_text = '#divtext'+$(this).attr("id").replace("btn_edit", "");

        //console.log( "ready! ctrl_div: "+ctrl_div+' ctrl_text: '+ctrl_text );
        $( ctrl_div ).toggle( "slow", function() {
          // Animation complete.
        });
        $( ctrl_text ).toggle( "slow", function() {
          // Animation complete.
        });
        
    });

    $( ".btn_cancel" ).click(function() {
        var ctrl_div = '#divtextarea'+$(this).attr("id").replace("btn_cancel", "");
        var ctrl_text = '#divtext'+$(this).attr("id").replace("btn_cancel", "");

        //console.log( "ready! ctrl_div: "+ctrl_div+' ctrl_text: '+ctrl_text );
        $( ctrl_div ).toggle( "slow", function() {
          // Animation complete.
        });
        $( ctrl_text ).toggle( "slow", function() {
          // Animation complete.
        });
        
    });

    $( ".btn_saveItem" ).click(function() {
       
        console.log( "btn_saveDefinicion! " + $(this).attr("id"));
        
        var id=$(this).attr("id").replace("btn_saveItem", "").toLowerCase();

        var ctrl_div = '#divtextarea'+$(this).attr("id").replace("btn_saveItem", "");
        var ctrl_text = '#divtext'+$(this).attr("id").replace("btn_saveItem", "");
        var text = '#text'+$(this).attr("id").replace("btn_saveItem", "");

        var ctrl_txt = '#textarea'+$(this).attr("id").replace("btn_saveItem", "");
        var txt=$(ctrl_txt).val();

        console.log(id+' '+txt);
/*
        $.post( "categoria_guardar.php", { tbl: tbl, id: id, txt: txt })
          .done(function( data ) {
          alert( "Información guardada");

          if(data==1){
            $( ctrl_div ).toggle( "slow", function() {
              // Animation complete.
            });
            $( ctrl_text ).toggle( "slow", function() {
              $( text ).html(txt);
            });
          }else{
            alert( "Ocurrio un error " + data );
          }
        });
*/

        
    });    
});
</script> 
