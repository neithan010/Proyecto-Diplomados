SELECT d.cod_diploma,
		 d.cod_interno AS CECO,
		 d.DIPLOMADO AS Nombre,
	    d.area_conocimiento,
		 d.tipo_programa AS producto,
		 d.tipo,
		 d.modalidad_programa AS modalidad,
		 CASE 
		 	WHEN d.jornada = 'T' THEN 'PM'
		   WHEN d.jornada = 'M' THEN 'AM'
		   WHEN d.jornada = 'E' THEN 'Tu decides'
		   WHEN d.jornada = 'V' THEN 'PM'
		   WHEN d.jornada = 'W' THEN 'WK'
		   ELSE 'Jornada no Definida'
		   END AS horario,
		 
		 d.nivel,
		 CASE
		 	WHEN d.Periodo = '2024S1' THEN 'Primer Semestre'
		 	WHEN d.Periodo = '2024S2' THEN 'Segundo Semestre'
		 	ELSE 'Sin Periodo'
		 	END AS Semestre,
		 	
		 d.fecha_inicio,
	    d.fecha_termino,
	    d.horario_web
		   
		 FROM intranet.diplomados d 
		 WHERE (d.Periodo = '2024S1' OR d.Periodo = '2024S2') AND d.Habilitado = 0  AND d.web_habilitado = 0 AND d.area_negocios = 'Ejecutiva'
		 ORDER BY FIELD (d.tipo_programa, 'Programa','Diploma', 'Curso', 'Curso Conducente', 'Taller'),  d.jornada