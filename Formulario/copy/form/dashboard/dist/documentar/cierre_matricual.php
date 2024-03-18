<?php

session_start();
$usr=$_SESSION["usuario"];


if(isset($_REQUEST['id_postulacion']) && isset($_REQUEST['accion'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
    $accion = $_REQUEST['accion'];

}else{
    echo 'Error';
    exit();
}

include('../../cn/cn_PDO.php');

//-----------------------------
// Cambio estado postulacion
//-----------------------------

if($accion == 'pendiente_cierre'){
    $etapa=31;
    $estado=31;

    $sql="UPDATE unegocios_nuevo.postulacion 
    SET
        etapa=$etapa,
        estado=$estado
    WHERE id_postulacion=$id_postulacion";
    
}elseif($accion == 'cierre_matricula'){
    $etapa=30;
    $estado=30;

    $sql="UPDATE unegocios_nuevo.postulacion
    SET
        etapa=$etapa,
        estado=$estado
    WHERE id_postulacion=$id_postulacion";
    
}



$stmt = $con->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

//-----------------------------
// registr LOG de estado
//-----------------------------
$sql_log = "INSERT INTO intranet.postulacion_estado
		(
			idpostulacion,
			etapa,
			estado,
			fecha_in,
			usuario
		)VALUES(
			".$id_postulacion.",
			".$etapa.",
			".$estado.",
			NOW(),
			'".$usr."')";
    
//echo '<pre>'.$sql_log.'</pre>';

$stmt = $con->prepare($sql_log);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
            
//-----------------------------
// Insert registro Matriculados
//-----------------------------
$sql_existe="SELECT m.ID_POSTULACION
    FROM 
        intranet.matriculados m
    WHERE 
        m.ID_POSTULACION =".$id_postulacion;

$stmt_existe = $con->prepare($sql_existe);
$stmt_existe->setFetchMode(PDO::FETCH_ASSOC);
$stmt_existe->execute();
$totalRows_existe=$stmt_existe->rowCount();

if ($row_rs_matriculados = $stmt_existe->fetch()){

    $sql_in_matriculados="UPDATE  intranet.matriculados
    LEFT JOIN unegocios_nuevo.postulacion
    ON
        matriculados.ID_POSTULACION = postulacion.ID_POSTULACION
    SET
        matriculados.cod_diploma       = postulacion.cod_diploma,               
        matriculados.POSTULACION       = postulacion.POSTULACION,       
        matriculados.NOMBRES           = postulacion.NOMBRES,           
        matriculados.APELLIDO_PAT      = postulacion.APELLIDO_PAT,      
        matriculados.APELLIDO_MAT      = postulacion.APELLIDO_MAT,      
        matriculados.RUT               = postulacion.RUT,               
        matriculados.GENERO            = postulacion.GENERO,            
        matriculados.FECHA_NAC         = postulacion.FECHA_NAC,         
        matriculados.EMAIL             = postulacion.EMAIL,             
        matriculados.TELEFONO          = postulacion.TELEFONO,          
        matriculados.CELULAR           = postulacion.CELULAR,           
        matriculados.DIREC_PARTICULAR  = postulacion.DIREC_PARTICULAR,  
        matriculados.COMUNA            = postulacion.COMUNA,            
        matriculados.CIUDAD            = postulacion.CIUDAD,            
        matriculados.CARRERA_PRO       = postulacion.CARRERA_PRO,       
        matriculados.TituloProfesional = postulacion.TituloProfesional, 
        matriculados.UNIVERSIDAD       = postulacion.UNIVERSIDAD,       
        matriculados.EX_ALUMNO         = postulacion.EX_ALUMNO,         
        matriculados.RAZON_SOCIAL      = postulacion.RAZON_SOCIAL,      
        matriculados.CARGO             = postulacion.CARGO,             
        matriculados.EXPERIENCIA       = postulacion.EXPERIENCIA,       
        matriculados.TELEFONO_OF       = postulacion.TELEFONO_OF,       
        matriculados.DIRECCION_COM     = postulacion.DIRECCION_COM,     
        matriculados.MOTIVACION_ESTUDIO= postulacion.MOTIVACION_ESTUDIO,
        matriculados.ID_FINANCIAMIENTO = postulacion.ID_FINANCIAMIENTO, 
        matriculados.EJECUTIVO_CONTACTO= postulacion.EJECUTIVO_CONTACTO,
        matriculados.CV                = postulacion.CV,                
        matriculados.FECHA_POST        = postulacion.FECHA_POST,        
        matriculados.NACIONALIDAD      = postulacion.NACIONALIDAD,      
        matriculados.etapa             = postulacion.etapa,             
        matriculados.estado            = postulacion.estado,            
        matriculados.observaciones     = postulacion.observaciones,     
        matriculados.reglamento        = postulacion.reglamento,        
        matriculados.magister          = postulacion.magister,          
        matriculados.nivel_escolaridad = postulacion.nivel_escolaridad, 
        matriculados.Periodo           = postulacion.periodo 
    WHERE
        postulacion.ID_POSTULACION = ".$id_postulacion;

    $stmt = $con->prepare($sql_in_matriculados);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

        echo 'Matricula actualizada';

}else{

    $sql_in_matriculados="INSERT INTO intranet.matriculados
    (
        ID_POSTULACION,
        cod_diploma,
        POSTULACION,
        NOMBRES,
        APELLIDO_PAT,
        APELLIDO_MAT,
        RUT,
        GENERO,
        FECHA_NAC,
        EMAIL,
        TELEFONO,
        CELULAR,
        DIREC_PARTICULAR,
        COMUNA,
        CIUDAD,
        CARRERA_PRO,
        TituloProfesional,
        UNIVERSIDAD,
        EX_ALUMNO,
        RAZON_SOCIAL,
        INDUSTRIA,
        CARGO,
        EXPERIENCIA,
        TELEFONO_OF,
        DIRECCION_COM,
        MOTIVACION_ESTUDIO,
        ID_FINANCIAMIENTO,
        EJECUTIVO_CONTACTO,
        CV,
        FECHA_POST,
        NACIONALIDAD,
        etapa,
        estado,
        observaciones,
        reglamento,
        magister,
        nivel_escolaridad,
        Periodo
    )
    SELECT
        ID_POSTULACION,
        cod_diploma,
        POSTULACION,
        NOMBRES,
        APELLIDO_PAT,
        APELLIDO_MAT,
        RUT,
        GENERO,
        FECHA_NAC,
        EMAIL,
        TELEFONO,
        CELULAR,
        DIREC_PARTICULAR,
        COMUNA,
        CIUDAD,
        CARRERA_PRO,
        TituloProfesional,
        UNIVERSIDAD,
        EX_ALUMNO,
        RAZON_SOCIAL,
        '',
        CARGO,
        EXPERIENCIA,
        TELEFONO_OF,
        DIRECCION_COM,
        MOTIVACION_ESTUDIO,
        ID_FINANCIAMIENTO,
        EJECUTIVO_CONTACTO,
        CV,
        FECHA_POST,
        NACIONALIDAD,
        etapa,
        estado,
        observaciones,
        reglamento,
        magister,
        nivel_escolaridad,
        periodo

    FROM unegocios_nuevo.postulacion p
    WHERE
        p.ID_POSTULACION=$id_postulacion
    ";


    //echo '<pre>'.$sql_in_matriculados.'</pre>';

    $stmt = $con->prepare($sql_in_matriculados);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    $id_matriculado = $con->lastInsertId();
    if($id_matriculado<>''){
        echo 'Alumno Matricualdo';
    }else{
        echo 'Error al cerrar Alumno Matricualdo';
    }

}
//-----------------------------------------------------------------------
// Insert registro Sistema Gestion Docente (SGD - clases.unegocios.cl)
//-----------------------------------------------------------------------


//-------------------------------
// EMAIL DE BIENVENIDA
//-----------------------------

$sql_datos="SELECT
    p.POSTULACION,
    p.`NOMBRES`,
    p.`APELLIDO_PAT`,
    p.`APELLIDO_MAT`,
    p.`GENERO`,
    p.`EMAIL`,
    d.nombre_cordinador_curso,
    d.email_cordinador_curso,
    d.tipo,
    concat(d.tipo_programa,' ',d.modalidad_programa) AS tipo_modalidad_programa,
    ev.email_bievenida_fecha,
    if(NOW()<=DATE_ADD(d.fecha_inicio, INTERVAL 15 DAY),'si','no') enviar
FROM 
    `unegocios_nuevo`.`postulacion` p 
    left join intranet.diplomados d on p.cod_diploma=d.cod_diploma
    left join intranet.email_enviados ev on ev.id_postulacion=p.ID_POSTULACION
where 
    p.ID_POSTULACION=".$id_postulacion;
//echo $sql_datos.'<p>';


$stmt_datos = $con->prepare($sql_datos);
$stmt_datos ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_datos ->execute();
$num_datos =$stmt_datos ->rowCount();	


if ($row_rs_datos  = $stmt_datos ->fetch()){

    $email_bievenida_fecha   = $row_rs_datos['email_bievenida_fecha'];
    $enviar                  = $row_rs_datos['enviar'];
    $tipo                    = $row_rs_datos['tipo'];
    $tipo_modalidad_programa = $row_rs_datos['tipo_modalidad_programa'];

    $programa = $row_rs_datos['POSTULACION'];
    $nombre = $row_rs_datos['NOMBRES'];

    $email = $row_rs_datos['EMAIL'];

}



if($email_bievenida_fecha == '' && $enviar == 'si'){

    if($tipo == 'B-Learing'){
    /* EMAIL DE BIENVENIDA */

    $url = 'https://intranet.unegocios.cl/apps/cdg/postulacion/admision/documentar/email_bienvenida.php';
    $data = array('form_id=' => $id_postulacion);

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
        )
        ,
        "ssl"=>array(
            "allow_self_signed"=>true,
            "verify_peer"=>false,
            "verify_peer_name"=>false
        )
    );


    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);


    /***/	
        $sql_in_email_enviados="INSERT INTO intranet.email_enviados (id_postulacion, email_bievenida_fecha, email_bievenida_destinatario
        )VALUES(
        '".$id_postulacion."',NOW(),'".$email."'
        ) 
        ";
        //echo '<pre>'.$sql_in_email_enviados.'</pre>';
        $stmt_in_email_enviados = $con->prepare($sql_in_email_enviados);
        $stmt_in_email_enviados ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_in_email_enviados ->execute();
    }



    if($tipo=='Diploma' || $tipo=='Curso conducente' || $tipo=='Curso' || $tipo=='Taller'){
        $texto_diploma="<p>Queremos comentarte que unos d&iacute;as antes del inicio del programa, el/la coordinador/a acad&eacute;mico/a, se contactar&aacute; contigo v&iacute;a correo electr&oacute;nico, enviando informaci&oacute;n relevante y recordatoria sobre el inicio de clases, sala, horarios, entre otros temas de inter&eacute;s. 
        </p>";
        
    }else{
        $texto_diploma="";	
    }

    $texto_beca='';
    if($tipo_modalidad_programa=='Diploma Presencial'){
        $texto_beca='<p>Te comento que ya cuentas con una beca de un 50% de descuento, beneficio que puedes utilizar en un segundo Diplomado presencial de Unegocios. Este beneficio es v&aacute;lido para dar continuidad en tu desarrollo profesional, ya que se hace efectivo s&oacute;lo en inscripciones del mismo semestre cursado o bien el semestre inmediatamente siguiente.</p>';
    }

    //------------------------------------------
    // EMAIL Bienvenida
    //------------------------------------------
    $redes_sociales='<p>S&iacute;guenos en nuestras redes sociales:<br />
    <a href="https://www.linkedin.com/company/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/linkedin.png" alt="linkedin" title="linkedin" /></a> 
    <a href="https://twitter.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/tweeter.png" alt="twitter" title="twitter" /></a> 
    <a href="https://www.facebook.com/unegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/facebook.png" alt="facebook" title="facebook" /></a> 
    <a href="https://www.youtube.com/user/TvUnegocios" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/youtube.png" alt="youtube" title="youtube" /></a> 
    <a href="https://www.instagram.com/unegocios/" target="_blank"><img src="http://intranet.unegocios.cl/img/logomail/instagram.png" alt="instagram" title="instagram" /></a> 
    </p>';

    $msj="<p>Estimado(a) ".$nombre.",</p>
    <p>Te damos la bienvenida a Unegocios de la Facultad de Econom&iacute;a y Negocios de la Universidad de Chile.</p>
    <p>Desde hoy, formas parte de una comunidad, que se propone enriquecer el desarrollo de las organizaciones, a trav&eacute;s de los conceptos y pr&aacute;cticas relevantes en el mundo actual.</p>
    <p>
    Buscamos fortalecer las competencias necesarias en las personas, en los distintos niveles de su carrera laboral, para marcar la diferencia en el &aacute;mbito de los negocios.</p>
    <p>Como instituci&oacute;n, nos caracterizamos por reflexionar acerca del quehacer de las organizaciones, en el marco de una propuesta de valor robusta, que abra posibilidades, genere crecimiento, y permita el desarrollo en todas sus formas.</p>
    ".$texto_beca."
    <p>Te damos la m&aacute;s c&aacute;lida y cordial bienvenida, y esperamos que aproveches al m&aacute;ximo esta experiencia de aprendizaje.</p>
    ".$texto_diploma."
    <p>Un cari&ntilde;oso saludo,</p>
    <p>Equipo UNEGOCIOS<br />
    <strong>FEN, Universidad de Chile</strong></p>
    <br />
    <br />
    ".$redes_sociales."
    <p style='color:#666'><small>Por favor no responder este correo ya que se env&iacute;a de una casilla gen&eacute;rica.</small> </p>
    ";

    //echo $msj;
    //exit;


    $destinatiario	=$email;
    $asunto			="Bienvenida UNEGOCIOS - ".$programa;
        
    $email_cordinador_curso		=	'no_reply@unegocios.cl';//$row_rs_datos['email_cordinador_curso'];
    $nombre_cordinador_curso	=	'Unegocios';//$row_rs_datos['nombre_cordinador_curso'];
    if($email_cordinador_curso==''){ $email_cordinador_curso="intranet@unegocios.cl"; }
    if($nombre_cordinador_curso==''){ $nombre_cordinador_curso="Intranet"; }

    $remite			=$email_cordinador_curso;
    $remitente		=$nombre_cordinador_curso;

    //DESTINATARIO
    $para  = $destinatiario; 
    // Asunto
    $titulo = $asunto;
    // Cuerpo o mensaje
    $mensaje 	="<font face=\"Arial\">".$msj."<p></font>";
    // Cabecera que especifica que es un HMTL
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Cabeceras adicionales

    $cabeceras .= "From:".$remitente."<".$remite.">". "\r\n";
    //$cabeceras .= 'Cc:""' . "\r\n";
    $cabeceras .= 'Bcc: llevio@fen.uchile.cl, fvaldes@unegocios.cl, anvilweb@live.com' . "\r\n";
    if(mail($para, $titulo, $mensaje, $cabeceras)){
        echo '<br>email enviado<br/>';
   
        $sql_in_email_enviados="INSERT INTO intranet.email_enviados (id_postulacion, email_bievenida_fecha, email_bievenida_destinatario
        )VALUES(
        '".$id_postulacion."',NOW(),'".$para."'
        ) 
        ";
        //echo '<pre>'.$sql_in_email_enviados.'</pre>';
        $stmt_in_email_enviados = $con->prepare($sql_in_email_enviados);
        $stmt_in_email_enviados ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_in_email_enviados ->execute();
    }else{
        echo '<br>Error enviar email bienvenida<br/>';
    }
}
?>