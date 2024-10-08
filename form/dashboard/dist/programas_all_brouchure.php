<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$usuario=$_SESSION['usuario_intranet'];

include('include/header.php');
include('../data/data_periodos.php');
include('../data/data_programas_x_usuario.php');
include('../data/data_postulantes_all_bruchure.php');

//echo ':: <pre>'.print_r($arr_programas, true).'</pre>';

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


                <?php
                                            foreach($arr_programas as $programa){
                                            ?>
                <div id="<?php echo $programa['id_programa'];?>" class="div_programa_detalle">
                    <div class="container-sm bg-info bg-gradientt p-3 rounded-3 m-3 shadow-sm"
                        style="--bs-bg-opacity: .1;">
                        (<a href="postulantes.php?id=<?php echo $programa['id_programa'];?>&tipo_modalidad=<?php echo $tipo_programa.' '.$modalidad_programa;?>"
                            target="_self"><?php echo $programa['id_programa'];?></a>)
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
                                              ?>
                    </div>

                    <?php

                                            
?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered small display" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ficha</th>
                                        <th>FECHA<br><sub>descarga bruchure</sub></th>
                                        <th>NOMBRE</th>

                                        <th>RUT</th>
                                        <th>Email</th>
                                        <th>Celular</th>
                                        <th>Mail envio<br><sub>Link formulario</sub></th>
                                        <th>Otra Postulacion</th>
                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ficha</th>
                                        <th>FECHA<br><sub>descarga bruchure</sub></th>
                                        <th>NOMBRE</th>

                                        <th>RUT</th>
                                        <th>Email</th>
                                        <th>Celular</th>
                                        <th>Mail envio<br><sub>Link formulario</sub></th>
                                        <th>Otra Postulacion</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php

                                            $arr_postulantes = _data_postulantes_brouchure($programa['id_programa']);

                                            $pendiente=0;
                                            
                                            foreach($arr_postulantes as $postulante){
                                            ?>
                                    <tr>
                                        <td><?php 
                                        if($postulante['rut']<>''){ 
                                        echo $postulante['id_postulacion'];
                                        }?></td>
                                        <td align="center">
                                            <?php if($postulante['rut']<>''){ ?>
                                             <a href="ficha_postulante.php?id_postulacion=<?php echo $postulante['id_postulacion'];?>" target="_blank"><i class="fas fa-file-alt"></i></a>
                                             <?php } ?>
                                        </td>

                                        <td nowrap><span
                                                class="text-hide "><?php echo $postulante['fecha_descarga_bruchure'];?></span>
                                            <?php echo date("d/m/Y H:i", strtotime($postulante['fecha_descarga_bruchure']));?>
                                        </td>
                                        <td nowrap>
                                            <?php echo $postulante['nombres'].' '. $postulante['apellido_pat'].' '.$postulante['aprllido_mat'];?>
                                        </td>

                                        <td nowrap><?php 
                                        if($postulante['rut']<>''){
                                                    echo $postulante['rut'];
                                                    if(!$postulante['es_rut_valido']){
                                                      ?>
                                            <spam data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Rut no valido">⚠
                                            </spam>
                                            <?php  
                                                      }
                                        }           ?>
                                        </td>
                                        <td><?php echo $postulante['email'];?></td>
                                        <td><?php echo $postulante['celular'];?></td>
                                        <td align="left">
                                            <?php 
                                            if($postulante['estado']==''){
                                            ?>
                                            <span id="td_mail">
                                                <?php if($postulante['rut']<>''){  ?>
                                                <button class="btn btn-sm btn-info btn_mail"
                                                    data_id="<?php echo $postulante['id_postulacion'];?>">enviar <i
                                                        class="bi bi-envelope"></i></button>
                                                <?php if($postulante['femail_pre_postulacion']==''){ ?>

                                                <?php }else{ ?>
                                                (ultimo envio:
                                                <?php echo date('d-m-Y H:i:s', strtotime($postulante['femail_pre_postulacion']));?>
                                                )

                                                <?php } ?>
                                            </span>
                                            <?php
                                            }else{
                                                echo $postulante['estado'];
                                            }
                                        } ?>
                                        </td>
                                        <td><?php 
                                        if($postulante['otra_pos']<>''){
                                            $arr_otra_pos = explode("|",$postulante['otra_pos']);
                                           
                                            if(!empty($arr_otra_pos)){
                                                ?>
                                            <div class="accordion accordion-flush"
                                                id="accordionFlushExample<?php echo $postulante['id_postulacion'];?>">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header"
                                                        id="flush-headingOne<?php echo $postulante['id_postulacion'];?>">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseOne<?php echo $postulante['id_postulacion'];?>"
                                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                                            <?php echo count($arr_otra_pos); ?> descargas mas
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapseOne<?php echo $postulante['id_postulacion'];?>"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="flush-headingOne"
                                                        data-bs-parent="#accordionFlushExample<?php echo $postulante['id_postulacion'];?>">
                                                        <div class="accordion-body">
                                                            
                                                                <?php
            foreach($arr_otra_pos as $otra_pos){
                echo '- '.$otra_pos.'<br>';
            }
            ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                             
                                        }
                                    }
                                        //echo str_replace("|","<br>", $postulante['otra_pos']);?>

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
                <?php


                                            }
                                            ?>

            </div>
            <p>
            <form action="https://intranet.unegocios.cl/apps/cdg/postulacion/admision/brouchure_excel.php" 
                method="post"
                target="_blank">
                <input type="hidden" name="periodo" value="<?php echo $periodo;?>">
                <input type="hidden" name="usuario" value="<?php echo $usuario;?>">

                <button type="submit" class="btn btn-primary btn-sm">Excel descarga Brouchure <i class="bi bi-download"></i></button>
            </form>    

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
            paging: false,
            order: [[ 2, "DESC" ]],

        });



        $('#filtrar').on('keyup', function () {
            table.search(this.value).draw();
        });

        $("#periodo").change(function () {

            console.log("Change periodo! " + $(this).val());

            $("#frm_periodo").submit();

        });

        $("body").on("click", ".btn_mail", function () {
            //$( ".btn_mail" ).click(function() {
            event.preventDefault();
            var ctrl = $(this).parent();
            $(ctrl).empty();
            id_postulacion = $(this).attr('data_id');
            console.log('Mail id_postulacion: ' + id_postulacion);
            //$.post( "https://intranet.unegocios.cl/apps/cdg/postulacion/admision/link_postulacion_x_paso.php",
            $.post("../../../cdg/postulacion/admision/link_postulacion_x_paso.php", {
                    form_id: id_postulacion,
                    nocache: Math.random()
                })
                .done(function (data) {
                    $(ctrl).html(data);

                });
        });




    });
</script>