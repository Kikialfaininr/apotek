-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 07:56 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `buktipembayaran`
--

CREATE TABLE `buktipembayaran` (
  `id_bukti` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `konfirmasi` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buktipembayaran`
--

INSERT INTO `buktipembayaran` (`id_bukti`, `id_pesanan`, `foto`, `konfirmasi`, `created_at`, `update_at`) VALUES
(5, 17, 'Bukti_20240313083727.jpg', 'Terkonfirmasi', '2024-03-13 08:37:28', '2024-03-13 08:37:28'),
(6, 21, 'Bukti_20240314054821.jpg', 'Terkonfirmasi', '2024-03-14 05:48:22', '2024-03-14 05:48:22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `update_at`) VALUES
(1, 'Obat Bebas', '2024-02-06 13:22:27', '2024-02-06 13:22:27'),
(2, 'Obat Bebas Terbatas', '2024-02-06 13:22:27', '2024-02-06 13:22:27'),
(3, 'Obat Keras', '2024-02-06 13:22:27', '2024-02-06 13:22:27'),
(5, 'Vitamin', '2024-02-06 14:22:38', '2024-02-06 14:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` int(11) NOT NULL,
  `jarak_maks` int(11) NOT NULL,
  `jarak_min` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id_ongkir`, `jarak_maks`, `jarak_min`, `ongkir`, `created_at`, `update_at`) VALUES
(1, 2, 0, 0, '2024-03-14 06:49:00', '2024-03-14 06:49:00'),
(2, 5, 2, 5000, '2024-03-12 07:40:19', '2024-03-12 07:40:19'),
(3, 7, 5, 7500, '2024-03-12 07:40:39', '2024-03-12 07:40:39'),
(4, 10, 7, 10000, '2024-03-12 07:40:59', '2024-03-12 07:40:59'),
(5, 13, 10, 12500, '2024-03-12 07:41:55', '2024-03-12 07:41:55'),
(6, 15, 13, 15000, '2024-03-12 07:41:55', '2024-03-12 07:41:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_ongkir` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jarak` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id_pengiriman`, `id_pesanan`, `id_ongkir`, `alamat`, `jarak`, `ongkir`, `created_at`, `update_at`) VALUES
(6, 17, 4, 'cilacap', 9, 10000, '2024-03-13 08:36:55', '2024-03-13 08:36:55'),
(7, 18, 4, 'Purwokerto', 9, 10000, '2024-03-13 08:44:08', '2024-03-13 08:44:08'),
(8, 19, 5, 'Bandung', 12, 12500, '2024-03-13 08:59:13', '2024-03-13 08:59:13'),
(9, 21, 3, 'Cilacap', 7, 7500, '2024-03-14 05:48:08', '2024-03-14 05:48:08'),
(10, 22, 6, 'Purwokerto', 15, 15000, '2024-03-14 06:45:48', '2024-03-14 06:45:48'),
(11, 23, 1, 'Cilacap', 1, 0, '2024-03-14 06:49:38', '2024-03-14 06:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `no_order` varchar(20) NOT NULL,
  `nama_kasir` varchar(20) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `pembayaran` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_order`, `nama_kasir`, `grand_total`, `pembayaran`, `kembalian`, `metode_pembayaran`, `created_at`, `update_at`) VALUES
(40, 'OD-202402265784', 'Kasir 1', 78530, 100000, 21470, 'Tunai', '2024-02-26 13:54:09', '2024-02-26 13:54:09'),
(41, 'OD-202402266945', 'Kasir 1', 7000, 10000, 3000, 'QRIS', '2024-02-26 14:36:43', '2024-02-26 14:36:43'),
(43, 'OD-202403073643', 'Kasir 1', 10000, 12000, 2000, 'Tunai', '2024-03-07 11:20:36', '2024-03-07 11:20:36'),
(44, 'OD-202403074203', 'Kasir 1', 15500, 16000, 500, 'Tunai', '2024-03-07 23:03:37', '2024-03-07 23:03:37'),
(45, 'OD-202403072019', 'Kasir 1', 24500, 25000, 500, 'QRIS', '2024-03-07 23:06:54', '2024-03-07 23:06:54'),
(46, 'OD-202403107333', 'Kasir 1', 21000, 25000, 4000, 'QRIS', '2024-03-10 12:44:21', '2024-03-10 12:44:21'),
(47, 'OD-202403113052', 'Kasir 1', 10500, 20000, 9500, 'Tunai', '2024-03-11 14:55:45', '2024-03-11 14:55:45'),
(48, 'OD-202403112850', 'Kasir 1', 10500, 20000, 9500, 'Tunai', '2024-03-11 14:56:44', '2024-03-11 14:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `penjualandetail`
--

CREATE TABLE `penjualandetail` (
  `id_penjualandetail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualandetail`
--

INSERT INTO `penjualandetail` (`id_penjualandetail`, `id_penjualan`, `id_produk`, `qty`, `total`, `created_at`, `update_at`) VALUES
(39, 40, 1, 2, 7000, '2024-02-26 06:54:09', '2024-02-26 06:54:09'),
(40, 40, 6, 3, 69000, '2024-02-26 06:54:09', '2024-02-26 06:54:09'),
(42, 41, 1, 2, 7000, '2024-02-26 07:36:43', '2024-02-26 07:36:43'),
(44, 43, 5, 2, 10000, '2024-03-07 04:20:36', '2024-03-07 04:20:36'),
(45, 44, 1, 1, 3500, '2024-03-07 16:03:37', '2024-03-07 16:03:37'),
(46, 44, 7, 2, 12000, '2024-03-07 16:03:38', '2024-03-07 16:03:38'),
(47, 45, 8, 1, 14000, '2024-03-07 16:06:54', '2024-03-07 16:06:54'),
(48, 45, 4, 1, 10500, '2024-03-07 16:06:54', '2024-03-07 16:06:54'),
(49, 46, 4, 2, 21000, '2024-03-10 05:44:21', '2024-03-10 05:44:21'),
(50, 48, 4, 1, 10500, '2024-03-11 07:56:44', '2024-03-11 07:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `no_order` varchar(20) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `metode_pengiriman` varchar(20) NOT NULL,
  `metode_pembayaran` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `no_order`, `grand_total`, `metode_pengiriman`, `metode_pembayaran`, `status`, `created_at`, `update_at`) VALUES
(17, 'ONLINE-202403134745', 33000, 'Dikirim', 'QRIS', 'Selesai', '2024-03-13 08:36:10', '2024-03-13 08:36:10'),
(18, 'ONLINE-202403136615', 14000, 'Dikirim', 'Tunai', 'Ditolak', '2024-03-13 08:41:32', '2024-03-13 08:41:32'),
(19, 'ONLINE-202403137299', 6000, 'Dikirim', 'Tunai', 'Dikirim', '2024-03-13 08:44:36', '2024-03-13 08:44:36'),
(20, 'ONLINE-202403138607', 5000, 'Dikirim', 'Tunai', 'Dikirim', '2024-03-13 08:48:41', '2024-03-13 08:48:41'),
(21, 'ONLINE-202403142531', 14000, 'Dikirim', 'QRIS', 'Selesai', '2024-03-14 05:46:53', '2024-03-14 05:46:53'),
(22, 'ONLINE-202403142311', 5000, 'Dikirim', 'QRIS', 'Siap', '2024-03-14 06:45:25', '2024-03-14 06:45:25'),
(23, 'ONLINE-202403141977', 14000, 'Dikirim', 'Tunai', 'Siap', '2024-03-14 06:47:59', '2024-03-14 06:47:59'),
(24, 'ONLINE-202403154769', 5000, 'Diambil', 'Tunai', NULL, '2024-03-15 07:15:37', '2024-03-15 07:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `pesanandetail`
--

CREATE TABLE `pesanandetail` (
  `id_pesanandetail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanandetail`
--

INSERT INTO `pesanandetail` (`id_pesanandetail`, `id_pesanan`, `id_produk`, `qty`, `total`, `created_at`, `update_at`) VALUES
(16, 17, 8, 2, 28000, '2024-03-13 01:36:10', '2024-03-13 01:36:10'),
(17, 17, 5, 1, 5000, '2024-03-13 01:36:10', '2024-03-13 01:36:10'),
(18, 18, 8, 1, 14000, '2024-03-13 01:41:32', '2024-03-13 01:41:32'),
(19, 19, 7, 1, 6000, '2024-03-13 01:44:36', '2024-03-13 01:44:36'),
(20, 20, 5, 1, 5000, '2024-03-13 01:48:41', '2024-03-13 01:48:41'),
(21, 21, 8, 1, 14000, '2024-03-13 22:46:53', '2024-03-13 22:46:53'),
(22, 22, 5, 1, 5000, '2024-03-13 23:45:25', '2024-03-13 23:45:25'),
(23, 23, 8, 1, 14000, '2024-03-13 23:47:59', '2024-03-13 23:47:59'),
(24, 24, 5, 1, 5000, '2024-03-15 00:15:37', '2024-03-15 00:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `bentuk_sediaan` varchar(50) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `foto`, `nama`, `bentuk_sediaan`, `satuan`, `stok`, `harga_beli`, `harga_jual`, `id_kategori`, `created_at`, `update_at`) VALUES
(1, 'FT20240210084412.png', 'Benoxicam', 'kaplet', 'biji', 80, 2300, 3500, 2, '2024-02-07 03:03:57', '2024-02-07 03:03:57'),
(2, 'FT20240210084508.png', 'Mexon', 'kaplet', 'biji', 296, 2111, 3000, 3, '2024-02-07 03:05:33', '2024-02-07 03:05:33'),
(3, 'FT20240210084211.png', 'Diabit', 'tablet', 'biji', 1699, 2530, 3500, 3, '2024-02-07 03:06:45', '2024-02-07 03:06:45'),
(4, 'FT20240210084054.png', 'Beneuron', 'tablet', 'biji', 187, 9790, 10500, 1, '2024-02-07 03:44:01', '2024-02-07 03:44:01'),
(5, 'FT20240210083827.jpg', 'Etabion', 'kapsul', 'biji', 356, 4105, 5000, 5, '2024-02-07 03:45:34', '2024-02-07 03:45:34'),
(6, 'FT20240210083659.png', 'Ulcron', 'suspensi', 'fls', 0, 20173, 23000, 3, '2024-02-07 03:46:14', '2024-02-07 03:46:14'),
(7, 'FT20240210083350.png', 'Ifarsyl', 'sirup', 'fls', 6, 5100, 6000, 3, '2024-02-07 03:46:50', '2024-02-07 03:46:50'),
(8, 'FT20240210082913.png', 'Cetirizin', 'kapsul', 'biji', 44, 12127, 14000, 2, '2024-02-07 03:47:36', '2024-02-07 03:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_tlp` varchar(13) DEFAULT NULL,
  `foto_profil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `fullname`, `alamat`, `nomor_tlp`, `foto_profil`, `level`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$Oxj3p94s8oc6wY2nhDr4r.iF1saaL9gyqrEl7jiHby5.u9p0w3umW', NULL, '', '', '', '', NULL, '2024-01-15 08:08:43', '2024-01-15 08:08:43'),
(3, 'kiki', 'kiki@gmail.com', NULL, '$2y$12$POUTSkMCRBMZA3klzBttgO6BMt7VAFwleQNf1uPK2hMzVWXkgRTDa', NULL, 'kiki', 'cilacap', '0895378176513', NULL, NULL, '2024-01-24 08:32:56', '2024-01-24 08:32:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buktipembayaran`
--
ALTER TABLE `buktipembayaran`
  ADD PRIMARY KEY (`id_bukti`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_ongkir` (`id_ongkir`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `penjualandetail`
--
ALTER TABLE `penjualandetail`
  ADD PRIMARY KEY (`id_penjualandetail`),
  ADD KEY `id_order` (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `pesanandetail`
--
ALTER TABLE `pesanandetail`
  ADD PRIMARY KEY (`id_pesanandetail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `kategori` (`id_kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buktipembayaran`
--
ALTER TABLE `buktipembayaran`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id_ongkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `penjualandetail`
--
ALTER TABLE `penjualandetail`
  MODIFY `id_penjualandetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pesanandetail`
--
ALTER TABLE `pesanandetail`
  MODIFY `id_pesanandetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buktipembayaran`
--
ALTER TABLE `buktipembayaran`
  ADD CONSTRAINT `buktipembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `kasir`
--
ALTER TABLE `kasir`
  ADD CONSTRAINT `kasir_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `pengiriman_ibfk_2` FOREIGN KEY (`id_ongkir`) REFERENCES `ongkir` (`id_ongkir`);

--
-- Constraints for table `penjualandetail`
--
ALTER TABLE `penjualandetail`
  ADD CONSTRAINT `penjualandetail_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `penjualandetail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pesanandetail`
--
ALTER TABLE `pesanandetail`
  ADD CONSTRAINT `pesanandetail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `pesanandetail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
