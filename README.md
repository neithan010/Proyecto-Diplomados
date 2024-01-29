# Proyecto-Diplomados
Proyecto que busca crear una nueva plantilla para la creación de Diplomados en la Universidad de Chile-Fen. Enfocado para el departamento de Unegocios.


# Introducción
El area de enfoque de este proyecto es la organización o entidad llamada "U-negocios" la cual una de sus 
areas o tareas es la creación/implementación/gestión de los Diplomados. Un Diplomado es un programa a seguir, el cual basiamente es un curso que imparte la FEN. Para crear un diplomado, se necesita tener conocimiento de algunos atributos importantes, estos atributos estan dentro de una base de datos llamada "intranet" la cual es gestionada por el departamento TI de U-negocios.

# Objetivos
El objetivo de este proyecto es mejorar y optimizar la creación de diplomados mediante el analisis de la base de datos Intranet de U-negocios, como tambien crear un servicio o pag web(formulario) para que la creación de nuevos Diplomados sea sencilla y editable.
Para cumplir este objetivo se analizará la tabla Diplomados y sus relacionadas, observando los atributos e identificando los mas relevantes. Acompañado de lo anterior se crearan nuevas tablas que serán necesarias para que al momento de crear el formulario se tenga orden y acceso a los mismos sin la perdida de información.

A continuación se enseñan los atributos de la tabla Diplomados de intranet (intranet.Diplomados):

# Atributos Diplomados
Los atributos serán enumerados y ordenados (a criterio propio), la estructura es la siguiente:
1. NOMBRE ATRIBUTO *(* se refiere a si es obligatorio) (Codigo SQL de busqueda):
    DESCRIPCIÓN ATRIBUTO


1. Código interno(Diplomados.Cod_interno)
    Codigo que representa un diploma Unico en la tabla

2. CECOS(Diplomados.ccos)

3. Código Diplomado(Diplomados.cod_diploma)
    Código único que identifica un Diploma, se define de la siguiente manera:
    Código abreviado.Año(2011 = 11).Semestre.X

4. Versión Diplomado(Diplomados.version)
    Se usa cuando hay más de un mismo Diplomado cursandose en el mismo semestre.

5. Orden Diplomado(Diplomados.orden)

6. Codigo Abreviado(Diplomados.codcatedraab)
    Código Diplomado pero abreviado solo a las siglas del Nombre del Diplomado.

7. Jornada Diplomado* (Diplomados.jornada)(actualizar)
    Se refiere a la jornada del Diplomado, la cual puede ser una de las siguientes opciones: 
    B, D, e, M, O, T, V, W

8. Nombre Diplomado(Diplomados.DIPLOMADOS)
    Nombre completo del diplomado que tiene el siguiente formato: TIPO Diplomado + NOMBRE ABREVIADO Diplomado.

9. Nombre Abreviado* (Diplomados.nom_diploma)
    Es el nombre del diplomado sin su tipo.

10. Nombre Web (Diplomados.nom_web)
    Nombre que aparece en la pagina web de U-negocios(puede no ser el mismo que los anteriores).

11. tipo* (Diplomados.tipo) (actualizar)
    Es el tipo de programa que deberia ser(Atributo no optimizado). Los posibles tipos son:
    B-Learning, Charla, CharlaFEN, Consultoria, Curso, Curso Conducente,
    Curso sin nota, Diploma, Fen, Online, Programa, Taller, Workshop

12. Nombre Coordinador postulación* (Diplomados.nom_coordnador_admisión)
    Se llama en realidad Ejecutivo de Admisión.

13. Telefono Coordinador postulación (Diplomados.telefono_coordinador_admision)

14. Mail envio postulacion (Diplomados.mail_envio)

15. Deshabilitado (Diplomados.habilitado)
    Indica si esta habilitado o no el diplomado, esta en formato binario.

16. Programa Web Habilitado (Diplomados.web_habilitado) 
    Indica si esta habilitado o no un diplomado Online.

17. ID Director Academico (Diplomados.ID_DA)

18. Director Academico* (Diplomados.Director)

    MARCA: No se usa, y no se usará.

19. ID coordinador curso (Diplomados.usr_coordinador_id)

20. Nombre Coordinador curso* (Diplomados.nombre_coordinador_curso)
    Se llama en realidad Coordinador Docente.

21. Telefono Coordinador curso (Diplomados.telefono_coordinador_curso)

22. Email Coordinador curso (Diplomados.email_coordinador_curso)

23. token

24. Costo Diplomado (Diplomados.valor_diplomado)

25. Tipo de Moneda  (Diplomados.moneda)

26. Periodo Diplomado* (Diplomados.periodo)
    El periodo especifica el año y el semestre en el cual se dictó o dictara el Diplomado, su formato es: 'Año+S+1/2'.

27. Fecha Inicio Diplomado* (Diplomados.fecha_inicio)
    Es la fecha(tentativa) a la cual el Diplomado puede iniciar sus actividades/catedras/etc.

28. Fecha Termino Diplomado (Diplomados.fecha_termino)
    Fecha en la cual debe terminar el Diplomado.

29. Horas Totales Diplomado (Diplomados.horas)

30. Horas Totales Online Diplomado (Diplomado.horas_online)

31. CODSENCE 
    Se usa solo para programas corporativos.

