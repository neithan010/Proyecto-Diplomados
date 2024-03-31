<?php
#Aqui ya tenemos los datos necesarios para insertar un programa nuevo.
#Aqui debemos insertar el programa nuevo completando todos los campos necesarios.

/**
 * nom_diploma     = nombre_programa
 * tipo_producto   = tipo_programa
 * area            = area_conocimiento
 * tipo_porgrama   = tipo 
 * modalidad       = modalidad_programa
 * periodo         = Periodo
 * jornada         = horario
 * nivel           = nivel
 * realizacion_en  = realizacion_en
 * fecha_de_inicio = fecha_inicio
 * version         = version
**/
#Se crea el sql que inserta una fila en la tabla de diplomados
$sql_insert_program = "INSERT INTO intranet.diplomados 
                        (nom_diploma, 
                        tipo_programa,
                        area_conocimiento,
                        tipo,
                        modalidad_programa,
                        Periodo,
                        jornada,
                        nivel,
                        realizacion_en,
                        fecha_inicio,
                        version,
                        codcatedraab,
                        cod_diploma,
                        area_negocios,

                        DIPLOMADO,
                        mail_envio,
                        Habilitado,
                        web_habilitado,
                        marca,
                        horario_web,
                        area,
                        vacantes,
                        usr_cordinador_ad,
                        nom_cordinadora_admision,
                        telefono_cordinadora_admision)
        
                        VALUES (:DIPLOMADO, 
                                :tipo_producto, 
                                :area, 
                                :tipo_programa, 
                                :modalidad,
                                :periodo, 
                                :jornada, 
                                :nivel, 
                                :realizacion_en, 
                                :fecha_de_inicio,
                                :version,
                                :cod_diploma, 
                                :siglas,
                                'Ejecutiva',

                                :nombre_programa,
                                :mail_envio,
                                1,
                                0,
                                0,
                                '',
                                :siglas_area,
                                35,
                                :usr_cordinador_ej,
                                :nom_ejecutivo_admision,
                                :telefono_ejecutivo_admision)";

#Aqui obtenemos todas las variables del archivo post_data.php para crear un programa desde 0 y las agregamos
#En la consulta sql hay valores por defecto modificables, como por ejemplo los cupos, que son 35 por default.
$stmt_insert_program = $con->prepare($sql_insert_program);
$stmt_insert_program->setFetchMode(PDO::FETCH_ASSOC);
$stmt_insert_program->bindParam(':DIPLOMADO', $nom_diploma);
$stmt_insert_program->bindParam(':tipo_producto', $tipo_producto);
$stmt_insert_program->bindParam(':area', $area);
$stmt_insert_program->bindParam(':tipo_programa', $tipo_programa);
$stmt_insert_program->bindParam(':modalidad', $modalidad);
$stmt_insert_program->bindParam(':periodo', $periodo);
$stmt_insert_program->bindParam(':jornada', $jornada);
$stmt_insert_program->bindParam(':nivel', $nivel);
$stmt_insert_program->bindParam(':realizacion_en', $realizacion_en);
$stmt_insert_program->bindParam(':fecha_de_inicio', $fecha_de_inicio);
$stmt_insert_program->bindParam(':version', $version);
$stmt_insert_program->bindParam(':cod_diploma', $siglas);
$stmt_insert_program->bindParam(':siglas', $new_cod_diploma);
$stmt_insert_program->bindParam(':nombre_programa', $DIPLOMADO);
$stmt_insert_program->bindParam(':siglas_area', $siglas_area);
$stmt_insert_program->bindParam(':mail_envio', $mail_envio);
$stmt_insert_program->bindParam(':usr_cordinador_ej', $usr_cordinador_ej);
$stmt_insert_program->bindParam(':nom_ejecutivo_admision', $nom_ejecutivo_admision);
$stmt_insert_program->bindParam(':telefono_ejecutivo_admision', $telefono_ejecutivo_admision);
$stmt_insert_program->execute();
?>