#Query para insertar un nuevo programa
SELECT 
		#Atributos para crear formulario
		 d.ID_DIPLOMA,
		 d.nom_diploma AS Nombre, 
		 d.tipo_programa AS Producto,
		 d.area_conocimiento AS Area,
		 d.tipo_programa,
	    d.modalidad_programa AS Modalidad,
	    d.Periodo,
	    d.jornada AS Horario,
		 d.nivel AS Nivel,
		 d.realizacion_en AS Realización,
		 d.fecha_inicio,
		 
		 #Atributos a completar cuando se crea formulario.
		 d.codcatedraab AS Siglas_Nombre,
		 #cod_diploma = Siglas Nombre.Siglas Años.1 o 2(semestre).Modalidad+versión(1 o 2).
		 d.cod_diploma,
		 #Cod_interno = consultar
		 d.Cod_interno,
		 #DIPLOMADO = consultar
		 d.DIPLOMADO,
		 d.version,
		 d.orden,
		 #d.tipo,
		 d.Habilitado,
		 d.web_habilitado,
		 #area = ver siglas
		 d.area,
		 #area_negocios = Ejecutiva/Corporativa
		 d.area_negocios
FROM intranet.diplomados d