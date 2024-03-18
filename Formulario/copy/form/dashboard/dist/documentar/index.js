$( document ).ready(function() {
    

    
    $("#pagar_usd").hide();
    
    $("#div_tx").hide();
    $("#div_tc").hide();
    $("#div_webpay").hide();
    $("#div_paypal").hide();
    $("#div_pat").hide();
    $("#div_pac").hide();
    $("#div_oc").hide();
    $("#div_vv").hide();
    $("#div_ch").hide();

    $("#div_tx_emp").hide();
    $("#div_tc_emp").hide();
    $("#div_webpay_emp").hide();
    $("#div_paypal_emp").hide();
    $("#div_pat_emp").hide();
    $("#div_oc_emp").hide();
    $("#div_vv_emp").hide();
    $("#div_ch_emp").hide();

    console.log('_pago_clpUsd');
    _pago_clpUsd();
    
    //$("#lnk_cd" ).click(function(){
    $("body").on("click","#lnk_cd",function(){
            console.log('clik lnk_cd');
            $("#div_cd").html('<button id="btn_refresh_cd" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i> control decreto</button>');
    });

    //$("#lnk_cs" ).click(function(){
    $("body").on("click","#lnk_cs",function(){
            console.log('click lnk_cs');
            $("#div_cs").html('<button id="btn_refresh_cs" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i> Contrato</button>');
    });

    //$("#lnk_dj" ).click(function(){
    $("body").on("click","#lnk_dj",function(){
            console.log('clik lnk_dj');
            $("#div_dj").html('<button id="btn_refresh_dj" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i> Declaración Jurada</button>');
    });

    
    $("#valor_pagar_usd" ).keyup(function(){
            $("#monto_paypal").val($(this).val());
    });

    $("#btn_valor_pagar_usd" ).click(function(){
        _in_postulacion_data_pagos();   
    });

    $("#valor_uf").keyup(function(){
        
        $("#uf").val($(this).val());
        console.log('UF: '+$("#uf").val());
        console.log('moneda: '+$("#moneda").val());       
        
        var total_pagar;

        if($("#moneda").val()=='UF'){
            total_pagar=Math.ceil($("#uf").val()*$("#valor_programa").val()*(1-$("#total_descuento").val()/100));
        }else{
            total_pagar=Math.ceil($("#valor_programa").val()*(1-$("#total_descuento").val()/100));
        }

        
        
        console.log('* total_pagar: '+total_pagar);

        $("#total_pagar").val(total_pagar);
        $("#div_valor_pagar").html(total_pagar+' CLP');
        
    });
    
//-------------------------        
// BTN CONTROL DECRETO
//-------------------------
    $("body").on("click","#btn_refresh_cd",function(){
        console.log('clik btn_refresh_cd 2 '+$("#id_postulacion").val());
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           var formData = new FormData(document.getElementById("frm_documentos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            $.ajax({
                url: "../control_decreto/valida_exista_cd.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_cd").html(data);
			
		});
    });

    $("body").on("click","#dell_cd",function(){
        console.log('clik dell_cd 2');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
        if(confirm('Esta seguro de eliminar el control decreto ya creado?')){
            console.log('CD Eliminado');
           
         
                var formData = new FormData(document.getElementById("frm_documentos"));
                    formData.append("id_postulacion", $("#id_postulacion").val());
                    $.ajax({
                        url: "dell_control_decreto.php",
                        type: "post",
                        //dataType: "json",
                        data: formData,
                        cache: false,
                        contentType: false,
                processData: false
                    })
                .fail(function(jqXHR, textStatus) {
                        alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
                    })
                .done(function( data ) {
                    $("#div_cd").html(data);
                    
                });
        }
        
    });
//-------------------------        
// BTN CONTRATO
//-------------------------
$("body").on("click","#btn_refresh_cs",function(){
        console.log('clik btn_refresh_cs 2');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           var formData = new FormData(document.getElementById("frm_documentos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            $.ajax({
                url: "../contrato/valida_exista_cs.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_cs").html(data);
			
		});
    });
