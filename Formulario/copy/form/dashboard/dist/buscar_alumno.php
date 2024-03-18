<?php

session_start();

include('include/header.php');
include('../cn/cn_PDO.php');

$num_buscar=0;
$txt_buscar='';

if(isset($_REQUEST['txt_buscar'])){
    
  $txt_buscar= trim($_REQUEST['txt_buscar']);
  if(strlen($txt_buscar)>0){

      $buscar = '%'.str_replace(" ","%",$txt_buscar).'%';
      
      $sql_buscar="SELECT 
          p.ID_POSTULACION,
          p.cod_diploma,
          d.cod_interno,
          p.POSTULACION,
          CONCAT_WS(' ', p.NOMBRES,p.APELLIDO_PAT, p.APELLIDO_MAT) AS nombre,
          p.rut,
          CONCAT(p.etapa, p.estado) ee,
          p.TELEFONO,
          p.CELULAR,
          p.EMAIL,
          d.usr_cordinador_ad,
          d.fecha_inicio,
          d.fecha_termino,
          d.web_habilitado,
          d.ID_DIPLOMA,
          d.tipo_programa,
          d.modalidad_programa,
          
          CASE concat(COALESCE(p.etapa,''),COALESCE(p.estado,''))
            WHEN '' THEN 'Descarga Brouchure'
            WHEN '00' THEN 'Post. Nueva'
            WHEN '01' or '02' THEN 'Pre postulacion'
            WHEN '1011' THEN 'Pre postulacion Eliminada'
            WHEN '1010' THEN 'Eliminada'
            WHEN '1030' THEN 'En Evaluacion'
            WHEN '2020' THEN 'Aceptada'
            WHEN '2030' THEN 'Rechazado'
            WHEN '2040' THEN 'Pendiente DA'
            WHEN '3010' THEN 'Retirado'
            WHEN '3030' THEN 'Matriculado'
            WHEN '3131' THEN 'Mat. Pendiente Cierre'
            WHEN '4020' THEN 'Postergado'
            WHEN '99' THEN 'S/I'
            ELSE '*'
        END etapaestado,
        p.observaciones,
        f.declaracion_firmado,
        f.contrato_ps_firmado
      
      FROM 
          unegocios_nuevo.postulacion p 
          INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
          LEFT JOIN intranet.firma_digital f ON f.id_postulacion=p.ID_POSTULACION
      WHERE 
          p.ID_POSTULACION LIKE '$buscar'
          OR CONCAT_WS(' ', p.NOMBRES,p.APELLIDO_PAT, p.APELLIDO_MAT) LIKE '$buscar'
          OR p.RUT LIKE '$buscar'
          OR p.EMAIL LIKE '$buscar'
      ORDER BY 
         p.ID_POSTULACION DESC, p.RUT";

  //echo '<pre>'.$sql_buscar.'</pre>';

      $stmt_buscar = $con->prepare($sql_buscar);
      $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
      $stmt_buscar ->execute();
      $num_buscar =$stmt_buscar ->rowCount();	
      //echo '::'.$num_postulantea;

      while ($row_buscar  = $stmt_buscar ->fetch()){
        $url="https://intranet.unegocios.cl/fotos/upload_pic/".$row_buscar['rut'].".jpg";
        if(@file_get_contents($url)){
          $foto="https://intranet.unegocios.cl/fotos/upload_pic/".$row_buscar['rut'].".jpg";
        }else{
          $foto="https://intranet.unegocios.cl/fotos/upload_pic/1.jpg";
        }
          $arr_buscar[]=array(
              "id_postulacion"	    => $row_buscar['ID_POSTULACION'],
              "cod_diploma"   	    => $row_buscar['cod_diploma'],
              "ceco"   	    => $row_buscar['cod_interno'],
              "programa"		        => utf8_encode($row_buscar['POSTULACION']),
              "nombre"			        => utf8_encode($row_buscar['nombre']),
              "rut"                 => $row_buscar['rut'],
              "ee"				          => $row_buscar['ee'],
              "telefono"			    	=> $row_buscar['TELEFONO'],
              "celular"				      => $row_buscar['CELULAR'],
              "email"				        => $row_buscar['EMAIL'],
              "usr_cordinador_ad"		=> $row_buscar['usr_cordinador_ad'],
              "fecha_inicio"				=> $row_buscar['fecha_inicio'],
              "fecha_termino"				=> $row_buscar['fecha_termino'],
              "web_habilitado"			=> $row_buscar['web_habilitado'],
              "id_diploma"				  => $row_buscar['ID_DIPLOMA'],
              "tipo_programa"				=> $row_buscar['tipo_programa'],
              "modalidad_programa"	=> $row_buscar['modalidad_programa'],
              "etapaestado"	        => $row_buscar['etapaestado'],
              "foto"                => $foto,
              "observaciones"			  => utf8_encode($row_buscar['observaciones']),
              "declaracion_firmado" => $row_buscar['declaracion_firmado'],
              "contrato_ps_firmado" => $row_buscar['contrato_ps_firmado']
          );

      }

  }
}
?>
<div class="container-fluid">
  <h1 class="mt-4">Buscar Persona (Alumno / Postulante)</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">buscar</li>
  </ol>

  <form class="row g-3 " method="POST">
    <div class="col-auto form-inline">
      <label for="inputPassword2" class="visually-hidden">Buscar</label>
      <input type="text" name="txt_buscar" class="form-control" id="inputPassword2"
        placeholder="nombre, id, rut o email" maxlength="255">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-3">Buscar</button>
    </div>
  </form>
  <?php
