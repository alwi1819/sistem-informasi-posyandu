-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 09:07 AM
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
-- Database: `posyandu_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$q52KH9k4hETN4xKXYPZ7ge/KyPr/R4.odPkLjjAyg9f0LkO9wIjp.', 'admin123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `balita`
--

CREATE TABLE `balita` (
  `id_balita` int(11) NOT NULL,
  `nama_balita` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balita`
--

INSERT INTO `balita` (`id_balita`, `nama_balita`, `tanggal_lahir`, `jenis_kelamin`, `nama_ibu`, `alamat`) VALUES
(10, 'Rafi', '2023-06-12', 'Laki-laki', 'Ani', 'Ds. Suka Maju RT.01 RW.02'),
(11, 'Lila', '2024-02-05', 'Perempuan', 'Dewi', 'Ds. Suka Maju RT.02 RW.02'),
(12, 'Bayu', '2022-11-20', 'Laki-laki', 'Ratna', 'Ds. Suka Maju RT.03 RW.01'),
(13, 'Sinta', '2023-08-30', 'Perempuan', 'Maya', 'Ds. Melati RT.01 RW.03'),
(14, 'Danu', '2024-03-15', 'Laki-laki', 'Sari', 'Ds. Melati RT.02 RW.03'),
(15, 'Mila', '2023-12-01', 'Perempuan', 'Rini', 'Ds. Mawar RT.01 RW.01'),
(16, 'Arif', '2022-06-10', 'Laki-laki', 'Tuti', 'Ds. Mawar RT.03 RW.02'),
(17, 'Nina', '2024-01-22', 'Perempuan', 'Lilis', 'Ds. Kenanga RT.01 RW.01'),
(18, 'Farel', '2023-04-18', 'Laki-laki', 'Nadya', 'Ds. Kenanga RT.02 RW.01'),
(19, 'Putri', '2022-09-09', 'Perempuan', 'Yuni', 'Ds. Kencana RT.01 RW.02'),
(20, 'Irfan', '2023-11-11', 'Laki-laki', 'Eka', 'Ds. Kencana RT.02 RW.02'),
(21, 'Alya', '2024-05-05', 'Perempuan', 'Hani', 'Ds. Melur RT.01 RW.01'),
(22, 'Bima', '2023-02-14', 'Laki-laki', 'Vina', 'Ds. Melur RT.02 RW.01'),
(23, 'Sari', '2022-12-25', 'Perempuan', 'Lina', 'Ds. Anggrek RT.01 RW.03'),
(24, 'Tio', '2023-07-07', 'Laki-laki', 'Indah', 'Ds. Anggrek RT.02 RW.03');

-- --------------------------------------------------------

--
-- Table structure for table `pengukuran`
--

CREATE TABLE `pengukuran` (
  `id` int(11) NOT NULL,
  `id_balita` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tinggi` decimal(6,2) DEFAULT NULL,
  `berat` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengukuran`
--

INSERT INTO `pengukuran` (`id`, `id_balita`, `tanggal`, `tinggi`, `berat`) VALUES
(5, 10, '2025-12-01', 72.00, 9.60),
(6, 11, '2025-12-01', 65.00, 7.80),
(7, 12, '2025-12-01', 85.00, 11.20),
(8, 13, '2025-12-01', 70.00, 8.90),
(9, 14, '2025-12-01', 60.00, 7.00),
(10, 15, '2025-12-01', 68.00, 8.10),
(11, 16, '2025-12-01', 90.00, 12.50),
(12, 17, '2025-12-01', 63.00, 7.40),
(13, 18, '2025-12-01', 75.00, 9.90),
(14, 19, '2025-12-01', 82.00, 11.00),
(15, 20, '2025-12-01', 69.00, 8.30),
(16, 21, '2025-12-01', 58.00, 6.80),
(17, 22, '2025-12-01', 78.00, 10.20),
(18, 23, '2025-12-01', 66.00, 7.60),
(19, 24, '2025-12-01', 71.00, 9.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'user', '$2y$10$QOfJJs9AapRd.AwNBjx72OUmOtoIIfv7HkXSjqJXBTwBS0mfkamRu', '2025-12-31 03:54:49', 'user123@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `balita`
--
ALTER TABLE `balita`
  ADD PRIMARY KEY (`id_balita`);

--
-- Indexes for table `pengukuran`
--
ALTER TABLE `pengukuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_balita` (`id_balita`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `balita`
--
ALTER TABLE `balita`
  MODIFY `id_balita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pengukuran`
--
ALTER TABLE `pengukuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengukuran`
--
ALTER TABLE `pengukuran`
  ADD CONSTRAINT `pengukuran_ibfk_1` FOREIGN KEY (`id_balita`) REFERENCES `balita` (`id_balita`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
