-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 09:06 AM
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
-- Database: `db_ptpn4regional3`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `id` bigint(20) NOT NULL,
  `nama_grade` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`id`, `nama_grade`, `jenis`, `created_at`) VALUES
(1, 'Plasma (Plasma Tua)', 'PLSM', NULL),
(2, 'MBJ (Matahari Berkah Jaya)', 'PLSM', NULL),
(3, 'PSR-E (Marga Bhakti)', 'PLSM', NULL),
(4, 'PSR (Tani Makmur)', 'PLSM', NULL),
(5, 'PSR (Karya Sawit)', 'PLSM', NULL),
(6, 'PSR (Majapahit)', 'PLSM', NULL),
(7, 'PSR (Tandan Mas Jaya)', 'PLSM', NULL),
(8, 'PSR (Tunas Muda)', 'PLSM', NULL),
(9, 'PSR (Budi Sawit)', 'PLSM', NULL),
(10, 'PSR (Lembah Sawit)', 'PLSM', NULL),
(11, 'PSR (Karya Tani)', 'PLSM', NULL),
(12, 'PSR (Makarti Jaya 2019)', 'PLSM', NULL),
(13, 'PSR (Makarti Jaya 2020)', 'PLSM', NULL),
(14, 'PSR (Wisma Tani)', 'PLSM', NULL),
(15, 'PSR (Subur Makmur)', 'PLSM', NULL),
(16, 'PSR (Gemah Ripah)', 'PLSM', NULL),
(17, 'Revit (Karya Darma III)', 'PLSM', NULL),
(18, 'Revit (Tunas Karya)', 'PLSM', NULL),
(19, 'Revit (Karya Mukti)', 'PLSM', NULL),
(20, 'Revit (Dayo Mukti)', 'PLSM', NULL),
(21, 'Revit (Tani Sejahtera)', 'PLSM', NULL),
(22, 'A1', 'PHTG', NULL),
(23, 'A2', 'PHTG', NULL),
(24, 'A3', 'PHTG', NULL),
(25, 'A1+', 'PHTG', NULL),
(26, 'A+', 'PHTG', NULL),
(27, 'BROND A', 'PHTG', NULL),
(28, 'BROND B', 'PHTG', NULL),
(29, 'ASS', 'PHTG', NULL),
(30, 'SIP', 'PHTG', NULL),
(31, 'FND', 'PHTG', NULL),
(32, 'EH', 'PHTG', NULL),
(33, 'BTA', 'PHTG', NULL),
(34, 'Ring 2 A1', 'PHTG', NULL),
(35, 'Ring 2 A2', 'PHTG', NULL),
(36, 'Ring 1 A1', 'PHTG', NULL),
(37, 'Ring 1 A2', 'PHTG', NULL),
(38, 'Kebun Plasma', 'PLSM', NULL),
(39, 'Plasma 2', 'PLSM', NULL),
(40, 'A2 KKPA', 'PHTG', NULL),
(41, 'A+1', 'PHTG', NULL),
(42, 'A+2', 'PHTG', NULL),
(43, 'A+3', 'PHTG', NULL),
(44, 'A+4', 'PHTG', NULL),
(45, 'A+5', 'PHTG', NULL),
(46, 'A+6', 'PHTG', NULL),
(47, 'A+7', 'PHTG', NULL),
(48, 'A+8', 'PHTG', NULL),
(49, 'A+P', 'PHTG', NULL),
(50, 'Plasma (Bina Tani Makmur)', 'PLSM', NULL),
(51, 'Plasma (Kusuma Bakti Mandiri)', 'PLSM', NULL),
(52, 'Plasma (Tri Manuggal)', 'PLSM', NULL),
(53, 'Plasma (Karya Maju)', 'PLSM', NULL),
(54, 'Plasma (GPJ(A+P))', 'PLSM', NULL),
(55, 'Plasma (GPJ(A+P1))', 'PLSM', NULL),
(56, 'PSR TM II (KUD Tani Makmur)', 'PLSM', NULL),
(57, 'A1+ SUKRI', 'PHTG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembelian_cpo_pk`
--

CREATE TABLE `tb_pembelian_cpo_pk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_unit` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `grade` varchar(50) NOT NULL,
  `harga_cpo` float DEFAULT NULL,
  `harga_pk` float DEFAULT NULL,
  `rendemen_cpo` float DEFAULT NULL,
  `rendemen_pk` float DEFAULT NULL,
  `biaya_olah` float DEFAULT NULL,
  `tarif_angkut_cpo` float DEFAULT NULL,
  `tarif_angkut_pk` float DEFAULT NULL,
  `biaya_angkut_jual` float DEFAULT NULL,
  `harga_escalasi` float DEFAULT NULL,
  `total_rendemen` float GENERATED ALWAYS AS (`rendemen_cpo` + `rendemen_pk`) STORED,
  `pendapatan_cpo` float GENERATED ALWAYS AS (`harga_cpo` * (`rendemen_cpo` / 100)) STORED,
  `pendapatan_pk` float GENERATED ALWAYS AS (`harga_pk` * (`rendemen_pk` / 100)) STORED,
  `total_pendapatan` float GENERATED ALWAYS AS (`pendapatan_cpo` + `pendapatan_pk`) STORED,
  `biaya_produksi` float GENERATED ALWAYS AS (`biaya_olah` / 100 * (`rendemen_cpo` + `rendemen_pk`)) STORED,
  `total_biaya` float GENERATED ALWAYS AS (`biaya_produksi` + `biaya_angkut_jual`) STORED,
  `harga_penetapan` float GENERATED ALWAYS AS (`total_pendapatan` - `total_biaya`) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `margin` float GENERATED ALWAYS AS (round((1 - `harga_escalasi` / nullif(`harga_penetapan`,0)) * 100,2)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembelian_cpo_pk`
--

INSERT INTO `tb_pembelian_cpo_pk` (`id`, `kode_unit`, `tanggal`, `grade`, `harga_cpo`, `harga_pk`, `rendemen_cpo`, `rendemen_pk`, `biaya_olah`, `tarif_angkut_cpo`, `tarif_angkut_pk`, `biaya_angkut_jual`, `harga_escalasi`, `created_at`, `updated_at`) VALUES
(1, '3E06', '2025-08-01', 'PSR (Gemah Ripah)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 01:23:11', '2025-08-12 01:23:11'),
(2, '3E06', '2025-08-05', 'PSR (Lembah Sawit)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-11 23:56:21', '2025-08-11 23:56:21'),
(3, '3E06', '2025-08-06', 'A+5', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:21:26', '2025-08-12 00:21:26'),
(4, '3E06', '2025-08-07', 'Plasma (Tri Manuggal)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:21:43', '2025-08-12 00:21:43'),
(5, '3E06', '2025-08-11', 'PSR (Makarti Jaya 2019)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:23:26', '2025-08-12 00:23:26'),
(6, '3E06', '2025-08-12', 'PSR (Makarti Jaya 2020)', 13400, 8600, 19.54, 4.2, 294.94, 171, 192.5, 35.47, 2970, '2025-08-12 00:43:22', '2025-08-12 00:43:22'),
(7, '3E06', '2025-08-12', 'Revit (Karya Darma III)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:23:45', '2025-08-12 00:23:45'),
(8, '3E06', '2025-08-13', 'PSR (Budi Sawit)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:01:25', '2025-08-12 00:01:25'),
(9, '3E06', '2025-08-14', 'A2', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:24:11', '2025-08-12 00:24:11'),
(10, '3E06', '2025-08-15', 'PSR-E (Marga Bhakti)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 00:24:29', '2025-08-12 00:24:29'),
(11, '3E06', '2025-08-28', 'PSR (Gemah Ripah)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 01:18:21', '2025-08-12 01:18:21'),
(12, '3E06', '2025-09-06', 'Plasma (Plasma Tua)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 01:16:25', '2025-08-12 01:16:25'),
(13, '3E06', '2025-09-19', 'PSR (Subur Makmur)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 01:14:06', '2025-08-12 01:14:06'),
(14, '3E06', '2025-10-08', 'PSR (Subur Makmur)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 01:01:29', '2025-08-12 01:01:29'),
(15, '3E25', '2025-08-12', 'PSR (Gemah Ripah)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 02:16:21', '2025-08-12 02:16:21'),
(16, '3E25', '2025-08-12', 'PSR (Subur Makmur)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 02:16:34', '2025-08-12 02:16:34'),
(17, '3E25', '2025-08-12', 'PSR (Budi Sawit)', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, '2025-08-12 02:16:45', '2025-08-12 02:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `id_unit` bigint(20) UNSIGNED NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `nama_distrik` varchar(255) DEFAULT NULL,
  `jenis` varchar(100) NOT NULL,
  `singkatan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`id_unit`, `kode_unit`, `nama_unit`, `nama_distrik`, `jenis`, `singkatan`, `created_at`, `updated_at`) VALUES
(6, '3E06', 'Kebun Plasma/Pembelian SGO/SPA/SGH', NULL, 'Kebun Inti', NULL, '2025-08-09 18:05:41', '2025-08-09 18:05:41'),
(7, '3E07', 'Kebun Plasma/Pembelian TPU/TME', NULL, 'Kebun Inti', NULL, '2025-08-09 18:05:41', '2025-08-09 18:05:41'),
(12, '3E12', 'Kebun Plasma/Pembelian SBT/LDA', NULL, 'Kebun Inti', NULL, '2025-08-09 18:05:41', '2025-08-09 18:05:41'),
(25, '3E25', 'Kebun Plasma/Pembelian STA/SSI/SIN/SRO', NULL, 'Kebun Inti', NULL, '2025-08-09 18:05:41', '2025-08-09 18:05:41'),
(49, '3R00', 'Kantor Regional', NULL, 'Kantor Regional', NULL, '2025-08-09 18:05:41', '2025-08-09 18:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `kode_unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `email`, `password`, `level`, `kode_unit`, `created_at`, `updated_at`) VALUES
(7, 'admin1', 'admin1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Admin', 'U01', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(8, 'asisten1', 'asisten1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Asisten', 'U02', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(9, 'manager1', 'manager1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Manager', 'U03', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(10, 'gm1', 'gm1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'General_Manager', 'U04', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(11, 'region1', 'region1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Region_Head', 'U05', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(12, 'sevp1', 'sevp1@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'SEVP', 'U06', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(13, 'admin2', 'admin2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Admin', 'U01', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(14, 'asisten2', 'asisten2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Asisten', 'U02', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(15, 'manager2', 'manager2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Manager', 'U03', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(16, 'gm2', 'gm2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'General_Manager', 'U04', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(17, 'region2', 'region2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Region_Head', 'U05', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(18, 'sevp2', 'sevp2@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'SEVP', 'U06', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(19, 'admin3', 'admin3@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Admin', 'U07', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(20, 'manager3', 'manager3@example.com', '$2y$12$abcdefghijklmnopqrstuv', 'Manager', 'U08', '2025-08-09 12:34:47', '2025-08-09 12:34:47'),
(22, 'aldi', 'aldi@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Asisten', 'ASN01', NULL, NULL),
(24, 'yusuf', 'yusuf@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'General_Manager', 'GM01', NULL, NULL),
(34, 'Muhammad Nabil', 'nabilaja@gmail.com', '$2y$12$ArX2pwR7lGkdg6kEoebZVOF4sR/p3.6s1Kdifo1.MGqjsXNzJ6MH2', 'Admin', '3E06', NULL, NULL),
(37, 'asisten', 'asisten@gmail.com', '$2y$12$qS0HOZSh.v28bQYCOiYYDu3ogZcPOTkEImedZzt8KCSpB9mZc8/6m', 'Asisten', '3R00', NULL, NULL),
(38, 'gm1234', 'gm1234@gmail', '$2y$12$7eK8cf0LyniAdzwGRtD6FOZaDbi42n.0bcFvZInIiuKD3jkcyxc1a', 'General_Manager', '3E25', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_pembelian_cpo_pk`
--
ALTER TABLE `tb_pembelian_cpo_pk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tb_pembelian_cpo_pk`
--
ALTER TABLE `tb_pembelian_cpo_pk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id_unit` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
