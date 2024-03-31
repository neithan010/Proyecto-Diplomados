<?php
#Conectores para crear siglas en el nombre de un programa
$conectores = ["de", "los", "la", "en", "y", "a", "el", "del", "las", "un", "una", "con", "por", "para"];

#Función que genera las siglas de un nombre, solo debe recibir dicho nombre y los conectores que se quiere
#excluir del mismo
function generate_siglas($nombre_programa, $conectores){

    #Primero eliminamos los conectores del nombre, reemplazandolos con "" 
    $siglas = '';
    $nombre_sin_conectores = str_replace($conectores, "", $nombre_programa);

    #Sacamos el largo del nombre sin conectores y lo recorremos en un for
    $max_len = strlen($nombre_sin_conectores);
    for($i = 0; $i < $max_len; $i++){
        #Si estamos en el primer caracter
        if($i == 0){
            #Y además, no es un espcio en blanco, entonces quiere decir que es una letra
            if($nombre_sin_conectores[$i] != ' '){
                #Agregamos dicha letra, strtoupper la transforma a una letra mayuscula.
                $siglas .= strtoupper($nombre_sin_conectores[$i]);
            }
        }
        #Si no estamos en la primera letra
        else{
            #Si el sig caracter no es el ultimo
            if($i+1 < $max_len - 1){
                #Si es que el sig caracter es el ultimo
                if($i+1 == $max_len-1){
                    #Si el caracter actual no es un espacio y el sig caracter es un espacio
                    if($nombre_sin_conectores[$i] != ' ' and $nombre_sin_conectores[$i+1] == ' '){
                        #Agregaremos dicha sigla, es un caso borde, como es el penultimo caracter y el sig es
                        #un espacio, hacemos un break para salir del for.
                        $siglas .= strtoupper($nombre_sin_conectores[$i]);
                        break;
                    }
                }
                #Si no es el ultimo caracter de la cadena
                else{
                    #Si es que el caracter anterior es un espacio y el caracter actual no es vacío
                    #quiere decir que es la primera letra de una palabra
                    if($nombre_sin_conectores[$i-1] == ' ' && $nombre_sin_conectores[$i] != ' '){
                        #Por tanto agregamos dicha letra en mayuscula a las siglas
                        $siglas .= strtoupper($nombre_sin_conectores[$i]);
                    }
                }
            }
            #Si es que estamos en el ultimo caracter
            else{
                #Si es que el actual no es un espacio y el anterior si es un espacio quiere decir que hay una letra al final de la cadena
                #Y como ya removimos los conectores no debemos preocuparnos de estos
                if($nombre_sin_conectores[$i] != ' ' and $nombre_sin_conectores[$i-1] == ' '){
                    #Por lo tanto agregamos dicho caracter a las siglas y salimos del for
                    $siglas .= strtoupper($nombre_sin_conectores[$i]);
                    break;
                }
            }
        }
    }
    #Entregamos las siglas generadas luego del for.
    return $siglas;
}

#Función que se encarga de generar las siglas de un programa según el tipo de producto que sea, solo recibe un argumento que es el tipo de producto.
function generate_sigla_tipo($tipo){
    #Si es tipo Curso entonces devuelve una C
    if($tipo == 'Curso'){
        return 'C';
    } #Si es un Diploma devuelve una D
    elseif($tipo == 'Diploma'){
        return 'D';
    } #Si es un Diploma Postitulo devulve un DP
    elseif($tipo == 'Diploma Postitulo'){
        return 'DP';
    }
}

#Función que se encarga de generar el codigo del diploma
#El codigo del diploma aqui se genera de la sig forma:
#cod_diploma = siglasTipoProducot + siglasNombre + . + año + . + semestre + . + jornada/horario + número versión
#Ej: D + CPD + . + 22 + . + 2 + . + AM + 3 
#El ejemplo quiere decir que: es tipo producto D(Diploma) siglas del nombre: CPD;  año 2022; 2do semestre; jornada AM; versión 3.
function generate_cod_diploma($siglas, $periodo, $jornada, $version, $sigla_tipo){
    #Generamos el codigo del diploma como se mencionó en la descripción de la función
    $cod_diploma = '';
    $cod_diploma .= $sigla_tipo.$siglas.".".substr($periodo, 2, 2).".".substr($periodo, 5, 5).".".strtoupper($jornada).substr($version,1,1);

    #Si es que no hay versión se pone como default la versión 1 del programa
    if($version == ''){
        $version = 'V1';
        $cod_diploma .= substr($version, 1, 1);
    }

    #Reemplazamos posibles espacios vacios dentro del codigo y lo retornamos.
    $cod_diploma = str_replace(' ', '', $cod_diploma);
    return $cod_diploma; 
}

