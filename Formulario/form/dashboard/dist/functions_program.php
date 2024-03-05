<?php

$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];
function generate_siglas($nombre_programa, $conectores){
    $siglas = '';
    $nombre_sin_conectores = str_replace($conectores, "", $nombre_programa);

    $max_len = strlen($nombre_sin_conectores);
    for($i = 0; $i < $max_len; $i++){
        #Si primer caracter es una letra
        if($i == 0){
            if($nombre_sin_conectores[$i] != ' '){
                $siglas .= strtoupper($nombre_sin_conectores[$i]);
            }
        }
        #Si no estamos en la primera letra
        else{
            if($i+1 < $max_len - 1){
                if($i+1 == $max_len-1){
                    if($nombre_sin_conectores[$i] != ' ' and $nombre_sin_conectores[$i+1] == ' '){
                        $siglas .= strtoupper($nombre_sin_conectores[$i]);
                        break;
                    }
                }

                else{
                    if($nombre_sin_conectores[$i-1] == ' ' && $nombre_sin_conectores[$i] != ' '){
                        $siglas .= strtoupper($nombre_sin_conectores[$i]);
                    }
                }
            }
            
            else{
                if($nombre_sin_conectores[$i] != ' ' and $nombre_sin_conectores[$i-1] == ' '){
                    $siglas .= strtoupper($nombre_sin_conectores[$i]);
                    break;
                }
            }
        }
    }
    return $siglas;
}

function generate_cod_diploma($siglas, $periodo, $jornada, $version){
    $cod_diploma = '';
    $cod_diploma .= $siglas.".".substr($periodo, 2, 2).".".substr($periodo, 5, 5).".".strtoupper($jornada).".".$version;
    if($version == ''){
        $version = 'V1';
        $cod_diploma .= substr($version, 1, 1);
    }

    $cod_diploma = str_replace(' ', '', $cod_diploma);
    return $cod_diploma; 
}

function generate_cod_interno(){}

function generate_DIPLOMADO($nombre_programa, $tipo_programa){
    $nom_diploma = "";
    $nom_diploma .= $tipo_programa. " en ". $nombre_programa;
    return $nom_diploma;
}

function generate_nom_diploma($nombre_programa, $cod_diploma){
    $nom_diploma = "";
    $nom_diploma .= $nombre_programa . " - ". $cod_diploma;
    return $nom_diploma;
}

function generate_tipo_programa($tipo_producto, $modalidad){
    $tipo_programa = $tipo_producto. " - " . $modalidad;
    return $tipo_programa;
}

function generate_area($area){
    $siglas_area = "";
    if($area == 'Innovación'){
        $siglas_area = "INEM";
    } elseif($area == 'Finanzas e Inversiones'){
        $siglas_area = 'FIN';
    } elseif($area == 'Marketing y Ventas'){
        $siglas_area = 'MKT';
    } elseif($area == 'Estrategia y Gestión'){
        $siglas_area = 'GDN';
    } elseif($area == 'Personas y Equipos'){
        $siglas_area = 'RRHH';
    } elseif($area == 'Operaciones y Logística'){
        $siglas_area = 'OPLO'; 
    } elseif($area == 'Dirección de Instituciones de Salud'){
        $siglas_area = 'SLD';
    } else{
        echo "Error 20: Area no encontrada, siglas de area vacías";
    }
    return $siglas_area;
}

function generate_version($version, $periodo){
    $n_version = "";
    if($version == ''){
        $n_version = "V1";
    }
    else{
        //verificamos que este dentro de un lapso de 2 años
        if($periodo<'2023S1'){
            $n_version = "V1";
        } else{
            //numero de la versión
            $n = +$version[1];
            $n_1 = $n+1;
            $n_version .= $version[0] . $n_1;
            return $n_version;
        }
    }
    return $n_version;
}


//genera condiciones, recibe una lista de datos de la forma: array[array[nombre campo, valor campo], ...]
function generate_conditions($list_campos_data){
    #Creamos las condiciones de la sig forma: d.area = AREA AND...
    #Pero no consideramos el nombre, ya que, para el nombre del diplomado
    #debemos crear un buscador mucho más exhaustivo que tome ciertas consideraciones:
    #1. Eliminar caracteres especiales

    $conditions = array();
    
    foreach ($list_campos_data as $item) {
        // Verifica si el valor es diferente de vacío antes de agregarlo a las condiciones
        if ($item[1] !== "") {
            // Agrega comillas simples alrededor de los valores de tipo string
            $value = is_string($item[1]) ? "'" . $item[1] . "'" : $item[1];
            // Para el primer elemento, usamos LIKE, de lo contrario usamos =
            // Primer elemento es el nombre del diploma(en base de datos es diplomados.nom_diploma)
            $condition = ($item[0] == 'nombre_program') ? "d.DIPLOMADO LIKE '%".$item[1]."%'" : "d.$item[0] = " . $value;
            $conditions[] = $condition;
        }
    }
    
    $conditions_str = implode(" AND ", $conditions);
    return $conditions_str;
}


