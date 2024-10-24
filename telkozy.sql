-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 03:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telkozy`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `nama_lengkap`, `username`, `email`, `foto_profil`, `password`, `role`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(29, 'Alip Lizal', 'aliflzl', 'aliplizal1@gmail.com', '665be8ceccb8e.jpg', '$2y$10$JAD0HYb1Y1QU..Z2LEO6BOSjZidoq1xaBaYuK16LHKuEnLzrBt0ey', 1, NULL, NULL),
(30, 'Abraham Putra', 'bramm', 'bram@gmail.com', '665be6816cdd5.jpeg', '$2y$10$WIRn7YqZWvBpBoxrq4YPhuPHdNWx1inOjUGssfOixzvVr3KjvGA8.', 1, NULL, NULL),
(31, 'Alip Lizal', 'aliplizal', 'alifputra8594@gmail.com', '665eb616312fc.jpg', '$2y$10$OvcLCic5pRx90lp.NC3gc.GTY25/jHXnrS12/IkAGA8PaAcEivUHO', 1, NULL, NULL),
(32, 'Ghina Fadhiyah', 'ghina', 'ghina@gmail.com', NULL, '$2y$10$x2xOhd8bP9BPkcoLApTdR.0JRZWcjYbhibbqh.xkkw61q6LV/X07.', 2, NULL, NULL),
(33, 'Alip Lizal', 'aliplizall', 'aliplizal@gmail.com', NULL, '$2y$10$DMtLsUkGavb1g1IS6.ilXe6enNCTXWIUFyOQRrwvA6TID1zuSISQC', 1, NULL, NULL),
(34, 'Abraham Putra', 'bram', 'bramm@gmail.com', '666653c2a1a14.jpeg', '$2y$10$QYmLsoLFN/UGhpBarLks1.aRePQ2QTwZfZdGj.ao6Z3NYpKXl8vJS', 2, NULL, NULL),
(35, 'Ria Pebrian Dini', 'riap', 'ria@gmail.com', NULL, '$2y$10$lCXEG1yJ2JEm6Ul7ELRYJeVmE7YkMnbMUOg2AjkenR7yxcDIu5oui', 2, NULL, NULL),
(36, 'Alip Lizal', 'zlyixp', 'alifputra@gmail.com', '665b59471dec9.jpg', '$2y$10$q2S1.P.0DsVCZUN6kHo8g.AotYFCHtEEJuZtaAfgj8bSGr0cDrUDO', 1, NULL, NULL),
(37, 'Abraham Putra ', 'abrahamm', 'abrahamputra@gmail.com', NULL, '$2y$10$2UrmW39Z9ccAbb9biCkWk.9a1bwWlzvxZ9ievmsEV.St0sKHVDKIm', 2, NULL, NULL),
(38, 'Abraham Putra Berman Simbolon', 'abraham', 'brammm@gmail.com', NULL, '$2y$10$oQNaz2ptSLDpq8WnOmPhKutBelnNHOOiHhIHIDg8BnWrLe307/qn6', 2, NULL, NULL),
(39, 'Ghina Fadiyah', 'gee', 'ghinaa@gmail.com', '665bf756e3aba.jpg', '$2y$10$K07Ps17DCZ//ti/9BitQguWBlXy0w1sx0BJwEcRf5rhgQU.94l2YC', 1, NULL, NULL),
(40, 'adx', 'adx', 'adx@gmail.com', NULL, '$2y$10$Ig4CtQU4RIzMybVixob27e6IwZJBTGMV0lT/NPDWGEJc4hpzsWid2', 1, NULL, NULL),
(41, 'Feli', 'felicia', 'feli@gmail.com', NULL, '$2y$10$3OmzeWTk5n.a5vFp95vml.41aKeLc054Zr2bi6y0icLyqbM.aO1mC', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `id_kost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `id_akun`, `id_kost`) VALUES
(108, 31, 3),
(109, 31, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kost`
--

CREATE TABLE `kost` (
  `id_kost` int(11) NOT NULL,
  `nama_kost` varchar(30) NOT NULL,
  `nama_daerah` enum('Sukapura','Sukabirus','PGA','Ciganitri','PBB','Mangga Dua') NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `tipe_kost` enum('Umum','Putra','Putri') NOT NULL,
  `foto_path` varchar(255) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kost`
--

INSERT INTO `kost` (`id_kost`, `nama_kost`, `nama_daerah`, `kontak`, `tipe_kost`, `foto_path`, `alamat`, `deskripsi`, `harga`, `id_akun`) VALUES
(1, 'Kost Sumberjaya', 'Sukapura', '0858711515', 'Putra', '666652fc9f05f3.38457279.jpg', 'Gedung 1 Asrama Putra Telkom University,  Jl. Sukapura No.20,  Sukapura,  Dayeuhkolot,  Bandung Regency,  West Java 40267', 'bagus, pokoknya, wkwk', 20000000, 34),
(2, 'Kost Sumberjaya', 'Sukapura', '022222222', 'Umum', '', 'Gedung 1 Asrama Putra Telkom University, Jl. Sukapura No.20, Sukapura, Dayeuhkolot, Bandung Regency, West Java 40267', 'Bagus pokonya', 20000000, 35),
(3, 'Kost Sukalaksana', 'PBB', '085211325465', 'Putra', '6666523e6ef1b6.53022991.jpg', 'Jl. Kb. Kopi No.145, Margamulya, Kec. Pangalengan, Kabupaten Bandung, Jawa Barat 40378', 'kamar mandi dalam,      wifi,      water heater,      njnj,  hvh', 20000000, 34),
(4, 'Kost Sukamaju', 'Ciganitri', '085158445876', 'Umum', '6666538f8d5cf8.07837805.jpg', 'Jl. Kb. Kopi No.145, Margamulya, Kec. Pangalengan, Kabupaten Bandung, Jawa Barat 40378', 'wc dalem,  wifi,  water heater,  kasur,  meja dll.', 25000000, 34),
(6, 'Kost Suka Berkah', 'Mangga Dua', '0', 'Putri', '', 'Jl. Telekomunikasi No.50a, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40267', 'meja rias,kursi, wifi', 12000000, 35),
(7, 'coba', 'Sukapura', '0', 'Putri', '666653a45bd763.10712463.jpg', 'coba', 'coba', 120000, 34);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'pencari'),
(2, 'pemilik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_akun` (`id_akun`),
  ADD KEY `id_kost` (`id_kost`);

--
-- Indexes for table `kost`
--
ALTER TABLE `kost`
  ADD PRIMARY KEY (`id_kost`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `kost`
--
ALTER TABLE `kost`
  MODIFY `id_kost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id_role`);

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);

--
-- Constraints for table `kost`
--
ALTER TABLE `kost`
  ADD CONSTRAINT `kost_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
