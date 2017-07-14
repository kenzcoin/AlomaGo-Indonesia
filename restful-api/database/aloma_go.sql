-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2017 at 01:29 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aloma_go`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `content` text,
  `author` varchar(50) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT CURRENT_TIMESTAMP,
  `terakhir_diubah` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_pulsa`
--

CREATE TABLE `transfer_pulsa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `nomer_tujuan` varchar(15) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tukar_pulsa`
--

CREATE TABLE `tukar_pulsa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `nomer_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `pin` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `terdaftar` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `userFotoNull` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    IF NEW.foto = null OR NEW.foto = 'null' OR NEW.foto = '' THEN

        SET NEW.foto = "http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `warung_bpjs`
--

CREATE TABLE `warung_bpjs` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_bpjs` varchar(30) NOT NULL DEFAULT '0',
  `no_hp` varchar(15) NOT NULL DEFAULT '0',
  `total_pembayaran` int(11) NOT NULL DEFAULT '0',
  `tanggal_waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warung_pln`
--

CREATE TABLE `warung_pln` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_pelanggan` varchar(30) NOT NULL DEFAULT '0',
  `nominal` int(11) NOT NULL DEFAULT '0',
  `tanggal_waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warung_pulsa`
--

CREATE TABLE `warung_pulsa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `nomer_tujuan` varchar(15) DEFAULT NULL,
  `tipe` enum('Paket','Pulsa') DEFAULT NULL,
  `nominal` int(11) DEFAULT '0',
  `tanggal_waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_pulsa`
--
ALTER TABLE `transfer_pulsa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tukar_pulsa`
--
ALTER TABLE `tukar_pulsa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warung_bpjs`
--
ALTER TABLE `warung_bpjs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warung_pln`
--
ALTER TABLE `warung_pln`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warung_pulsa`
--
ALTER TABLE `warung_pulsa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transfer_pulsa`
--
ALTER TABLE `transfer_pulsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tukar_pulsa`
--
ALTER TABLE `tukar_pulsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warung_bpjs`
--
ALTER TABLE `warung_bpjs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warung_pln`
--
ALTER TABLE `warung_pln`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warung_pulsa`
--
ALTER TABLE `warung_pulsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