32. Horas Pedagogicas (Diplomados.hrs_pedagogicas)
    Opcional.

33. Hora de Inicio clase (Diplomados.hora_inicio)
    Moda de la hora de inicio de las clase.

34. Hora de Termino clase (Diplomados.hora_termino)
    Moda de la hora de termino de las clase.

35. Vacantes totales* (Diplomados.vacantes)
    Número de estudiantes que deben estudiar.

36. Metas de ingresos (Diplomados.metas)
    

37. Valor Metas de ingresos (Diplomados.valor_meta)


38. DIAS


39. Periodicidad (Diplomados.periodicidad)
    Dice si hay 2 bloques de clase contiguos

40. DURACIÓN HORAS
    -

41. Descripción Horario Web* (Diplomados.horario_web)
    Descripción del horario en la pag web.

42. area* (Diplomados.area) (actualizar)
    Abreviación del area del Diplomado, puede ser los siguientes tipos:
    B-L, CHAR, COR, CUR, EMP, ENGIN, FEN, FIN, GDN, INEM, MKT, NIV, OPLO, PRG, RRHH, SLD, XXX.

43. area_conocimiento (Diplomados.area_conocimiento) (actualizar)
    Area del Diplomado, puede ser los siguientes tipos:
    Consultoria, Corporativa, Corporativo, Dirección de Instituciones de Salud, 
    Direción de Personas y Equipos, Estrategia y Gestión, Estrategia y Gestión de Negocios,
    Finanzas, Finanzas e Inversiones, Gestión de Instituciones de Salud, Innovación y Emprendimiento, Management, Marketing y Venta, Marketing y Ventas, Operaciones y Logística,
    Operaciones y Logística+ENTER, Personas y Equipos, Sostenibilidad, Taller.

44. Link pdf


45. Codigo de Sala (Diplomados.cod_sala)

46. Secretaria (Diplomados.secretaria) (Encargado Asistencia)


47. Sala Coffee Break (Diplomados.sala_cafe)

48. Detalles/Hora Coffee Break (Diplomados.in_coffee)

49. Uso de Computadores* (Diplomados.uso_pcs)
    En formato binario, enseña si el Diplomado necesita computadores.

50. Nivelación* (Diplomados.nivelacion)
    En formato binario, enseña si el Diplomado necesita nivelación.

51. Introducción Diplomado* (Diplomados.intro_DA)
    En formato binario, enseña si el Diplomado necesita una Introducción.

52. Cierre Diplomado* (Diplomados.cierre)
    En formato binario, enseña si el Diplomado necesita un Cierre.

53. Encuesta del Diplomado* (Diplomados.encuesta)
    En formato binario, enseña si el Diplomado necesita una Encuesta.

54. cod_AUGE

55. Realización Diplomado* (Diplomados.realización_en) (actualizar)
    Enseña donde se realizará el Diplomado. Los tipos de realizaciones son:
    B-Learning, FEN, FUERA, INTERNACIONAL, Oriente, OrienteFen, NULL.

56. Ultima Modificación (Diplomados.ultima_modificacion)
    Enseña la fecha en que fue modificado por ultima vez el Diplomado.

57. Coordinador Comercial* (Diplomados.usr_coordinador_comercial)

58. Coordinador Docente Corporativo* (Diplomados.usr_coordinador_ corp)
    Persona de la Empresa que esta encargada

59. tipo de Programa* (Diplomados.tipo_programa) (actualizar)
    Es el tipo de programa, que puede ser:
    B-Learning, Certificación, Charla, Consultoria, Curso, Curso Conducente, Curso Virtual,
    Diploma, FEN, Programa, Simposio, Sumit, Taller, Workshop, NULL.


60. Modalidad del Programa* (Diplomados.modalidad_progama) (actualizar)
    Es el modo en el que se impartiran las clases o catedras, los tipos que puede ser son:
    B-Learning, Curso, Mixto, Online, Presencial, Taller, Virtual, Vitual, NULL.

61. ID_ORDEN
    -

62. Area de Negocios (Diplomados.area_conocimiento)
    Es el area de desempeño del Diplomado, los tipos que pueden ser son:
    Finanzas, Marketing y Venta, Dirección de Personas y Equipos, Management, _, 
    Dirección de Instituciones de Salud, Consultoría, Corporativa, Sostenibilidad, Taller,
    Marketing y Ventas, Finanzas e Inversiones, Personas y Equipos, Operaciones y Logística,
    Estrategia y Gestión de Negocios, Finanzas e Inversiones x2, Innovación y Emprendimiento,
    Estrategia y Gestión, Operaciones y Logística, Gestión de Instituciones de Salud, Corporativo.

63. CUENTA_CONTABLE

64. Solicitud CECO (Diplomados.fecha_solicitud_ceco)
    Fecha en la cual se solicita el CECO.

65. Asignación CECO (Diplomados.fecha_asignación_ceco)
    Fecha en la que se le asigna el CECO.

66. Reglamento* (Diplomados.reglamento)
    Se indica en binario, si se aplica el reglamento para el diplomado.

# Complicaciones
Como se puede ver hay muchas columnas redundantes y poco intuitivas de manejar, por lo cual se creará una nueva tabla "Diplomados_niveles"
Pero antes de ello