//--------------------------
// recallPackage contrato
//--------------------------

    $("body").on("click","#dell_cs",function(){
        console.log('clik dell_cd 2');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           if(confirm('Esta seguro de eliminar el contrato ya creado?')){
            console.log('CS Eliminado');
           }
         
           var formData = new FormData();
            formData.append("id_postulacion", $("#id_postulacion").val());
            formData.append("documento", "contrato");
            $.ajax({
                url: "../certinet/recallPackage.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
            $("#div_cs").empty();
			$("#div_cs").html(data);
			
		});
    
    });  
//------------------------------
// recallPackage declaracion
//------------------------------
      
    $("body").on("click","#dell_dj_digital",function(){
        console.log('clik dell_dj_digital');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           if(confirm('Esta seguro de eliminar la declaracion jurada ya creado?')){
            console.log('DJ Eliminado');
           }
         
           var formData = new FormData();
            formData.append("id_postulacion", $("#id_postulacion").val());
            formData.append("documento", "declaracion");
            $.ajax({
                url: "../certinet/recallPackage.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
            $("#div_dj").empty();
			$("#div_dj").html(data);
			
		});
    
    });

//-------------------------        
// BTN DECLARACION JURADA
//-------------------------
    $("body").on("click","#btn_refresh_dj",function(){
        console.log('clik btn_refresh_dj 2');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           var formData = new FormData(document.getElementById("frm_documentos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            $.ajax({
                url: "valida_exista_dj.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_dj").html(data);
			
		});
    });

    $("body").on("click","#dell_dj",function(){
        console.log('clik dell_dj 2');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           if(confirm('Esta seguro de eliminar la declaraci\u00f3n jurada ya creado?')){
            console.log('dj Eliminado');

            var v_id_postulacion=$("#id_postulacion").val();
            $.post( "dell_dj.php", { id_postulacion: v_id_postulacion })
            .done(function( data ) {
                alert( data );
                $("#div_dj").html('<i class="fas fa-file-alt"></i><a href="declaracion.php?form_id='+$("#id_postulacion").val()+'" target="_blank"  id="lnk_dj">Declaracion Jurada</a>');

            });
           }
         
    });    

//-----------
//--------------------
// Link firma documento
//-----------------------

$("body").on("click","#btn_link_firma",function(){
    console.log('clik btn_link_firma');
       /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
    
    
       
     
            var formData = new FormData(document.getElementById("frm_documentos"));
                formData.append("id_postulacion", $("#id_postulacion").val());
                $.ajax({
                    url: "enviar_link_firma.php",
                    type: "post",
                    //dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
            processData: false
                })
            .fail(function(jqXHR, textStatus) {
                    alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
                })
            .done(function( data ) {
                $("#div_link_firma").html(data);
                
            });
    
    
});    
//-----------
$(".rd_pago" ).click(function() {
    console.log('click: '+$("#rd_pago_usd" ).is(':checked'));
    _pago_clpUsd();

});

