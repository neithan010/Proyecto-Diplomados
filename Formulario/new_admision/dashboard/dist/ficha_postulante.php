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
                  


<fieldset class="border-top border-bottom p-3">
<p class="lh-lg">
<!-- <img src="<?php echo $url_img; ?>" class="rounded float-end mx-2"  width="150px" height="200px" alt="..." align="right">
-->

  ID: <?php echo $id_postulacion;?> <input type="hidden" name="id_postulacion" id="id_postulacion" value="<?php echo $id_postulacion;?>"><br>
  Fecha Postulacion: <?php echo date("d-m-Y H:i:s", strtotime($fecha_postulacion));?><br>
  Programa: <?php echo $programa;?><br>
  Ceco: <?php echo $ceco;?><br>
  Cod Diploma: <?php echo $cod_diploma;?><br>
  Fecha Inicio: <?php echo date("d-m-Y", strtotime($fecha_inicio));?><br>
  Fecha Termino: <?php echo date("d-m-Y", strtotime($fecha_termino));?><br>
  Financiamiento: <?php echo $financiamiento;?><br>
  <div id="div_eliminar">
    <input type="hidden" name="ee" id="ee" value="<?php echo $ee;?>">
  <?php
  if($ee <> '3030' && $ee <> '3131'){
  ?>
<button class="btn btn-danger btn-sm" id="btn_in_motivo" >Eliminar: <?php echo $etapaestado;?></button>  
    <div class="" style="display:none;" id="div_motivo">
        <div class="dropdown p-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Seleccione motivo para eliminar:
        </button>
        <ul class="dropdown-menu">


            <li data="Por falta de tiempo" class="dropdown-item">Por falta de tiempo</li>
            <li data="Por razones de trabajo" class="dropdown-item">Por razones de trabajo</li>
            <li data="No contesto" class="dropdown-item">No contesto</li>
            <li data="Se matriculó en otro" class="dropdown-item">Se matriculó en otro</li>
            <li data="Motivos personales" class="dropdown-item">Motivos personales</li>
            <li data="Siguiente Semestre" class="dropdown-item">Siguiente Semestre</li>
            <li data="Rechazado" class="dropdown-item">Rechazado</li>
            <li data="Por razones económicas" class="dropdown-item">Por razones económicas</li>
            <li data="Otros" class="dropdown-item">Otros</li>
            
        </ul>
        <br>
        <div class="form-floating" >
            <textarea class="form-control" placeholder="Escriba el motivo" id="textarea_motivo_elimina" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Motivo</label>
        </div>
    </div>

<button class="btn btn-danger btn-sm" id="btn_eliminar" data-id_postulacion=<?php echo $id_postulacion;?> >Enviar</button>
</div>
  <?php
  }
  ?>
  </div>
  </p>
  </fieldset>

<fieldset class="border-bottom p-3">
<legend>Datos Postulante</legend> 
<img src="<?php echo $url_img; ?>" class="img-fluid rounded float-end" alt="..." width="150px">
<div id="datos_personales">
<p class="lh-lg">
  Rut: <?php echo $rut;?><br>
  Nombres: <?php echo $nombre;?><br>
  Apellidos: <?php echo $apellido_pat.' '.$apellido_mat;?><br>
  Genero: <?php echo $genero;?><br>
  Fecha Nacimiento: <?php echo date("d-m-Y", strtotime($fecha_nac));?><br>
  Email: <?php echo $email;?><br>
  Telefono: <?php echo $celular;?><br>
  Direccion: <?php echo $direccion;?><br>
  Ex alumno: <?php if($ex_alumno==1){echo 'Si';}else{echo 'No';} ?><br>
  </p>
  <button class="btn btn-primary btn-sm" id="btn_editar">Editar</button>
  </div>

  <div id="div_frm_datos_personales">
<p class="lh-lg">
<div class="clearfix">
<form action="">

