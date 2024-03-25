<?php
session_start();
include("functions_program.php");
$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];
//si recibimos un programa base lo obtenemos y le hacemos explode para obtener su array
if(isset($_POST["programa_base"])){
    $programa_base = $_POST["programa_base"];
    $programa_base = explode('|', $programa_base);

    $new_data_update = array();

    //Nos aseguramos de que el periodo si se cambio $Periodo mantenga el valor que se desea mantener o actualizar
    $Periodo = $programa_base[4];
    if(isset($_POST['periodo']) && $Periodo != $_POST['periodo']){
        $Periodo = $_POST['periodo'];
    }
    $new_data_update['Periodo'] = $Periodo;

    //Nos aseguramos de que el horario/jornada si se cambio $Horario mantenga el valor que se desea mantener o actualizar
    $Horario = $programa_base[5];
    if(isset($_POST['jornada']) && $Horario != $_POST['jornada']){
        $Horario = $_POST['jornada'];
    }
    $new_data_update['jornada'] = $Horario;
    
    //Nos aseguramos de que la version si se cambio $Version mantenga el valor que se desea mantener o actualizar
    $Version = $programa_base[9];
    if(isset($_POST['version']) && $Version != $_POST['version']){
        $Version = $_POST['version'];
    }
    $new_data_update['version'] = $Version;

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
        $Codigo_Programa = generate_cod_diploma($siglas, $Periodo, $Horario, $Version);
        $DIPLOMADO = generate_DIPLOMADO($Nombre_Programa, $$Tipo_Programa);

        if(isset($_POST['tipo'])){
            $tipo = $_POST['tipo'];

            if($Tipo_Programa != $tipo){
                $Tipo_Programa = $tipo;
            }
        }
    }

    //Asignamos a los datos nuevos lo que queremos actualizar
    $new_data_update['DIPLOMADO'] = $DIPLOMADO;
    $new_data_update['tipo_programa'] = $Tipo_Programa;
    $new_data_update['codcatedraab'] = $Siglas;
    $new_data_update['cod_diploma'] = $Codigo_Programa;
    $new_data_update['nom_diploma'] = generate_nom_diploma($Nombre_Programa, $Codigo_Programa);

    $Area_Conocimiento = $programa_base[2];
    $Area = generate_area($Area_Conocimiento);
    if(isset($_POST['area']) && $Area_Conocimiento != $_POST['area']){
        $Area_Conocimiento = $_POST['area'];
        $Area = generate_area($_POST['area']);
    }
    $new_data_update['area_conocimiento'] = $Area_Conocimiento;
    $new_data_update['area'] = $Area;

    $Modalidad = $programa_base[3];
    if(isset($_POST['modalidad']) && $Modalidad != $_POST['modalidad']){
        $Modalidad = $_POST['modalidad'];
    }
    $new_data_update['modalidad_programa'] = $Modalidad;

    $Nivel = $programa_base[6];
    if(isset($_POST['nivel']) && $Nivel != $_POST['nivel']){
        $Modalidad = $_POST['nivel'];
    }
    $new_data_update['nivel'] = $Nivel;

    $Realizacion = $programa_base[7];
    if(isset($_POST['realizacion_en']) && $Realizacion != $_POST['realizacion_en']){
        $Modalidad = $_POST['realizacion_en'];
    }
    $new_data_update['realizacion_en'] = $Realizacion;

    $Fecha_Inicio = $programa_base[8];
    if(isset($_POST['fecha_de_inicio']) && $Fecha_Inicio != $_POST['fecha_de_inicio']){
        $Modalidad = $_POST['fecha_de_inicio'];
    }
    $new_data_update['fecha_inicio'] = $Fecha_Inicio;

    $Area_Negocios = $programa_base[12];
    $new_data_update['area_negocios'] = $Area_Negocios;

    $Habilitado = $programa_base[15];
    if(isset($_POST['habilitado']) && $Habilitado != $_POST['habilitado']){
        $Habilitado = $_POST['habilitado'];
    }
    $new_data_update['habilitado'] = $Habilitado;

    $Habilitado_web = $programa_base[16];
    if(isset($_POST['web_habilitado']) && $Habilitado_web != $_POST['web_habilitado']){
        $Habilitado_web = $_POST['web_habilitado'];
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
    $new_data_update['vacantes'] = $Vacantes;

    $Nombre_Web = $programa_base[24];
    if(isset($_POST['nombre_web']) && $Nombre_Web != $_POST['nombre_web']){
        $Nombre_Web = $_POST['nombre_web'];
    }
    $new_data_update['nombre_web'] = $Nombre_Web;

    $ID_DA = $programa_base[25];
    $Director = $programa_base[26];
    $Email_Director = $programa_base[27];
    $Token  = $programa_base[28];

    $Nombre_Coordinador_Docente = $programa_base[29];
    $ID_Coordinador_Docente = $programa_base[30];
    $Email_Coordinador_Docente =    $programa_base[31];
    $Telefono_Coordinador_Docente = $programa_base[32];

    $Valor_Programa = $programa_base[33];
    if(isset($_POST['valor_diplomado']) && $Valor_Programa != $_POST['valor_diplomado']){
        $Valor_Programa = $_POST['valor_diplomado'];
    }
    $new_data_update['valor_diplomado'] = $Valor_Programa;
    
    $Tipo_Moneda =  $programa_base[34];
    if(isset($_POST['moneda']) && $Tipo_Moneda != $_POST['moneda']){
        $Tipo_Moneda = $_POST['moneda'];
    }
    $new_data_update['moneda'] = $Tipo_Moneda;

    $Fecha_Termino = $programa_base[35];
    if(isset($_POST['fecha_de_termino']) && $Fecha_Termino != $_POST['fecha_de_termino']){
        $Fecha_Termino = $_POST['fecha_de_termino'];
    }
    $new_data_update['fecha_termino'] = $Fecha_Termino;

    $Horas = $programa_base[36];
    if(isset($_POST['hora_totales']) && $Horas != $_POST['hora_totales']){
        $Horas = $_POST['hora_totales'];
    }
    $new_data_update['horas'] = $Horas;

    $Horas_Online = $programa_base[37];
    if(isset($_POST['hora_online']) && $Horas_Online != $_POST['hora_online']){
        $Horas_Online = $_POST['hora_online'];
    }
    $new_data_update['horas_onlne'] = $Horas_Online;

    $Horas_Pedagogicas = $programa_base[38];
    if(isset($_POST['hora_pedagogica']) && $Horas_Pedagogicas != $_POST['hora_pedagogica']){
        $Horas_Pedagogicas = $_POST['hora_pedagogica'];
    }
    $new_data_update['hrs_pedagogicas'] = $Horas_Pedagogicas;

    $Hora_Inicio = $programa_base[39];
    if(isset($_POST['hora_inicio']) && $Hora_Inicio != $_POST['hora_inicio']){
        $Hora_Inicio = $_POST['hora_inicio'];
    }
    $new_data_update['hora_inicio'] = $Hora_Inicio;

    $Hora_Termino = $programa_base[40];
    if(isset($_POST['hora_final'])  && $Hora_Termino != $_POST['hora_final']){
        $Hora_Termino = $_POST['hora_final'];
    } 
    $new_data_update['hora_termino'] = $Hora_Termino;

    $Meta = $programa_base[41];
    if(isset($_POST['meta']) && $Meta != $_POST['meta']){
        $Meta = $_POST['meta'];
    }
    $new_data_update['meta'] = $Meta;

    $Valor_Meta = $programa_base[42];
    if(isset($_POST['valor_meta']) && $Valor_Meta != $_POST['valor_meta']){
        $Valor_Meta = $_POST['valor_meta'];
    }

    $Dias = $programa_base[43];
    $new_data_update['dias'] =  $Dias;

    $ID_Ejecutivo_Admision = $programa_base[44];
    $Nombre_Ejecutivo_Admision = $programa_base[45];
    $Telefono_ejecutivo_admision = $programa_base[46];
    $Mail_Envio = $programa_base[14];

    $Link_PDF = $programa_base[47];
    $new_data_update['lnk_pdf'] = $Link_PDF;

    $Codigo_Sala = $programa_base[48];
    if(isset($_POST['cod_sala']) && $_POST['cod_sala'] != $Codigo_Sala){
        $Codigo_Sala = $_POST['cod_sala'];
    }
    $new_data_update['cod_sala'] = $Codigo_Sala;

    $Secretaria = $programa_base[49];
    if(isset($_POST['id_secretaria']) && $_POST['id_secretaria'] != $Secretaria){
        $Secretaria = $_POST['id_secretaria'];
    }
    $new_data_update['secretaria'] = $Secretaria;

    $Sala_Cafe = $programa_base[50];
    if(isset($_POST['sala_cafe']) && $_POST['sala_cafe'] != $Sala_Cafe){
        $Sala_Cafe = $_POST['sala_cafe'];
    }
    $new_data_update['sala_cafe'] = $Sala_Cafe;

    $In_Coffee = $programa_base[51];
    $new_data_update['in_coffe'] = $In_Coffee;

    $Uso_pcs = $programa_base[52];
    if(isset($_POST['pc']) && $_POST['pc'] != $Uso_pcs){
        $Uso_pcs = $_POST['pc'];
    }
    $new_data_update['uso_pcs'] = $Uso_pcs;

    $Nivelacion = $programa_base[53];
    if(isset($_POST['nivelacion']) && $_POST['nivelacion'] != $Nivelacion){
        $Nivelacion = $_POST['nivelacion'];
    }
    $new_data_update['nivelacion'] = $Nivelacion;

    $Introduccion = $programa_base[54];
    if(isset($_POST['intro_DA']) && $_POST['intro_DA']){
        $introduccion = $_POST['intro_DA'];
    }
    $new_data_update['intro_DA'] = $Introduccion;

    $Cierre = $programa_base[55];
    if(isset($_POST['cierre']) && $_POST['cierre'] != $Cierre){
        $Cierre = $_POST['cierre'];
    }
    $new_data_update['cierre'] = $Cierre;
    
    $Encuesta = $programa_base[56];
    if(isset($_POST['encuesta']) && $_POST['encuesta'] != $Encuesta){
        $Encuesta = $_POST['encuesta'];
    }
    $new_data_update['encuesta'] = $Encuesta;

    $Reglamento = $programa_base[61];
    if(isset($_POST['reglamento']) && $_POST['reglamento'] != $Reglamento){
        $Reglamento = $_POST['reglamento'];
    }
    $new_data_update['reglamento'] = $Reglamento;

    /*$Usr_Coordinador_Comercial = $programa_base[58];
    if(isset($_POST['usr_coordinador_comercial']) && $Usr_Coordinador_Comercial != $_POST['usr_coordinador_comercial']){
        $Usr_Coordinador_Comercial = $_POST['usr_coordinador_comercial'];
    }
    $new_data_update['usr_coordinador_comercial'] = $Usr_Coordinador_Comercial;
*/

    $Usr_Consultor_Corporativo = $programa_base[59];
    $new_data_update['usr_consultor_corp'] = $Usr_Consultor_Corporativo;

    $Marca = $programa_base[17];
    $new_data_update['marca'] = $Marca;

    $Id_Programa = $programa_base[21];
    $new_data_update['ID_DIPLOMA'] = $Id_Programa;

    $Codigo_Interno = $programa_base[22];
    $new_data_update['Cod_interno'] = $Codigo_Interno;

    $ORDEN = $programa_base[23];
    $new_data_update['orden'] = $ORDEN;

    $Codigo_AUGE = $programa_base[57];
    $new_data_update['cod_AUGE'] = $Codigo_AUGE;

    $ID_ORDEN = $programa_base[60];
    $new_data_update['ID_ORDEN'] = $ID_ORDEN;
}