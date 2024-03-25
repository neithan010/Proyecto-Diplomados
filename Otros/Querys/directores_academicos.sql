-- --------------------------------------------------------
-- Host:                         172.16.206.12
-- Versión del servidor:         5.6.11 - MySQL Community Server (GPL) by PowerStack
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para intranet
CREATE DATABASE IF NOT EXISTS `intranet` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `intranet`;

-- Volcando estructura para vista intranet.directores_academicos
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `directores_academicos` (
	`id_DA` INT(11) NULL,
	`emailDirector` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci',
	`nombre` VARCHAR(152) NULL COLLATE 'latin1_swedish_ci',
	`email` VARCHAR(60) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista intranet.directores_academicos
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `directores_academicos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `directores_academicos` AS select distinct `d`.`id_DA` AS `id_DA`,`d`.`emailDirector` AS `emailDirector`,concat_ws(' ',`pf`.`Nombre`,`pf`.`ApellidoPaterno`,`pf`.`ApellidoMaterno`) AS `nombre`,`e`.`email` AS `email` from ((`diplomados` `d` join `profesores` `pf` on((`d`.`id_DA` = `pf`.`ID_PROFESOR`))) join `email_profesores` `e` on((`e`.`id_profesor` = `pf`.`ID_PROFESOR`))) where (`d`.`cod_diploma` like '%.24.%') order by `nombre`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