function _pago_clpUsd(){
    $("#div_link_paypal").hide(300);
    $("#div_link_paypal_emp").hide(300);

    if($("#rd_int" ).is(':checked') || $("#rd_intemp" ).is(':checked')){
        //console.log('rd_int - rd_intemp');
        //------------------------------
        //--------- Pago USD
        //------------------------------
        if($("#rd_pago_usd" ).is(':checked')){

            //console.log('Pago USD: '+$("#rd_pago_usd" ).is(':checked'));

            $("#pagar_usd").show(300);
            
            $("#check_tx").attr("disabled", true);
            $("#check_tc").attr("disabled", true);
            $("#check_webpay").attr("disabled", true);
            $("#check_pat").attr("disabled", true);
            $("#check_oc").attr("disabled", true);
            $("#check_vv").attr("disabled", true);
            $("#check_tx").attr("disabled", true);

            $("#check_paypal").removeAttr("disabled");

            $("#div_link_tc").hide(300);
            $("#div_link_paypal").show(300);
            

        }else{
        //------------------------------
        //--------- Pago CLP
        //------------------------------    
            //console.log('Pago CLP: '+$("#rd_pago_usd" ).is(':checked'));

            $("#pagar_usd").hide(300);

            $("#check_tx").removeAttr("disabled");
            $("#check_tc").removeAttr("disabled");
            $("#check_webpay").removeAttr("disabled");
            $("#check_pat").removeAttr("disabled");
            //$("#check_oc").removeAttr("disabled");
            $("#check_vv").removeAttr("disabled");
            $("#check_tx").removeAttr("disabled");

            $("#check_paypal").prop("checked",false);
            $("#check_paypal").attr("disabled", true);
            

            $("#div_link_tc").show(300);
            $("#div_link_paypal").hide(300);
            //console.log('div_link_paypal CLP: ');
            
            }
    }
    if($("#rd_emp" ).is(':checked') || $("#rd_intemp" ).is(':checked')){
        //console.log('rd_emp - rd_intemp');
        //------------------------------
        //--------- Pago USD
        //------------------------------
        //console.log('Pago USD: '+$("#rd_pago_usd" ).is(':checked'));

        if($("#rd_pago_usd" ).is(':checked')){
            $("#pagar_usd").show(300);
            
            $("#check_tx_emp").attr("disabled", true);
            $("#check_tc_emp").attr("disabled", true);
            $("#check_webpay_emp").attr("disabled", true);
            $("#check_pat_emp").attr("disabled", true);
            $("#check_oc_emp").attr("disabled", true);
            $("#check_vv_emp").attr("disabled", true);
            

            $("#check_paypal_emp").removeAttr("disabled");

            $("#div_link_tc_emp").hide(300);
            $("#div_link_paypal_emp").show(300);
            

            }else{
        //------------------------------
        //--------- Pago CLP
        //------------------------------    
            //console.log('Pago CLP: '+$("#rd_pago_usd" ).is(':checked'));

                $("#pagar_usd").hide(300);

            $("#check_tx_emp").removeAttr("disabled");
            $("#check_tc_emp").removeAttr("disabled");
            $("#check_webpay_emp").removeAttr("disabled");
            $("#check_pat_emp").removeAttr("disabled");
            $("#check_oc_emp").removeAttr("disabled");
            $("#check_vv_emp").removeAttr("disabled");
            

            $("#check_paypal_emp").prop("checked",false);
            $("#check_paypal_emp").attr("disabled", true);
            

            $("#div_link_tc_emp").show(300);
            $("#div_link_paypal_emp").hide(300);

            
            }
    }
}     
   
    
$(".monto").keyup(function (){
 this.value = (this.value + '').replace(/[^0-9]/g, '');
 
});
$(".monto_usd").keyup(function (){
 this.value = (this.value + '').replace(/[^0-9,.]/g, '');
 
});


$(".calCuota").keyup(function (){
    
    var cuota=parseInt($("#monto_tc").val().replace(/\./g,'')||0)/ parseInt($("#num_cuotas").val().replace(/\./g,'')||1);
    cuota=Math.ceil(cuota);
    cuota= new Intl.NumberFormat("es-CL").format(cuota)

    $("#valor_cuota").html(cuota);

    var cuota=parseInt($("#monto_tc_emp").val().replace(/\./g,'')||0)/ parseInt($("#num_cuotas_emp").val().replace(/\./g,'')||1);
    cuota=Math.ceil(cuota);
    cuota= new Intl.NumberFormat("es-CL").format(cuota)

    $("#valor_cuota_emp").html(cuota);

    var cuota=parseInt($("#monto_tc_wp").val().replace(/\./g,'')||0)/ parseInt($("#num_cuotas_wp").val().replace(/\./g,'')||1);
    cuota=Math.ceil(cuota);
    cuota= new Intl.NumberFormat("es-CL").format(cuota)

    $("#valor_cuota_wp").html(cuota);

    var cuota=parseInt($("#monto_tc_wp_emp").val().replace(/\./g,'')||0)/ parseInt($("#num_cuotas_wp_emp").val().replace(/\./g,'')||1);
    cuota=Math.ceil(cuota);
    cuota= new Intl.NumberFormat("es-CL").format(cuota)

    $("#valor_cuota_wp_emp").html(cuota);
});

