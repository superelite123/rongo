-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for rongo
CREATE DATABASE IF NOT EXISTS `rongo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `rongo`;

-- Dumping structure for table rongo.shippers
DROP TABLE IF EXISTS `shippers`;
CREATE TABLE IF NOT EXISTS `shippers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rongo.shippers: ~2 rows (approximately)
/*!40000 ALTER TABLE `shippers` DISABLE KEYS */;
INSERT INTO `shippers` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, '高橋 美加子', NULL, NULL),
	(2, '美加子高橋 ', NULL, NULL);
/*!40000 ALTER TABLE `shippers` ENABLE KEYS */;

-- Dumping structure for table rongo.shipp_days
DROP TABLE IF EXISTS `shipp_days`;
CREATE TABLE IF NOT EXISTS `shipp_days` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `day` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rongo.shipp_days: ~5 rows (approximately)
/*!40000 ALTER TABLE `shipp_days` DISABLE KEYS */;
INSERT INTO `shipp_days` (`id`, `day`, `created_at`, `updated_at`) VALUES
	(1, 1, '2020-07-24 11:12:44', '2020-07-24 11:12:54'),
	(2, 2, '2020-07-24 11:12:45', '2020-07-24 11:12:53'),
	(3, 3, '2020-07-24 11:12:46', '2020-07-24 11:12:52'),
	(4, 4, '2020-07-24 11:12:47', '2020-07-24 11:12:51'),
	(5, 5, '2020-07-24 11:12:48', '2020-07-24 11:12:50');
/*!40000 ALTER TABLE `shipp_days` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
