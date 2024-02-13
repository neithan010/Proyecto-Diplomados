<?php

include('functions_program.php');
#Aqui ya tenemos los datos necesarios para insertar un programa nuevo.
#Aqui debemos insertar el programa nuevo completando todos los campos necesarios.

$siglas = $generate_siglas($nombre_programa);
#cod_diploma = Siglas Nombre.Siglas Años.1 o 2(semestre).Modalidad+versión(1 o 2).
#DIPLOMADO = consultar
#d.tipo
#area = ver siglas
#area_negocios = Ejecutiva/Corporativa
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
                    
                    d.codcatedraab AS Siglas_Nombre,
                    d.cod_diploma,
                    d.DIPLOMADO,
                    d.version,
                    d.Habilitado,
                    d.web_habilitado,
                    d.area,
                    d.area_negocios)

                    VALUES ($nombre_programa, $tipo_producto, $area, $tipo_programa, $modalidad,
                            $periodo, $jornada, $nivel, $realizacion_en, $fecha_de_inicio,
                            siglas, cod_diploma, cod_interno, DIPLOMADO, version,
                            1, 0, area, Ejecutiva)";
?>