#Función que se encarga de generar el DIPLOMADO que es una columna de la tabla de diplomados en la base de datos de Intranet
#La función solo recibe como entrada el nombre de un programa con su tipo de producto.
#Este campo se genera de la sig forma: DIPLOMADO = tipo producto "en" Nombre Programa
#Ej: Curso en Habilidades Sociales ; Diplomado en Marketing
function generate_DIPLOMADO($nombre_programa, $tipo_programa){
    #Se genera el DIPLOMADO como se describió anteriormente y se retorna.
    $nom_diploma = "";
    $nom_diploma .= $tipo_programa. " en ". $nombre_programa;
    return $nom_diploma;
}

#Función que se encarga de generar el nom_diploma, que es una columna de la tabla de diplomados
#Solo recibe el nombre y el codigo del programa
#Se genera de la sig manera. nom_diploma = Nombre - codigo programa
#Ej: Competencias en Problemas y Diseños - DCPD.22.2.AM3 
function generate_nom_diploma($nombre_programa, $cod_diploma){
    #Generamos el nombre del diploma como se explica y se retorna
    $nom_diploma = "";
    $nom_diploma .= $nombre_programa . " - ". $cod_diploma;
    return $nom_diploma;
}

#Función que se encarga de Generar el tipo, de un programa, que es diferente al tipo de producto que es un programa
#La creación del tipo es : tipo producto - modalidad del programa
#Se recibe el tipo de Producto, la modalidad y el booleano conducente.
function generate_tipo_programa($tipo_producto, $modalidad, $conducente){
    #Creamos el tipo programa
    $tipo_programa = $tipo_producto. " - " . $modalidad;
    
    #Si es que el Programa es Conducente, se le agrega dicha cadena al tipo de programa, luego retornamos.
    if($conducente){
        $tipo_programa = $tipo_producto. " Conducente - ". $modalidad;
    }
    return $tipo_programa;
}

#Función que genera las siglas de un area dada
#Solo recibe como input las siglas y las generamos sin buscarlas en la base de datos
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

#Funcion que genera la versión, es el unico lugar donde se verifica que el periodo este dentro de los 2 años
function generate_version($version, $periodo){
    $n_version = "";
    if($version == ''){
        $n_version = "V1";
    }
    else{
        //verificamos que este dentro de un lapso de 2 años
        if($periodo<'2022S1'){
            $n_version = "V1";
        } else{
            //Si tenemos una version y vemos que el periodo no es el indicado, ponemos la sig versión
            $n = +$version[1];
            $n_1 = $n+1;
            $n_version .= $version[0] . strval($n_1);
            return $n_version;
        }
    }
    return $n_version;
}