// ------------  TX  -------------------
    $("#check_tx" ).click(function() {
        if($("#check_tx" ).is(':checked')){
           $("#div_tx").show(300);
        }else{
            
            $('#monto_tx').val('');
            $("#div_tx").hide(300);
            
        }
        
    });

    $("#check_tx_emp" ).click(function() {
        if($("#check_tx_emp" ).is(':checked')){
           $("#div_tx_emp").show(300);
        }else{
            
            $('#monto_tx_emp').val('');
            $("#div_tx_emp").hide(300);
            
        }
        
    });
    
// ------------  TC  -------------------
    $("#check_tc" ).click(function() {
        if($("#check_tc" ).is(':checked')){
           $("#div_tc").show(300);
        }else{
            $("#div_tc").hide(300);
           
        }
        
    });

    $("#check_tc_emp" ).click(function() {
        if($("#check_tc_emp" ).is(':checked')){
           $("#div_tc_emp").show(300);
        }else{
            $("#div_tc_emp").hide(300);
           
        }
        
    });
    
// ------------  WEBPAY  -------------------
$("#check_webpay" ).click(function() {
        if($("#check_webpay" ).is(':checked')){
           $("#div_webpay").show(300);
        }else{
            $("#div_webpay").hide(300);
        }
        
    });
    $("#check_webpay_emp" ).click(function() {
        if($("#check_webpay_emp" ).is(':checked')){
           $("#div_webpay_emp").show(300);
        }else{
            $("#div_webpay_emp").hide(300);
        }
        
    });

    
