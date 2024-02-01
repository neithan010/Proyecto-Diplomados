<?php

session_start();

include('include/header.php');
include('../cn/cn_PDO.php');
include_once('../data/data_periodos.php');


$periodo= isset($row_rs_periodo['periodo'])?$row_rs_periodo['periodo']:'20221';
//-----------------------------------------
// Se incluyen los cursos en el resumen
//-----------------------------------------
$cod_diploma='%.'.substr($periodo,-3,2).'.'.substr($periodo,-1).'.%';

$periodo=isset($_POST['periodo'])?$_POST['periodo']:'';
if($periodo==''){ $periodo=end($arr_periodos); }


$usr_cordinador_ad_cmb = isset($_REQUEST['usuario'])?$_REQUEST['usuario']:$_SESSION['usuario'];

$sql_resumen="SELECT 
    d.DIPLOMADO as postulacion,
    d.cod_diploma,
    d.usr_cordinador_ad,
     
    SUM( IF(p.ID_POSTULACION<>'', 1, 0 ) ) AS numPost,
    SUM( IF(p.ID_POSTULACION<>'' and p.nom_diploma is not null and p.nom_diploma<>'' and concat(p.etapa, p.estado) not in ('01','02','03','04','1011','020'), 1, 0 ) ) AS npost_nuevos,
    
    SUM( IFNULL( p.nom_diploma, 1) ) AS re_ingreso,
    SUM( IF( concat(p.etapa,p.estado)in('3030','3131') , 1, IF( garantia=1 , 1, 0 ) ) ) AS Matall,
    sum(if(concat(p.etapa,p.estado)in(3030,3131, 4020,3010),1,IF( garantia=1 , 1, 0 ))) Mat_corregida,
    SUM( IF( concat(p.etapa,p.estado)=('00'), 1, 0 ) ) AS Nuevas ,
    SUM( IF( concat(p.etapa,p.estado)=('1010'), 1, 0 ) ) AS `Eliminadas` ,
    SUM( IF( concat(p.etapa,p.estado)=('1030'), 1, 0 ) ) AS `En_Evaluacion` ,
    SUM( IF( concat(p.etapa,p.estado)=('2020'), 1, 0 ) ) AS `Aceptadas` ,
    SUM( IF( concat(p.etapa,p.estado)=('2030'), 1, 0 ) ) AS `Rechazadas` ,
    SUM( IF( concat(p.etapa,p.estado)=('4020'), 1, 0 ) ) AS `Retirado` ,
    
    SUM( IF( concat(p.etapa,p.estado)=('3131') , IF( garantia=1 , 0, 1 ), 0 ) ) AS `Matriculadas_pc`,
    SUM( IF( concat(p.etapa,p.estado)=('3030') , 1, 0 ) ) AS `Matriculadas_c`,
    SUM( IF( concat(p.etapa,p.estado) in ('3030','3131'), IF( garantia=1 , 1, 0 ), 0 ) ) AS `Garantia`,
    SUM( IF( concat(p.etapa,p.estado)=('2040'), 1, 0 ) ) AS `Espera` ,
    SUM( IF( concat(p.etapa,p.estado)in('00','1030','2020','2040'), 1, 0 ) ) AS Pend,

    SUM( IF(p.ID_POSTULACION<>'' and p.nom_diploma is not null and p.nom_diploma<>'' and concat(p.etapa, p.estado) in ('01','02','03','04','1011'), 1, 0 ) ) AS numPrePost,
    SUM( IF( concat(p.etapa,p.estado)=('1011'), 1, 0 ) ) AS `PrePostElim` 
FROM 
    intranet.diplomados d
    LEFT JOIN unegocios_nuevo.postulacion p on p.cod_diploma=d.cod_diploma 
        AND concat(p.etapa, p.estado)<>'99'
    LEFT JOIN intranet.postulacion_fpago fp on p.id_postulacion=fp.idpostulacion
WHERE 

    -- d.cod_diploma like '$cod_diploma'
    d.periodo='$periodo'
    AND d.usr_cordinador_ad like '$usr_cordinador_ad_cmb'
    AND d.cod_diploma<>'DXX.13.2.T1'
    AND d.area<>'COR'
    AND d.habilitado=0

