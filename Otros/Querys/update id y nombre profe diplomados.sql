#Obtener id de cada profesor segun los mail en los diplomas


		Update intranet.diplomados d
		left JOIN (intranet.email_profesores ep 
		INNER JOIN intranet.profesores p ON ep.id_profesor = p.ID_PROFESOR )diplomados
		on
		d.emailDirector = ep.email
		SET d.id_DA = ep.id_profesor, d.Director = CONCAT (p.Nombre ,' ', p.ApellidoPaterno)
		WHERE d.id_DA IS NULL