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

function generate_tipo_programa($tipo_producto, $modalidad, $conducente){
    $tipo_programa = $tipo_producto. " - " . $modalidad;
    if($conducente){
        $tipo_programa = $tipo_producto. " Conducente - ". $modalidad;
    }
    return $tipo_programa;
}

function generate_area($area){
    $siglas_area = "";
    if($area == 'Innovación y Emprendimiento'){
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
            $n_version .= $version[0] . strval($n_1);
            return $n_version;
        }
    }
    return $n_version;
}

function aprobe_version($version, $periodo, $name_program){
    //buscar programas que coincidan en nombre y periodo y codigo diploma
    $result = find_coincidence($name_program, $periodo);

    //numero de versiones
    $count_result = count($result);

    $val_version = array();
    //recorremos los resultados
    for($i = 0; $i < $count_result; $i++){
        $val_version[] = array(
            "Value Version" =>  $result[$i]['Version'][1]
        );
    }
    //si no hay coincidencias quiere decir que es primera vez que se dicta dicho programa
    if($count_result == 0){
        return $version;
    } else{
        for($i = 0; $i < count($val_version); $i++){
            //Si el indice y el valor son distintos, quiere decir que se eliminó un programa entre todas las versiones
            if($i+1 != $val_version[$i]['Value Version']){
                $version = "V". strval(intval($i)+1);
                break;
            }
            else{
                //si estamos en el ultimo quiere decir que no encontramos ningun espacio en las versiones anteriores
                //generamos una version nueva
                if($i == count($val_version)-1){
                    $version = "V". strval(intval($val_version[$i]['Value Version'])+1);
                    break;
                }
            }
        }
    }
    return $version;
}

function find_coincidence($name_program, $periodo){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    $sql_buscar_coincidencias = "SELECT
                                    d.version, d.codcatedraab
                                    FROM intranet.diplomados d
                                    WHERE d.Periodo = :periodo AND d.DIPLOMADO = :name_program
                                    ORDER BY d.cod_diploma";

    $stmt_buscar_coincidencias = $con->prepare($sql_buscar_coincidencias);
    $stmt_buscar_coincidencias ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_buscar_coincidencias->bindParam(':periodo', $periodo);
    $stmt_buscar_coincidencias->bindParam(':name_program', $name_program);
    $stmt_buscar_coincidencias ->execute();

    $results = array();
    while($row = $stmt_buscar_coincidencias->fetch()){
        $results[] =array(
            "Version" => $row['version'],
            "Siglas" => $row['codcatedraab']
        );
    }   
    return $results;
}
//genera condiciones, recibe una lista de datos de la forma: array[array[nombre campo, valor campo], ...]
function generate_conditions($list_campos_data){
    #Creamos las condiciones de la sig forma: d.area = AREA AND...
    #Pero no consideramos el nombre, ya que, para el nombre del diplomado
    #debemos crear un buscador mucho más exhaustivo que tome ciertas consideraciones:
    #1. Eliminar caracteres especiales
    
    $conditions = array();

    $my_conducent_program = "";
    //verificamos si el ultimo campo es conducente viendo si es una variable booleana
    if(is_bool(end($list_campos_data)[1])){
        //agregamos condicion
        $my_conducent_program .= "d.tipo = 'Curso conducente'";
        array_pop($list_campos_data);
    }

    foreach ($list_campos_data as $item) {
        // Verifica si el valor es diferente de vacío antes de agregarlo a las condiciones
        if ($item[1] !== "") {

            // Agrega comillas simples alrededor de los valores de tipo string
            $value = is_string($item[1]) ? "'" . $item[1] . "'" : $item[1];

            $condition = ($item[0] == 'nombre_program') ? "d.DIPLOMADO LIKE '%".$item[1]."%'" : "d.$item[0] = " . $value;
            $conditions[] = $condition;
        }
    }
    
    if($my_conducent_program != ""){
        $conditions[] = $my_conducent_program;
    }

    $conditions_str = implode(" AND ", $conditions);
    return $conditions_str;
}

