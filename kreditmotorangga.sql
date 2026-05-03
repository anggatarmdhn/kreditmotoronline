-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Bulan Mei 2026 pada 12.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kreditmotorangga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsurans`
--

CREATE TABLE `angsurans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kredit` bigint(20) UNSIGNED NOT NULL,
  `angsuran_ke` smallint(5) UNSIGNED NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `jumlah_tagihan` decimal(15,2) NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_bayar` date DEFAULT NULL,
  `metode_bayar_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('belum_bayar','lunas','tunggak') NOT NULL DEFAULT 'belum_bayar',
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `angsurans`
--

INSERT INTO `angsurans` (`id`, `id_kredit`, `angsuran_ke`, `jatuh_tempo`, `jumlah_tagihan`, `jumlah_bayar`, `tanggal_bayar`, `metode_bayar_id`, `status`, `midtrans_order_id`, `bukti_bayar`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, 3, 1, '2026-05-30', 899652.17, 899652.17, '2026-05-01', NULL, 'lunas', 'ANG-7-1777615992', NULL, 'Dibayar via Midtrans (Order ID: ANG-7-1777615992)', '2026-04-30 05:26:04', '2026-04-30 23:13:18'),
(8, 3, 2, '2026-06-30', 899652.17, 899652.17, '2026-05-02', 1, 'lunas', 'ANG-8-1777717639', NULL, 'Dibayar via Midtrans (Order ID: ANG-8-1777717639)', '2026-04-30 05:26:04', '2026-05-02 03:27:24'),
(9, 3, 3, '2026-07-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(10, 3, 4, '2026-08-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(11, 3, 5, '2026-09-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(12, 3, 6, '2026-10-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(13, 3, 7, '2026-11-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(14, 3, 8, '2026-12-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(15, 3, 9, '2027-01-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(16, 3, 10, '2027-02-28', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(17, 3, 11, '2027-03-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(18, 3, 12, '2027-04-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(19, 3, 13, '2027-05-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(20, 3, 14, '2027-06-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(21, 3, 15, '2027-07-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(22, 3, 16, '2027-08-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(23, 3, 17, '2027-09-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(24, 3, 18, '2027-10-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(25, 3, 19, '2027-11-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(26, 3, 20, '2027-12-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(27, 3, 21, '2028-01-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(28, 3, 22, '2028-02-29', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(29, 3, 23, '2028-03-30', 899652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 05:26:04', '2026-04-30 05:26:04'),
(30, 4, 1, '2026-05-30', 1630619.57, 1630619.00, '2026-05-02', 2, 'belum_bayar', NULL, NULL, 'bayaar dirumah', '2026-04-30 06:12:00', '2026-05-02 00:19:17'),
(31, 4, 2, '2026-06-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(32, 4, 3, '2026-07-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(33, 4, 4, '2026-08-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(34, 4, 5, '2026-09-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(35, 4, 6, '2026-10-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(36, 4, 7, '2026-11-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(37, 4, 8, '2026-12-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(38, 4, 9, '2027-01-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(39, 4, 10, '2027-02-28', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(40, 4, 11, '2027-03-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(41, 4, 12, '2027-04-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(42, 4, 13, '2027-05-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(43, 4, 14, '2027-06-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(44, 4, 15, '2027-07-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(45, 4, 16, '2027-08-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(46, 4, 17, '2027-09-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(47, 4, 18, '2027-10-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(48, 4, 19, '2027-11-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(49, 4, 20, '2027-12-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(50, 4, 21, '2028-01-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(51, 4, 22, '2028-02-29', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(52, 4, 23, '2028-03-30', 1630619.57, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 06:12:00', '2026-04-30 06:12:00'),
(53, 5, 1, '2026-06-01', 723652.17, 723652.00, '2026-05-02', 2, 'lunas', NULL, NULL, 'udah bayar dirumah', '2026-04-30 18:31:45', '2026-05-02 02:13:13'),
(54, 5, 2, '2026-07-01', 723652.17, 723652.00, '2026-05-02', 2, 'lunas', NULL, NULL, 'bayar dirumah', '2026-04-30 18:31:45', '2026-05-02 02:13:40'),
(55, 5, 3, '2026-08-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(56, 5, 4, '2026-09-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(57, 5, 5, '2026-10-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(58, 5, 6, '2026-11-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(59, 5, 7, '2026-12-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(60, 5, 8, '2027-01-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(61, 5, 9, '2027-02-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(62, 5, 10, '2027-03-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(63, 5, 11, '2027-04-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(64, 5, 12, '2027-05-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(65, 5, 13, '2027-06-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(66, 5, 14, '2027-07-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(67, 5, 15, '2027-08-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(68, 5, 16, '2027-09-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(69, 5, 17, '2027-10-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(70, 5, 18, '2027-11-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(71, 5, 19, '2027-12-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(72, 5, 20, '2028-01-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(73, 5, 21, '2028-02-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(74, 5, 22, '2028-03-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(75, 5, 23, '2028-04-01', 723652.17, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-04-30 18:31:45', '2026-04-30 18:31:45'),
(76, 6, 1, '2026-06-01', 1384116.85, 1384116.85, '2026-05-01', NULL, 'lunas', 'ANG-76-1777656505', NULL, 'Dibayar via Midtrans (Order ID: ANG-76-1777656505)', '2026-05-01 10:27:11', '2026-05-01 10:28:29'),
(77, 6, 2, '2026-07-01', 1384116.85, 1384116.85, '2026-05-01', NULL, 'lunas', 'ANG-77-1777656511', NULL, 'Dibayar via Midtrans (Order ID: ANG-77-1777656511)', '2026-05-01 10:27:11', '2026-05-01 10:28:35'),
(78, 6, 3, '2026-08-01', 1384116.85, 1384116.85, '2026-05-01', NULL, 'lunas', 'ANG-78-1777656520', NULL, 'Dibayar via Midtrans (Order ID: ANG-78-1777656520)', '2026-05-01 10:27:11', '2026-05-01 10:28:44'),
(79, 6, 4, '2026-09-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(80, 6, 5, '2026-10-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(81, 6, 6, '2026-11-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(82, 6, 7, '2026-12-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(83, 6, 8, '2027-01-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(84, 6, 9, '2027-02-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(85, 6, 10, '2027-03-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(86, 6, 11, '2027-04-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(87, 6, 12, '2027-05-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(88, 6, 13, '2027-06-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(89, 6, 14, '2027-07-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(90, 6, 15, '2027-08-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(91, 6, 16, '2027-09-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(92, 6, 17, '2027-10-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(93, 6, 18, '2027-11-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(94, 6, 19, '2027-12-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(95, 6, 20, '2028-01-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(96, 6, 21, '2028-02-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(97, 6, 22, '2028-03-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(98, 6, 23, '2028-04-01', 1384116.85, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-01 10:27:11', '2026-05-01 10:27:11'),
(99, 7, 1, '2026-04-12', 1567139.20, 1567139.20, '2026-04-14', 1, 'lunas', NULL, NULL, NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(100, 7, 2, '2026-04-29', 1567139.20, 1567139.00, '2026-05-02', 2, 'lunas', NULL, NULL, 'udh dibayar dirumah', '2026-05-02 00:16:14', '2026-05-02 00:40:30'),
(101, 7, 3, '2026-05-27', 1567139.20, 1567139.00, '2026-05-02', 2, 'lunas', NULL, NULL, 'udah dibayar dirumah', '2026-05-02 00:16:14', '2026-05-02 00:41:22'),
(102, 8, 1, '2026-04-12', 2616051.14, 2616051.14, '2026-04-14', 1, 'lunas', NULL, NULL, NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(103, 8, 2, '2026-04-29', 2616051.14, 0.00, NULL, NULL, 'tunggak', NULL, NULL, NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(104, 8, 3, '2026-05-27', 2616051.14, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(105, 9, 1, '2026-06-02', 1588650.00, 1588650.00, '2026-05-02', NULL, 'lunas', 'ANG-105-1777713151', NULL, 'Dibayar via Midtrans (Order ID: ANG-105-1777713151)', '2026-05-02 02:11:55', '2026-05-02 02:12:35'),
(106, 9, 2, '2026-07-02', 1588650.00, 1588650.00, '2026-05-02', NULL, 'lunas', 'ANG-106-1777713157', NULL, 'Dibayar via Midtrans (Order ID: ANG-106-1777713157)', '2026-05-02 02:11:55', '2026-05-02 02:12:42'),
(107, 9, 3, '2026-08-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(108, 9, 4, '2026-09-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(109, 9, 5, '2026-10-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(110, 9, 6, '2026-11-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(111, 9, 7, '2026-12-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(112, 9, 8, '2027-01-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(113, 9, 9, '2027-02-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(114, 9, 10, '2027-03-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(115, 9, 11, '2027-04-02', 1588650.00, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:11:55', '2026-05-02 02:11:55'),
(116, 10, 1, '2026-06-02', 2341988.64, 2341988.64, '2026-05-02', NULL, 'lunas', 'ANG-116-1777715220', NULL, 'Dibayar via Midtrans (Order ID: ANG-116-1777715220)', '2026-05-02 02:46:35', '2026-05-02 02:47:05'),
(117, 10, 2, '2026-07-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(118, 10, 3, '2026-08-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(119, 10, 4, '2026-09-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(120, 10, 5, '2026-10-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(121, 10, 6, '2026-11-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(122, 10, 7, '2026-12-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(123, 10, 8, '2027-01-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(124, 10, 9, '2027-02-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(125, 10, 10, '2027-03-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(126, 10, 11, '2027-04-02', 2341988.64, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 02:46:35', '2026-05-02 02:46:35'),
(127, 11, 1, '2026-06-02', 696515.22, 696515.22, '2026-05-02', NULL, 'lunas', 'ANG-127-1777717631', NULL, 'Dibayar via Midtrans (Order ID: ANG-127-1777717631)', '2026-05-02 03:26:40', '2026-05-02 03:27:15'),
(128, 11, 2, '2026-07-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(129, 11, 3, '2026-08-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(130, 11, 4, '2026-09-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(131, 11, 5, '2026-10-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(132, 11, 6, '2026-11-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(133, 11, 7, '2026-12-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(134, 11, 8, '2027-01-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(135, 11, 9, '2027-02-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(136, 11, 10, '2027-03-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(137, 11, 11, '2027-04-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(138, 11, 12, '2027-05-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(139, 11, 13, '2027-06-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(140, 11, 14, '2027-07-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(141, 11, 15, '2027-08-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(142, 11, 16, '2027-09-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(143, 11, 17, '2027-10-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(144, 11, 18, '2027-11-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(145, 11, 19, '2027-12-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(146, 11, 20, '2028-01-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(147, 11, 21, '2028-02-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(148, 11, 22, '2028-03-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40'),
(149, 11, 23, '2028-04-02', 696515.22, 0.00, NULL, NULL, 'belum_bayar', NULL, NULL, NULL, '2026-05-02 03:26:40', '2026-05-02 03:26:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asuransis`
--