Rut: <input type="text" id="rut" name="rut" class="form-control col-2" value="<?php echo $rut;?>" maxlength="15" size="20"><br>
Nombres: <input type="text" id="nombre" name="nombre" class="form-control col-4" value="<?php echo $nombre;?>" maxlength="50" size="50"><br>
Apellido Paterno: <input type="text" id="apellido_pat" name="apellido_pat" class="form-control col-4" value="<?php echo $apellido_pat;?>" maxlength="50" size="50"><br>
Apellido Materno: <input type="text" id="apellido_mat" name="apellido_mat" class="form-control col-4" value="<?php echo $apellido_mat;?>" maxlength="50" size="50"><br>
<!--
Genero: <input class="form-check-input col-2" type="radio" name="r_genero" id="r_femenino" <?php if($genero=='femenino'){ echo 'checked';} ?> value="femenino"> Femenino <input class="form-check-input" type="radio" name="r_genero" id="r_masculino" <?php if($genero=='masculino'){ echo 'checked';} ?> value="masculino"> Masculino <input class="form-check-input" type="radio" name="r_genero" id="r_otro" <?php if($genero=='otro'){ echo 'checked';} ?> value="otro"> Otro<br>
-->
<input type="hidden" name="genero" id="genero" value="<?php echo $genero;?>">
<input type="hidden" name="ex_alumno" id="ex_alumno" value="<?php echo $ex_alumno;?>">
Fecha Nacimiento: <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control col-2" value="<?php echo date("Y-m-d", strtotime($fecha_nac));?>" ><br>
  Email: <input type="email" id="email" name="email" class="form-control col-4" value="<?php echo $email;?>" maxlength="200" size="150"><br>
  Telefono: <input type="text" id="celular" name="celular" class="form-control col-2" value="<?php echo $celular;?>" maxlength="50" size="50"><br>
  Direccion calle: <input type="text" id="calle" name="calle" class="form-control col-4" value="<?php echo $calle;?>" maxlength="200" size="50"><br>
  Numero: <input type="text" id="numero" name="numero" class="form-control col-2" value="<?php echo $numero;?>" maxlength="10" size="15"><br>
  Depto/of: <input type="text" id="depto_of" name="depto_of" class="form-control col-2" value="<?php echo $depto_of_par;?>" maxlength="10" size="15"><br>
  comuna: <select class="form-select col-4" id="comuna" name="comuna">
        <?php
        foreach($arr_comunas as $cmb_cod_comuna => $comuna){
        ?>
            <option value="<?php echo $cmb_cod_comuna;?>" <?php if($cmb_cod_comuna==$cod_comuna){ echo 'selected';} ?>><?php echo $comuna; ?></option>
        <?php
        }
        ?>
        </select>
        <br>
</form>
</div>
  </p>
  <button class="btn btn-primary btn-sm" id="btn_guardar">Guardar</button> <button class="btn btn-primary btn-sm" id="btn_cancelar">cancelar</button>
  </div>
  </fieldset>

  <fieldset class="border-bottom p-3"> 
  <legend>Estudios</legend> 
  <?php if($titulo<>''){ ?>
    <p class="lh-lg">
    Estudio: Universitario <br>
    Titulo: <?php echo $titulo;?><br>
    Universidad: <?php echo $UNIVERSIDAD;?><br>
    Estado Titulo: <?php echo $r_universitario;?><br>
    Año Titulación: <?php echo $titulado_uni;?><br>
    </p>
<?php } ?>
  <?php if($tecnico<>''){ ?>
    <p class="lh-lg">
    Estudio: Tecnico <br>
    Titulo: <?php echo $carrera_tecnica;?><br>
    Institución: <?php echo $institucion_tecnica;?><br>
    Estado Titulo: <?php echo $r_carrera_tec;?><br>
    Año Titulación: <?php echo $fecha_tec;?><br>
    </p>
<?php } ?>
<?php if($magister<>''){ ?>
    <p class="lh-lg">
    Estudio: Magister <br>
    Titulo: <?php echo $carrera_magister;?><br>
    Institución: <?php echo $universidad_mag;?><br>
    Estado Titulo: <?php echo $r_magister;?><br>
    Año Titulación: <?php echo $fecha_magister;?><br>
    </p>
<?php } ?>
<?php if($doctorado<>''){ ?>
    <p class="lh-lg">
    Estudio: Magister <br>
    Titulo: <?php echo $carrera_doctorado;?><br>
    Institución: <?php echo $universidad_doc;?><br>
    Estado Titulo: <?php echo $r_doctorado;?><br>
    Año Titulación: <?php echo $fecha_doc;?><br>
    </p>
<?php } ?>
<?php if($estudio_1<>''){ ?>
    <p class="lh-lg">
    Estudio: Otros <br>
    1: <?php echo $estudio_1;?><br>
<?php if($estudio_2<>''){ ?>    
    2: <?php echo $estudio_2;?><br>
<?php } ?>    
    </p>
<?php } ?>
</fieldset>