if($num_buscar>0){
?>
  <div>

    Se encontraron <?php echo $num_buscar;?> resultados para: "<i><?php echo $txt_buscar;?></i>"
  </div>
  <?php
}elseif($num_buscar==0 && $txt_buscar<>''){
  ?>
  <div>

    No se encontraron resultados para: "<i><?php echo $txt_buscar;?></i>"
  </div>
  <?php
}

?>

  <?php
if($num_buscar>0){
    foreach($arr_buscar as $buscar){
?>
  <div class="card w-95 result_busqueda my-2">
    <div class="card-body">

      <img src="<?php echo $buscar['foto']; ?>" class="rounded float-start mx-2" width="67" height="85" alt="...">

      <h5 class="card-title">
        <i class="bi bi-fingerprint"></i> <?php echo $buscar['rut']; ?><br>
        <i class="bi bi-person"></i> <?php echo $buscar['nombre']; ?><br>
        <i class="bi bi-envelope"></i> <a href="mailto:<?php echo $buscar['email']; ?>"><?php echo $buscar['email']; ?></a><br>
        <i class="bi bi-telephone"></i> <a href="tel:<?php echo $buscar['telefono']; ?>"><?php echo $buscar['telefono']; ?></a><br>
        <i class="bi bi-phone-vibrate"></i> <a href="tel:<?php echo $buscar['celular']; ?>"><?php echo $buscar['celular']; ?></a>
      </h5>
      <p class="card-text"><strong>ID:</strong> <?php echo $buscar['id_postulacion']; ?><br>
        <strong>Programa:</strong> <?php echo $buscar['programa']; ?> [<?php echo $buscar['cod_diploma']; ?>]
        [<?php echo $buscar['ceco']; ?>] [<?php echo $buscar['usr_cordinador_ad']; ?>]<br>
        <strong>Fecha:</strong>
        <?php echo ($buscar['fecha_inicio']<>'')?date("d-m-Y", strtotime($buscar['fecha_inicio'])):'(sin definir)'; ?>
        al
        <?php echo ($buscar['fecha_termino']<>'')?date("d-m-Y", strtotime($buscar['fecha_termino'])):'(sin definir)'; ?>
      </p>

      <strong>Estado:</strong> <?php echo $buscar['etapaestado']; 
    $arr_estados = array('2020','3030','3131','4020');
    
    echo $buscar['usr_cordinador_ad'].'<br>';
    echo $_SESSION['usuario_intranet'].'<br>';

    if($buscar['usr_cordinador_ad']==$_SESSION['usuario_intranet'] && in_array($buscar['ee'],$arr_estados)){
?>
      : <a
        href="postulantes.php?id=<?php echo $buscar['id_diploma'];?>&tipo_modalidad=<?php echo $buscar['tipo_programa'].'%20'.$buscar['modalidad_programa'];?>&id_postulacion=<?php echo $buscar['id_postulacion']; ?>"
        class="btn btn-primary btn-sm">ir</a>
      <?php
    }
    ?>

      </p>
      <?php if($buscar['observaciones']<>''){ ?>
      <p>
        <strong>Observaciones</strong> <?php echo $buscar['observaciones'];?>
      </p>
      <?php } ?>
      <?php 
//echo ':: '.$_SESSION["usuario"];
if($_SESSION["usuario_intranet"]=='admin'){
  if($buscar['declaracion_firmado']<>1 || $buscar['contrato_ps_firmado']<>1){
  ?>
      <div id="marca<?php echo $buscar['id_postulacion']; ?>">
        <button class="btn btn-info btn-sm btn_marca_firmado" data="<?php echo $buscar['id_postulacion']; ?>">marcar
          como firmados</button>
      </div>
      <?php
  }
  if($buscar['declaracion_firmado']==1 && $buscar['contrato_ps_firmado']==1){
    ?>
      <div id="marca<?php echo $buscar['id_postulacion']; ?>">
        documentos firmados ✔✔
      </div>
      <?php
  }
}
?>

    </div>
  </div>
  <?php        
       
    }
}
?>

</div>


<?php
include_once('include/footer.php');
?>
<script>
  $(document).ready(function () {


    $(".btn_marca_firmado").click(function () {

      console.log("btn_marca_firmado! " + $(this).attr('data'));
      var id = $(this).attr('data');

      $.post("certinet/marca_firma_doc_fdigital.php", {
          id_postulacion: $(this).attr('data')
        })
        .done(function (data) {
          var ctrl = "#marca" + id;
          $(ctrl).empty();
          $(ctrl).html(data);


        });



    });


  });
</script>