// ------------  PAYPAL  -------------------
    $("#check_paypal" ).click(function() {
        console.log('check_paypal '+$("#check_paypal" ).is(':checked'));
        if($("#check_paypal" ).is(':checked')){
           $("#div_paypal").show(300);
           console.log('mostrar');
        }else{
            $("#div_paypal").hide(300);
            console.log('ocultar');
        }
        
    });

    $("#check_paypal_emp" ).click(function() {
    console.log('check_paypal_emp '+$("#check_paypal_emp" ).is(':checked'));
        if($("#check_paypal_emp" ).is(':checked')){
           $("#div_paypal_emp").show(300);
           console.log('mostrar');
        }else{
            $("#div_paypal_emp").hide(300);
            console.log('ocultar');
        }
        
    });
    

    // ------------  PAT  -------------------
    $("#check_pat" ).click(function() {
            if($("#check_pat" ).is(':checked')){
            $("#div_pat").show(300);
            }else{
                $("#div_pat").hide(300);
            }
            
    });
    $("#check_pat_emp" ).click(function() {
            if($("#check_pat_emp" ).is(':checked')){
            $("#div_pat_emp").show(300);
            }else{
                $("#div_pat_emp").hide(300);
            }
            
    });

    // ------------  PAC  -------------------
    $("#check_pac" ).click(function() {
        if($("#check_pac" ).is(':checked')){
        $("#div_pac").show(300);
        }else{
            $("#div_pac").hide(300);
        }
        
    });
    $("#check_pac_emp" ).click(function() {
        if($("#check_pac_emp" ).is(':checked')){
        $("#div_pac_emp").show(300);
        }else{
            $("#div_pac_emp").hide(300);
        }
        
    });    
    
    // ------------  OC  -------------------
    $("#check_oc" ).click(function() {
        if($("#check_oc" ).is(':checked')){
        $("#div_oc").show(300);
        }else{
            $("#div_oc").hide(300);
        }
        
    });
    $("#check_oc_emp" ).click(function() {
        if($("#check_oc_emp" ).is(':checked')){
        $("#div_oc_emp").show(300);
        }else{
            $("#div_oc_emp").hide(300);
        }
        
    });

    
    // ------------  VV  -------------------
    $("#check_vv" ).click(function() {
        if($("#check_vv" ).is(':checked')){
        $("#div_vv").show(300);
        }else{
            $("#div_vv").hide(300);
        }
        
    });

    $("#check_vv_emp" ).click(function() {
        if($("#check_vv_emp" ).is(':checked')){
        $("#div_vv_emp").show(300);
        }else{
            $("#div_vv_emp").hide(300);
        }
        
    });

    
    // ------------  VV  -------------------
    $("#check_ch" ).click(function() {
        if($("#check_ch" ).is(':checked')){
        $("#div_ch").show(300);
        }else{
            $("#div_ch").hide(300);
        }
        
    });

    $("#check_ch_emp" ).click(function() {
        if($("#check_ch_emp" ).is(':checked')){
        $("#div_ch_emp").show(300);
        }else{
            $("#div_ch_emp").hide(300);
        }
        
    });

    //------------------
    
    $("#rd_int" ).click(function() {
        $("#interesado").show(300);
        $("#empresa").hide(300);
        _pago_clpUsd();
        console.log('clock int');

        $.post( "update_forma_pago.php",
            { id_postulacion : $(this).attr('data'),
            qpaga : 'Interesado' })
        .done(function( data ) {
            console.log(data);
        });
    });
    $("#rd_emp" ).click(function() {
        $("#empresa").show(300);
        $("#interesado").hide(300);
        _pago_clpUsd();
       console.log('clock emp');
       $.post( "update_forma_pago.php",
            { id_postulacion : $(this).attr('data'),
            qpaga : 'Empresa' })
        .done(function( data ) {
            console.log(data);
        });
    });
    $("#rd_intemp").click(function() {
        $("#empresa").show(300);
        $("#interesado").show(300);
        _pago_clpUsd();
        console.log('clock mixto');
        $.post( "update_forma_pago.php",
            { id_postulacion : $(this).attr('data'),
            qpaga : 'Interesado/Empresa' })
        .done(function( data ) {
            console.log(data);
        });
    });
    

console.log('#rd_int'+ $("#rd_int" ).is(':checked'));
console.log('#rd_emp'+ $("#rd_emp" ).is(':checked'));
console.log('#rd_intemp'+ $("#rd_intemp" ).is(':checked'));
    
$("#interesado").hide(300);
$("#empresa").hide(300);

