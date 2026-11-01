-- =====================================================================
-- db_debugtik : schema rapi + tipe data disesuaikan
-- MySQL 8.x | utf8mb4 | InnoDB
-- =====================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";

SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `db_debugtik` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_debugtik`;

-- =====================================================================
-- 1. TABEL INTI APLIKASI
-- =====================================================================

-- ---------------------------------------------------------------------
-- gurus
-- ---------------------------------------------------------------------
CREATE TABLE `gurus` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nip` VARCHAR(18) NOT NULL COMMENT 'NIP = 18 digit',
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL COMMENT 'hash bcrypt/argon, biarkan 255',
    `role` ENUM('teacher', 'lab_admin') NOT NULL,
    `sekolah` VARCHAR(150) NOT NULL,
    `foto_profil` VARCHAR(150) DEFAULT NULL,
    `tahun_ajaran` VARCHAR(9) NOT NULL DEFAULT '2024/2025',
    `semester` ENUM('Ganjil', 'Genap') NOT NULL DEFAULT 'Ganjil',
    `mata_pelajaran` VARCHAR(100) NOT NULL DEFAULT 'Teknologi Informasi & Komunikasi',
    `no_hp` VARCHAR(20) DEFAULT NULL,
    `active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `gurus_nip_unique` (`nip`),
    UNIQUE KEY `gurus_email_unique` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- users (siswa)
-- ---------------------------------------------------------------------
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `kelas` VARCHAR(20) DEFAULT NULL COMMENT 'contoh: XI RPL 1',
    `no_hp` VARCHAR(20) DEFAULT NULL,
    `foto_profil` VARCHAR(150) DEFAULT NULL,
    `active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `email` VARCHAR(100) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- materi_belajar
-- ---------------------------------------------------------------------
CREATE TABLE `materi_belajar` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_materi` VARCHAR(30) NOT NULL COMMENT 'contoh: MAT-HTML-01',
    `guru_id` BIGINT UNSIGNED NOT NULL,
    `judul` VARCHAR(150) NOT NULL,
    `deskripsi` VARCHAR(500) NOT NULL,
    `kategori` ENUM(
        'HTML Dasar',
        'CSS Dasar',
        'JS Dasar',
        'Web Responsif'
    ) NOT NULL,
    `level` ENUM(
        'Pemula',
        'Menengah',
        'Lanjutan'
    ) NOT NULL DEFAULT 'Pemula',
    `konten` TEXT NOT NULL,
    `estimasi_waktu` SMALLINT UNSIGNED NOT NULL DEFAULT 45 COMMENT 'menit',
    `tingkat_kesulitan` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `published` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `materi_belajar_id_materi_unique` (`id_materi`),
    KEY `materi_belajar_guru_id_foreign` (`guru_id`),
    CONSTRAINT `materi_belajar_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- kuis_settings
-- ---------------------------------------------------------------------
CREATE TABLE `kuis_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `materi_id` BIGINT UNSIGNED NOT NULL,
    `id_kuis` VARCHAR(50) NOT NULL COMMENT 'Kode unik kuis, contoh: KUIS-HTML-2024',
    `waktu_per_soal` SMALLINT UNSIGNED NOT NULL DEFAULT 30 COMMENT 'Nilai numerik waktu per soal',
    `satuan_waktu` ENUM('detik', 'menit', 'jam') NOT NULL DEFAULT 'detik',
    `kkm` TINYINT UNSIGNED NOT NULL DEFAULT 70 COMMENT 'Persentase minimum lulus, 0-100',
    `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    `published_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `kuis_settings_materi_id_unique` (`materi_id`),
    UNIQUE KEY `kuis_settings_id_kuis_unique` (`id_kuis`),
    CONSTRAINT `kuis_settings_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- kuis_tik
