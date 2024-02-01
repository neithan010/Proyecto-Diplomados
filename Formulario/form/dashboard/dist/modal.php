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

 
  
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
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
    
       




  });
</script>
<script>
  var exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal.querySelector('.modal-title')
  var modalBodyInput = exampleModal.querySelector('.modal-body input')

  modalTitle.textContent = 'New message to ' + recipient
  modalBodyInput.value = recipient
})
</script>