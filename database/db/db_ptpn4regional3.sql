-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 03:51 AM
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
-- Table structure for table `tb_pembelian_approvals`
--

CREATE TABLE `tb_pembelian_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembelian_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `harga_penetapan` decimal(15,2) DEFAULT NULL,
  `harga_escalasi` decimal(15,2) DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pembelian_approvals`
--

INSERT INTO `tb_pembelian_approvals` (`id`, `pembelian_id`, `role`, `harga_penetapan`, `harga_escalasi`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(13, 3, 'Manager', 2874.07, 2970.00, NULL, '2025-08-28 02:03:18', '2025-08-28 02:03:18', '2025-08-28 02:03:18'),
(15, 11, 'Manager', 2874.07, 2970.00, NULL, '2025-08-28 02:03:18', '2025-08-28 02:03:18', '2025-08-28 02:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembelian_cpo_pk`
--

CREATE TABLE `tb_pembelian_cpo_pk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_unit` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `status_approval_admin` tinyint(4) DEFAULT NULL,
  `status_approval_manager` tinyint(4) DEFAULT NULL,
  `status_approval_gm` tinyint(4) DEFAULT NULL,
  `status_approval_rh` tinyint(4) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `harga_cpo` float DEFAULT NULL,
  `harga_pk` float DEFAULT NULL,
  `rendemen_cpo` float DEFAULT NULL,
  `rendemen_pk` float DEFAULT NULL,
  `biaya_olah` float DEFAULT NULL,
  `tarif_angkut_cpo` float DEFAULT NULL,
  `tarif_angkut_pk` float DEFAULT NULL,
  `biaya_angkut_jual` float DEFAULT NULL,
  `harga_escalasi` float DEFAULT NULL,
  `total_rendemen` float DEFAULT NULL,
  `pendapatan_cpo` float DEFAULT NULL,
  `pendapatan_pk` float DEFAULT NULL,
  `total_pendapatan` float DEFAULT NULL,
  `biaya_produksi` float DEFAULT NULL,
  `total_biaya` float DEFAULT NULL,
  `harga_penetapan` float DEFAULT NULL,
  `margin` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembelian_cpo_pk`
--

INSERT INTO `tb_pembelian_cpo_pk` (`id`, `kode_unit`, `tanggal`, `status_approval_admin`, `status_approval_manager`, `status_approval_gm`, `status_approval_rh`, `grade`, `harga_cpo`, `harga_pk`, `rendemen_cpo`, `rendemen_pk`, `biaya_olah`, `tarif_angkut_cpo`, `tarif_angkut_pk`, `biaya_angkut_jual`, `harga_escalasi`, `total_rendemen`, `pendapatan_cpo`, `pendapatan_pk`, `total_pendapatan`, `biaya_produksi`, `total_biaya`, `harga_penetapan`, `margin`, `created_at`, `updated_at`) VALUES
(3, '3E12', '2025-08-25', NULL, 1, NULL, NULL, 'A3', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, 23.74, 2618.36, 361.2, 2979.56, 70.02, 105.49, 2874.07, -3.34, '2025-08-26 07:58:34', '2025-08-28 02:03:18'),
(6, '3E25', '2025-08-26', NULL, NULL, NULL, NULL, 'A+1', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, 23.74, 2618.36, 361.2, 2979.56, 70.02, 105.49, 2874.07, -3.34, '2025-08-27 07:24:05', '2025-08-27 07:24:05'),
(7, '3E25', '2025-08-26', NULL, NULL, NULL, NULL, 'A+2', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, 23.74, 2618.36, 361.2, 2979.56, 70.02, 105.49, 2874.07, -3.34, '2025-08-27 07:25:26', '2025-08-27 07:25:26'),
(8, '3E06', '2025-08-26', NULL, NULL, NULL, NULL, 'BROND A', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, 23.74, 2618.36, 361.2, 2979.56, 70.02, 105.49, 2874.07, -3.34, '2025-08-27 09:18:09', '2025-08-27 09:18:09'),
(11, '3E12', '2025-08-22', NULL, 1, NULL, NULL, 'A3', 13400, 8600, 19.54, 4.2, 294.94, 171, 194.5, 35.47, 2970, 23.74, 2618.36, 361.2, 2979.56, 70.02, 105.49, 2874.07, -3.34, '2025-08-28 01:55:19', '2025-08-28 02:03:18'),
(13, '3E07', '2025-08-27', NULL, NULL, NULL, NULL, 'PSR (Lembah Sawit)', 13400, 8600, 1, 1, 1, 1, 1, 1, 1, 2, 134, 86, 220, 0.02, 1.02, 218.98, 99.54, '2025-08-28 04:49:54', '2025-08-28 04:49:54'),
(14, '3E25', '2025-08-27', NULL, NULL, NULL, NULL, 'PSR (Karya Tani)', 13400, 8600, 2, 2, 2, 2, 2, 2, 2, 4, 268, 172, 440, 0.08, 2.08, 437.92, 99.54, '2025-08-28 04:50:51', '2025-08-28 04:50:51');

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
  `password` varchar(255) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `kode_unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `level`, `kode_unit`, `created_at`, `updated_at`) VALUES
(48, 'satria', '$2y$12$52eoN6VpPAi7owNH/d9jBenlDTSxB6ozJghPiI82n942E9BuQR.G.', 'Asisten', '3E07', '2025-08-28 01:34:09', '2025-08-28 04:47:59'),
(49, 'nabil', '$2y$12$LmKoW24XHLW2/nk6LVcvE.nc6rck3cLOECJuTPOGb9FEkCeUPkJze', 'Asisten', '3E25', '2025-08-28 01:34:32', '2025-08-28 01:34:32'),
(50, 'admin', '$2y$12$E1Ch3Q8HP4OJK.mP00ZC.eBp9.Yqq6zVV7IyeNIFFnV0OXfZgKY9K', 'Admin', '3R00', '2025-08-28 02:14:38', '2025-08-28 02:14:38'),
(67, 'dika', '$2y$12$qZGhEz5h3jam94.zXT36Ue./OR8OWb4.KOYP3qROg4CpQlOGLvGne', 'Manager', '3E07', '2025-08-28 04:46:14', '2025-08-28 04:48:24'),
(68, 'pajar', '$2y$12$SfkrRQLidVXQnx5iHuB6xO2cohj6ACulLwwBcm2U7kDks/ofG34IC', 'Manager', '3E25', '2025-08-28 04:46:52', '2025-08-28 04:46:52'),
(70, 'putri2', '$2y$12$oI.agm0YnH6sC9DK.p40MOL/x6DDRjXM/vvOBmUVlZLjnYFKuz4pm', 'Admin', '3E12', '2025-08-28 07:29:57', '2025-08-28 07:31:59');

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
-- Indexes for table `tb_pembelian_approvals`
--
ALTER TABLE `tb_pembelian_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pembelian_id` (`pembelian_id`),
  ADD KEY `idx_approved_by` (`approved_by`);

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
-- AUTO_INCREMENT for table `tb_pembelian_approvals`
--
ALTER TABLE `tb_pembelian_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_pembelian_cpo_pk`
--
ALTER TABLE `tb_pembelian_cpo_pk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id_unit` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pembelian_approvals`
--
ALTER TABLE `tb_pembelian_approvals`
  ADD CONSTRAINT `pembelian_approvals_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembelian_approvals_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `tb_pembelian_cpo_pk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