<fieldset class="border-bottom p-3">
<legend>Datos Laborales</legend> 
<p class="lh-lg">
Razon Social: <?php echo $RAZON_SOCIAL;?><br>
Cargo: <?php echo $CARGO;?><br>
Experiencia: <?php echo $experiencia;?><br>
Trabajando: <?php echo $empleado;?><br>
  Tiempo posicion actual: <?php echo $year_posicion;?><br>
  Personal a Cargo: <?php echo $personal_cargo;?><br>
  De las personas que usted lidera, ¿Tienen personas a cargo?: <?php echo $personas_a_cargo;?><br>
  Empleado Publico: <?php echo $empleado_publico;?><br>
  
  </p>
  </fieldset>
<?php if($actividad<>''){ ?>
  <fieldset class="border-bottom p-3">
<legend>Experiencia Laboral</legend> 
<p class="lh-lg">
Empresa: <?php echo $empresa;?><br>
Industria: <?php echo $industria;?><br>
Actividad: <?php echo $actividad;?><br>
Cargo: <?php echo $cargo;?><br>
Año: <?php echo $fecha_ini;?><br>
Año termino: <?php echo $fecha_fin;?><br>
  </p>
<?php if($empresa_2<>''){ ?>
    <p class="lh-lg">
Empresa Anterior: <?php echo $empresa_2;?><br>
Industria: <?php echo $industria_2;?><br>
Actividad: <?php echo $actividad_2;?><br>
Cargo: <?php echo $cargo_2;?><br>
Año: <?php echo $fecha_ini_2;?><br>
Año termino: <?php echo $fehca_fin_2;?><br>
  </p>
<?php } ?>  
  </fieldset>
  <?php
  }

if($motivacion_1<>''){ ?>
  <fieldset class="border-bottom p-3">

<p class="lh-lg">
Razon de postular y su importancia: <br>
  1: <?php echo $motivacion_1;?><br>
  2: <?php echo $motivacion_2;?><br>
  3: <?php echo $motivacion_3;?><br>
  4: <?php echo $motivacion_4;?><br>
  
  </p>
  </fieldset>
<?php } ?>

<fieldset class="border-bottom p-3">
    <legend>Motivación</legend> 
    <p><?php echo $motivacion;?></p>
</fieldset>

<fieldset class="border-bottom p-3">
    <legend>Estado <?php echo $etapaestado;?></legend> 
    <p><?php echo $observaciones;?></p>
</fieldset>


<fieldset class="border-bottom p-3">
    <legend>Documentos</legend> 
    <p>CV: <a href="https://unegocios.uchile.cl/CV/<?php echo $CV; ?>" target="_blank" rel="noopener noreferrer">Curriculum</a> </p>
    <p>
        Documentos adjuntos:<br>
        <ul>
 <?php
	//------------------------
	// Declaracion Jurada
	//------------------------
	
