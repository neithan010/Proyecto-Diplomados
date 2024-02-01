SELECT 	un.ID_POSTULACION,
			un.POSTULACION,
			un.NOMBRES,
			un.APELLIDO_PAT,
			un.APELLIDO_MAT,
			un.RUT,
			un.EMAIL,
CASE concat(un.etapa,un.estado)
            WHEN '00' THEN 'Post. Nueva'
            WHEN '01' THEN 'Pre postulacion'
            WHEN '02' THEN 'Pre postulacion'
            WHEN '1011' THEN 'Pre postulacion Eliminada'
            WHEN '1010' THEN 'Eliminada'
            WHEN '1030' THEN 'En Evaluacion'
            WHEN '2020' THEN 'Aceptada'
            WHEN '2030' THEN 'Rechazado'
            WHEN '2040' THEN 'Pendiente DA'
            WHEN '3010' THEN 'Retirado'
            WHEN '3030' THEN 'Matriculado'
            WHEN '3131' THEN 'Mat. Pendiente Cierre'
            WHEN '4020' THEN 'Postergado'
            WHEN '99' THEN 'S/I'
            ELSE CONCAT(un.etapa,un.estado)
        END Estado_Postulacion

			
 FROM unegocios_nuevo.postulacion un
	WHERE un.FECHA_POST BETWEEN '2024-01-01'AND '2024-01-31'
	
	ORDER BY un.etapa, un.estado