function get_this_date(){
    $hoy = getdate();
    $mon = $hoy['mon'];
    if($hoy['mon'] <=9){
        $mon = "0".$mon;
    }
    $day = $hoy['mday'];
    if($day <=9){
        $day = "0".$day;
    }

    $fecha_hoy = $hoy['year']. "-" .$mon. "-" .$day;
    return $fecha_hoy;
}

function verify_date($fecha_de_inicio){
    $fecha_hoy = get_this_date();
    if($fecha_de_inicio < $fecha_hoy){
        return true;
    } else{
        return false;
    }
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
    d.nombre_cordinador_curso,    
    d.usr_cordinador_curso,       
    d.email_cordinador_curso,     
    d.telefono_cordinador_curso,  
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
    d.usr_cordinador_ad,                 
    d.nom_cordinadora_admision,     
    d.telefono_cordinadora_admision,  
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
    d.reglamento,                   
    d.nivel,
    d.tipo                         
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
    d.vacantes,
    d.usr_cordinador_ad
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
function get_program($list_campos_data, $create){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    $conditions = generate_conditions($list_campos_data);

    if($create){
        $sql_buscar_programa = search_create_query($conditions);
        $stmt_buscar = $con->prepare($sql_buscar_programa);
        $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_buscar ->execute();

    } else{
        $sql_buscar_programa = search_edit_query($conditions);
        $stmt_buscar = $con->prepare($sql_buscar_programa);
        $stmt_buscar ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_buscar ->execute();
    }

    $num_buscar =$stmt_buscar ->rowCount();

    $arr_programas = array();

    while($row = $stmt_buscar->fetch()){

        if($create){
            $arr_programas[] =array(
                "Nombre_Diploma"            =>  $row['nom_diploma'],
                "Tipo_Programa"             =>  $row['tipo_programa'],
                "Area_Conocimiento"         =>  $row['area_conocimiento'],
                "Modalidad"                 =>  $row['modalidad_programa'],
                "Periodo"                   =>  $row['Periodo'],
                "Horario"                   =>  $row['jornada'],
                "Nivel"                     =>  $row['nivel'],
                "Realización"               =>  $row['realizacion_en'],
                "Fecha_Inicio"              =>  $row['fecha_inicio'],
                "Version"                   =>  $row['version'],
                "Siglas"                    =>  $row['codcatedraab'],
                "Codigo_Diploma"            =>  $row['cod_diploma'],
                "Area_Negocios"             =>  $row['area_negocios'],

                "DIPLOMADO"                 =>  $row['DIPLOMADO'],
                "Mail_Envio"                =>  $row['mail_envio'],
                "Habilitado"                =>  $row['Habilitado'],
                "Habilitado_Web"            =>  $row['web_habilitado'],
                "Marca"                     =>  $row['marca'],
                "Horario_Web"               =>  $row['horario_web'],
                "Area"                      =>  $row['area'],
                "Vacantes"                  =>  $row['vacantes'],
                "Usr_Coordinador_Ejecutivo"  => $row["usr_cordinador_ad"]
            );
        }
        else{
            $arr_programas[] =array(
    /*ok*/             "Nombre_Diploma"                =>  $row['nom_diploma'],
    /*ok*/            "Tipo_Programa"                 =>  $row['tipo_programa'],
    /*ok*/             "Area_Conocimiento"             =>  $row['area_conocimiento'],
    /*ok*/             "Modalidad"                     =>  $row['modalidad_programa'],
    /*ok*/             "Periodo"                       =>  $row['Periodo'],
    /*ok*/             "Horario"                       =>  $row['jornada'],
    /*ok*/             "Nivel"                         =>  $row['nivel'],
    /*ok*/             "Realización"                   =>  $row['realizacion_en'],
    /*ok*/             "Fecha_Inicio"                  =>  $row['fecha_inicio'],
    /*ok*/             "Version"                       =>  $row['version'],
    /*ok*/             "Siglas"                        =>  $row['codcatedraab'],
    /*ok*/             "Codigo_Diploma"                =>  $row['cod_diploma'],
    /*ok*/             "Area_Negocios"                 =>  $row['area_negocios'],

    /*ok*/             "DIPLOMADO"                     =>  $row['DIPLOMADO'],
    /*ok*/            "Mail_Envio"                    =>  $row['mail_envio'],
    /*ok*/             "Habilitado"                    =>  $row['Habilitado'],
    /*ok*/             "Habilitado_Web"                =>  $row['web_habilitado'],
    /*ok*/             "Marca"                         =>  $row['marca'],
    /*ok*/             "Horario_Web"                   =>  $row['horario_web'],
    /*ok*/             "Area"                          =>  $row['area'],
    /*ok*/             "Vacantes"                      =>  $row['vacantes'],

    /*ok*/             "Id_Diploma"                    =>  $row['ID_DIPLOMA'],
    /*ok*/             "Codigo_Interno"                =>  $row['Cod_interno'],
    /*ok*/             "ORDEN"                         =>  $row['orden'],
    /*ok*/             "Nombre_Web"                    =>  $row['nombre_web'],
    /*ok*/            "ID_D_A"                        =>  $row['id_DA'],
    /*ok*/            "Director"                      =>  $row['Director'],
    /*ok*/            "Email_Director"                =>  $row['emailDirector'],
    /*--*/            "Token"                         =>  $row['token'],
    /*ok*/            "Nombre_Coordinador_Docente"    =>  $row['nombre_cordinador_curso'],
    /*ok*/            "ID_Coordinador_Docente"        =>  $row['usr_cordinador_curso'],
    /*ok*/            "Email_Coordinador_Docente"     =>  $row['email_cordinador_curso'],
    /*ok*/            "Telefono_Coordinador_Docente"  =>  $row['telefono_cordinador_curso'],
    /*ok*/             "Valor_Programa"                =>  $row['valor_diplomado'],
    /*ok*/             "Tipo_Moneda"                   =>  $row['moneda'],
    /*ok*/             "Fecha_Termino"                 =>  $row['fecha_termino'],
    /*ok*/             "Horas"                         =>  $row['horas'],
    /*ok*/             "Horas_Online"                  =>  $row['horas_online'],
    /*ok*/             "Horas_Pedagogicas"             =>  $row['hrs_pedagogicas'],
    /*ok*/             "Hora_Inicio"                   =>  $row['hora_inicio'],
    /*ok*/             "Hora_Termino"                  =>  $row['hora_termino'],
    /*ok*/             "Meta"                          =>  $row['meta'],
    /*ok*/             "Valor_Meta"                    =>  $row['valor_meta'],
    /*ok*/             "Dias"                          =>  $row['dias'],
    /*ok*/            "ID_Ejecutivo_Admision"         =>  $row['usr_cordinador_ad'],
    /*ok*/            "Nombre_Ejecutivo_Admision"     =>  $row['nom_cordinadora_admision'],
    /*ok*/            "Telefono_Ejecutivo_Admision"   =>  $row['telefono_cordinadora_admision'],
    /*ok*/              "Link_PDF"                      =>  $row['lnk_pdf'],
    /*ok*/              "Codigo_Sala"                   =>  $row['cod_sala'],
    /*ok*/              "Secretaria"                    =>  $row['secretaria'],
    /*ok*/              "Sala_Cafe"                     =>  $row['sala_cafe'],
    /*ok*/              "In_Coffee"                     =>  $row['in_coffe'],
    /*ok*/              "Uso_PC_s"                      =>  $row['uso_pcs'],
    /*ok*/              "Nivelacion"                    =>  $row['nivelacion'],
    /*ok*/              "Introducción"                  =>  $row['intro_DA'],
    /*ok*/              "Cierre"                        =>  $row['cierre'],
    /*ok*/              "Encuesta"                      =>  $row['encuesta'],
    /*ok*/              "Codigo_AUGE"                   =>  $row['cod_AUGE'],
    /*ok*/            "ID_Coordinador_Comercial"      =>  $row['usr_coordinador_comercial'],
    /*ok*/              "ID_Consultor_Corporativo"      =>  $row['usr_consultor_corp'],
    /*ok*/             "ID_ORDEN"                      =>  $row['ID_ORDEN'],
    /*ok*/             "Reglamento"                    =>  $row['reglamento'],
                    'Tipo'=> $row['tipo']
            );
        }
    }
    //se entrega el array(N, lista con los datos) 
    $arr_f = array($num_buscar, $arr_programas);
    return $arr_f;
}

//funcion que contiene la query para encontrar el nombre de una secretaria
//la encuentra segun su id y si esta vigente.
function search_secretaria_byid(){
    $sql_get_secretaria = ' SELECT 
                            s.nombre,
                            s.apellido_pat,
                            s.apellido_mat
                                FROM intranet.secretaria s
                                    WHERE   s.idsecretaria = :id_secretaria AND
                                            s.vigente = 1';

    return $sql_get_secretaria;
}

//funcion que obtiene el nombre de la secretaria
function get_secretaria($id_secretaria){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    //obtenemos la query que nos debería dar solo una fila
    $sql_get_secretaria = search_secretaria_byid();
    $stmt_secretaria = $con->prepare($sql_get_secretaria);
    $stmt_secretaria ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_secretaria->bindParam(':id_secretaria', $id_secretaria);
    $stmt_secretaria ->execute();  

    //si efectivamente es una sola fila, quiere decir que no hay una id repetida(no deberia pasar)
    if($stmt_secretaria ->rowCount() == 1){
        //obtenemos la fila y sacamos los datos
        $secretaria = array();

        if($row = $stmt_secretaria->fetch()){
            $secretaria[] =array(
                "Nombre_Secretaria"  =>  $row['nombre'],
                "Apellido_Paterno"   =>  $row['apellido_pat'],
                "Apellido_Materno"   =>  $row['apellido_mat']
            );

            return $secretaria;
        }
    } else{
        //si hay más de una secretaria con el mismo id debe ocurrir un error dentro de la base de datos.
        return '';
    }
}

function search_cord_comercial_byid(){
    $sql_get_cord_comercial = ' SELECT 
                            c.nombre,
                            c.apellido,
                            c.usr
                                FROM intranet.usuarios_int c
                                    WHERE   c.usr = :usr_cord_comercial';

    return $sql_get_cord_comercial;
}

function get_cord_comercial($usr_cord_comercial){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    //obtenemos la query que nos debería dar solo una fila
    $sql_get_cord_comercial = search_cord_comercial_byid();
    $stmt_cord_comercial = $con->prepare($sql_get_cord_comercial);
    $stmt_cord_comercial ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_cord_comercial->bindParam(':usr_cord_comercial', $usr_cord_comercial);
    $stmt_cord_comercial ->execute();  

    //si efectivamente es una sola fila, quiere decir que no hay una id repetida(no deberia pasar)
    if($stmt_cord_comercial ->rowCount() == 1){
        //obtenemos la fila y sacamos los datos
        $cord_comercial= array();
        if($row = $stmt_cord_comercial->fetch()){
            $cord_comercial[] =array(
                "Nombre_Cord_Comercial"  =>  $row['nombre'],
                "Apellido"               =>  $row['apellido'],
                "Usuario"                =>  $row['usr']
            );

            return $cord_comercial;
        }
    } else{
        //si hay más de un coordinador comercial con el mismo id debe ocurrir un error dentro de la base de datos.
        return '';
    }
}

function get_query_encargados($tipo){
    $sql_data = "";
    if($tipo == 'coordinador docente'){
        $sql_data = "SELECT *
                        FROM intranet.cordinadores_docentes cd
                        WHERE   cd.nombre_cordinador_curso LIKE :nombre";

    } else if($tipo == "coordinador ejecutivo"){
        $sql_data = "SELECT *
                        FROM intranet.ejecutivos_admision ea
                        WHERE ea.ej_admision_nombre LIKE :nombre";

    } else if($tipo == "director academico"){
        $sql_data = "SELECT da.id_DA,
                            da.emailDirector,
                            da.nombre
                        FROM intranet.directores_academicos da
                        WHERE da.nombre LIKE :nombre";

    } else if($tipo == 'coordinador comercial'){
        $sql_data = "SELECT cd.nombre_cordinador_curso ,
                            cd.usr_cordinador_curso
                        FROM intranet.cordinador_comercial cd
                        WHERE   cd.nombre_cordinador_curso LIKE :nombre";
    } else if($tipo == 'secretaria'){
        $sql_data = 'SELECT
                                s.idsecretaria,
                                s.nombre,
                                s.apellido_pat
                                FROM intranet.secretaria s
                                WHERE   s.nombre LIKE :nombre AND
                                        s.apellido_pat LIKE :apellido AND
                                        s.vigente = 1';
    }

    return $sql_data;
}

function get_data_encargados($tipo, $nombre){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    list($n, $apellido) = explode(" ", $nombre);
    $nombre = str_replace(' ', "%", $nombre);
    $nombre = '%'.$nombre.'%';


    $sql_encargados = get_query_encargados($tipo);
    $stmt_encargados = $con->prepare($sql_encargados);
    $stmt_encargados ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_encargados->bindParam(':nombre', $nombre);
    if($tipo == 'secretaria'){
        $n = '%'.$n.'%';
        $apellido = '%'.$apellido.'%';
        
        $stmt_encargados->bindParam(':nombre', $n);
        $stmt_encargados->bindParam(':apellido', $apellido);
    }
    $stmt_encargados ->execute();

    $arr_encargados = array();

    while($row = $stmt_encargados->fetch()){
        if($tipo == 'coordinador ejecutivo'){
            $arr_encargados[] = array(
                "Nombre"    =>  $row['ej_admision_nombre'],
                "Usr"       =>  $row['ej_admision_usuario'],
                "Email"     =>  $row['ej_admision_email'],
                "Telefono"  =>  $row['ej_admision_telefono']
            );

        } else if($tipo == 'coordinador docente'){
            $arr_encargados[] =array(
            "Nombre"            => $row["nombre_cordinador_curso"],
            "Usr"           => $row["usr_cordinador_curso"],
            "Email"         => $row["email_cordinador_curso"],
            "Telefono"      => $row["telefono_cordinador_curso"]
            );

        } else if($tipo == 'director academico'){
            $arr_encargados[] =array(
                "ID"    => $row["id_DA"],
                "Nombre"=> $row["nombre"],
                "Email" => $row["emailDirector"]
            );
            
        } else if($tipo == 'coordinador comercial'){
            $arr_encargados[] =array(
                "Nombre"        => $row["nombre_cordinador_curso"],
                "Usr"           => $row["usr_cordinador_curso"]
                );

        } else if($tipo == 'secretaria'){
            $arr_encargados[] =array(
                "ID"            =>  $row["idsecretaria"],
                "Nombre"        => $row["nombre"],
                "Apellido"      => $row["apellido_pat"]
            );
        }
    }
    return $arr_encargados;
}

function get_sql_update(){
    $sql_update= "UPDATE intranet.diplomados
                    SET     Cod_interno                         = :Codigo_Interno,                  
                            cod_diploma                         = :Codigo_Programa,                  
                            version                             = :Version,                      
                            orden                               = :ORDEN,                       
                            codcatedraab                        = :Siglas,                 
                            jornada                             = :Horario,                      
                            DIPLOMADO                           = :DIPLOMADO,                    
                            nom_diploma                         = :Nom_Diploma,                
                            nombre_web                          = :Nombre_Web,                                          
                            mail_envio                          = '',                 
                            Habilitado                          = :Habilitado,                  
                            web_habilitado                      = :Habilitado_web,              
                            marca                               = :Marca,                        
                            id_DA                               = '',                        
                            Director                            = '',                  
                            emailDirector                       = '',                
                            token                               = '',                        
                            nombre_cordinador_curso             = '',    
                            usr_cordinador_curso                = '',       
                            email_cordinador_curso              = '',     
                            telefono_cordinador_curso           = '',  
                            valor_diplomado                     = :Valor_Programa,              
                            moneda                              = :Tipo_Moneda,                       
                            Periodo                             = :Periodo,                      
                            fecha_inicio                        = :Fecha_Inicio,                
                            fecha_termino                       = :Fecha_Termino,               
                            horas                               = :Horas,                        
                            horas_online                        = :Horas_Online,                 
                            hrs_pedagogicas                     = :Horas_Pedagogicas,              
                            hora_inicio                         = :Hora_Inicio,                  
                            hora_termino                        = :Hora_Termino,                 
                            vacantes                            = :Vacantes,                     
                            meta                                = :Meta,                                
                            valor_meta                          = :Valor_Meta,                   
                            dias                                = :Dias,                         
                            horario_web                         = :Horario_Web,                   
                            area                                = :Area,                          
                            area_conocimiento                   = :Area_Conocimiento,             
                            usr_cordinador_ad                   = '',                 
                            nom_cordinadora_admision            = '',     
                            telefono_cordinadora_admision       = '',  
                            lnk_pdf                             = :Link_PDF,                      
                            cod_sala                            = :Codigo_Sala,                           
                            secretaria                          = '',                   
                            sala_cafe                           = :Sala_Cafe,                    
                            in_coffe                            = :In_Coffee,                     
                            uso_pcs                             = :Uso_pcs,                      
                            nivelacion                          = :Nivelacion,                   
                            intro_DA                            = :Introduccion,                     
                            cierre                              = :Cierre,                       
                            encuesta                            = :Encuesta,                     
                            cod_AUGE                            = :Codigo_AUGE,                     
                            realizacion_en                      = :Realizacion,               
                            usr_coordinador_comercial           = '',    
                            usr_consultor_corp                  = :Usr_Consultor_Corporativo,           
                            tipo_programa                       = :Tipo_Programa,                
                            modalidad_programa                  = :Modalidad,           
                            ID_ORDEN                            = :ID_ORDEN,                     
                            area_negocios                       = :Area_Negocios,                           
                            reglamento                          = :Reglamento,                   
                            nivel                               = :Nivel,
                            tipo                                = :Tipo
                    WHERE ID_DIPLOMA = :Id_Programa;";

    return $sql_update;
}

function update_data($update_data_JSON){
    echo $update_data_JSON;
    
    $programa = json_decode($update_data_JSON, true);
    echo count($programa);
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');
    $sql_update_data = get_sql_update();

    $stmt_encargados = $con->prepare($sql_update_data);
    $stmt_encargados ->setFetchMode(PDO::FETCH_ASSOC);

    //asignamos los valores a actualizar
    $stmt_encargados->bindParam(':Codigo_Interno', $programa['Cod_interno']);
    $stmt_encargados->bindParam(':Codigo_Programa', $programa['cod_diploma']);
    $stmt_encargados->bindParam(':Version', $programa['version']);
    $stmt_encargados->bindParam(':ORDEN', $programa['orden']);
    $stmt_encargados->bindParam(':Siglas',$programa['codcatedraab']);
    $stmt_encargados->bindParam(':Horario',$programa['jornada']);
    $stmt_encargados->bindParam(':DIPLOMADO',$programa['DIPLOMADO']);
    $stmt_encargados->bindParam(':Nom_Diploma',$programa['nom_diploma']);
    $stmt_encargados->bindParam(':Nombre_We',$programa['nombre_web']);
    $stmt_encargados->bindParam(':Habilitado',$programa['habilitado']);
    $stmt_encargados->bindParam(':Habilitado_web',$programa['web_habilitado']);
    $stmt_encargados->bindParam(':Marca',$programa['marca']);
    $stmt_encargados->bindParam(':Valor_Programa',$programa['valor_diplomado']);
    $stmt_encargados->bindParam(':Tipo_Moneda',$programa['moneda']);
    $stmt_encargados->bindParam(':Periodo',$programa['Periodo']);
    $stmt_encargados->bindParam(':Fecha_Inicio',$programa['fecha_inicio']);
    $stmt_encargados->bindParam(':Fecha_Termino',$programa['fecha_termino']);
    $stmt_encargados->bindParam(':Horas',$programa['horas']);
    $stmt_encargados->bindParam('Horas_Online',$programa['horas_online']);
    $stmt_encargados->bindParam(':Horas_Pedagogicas',$programa['hrs_pedagogicas']);
    $stmt_encargados->bindParam(':Hora_Inicio',$programa['hora_inicio']);
    $stmt_encargados->bindParam('Hora_Termino',$programa['hora_termino']);
    $stmt_encargados->bindParam(':Vacantes',$programa['vacantes']);
    $stmt_encargados->bindParam(':Meta',$programa['meta']);
    $stmt_encargados->bindParam(':Valor_meta',$programa['valor_meta']);
    $stmt_encargados->bindParam(':Dias',$programa['dias']);
    $stmt_encargados->bindParam(':Horario_Web',$programa['horario_web']);
    $stmt_encargados->bindParam(':Area',$programa['area']);
    $stmt_encargados->bindParam(':Area_Conocimiento',$programa['area_conocimiento']);
    $stmt_encargados->bindParam(':Link_PDF',$programa['lnk_PDF']);
    $stmt_encargados->bindParam(':Codigo_Sala',$programa['cod_sala']);
    $stmt_encargados->bindParam(':Sala_Cafe',$programa['sala_cafe']);
    $stmt_encargados->bindParam(':In_Coffee',$programa['in_coffe']);
    $stmt_encargados->bindParam(':Uso_pcs',$programa['uso_pcs']);
    $stmt_encargados->bindParam(':Nivelacion',$programa['nivelacion']);
    $stmt_encargados->bindParam(':Introduccion',$programa['intro_DA']);
    $stmt_encargados->bindParam(':Cierre',$programa['cierre']);
    $stmt_encargados->bindParam(':Encuesta',$programa['encuesta']);
    $stmt_encargados->bindParam(':Codigo_AUGE',$programa['cod_AUGE']);
    $stmt_encargados->bindParam(':Realizacion',$programa['realizacion_en']);
    $stmt_encargados->bindParam(':Usr_Consultor_Corporativo',$programa['usr_consultor_corp']);
    $stmt_encargados->bindParam(':Tipo_Programa',$programa['tipo_programa']);
    $stmt_encargados->bindParam(':Modalidad',$programa['modalidad_programa']);
    $stmt_encargados->bindParam(':ID_ORDEN',$programa['ID_ORDEN']);
    $stmt_encargados->bindParam(':Area_Negocios',$programa['area_negocios']);
    $stmt_encargados->bindParam(':Reglamento',$programa['reglamento']);
    $stmt_encargados->bindParam(':Nivel',$programa['nivel']);
    $stmt_encargados->bindParam(':Tipo',$programa['tipo']);
    $stmt_encargados->bindParam(':Id_Programa',$programa['ID_DIPLOMA']);

    $stmt_encargados ->execute();
    echo "Programa Actualizado";
}
?>