-- (kunci_jawaban sebelumnya TEXT, padahal isinya JSON -> diubah ke JSON,
--  sesuai migrasi change_kunci_jawaban_to_json_in_kuis_tik)
-- ---------------------------------------------------------------------
CREATE TABLE `kuis_tik` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `materi_id` BIGINT UNSIGNED NOT NULL,
    `id_soal` VARCHAR(50) NOT NULL,
    `pertanyaan` TEXT NOT NULL,
    `tipe` ENUM(
        'pilihan_ganda',
        'multiple_answer',
        'essay'
    ) NOT NULL DEFAULT 'pilihan_ganda',
    `opsi_jawaban` JSON DEFAULT NULL,
    `kunci_jawaban` JSON NOT NULL,
    `penjelasan_opsi` JSON DEFAULT NULL,
    `poin` SMALLINT UNSIGNED NOT NULL DEFAULT 25,
    `urutan` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `kuis_tik_id_soal_unique` (`id_soal`),
    KEY `kuis_tik_materi_id_foreign` (`materi_id`),
    CONSTRAINT `kuis_tik_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- lab_praktik
-- ---------------------------------------------------------------------
CREATE TABLE `lab_praktik` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `materi_id` BIGINT UNSIGNED NOT NULL,
    `id_lab` VARCHAR(50) NOT NULL,
    `deskripsi_kasus` TEXT NOT NULL,
    `kode_soal_awal` TEXT NOT NULL,
    `bug_target` TEXT NOT NULL,
    `solusi_fix` TEXT NOT NULL,
    `tingkat_kesulitan` ENUM('mudah', 'sedang', 'sulit') NOT NULL DEFAULT 'mudah',
    `poin_max` SMALLINT UNSIGNED NOT NULL DEFAULT 100,
    `test_cases` JSON DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `lab_praktik_id_lab_unique` (`id_lab`),
    KEY `lab_praktik_materi_id_foreign` (`materi_id`),
    CONSTRAINT `lab_praktik_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- progress_belajar