CREATE TABLE `asuransis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `nama_asuransi` varchar(100) NOT NULL,
  `margin_persen` decimal(8,2) NOT NULL DEFAULT 0.00,
  `no_rekening` varchar(50) DEFAULT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asuransis`
--

INSERT INTO `asuransis` (`id`, `nama_perusahaan`, `nama_asuransi`, `margin_persen`, `no_rekening`, `url_logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Asuransi Aman Sentosa', 'Aman Basic', 0.75, '1234567890', NULL, 1, '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(2, 'Asuransi Nusantara Proteksi', 'Nusantara Plus', 1.10, '0987654321', NULL, 1, '2026-04-30 02:50:39', '2026-04-30 02:50:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image_path`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Motor Honda', NULL, 'banners/rrloh60WGBxYBsj1qBkLrU8er6dMfud8NlTMFYph.jpg', 1, 0, '2026-05-01 23:39:35', '2026-05-02 00:24:46'),
(2, 'Honda', NULL, 'banners/4mSh9traDwu0BSP8xoIvXRiVPhzmD8umhyU42vG2.png', 1, 1, '2026-05-01 23:39:48', '2026-05-02 00:03:05'),
(3, 'Yamaha', NULL, 'banners/QLhwDc2msK3gbjtdXTb8cJVERCfGI9MWxIMjgGHU.png', 1, 0, '2026-05-01 23:41:48', '2026-05-01 23:58:51'),
(4, 'Yamaha', NULL, 'banners/U9cvNXG7abCrSEljRj7fz1sxqsdgEN91d18gxsi3.jpg', 1, 0, '2026-05-01 23:42:03', '2026-05-01 23:42:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jenis_cicilans`
--

CREATE TABLE `jenis_cicilans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tenor_bulan` smallint(5) UNSIGNED NOT NULL,
  `bunga_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_cicilans`
--

INSERT INTO `jenis_cicilans` (`id`, `nama`, `tenor_bulan`, `bunga_persen`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Reguler 11 Bulan', 11, 1.50, 1, '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(2, 'Reguler 17 Bulan', 17, 1.80, 1, '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(3, 'Reguler 23 Bulan', 23, 2.10, 1, '2026-04-30 02:50:39', '2026-04-30 02:50:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_motors`
--

CREATE TABLE `jenis_motors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merk` varchar(50) NOT NULL,
  `jenis` enum('Bebek','Skuter','Dual Sport','Naked Sport','Sport Bike','Retro','Cruiser','Sport Touring','Dirt Bike','Motocross','Scrambler','ATV','Motor Adventure','Lainnya') NOT NULL,
  `deskripsi_jenis` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kredits`
--

CREATE TABLE `kredits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pengajuan_kredit` bigint(20) UNSIGNED NOT NULL,
  `id_metode_bayar` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl_mulai_kredit` date NOT NULL,
  `tgl_selesai_kredit` date DEFAULT NULL,
  `sisa_kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_kredit` enum('Dicicil','Macet','Lunas') NOT NULL DEFAULT 'Dicicil',
  `keterangan_status_kredit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kredits`
--

INSERT INTO `kredits` (`id`, `id_pengajuan_kredit`, `id_metode_bayar`, `tgl_mulai_kredit`, `tgl_selesai_kredit`, `sisa_kredit`, `status_kredit`, `keterangan_status_kredit`, `created_at`, `updated_at`) VALUES
(3, 5, NULL, '2026-05-01', NULL, 18892695.66, 'Dicicil', NULL, '2026-04-30 05:26:04', '2026-05-02 03:27:24'),
(4, 6, NULL, '2026-05-01', NULL, 37504250.00, 'Dicicil', NULL, '2026-04-30 06:12:00', '2026-05-01 10:25:45'),
(5, 7, NULL, '2026-05-02', NULL, 15196695.66, 'Dicicil', NULL, '2026-04-30 18:31:45', '2026-05-02 02:46:15'),
(6, 8, NULL, '2026-05-02', NULL, 27682336.95, 'Dicicil', NULL, '2026-05-01 10:27:11', '2026-05-02 02:46:10'),
(7, 9, 1, '2026-04-23', NULL, 14104252.85, 'Dicicil', NULL, '2026-05-02 00:16:14', '2026-05-02 00:41:22'),
(8, 10, 1, '2026-04-22', NULL, 26160511.36, 'Dicicil', NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(9, 11, NULL, '2026-05-02', NULL, 14297850.00, 'Dicicil', NULL, '2026-05-02 02:11:55', '2026-05-02 02:12:42'),
(10, 13, NULL, '2026-05-02', NULL, 23419886.36, 'Dicicil', NULL, '2026-05-02 02:46:35', '2026-05-02 02:47:05'),
(11, 14, NULL, '2026-05-02', NULL, 15323334.78, 'Dicicil', NULL, '2026-05-02 03:26:40', '2026-05-02 03:27:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `landing_sections`
--

CREATE TABLE `landing_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_bayars`
--

CREATE TABLE `metode_bayars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_13_053339_create_roles_table', 1),
(5, '2026_04_13_053340_add_role_id_to_users_table', 1),
(6, '2026_04_13_053342_1_create_jenis_motors_table', 1),
(7, '2026_04_13_053342_create_pelanggans_table', 1),
(8, '2026_04_13_053343_create_motors_table', 1),
(9, '2026_04_13_053344_create_jenis_cicilans_table', 1),
(10, '2026_04_13_053345_create_metode_bayars_table', 1),
(11, '2026_04_13_053346_create_pengajuan_kredits_table', 1),
(12, '2026_04_13_053346_z_create_kredits_table', 1),
(13, '2026_04_13_053347_create_angsurans_table', 1),
(14, '2026_04_13_053348_create_landing_sections_table', 1),
(15, '2026_04_13_053348_create_pengirimen_table', 1),
(16, '2026_04_13_170000_create_asuransis_table', 1),
(17, '2026_04_13_170100_add_asuransi_to_pengajuan_kredits_table', 1),
(18, '2026_04_30_111840_create_banners_table', 1),
(19, '2026_05_01_010000_add_dp_payment_fields_to_pengajuan_kredits', 1),
(20, '2026_05_01_043112_add_midtrans_to_angsurans', 1),
(21, '2026_05_01_164017_add_otp_fields_to_users_table', 1),
(22, '2026_05_02_074228_create_settings_table', 1),
(23, '2026_05_02_093246_remove_slip_gaji_and_npwp_from_pengajuan_kredits', 1),
(24, '2026_05_02_094111_ensure_correct_pengajuan_columns', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `motors`
--

CREATE TABLE `motors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_motor` varchar(255) NOT NULL,
  `nama_motor` varchar(100) NOT NULL,
  `id_jenis` bigint(20) UNSIGNED DEFAULT NULL,
  `harga_cash` decimal(15,2) NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `dp_minimum` decimal(15,2) NOT NULL DEFAULT 0.00,
  `deskripsi_motor` text DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `kapasitas_mesin` varchar(10) DEFAULT NULL,
  `tahun_produksi` year(4) DEFAULT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `motors`
--

INSERT INTO `motors` (`id`, `kode_motor`, `nama_motor`, `id_jenis`, `harga_cash`, `harga_jual`, `dp_minimum`, `deskripsi_motor`, `warna`, `kapasitas_mesin`, `tahun_produksi`, `foto1`, `foto2`, `foto3`, `stok`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MTR-001', 'Beat CBS', 1, 18500000.00, 18500000.00, 2500000.00, 'Honda Beat irit dan gesit, cocok untuk harian di kota.', 'Hitam', '110cc', '2025', 'motors/beat-cbs-1.jpg', 'motors/beat-cbs-2.jpeg', 'motors/beat-cbs-3.jpg', 12, 1, '2026-04-30 02:50:39', '2026-05-02 01:32:24'),
(2, 'MTR-002', 'NMAX 155', 2, 34500000.00, 34500000.00, 5500000.00, 'Yamaha NMAX premium skuter dengan teknologi VVA.', 'Silver', '155cc', '2025', 'motors/nmax-155-1.jpeg', 'motors/nmax-155-2.png', 'motors/nmax-155-3.jpeg', 8, 1, '2026-04-30 02:50:39', '2026-05-02 01:32:24'),
(3, 'MTR-003', 'GSX R150', 3, 31250000.00, 31250000.00, 5000000.00, 'Suzuki GSX R150 performa sport tinggi.', 'Biru', '150cc', '2025', 'motors/gsx-r150-1.png', NULL, NULL, 5, 1, '2026-04-30 02:50:39', '2026-05-02 01:32:24'),
(10, 'MTR-004', 'Vario 125', 1, 22500000.00, 22500000.00, 3000000.00, 'Honda Vario 125 dengan fitur canggih dan bagasi luas.', 'Merah', '125cc', '2025', 'motors/vario-125-1.jpg', 'motors/vario-125-2.jpg', 'motors/vario-125-3.jpeg', 10, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24'),
(11, 'MTR-005', 'Aerox 155', 2, 27500000.00, 27500000.00, 4000000.00, 'Yamaha Aerox 155 sport scooter yang kencang dan stylish.', 'Cyan', '155cc', '2025', 'motors/aerox-155-1.png', 'motors/aerox-155-2.png', 'motors/aerox-155-3.jpg', 7, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24'),
(12, 'MTR-006', 'Scoopy', 1, 21800000.00, 21800000.00, 2800000.00, 'Honda Scoopy desain retro modern yang ikonik.', 'Cream', '110cc', '2025', 'motors/scoopy-1.jpg', NULL, 'motors/scoopy-3.jpg', 15, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24'),
(13, 'MTR-007', 'Mio M3', 2, 17400000.00, 17400000.00, 2000000.00, 'Yamaha Mio M3 motor harian yang handal dan ekonomis.', 'Biru', '125cc', '2025', 'motors/mio-m3-1.jpg', 'motors/mio-m3-2.png', NULL, 20, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24'),
(14, 'MTR-008', 'CB150R', 4, 30500000.00, 30500000.00, 4500000.00, 'Honda CB150R StreetFire performa naked bike sejati.', 'Hitam Merah', '150cc', '2025', 'motors/cb150r-1.png', 'motors/cb150r-2.jpg', 'motors/cb150r-3.png', 4, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24'),
(15, 'MTR-009', 'R15', 5, 39800000.00, 39800000.00, 6000000.00, 'Yamaha R15 motor sport dengan aura balap kental.', 'Biru Putih', '155cc', '2025', 'motors/r15-1.png', 'motors/r15-2.jpeg', NULL, 3, 1, '2026-05-02 01:32:24', '2026-05-02 01:32:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `katakunci` varchar(255) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat1` varchar(255) DEFAULT NULL,
  `kota1` varchar(255) DEFAULT NULL,
  `propinsi1` varchar(255) DEFAULT NULL,
  `kodepos1` varchar(255) DEFAULT NULL,
  `alamat2` varchar(255) DEFAULT NULL,
  `kota2` varchar(255) DEFAULT NULL,
  `propinsi2` varchar(255) DEFAULT NULL,
  `kodepos2` varchar(255) DEFAULT NULL,
  `alamat3` varchar(255) DEFAULT NULL,
  `kota3` varchar(255) DEFAULT NULL,
  `propinsi3` varchar(255) DEFAULT NULL,
  `kodepos3` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(120) DEFAULT NULL,
  `penghasilan_bulanan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_pernikahan` enum('lajang','menikah','cerai') NOT NULL DEFAULT 'lajang',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `nama_pelanggan`, `email`, `katakunci`, `no_telp`, `alamat1`, `kota1`, `propinsi1`, `kodepos1`, `alamat2`, `kota2`, `propinsi2`, `kodepos2`, `alamat3`, `kota3`, `propinsi3`, `kodepos3`, `foto`, `nik`, `pekerjaan`, `penghasilan_bulanan`, `status_pernikahan`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'budi@mail.com', '$2y$12$UPOh55oG0fy8R37M.5ej3uj0CnG/7whI4XZr1f7mq1gE5IcwIWgCC', '081234567890', 'Jl. Merdeka No. 10', 'Bandung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3273011201900001', 'Karyawan Swasta', 7000000.00, 'menikah', '2026-04-30 02:50:40', '2026-05-02 01:32:24'),
(2, 'Siti Aisyah', 'siti@mail.com', '$2y$12$pyMboukDDq0Y9B6KvaXRkuUaxdSO4D7eMYw00tX2RER4BSbaghMJ2', '081298765432', 'Jl. Cempaka No. 5', 'Cimahi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3273011201900002', 'Wiraswasta', 8500000.00, 'lajang', '2026-04-30 02:50:40', '2026-05-02 01:32:24'),
(3, 'Angga', NULL, NULL, 'we14323415243', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1432341524301112', 'Belum diisi', 0.00, 'lajang', '2026-04-30 04:25:13', '2026-04-30 04:25:13'),
(4, 'Angga', NULL, NULL, 'we14323415243', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1432341524301107', 'Belum diisi', 0.00, 'lajang', '2026-04-30 04:25:13', '2026-04-30 04:25:13'),
(5, 'Anggata Alhaadi Ramadhan', 'klien@gmail.com', NULL, '222222', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222220000001146', 'Belum diisi', 0.00, 'lajang', '2026-04-30 04:51:50', '2026-04-30 04:51:50'),
(6, 'woywoy', 'klien@gmail.com', NULL, 'we14323415243', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1432341524301369', 'Belum diisi', 0.00, 'lajang', '2026-04-30 06:11:15', '2026-04-30 06:11:15'),
(7, 'Klien Kredit', 'klien@gmail.com', NULL, 'we14323415243', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1432341524300188', 'Belum diisi', 0.00, 'lajang', '2026-04-30 18:31:20', '2026-04-30 18:31:20'),
(8, 'rudis', 'crowngaming07@gmail.com', NULL, 'woywoy', 'jakarta', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000000000001771', 'Belum diisi', 0.00, 'lajang', '2026-05-01 10:21:43', '2026-05-01 10:21:43'),
(13, 'Anggata Al Haadi Ramadhan', 'anggataalhaadiramadhan@gmail.com', NULL, '081387047805', 'Perum Permata Pondok Rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0813870478050936', 'Belum diisi', 0.00, 'lajang', '2026-05-02 02:09:00', '2026-05-02 02:09:00'),
(14, 'Bento', 'crowngaming07@gmail.com', NULL, '222222', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222220000000939', 'Bos CEO', 0.00, 'lajang', '2026-05-02 02:42:20', '2026-05-02 02:42:20'),
(15, 'alam', 'crowngaming07@gmail.com', NULL, '101010101', 'rajeg', 'Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1010101010000967', 'Karyawan', 10000000000.00, 'lajang', '2026-05-02 02:45:50', '2026-05-02 02:45:50'),
(16, 'Bang Bos', 'klien@gmail.com', NULL, '11111111', 'Gaperi', 'Bogor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1111111100001079', 'Karyawan', 100000000.00, 'lajang', '2026-05-02 03:26:15', '2026-05-02 03:26:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_kredits`
--

CREATE TABLE `pengajuan_kredits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_pengajuan` varchar(255) NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL,
  `motor_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_cicilan_id` bigint(20) UNSIGNED NOT NULL,
  `asuransi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `marketing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `harga_cash` decimal(15,2) NOT NULL,
  `dp` decimal(15,2) NOT NULL,
  `pokok_hutang` decimal(15,2) NOT NULL,
  `bunga_persen` decimal(5,2) NOT NULL,
  `biaya_asuransi_per_bulan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_pembiayaan` decimal(15,2) NOT NULL,
  `angsuran_per_bulan` decimal(15,2) NOT NULL,
  `tenor_bulan` smallint(5) UNSIGNED NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `url_kk` varchar(255) DEFAULT NULL,
  `url_ktp` varchar(255) DEFAULT NULL,
  `url_slip_gaji` varchar(255) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Diproses','Dibatalkan Pembeli','Dibatalkan Penjual','Bermasalah','Diterima','Aktif') NOT NULL DEFAULT 'Menunggu Konfirmasi',
  `catatan` text DEFAULT NULL,
  `dp_paid` tinyint(1) NOT NULL DEFAULT 0,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `dp_paid_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengajuan_kredits`
--

INSERT INTO `pengajuan_kredits` (`id`, `kode_pengajuan`, `pelanggan_id`, `motor_id`, `jenis_cicilan_id`, `asuransi_id`, `marketing_id`, `approved_by`, `harga_cash`, `dp`, `pokok_hutang`, `bunga_persen`, `biaya_asuransi_per_bulan`, `total_pembiayaan`, `angsuran_per_bulan`, `tenor_bulan`, `tanggal_pengajuan`, `url_kk`, `url_ktp`, `url_slip_gaji`, `url_foto`, `status`, `catatan`, `dp_paid`, `midtrans_order_id`, `dp_paid_at`, `approved_at`, `created_at`, `updated_at`) VALUES
(3, 'PGJ-20260430-8667', 3, 1, 3, 2, 2, 1, 18500000.00, 2500000.00, 16000000.00, 2.10, 176000.00, 20692000.00, 899652.17, 23, '2026-04-30', 'pengajuan/kk/zc9ash6lqmRUnprN7wgJACBHeDtLUA7HCpe5THVK.jpg', 'pengajuan/ktp/CjI7BF7APRfLlVuUPpizH7d5bWA7NrrHX9Xg8ZWa.jpg', NULL, NULL, 'Dibatalkan Pembeli', NULL, 0, NULL, NULL, '2026-04-30 18:29:59', '2026-04-30 04:25:13', '2026-04-30 18:29:59'),
(4, 'PGJ-20260430-1356', 4, 1, 3, 2, 2, 1, 18500000.00, 2500000.00, 16000000.00, 2.10, 176000.00, 20692000.00, 899652.17, 23, '2026-04-30', 'pengajuan/kk/Z3cWntIjWa9AobLu1KSehYJImbxZq0hPCQclg5L4.jpg', 'pengajuan/ktp/lZmVwN1DsuTA4fyNOMJvS8KMxrAygA1z2TturAPE.jpg', NULL, NULL, 'Dibatalkan Penjual', NULL, 0, NULL, NULL, '2026-04-30 18:29:54', '2026-04-30 04:25:13', '2026-04-30 18:29:54'),
(5, 'PGJ-20260430-0881', 5, 1, 3, 2, 2, 1, 18500000.00, 2500000.00, 16000000.00, 2.10, 176000.00, 20692000.00, 899652.17, 23, '2026-04-30', 'pengajuan/kk/kyP4Kl4TXe4D74SuiIz79jamqJvmFftAkg5umXtr.jpg', 'pengajuan/ktp/QIYf7xE9kmt1JyZAYBB4PcB82QkF0MT28WpWFS87.jpg', NULL, 'pengajuan/foto/EEFskbd8JpWuElv4Hyw2CVrIhPG7hNznk3vsJbH5.jpg', 'Aktif', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260430-0881-123). Menunggu proses pengiriman motor.', 1, 'PGJ-20260430-0881-123', '2026-04-30 21:08:06', '2026-04-30 05:26:04', '2026-04-30 04:51:50', '2026-05-01 10:25:50'),
(6, 'PGJ-20260430-1912', 6, 2, 3, 2, 2, 1, 34500000.00, 5500000.00, 29000000.00, 2.10, 319000.00, 37504250.00, 1630619.57, 23, '2026-04-30', 'pengajuan/kk/mA0HsaotNccBIkq2kBOEQz44Ol9fut640ow2VHBd.jpg', 'pengajuan/ktp/mIRMQrwQLR8zclT5ptGZ0eNhXasUVwjlWEoPQVOs.jpg', NULL, 'pengajuan/foto/T9tacrkLovIT0pOMzm8GOGPsG8VbOwb4IulDd85I.jpg', 'Aktif', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260430-1912-1777609611). Menunggu proses pengiriman motor.', 1, 'PGJ-20260430-1912-1777609611', '2026-04-30 21:26:56', '2026-04-30 06:12:00', '2026-04-30 06:11:15', '2026-05-01 10:25:45'),
(7, 'PGJ-20260501-5404', 7, 1, 3, NULL, 2, 1, 18500000.00, 2500000.00, 16000000.00, 2.10, 0.00, 16644000.00, 723652.17, 23, '2026-05-01', 'pengajuan/kk/5uRpHAdVB6Dt7cZDYNqTvoYmr8dKbMtXRQUiCaC6.jpg', 'pengajuan/ktp/zg0U2tZtz5hxBmAGIYC1OiWmeUTYmGikBlYVR8Y7.jpg', NULL, 'pengajuan/foto/DLtGvpZnK8IDUrkTRsUwtzmUqRF8qrikBdbY7oYq.jpg', 'Aktif', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260501-5404-1777600790). Menunggu proses pengiriman motor.', 1, 'PGJ-20260501-5404-1777600790', '2026-04-30 19:01:05', '2026-04-30 18:31:45', '2026-04-30 18:31:20', '2026-05-02 02:46:15'),
(8, 'PGJ-20260501-0142', 8, 3, 3, 1, 2, 1, 31250000.00, 5000000.00, 26250000.00, 2.10, 196875.00, 31834687.50, 1384116.85, 23, '2026-05-01', 'pengajuan/kk/7ctqI3lslDA1RahPwSWmciHMVuaskc2bMzNIg7Fw.jpg', 'pengajuan/ktp/tatGItHArWmTvej6P2vD53yVVHA7WfyH2lZ767wT.jpg', NULL, 'pengajuan/foto/hDGRsBCMQPuuEUbx7WYuPn0v8OBYXcJTZQlRWdcv.jpg', 'Aktif', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260501-0142-1777656447). Menunggu proses pengiriman motor.', 1, 'PGJ-20260501-0142-1777656447', '2026-05-01 10:27:32', '2026-05-01 10:27:11', '2026-05-01 10:21:43', '2026-05-02 02:46:10'),
(9, 'PGJ-2026-001', 1, 1, 1, 1, 2, NULL, 18500000.00, 2775000.00, 15725000.00, 1.50, 117937.50, 17238531.25, 1567139.20, 11, '2026-04-22', NULL, NULL, NULL, NULL, 'Diterima', 'Data demo pembayaran', 0, NULL, NULL, '2026-04-23 00:16:14', '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(10, 'PGJ-2026-002', 2, 3, 1, 1, 2, NULL, 31250000.00, 5000000.00, 26250000.00, 1.50, 196875.00, 28776562.50, 2616051.14, 11, '2026-04-21', NULL, NULL, NULL, NULL, 'Diterima', 'Data demo pembayaran', 0, NULL, NULL, '2026-04-22 00:16:14', '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(11, 'PGJ-20260502-7127', 13, 13, 1, 2, 2, 10, 17400000.00, 2000000.00, 15400000.00, 1.50, 169400.00, 17475150.00, 1588650.00, 11, '2026-05-02', 'pengajuan/kk/cWXFrwmFf8NyWsRU9ypswRiyJn28lPTs7iSetbKm.jpg', 'pengajuan/ktp/FEZ34tnupQ7e6bHWJFa4pLwVbzevloKeIvsG1gGz.jpg', NULL, 'pengajuan/foto/uyIfTcDsNCY1LSvG8sJHmiIcnr4grwfMO9UcP5aC.jpg', 'Diterima', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260502-7127-1777713135). Menunggu proses pengiriman motor.', 1, 'PGJ-20260502-7127-1777713135', '2026-05-02 02:12:21', '2026-05-02 02:31:42', '2026-05-02 02:09:00', '2026-05-02 02:31:42'),
(12, 'PGJ-20260502-7226', 14, 10, 1, 1, 2, 2, 22500000.00, 3000000.00, 19500000.00, 1.50, 146250.00, 21376875.00, 1943352.27, 11, '2026-05-02', 'pengajuan/kk/RyQav2PaYQMYX85Bkeo8ool5C94fuNTragAPwKlb.jpg', 'pengajuan/ktp/UU0aMxmQP4AehR41gji0mt6nWi5jvo7nYD6JUZie.jpg', 'pengajuan/slip_gaji/WC4Uz8zBE9OtgXsrkDFerPWU1He5YY5GxDZcUUOh.jpg', 'pengajuan/foto/4XFTpjUhAJir3c27o3HeW6fGDj0jqB5fPDO3b8jB.jpg', 'Dibatalkan Penjual', NULL, 0, NULL, NULL, '2026-05-02 02:44:55', '2026-05-02 02:42:20', '2026-05-02 02:44:55'),
(13, 'PGJ-20260502-2213', 15, 11, 1, 1, 2, 2, 27500000.00, 4000000.00, 23500000.00, 1.50, 176250.00, 25761875.00, 2341988.64, 11, '2026-05-02', 'pengajuan/kk/fFScYVOgEPNq3vclaWZRT4rpNNTdEUYvGmeUT9hk.jpg', 'pengajuan/ktp/gtV1A5MXPRKOolfsp6LVKyFLMqdRLeqwZUeuB5LO.jpg', 'pengajuan/slip_gaji/gSgPbGqCOSxv58MYAkgAacLtkfchakvn4XStWSOO.jpg', 'pengajuan/foto/KAb2ZnnSQh6Dd3I1rLUZuCoCgRF2NTpWQZHyEzem.jpg', 'Diproses', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260502-2213-1777715211). Menunggu proses pengiriman motor.', 1, 'PGJ-20260502-2213-1777715211', '2026-05-02 02:46:55', '2026-05-02 02:46:35', '2026-05-02 02:45:50', '2026-05-02 02:46:55'),
(14, 'PGJ-20260502-5811', 16, 13, 3, NULL, 2, 2, 17400000.00, 2000000.00, 15400000.00, 2.10, 0.00, 16019850.00, 696515.22, 23, '2026-05-02', 'pengajuan/kk/3vr0hONunTwy56WRyEfdycVSYyB5kwvZ4lnyD9FM.jpg', 'pengajuan/ktp/YJNMNYAssQBqsY1tzKWbCNzPNZO7eCckjbwqrazu.jpg', 'pengajuan/slip_gaji/EjJXdsgvtQx02FmpbJd5bWjyWsGdczYJF3n9apHr.jpg', 'pengajuan/foto/1kja3Yz74A4IyFjJn2xt0xM46b8iAFVNNy2fWNPo.jpg', 'Diproses', '✅ DP telah dibayar via Midtrans (Order ID: PGJ-20260502-5811-1777717614). Menunggu proses pengiriman motor.', 1, 'PGJ-20260502-5811-1777717614', '2026-05-02 03:26:59', '2026-05-02 03:26:40', '2026-05-02 03:26:15', '2026-05-02 03:26:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kredit` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(255) DEFAULT NULL,
  `tgl_kirim` datetime DEFAULT NULL,
  `tgl_tiba` datetime DEFAULT NULL,
  `status_kirim` enum('Sedang Dikirim','Tiba Di Tujuan') NOT NULL DEFAULT 'Sedang Dikirim',
  `nama_kurir` varchar(30) DEFAULT NULL,
  `telpon_kurir` varchar(15) DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'Akses penuh sistem', '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(2, 'Marketing', 'marketing', 'Input pengajuan kredit', '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(3, 'Surveyor', 'surveyor', 'Verifikasi lapangan', '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(4, 'Kolektor', 'kolektor', 'Penagihan dan pembayaran', '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(5, 'Klien', 'klien', 'Klien pengajuan kredit', '2026-04-30 02:50:39', '2026-04-30 02:50:39'),
(6, 'Manager', 'manager', 'Manajer Cabang', '2026-05-01 09:41:39', '2026-05-02 00:16:00'),
(7, 'Owner', 'owner', 'Pemilik Bisnis', '2026-05-02 00:16:00', '2026-05-02 00:16:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Wd6VWgcXu3bY3uWbZLb58Dvv05nM1gDc2R8dinm1', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTG96VWV1RU5NcGE5QldrMkJDVE91TEJIcDNUbmd0YmREWXVmYXpXMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1777717666);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'Angga Motors Credit', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(2, 'company_name_short', 'Angga Motors', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(3, 'company_tagline', 'Kredit Motor Online Mudah, Cepat dan Terpercaya', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(4, 'company_branch', 'Rajeg', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(5, 'company_phone', '0813-8704-7805', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(6, 'company_logo_text', 'AM', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(7, 'company_logo_path', 'logos/Qt9renXoiDxO6UUi7up04jjnC1lYCukdJ0D51ZVC.jpg', '2026-05-02 00:54:58', '2026-05-02 00:54:58'),
(8, 'company_name_suffix', 'Credit', '2026-05-02 03:24:12', '2026-05-02 03:24:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `otp_code`, `otp_expires_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin Kredit', 'admin@gmail.com', '2026-05-02 00:16:12', '$2y$12$awpy/uU/ZmmkyMcE.lkOqegtJJsoOV8tYFY1Qtk.AmGnT8TN5C5Y2', NULL, NULL, NULL, '2026-04-30 02:50:40', '2026-05-02 00:16:13'),
(2, 2, 'Marketing Kredit', 'marketing@gmail.com', '2026-05-02 00:16:13', '$2y$12$BgQ03qK1N/U9Wd4oD/3qK.G0Lei.T1mc/Tn.C0COIzWjg/Rnyeg6G', NULL, NULL, NULL, '2026-04-30 02:50:40', '2026-05-02 00:16:13'),
(3, 3, 'Surveyor Kredit', 'surveyor@gmail.com', '2026-05-02 00:16:13', '$2y$12$jRXLG6Pc8rFfYnohH7XMXep2NHhYidBOn8wOhcCGEeQNf2qDPmboq', NULL, NULL, NULL, '2026-04-30 02:50:41', '2026-05-02 00:16:13'),
(4, 4, 'Kolektor Kredit', 'kolektor@gmail.com', '2026-05-02 00:16:13', '$2y$12$MV/l4qUXxDJHVCdzf7.WCei0/CBgo9ZwixbI0SWEISaeFUjsdj6Rm', NULL, NULL, NULL, '2026-04-30 02:50:41', '2026-05-02 00:16:13'),
(5, 5, 'Klien Kredit', 'klien@gmail.com', '2026-05-02 00:16:14', '$2y$12$pOXx.wj42gywRrZY1udQ7ucwqnB0rfz2WI4Qk9sDzsoJViU9RbyxG', NULL, NULL, NULL, '2026-04-30 02:50:41', '2026-05-02 00:16:14'),
(6, 5, 'anggataramadhan', 'crowngaming07@gmail.com', '2026-05-01 23:43:34', '$2y$12$39H5jKqMTrm4rBlssNoBb.1n8fWB641jdcbqm2uo.jxPMz8pYm/pC', '496891', '2026-05-01 23:46:58', NULL, '2026-04-30 03:59:05', '2026-05-01 23:43:34'),
(7, 5, 'Test Client', 'newclient@test.com', '2026-05-01 23:43:34', '$2y$12$6qsoI2OkFr9XbjFU.N5oxerk.Nuu69gT0S4BGwSDiLsKirOpfufTu', NULL, NULL, NULL, '2026-04-30 18:40:52', '2026-05-01 23:43:34'),
(8, 5, 'Tester', 'tester@gmail.com', '2026-05-01 23:43:34', '$2y$12$JN5SWjgjh9Poe3B/sGYb6OTT7r744dYEahHi7MJzv.Dst4SBkKf6C', NULL, NULL, NULL, '2026-04-30 20:37:37', '2026-05-01 23:43:34'),
(9, 6, 'Manager Area', 'manager@gmail.com', '2026-05-02 00:16:13', '$2y$12$TPHEnUiaP2zgSX5AW4EkQ.TnhZPFDRIcd9tEGroNBt2xaFc0lGKSO', NULL, NULL, NULL, '2026-05-01 09:41:39', '2026-05-02 00:16:13'),
(10, 7, 'Owner', 'owner@gmail.com', '2026-05-02 00:16:13', '$2y$12$.rZPSwxYH5IRx2EbOLwaO.yLzHJapHbQy10vzfxnSh/gGSmv9v2NW', NULL, NULL, NULL, '2026-05-02 00:16:14', '2026-05-02 00:16:14'),
(11, 5, 'Angga Ke 2', 'anggataalhaadiramadhan@gmail.com', NULL, '$2y$12$7XiF3b1K.kG1ZDiZIdwQUe8kAGtTl8yYJ1qE1rzj3wZWii77dIwcy', NULL, NULL, NULL, '2026-05-02 02:03:47', '2026-05-02 02:03:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `angsurans`
--
ALTER TABLE `angsurans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `angsurans_id_kredit_angsuran_ke_unique` (`id_kredit`,`angsuran_ke`),
  ADD KEY `angsurans_metode_bayar_id_foreign` (`metode_bayar_id`),
  ADD KEY `angsurans_status_jatuh_tempo_index` (`status`,`jatuh_tempo`);

--
-- Indeks untuk tabel `asuransis`
--
ALTER TABLE `asuransis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis_cicilans`
--
ALTER TABLE `jenis_cicilans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_motors`
--
ALTER TABLE `jenis_motors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kredits`
--
ALTER TABLE `kredits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kredits_id_pengajuan_kredit_foreign` (`id_pengajuan_kredit`),
  ADD KEY `kredits_id_metode_bayar_foreign` (`id_metode_bayar`);

--
-- Indeks untuk tabel `landing_sections`
--
ALTER TABLE `landing_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landing_sections_section_key_unique` (`section_key`);

--
-- Indeks untuk tabel `metode_bayars`
--
ALTER TABLE `metode_bayars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `metode_bayars_kode_unique` (`kode`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `motors`
--
ALTER TABLE `motors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `motors_kode_motor_unique` (`kode_motor`),
  ADD KEY `motors_id_jenis_foreign` (`id_jenis`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggans_nik_unique` (`nik`);

--
-- Indeks untuk tabel `pengajuan_kredits`
--
ALTER TABLE `pengajuan_kredits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengajuan_kredits_kode_pengajuan_unique` (`kode_pengajuan`),
  ADD KEY `pengajuan_kredits_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `pengajuan_kredits_motor_id_foreign` (`motor_id`),
  ADD KEY `pengajuan_kredits_jenis_cicilan_id_foreign` (`jenis_cicilan_id`),
  ADD KEY `pengajuan_kredits_marketing_id_foreign` (`marketing_id`),
  ADD KEY `pengajuan_kredits_approved_by_foreign` (`approved_by`),
  ADD KEY `pengajuan_kredits_status_tanggal_pengajuan_index` (`status`,`tanggal_pengajuan`),
  ADD KEY `pengajuan_kredits_asuransi_id_foreign` (`asuransi_id`);

--
-- Indeks untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengiriman_id_kredit_unique` (`id_kredit`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `angsurans`
--
ALTER TABLE `angsurans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT untuk tabel `asuransis`
--
ALTER TABLE `asuransis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_cicilans`
--
ALTER TABLE `jenis_cicilans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_motors`
--
ALTER TABLE `jenis_motors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kredits`
--
ALTER TABLE `kredits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `landing_sections`
--
ALTER TABLE `landing_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `metode_bayars`
--
ALTER TABLE `metode_bayars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `motors`
--
ALTER TABLE `motors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_kredits`
--
ALTER TABLE `pengajuan_kredits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `angsurans`
--
ALTER TABLE `angsurans`
  ADD CONSTRAINT `angsurans_id_kredit_foreign` FOREIGN KEY (`id_kredit`) REFERENCES `kredits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `angsurans_metode_bayar_id_foreign` FOREIGN KEY (`metode_bayar_id`) REFERENCES `metode_bayars` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kredits`
--
ALTER TABLE `kredits`
  ADD CONSTRAINT `kredits_id_metode_bayar_foreign` FOREIGN KEY (`id_metode_bayar`) REFERENCES `metode_bayars` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kredits_id_pengajuan_kredit_foreign` FOREIGN KEY (`id_pengajuan_kredit`) REFERENCES `pengajuan_kredits` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `motors`
--
ALTER TABLE `motors`
  ADD CONSTRAINT `motors_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_motors` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengajuan_kredits`
--
ALTER TABLE `pengajuan_kredits`
  ADD CONSTRAINT `pengajuan_kredits_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_kredits_asuransi_id_foreign` FOREIGN KEY (`asuransi_id`) REFERENCES `asuransis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_kredits_jenis_cicilan_id_foreign` FOREIGN KEY (`jenis_cicilan_id`) REFERENCES `jenis_cicilans` (`id`),
  ADD CONSTRAINT `pengajuan_kredits_marketing_id_foreign` FOREIGN KEY (`marketing_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_kredits_motor_id_foreign` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id`),
  ADD CONSTRAINT `pengajuan_kredits_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_kredit_foreign` FOREIGN KEY (`id_kredit`) REFERENCES `kredits` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
