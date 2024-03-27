<?php
session_start();
include_once('C:/laragon/www/form/dashboard/dist/include/header.php');
include("functions_program.php");
$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];

//si recibimos un programa base lo obtenemos y le hacemos explode para obtener su array
if(isset($_POST["programa_base"])){

    //data con todos los datos obtenidos de la base sin modificar
    $programa_base = $_POST["programa_base"];
    $programa_base = explode('|', $programa_base);

    $new_data_update = array();

    //Nos aseguramos de que el periodo si se cambio $Periodo mantenga el valor que se desea mantener o actualizar
    $Periodo = $programa_base[4];
    if(isset($_POST['periodo']) && $Periodo != $_POST['periodo']){
        $Periodo = $_POST['periodo'];
    }
    if($Periodo == ''){
        $Periodo = NULL;
    }
    $new_data_update['Periodo'] = $Periodo;

    //Nos aseguramos de que el horario/jornada si se cambio $Horario mantenga el valor que se desea mantener o actualizar
    $Horario = $programa_base[5];
    if(isset($_POST['jornada']) && $Horario != $_POST['jornada']){
        $Horario = $_POST['jornada'];
    }
    if($Horario == ''){
        $Horario = NULL;
    }
    $new_data_update['jornada'] = $Horario;
    
    
    //Nos aseguramos de que la version si se cambio $Version mantenga el valor que se desea mantener o actualizar
    $Version = $programa_base[9];
    if(isset($_POST['version']) && $Version != $_POST['version']){
        $Version = $_POST['version'];
    }
    $new_data_update['version'] = $Version;

    $Modalidad = $programa_base[3];
    if(isset($_POST['modalidad']) && $Modalidad != $_POST['modalidad']){
        $Modalidad = $_POST['modalidad'];
    }
    if($Modalidad == ''){
        $Modalidad = NULL;
    }
    $new_data_update['modalidad_programa'] = $Modalidad;

    //Nos aseguramos de que el nombre y el tipo si se cambio $Nombre_Programa y $Tipo_Programa
    // mantenga el valor que se desea mantener o actualizar
    $Nombre_Programa = $programa_base[0];
    $Tipo_Programa = $programa_base[1];
    $Siglas = $programa_base[10];
    $Codigo_Programa = $programa_base[11];
    $DIPLOMADO = $programa_base[13];
    $name = '';
    for($i = 0; $i < strlen($Nombre_Programa); $i++){
        //si estamos en un espacio en blano y viene un - quiere decir que todo lo anterior
        //es el nombre del programa y lo que viene es el código del diploma.
        if($Nombre_Programa[$i] == ' ' && $Nombre_Programa[$i+1] == '-'){
            break;
        } else{
            //en otro caso debemos copiar el nombre 
            $name .= $Nombre_Programa[$i]; 
        }
    }
    $Nombre_Programa = $name;
    //Comparamos ambos nombres, si es que son diferentes
    if(isset($_POST['nombre_program']) && $name != $_POST['nombre_program']){
        $Nombre_Programa = $_POST['nombre_program'];
        $Siglas = generate_siglas($Nombre_Programa, $conectores);
        $Codigo_Programa = generate_cod_diploma($Siglas, $Periodo, $Horario, $Version);

        if(isset($_POST['tipo'])){
            $tipo = $_POST['tipo'];

            if($Tipo_Programa != $tipo){
                $Tipo_Programa = $tipo;
            }
        }
        $DIPLOMADO = generate_DIPLOMADO($Nombre_Programa, $Tipo_Programa);

    }
    $conducente = false;

    if($Tipo_Programa == 'Curso'){
        if(isset($_POST['curso_conducente_box'])){
            if($_POST['curso_conducente_box'] == 'Conducente'){
                $conducente = true;
            }
        }
    }
    if($DIPLOMADO == ''){
        $DIPLOMADO = NULL;
    }
    if($Tipo_Programa ==''){
        $Tipo_Programa = NULL;
    }
    if($Siglas == ''){
        $Siglas = NULL;
    }
    $Tipo = generate_tipo_programa($Tipo_Programa,$Modalidad, $conducente);
    $nom_diploma = generate_nom_diploma($Nombre_Programa, $Codigo_Programa);
    if($nom_diploma == ''){
        $nom_diploma =NULL;
    }
    //Asignamos a los datos nuevos lo que queremos actualizar
    $new_data_update['DIPLOMADO'] = $DIPLOMADO;
    $new_data_update['tipo_programa'] = $Tipo_Programa;
    $new_data_update['tipo'] = $Tipo;
    $new_data_update['codcatedraab'] = $Siglas;
    $new_data_update['cod_diploma'] = $Codigo_Programa;
    $new_data_update['nom_diploma'] = $nom_diploma;

    
    $Area_Conocimiento = $programa_base[2];
    $Area = generate_area($Area_Conocimiento);
    if(isset($_POST['area']) && $Area_Conocimiento != $_POST['area']){
        $Area_Conocimiento = $_POST['area'];
        $Area = generate_area($_POST['area']);
    }
    $new_data_update['area_conocimiento'] = $Area_Conocimiento;
    $new_data_update['area'] = $Area;

    
    $Nivel = $programa_base[6];
    if(isset($_POST['nivel']) && $Nivel != $_POST['nivel']){
        $Nivel = $_POST['nivel'];
    }
    if($Nivel == ''){
        $Nivel = NULL;
    }
    $new_data_update['nivel'] = $Nivel;
    
    $Realizacion = $programa_base[7];
    if(isset($_POST['realizacion_en']) && $Realizacion != $_POST['realizacion_en']){
        $Realizacion = $_POST['realizacion_en'];
    }
    if($Realizacion == ''){
        $Realizacion =NULL;
    }
    $new_data_update['realizacion_en'] = $Realizacion;

    $Fecha_Inicio = $programa_base[8];
    if(isset($_POST['fecha_de_inicio']) && $Fecha_Inicio != $_POST['fecha_de_inicio']){
        $Fecha_Inicio = $_POST['fecha_de_inicio'];
    }
    if($Fecha_Inicio == ''){
        $Fecha_Inicio = NULL;
    }
    $new_data_update['fecha_inicio'] = $Fecha_Inicio;

    $Area_Negocios = $programa_base[12];
    if($Area_Negocios == ''){
        $Area_Negocios = NULL;
    }
    $new_data_update['area_negocios'] = $Area_Negocios;
    
    $Habilitado = $programa_base[15];
    if(isset($_POST['habilitado']) && $Habilitado != $_POST['habilitado']){
        $Habilitado = $_POST['habilitado'];
    }
    if($Habilitado == ''){
        $Habilitado == 1;
    }
    $new_data_update['habilitado'] = $Habilitado;

    $Habilitado_web = $programa_base[16];
    if(isset($_POST['web_habilitado']) && $Habilitado_web != $_POST['web_habilitado']){
        $Habilitado_web = $_POST['web_habilitado'];
    }
    if($Habilitado_web == ''){
        $Habilitado_web == 0;
    }
    $new_data_update['web_habilitado'] = $Habilitado_web;
    
    $Horario_Web = $programa_base[18];
    if(isset($_POST['horario_web']) && $Horario_Web != $_POST['horario_web']){
        $Horario_Web = $_POST['horario_web'];
    }
    $new_data_update['horario_web'] = $Horario_Web;
    
    $Vacantes = $programa_base[20];
    if(isset($_POST['vacantes']) && $Vacantes != $_POST['vacantes']){
        $Vacantes = $_POST['vacantes'];
    }
    if($Vacantes == ''){
        $Vacantes = NULL;
    }
    $new_data_update['vacantes'] = $Vacantes;

    $Nombre_Web = $programa_base[24];
    if(isset($_POST['nombre_web']) && $Nombre_Web != $_POST['nombre_web']){
        $Nombre_Web = $_POST['nombre_web'];
    }
    if($Nombre_Web == ''){
        $Nombre_Web = NULL;
    }
    $new_data_update['nombre_web'] = $Nombre_Web;

    $ID_DA = $programa_base[25];
    if(isset($_POST['id_director_academico']) && $ID_DA != $_POST['id_director_academico']){
        $ID_DA = $_POST['id_director_academico'];
    }
    if($ID_DA == ''){
        $ID_DA = NULL;
    }
    $new_data_update['id_DA'] = $ID_DA;
    
    $Director = $programa_base[26];
    if(isset($_POST['nombre_director_academico']) && $Director != $_POST['nombre_director_academico']){
        $Director = $_POST['nombre_director_academico'];
    }
    if($Director == ''){
        $Director = NULL;
    }
    $new_data_update['Director'] = $Director;

    $Email_Director = $programa_base[27];
    if(isset($_POST['email_director_academico']) && $Email_Director != $_POST['email_director_academico']){
        $Email_Director = $_POST['email_director_academico'];
    }
    if($Email_Director == ''){
        $Email_Director = NULL;
    }
    $new_data_update['emailDirector'] = $Email_Director;
    
    $Token  = $programa_base[28];
    if($Token == ''){
        $Token = NULL;
    }
    $new_data_update['token'] = $Token;

    $Nombre_Coordinador_Docente = $programa_base[29];
    if(isset($_POST['nombre_cordinador_docente']) && $Nombre_Coordinador_Docente != $_POST['nombre_cordinador_docente']){
        $Nombre_Coordinador_Docente = $_POST['nombre_cordinador_docente'];
    }
    if($Nombre_Coordinador_Docente == ''){
        $Nombre_Coordinador_Docente = NULL;
    }
    $new_data_update['nombre_cordinador_curso'] = $Nombre_Coordinador_Docente;

    $ID_Coordinador_Docente = $programa_base[30];
    if(isset($_POST['usr_cordinador_docente']) && $ID_Coordinador_Docente != $_POST['usr_cordinador_docente']){
        $ID_Coordinador_Docente = $_POST['usr_cordinador_docente'];
    }
    if($ID_Coordinador_Docente == ''){
        $ID_Coordinador_Docente = NULL;
    }
    $new_data_update['usr_cordinador_curso'] = $ID_Coordinador_Docente;

    $Email_Coordinador_Docente = $programa_base[31];
    if(isset($_POST['email_cordinador_docente']) && $Email_Coordinador_Docente != $_POST['email_cordinador_docente']){
        $Email_Coordinador_Docente = $_POST['email_cordinador_docente'];
    }
    if($Email_Coordinador_Docente == ''){
        $Email_Coordinador_Docente = NULL;
    }
    $new_data_update['email_cordinador_curso'] = $Email_Coordinador_Docente;

    $Telefono_Coordinador_Docente = $programa_base[32];
    if(isset($_POST['telefono_cordinador_docente']) && $Telefono_Coordinador_Docente != $_POST['telefono_cordinador_docente']){
        $Telefono_Coordinador_Docente = $_POST['telefono_cordinador_docente'];
    }
    if($Telefono_Coordinador_Docente == ''){
        $Telefono_Coordinador_Docente = NULL;
    }
    $new_data_update['telefono_cordinador_curso'] = $Telefono_Coordinador_Docente;
    
    $Valor_Programa = $programa_base[33];
    if(isset($_POST['valor_diplomado']) && $Valor_Programa != $_POST['valor_diplomado']){
        $Valor_Programa = $_POST['valor_diplomado'];
    }
    if($Valor_Programa == ''){
        $Valor_Programa = NULL;
    }
    $new_data_update['valor_diplomado'] = $Valor_Programa;
    
    $Tipo_Moneda =  $programa_base[34];
    if(isset($_POST['moneda']) && $Tipo_Moneda != $_POST['moneda']){
        $Tipo_Moneda = $_POST['moneda'];
    }
    if($Tipo_Moneda == ''){
        $Tipo_Moneda = NULL;
    }
    $new_data_update['moneda'] = $Tipo_Moneda;

    $Fecha_Termino = $programa_base[35];
    if(isset($_POST['fecha_de_termino']) && $Fecha_Termino != $_POST['fecha_de_termino']){
        $Fecha_Termino = $_POST['fecha_de_termino'];
    }
    if($Fecha_Termino == ''){
        $Fecha_Termino = NULL;
    }
    $new_data_update['fecha_termino'] = $Fecha_Termino;

    $Horas = $programa_base[36];
    if(isset($_POST['hora_totales']) && $Horas != $_POST['hora_totales']){
        $Horas = $_POST['hora_totales'];
    }
    if($Horas == ''){
        $Horas = NULL;
    }
    $new_data_update['horas'] = $Horas;

    $Horas_Online = $programa_base[37];
    if(isset($_POST['hora_online']) && $Horas_Online != $_POST['hora_online']){
        $Horas_Online = $_POST['hora_online'];
    }
    if($Horas_Online == ''){
        $Horas_Online = NULL;
    }
    $new_data_update['horas_online'] = $Horas_Online;

    $Horas_Pedagogicas = $programa_base[38];
    if(isset($_POST['hora_pedagogicas']) && $Horas_Pedagogicas != $_POST['hora_pedagogicas']){
        $Horas_Pedagogicas = $_POST['hora_pedagogicas'];
    }
    if($Horas_Pedagogicas == ''){
        $Horas_Pedagogicas = NULL;
    }
    $new_data_update['hrs_pedagogicas'] = $Horas_Pedagogicas;

    $Hora_Inicio = $programa_base[39];
    if(isset($_POST['hora_inicio']) && $Hora_Inicio != $_POST['hora_inicio']){
        $Hora_Inicio = $_POST['hora_inicio'];
    }
    if($Hora_Inicio == ''){
        $Hora_Inicio = NULL;
    }
    $new_data_update['hora_inicio'] = $Hora_Inicio;

    $Hora_Termino = $programa_base[40];
    if(isset($_POST['hora_final'])  && $Hora_Termino != $_POST['hora_final']){
        $Hora_Termino = $_POST['hora_final'];
    } 
    if($Hora_Termino == ''){
        $Hora_Termino = NULL;
    }
    $new_data_update['hora_termino'] = $Hora_Termino;

    $Meta = $programa_base[41];
    if(isset($_POST['meta']) && $Meta != $_POST['meta']){
        $Meta = $_POST['meta'];
    }
    if($Meta == ''){
        $Meta = NULL;
    }
    $new_data_update['meta'] = $Meta;

    $Valor_Meta = $programa_base[42];
    if(isset($_POST['valor_meta']) && $Valor_Meta != $_POST['valor_meta']){
        $Valor_Meta = $_POST['valor_meta'];
    }
    if($Valor_Meta == ''){
        $Valor_Meta = NULL;
    }
    $new_data_update['valor_meta'] = $Valor_Meta;

    $Dias = $programa_base[43];
    if($Dias == ''){
        $Dias = NULL;
    }
    $new_data_update['dias'] =  $Dias;
    
    $ID_Ejecutivo_Admision = $programa_base[44];
    if(isset(   $_POST['usr_cordinador_ejecutivo']) && 
                $ID_Ejecutivo_Admision != $_POST['usr_cordinador_ejecutivo']){
        $ID_Ejecutivo_Admision = $_POST['usr_cordinador_ejecutivo'];
    }
    if($ID_Ejecutivo_Admision == ''){
        $ID_Ejecutivo_Admision = NULL;
    }
    $new_data_update['usr_cordinador_ad'] = $ID_Ejecutivo_Admision;

    $Nombre_Ejecutivo_Admision = $programa_base[45];
    if(isset( $_POST['nombre_cordinador_ejecutivo']) && $Nombre_Ejecutivo_Admision != $_POST['nombre_cordinador_ejecutivo']){
        $Nombre_Ejecutivo_Admision = $_POST['nombre_cordinador_ejecutivo'];
    }
    if($Nombre_Ejecutivo_Admision == ''){
        $Nombre_Ejecutivo_Admision = NULL;
    }
    $new_data_update['nom_cordinadora_admision'] = $Nombre_Ejecutivo_Admision;

    $Telefono_ejecutivo_admision = $programa_base[46];
    if(isset( $_POST['telefono_cordinador_ejecutivo']) && $Telefono_ejecutivo_admision != $_POST['telefono_cordinador_ejecutivo']){
        $Telefono_ejecutivo_admision = $_POST['telefono_cordinador_ejecutivo'];
    }
    if($Telefono_ejecutivo_admision == ''){
        $Telefono_ejecutivo_admision = NULL;
    }
    $new_data_update['telefono_cordinadora_admision'] = $Telefono_ejecutivo_admision;

    $Mail_Envio = $programa_base[14];
    if(isset( $_POST['email_cordinador_ejecutivo']) && $Mail_Envio != $_POST['email_cordinador_ejecutivo']){
            $Mail_Envio = $_POST['email_cordinador_ejecutivo'];
    }
    $new_data_update['mail_envio'] = $Mail_Envio;
    
    $Link_PDF = $programa_base[47];
    if($Link_PDF == ''){
        $Link_PDF = NULL;
    }
    $new_data_update['lnk_pdf'] = $Link_PDF;

    $Codigo_Sala = $programa_base[48];
    if(isset($_POST['cod_sala']) && $_POST['cod_sala'] != $Codigo_Sala){
        $Codigo_Sala = $_POST['cod_sala'];
    }
    if($Codigo_Sala == ''){
        $Codigo_Sala = NULL;
    }
    $new_data_update['cod_sala'] = $Codigo_Sala;

    $Secretaria = $programa_base[49];
    if(isset($_POST['id_secretaria']) && $_POST['id_secretaria'] != $Secretaria){
        $Secretaria = $_POST['id_secretaria'];
    }
    if($Secretaria == ''){
        $Secretaria = NULL;
    }
    $new_data_update['secretaria'] = $Secretaria;
    
    $Sala_Cafe = $programa_base[50];
    if(isset($_POST['sala_cafe']) && $_POST['sala_cafe'] != $Sala_Cafe){
        $Sala_Cafe = $_POST['sala_cafe'];
    }
    if($Sala_Cafe == ''){
        $Sala_Cafe = NULL;
    }
    $new_data_update['sala_cafe'] = $Sala_Cafe;

    $In_Coffee = $programa_base[51];
    if($In_Coffee == ''){
        $In_Coffee = NULL;
    }
    $new_data_update['in_coffe'] = $In_Coffee;
    
    $Uso_pcs = $programa_base[52];
    if(isset($_POST['pc']) && $_POST['pc'] != $Uso_pcs){
        $Uso_pcs = $_POST['pc'];
    }
    if($Uso_pcs == ''){
        $Uso_pcs = NULL;
    }
    $new_data_update['uso_pcs'] = $Uso_pcs;

    $Nivelacion = $programa_base[53];
    if(isset($_POST['nivelacion']) && $_POST['nivelacion'] != $Nivelacion){
        $Nivelacion = $_POST['nivelacion'];
    }
    if($Nivelacion == ''){
        $Nivelacion = NULL;
    }
    $new_data_update['nivelacion'] = $Nivelacion;
    
    $Introduccion = $programa_base[54];
    if(isset($_POST['intro_DA']) && $_POST['intro_DA'] != $Introduccion){
        $Introduccion = $_POST['intro_DA'];
    }
    if($Introduccion == ''){
        $Introduccion = NULL;
    }
    $new_data_update['intro_DA'] = $Introduccion;

    $Cierre = $programa_base[55];
    if(isset($_POST['cierre']) && $_POST['cierre'] != $Cierre){
        $Cierre = $_POST['cierre'];
    }
    if($Cierre == ''){
        $Cierre = NULL;
    }
    $new_data_update['cierre'] = $Cierre;
    
    //****
    $Encuesta = $programa_base[56];
    if(isset($_POST['encuesta']) && $_POST['encuesta'] != $Encuesta){
        $Encuesta = $_POST['encuesta'];
    }
    if($Encuesta == ''){
        $Encuesta = NULL;
    }
    $new_data_update['encuesta'] = $Encuesta;

    $Reglamento = $programa_base[61];
    if(isset($_POST['reglamento']) && $_POST['reglamento'] != $Reglamento){
        $Reglamento = $_POST['reglamento'];
    }
    if($Reglamento == ''){
        $Reglamento = NULL;
    }
    $new_data_update['reglamento'] = $Reglamento;

    $Usr_Coordinador_Comercial = $programa_base[58];
    if(isset($_POST['usr_coordinador_comercial']) && $Usr_Coordinador_Comercial != $_POST['usr_coordinador_comercial']){
        $Usr_Coordinador_Comercial = $_POST['usr_coordinador_comercial'];
    }
    if($Usr_Coordinador_Comercial == ''){
        $Usr_Coordinador_Comercial = NULL;
    } 
    $new_data_update['usr_coordinador_comercial'] = $Usr_Coordinador_Comercial;
    
    $Usr_Consultor_Corporativo = $programa_base[59];
    if($Usr_Consultor_Corporativo == ''){
        $Usr_Consultor_Corporativo = NULL;
    }
    $new_data_update['usr_consultor_corp'] = $Usr_Consultor_Corporativo;
    
    $Marca = $programa_base[17];
    if($Marca == ''){
        $Marca = 0;
    }
    $new_data_update['marca'] = $Marca;

    $Id_Programa = $programa_base[21];
    $new_data_update['ID_DIPLOMA'] = $Id_Programa;

    $Codigo_Interno = $programa_base[22];
    if(isset($_POST['cod_interno']) && $Codigo_Interno != $_POST['cod_interno']){
        $Codigo_Interno = $_POST['cod_interno'];
    }
    if($Codigo_Interno == ''){
        $Codigo_Interno = NULL;
    }
    $new_data_update['Cod_interno'] = $Codigo_Interno;

    $ORDEN = $programa_base[23];
    if($ORDEN == ''){
        $ORDEN =  NULL;
    }
    $new_data_update['orden'] = $ORDEN;

    $Codigo_AUGE = $programa_base[57];
    if($Codigo_AUGE == ''){
        $Codigo_AUGE = NULL;
    }
    $new_data_update['cod_AUGE'] = $Codigo_AUGE;

    $ID_ORDEN = $programa_base[60];
    if($ID_ORDEN ==''){
        $ID_ORDEN = "0";
    }
    $new_data_update['ID_ORDEN'] = $ID_ORDEN;


    $update_data_JSON = json_encode($new_data_update, JSON_UNESCAPED_UNICODE);
    update_data($update_data_JSON);
}
?>

<div class="container-fluid">
    <h1 class="mt-4">Editar Programas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Programa Editado</li>
        </ol>
        <div id = "resultado_post_program">
            <h3>
                El programa fue editado exitosamente
            </h3>
        </div>
        <div id = "volver al menu principal">
            <a href = "diplomados.php">
                Volver al menu Principal
            </a>    
        </div>
</div>
<?php
    if(true){
        #se cargo correctamente el programa en la base de datos
        ?>
        <script>
            var parrafo = document.createElement("p");
            parrafo.body.appendChild("Programa Cargado correctamente");
            document.getElementById("resultado_post_program").appendChild(parrafo);
        </script>
        <?php
    }

include_once('C:\laragon\www\form\dashboard\dist\include\footer.php');
?>