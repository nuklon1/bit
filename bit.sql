-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.19 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных bit
CREATE DATABASE IF NOT EXISTS `bit` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bit`;

-- Дамп структуры для таблица bit.payment_history
CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `user_card_id` int unsigned NOT NULL DEFAULT '0',
  `sum` int NOT NULL DEFAULT '0' COMMENT 'Сумма при текущей операции',
  `balance_before` int NOT NULL DEFAULT '0',
  `balance_after` int NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Тип операции (пополнение/вывод)',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_card_id` (`user_card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='История транзакций';

-- Дамп данных таблицы bit.payment_history: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `payment_history` DISABLE KEYS */;
INSERT INTO `payment_history` (`id`, `user_id`, `user_card_id`, `sum`, `balance_before`, `balance_after`, `type`) VALUES
	(1, 1, 1, 100, 0, 100, 1),
	(2, 1, 1, -5, 100, 95, 2),
	(3, 1, 1, -10, 95, 85, 2),
	(4, 1, 1, -5, 85, 80, 2),
	(5, 1, 1, -10, 80, 70, 2);
/*!40000 ALTER TABLE `payment_history` ENABLE KEYS */;

-- Дамп структуры для таблица bit.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы bit.user: 0 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
	(1, 'Лунтик', 'luntik@mail.ru', '$2y$10$oX0V8mcsYEKRD/nY2chlHetjbgf1zos4HJW9KTihn3P8ywS8h2cZ.'),
	(2, 'Кузя', 'kuzya@mail.ru', '$2y$10$XPTLJptDRPKBugY7yoNdJurqYcenumQDI4gjJODQ/rP1sAr6uMZ/i');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Дамп структуры для таблица bit.user_card
CREATE TABLE IF NOT EXISTS `user_card` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT '0',
  `balance` int DEFAULT NULL,
  `number` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы bit.user_card: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user_card` DISABLE KEYS */;
INSERT INTO `user_card` (`id`, `user_id`, `balance`, `number`) VALUES
	(1, 1, 70, '1000 6000 2500 0001'),
	(3, 2, 200, '2000 6000 2000 0001');
/*!40000 ALTER TABLE `user_card` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