if($("#rd_int" ).is(':checked')){
   $("#interesado").show(300);
}
if($("#rd_emp" ).is(':checked')){
    $("#empresa").show(300);
}
if($("#rd_intemp" ).is(':checked')){    
    $("#empresa").show(300);
    $("#interesado").show(300);
     
}
    //-----------
    

    $(".monto").keyup(function() {
        if(this.value!==''){
            this.value = parseFloat(this.value.replace(/,/g, ""))
                  .toFixed(0)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
    $(".monto_usd").keyup(function() {
        if(this.value!==''){
            //this.value = new Intl.NumberFormat("en-EN").format(this.value)
            //this.value = new Intl.NumberFormat("de-DE").format(this.value)
        }
    });
    

    $(".colorbox_cd").colorbox({
		width: "80%",
		maxHeight:"80%"
	});

    _pago_clpUsd();	
//-----------------------------
// postulacion_data_pagos
//--------------------------
    $("body").on("click","#rd_pago_clp",function(){
        console.log('clik rd_pago_clp');
           /* con post verificar la creacion y colocarlink de descarga o boton de modificacion */
           //_in_postulacion_data_pagos();
    });

    $("body").on("click",".btn_re_envio_mail",function(){
        console.log('clik btn_re_envio_mail');
        _envia_mail_pago_webpay_diferido();  
    });
    

    function _in_postulacion_data_pagos(){
        var formData = new FormData(document.getElementById("frm_postulacion_data_pagos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            formData.append("id_financiamiento",$('input:radio[name=qpaga]:checked').val());
            formData.append("moneda_pago",$('input:radio[name=rd_pago]:checked').val());
            formData.append("monto_tc1_link_pago", $("#monto_tc1").val());
            formData.append("monto_tc2_link_pago", $("#monto_tc2").val());
            formData.append("monto_usd_link_pago", $("#valor_pagar_usd").val());
            formData.append("num_link_tc", $("#num_link_tc").val());

            $.ajax({
                url: "postulacion_data_pagos.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_postulacion_data_pagos").html(data);
			
		});
    }

    function _envia_mail_webpay(){
        var formData = new FormData(document.getElementById("frm_postulacion_data_pagos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            
            $.ajax({
                url: "envia_mail_pago_webpay.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_postulacion_data_pagos").html(data);
			
		});
    }
    function _envia_mail_pago_webpay_diferido(){
        
        console.log('_envia_mail_pago_webpay_diferido()');

        var formData = new FormData(document.getElementById("frm_postulacion_data_pagos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            formData.append("pago_diferido", "pago_diferido");
            //formData.append("monto_tc1", $("#monto_tc1").val().replace(/[^0-9]/g, ''));
            
            $.ajax({
                url: "envia_mail_pago_webpay_diferido.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_postulacion_data_pagos").html(data);
			
		});
    }
    function _envia_mail_paypal(){
        var formData = new FormData(document.getElementById("frm_postulacion_data_pagos"));
            formData.append("id_postulacion", $("#id_postulacion").val());
            
            $.ajax({
                url: "envia_mail_pago_paypal.php",
                type: "post",
                //dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
		.fail(function(jqXHR, textStatus) {
				alert( "Ocurrio un error, intente de nuevo o comuniquese con el administrador "+ textStatus );
			})
		.done(function( data ) {
			$("#div_postulacion_data_pagos").html(data);
			
		});
    }
    

    $(document).on('submit', 'frm_postulacion_data_pagos', function(e) {

        console.log('click preventDefault');

        if (e.delegateTarget.activeElement.localName!=="button") {
         e.preventDefault();
        }else{

            $("#div_btn_cp").html('<button id="btn_refresh_comprobante" class="btn btn-success" type="button"><i class="bi bi-arrow-clockwise"></i> Generar comprobante</button>');

        }
    });

    /*
    $("#btn_cp").click(function() {
    
        $("#div_btn_cp").html('<button id="btn_refresh_comprobante" class="btn btn-success" type="button"><i class="bi bi-arrow-clockwise"></i> Generar comprobante</button>');
        console.log('click submit');

    });
*/

    $("#btn_refresh_comprobante").click(function() {
        console.log('click btn_refresh_comprobante');
    });

    
    $("#btn_link_pago").click(function() {
        console.log('click btn_link_pago');
        if($("#monto_tc1").val()==''){
            return false;
        }else{
            _in_postulacion_data_pagos();
            var valor_pagar=$("#valor_pagar").val();
            var monto_pago_tc=$("#monto_tc1").val().replace(/[^0-9]/g, '');
           
            console.log('valor_pagar: '+valor_pagar+' monto_pago_tc: '+monto_pago_tc);
            if(valor_pagar==monto_pago_tc){
                _envia_mail_webpay();
            }else{
                _envia_mail_pago_webpay_diferido();
            }
            
                  
        }
    });

    $("#btn_link_pagoUsd").click(function() {
        console.log('click btn_link_pagoUsd');
        if($("#monto_paypal").val()==''){
            return false;
        }else{
            _in_postulacion_data_pagos();
            _envia_mail_paypal();
        }
    });


    $("body").on("click","#link_pago_total",function(){
        console.log('clik link_pago_total');

       

        _envia_mail_webpay()
        
    });
    

});