//Query con datos necesarios para editar un programa ya existente
//toma condiciones ya creadas en funcion de mas arriba
function search_edit_query($conditions){
    $sql_buscar_programa =  "SELECT 
    d.ID_DIPLOMA,                   
    d.Cod_interno,                  
    d.cod_diploma,                  
    d.version,                      
    d.orden,                       
    d.codcatedraab,                 
    d.jornada,                      
    d.DIPLOMADO,                    
    d.nom_diploma,                
    d.nombre_web,                                          
    d.mail_envio,                 
    d.Habilitado,                  
    d.web_habilitado,              
    d.marca,                        
    d.id_DA,                        
    d.Director,                     
    d.emailDirector,                
    d.token,                        
    d.nombre_cordinador_docente,    
    d.usr_cordinador_docente,       
    d.email_cordinador_docente,     
    d.telefono_cordinador_docente,  
    d.valor_diplomado,              
    d.moneda,                       
    d.Periodo,                      
    d.fecha_inicio,                
    d.fecha_termino,               
    d.horas,                        
    d.horas_online,                 
    d.hrs_pedagogicas,              
    d.hora_inicio,                  
    d.hora_termino,                 
    d.vacantes,                     
    d.meta,                                
    d.valor_meta,                   
    d.dias,                         
    d.horario_web,                   
    d.area,                          
    d.area_conocimiento,             
    d.usr_cordinador_ej,                 
    d.nom_ejecutivo_admision,     
    d.telefono_ejecutivo_admision,  
    d.lnk_pdf,                      
    d.cod_sala,                           
    d.secretaria,                   
    d.sala_cafe,                    
    d.in_coffe,                     
    d.uso_pcs,                      
    d.nivelacion,                   
    d.intro_DA,                     
    d.cierre,                       
    d.encuesta,                     
    d.cod_AUGE,                     
    d.realizacion_en,               
    d.usr_coordinador_comercial,    
    d.usr_consultor_corp,           
    d.tipo_programa,                
    d.modalidad_programa,           
    d.ID_ORDEN,                     
    d.area_negocios,                
    d.cuenta_contable,              
    d.reglamento,                   
    d.nivel                         
    "
    #Escogemos los atributos con los que buscamos
    #Obtenemos otros atributos
    ." FROM intranet.diplomados d
    WHERE "
        #Le agregamos las condiciones para que filtre segun el usuario buscó.
        .$conditions
        ." ORDER BY d.ID_DIPLOMA desc";
    
    return $sql_buscar_programa;
}


//Query con datos necesarios para crear un nuevo programa
//toma condiciones ya creadas en funcion de mas arriba
function search_create_query($conditions){
    $sql_buscar_programa =  "SELECT 
    d.nom_diploma, 
    d.tipo_programa,
    d.area_conocimiento,
    d.modalidad_programa,
    d.Periodo,
    d.jornada,
    d.nivel,
    d.realizacion_en,
    d.fecha_inicio,
    d.version,
    d.codcatedraab,
    d.cod_diploma,
    d.area_negocios,

    d.DIPLOMADO,
    d.mail_envio,
    d.Habilitado,
    d.web_habilitado,
    d.marca,
    d.horario_web,
    d.area,
    d.vacantes
    "
    #Escogemos los atributos con los que buscamos
    #Obtenemos otros atributos
    ." FROM intranet.diplomados d
    WHERE "
        #Le agregamos las condiciones para que filtre segun el usuario buscó.
        .$conditions
        ." ORDER BY d.ID_DIPLOMA desc";

    return $sql_buscar_programa;
}

