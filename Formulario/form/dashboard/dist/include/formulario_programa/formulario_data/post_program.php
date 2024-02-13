<?php

include('functions_program.php');
#Aqui ya tenemos los datos necesarios para insertar un programa nuevo.
#Aqui debemos insertar el programa nuevo completando todos los campos necesarios.

$siglas = $generate_siglas($nombre_programa);
$cod_diploma = $generate_cod_diploma($siglas, $modalidad);
#cod_diploma = Siglas Nombre.Siglas Años.1 o 2(semestre).periodo+versión.
#DIPLOMADO = consultar
#d.tipo
#area = ver siglas
#area_negocios = Ejecutiva/Corporativa

/**
 * nom_diploma     = nombre_programa
 * tipo_producto   = tipo_programa **
 * area            = area_conocimiento
 * tipo_porgrama   = tipo **
 * modalidad       = modalidad_programa
 * periodo         = Periodo
 * jornada         = horario
 * nivel           = nivel
 * realizacion_en  = realizacion_en
 * fecha_de_inicio = fecha_inicio
 * version         = version
**/
$insert_program = "INSERT INTO intranet.diplomados d
                    (d.nom_diploma AS Nombre, 
                    d.tipo_programa AS Producto,
                    d.area_conocimiento AS Area,
                    d.tipo_programa,
                    d.modalidad_programa AS Modalidad,
                    d.Periodo,
                    d.jornada AS Horario,
                    d.nivel AS Nivel,
                    d.realizacion_en AS Realización,
                    d.fecha_inicio,
                    d.version,
                    
                    d.codcatedraab AS Siglas_Nombre,
                    d.cod_diploma,
                    d.DIPLOMADO,
                    d.Habilitado,
                    d.web_habilitado,
                    d.area,
                    d.area_negocios)

                    VALUES ($nombre_programa, 
                            $tipo_producto, 
                            $area, 
                            $tipo_programa, 
                            $modalidad,
                            $periodo, 
                            $jornada, 
                            $nivel, 
                            $realizacion_en, 
                            $fecha_de_inicio,
                            $version,
                            
                            $siglas, 
                            cod_diploma, 
                            cod_interno, 
                            DIPLOMADO, 
                            1, 
                            0, 
                            area, 
                            Ejecutiva)";
?>