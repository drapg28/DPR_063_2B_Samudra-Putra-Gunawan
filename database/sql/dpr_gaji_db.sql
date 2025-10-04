-- ==============================
-- DATABASE STRUCTURE
-- ==============================

-- Tabel Pengguna
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_pengguna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) NOT NULL,
  `role` enum('Admin','Public') NOT NULL DEFAULT 'Public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Anggota
CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) NOT NULL,
  `gelar_depan` varchar(50) DEFAULT NULL,
  `gelar_belakang` varchar(50) DEFAULT NULL,
  `jabatan` enum('Ketua','Wakil Ketua','Anggota') NOT NULL,
  `status_pernikahan` enum('Kawin','Belum Kawin','Cerai Hidup','Cerai Mati') NOT NULL DEFAULT 'Belum Kawin',
  `jumlah_anak` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Komponen Gaji
CREATE TABLE IF NOT EXISTS `komponen_gaji` (
  `id_komponen_gaji` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_komponen` varchar(100) NOT NULL,
  `kategori` enum('Gaji Pokok','Tunjangan Melekat','Tunjangan Lain') NOT NULL,
  `jabatan` enum('Ketua','Wakil Ketua','Anggota','Semua') NOT NULL,
  `nominal` decimal(17,2) NOT NULL,
  `satuan` enum('Bulan','Hari','Periode') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komponen_gaji`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Penggajian (Pivot Table)
CREATE TABLE IF NOT EXISTS `penggajian` (
  `id_komponen_gaji` bigint(20) UNSIGNED NOT NULL,
  `id_anggota` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komponen_gaji`,`id_anggota`),
  KEY `penggajian_id_anggota_foreign` (`id_anggota`),
  CONSTRAINT `penggajian_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE,
  CONSTRAINT `penggajian_id_komponen_gaji_foreign` FOREIGN KEY (`id_komponen_gaji`) REFERENCES `komponen_gaji` (`id_komponen_gaji`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================
-- DATA PENGGUNA (Admin & Public)
-- ==============================
INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `email`, `nama_depan`, `nama_belakang`, `role`) VALUES
(1, 'admin', '$2y$10$ZUFh4lLwB9YUOONYitdo6u1WGkmaItKKGZWDXr/SdJ0kqatxqYhB6', 'thoriq@simanjuntak.com', 'Thoriq', 'Simanjuntak', 'Admin'),
(2, 'citizen', '$2y$10$DW2xTeWcEKu.7X2nmPf82OgSIEos73jbCfjyWqg7F0CXFGVNEtlMi', 'richard@subakat.com', 'Richard', 'Subakat', 'Public');

-- ==============================
-- DATA ANGGOTA DPR (6 orang)
-- ==============================
INSERT INTO `anggota` (`id_anggota`, `nama_depan`, `nama_belakang`, `gelar_depan`, `gelar_belakang`, `jabatan`, `status_pernikahan`, `jumlah_anak`) VALUES
(101, 'Puan', 'Maharani', 'Dr. (H.C.)', 'S.Sos.', 'Ketua', 'Kawin', 2),
(102, 'Lodewijk', 'Paulus', NULL, NULL, 'Wakil Ketua', 'Kawin', 2),
(103, 'Fadli', 'Zon', 'Dr.', 'S.S., M.Sc.', 'Anggota', 'Kawin', 3),
(104, 'Sufmi', 'Dasco', 'Prof. Dr. Ir. H.', 'S.H., M.H.', 'Wakil Ketua', 'Kawin', 2),
(105, 'Muhaimin', 'Iskandar', 'Dr (HC). Drs.', NULL, 'Anggota', 'Kawin', 2),
(106, 'Herman', 'Hery', NULL, NULL, 'Anggota', 'Belum Kawin', 0);

-- ==============================
-- DATA KOMPONEN GAJI (23 item)
-- ==============================

-- Gaji Pokok
INSERT INTO `komponen_gaji` (`id_komponen_gaji`, `nama_komponen`, `kategori`, `jabatan`, `nominal`, `satuan`) VALUES
(201, 'Gaji Pokok Ketua', 'Gaji Pokok', 'Ketua', 5040000.00, 'Bulan'),
(202, 'Gaji Pokok Wakil Ketua', 'Gaji Pokok', 'Wakil Ketua', 4620000.00, 'Bulan'),
(203, 'Gaji Pokok Anggota', 'Gaji Pokok', 'Anggota', 4200000.00, 'Bulan');

-- Tunjangan Melekat
INSERT INTO `komponen_gaji` (`id_komponen_gaji`, `nama_komponen`, `kategori`, `jabatan`, `nominal`, `satuan`) VALUES
(204, 'Tunjangan Istri/Suami', 'Tunjangan Melekat', 'Semua', 420000.00, 'Bulan'),
(205, 'Tunjangan Anak', 'Tunjangan Melekat', 'Semua', 168000.00, 'Bulan'),
(206, 'Uang Sidang/Paket', 'Tunjangan Melekat', 'Semua', 2000000.00, 'Bulan'),
(207, 'Tunjangan Jabatan Ketua', 'Tunjangan Melekat', 'Ketua', 18900000.00, 'Bulan'),
(208, 'Tunjangan Jabatan Wakil Ketua', 'Tunjangan Melekat', 'Wakil Ketua', 15600000.00, 'Bulan'),
(209, 'Tunjangan Jabatan Anggota', 'Tunjangan Melekat', 'Anggota', 9700000.00, 'Bulan'),
(210, 'Tunjangan Beras', 'Tunjangan Melekat', 'Semua', 12000000.00, 'Bulan');

-- Tunjangan Lain
INSERT INTO `komponen_gaji` (`id_komponen_gaji`, `nama_komponen`, `kategori`, `jabatan`, `nominal`, `satuan`) VALUES
(213, 'Tunjangan Kehormatan Ketua', 'Tunjangan Lain', 'Ketua', 6690000.00, 'Bulan'),
(214, 'Tunjangan Kehormatan Wakil Ketua', 'Tunjangan Lain', 'Wakil Ketua', 6450000.00, 'Bulan'),
(215, 'Tunjangan Kehormatan Anggota', 'Tunjangan Lain', 'Anggota', 5580000.00, 'Bulan'),
(216, 'Tunjangan Komunikasi Ketua', 'Tunjangan Lain', 'Ketua', 16468000.00, 'Bulan'),
(217, 'Tunjangan Komunikasi Wakil Ketua', 'Tunjangan Lain', 'Wakil Ketua', 16009000.00, 'Bulan'),
(218, 'Tunjangan Komunikasi Anggota', 'Tunjangan Lain', 'Anggota', 15554000.00, 'Bulan'),
(219, 'Tunjangan Fungsi Ketua', 'Tunjangan Lain', 'Ketua', 5250000.00, 'Bulan'),
(220, 'Tunjangan Fungsi Wakil Ketua', 'Tunjangan Lain', 'Wakil Ketua', 4500000.00, 'Bulan'),
(221, 'Tunjangan Fungsi Anggota', 'Tunjangan Lain', 'Anggota', 3750000.00, 'Bulan'),
(222, 'Bantuan Listrik & Telepon', 'Tunjangan Lain', 'Semua', 7700000.00, 'Bulan'),
(223, 'Asisten Anggota', 'Tunjangan Lain', 'Semua', 2250000.00, 'Bulan'),
(224, 'Tunjangan Perumahan', 'Tunjangan Lain', 'Semua', 50000000.00, 'Bulan'),
(225, 'Fasilitas Kredit Mobil', 'Tunjangan Lain', 'Semua', 70000000.00, 'Periode');

-- ==============================
-- RELASI PENGGAJIAN (6 anggota)
-- ==============================

-- Ketua DPR (Puan)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(201,101),(204,101),(205,101),(206,101),(207,101),
(210,101),(213,101),(216,101),(219,101),(222,101),
(223,101),(224,101),(225,101);

-- Wakil Ketua DPR (Lodewijk)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(202,102),(204,102),(205,102),(206,102),(208,102),
(210,102),(214,102),(217,102),(220,102),(222,102),
(223,102),(224,102),(225,102);

-- Anggota DPR (Fadli)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(203,103),(204,103),(205,103),(206,103),(209,103),
(210,103),(215,103),(218,103),(221,103),(222,103),
(223,103),(224,103),(225,103);

-- Wakil Ketua DPR (Dasco)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(202,104),(204,104),(205,104),(206,104),(208,104),
(210,104),(214,104),(217,104),(220,104),(222,104),
(223,104),(224,104),(225,104);

-- Anggota DPR (Muhaimin)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(203,105),(204,105),(205,105),(206,105),(209,105),
(210,105),(215,105),(218,105),(221,105),(222,105),
(223,105),(224,105),(225,105);

-- Anggota DPR (Herman)
INSERT INTO `penggajian` (`id_komponen_gaji`, `id_anggota`) VALUES
(203,106),(206,106),(209,106),
(210,106),(215,106),(218,106),(221,106),(222,106),
(223,106),(224,106),(225,106);