SELECT m.modalidad
FROM intranet.modalidad_diplomados m
WHERE m.modalidad = 'Presencial' OR
		m.modalidad = 'B-Learning' OR
		m.modalidad = 'E-Learning' OR
		m.modalidad = 'Virtual' OR
		m.modalidad = 'Mixto' OR 
		m.modalidad = 'Híbrido'