-- Catatan: kolom status/status_selesai, progress_persen/persentase_selesai,
-- dan skor/nilai_akhir terlihat redundan. Dipertahankan agar kode
-- aplikasi tidak rusak; pertimbangkan digabung nanti.
-- ---------------------------------------------------------------------
CREATE TABLE `progress_belajar` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `materi_id` BIGINT UNSIGNED NOT NULL,
    `status` ENUM(
        'belum_mulai',
        'sedang_belajar',
        'selesai'
    ) NOT NULL DEFAULT 'belum_mulai',
    `status_selesai` TINYINT(1) NOT NULL DEFAULT 0,
    `progress_persen` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-100',
    `persentase_selesai` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-100',
    `skor` SMALLINT UNSIGNED DEFAULT NULL,
    `nilai_kuis` TINYINT UNSIGNED DEFAULT NULL COMMENT '0-100',
    `nilai_lab` TINYINT UNSIGNED DEFAULT NULL COMMENT '0-100',
    `nilai_akhir` TINYINT UNSIGNED DEFAULT NULL COMMENT '0-100',
    `mulai_belajar` TIMESTAMP NULL DEFAULT NULL,
    `selesai_belajar` TIMESTAMP NULL DEFAULT NULL,
    `catatan` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `progress_belajar_user_id_materi_id_unique` (`user_id`, `materi_id`),
    KEY `progress_belajar_materi_id_foreign` (`materi_id`),
    CONSTRAINT `progress_belajar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `progress_belajar_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi_belajar` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- attachments (polymorphic)
-- ---------------------------------------------------------------------
CREATE TABLE `attachments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `attachable_type` VARCHAR(100) NOT NULL COMMENT 'nama class model',
    `attachable_id` BIGINT UNSIGNED NOT NULL,
    `nama_file` VARCHAR(150) NOT NULL,
    `path` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `ukuran` INT UNSIGNED NOT NULL COMMENT 'byte (maks ~4 GB)',
    `disk` VARCHAR(20) NOT NULL DEFAULT 'public',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `attachments_attachable_type_attachable_id_index` (
        `attachable_type`,
        `attachable_id`
    )
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- api_tokens (polymorphic)
-- ---------------------------------------------------------------------
CREATE TABLE `api_tokens` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tokenable_type` VARCHAR(100) NOT NULL,
    `tokenable_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `token` CHAR(64) NOT NULL COMMENT 'sha256 = tepat 64 karakter',
    `abilities` VARCHAR(255) NOT NULL DEFAULT '*',
    `last_used_at` TIMESTAMP NULL DEFAULT NULL,
    `expires_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `api_tokens_token_unique` (`token`),
    KEY `api_tokens_tokenable_type_tokenable_id_index` (
        `tokenable_type`,
        `tokenable_id`
    )
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================================
-- 2. TABEL FRAMEWORK LARAVEL (sengaja TIDAK diubah ukurannya,
--    supaya kompatibel dengan migrasi/driver bawaan Laravel)
-- =====================================================================

CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_index` (`expiration`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` SMALLINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT,
    `cancelled_at` INT DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` TEXT,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================================
-- 3. DATA AWAL
-- (tabel sessions tidak disertakan; remember_token dikosongkan)
-- =====================================================================

INSERT INTO
    `gurus` (
        `id`,
        `nip`,
        `name`,
        `email`,
        `password`,
        `role`,
        `sekolah`,
        `foto_profil`,
        `tahun_ajaran`,
        `semester`,
        `mata_pelajaran`,
        `no_hp`,
        `active`,
        `last_login`,
        `remember_token`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        '198512051234567890',
        'Siti Nurhaliza',
        'siti.nurhaliza@sekolah.sch.id',
        '$2y$12$qG5iSIzz9bNwW.vmJnm4ROV/HmbYkJ2O1EmXEywJPR9PxmpvGbhv2',
        'teacher',
        'SMAN 1 Jakarta Pusat',
        NULL,
        '2024/2025',
        'Ganjil',
        'Teknologi Informasi & Komunikasi',
        NULL,
        1,
        NULL,
        NULL,
        '2026-09-23 05:26:02',
        '2026-09-23 05:26:02'
    ),
    (
        2,
        '198703151098765432',
        'Ahmad Hidayat',
        'ahmad.hidayat@sekolah.sch.id',
        '$2y$12$M6w4giAMoun0MvNMvhzNGOoJbJKCG/TzC7ntq9WWlaK7xZLPPCNVa',
        'lab_admin',
        'SMAN 1 Jakarta Pusat',
        NULL,
        '2024/2025',
        'Ganjil',
        'Teknologi Informasi & Komunikasi',
        NULL,
        1,
        NULL,
        NULL,
        '2026-09-23 05:26:03',
        '2026-09-23 05:26:03'
    );

INSERT INTO
    `materi_belajar` (
        `id`,
        `id_materi`,
        `guru_id`,
        `judul`,
        `deskripsi`,
        `kategori`,
        `level`,
        `konten`,
        `estimasi_waktu`,
        `tingkat_kesulitan`,
        `published`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'MAT-HTML-01',
        1,
        'HTML Dasar: Struktur Dokumen & Tag Essential',
        'Materi pengenalan HTML: struktur dokumen, tag HTML, heading, paragraph, link, dan gambar.',
        'HTML Dasar',
        'Pemula',
        '<p>HTML adalah bahasa markup untuk membuat struktur halaman web.</p>',
        45,
        1,
        1,
        '2026-09-23 05:26:04',
        '2026-09-23 05:26:04'
    ),
    (
        2,
        'MAT-CSS-02',
        1,
        'CSS Dasar: Styling & Layout Box Model',
        'Pengenalan CSS: syntax, selector, property, box model, margin, padding, dan display.',
        'CSS Dasar',
        'Pemula',
        '<p>CSS mengatur tampilan dan layout elemen HTML.</p>',
        60,
        2,
        1,
        '2026-09-23 05:26:04',
        '2026-09-23 05:26:04'
    ),
    (
        3,
        'MAT-JS-03',
        1,
        'JavaScript Dasar: Variabel, Function, dan DOM',
        'Pengenalan JavaScript: variabel, tipe data, function, event listener, dan DOM manipulation.',
        'JS Dasar',
        'Menengah',
        '<p>JavaScript membuat halaman web interaktif.</p>',
        75,
        2,
        1,
        '2026-09-23 05:26:04',
        '2026-09-23 05:26:04'
    );

INSERT INTO
    `kuis_settings` (
        `id`,
        `materi_id`,
        `id_kuis`,
        `waktu_per_soal`,
        `satuan_waktu`,
        `kkm`,
        `status`,
        `published_at`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        1,
        'KUIS-HTML-120',
        30,
        'detik',
        70,
        'draft',
        NULL,
        '2026-09-29 19:26:33',
        '2026-09-29 22:55:45'
    );

INSERT INTO
    `kuis_tik` (
        `id`,
        `materi_id`,
        `id_soal`,
        `pertanyaan`,
        `tipe`,
        `opsi_jawaban`,
        `kunci_jawaban`,
        `penjelasan_opsi`,
        `poin`,
        `urutan`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        1,
        'KUIS-HTML-01',
        'Tag HTML untuk membuat heading level 1?',
        'pilihan_ganda',
        '["<h1>", "<h2>", "<title>", "<head>"]',
        '["<h1>"]',
        NULL,
        25,
        1,
        '2026-09-23 05:26:04',
        '2026-09-23 05:26:04'
    ),
    (
        4,
        3,
        'java script-192',
        'apakah yang dimaksud dengan java script',
        'pilihan_ganda',
        '["A", "B", "C", "D"]',
        '["A"]',
        '[null, null, null, null]',
        25,
        1,
        '2026-09-29 06:15:58',
        '2026-09-29 06:15:58'
    ),
    (
        5,
        1,
        'KUIS-HTML-120-02',
        'APA ITU HTML',
        'pilihan_ganda',
        '["A", "B", "C", "D"]',
        '["B"]',
        '[null, null, null, null]',
        10,
        2,
        '2026-09-29 19:27:38',
        '2026-09-29 23:25:49'
    );

INSERT INTO
    `lab_praktik` (
        `id`,
        `materi_id`,
        `id_lab`,
        `deskripsi_kasus`,
        `kode_soal_awal`,
        `bug_target`,
        `solusi_fix`,
        `tingkat_kesulitan`,
        `poin_max`,
        `test_cases`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        2,
        'LAB-CSS-01',
        'Fix CSS box model: padding missing, border double.',
        '.box { margin: 10px; padding: 20px; border: 5px solid red; }',
        'padding: 20px;',
        '.box { margin: 10px; padding: 30px; border: 5px solid red; }',
        'mudah',
        100,
        '["padding: 30px;", "border: 5px solid red;"]',
        '2026-09-23 05:26:04',
        '2026-09-23 05:26:04'
    );

INSERT INTO
    `migrations` (`id`, `migration`, `batch`)
VALUES (
        1,
        '0001_01_01_000000_create_users_table',
        1
    ),
    (
        2,
        '0001_01_01_000001_create_cache_table',
        1
    ),
    (
        3,
        '0001_01_01_000002_create_jobs_table',
        1
    ),
    (
        4,
        '2026_09_23_095618_create_gurus_table',
        1
    ),
    (
        5,
        '2026_09_23_095647_create_materi_belajar_table',
        1
    ),
    (
        6,
        '2026_09_23_095649_create_progress_belajar_table',
        1
    ),
    (
        7,
        '2026_09_23_102728_add_extra_columns_to_progress_belajar',
        1
    ),
    (
        8,
        '2026_09_23_121332_create_kuis_tik_table',
        1
    ),
    (
        9,
        '2026_09_23_121332_create_lab_praktik_table',
        1
    ),
    (
        10,
        '0000_00_00_000000_create_sessions_table',
        2
    ),
    (
        11,
        '2026_09_29_032531_add_penjelasan_opsi_to_kuis_tik_table',
        3
    ),
    (
        12,
        '2026_09_29_033818_change_kunci_jawaban_to_json_in_kuis_tik',
        4
    ),
    (
        13,
        '2026_09_29_153917_create_kuis_settings_table',
        5
    ),
    (
        14,
        '2026_09_30_023334_create_attachments_table',
        6
    ),
    (
        15,
        '2026_09_30_032109_add_status_to_kuis_settings_table',
        7
    ),
    (
        16,
        '2026_09_30_065120_create_api_tokens_table',
        8
    ),
    (
        17,
        '2026_09_30_065441_add_profile_fields_to_users_table',
        8
    ),
    (
        18,
        '2026_09_30_095025_add_profile_fields_to_gurus_table',
        9
    );

-- Reset auto increment sesuai data
ALTER TABLE `gurus` AUTO_INCREMENT = 3;

ALTER TABLE `materi_belajar` AUTO_INCREMENT = 4;

ALTER TABLE `kuis_settings` AUTO_INCREMENT = 2;

ALTER TABLE `kuis_tik` AUTO_INCREMENT = 6;

ALTER TABLE `lab_praktik` AUTO_INCREMENT = 2;

ALTER TABLE `migrations` AUTO_INCREMENT = 19;

SET FOREIGN_KEY_CHECKS = 1;