//Esta funcion crea y deberia ejecutar una query creada
//se crea segun el parametro entregado "edit_create"
function get_program($list_campos_data, $edit_create){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    $conditions = generate_conditions($list_campos_data);

    if($edit_create == "buscar_create"){
        $sql_buscar_programa = search_create_query($conditions);
        $stmt_buscar = $con->prepare($sql_buscar_programa);
        $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_buscar ->execute();

    }
    elseif($edit_create == "buscar_edit"){
        $sql_buscar_programa = search_edit_query($conditions);
        $stmt_buscar = $con->prepare($sql_buscar_programa);
        $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_buscar ->execute();
    }
    else{
        //error inesperado, algo falló en el formulario
        echo "Error en la funcion get_program";
    }

    $num_buscar =$stmt_buscar ->rowCount();

    $arr_programas = array();

    while($row = $stmt_buscar->fetch()){

        if($edit_create == 'buscar_create'){
            $arr_programas[] =array(
                "Nombre Diploma"    =>  $row['nom_diploma'],
                "Tipo Programa"     =>  $row['tipo_programa'],
                "Area Conocimiento" =>  $row['area_conocimiento'],
                "Modalidad"         =>  $row['modalidad_programa'],
                "Periodo"           =>  $row['Periodo'],
                "Horario"           =>  $row['jornada'],
                "Nivel"             =>  $row['nivel'],
                "Realización"       =>  $row['realizacion_en'],
                "Fecha Inicio"      =>  $row['fecha_inicio'],
                "Version"           =>  $row['version'],
                "Siglas"            =>  $row['codcatedraab'],
                "Codigo Diploma"    =>  $row['cod_diploma'],
                "Area Negocios"     =>  $row['area_negocios'],

                "DIPLOMADO"         =>  $row['DIPLOMADO'],
                "Mail Envio"        =>  $row['mail_envio'],
                "Habilitado"        =>  $row['Habilitado'],
                "Habilitado Web"    =>  $row['web_habilitado'],
                "Marca"             =>  $row['marca'],
                "Horario Web"       =>  $row['horario_web'],
                "Area"              =>  $row['area'],
                "Vacantes"          =>  $row['vacantes']
            );
        }
        elseif($edit_create == 'buscar_edit'){
            $arr_programas[] =array(
                "Nombre Diploma"                =>  $row['nom_diploma'],
                "Tipo Programa"                 =>  $row['tipo_programa'],
                "Area Conocimiento"             =>  $row['area_conocimiento'],
                "Modalidad"                     =>  $row['modalidad_programa'],
                "Periodo"                       =>  $row['Periodo'],
                "Horario"                       =>  $row['jornada'],
                "Nivel"                         =>  $row['nivel'],
                "Realización"                   =>  $row['realizacion_en'],
                "Fecha Inicio"                  =>  $row['fecha_inicio'],
                "Version"                       =>  $row['version'],
                "Siglas"                        =>  $row['codcatedraab'],
                "Codigo Diploma"                =>  $row['cod_diploma'],
                "Area Negocios"                 =>  $row['area_negocios'],

                "DIPLOMADO"                     =>  $row['DIPLOMADO'],
                "Mail Envio"                    =>  $row['mail_envio'],
                "Habilitado"                    =>  $row['Habilitado'],
                "Habilitado Web"                =>  $row['web_habilitado'],
                "Marca"                         =>  $row['marca'],
                "Horario Web"                   =>  $row['horario_web'],
                "Area"                          =>  $row['area'],
                "Vacantes"                      =>  $row['vacantes'],

                "Id Diploma"                    =>  $row['ID_DIPLOMA'],
                "Codigo Interno"                =>  $row['Cod_interno'],
                "ORDEN"                         =>  $row['orden'],
                "Nombre Web"                    =>  $row['nombre_web'],
                "ID D.A"                        =>  $row['id_DA'],
                "Director"                      =>  $row['Director'],
                "Email Director"                =>  $row['emailDirector'],
                "Token"                         =>  $row['token'],
                "Nombre Coordinador Docente"    =>  $row['nombre_cordinador_docente'],
                "ID Coordinador Docente"        =>  $row['usr_cordinador_docente'],
                "Email Coordinador Docente"     =>  $row['email_cordinador_docente'],
                "Telefono Coordinador Docente"  =>  $row['telefono_cordinador_docente'],
                "Valor Programa"                =>  $row['valor_diplomado'],
                "Tipo Moneda"                   =>  $row['moneda'],
                "Fecha Termino"                 =>  $row['fecha_termino'],
                "Horas"                         =>  $row['horas'],
                "Horas Online"                  =>  $row['horas_online'],
                "Horas Pedagogicas"             =>  $row['hrs_pedagogicas'],
                "Hora Inicio"                   =>  $row['hora_inicio'],
                "Hora Termino"                  =>  $row['hora_termino'],
                "Meta"                          =>  $row['meta'],
                "Valor Meta"                    =>  $row['valor_meta'],
                "Dias"                          =>  $row['dias'],
                "ID Ejecutivo Admision"         =>  $row['usr_cordinador_ej'],
                "Nombre Ejecutivo Admision"     =>  $row['nom_ejecutivo_admision'],
                "Telefono Ejecutivo Admision"   =>  $row['telefono_ejecutivo_admision'],
                "Link PDF"                      =>  $row['lnk_pdf'],
                "Codigo Sala"                   =>  $row['cod_sala'],
                "Secretaria"                    =>  $row['secretaria'],
                "Sala Cafe"                     =>  $row['sala_cafe'],
                "In Coffee"                     =>  $row['in_coffe'],
                "Uso PC's"                      =>  $row['uso_pcs'],
                "Nivelacion"                    =>  $row['nivelacion'],
                "Introducción"                  =>  $row['intro_DA'],
                "Cierre"                        =>  $row['cierre'],
                "Encuesta"                      =>  $row['encuesta'],
                "Codigo AUGE"                   =>  $row['cod_AUGE'],
                "ID Coordinador Comercial"      =>  $row['usr_coordinador_comercial'],
                "ID Consultor Corporativo"      =>  $row['usr_consultor_corp'],
                "ID_ORDEN"                      =>  $row['ID_ORDEN'],
                "Cuenta Contable"               =>  $row['cuenta_contable'],
                "Reglamento"                    =>  $row['reglamento']
            );
        }
        else{
            //Error Inesperado, revise sus datos.
        }
    }

    //se entrega el array(N, lista con los datos) 
    $arr_f = array($num_buscar, $arr_programas);
    return $arr_f;
}
?>