if($id_declaracion_64_dec5<>''){	
?>
   <li>
    <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_doc_x_id_documento.php?id_documento=<?php echo $id_declaracion_64_dec5;?>" target="_blank"> Ver Declaracion</a>
   </li>
 
<?php
}
//------------------------------------//
// Contrato prestaciones de servicio  //
//------------------------------------//
if($id_contrato_ps_64_dec5<>''){	
?>
	<li>
	 <a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/dec5/get_doc_x_id_documento.php?id_documento=<?php echo $id_contrato_ps_64_dec5;?>" target="_blank"> Ver Contrato</a>
	</li>
<?php
}
?>    
</ul>
<ul>
    <?php
    /*
    foreach($arr_documentos as $archivo){
        ?>
        <li><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/Fichas/<?php echo $id_postulacion;?>/<?php echo $archivo;?>?k=<?php echo rand(1,100)?>" target="_blank"><?php echo $archivo;?></a></li>
        <?php
    }
    */
    $dir = $_SERVER{'DOCUMENT_ROOT'}."apps/cdg/postulacion/admision/Fichas/".$id_postulacion."";
    if(is_dir($dir)){
        $directorio=opendir($dir); 
        $i=1;
       while ($archivo = readdir($directorio)) { 
            if($archivo != '.' && $archivo != '..' && $archivo != 'bk' && $archivo != 'BK'){
            ?>
            <li id="li<?php echo $i;?>"><a href="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/Fichas/<?php echo $id_postulacion;?>/<?php echo $archivo;?>?k=<?php echo rand(1,100)?>" target="_blank"><?php echo $archivo;?></a> 
                <?php 

                if($archivo<>'control_decreto.pdf'){ ?>
                <button class="btn btn-sm btn-outline-primary eliminar_adj" data="<?php echo $archivo;?>" li="li<?php echo $i;?>"><i class="bi bi-trash"></i> eliminar</button>
                <?php } ?>
            </li>
            <?php
            }
           $i++; 
        }
    }
    ?>
</ul> 
</p>
    <a class="btn btn-primary" href="adj_documentos.php?id_form=<?php echo $id_postulacion;?>" target="_self" rel="noopener noreferrer"> Adjuntar Documento</a>
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
        console.log('clic btn_cancelar');

        $("#datos_personales").show(300);
        $("#div_frm_datos_personales").hide(300);
        $('html,body').animate({
            scrollTop: $("#datos_personales").offset().top
        }, 1000);
        

    });

    $("#btn_guardar").click(function() {
        console.log('clic btn_guardar');

        $.post( "actualizar_data.php", 
            { 
                rut: $("#rut").val(),
                nombre: $("#nombre").val(),
                apellido_pat: $("#apellido_pat").val(),
                apellido_mat: $("#apellido_mat").val(),
                fecha_nacimiento: $("#fecha_nacimiento").val(),
                email: $("#email").val(),
                celular: $("#celular").val(),
                calle: $("#calle").val(),
                numero: $("#numero").val(),
                depto_of: $("#depto_of").val(),
                comuna: $("#comuna").val(),
                genero: $("#genero").val(),
                ex_alumno: $("#ex_alumno").val(),
                
                id_postulacion: $("#id_postulacion").val()
            })
        .done(function( data ) {
            console.log( "Data actualizado: " + data );
            
            $("#datos_personales").empty().html(data);
            
        });


        $("#datos_personales").show(300);
        $("#div_frm_datos_personales").hide(300);
        
        $('html,body').animate({
            scrollTop: $("#datos_personales").offset().top
        }, 1000);
        

    });

    
    $("#btn_eliminar").click(function() {
        console.log('clic btn_eliminar '+$(this).attr('data-id_postulacion'));

       
        $.post( "eliminar_postulacion.php", 
            { 
                ee: $("#ee").val(),
                id_postulacion: $("#id_postulacion").val()
            })
        .done(function( data ) {
            console.log( "Data actualizado: " + data );
            
            $("#div_eliminar").empty().html('Eliminado');
   
            
        });


    });

    
    $("#btn_in_motivo").click(function() {
       console.log('click div_motivo'); 
       
       $("#div_motivo").show(300);
        $("#btn_in_motivo").hide(300);
       
    });

    $(".dropdown-item").click(function() {
       console.log($(this).attr('data')); 
       $("#textarea_motivo_elimina").val($(this).attr('data'));
       
       
       
    });

});



        </script>
        
    </body>
</html>
