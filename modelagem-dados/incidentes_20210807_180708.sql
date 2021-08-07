-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "incidentes" -----------------------------------
CREATE TABLE `incidentes`( 
	`ID_HOST` Int( 255 ) NOT NULL,
	`ID_INCIDENTE` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`DESCRICAO` Text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`DATA_ABERTURA` Timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`STATUS` VarChar( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`IDEMPRESA` Int( 11 ) NOT NULL,
	`ID_TRIGGER` BigInt( 20 ) NOT NULL,
	`DATA_ENCERRAMENTO` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT `unique_ID_INCIDENTE` UNIQUE( `ID_INCIDENTE` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 40;
-- -------------------------------------------------------------


-- Dump data of "incidentes" -------------------------------
BEGIN;

INSERT INTO `incidentes`(`ID_HOST`,`ID_INCIDENTE`,`DESCRICAO`,`DATA_ABERTURA`,`STATUS`,`IDEMPRESA`,`ID_TRIGGER`,`DATA_ENCERRAMENTO`) VALUES 
( '0', '13', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:12:12', 'CANCELADO', '0', '0', '2021-08-07 17:12:12' ),
( '10084', '26', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:17:51', 'RESOLVIDO', '0', '16196', '2021-08-07 17:17:45' ),
( '10358', '27', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:33', 'RESOLVIDO', '0', '16196', '2021-06-08 21:13:15' ),
( '10358', '29', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:33', 'RESOLVIDO', '0', '16196', '2021-06-08 21:32:55' ),
( '10358', '31', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:33', 'RESOLVIDO', '0', '16196', '2021-06-08 21:40:40' ),
( '10358', '33', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:34', 'RESOLVIDO', '0', '16196', '2021-06-08 21:42:35' ),
( '10358', '35', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:34', 'RESOLVIDO', '0', '16196', '2021-06-08 22:14:10' ),
( '10358', '37', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:16:34', 'RESOLVIDO', '0', '16196', '2021-08-07 17:10:15' ),
( '10358', '39', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:10:33', 'ABERTO', '0', '16196', '2021-08-07 17:12:03' ),
( '10084', '41', 'Zabbix agent is not available (for 3m)', '2021-08-07 17:18:29', 'ABERTO', '0', '16196', '2021-08-07 17:18:33' );
COMMIT;
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


