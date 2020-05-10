-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "noc_notificacao" ------------------------------
CREATE TABLE `noc_notificacao`( 
	`id` Int( 11 ) UNSIGNED AUTO_INCREMENT NOT NULL,
	`IDEMPRESA` Int( 11 ) UNSIGNED NULL,
	`IDTRIGGER` Int( 11 ) UNSIGNED NULL,
	`SEVERIDADE` Int( 11 ) UNSIGNED NULL,
	`NOTIFICA_CLIENTE` Int( 2 ) NULL DEFAULT 0,
	`NOTIFICA_EMPRESA` Int( 2 ) NULL DEFAULT 0,
	`TEMPO_NOTIFICA_CLIENTE` Time NULL,
	`TEMPO_NOTIFICA_EMPRESA` Time NULL,
	`RENOTIFICA_INTERACAO` Time NULL,
	`IDEQUIPAMENTO` Int( 11 ) UNSIGNED NULL,
	CONSTRAINT `unique_id` UNIQUE( `id` ) )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- -------------------------------------------------------------


-- Dump data of "noc_notificacao" --------------------------
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


