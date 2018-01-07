-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.57-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for AlomaGo
DROP DATABASE IF EXISTS `AlomaGo`;
CREATE DATABASE IF NOT EXISTS `AlomaGo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `AlomaGo`;

-- Dumping structure for table AlomaGo.administrator
DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `foto_profil` tinytext NOT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.administrator: ~1 rows (approximately)
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` (`id`, `nama`, `username`, `password`, `foto_profil`, `token`) VALUES
	(1, 'Admin AlomaGo', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'http://localhost:3000/resources/uploads/admin.jpg', 'TOKEN_ADMIN');
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.app_info
DROP TABLE IF EXISTS `app_info`;
CREATE TABLE IF NOT EXISTS `app_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `content` longtext,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.app_info: ~6 rows (approximately)
/*!40000 ALTER TABLE `app_info` DISABLE KEYS */;
INSERT INTO `app_info` (`id`, `key`, `name`, `content`, `last_modified`) VALUES
	(1, 'privacy', 'Privacy Apps', 'Tentang Privacy<br>', '2017-08-27 22:54:28'),
	(2, 'disclaimer', 'Disclaimer Apps', 'Content Disclaimer', '2017-08-27 22:57:34'),
	(3, 'about', 'About AlomaGo', 'Tentang Aplikasi AlomaGo Indonesia<br>', '2017-08-11 14:07:37'),
	(4, 'url-1', 'Link Website', 'http://www.alomago.com', '2017-08-27 22:03:42'),
	(5, 'url-2', 'Link Playstore', 'https://play.google.com/store/apps/details?id=com.alomago.apps', '2017-08-27 22:03:42'),
	(6, 'url-3', 'Link Fanspage Facebook', 'https://www.facebok.com/alomagocom', '2017-08-27 22:03:42');
/*!40000 ALTER TABLE `app_info` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.authentication
DROP TABLE IF EXISTS `authentication`;
CREATE TABLE IF NOT EXISTS `authentication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.authentication: ~1 rows (approximately)
/*!40000 ALTER TABLE `authentication` DISABLE KEYS */;
INSERT INTO `authentication` (`id`, `key`, `description`) VALUES
	(1, '7ce523c2d1-b0TqG-5312032051', 'Free Authentication');
/*!40000 ALTER TABLE `authentication` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.berita
DROP TABLE IF EXISTS `berita`;
CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(50) DEFAULT NULL,
  `gambar` text,
  `content` longtext,
  `author` varchar(50) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `dilihat` bigint(15) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT NULL,
  `terakhir_diubah` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.berita: ~3 rows (approximately)
/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.feedback
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `pesan` text,
  `tanggal_waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.feedback: ~12 rows (approximately)
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.transfer_pulsa
DROP TABLE IF EXISTS `transfer_pulsa`;
CREATE TABLE IF NOT EXISTS `transfer_pulsa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(20) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `nomer_pengirim` varchar(15) DEFAULT NULL,
  `nomer_tujuan` varchar(15) DEFAULT NULL,
  `nominal` bigint(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.transfer_pulsa: ~3 rows (approximately)
/*!40000 ALTER TABLE `transfer_pulsa` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfer_pulsa` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.tukar_pulsa
DROP TABLE IF EXISTS `tukar_pulsa`;
CREATE TABLE IF NOT EXISTS `tukar_pulsa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT '0',
  `nomer_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.tukar_pulsa: ~0 rows (approximately)
/*!40000 ALTER TABLE `tukar_pulsa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tukar_pulsa` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `pin` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `terdaftar` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.user: ~3 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.warung_bpjs
DROP TABLE IF EXISTS `warung_bpjs`;
CREATE TABLE IF NOT EXISTS `warung_bpjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_bpjs` varchar(30) NOT NULL DEFAULT '0',
  `no_hp` varchar(15) NOT NULL DEFAULT '0',
  `total_pembayaran` int(11) NOT NULL DEFAULT '0',
  `tanggal_waktu` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.warung_bpjs: ~0 rows (approximately)
/*!40000 ALTER TABLE `warung_bpjs` DISABLE KEYS */;
/*!40000 ALTER TABLE `warung_bpjs` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.warung_pln
DROP TABLE IF EXISTS `warung_pln`;
CREATE TABLE IF NOT EXISTS `warung_pln` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_pelanggan` varchar(30) NOT NULL DEFAULT '0',
  `nominal` int(11) NOT NULL DEFAULT '0',
  `tanggal_waktu` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.warung_pln: ~0 rows (approximately)
/*!40000 ALTER TABLE `warung_pln` DISABLE KEYS */;
/*!40000 ALTER TABLE `warung_pln` ENABLE KEYS */;

-- Dumping structure for table AlomaGo.warung_pulsa
DROP TABLE IF EXISTS `warung_pulsa`;
CREATE TABLE IF NOT EXISTS `warung_pulsa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT '0',
  `nomer_tujuan` varchar(15) DEFAULT NULL,
  `tipe` enum('Paket','Pulsa') DEFAULT NULL,
  `nominal` int(11) DEFAULT '0',
  `tanggal_waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table AlomaGo.warung_pulsa: ~0 rows (approximately)
/*!40000 ALTER TABLE `warung_pulsa` DISABLE KEYS */;
/*!40000 ALTER TABLE `warung_pulsa` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
