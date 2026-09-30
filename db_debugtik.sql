-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2026 at 12:44 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_debugtik`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_tokens`
--

CREATE TABLE `api_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*',
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `attachable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachable_id` bigint UNSIGNED NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` bigint UNSIGNED NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('teacher','lab_admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2024/2025',
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ganjil',
  `mata_pelajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Teknologi Informasi & Komunikasi',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `nip`, `name`, `email`, `password`, `role`, `sekolah`, `foto_profil`, `tahun_ajaran`, `semester`, `mata_pelajaran`, `no_hp`, `active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '198512051234567890', 'Siti Nurhaliza', 'siti.nurhaliza@sekolah.sch.id', '$2y$12$qG5iSIzz9bNwW.vmJnm4ROV/HmbYkJ2O1EmXEywJPR9PxmpvGbhv2', 'teacher', 'SMAN 1 Jakarta Pusat', NULL, '2024/2025', 'Ganjil', 'Teknologi Informasi & Komunikasi', NULL, 1, NULL, 'Fj3zcEF6HWCZx0WN62G4sooITia1iKoYg3yawyA3d9V6NC6xooHKRJW636Nf', '2026-09-23 05:26:02', '2026-09-23 05:26:02'),
(2, '198703151098765432', 'Ahmad Hidayat', 'ahmad.hidayat@sekolah.sch.id', '$2y$12$M6w4giAMoun0MvNMvhzNGOoJbJKCG/TzC7ntq9WWlaK7xZLPPCNVa', 'lab_admin', 'SMAN 1 Jakarta Pusat', NULL, '2024/2025', 'Ganjil', 'Teknologi Informasi & Komunikasi', NULL, 1, NULL, NULL, '2026-09-23 05:26:03', '2026-09-23 05:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kuis_settings`
--

CREATE TABLE `kuis_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `id_kuis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kode unik kuis, contoh: KUIS-HTML-2024',
  `waktu_per_soal` smallint UNSIGNED NOT NULL DEFAULT '30' COMMENT 'Nilai numerik waktu per soal',
  `satuan_waktu` enum('detik','menit','jam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'detik',
  `kkm` tinyint UNSIGNED NOT NULL DEFAULT '70' COMMENT 'Persentase minimum jawaban benar untuk lulus, 0-100',
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kuis_settings`
--

INSERT INTO `kuis_settings` (`id`, `materi_id`, `id_kuis`, `waktu_per_soal`, `satuan_waktu`, `kkm`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'KUIS-HTML-120', 30, 'detik', 70, 'draft', NULL, '2026-09-29 19:26:33', '2026-09-29 22:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `kuis_tik`
--

CREATE TABLE `kuis_tik` (
  `id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `id_soal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('pilihan_ganda','multiple_answer','essay') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pilihan_ganda',
  `opsi_jawaban` json DEFAULT NULL,
  `kunci_jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjelasan_opsi` json DEFAULT NULL,
  `poin` int NOT NULL DEFAULT '25',
  `urutan` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kuis_tik`
--

INSERT INTO `kuis_tik` (`id`, `materi_id`, `id_soal`, `pertanyaan`, `tipe`, `opsi_jawaban`, `kunci_jawaban`, `penjelasan_opsi`, `poin`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 1, 'KUIS-HTML-01', 'Tag HTML untuk membuat heading level 1?', 'pilihan_ganda', '[\"<h1>\", \"<h2>\", \"<title>\", \"<head>\"]', '[\"<h1>\"]', NULL, 25, 1, '2026-09-23 05:26:04', '2026-09-23 05:26:04'),
(4, 3, 'java script-192', 'apakah yang dimaksud dengan java script', 'pilihan_ganda', '[\"A\", \"B\", \"C\", \"D\"]', '[\"A\"]', '[null, null, null, null]', 25, 1, '2026-09-29 06:15:58', '2026-09-29 06:15:58'),
(5, 1, 'KUIS-HTML-120-02', 'APA ITU HTML', 'pilihan_ganda', '[\"A\", \"B\", \"C\", \"D\"]', '[\"B\"]', '[null, null, null, null]', 10, 2, '2026-09-29 19:27:38', '2026-09-29 23:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `lab_praktik`
--

CREATE TABLE `lab_praktik` (
  `id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `id_lab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_kasus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_soal_awal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bug_target` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `solusi_fix` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_kesulitan` enum('mudah','sedang','sulit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mudah',
  `poin_max` int NOT NULL DEFAULT '100',
  `test_cases` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_praktik`
--

INSERT INTO `lab_praktik` (`id`, `materi_id`, `id_lab`, `deskripsi_kasus`, `kode_soal_awal`, `bug_target`, `solusi_fix`, `tingkat_kesulitan`, `poin_max`, `test_cases`, `created_at`, `updated_at`) VALUES
(1, 2, 'LAB-CSS-01', 'Fix CSS box model: padding missing, border double.', '.box { margin: 10px; padding: 20px; border: 5px solid red; }', 'padding: 20px;', '.box { margin: 10px; padding: 30px; border: 5px solid red; }', 'mudah', 100, '[\"padding: 30px;\", \"border: 5px solid red;\"]', '2026-09-23 05:26:04', '2026-09-23 05:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `materi_belajar`
--

CREATE TABLE `materi_belajar` (
  `id` bigint UNSIGNED NOT NULL,
  `id_materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('HTML Dasar','CSS Dasar','JS Dasar','Web Responsif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('Pemula','Menengah','Lanjutan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pemula',
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimasi_waktu` int NOT NULL DEFAULT '45',
  `tingkat_kesulitan` int NOT NULL DEFAULT '1',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materi_belajar`
--

INSERT INTO `materi_belajar` (`id`, `id_materi`, `guru_id`, `judul`, `deskripsi`, `kategori`, `level`, `konten`, `estimasi_waktu`, `tingkat_kesulitan`, `published`, `created_at`, `updated_at`) VALUES
(1, 'MAT-HTML-01', 1, 'HTML Dasar: Struktur Dokumen & Tag Essential', 'Materi pengenalan HTML: struktur dokumen, tag HTML, heading, paragraph, link, dan gambar.', 'HTML Dasar', 'Pemula', '<p>HTML adalah bahasa markup untuk membuat struktur halaman web.</p>', 45, 1, 1, '2026-09-23 05:26:04', '2026-09-23 05:26:04'),
(2, 'MAT-CSS-02', 1, 'CSS Dasar: Styling & Layout Box Model', 'Pengenalan CSS: syntax, selector, property, box model, margin, padding, dan display.', 'CSS Dasar', 'Pemula', '<p>CSS mengatur tampilan dan layout elemen HTML.</p>', 60, 2, 1, '2026-09-23 05:26:04', '2026-09-23 05:26:04'),
(3, 'MAT-JS-03', 1, 'JavaScript Dasar: Variabel, Function, dan DOM', 'Pengenalan JavaScript: variabel, tipe data, function, event listener, dan DOM manipulation.', 'JS Dasar', 'Menengah', '<p>JavaScript membuat halaman web interaktif.</p>', 75, 2, 1, '2026-09-23 05:26:04', '2026-09-23 05:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_23_095618_create_gurus_table', 1),
(5, '2026_09_23_095647_create_materi_belajar_table', 1),
(6, '2026_09_23_095649_create_progress_belajar_table', 1),
(7, '2026_09_23_102728_add_extra_columns_to_progress_belajar', 1),
(8, '2026_09_23_121332_create_kuis_tik_table', 1),
(9, '2026_09_23_121332_create_lab_praktik_table', 1),
(10, '0000_00_00_000000_create_sessions_table', 2),
(11, '2026_09_29_032531_add_penjelasan_opsi_to_kuis_tik_table', 3),
(12, '2026_09_29_033818_change_kunci_jawaban_to_json_in_kuis_tik', 4),
(13, '2026_09_29_153917_create_kuis_settings_table', 5),
(14, '2026_09_30_023334_create_attachments_table', 6),
(15, '2026_09_30_032109_add_status_to_kuis_settings_table', 7),
(16, '2026_09_30_065120_create_api_tokens_table', 8),
(17, '2026_09_30_065441_add_profile_fields_to_users_table', 8),
(18, '2026_09_30_095025_add_profile_fields_to_gurus_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress_belajar`
--

CREATE TABLE `progress_belajar` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `status` enum('belum_mulai','sedang_belajar','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_mulai',
  `status_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `progress_persen` int NOT NULL DEFAULT '0',
  `persentase_selesai` int NOT NULL DEFAULT '0',
  `skor` int DEFAULT NULL,
  `nilai_kuis` int DEFAULT NULL,
  `nilai_lab` int DEFAULT NULL,
  `nilai_akhir` int DEFAULT NULL,
  `mulai_belajar` timestamp NULL DEFAULT NULL,
  `selesai_belajar` timestamp NULL DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('vJZZklvbJpTzIVAkOSI4P9OjAHcxKIsGhf0j5Vbo', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'eyJfdG9rZW4iOiI3VHd1c3ltcW9uSDkyZHhpcHBJbVV6WkMzcU51Yk9adUlzVE1ZVXdCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxXC9rZWxvbGEtbWF0ZXJpIiwicm91dGUiOiJrZWxvbGEubWF0ZXJpLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOlsiX29sZF9pbnB1dCIsImVycm9ycyJdLCJuZXciOltdfSwibG9naW5fZ3VydV81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJfb2xkX2lucHV0Ijp7ImRlc2tyaXBzaSI6IlRlc3RpbmcgUE9TVCIsImVzdGltYXNpX3dha3R1IjoiMjQwIiwibGV2ZWwiOiI0IiwianVkdWwiOiJQSFAgQmFja2VuZCBUZXN0IiwiX3Rva2VuIjoiN1R3dXN5bXFvbkg5MmR4aXBwSW1VelpDM3FOdWJPWnVJc1RNWVV3QiJ9LCJlcnJvcnMiOnsiZGVmYXVsdCI6eyJmb3JtYXQiOiI6bWVzc2FnZSIsIm1lc3NhZ2VzIjp7ImlkX21hdGVyaSI6WyJUaGUgaWQgbWF0ZXJpIGZpZWxkIGlzIHJlcXVpcmVkLiJdLCJrYXRlZ29yaSI6WyJUaGUga2F0ZWdvcmkgZmllbGQgaXMgcmVxdWlyZWQuIl0sImxldmVsIjpbIlRoZSBzZWxlY3RlZCBsZXZlbCBpcyBpbnZhbGlkLiJdLCJrb250ZW4iOlsiVGhlIGtvbnRlbiBmaWVsZCBpcyByZXF1aXJlZC4iXX19fX0=', 1790167978);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_tokens_token_unique` (`token`),
  ADD KEY `api_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_attachable_type_attachable_id_index` (`attachable_type`,`attachable_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_nip_unique` (`nip`),
  ADD UNIQUE KEY `gurus_email_unique` (`email`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kuis_settings`
--
ALTER TABLE `kuis_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kuis_settings_materi_id_unique` (`materi_id`),
  ADD UNIQUE KEY `kuis_settings_id_kuis_unique` (`id_kuis`);

--
-- Indexes for table `kuis_tik`
--
ALTER TABLE `kuis_tik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kuis_tik_id_soal_unique` (`id_soal`),
  ADD KEY `kuis_tik_materi_id_foreign` (`materi_id`);

--
-- Indexes for table `lab_praktik`
--
ALTER TABLE `lab_praktik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_praktik_id_lab_unique` (`id_lab`),
  ADD KEY `lab_praktik_materi_id_foreign` (`materi_id`);

--
-- Indexes for table `materi_belajar`
--
ALTER TABLE `materi_belajar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materi_belajar_id_materi_unique` (`id_materi`),
  ADD KEY `materi_belajar_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `progress_belajar`
--
ALTER TABLE `progress_belajar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `progress_belajar_user_id_materi_id_unique` (`user_id`,`materi_id`),
  ADD KEY `progress_belajar_materi_id_foreign` (`materi_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `api_tokens`
--
ALTER TABLE `api_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuis_settings`
--
ALTER TABLE `kuis_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kuis_tik`
--
ALTER TABLE `kuis_tik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_praktik`
--
ALTER TABLE `lab_praktik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materi_belajar`
--
ALTER TABLE `materi_belajar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `progress_belajar`
--
ALTER TABLE `progress_belajar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kuis_settings`
--
ALTER TABLE `kuis_settings`
  ADD CONSTRAINT `kuis_settings_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kuis_tik`
--
ALTER TABLE `kuis_tik`
  ADD CONSTRAINT `kuis_tik_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_praktik`
--
ALTER TABLE `lab_praktik`
  ADD CONSTRAINT `lab_praktik_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materi_belajar`
--
ALTER TABLE `materi_belajar`
  ADD CONSTRAINT `materi_belajar_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress_belajar`
--
ALTER TABLE `progress_belajar`
  ADD CONSTRAINT `progress_belajar_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progress_belajar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
