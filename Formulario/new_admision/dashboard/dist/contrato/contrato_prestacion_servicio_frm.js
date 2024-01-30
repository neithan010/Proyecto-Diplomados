// JavaScript Document
function _generar_doc_fd(doc_fd){
	var variables='diploma='+document.getElementById('diploma').value;
	variables=variables+'&nombre_completo='+document.getElementById('nombre_completo').value;
	variables=variables+'&fecha_imp='+document.getElementById('fecha_imp').value;
	variables=variables+'&RUT='+document.getElementById('RUT').value;
	variables=variables+'&form_id='+document.getElementById('form_id').value;
	variables=variables+'&valor_programa='+document.getElementById('valor_programa').value;
	
	variables=variables+'&moneda='+document.getElementById('moneda').value;
	
	variables=variables+'&NACIONALIDAD='+document.getElementById('NACIONALIDAD').value;
	variables=variables+'&fecha_inicio='+document.getElementById('ini_programa').value;
	variables=variables+'&ini_programa='+document.getElementById('ini_programa').value;
	
	
	variables=variables+'&direc_particular='+document.getElementById('DIREC_PARTICULAR').value;
	variables=variables+'&carrera_pro='+document.getElementById('CARRERA_PRO').value;
	
	variables=variables+'&email='+document.getElementById('email').value;
	variables=variables+'&cod_diploma='+document.getElementById('cod_diploma').value;
	
	variables=variables+'&titulo_decano='+document.getElementById('titulo_decano').value;
	variables=variables+'&rut_decano='+document.getElementById('rut_decano').value;
	variables=variables+'&nombre_decano='+document.getElementById('nombre_decano').value;
	
	
	
	var opciones = document.getElementsByName("quien_paga");
	
	for(var i=0; i<opciones.length; i++) {	
	  if(opciones[i].checked) {
	    variables=variables+'&quien_paga='+opciones[i].value;
	    break;
	  }
	}
	variables=variables+'&descuento_su_empresa='+document.getElementById('descuento_su_empresa').value;
	variables=variables+'&descuento_alum_empresa='+document.getElementById('descuento_alum_empresa').value;
	variables=variables+'&doc_fd='+doc_fd;
	
	
	
	//if(confirm(variables)){
	
if(doc_fd=='cs'){
	setTimeout("actualiza('fd_cs','postulacion/admision/g_documentos/contratos/contrato_prestacion_servicio_firma_digital.php', '"+variables+"')",500);
}
if(doc_fd=='dj'){
	setTimeout("actualiza('fd_dj', 'postulacion/admision/firma_digital/declaracion_df.php', '"+variables+"')",1000);	
}
	
	
	
	
	setTimeout("actualiza('fd_up', 'postulacion/admision/firma_digital/upload_documentos.php', '"+variables+"')",1500);	
	
	
	//}

	
	
}