GROUP BY d.cod_diploma
ORDER BY d.usr_cordinador_ad, d.DIPLOMADO
"
;
//echo '<pre>'.$sql_resumen.'</pre>';

      $stmt_resumen = $con->prepare($sql_resumen);
      $stmt_resumen ->setFetchMode(PDO::FETCH_ASSOC);
      $stmt_resumen ->execute();
      $num_resumen =$stmt_resumen ->rowCount();	
      //echo '::'.$num_resumen;

      while ($row_resumen  = $stmt_resumen ->fetch()){
          $arr_data[]=array(
            "postulacion"       => utf8_encode($row_resumen['postulacion']),
            "cod_diploma"       => $row_resumen['cod_diploma'],
            "usr_cordinador_ad" => $row_resumen['usr_cordinador_ad'],
            "numPost"           => $row_resumen['numPost'],
            "npost_nuevos"      => $row_resumen['npost_nuevos'],
            "re_ingreso"        => $row_resumen['re_ingreso'],
            "Matall"            => $row_resumen['Matall'],
            "Mat_corregida"     => $row_resumen['Mat_corregida'],
            "Nuevas"            => $row_resumen['Nuevas'],
            "Eliminadas"        => $row_resumen['Eliminadas'],
            "En_Evaluacion"     => $row_resumen['En_Evaluacion'],
            "Aceptadas"         => $row_resumen['Aceptadas'],
            "Rechazadas"        => $row_resumen['Rechazadas'],
            "Retirado"          => $row_resumen['Retirado'],
            "Matriculadas_pc"   => $row_resumen['Matriculadas_pc'],
            "Matriculadas_c"    => $row_resumen['Matriculadas_c'],
            "Garantia"          => $row_resumen['Garantia'],
            "Espera"            => $row_resumen['Espera'],
            "Pend"              => $row_resumen['Pend'],
            "numPrePost"        => $row_resumen['numPrePost'],
            "PrePostElim"       => $row_resumen['PrePostElim'] 
          );

          $arr_usr_cordinador_ad[]=$row_resumen['usr_cordinador_ad'];
      }
      $arr_usr_cordinador_ad=array_unique($arr_usr_cordinador_ad);
//echo '<pre>'.print_r($arr_usr_cordinador_ad, true).'</pre>';
?>
<div class="container-fluid">

    <h1 class="mt-4">Resumen de estados</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Resumen Estados</li>
    </ol>


    <form action="#" name="frm_usr_periodo" id="frm_usr_periodo" method="POST">

                        <div class="row align-items-start p-3">
                          <div class="col-3">Usuario: 
                            <select class="form-select form-select-sm " id="usuario" name="usuario" aria-label=".form-select-sm ">
                              
                              <?php foreach($arr_usr_cordinador_ad as $usr_cordinador_ad){ ?>
                              <option value="<?php echo $usr_cordinador_ad;?>" <?php if($usr_cordinador_ad==$usr_cordinador_ad_cmb){echo 'selected';} ?> ><?php echo $usr_cordinador_ad;?></option>
                              <?php } ?>
                              <option value="%" <?php if('%'==$usr_cordinador_ad_cmb){echo 'selected';} ?> >Todos</option>
                            </select>
                          </div>
                          <div class="col-9"></div>
                        </div>
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

<table class="table table-bordered table-sm">
<caption>Resumen postulaciones y estados</caption>
    
    <thead>
    <tr>
        <th>Postulacion</th>
        <th>Cod_Diploma</th>
        <th>Ejecutivo</th>
        <th>Post</th>
        <th>Post Nuevos</th>
        <th>Re Ingreso</th>
        <th>Mat</th>

        <th>Nuevas</th>
        <th>Elim</th>
        <th>En Eva.</th>
        <th>Acep</th>
        <th>Rech.</th>
        <th>Retirado</th>

  
        <th>Espera</th>
        <th>Pend</th>
        <th title="Pre Postulaciones">Pre Post</th>
        <th title="Pre Postulaciones Eliminadas">Pre Post Elim</th>
        </tr>
    </thead>
    
    <tbody>
<?php
foreach($arr_data as $data){
?>

<tr>
    <td><?php echo $data['postulacion']; ?></td>
    <td><?php echo $data['cod_diploma']; ?></td>
    <td><?php echo $data['usr_cordinador_ad']; ?></td>
    <td><?php echo $data['numPost']; ?></td>
    <td><?php echo $data['npost_nuevos']; ?></td>
    <td><?php echo $data['re_ingreso']; ?></td>
    <td><?php echo $data['Matall']; ?></td>

    <td><?php echo $data['Nuevas']; ?></td>
    <td><?php echo $data['Eliminadas']; ?></td>
    <td><?php echo $data['En_Evaluacion']; ?></td>
    <td><?php echo $data['Aceptadas']; ?></td>
    <td><?php echo $data['Rechazadas']; ?></td>
    <td><?php echo $data['Retirado']; ?></td>


    <td><?php echo $data['Espera']; ?></td>
    <td><?php echo $data['Pend']; ?></td>
    <td><?php echo $data['numPrePost']; ?></td>
    <td><?php echo $data['PrePostElim']; ?></td>
    </tr>
   
<?php
}
?>
</tbody> 
</table>

</div>


<?php
include_once('include/footer.php');
?> 
<script>
$( document ).ready(function() {

    $("#periodo" ).change(function() {
       //console.log( "Change periodo! " + $(this).val());
       $("#frm_usr_periodo").submit();
     });

     $("#usuario" ).change(function() {
       //console.log( "Change usuario! " + $(this).val());
       $("#frm_usr_periodo").submit();
     });
});
</script>