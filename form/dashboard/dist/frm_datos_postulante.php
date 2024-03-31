<?php
session_start();
include_once('../data/data_ficha_postulante.php');

?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ficha Postulante</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    </head>
    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>

                <div class="container">
                  <h2>Ficha Postulante</h2>

                  <div class="clearfix">
                  





<form action="">

<div class="row g-3 align-items-center">
  <div class="col-auto">
    <label for="inputPassword6" class="col-form-label">Rut</label>
  </div>
  <div class="col-auto">
    <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" value="<?php echo $rut;?>" length="15">
  </div>
  <div class="col-auto">
    <span id="passwordHelpInline" class="form-text">
      ingresar sin puntos y con guion.
    </span>
  </div>
</div>


</form>
</div>
  Nombres: <?php echo $nombre;?><br>
  Apellidos: <?php echo $apellido_pat.' '.$apellido_mat;?><br>
  Genero: <?php echo $genero;?><br>
  Fecha Nacimiento: <?php echo date("d-m-Y", strtotime($fecha_nac));?><br>
  Email: <?php echo $email;?><br>
  Telefono: <?php echo $celular;?><br>
  Direccion: <?php echo $direccion;?><br>
  Ex alumno: <?php if($ex_alumno==1){echo 'Si';}else{echo 'No';} ?><br>
  </p>
  <button class="btn btn-primary btn-sm" id="btn_guardar">Guardar</button> <button class="btn btn-primary btn-sm" id="btn_cancelar">cancelar</button>
  </div>
  </fieldset>

  

</div>




                </main>
            </div>
            <div id="layoutError_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">TI Unegocios &copy; Santiago - Chile 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

        <script>
$(document).ready(function() {
    
    $("#div_frm_datos_personales").hide();



    $(".eliminar_adj").click(function() {
        var archivo_adj = $(this).attr('data');
        var ctr_li = '#'+$(this).attr('li');

        var id_postulacion = $("#id_postulacion").val();
        if(confirm('Esta seguro de querer eliminar el archivo')){
            $.post( "eliminar_adj.php", 
                { 
                    archivo: archivo_adj ,
                    id_form: id_postulacion
                })
            .done(function( data ) {
                console.log( "Data eliminado: " + data );
                console.log( "ctr_li: " + ctr_li );

                $(ctr_li).hide(300);
            });
        }      
    });  

    $("#btn_editar").click(function() {
        console.log('clic btn_editar');

        $("#datos_personales").hide(300);
        $("#div_frm_datos_personales").show(300);

    });  
    $("#btn_cancelar").click(function() {
        console.log('clic btn_editar');

        $("#datos_personales").show(300);
        $("#div_frm_datos_personales").hide(300);

    });
});
        </script>
        
    </body>
</html>