#Funcion que aprueba la versión de un programa creado, se usar principalmente cuando usamos un programa existente para crear otro
function aprobe_version($version, $periodo, $name_program){
    //buscar programas que coincidan en nombre y periodo y codigo diploma
    $result = find_coincidence($name_program, $periodo);

    //numero de versiones
    $count_result = count($result);

    $val_version = array();

    //recorremos los resultados obtenidos
    for($i = 0; $i < $count_result; $i++){
        $val_version[] = array(
            "Value Version" =>  $result[$i]['Version'][1]
        );
    }

    //si no hay coincidencias quiere decir que es primera vez que se dicta dicho programa
    if($count_result == 0){
        #devolvemos la versión
        return $version;
    } #Si hay al menos una coincidencia
    else{
        #Recorremos los resultados obtenidos
        for($i = 0; $i < count($val_version); $i++){
            //Si el indice y el valor son distintos, quiere decir que se eliminó un programa entre todas las versiones
            if($i+1 != $val_version[$i]['Value Version']){
                #La versión que tendrá el programa será la versión disponible dentro de la lista y salimos del for
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

#Función que se usa para encontrar coincidencias entre un nombre y el periodo de un programa
function find_coincidence($name_program, $periodo){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    #Creamos la consulta en sql que obtiene la version segun el periodo y el nombre de un programa
    $sql_buscar_coincidencias = "SELECT
                                    d.version, d.codcatedraab
                                    FROM intranet.diplomados d
                                    WHERE d.Periodo = :periodo AND d.DIPLOMADO = :name_program
                                    ORDER BY d.cod_diploma";

    #Ejecutamos la query asignando los campos de periodo y name_program
    $stmt_buscar_coincidencias = $con->prepare($sql_buscar_coincidencias);
    $stmt_buscar_coincidencias ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_buscar_coincidencias->bindParam(':periodo', $periodo);
    $stmt_buscar_coincidencias->bindParam(':name_program', $name_program);
    $stmt_buscar_coincidencias ->execute();

    #Dejamos los resultados en un array de la forma Versión, Siglas
    $results = array();
    while($row = $stmt_buscar_coincidencias->fetch()){
        $results[] =array(
            "Version" => $row['version'],
            "Siglas" => $row['codcatedraab']
        );
    }   

    #Entregamos los resultados
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
        //agregamos condicion y eliminamos el ultimo elemento ya que lo evaluamos
        $my_conducent_program .= "d.tipo = 'Curso conducente'";
        array_pop($list_campos_data);
    }

    #Recorremos todos los datos 
    foreach ($list_campos_data as $item) {

        // Verifica si el valor es diferente de vacío antes de agregarlo a las condiciones
        if ($item[1] !== "") {

            // Agrega comillas simples alrededor de los valores de tipo string
            $value = is_string($item[1]) ? "'" . $item[1] . "'" : $item[1];

            #Generamos las condiciones, si es que el nombre del campo es nombre_program agrega lo primero(antes del :), si no lo es, entonces
            #agrega lo que viene despues de ":"
            $condition = ($item[0] == 'nombre_program') ? "d.DIPLOMADO LIKE '%".$item[1]."%'" : "d.$item[0] = " . $value;

            #Agregamos a la lista cada condición por separado
            $conditions[] = $condition;
        }
    }
    
    #Si es que la variable tiene algo dentro, entonces la agregamos a la lista de condiciones
    if($my_conducent_program != ""){
        $conditions[] = $my_conducent_program;
    }

    #Hacemos implode de la lista de condiciones usando AND para separarlas y retornamos las condiciones para buscar un programa 
    $conditions_str = implode(" AND ", $conditions);
    return $conditions_str;
}

#Función que obtiene la fecha en el siguiente formato: Año-mes-dia
function get_this_date(){

    #Obtenemos la fecha de hoy
    $hoy = getdate();

    #Obtenemos el mes de hoy, si es un mes entre el 1ro y el 9no le pone un cero a la izquierda
    $mon = $hoy['mon'];
    if($hoy['mon'] <=9){
        $mon = "0".$mon;
    }

    #Obtenemos el dia de hoy, si es un dia entre el 1ro y el 9no le pone un cero a la izquierda.
    $day = $hoy['mday'];
    if($day <=9){
        $day = "0".$day;
    }

    #Creamos la fecha de hoy y la retornamos
    $fecha_hoy = $hoy['year']. "-" .$mon. "-" .$day;
    return $fecha_hoy;
}

#Función que verifica una fecha, recibe una fecha de inicio de un programa
function verify_date($fecha_de_inicio){
    #Obtenemos la fecha de hoy en el formato en que se lee en la base de datos
    $fecha_hoy = get_this_date();

    #Si es que la fecha actual es mayor a la fecha de inicio del programa retorna true, en caso contrario retorna false.
    if($fecha_de_inicio < $fecha_hoy){
        return true;
    } else{
        return false;
    }
}

//Query con datos necesarios para editar un programa ya existente
//toma condiciones ya creadas en la función de más arriba
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
    d.usr_cordinador_ad,
    d.tipo,
    d.cod_diploma
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

//Esta funcion crea y ejecuta una query creada se crea segun el parametro entregado "edit_create"
//el input create representa un booleano, de si estamos creando(true) o si estamos editando(false)
//La función recibe la lista de campos, la cual tiene todos los parametros para generar las condiciones
function get_program($list_campos_data, $create){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    #Generamos las condiciones usando la función anterior
    $conditions = generate_conditions($list_campos_data);

    #Si estamos creando un programa, obtenemos la query respectiva y la ejecutamos, en caso contrario buscamos la query para editar un programa
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

    #Obtenemos el número de resultados, creamos un array que los va a guardar
    $num_buscar =$stmt_buscar ->rowCount();

    $arr_programas = array();

    #Mientras exista una fila de los resultados que procesar haremos lo sig
    while($row = $stmt_buscar->fetch()){
        #Si vamos a crear un programa(buscando uno) entonces crearemos el array de la sig forma:
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
                "Usr_Coordinador_Ejecutivo"  => $row["usr_cordinador_ad"],
                "Tipo"                      => $row["tipo"],
                "Cod_diploma"               =>  $row['cod_diploma']
            );
        } #Si estamos editando un programa(buscando uno a escoger) entonces las filas son:
        else{
            $arr_programas[] =array(
                 "Nombre_Diploma"                =>  $row['nom_diploma'],
                 "Tipo_Programa"                 =>  $row['tipo_programa'],
                 "Area_Conocimiento"             =>  $row['area_conocimiento'],
                 "Modalidad"                     =>  $row['modalidad_programa'],
                 "Periodo"                       =>  $row['Periodo'],
                 "Horario"                       =>  $row['jornada'],
                 "Nivel"                         =>  $row['nivel'],
                 "Realización"                   =>  $row['realizacion_en'],
                 "Fecha_Inicio"                  =>  $row['fecha_inicio'],
                 "Version"                       =>  $row['version'],
                 "Siglas"                        =>  $row['codcatedraab'],
                 "Codigo_Diploma"                =>  $row['cod_diploma'],
                 "Area_Negocios"                 =>  $row['area_negocios'],

                 "DIPLOMADO"                     =>  $row['DIPLOMADO'],
                 "Mail_Envio"                    =>  $row['mail_envio'],
                 "Habilitado"                    =>  $row['Habilitado'],
                 "Habilitado_Web"                =>  $row['web_habilitado'],
                 "Marca"                         =>  $row['marca'],
                 "Horario_Web"                   =>  $row['horario_web'],
                 "Area"                          =>  $row['area'],
                 "Vacantes"                      =>  $row['vacantes'],

                 "Id_Diploma"                    =>  $row['ID_DIPLOMA'],
                 "Codigo_Interno"                =>  $row['Cod_interno'],
                 "ORDEN"                         =>  $row['orden'],
                 "Nombre_Web"                    =>  $row['nombre_web'],
                 "ID_D_A"                        =>  $row['id_DA'],
                 "Director"                      =>  $row['Director'],
                 "Email_Director"                =>  $row['emailDirector'],
                 "Token"                         =>  $row['token'],
                 "Nombre_Coordinador_Docente"    =>  $row['nombre_cordinador_curso'],
                 "ID_Coordinador_Docente"        =>  $row['usr_cordinador_curso'],
                 "Email_Coordinador_Docente"     =>  $row['email_cordinador_curso'],
                 "Telefono_Coordinador_Docente"  =>  $row['telefono_cordinador_curso'],
                 "Valor_Programa"                =>  $row['valor_diplomado'],
                 "Tipo_Moneda"                   =>  $row['moneda'],
                 "Fecha_Termino"                 =>  $row['fecha_termino'],
                 "Horas"                         =>  $row['horas'],
                 "Horas_Online"                  =>  $row['horas_online'],
                 "Horas_Pedagogicas"             =>  $row['hrs_pedagogicas'],
                 "Hora_Inicio"                   =>  $row['hora_inicio'],
                 "Hora_Termino"                  =>  $row['hora_termino'],
                 "Meta"                          =>  $row['meta'],
                 "Valor_Meta"                    =>  $row['valor_meta'],
                 "Dias"                          =>  $row['dias'],
                 "ID_Ejecutivo_Admision"         =>  $row['usr_cordinador_ad'],
                 "Nombre_Ejecutivo_Admision"     =>  $row['nom_cordinadora_admision'],
                 "Telefono_Ejecutivo_Admision"   =>  $row['telefono_cordinadora_admision'],
                 "Link_PDF"                      =>  $row['lnk_pdf'],
                 "Codigo_Sala"                   =>  $row['cod_sala'],
                 "Secretaria"                    =>  $row['secretaria'],
                 "Sala_Cafe"                     =>  $row['sala_cafe'],
                 "In_Coffee"                     =>  $row['in_coffe'],
                 "Uso_PC_s"                      =>  $row['uso_pcs'],
                 "Nivelacion"                    =>  $row['nivelacion'],
                 "Introducción"                  =>  $row['intro_DA'],
                 "Cierre"                        =>  $row['cierre'],
                 "Encuesta"                      =>  $row['encuesta'],
                 "Codigo_AUGE"                   =>  $row['cod_AUGE'],
                 "ID_Coordinador_Comercial"      =>  $row['usr_coordinador_comercial'],
                 "ID_Consultor_Corporativo"      =>  $row['usr_consultor_corp'],
                 "ID_ORDEN"                      =>  $row['ID_ORDEN'],
                 "Reglamento"                    =>  $row['reglamento'],
                 'Tipo'                          =>  $row['tipo']
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

//funcion que obtiene el nombre de la secretaria según el usuario que tenga(input)
function get_secretaria($id_secretaria){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    //obtenemos la query que nos debería dar solo una fila y la ejecutamos asignando el parametro id_secretaria(usr)
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

#Función que genera la query necesaria para encontrar a un coordinador comercial, con un parametro libre(id)
function search_cord_comercial_byid(){
    $sql_get_cord_comercial = ' SELECT 
                            c.nombre,
                            c.apellido,
                            c.usr
                                FROM intranet.usuarios_int c
                                    WHERE   c.usr = :usr_cord_comercial';

    return $sql_get_cord_comercial;
}

#Función que obtiene a un coordinador comercial según su usuario
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

#Función que genera una query según el tipo de encargado que estemos queriendo obtener
function get_query_encargados($tipo){
    $sql_data = "";

    #Si es de un tipo dado se genera su propia query
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

#Función que se encarga de obtener los encargados que puede tener un programa según su tipo y el nombre o input del usuario 
function get_data_encargados($tipo, $nombre){
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    #Generamos el nombre(n) y el apellido haciendo explode al input nombre, dejamos el nombre en la forma '%nombre%' para una busqueda más completa
    list($n, $apellido) = explode(" ", $nombre);
    $nombre = str_replace(' ', "%", $nombre);
    $nombre = '%'.$nombre.'%';

    #Obtenemos la query para buscar a los usuarios que coincidan con el nombre y con el tipo de encargado
    $sql_encargados = get_query_encargados($tipo);
    $stmt_encargados = $con->prepare($sql_encargados);
    $stmt_encargados ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_encargados->bindParam(':nombre', $nombre);

    #Si el tipo es secretaria haremos uso del nombre y apellido que separamos
    if($tipo == 'secretaria'){
        $n = '%'.$n.'%';
        $apellido = '%'.$apellido.'%';
        
        #Fijamos el nombre y el apellido para el tipo secretaria, ya que tiene las columnas de nombre y apellido por separado
        $stmt_encargados->bindParam(':nombre', $n);
        $stmt_encargados->bindParam(':apellido', $apellido);
    }
    
    #Ejecutamos la query y creamos el array para guardar a los encargados
    $stmt_encargados ->execute();

    $arr_encargados = array();

    #Mientras existan filas que procesar haremos lo sig:
    while($row = $stmt_encargados->fetch()){
        #Si es un tipo de encargado generaremos una lista diferente
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

    #Retornamos
    return $arr_encargados;
}

#Función que obtiene la query para actualizar un programa editado
function get_sql_update(){
    $sql_update = "UPDATE intranet.diplomados
    SET 	Periodo = :Periodo,
            jornada = :Horario,
            version  = :Version,
            modalidad_programa = :Modalidad,
            DIPLOMADO = :DIPLOMADO,
            tipo_programa = :Tipo_Programa,
            tipo = :Tipo,
            codcatedraab = :Siglas,
            cod_diploma = :Codigo_Programa,
            nom_diploma = :Nom_Diploma,
            area_conocimiento = :Area_Conocimiento,
            area = :Area,
            nivel = :Nivel,
            realizacion_en = :Realizacion,
            fecha_inicio = :Fecha_Inicio,
            area_negocios = :Area_Negocios,
            habilitado = :Habilitado,
            web_habilitado = :Habilitado_web,
            horario_web = :Horario_Web,
            vacantes = :Vacantes,
            nombre_web = :Nombre_Web,
            valor_diplomado = :Valor_Programa,
            moneda = :Tipo_Moneda,
            fecha_termino = :Fecha_Termino,
            horas = :Horas,
            horas_online = :Horas_Online,
            hrs_pedagogicas = :Horas_Pedagogicas,
            hora_inicio = :Hora_Inicio,
            hora_termino = :Hora_Termino,
            meta = :Meta,
            valor_meta = :Valor_Meta,
            dias = :Dias,
            lnk_pdf = :Link_PDF,
            cod_sala = :Codigo_Sala,
            sala_cafe = :Sala_Cafe,
            in_coffe = :In_Coffee,
            uso_pcs = :Uso_pcs,
            nivelacion = :Nivelacion,
            intro_DA = :Introduccion,
            cierre = :Cierre,
            encuesta = :Encuesta,
            reglamento = :Reglamento,
            usr_consultor_corp = :Usr_Consultor_Corporativo,
            marca = :Marca,
            Cod_interno = :Codigo_Interno,
            orden = :ORDEN,
            cod_AUGE = :Codigo_AUGE,
            ID_ORDEN = :ID_ORDEN,
            
            mail_envio = :mail_envio,
            id_DA = :id_DA,
            emailDirector = :emailDirector,
            Director = :Director,
            token = :token,
            nombre_cordinador_curso = :nombre_cordinador_curso,
            usr_cordinador_curso = :usr_cordinador_curso,
            email_cordinador_curso = :email_cordinador_curso ,
            telefono_cordinador_curso = :telefono_cordinador_curso,
            
            usr_cordinador_ad = :usr_cordinador_ad,
            nom_cordinadora_admision = :nom_cordinadora_admision,
            telefono_cordinadora_admision = :telefono_cordinadora_admision,
            secretaria = :secretaria,
            usr_coordinador_comercial = :usr_coordinador_comercial
            
    
    WHERE ID_DIPLOMA = :Id_Programa	";
    return $sql_update;
}

#Función que toma una variable de tipo JSON con todos los datos de un programa editado, la función se encarga de actualizar el mismo programa
#usando los parametros entregados
function update_data($update_data_JSON){
    #Decodificamos el json, es decir, lo pasamos a un array    
    $programa = json_decode($update_data_JSON, true);
    include('C:\laragon\www\form\dashboard\cn\cn_PDO.php');

    #Obtenemos la query que obtiene el programa por ID del Programa
    $sql_update_data = get_sql_update();

    #Intentamos...
    try {
        #Iniciar la query obtenida y agregar todos los datos en la query uno a uno
        $con->beginTransaction();
        $stmt_encargados = $con->prepare($sql_update_data);
        $stmt_encargados ->setFetchMode(PDO::FETCH_ASSOC);
    
        $stmt_encargados->bindParam(':Periodo',$programa['Periodo']);
        $stmt_encargados->bindParam(':Horario',$programa['jornada']);
        $stmt_encargados->bindParam(':Version', $programa['version']);
        $stmt_encargados->bindParam(':Modalidad',$programa['modalidad_programa']);
        $stmt_encargados->bindParam(':DIPLOMADO',$programa['DIPLOMADO']);
        $stmt_encargados->bindParam(':Tipo_Programa',$programa['tipo_programa']);
        $stmt_encargados->bindParam(':Tipo',$programa['tipo']);
        $stmt_encargados->bindParam(':Siglas',$programa['codcatedraab']);
        $stmt_encargados->bindParam(':Codigo_Programa', $programa['cod_diploma']);
        $stmt_encargados->bindParam(':Nom_Diploma',$programa['nom_diploma']);
        $stmt_encargados->bindParam(':Area_Conocimiento',$programa['area_conocimiento']);
        $stmt_encargados->bindParam(':Area',$programa['area']);
        $stmt_encargados->bindParam(':Nivel',$programa['nivel']);
        $stmt_encargados->bindParam(':Realizacion',$programa['realizacion_en']);
        $stmt_encargados->bindParam(':Habilitado',$programa['habilitado']);
        $stmt_encargados->bindParam(':Habilitado_web',$programa['web_habilitado']);
        $stmt_encargados->bindParam(':Horario_Web',$programa['horario_web']);
        $stmt_encargados->bindParam(':Vacantes',$programa['vacantes']);
        $stmt_encargados->bindParam(':Nombre_Web',$programa['nombre_web']);
        $stmt_encargados->bindParam(':Valor_Programa',$programa['valor_diplomado']);
        $stmt_encargados->bindParam(':Tipo_Moneda',$programa['moneda']);
        $stmt_encargados->bindParam(':Fecha_Inicio',$programa['fecha_inicio']);
        $stmt_encargados->bindParam(':Area_Negocios',$programa['area_negocios']);
        $stmt_encargados->bindParam(':Fecha_Termino',$programa['fecha_termino']);
        $stmt_encargados->bindParam(':Horas',$programa['horas']);
        $stmt_encargados->bindParam('Horas_Online',$programa['horas_online']);
        $stmt_encargados->bindParam(':Horas_Pedagogicas',$programa['hrs_pedagogicas']);
        $stmt_encargados->bindParam(':Hora_Inicio',$programa['hora_inicio']);
        $stmt_encargados->bindParam('Hora_Termino',$programa['hora_termino']);
        $stmt_encargados->bindParam(':Meta',$programa['meta']);
        $stmt_encargados->bindParam(':Valor_Meta',$programa['valor_meta']);
        $stmt_encargados->bindParam(':Dias',$programa['dias']);
        $stmt_encargados->bindParam(':Link_PDF',$programa['lnk_pdf']);
        $stmt_encargados->bindParam(':Codigo_Sala',$programa['cod_sala']);
        $stmt_encargados->bindParam(':Sala_Cafe',$programa['sala_cafe']);
        $stmt_encargados->bindParam(':In_Coffee',$programa['in_coffe']);
        $stmt_encargados->bindParam(':Uso_pcs',$programa['uso_pcs']);
        $stmt_encargados->bindParam(':Nivelacion',$programa['nivelacion']);
        $stmt_encargados->bindParam(':Introduccion',$programa['intro_DA']);
        $stmt_encargados->bindParam(':Cierre',$programa['cierre']);
        $stmt_encargados->bindParam(':Encuesta',$programa['encuesta']);
        $stmt_encargados->bindParam(':Reglamento',$programa['reglamento']);
        $stmt_encargados->bindParam(':Usr_Consultor_Corporativo',$programa['usr_consultor_corp']);
        $stmt_encargados->bindParam(':Marca',$programa['marca']);
        $stmt_encargados->bindParam(':Codigo_Interno', $programa['Cod_interno']);
        $stmt_encargados->bindParam(':ORDEN', $programa['orden']);
        $stmt_encargados->bindParam(':Codigo_AUGE',$programa['cod_AUGE']);
        $stmt_encargados->bindParam(':ID_ORDEN',$programa['ID_ORDEN']);
        $stmt_encargados->bindParam(':Id_Programa',$programa['ID_DIPLOMA']);
        $stmt_encargados->bindParam(':mail_envio',$programa['mail_envio']);
        $stmt_encargados->bindParam(':id_DA',$programa['id_DA']);
        $stmt_encargados->bindParam(':emailDirector',$programa['emailDirector']);
        $stmt_encargados->bindParam(':Director',$programa['Director']);
        $stmt_encargados->bindParam(':token',$programa['token']);
        $stmt_encargados->bindParam(':nombre_cordinador_curso',$programa['nombre_cordinador_curso']);
        $stmt_encargados->bindParam(':usr_cordinador_curso',$programa['usr_cordinador_curso']);
        $stmt_encargados->bindParam(':email_cordinador_curso',$programa['email_cordinador_curso']);
        $stmt_encargados->bindParam(':telefono_cordinador_curso',$programa['telefono_cordinador_curso']);
        $stmt_encargados->bindParam(':usr_cordinador_ad',$programa['usr_cordinador_ad']);
        $stmt_encargados->bindParam(':nom_cordinadora_admision',$programa['nom_cordinadora_admision']);
        $stmt_encargados->bindParam(':telefono_cordinadora_admision',$programa['telefono_cordinadora_admision']);
        $stmt_encargados->bindParam(':secretaria',$programa['secretaria']);
        $stmt_encargados->bindParam(':usr_coordinador_comercial',$programa['usr_coordinador_comercial']);
        
        #Ejecutamos la query
        $stmt_encargados ->execute();
        $con->commit();
    } #Si es que ocurre un error lo enseña en pantalla 
    catch (\Throwable $th) {
        echo "Mensaje de Error: " . $th->getMessage();
    }
}
?>