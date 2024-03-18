</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">TI Unegocios &copy; Santiago - Chile 2020</div>
            <div>
                <a href="#">Politica de Privacidad</a>
                &middot;
                <a href="#">Terminos &amp; Condiciones</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>-->
<script src="js/jquery-3.5.1.min.js"></script>
<!--
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="js/scripts.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>-->
<script src="js/Chart.min.js"></script>
<!--
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
<script src="js/popper.min.js"></script>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script>
    $(document).ready(function () {
/* VALORES CARGADOS */
            if ($("#programa_detalle").val() != '') {
                
                $(".div_programa_detalle").hide(300);

                    var ctr_div = $("#programa_detalle").val()
                    $(ctr_div).show(100);

            } else {
                $(".div_programa_detalle").show(300);
                //$('#programa_detalle').val();

            }

        /* COMBOBOX PROGRAMAS  */

        $("#cmb_programa").change(function () {

            if ($(this).val() != '') {
                if ($('.div_programa_detalle').is(":visible")) {
                    $(".div_programa_detalle").hide(300);

                    var ctr_div = "#" + $(this).val();
                    $(ctr_div).show(100);

                    $('#programa_detalle').val(ctr_div);

                }
            } else {
                $(".div_programa_detalle").show(300);
                $('#programa_detalle').val('');

            }
        });

        
        $(".nav-link").click(function () {
            console.log($(this).attr('url'));
            $("#link").attr('action',$(this).attr('url'));
            $("#link").submit();
        });

    });


    var initDestroyTimeOutPace = function() {
    var counter = 0;

    var refreshIntervalId = setInterval( function(){
        var progress; 

        if( typeof $( '.pace-progress' ).attr( 'data-progress-text' ) !== 'undefined' ) {
            progress = Number( $( '.pace-progress' ).attr( 'data-progress-text' ).replace("%" ,'') );
        }

        if( progress === 99 ) {
            counter++;
        }

        if( counter > 25 ) {
            clearInterval(refreshIntervalId);
            Pace.stop();
        }
            }, 100);
        }
        initDestroyTimeOutPace();



</script>

</body>

</html>