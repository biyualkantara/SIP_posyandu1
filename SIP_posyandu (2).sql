-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: sip-mysql
-- Generation Time: Dec 03, 2025 at 03:22 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SIP_posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_chat_history`
--

CREATE TABLE `ai_chat_history` (
  `id_chat` int NOT NULL,
  `id_operator` int DEFAULT NULL,
  `id_wuspus` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `role` enum('user','admin','ai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_chat_history`
--

INSERT INTO `ai_chat_history` (`id_chat`, `id_operator`, `id_wuspus`, `id_pengguna`, `role`, `pesan`, `response`, `waktu`) VALUES
(1, 1, NULL, NULL, 'user', 'Bagaimana cara mendaftar bayi baru?', 'Silakan buka menu Data Bayi -> Tambah Bayi', '2025-11-19 14:00:30'),
(2, 1, 1, NULL, 'admin', 'Saya ingin update data WUSPUS', 'Silakan akses menu WUSPUS -> Edit', '2025-11-19 14:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `ai_food_recommendation`
--

CREATE TABLE `ai_food_recommendation` (
  `id_rekomendasi` int NOT NULL,
  `id_prediksi` int NOT NULL,
  `nama_makanan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_makanan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kandungan_gizi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `porsi_harian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_food_recommendation`
--

INSERT INTO `ai_food_recommendation` (`id_rekomendasi`, `id_prediksi`, `nama_makanan`, `jenis_makanan`, `kandungan_gizi`, `porsi_harian`, `catatan`) VALUES
(1, 1, 'Telur Rebus', 'Protein', 'Protein tinggi', '1 butir/hari', 'Pemantauan lanjutan'),
(2, 1, 'Sayur Hijau', 'Sayur', 'Zat besi', '1 porsi/hari', 'Masukkan sayuran lunak');

-- --------------------------------------------------------

--
-- Table structure for table `ai_stunting_prediction`
--

CREATE TABLE `ai_stunting_prediction` (
  `id_prediksi` int NOT NULL,
  `id_bayi` int DEFAULT NULL,
  `umur_bulan` int DEFAULT NULL,
  `berat_badan` decimal(6,2) DEFAULT NULL,
  `tinggi_badan` decimal(6,2) DEFAULT NULL,
  `tinggi_ibu` decimal(5,2) DEFAULT NULL,
  `tinggi_ayah` decimal(5,2) DEFAULT NULL,
  `z_score` float DEFAULT NULL,
  `status_gizi` enum('Normal','Berisiko Stunting','Stunting') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Normal',
  `tingkat_risiko` decimal(5,2) DEFAULT '0.00',
  `tanggal_prediksi` date DEFAULT (curdate()),
  `rekomendasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sumber_model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_stunting_prediction`
--

INSERT INTO `ai_stunting_prediction` (`id_prediksi`, `id_bayi`, `umur_bulan`, `berat_badan`, `tinggi_badan`, `tinggi_ibu`, `tinggi_ayah`, `z_score`, `status_gizi`, `tingkat_risiko`, `tanggal_prediksi`, `rekomendasi`, `sumber_model`, `created_at`) VALUES
(1, 2, 18, 8.50, 72.00, 156.50, 170.00, NULL, 'Berisiko Stunting', 68.50, '2025-10-13', 'Perlukan makanan tinggi protein + zat besi', 'rule_based_v1', '2025-11-19 14:00:30');

--
-- Triggers `ai_stunting_prediction`
--
DELIMITER $$
CREATE TRIGGER `trg_after_prediksi_insert` AFTER INSERT ON `ai_stunting_prediction` FOR EACH ROW BEGIN
  IF NEW.tingkat_risiko >= 75 THEN
    INSERT INTO ai_food_recommendation (id_prediksi, nama_makanan, jenis_makanan, kandungan_gizi, porsi_harian, catatan)
    VALUES (NEW.id_prediksi, 'Telur Rebus', 'Protein', 'Protein tinggi, Vitamin D', '1-2 butir/hari', 'Sumber protein murah dan cepat'),
           (NEW.id_prediksi, 'Ikan Salmon/Tempe', 'Protein', 'Protein, Omega-3 / Protein nabati', '1 porsi/hari', 'Ikan bila tersedia, tempe alternatif'),
           (NEW.id_prediksi, 'Sayur Bayam/Kangkung', 'Sayur', 'Zat besi, vitamin A', '1 mangkuk/hari', 'Tingkatkan serat dan mikronutrien');
  ELSEIF NEW.tingkat_risiko >= 50 THEN
    INSERT INTO ai_food_recommendation (id_prediksi, nama_makanan, jenis_makanan, kandungan_gizi, porsi_harian, catatan)
    VALUES (NEW.id_prediksi, 'Telur Rebus', 'Protein', 'Protein tinggi', '1 butir/hari', 'Pemantauan lanjutan'),
           (NEW.id_prediksi, 'Sayur Hijau', 'Sayur', 'Zat besi', '1 porsi/hari', 'Masukkan sayuran lunak');
  ELSE
    INSERT INTO ai_food_recommendation (id_prediksi, nama_makanan, jenis_makanan, kandungan_gizi, porsi_harian, catatan)
    VALUES (NEW.id_prediksi, 'ASI Eksklusif / Susu Formula sesuai umur', 'Susu/ASI', 'Gizi seimbang untuk bayi/anak', 'Sesuai kebutuhan umur', 'Teruskan pola makan sehat');
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_ai_prediksi_autofill_height` BEFORE INSERT ON `ai_stunting_prediction` FOR EACH ROW BEGIN
  DECLARE ibu_height DECIMAL(5,2);
  DECLARE ayah_height DECIMAL(5,2);

  SELECT w.tinggi_ibu, w.tinggi_ayah 
    INTO ibu_height, ayah_height
  FROM bayi b
  LEFT JOIN wuspus w ON b.id_wuspus = w.id_wuspus
  WHERE b.id_bayi = NEW.id_bayi
  LIMIT 1;

  SET NEW.tinggi_ibu = ibu_height;
  SET NEW.tinggi_ayah = ayah_height;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bayi`
--

CREATE TABLE `bayi` (
  `id_bayi` int NOT NULL,
  `id_wuspus` int DEFAULT NULL,
  `nama_bayi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jk` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lhr` date DEFAULT NULL,
  `bb` decimal(5,2) DEFAULT NULL,
  `tb` decimal(5,2) DEFAULT NULL,
  `tb_terkini` decimal(5,2) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bayi`
--

INSERT INTO `bayi` (`id_bayi`, `id_wuspus`, `nama_bayi`, `jk`, `tgl_lhr`, `bb`, `tb`, `tb_terkini`, `tgl_daftar`, `ket`) VALUES
(1, 1, 'Rafa Pratama', 'L', '2022-06-14', 3.20, 49.00, 82.00, '2022-06-15', ''),
(2, 1, 'Alya Putri', 'P', '2021-12-03', 3.10, 48.00, 80.50, '2021-12-04', ''),
(3, 2, 'Farel Nugraha', 'L', '2023-01-20', 3.25, 50.00, 74.00, '2023-01-21', ''),
(4, 3, 'Nadia Safitri', 'P', '2022-09-11', 2.90, 47.00, 78.20, '2022-09-12', ''),
(5, 4, 'Alvin Ramadhan', 'L', '2021-03-05', 3.00, 49.50, 86.00, '2021-03-06', ''),
(6, 5, 'Keisha Lestari', 'P', '2023-04-18', 3.15, 49.20, 70.00, '2023-04-19', ''),
(7, 6, 'Zidan Hakim', 'L', '2020-11-23', 2.85, 48.00, 90.00, '2020-11-24', ''),
(8, 7, 'Kayla Syifa', 'P', '2019-08-30', 3.05, 49.00, 95.00, '2019-08-31', ' [Wafat pada: 2020-09-15]'),
(9, 8, 'Rafi Akbar', 'L', '2022-02-10', 3.30, 50.00, 81.00, '2022-02-11', ''),
(10, 9, 'Salsa Aulia', 'P', '2021-07-07', 2.95, 48.50, 88.00, '2021-07-08', '');

-- --------------------------------------------------------

--
-- Table structure for table `bayi_imun`
--

CREATE TABLE `bayi_imun` (
  `id_bayi_imun` int NOT NULL,
  `id_bayi` int NOT NULL,
  `id_imun` int NOT NULL,
  `tgl_imun` date DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bayi_imun`
--

INSERT INTO `bayi_imun` (`id_bayi_imun`, `id_bayi`, `id_imun`, `tgl_imun`, `ket`) VALUES
(1, 1, 1, '2022-07-01', 'HB-0 lengkap'),
(2, 1, 2, '2022-07-15', 'BCG di Puskesmas'),
(3, 2, 1, '2021-12-05', 'HB-0 lengkap'),
(4, 2, 2, '2021-12-20', 'BCG di Puskesmas'),
(5, 3, 1, '2023-01-22', 'HB-0'),
(6, 3, 2, '2023-02-02', 'BCG'),
(7, 4, 1, '2022-09-13', 'HB-0'),
(8, 4, 2, '2022-09-25', 'BCG'),
(9, 5, 1, '2021-03-07', 'HB-0'),
(10, 5, 2, '2021-03-18', 'BCG');

-- --------------------------------------------------------

--
-- Table structure for table `bayi_pnb`
--

CREATE TABLE `bayi_pnb` (
  `id_bayi_pnb` int NOT NULL,
  `id_bayi` int NOT NULL,
  `tgl_pnb` date DEFAULT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `tb` decimal(5,2) DEFAULT NULL,
  `hasil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pmt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bayi_pnb`
--

INSERT INTO `bayi_pnb` (`id_bayi_pnb`, `id_bayi`, `tgl_pnb`, `berat`, `tb`, `hasil`, `pmt`, `ket`) VALUES
(1, 1, '2024-01-05', 10.20, 74.00, 'Naik baik', 'PMT Balita', ''),
(2, 1, '2024-04-05', 11.00, 77.00, 'Naik cukup', 'PMT Balita', ''),
(3, 2, '2024-01-05', 9.80, 72.00, 'Naik baik', 'PMT Balita', ''),
(4, 2, '2024-04-05', 10.40, 75.00, 'Naik cukup', 'PMT Balita', ''),
(5, 3, '2024-01-05', 8.20, 60.00, 'Naik baik', 'PMT Balita', ''),
(6, 3, '2024-04-05', 8.90, 63.00, 'Naik cukup', 'PMT Balita', ''),
(7, 4, '2024-01-05', 9.00, 62.00, 'Naik baik', 'PMT Balita', ''),
(8, 4, '2024-04-05', 9.70, 65.00, 'Naik cukup', 'PMT Balita', ''),
(9, 5, '2024-01-05', 11.40, 80.00, 'Naik baik', 'PMT Balita', ''),
(10, 5, '2024-04-05', 12.00, 83.00, 'Naik cukup', 'PMT Balita', ''),
(11, 6, '2024-01-05', 7.50, 59.00, 'Naik baik', 'PMT Balita', ''),
(12, 6, '2024-04-05', 8.10, 61.00, 'Naik cukup', 'PMT Balita', '');

-- --------------------------------------------------------

--
-- Table structure for table `bayi_wafat`
--

CREATE TABLE `bayi_wafat` (
  `id_wafat` int NOT NULL,
  `id_bayi` int NOT NULL,
  `tgl_kematian` date DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bayi_wafat`
--

INSERT INTO `bayi_wafat` (`id_wafat`, `id_bayi`, `tgl_kematian`, `ket`) VALUES
(1, 8, '2020-09-15', 'Pneumonia berat, dirawat di RS');

--
-- Triggers `bayi_wafat`
--
DELIMITER $$
CREATE TRIGGER `trg_after_bayi_wafat_insert` AFTER INSERT ON `bayi_wafat` FOR EACH ROW BEGIN
  UPDATE bayi SET ket = CONCAT(IFNULL(ket,''),' [Wafat pada: ', DATE_FORMAT(NEW.tgl_kematian,'%Y-%m-%d'), ']') 
    WHERE id_bayi = NEW.id_bayi;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ringkasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `isi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `penulis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul`, `ringkasan`, `isi`, `penulis`, `tanggal_waktu`) VALUES
(1, 'Gebyar Posyandu Sehat 2025', 'Kegiatan gebyar posyandu di seluruh kelurahan Kota Cimahi.', 'Kegiatan gebyar posyandu dilaksanakan serentak dengan berbagai layanan kesehatan ibu dan anak, penyuluhan gizi, serta skrining tumbuh kembang balita.', 'Dinas Kesehatan Cimahi', '2025-11-22 00:08:09'),
(2, 'Pelatihan Kader Posyandu Terpadu', 'Pelatihan peningkatan kapasitas kader posyandu.', 'Pelatihan ini mencakup pencatatan elektronik, pemantauan tumbuh kembang, dan konseling gizi bagi keluarga berisiko stunting.', 'Bidang Kesmas', '2025-11-22 00:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `bumil`
--

CREATE TABLE `bumil` (
  `id_bumil` int NOT NULL,
  `id_wuspus` int NOT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `umur_kehamilan` int DEFAULT NULL,
  `hamil_ke` int DEFAULT NULL,
  `pmt_pemulihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lila` float DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bumil`
--

INSERT INTO `bumil` (`id_bumil`, `id_wuspus`, `tgl_daftar`, `umur_kehamilan`, `hamil_ke`, `pmt_pemulihan`, `lila`, `ket`) VALUES
(1, 1, '2024-01-05', 20, 2, 'PMT Bumil KEK', 23.5, 'Pemantauan rutin'),
(2, 2, '2024-02-12', 16, 1, 'PMT Ibu Hamil', 24, ''),
(3, 5, '2023-11-20', 30, 3, 'PMT Tambahan', 25.1, '');

-- --------------------------------------------------------

--
-- Table structure for table `bumil_imun`
--

CREATE TABLE `bumil_imun` (
  `id_bumil_imun` int NOT NULL,
  `id_wuspus` int NOT NULL,
  `id_imun` int NOT NULL,
  `tgl_imun` date DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bumil_imun`
--

INSERT INTO `bumil_imun` (`id_bumil_imun`, `id_wuspus`, `id_imun`, `tgl_imun`, `ket`) VALUES
(1, 1, 4, '2024-02-01', 'TT Bumil'),
(2, 2, 4, '2024-03-01', 'TT Bumil');

-- --------------------------------------------------------

--
-- Table structure for table `bumil_pnb`
--

CREATE TABLE `bumil_pnb` (
  `id_bumil_pnb` int NOT NULL,
  `id_wuspus` int NOT NULL,
  `bln_hamil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pnb` date DEFAULT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `hasil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bumil_pnb`
--

INSERT INTO `bumil_pnb` (`id_bumil_pnb`, `id_wuspus`, `bln_hamil`, `tgl_pnb`, `berat`, `hasil`, `ket`) VALUES
(1, 1, '5 bulan', '2024-02-05', 54.20, 'Kenaikan baik', ''),
(2, 1, '6 bulan', '2024-03-05', 55.00, 'Kenaikan cukup', ''),
(3, 2, '4 bulan', '2024-03-10', 52.10, 'Perlu pemantauan', 'Keluhan mual');

-- --------------------------------------------------------

--
-- Table structure for table `data_bayi`
--

CREATE TABLE `data_bayi` (
  `id_data` int NOT NULL,
  `nama_posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_bayi` int DEFAULT NULL,
  `nama_bayi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jk` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lhr` date DEFAULT NULL,
  `bb` decimal(5,2) DEFAULT NULL,
  `tb` decimal(5,2) DEFAULT NULL,
  `nama_wuspus` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_suami` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_bayi`
--

INSERT INTO `data_bayi` (`id_data`, `nama_posyandu`, `id_bayi`, `nama_bayi`, `jk`, `tgl_lhr`, `bb`, `tb`, `nama_wuspus`, `nama_suami`, `ket`) VALUES
(1, 'Posyandu Melati Indah', 1, 'Rafa Pratama', 'L', '2022-06-14', 3.20, 82.00, 'Ani Lestari', 'Budi Santoso', ''),
(2, 'Posyandu Melati Indah', 2, 'Alya Putri', 'P', '2021-12-03', 3.10, 80.50, 'Ani Lestari', 'Budi Santoso', ''),
(3, 'Posyandu Flamboyan Asri', 3, 'Farel Nugraha', 'L', '2023-01-20', 3.25, 74.00, 'Dewi Anggraeni', 'Rizki Maulana', ''),
(4, 'Posyandu Anggrek Lestari', 4, 'Nadia Safitri', 'P', '2022-09-11', 2.90, 78.20, 'Rina Kurniasih', 'Fajar Nugraha', ''),
(5, 'Posyandu Dahlia Sehat', 5, 'Alvin Ramadhan', 'L', '2021-03-05', 3.00, 86.00, 'Eka Susilawati', 'Yudi Pratama', ''),
(6, 'Posyandu Kenanga Harmoni', 6, 'Keisha Lestari', 'P', '2023-04-18', 3.15, 70.00, 'Lilis Fitriani', 'Taufik Hidayat', ''),
(7, 'Posyandu Mawar Sentosa', 7, 'Zidan Hakim', 'L', '2020-11-23', 2.85, 90.00, 'Yuni Aprilianti', 'Agus Purnama', ''),
(8, 'Posyandu Cempaka Husada', 8, 'Kayla Syifa', 'P', '2019-08-30', 3.05, 95.00, 'Nia Kurnia', 'Dedi Kurniawan', ''),
(9, 'Posyandu Sakura Ceria', 9, 'Rafi Akbar', 'L', '2022-02-10', 3.30, 81.00, 'Mega Puspitasari', 'Yoga Saputra', ''),
(10, 'Posyandu Teratai Mandiri', 10, 'Salsa Aulia', 'P', '2021-07-07', 2.95, 88.00, 'Indah Permata', 'Bayu Firmansyah', '');

-- --------------------------------------------------------

--
-- Table structure for table `duspy`
--

CREATE TABLE `duspy` (
  `id_posyandu` int NOT NULL,
  `nama_posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `strata_psy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_posyandu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_kel` int DEFAULT NULL,
  `pj_umum` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pj_operasional` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ketuplak` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sekretaris` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `int_paud` int DEFAULT '0',
  `int_bkd` int DEFAULT '0',
  `int_terpadu` int DEFAULT '0',
  `kader_aktif` int DEFAULT '0',
  `kader_taktif` int DEFAULT '0',
  `ptgs_kb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ptgs_medis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ptgs_bidan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `duspy`
--

INSERT INTO `duspy` (`id_posyandu`, `nama_posyandu`, `strata_psy`, `alamat_posyandu`, `id_kel`, `pj_umum`, `pj_operasional`, `ketuplak`, `sekretaris`, `int_paud`, `int_bkd`, `int_terpadu`, `kader_aktif`, `kader_taktif`, `ptgs_kb`, `ptgs_medis`, `ptgs_bidan`) VALUES
(1, 'Posyandu Melati Indah', 'Madya', 'Jl. Melati Raya No. 22, Cipageran', 1, 'Nur Aisyah', 'Rina Marlina', 'Dewi Lestari', 'Ratna Dewi', 1, 1, 1, 8, 1, 'Petugas KB 1', 'Petugas Medis 1', 'Bidan 1'),
(2, 'Posyandu Flamboyan Asri', 'Pratama', 'Jl. Flamboyan No. 5, Cibabat', 3, 'Siti Rahma', 'Lilis Kurnia', 'Yuni Astuti', 'Mega Sari', 1, 1, 1, 8, 1, 'Petugas KB 2', 'Petugas Medis 2', 'Bidan 2'),
(4, 'Posyandu Dahlia Sehat', 'Mandiri', 'Jl. Dahlia No. 3, Padasuka', 7, 'Reni Puspita', 'Indah Melati', 'Tia Anggraini', 'Dian Lestari', 1, 1, 1, 8, 1, 'Petugas KB 4', 'Petugas Medis 4', 'Bidan 4'),
(5, 'Posyandu Kenanga Harmoni', 'Madya', 'Jl. Kenanga No. 8, Melong', 11, 'Yayu Pertiwi', 'Dewi Sartika', 'Novi Kurnia', 'Irma Rosdiana', 1, 1, 1, 8, 1, 'Petugas KB 5', 'Petugas Medis 5', 'Bidan 5'),
(6, 'Posyandu Mawar Sentosa', 'Pratama', 'Jl. Mawar No. 14, Leuwigajah', 12, 'Ana Pratiwi', 'Rika Amelia', 'Lia Mulyani', 'Dewi Ayu', 1, 1, 1, 8, 1, 'Petugas KB 6', 'Petugas Medis 6', 'Bidan 6'),
(7, 'Posyandu Cempaka Husada', 'Purnama', 'Jl. Cempaka No. 9, Cibeber', 13, 'Hana Lestari', 'Tata Sari', 'Dina Agustin', 'Rani Febriani', 1, 1, 1, 8, 1, 'Petugas KB 7', 'Petugas Medis 7', 'Bidan 7'),
(8, 'Posyandu Sakura Ceria', 'Madya', 'Jl. Sakura No. 2, Utama', 14, 'Rosa Amelia', 'Yani Rahayu', 'Euis Komariah', 'Sari Purnama', 1, 1, 1, 8, 1, 'Petugas KB 8', 'Petugas Medis 8', 'Bidan 8'),
(9, 'Posyandu Teratai Mandiri', 'Mandiri', 'Jl. Teratai No. 1, Cibeureum', 15, 'Maya Oktaviani', 'Nani Kusuma', 'Rita Saputri', 'Fitri Handayani', 1, 1, 1, 8, 1, 'Petugas KB 9', 'Petugas Medis 9', 'Bidan 9'),
(11, 'Posyandu Kenari Indah', 'Pratama', 'Jl. Kenari No. 3, Cipageran', 1, 'Maya Dwi', 'Sulastri Mega', 'Ayu Anggraini', 'Fira Damayanti', 1, 1, 1, 6, 2, 'KB1', 'Medis1', 'Bidan Rani'),
(13, 'Posyandu Cendana Mandiri', 'Mandiri', 'Jl. Cendana No. 9, Citeureup', 2, 'Hesti Aprilia', 'Rika Sari', 'Santi Nur', 'Mega Irma', 1, 1, 1, 5, 1, 'KB3', 'Medis3', 'Bidan Mira'),
(14, 'Posyandu Kenongo Asri', 'Purnama', 'Jl. Kenongo Raya, Baros', 6, 'Tina Amelia', 'Ririn Astuti', 'Dewi Karina', 'Mela Hardi', 1, 1, 1, 9, 1, 'KB4', 'Medis4', 'Bidan Silvi'),
(15, 'Posyandu Rambutan Sehat', 'Pratama', 'Jl. Rambutan No. 5, Padasuka', 7, 'Novi Yuliana', 'Umi Kalsum', 'Alda Kania', 'Siti Nurani', 1, 1, 1, 7, 2, 'KB5', 'Medis5', 'Bidan Risa'),
(16, 'Posyandu Leci Ceria', 'Madya', 'Jl. Leci No. 11, Setiamanah', 8, 'Tari Melinda', 'Kiki Safitri', 'Risma Farida', 'Wulan Pertiwi', 1, 1, 1, 6, 2, 'KB6', 'Medis6', 'Bidan Wati'),
(17, 'Posyandu Matoa Harmoni', 'Mandiri', 'Jl. Matoa Utama, Cimahi', 10, 'Nida Aprillia', 'Lilis Purnama', 'Yuni Mawar', 'Indri Aulia', 1, 1, 1, 8, 1, 'KB7', 'Medis7', 'Bidan Nurma'),
(18, 'Posyandu Soka Melati', 'Purnama', 'Jl. Soka No. 2, Melong', 11, 'Hana Apriliani', 'Sherly Putri', 'Mega Oktavia', 'Uun Rahayu', 1, 1, 1, 7, 1, 'KB8', 'Medis8', 'Bidan Aulia'),
(19, 'Posyandu Wijaya Kusuma', 'Madya', 'Jl. Wijaya Kusuma No. 7, Melong', 11, 'Niken Damayanti', 'Ratih Amelia', 'Puri Dwi', 'Cika Rani', 1, 1, 1, 8, 1, 'KB9', 'Medis9', 'Bidan Nirma'),
(21, 'Posyandu Pinus Ceria', 'Madya', 'Jl. Pinus No. 8, Leuwigajah', 12, 'Mala Dewi', 'Ayu Rahayu', 'Lilis Kartika', 'Nina Kamelia', 1, 1, 1, 7, 1, 'KB11', 'Medis11', 'Bidan Rina'),
(22, 'Posyandu Duku Mandiri', 'Mandiri', 'Jl. Duku No. 19, Cibeber', 13, 'Selvi Anggun', 'Tetty Marlina', 'Putri Erna', 'Gina Oktavianti', 1, 1, 1, 8, 1, 'KB12', 'Medis12', 'Bidan Eva'),
(23, 'Posyandu Mangga Lestari', 'Purnama', 'Jl. Mangga No. 2, Cibeber', 13, 'Kania Putri', 'Leli Saraswati', 'Riri Febrina', 'Dita Mariana', 1, 1, 1, 9, 1, 'KB13', 'Medis13', 'Bidan Mia'),
(24, 'Posyandu Delima Jaya', 'Pratama', 'Jl. Delima No. 15, Utama', 14, 'Rinny Amelia', 'Della Hartati', 'Winda Ayu', 'Silvi Hakim', 1, 1, 1, 5, 2, 'KB14', 'Medis14', 'Bidan Santi'),
(25, 'Posyandu Pisang Asri', 'Madya', 'Jl. Pisang No. 10, Utama', 14, 'Putri Natasya', 'Rara Fitri', 'Mala Sari', 'Linda Maya', 1, 1, 1, 8, 1, 'KB15', 'Medis15', 'Bidan Arini'),
(27, 'Posyandu Sawo Ceria', 'Mandiri', 'Jl. Sawo No. 6, Cibeureum', 15, 'Alya Widyasari', 'Novi Rahmi', 'Intan Sari', 'Icha Yuni', 1, 1, 1, 8, 1, 'KB17', 'Medis17', 'Bidan Rara'),
(44, 'Posyandu testing1', 'Pratama', 'Posyandu testing1', 13, 'Posyandu testing1', 'Posyandu testing1', 'Posyandu testing1', 'Posyandu testing1', 0, 0, 1, 1, 1, '1', 'Posyandu testing1', 'Posyandu testing1'),
(45, 'testingaja1', 'Madya', 'testingaja1', 15, 'testingaja1', 'testingaja1', 'testingaja1', 'testingaja1', 1, 1, 1, 1, 1, '1', 'testingaja1', 'testingaja1'),
(46, 'testingaja2', 'Pratama', 'testingaja2', 13, 'testingaja2', 'testingaja2', 'testingaja2', 'testingaja2', 0, 1, 1, 1, 1, 'testingaja2', 'testingaja2', 'testingaja2'),
(47, 'initeskedua', 'Madya', 'initeskedua', 6, 'initeskedua', 'initeskedua', 'initeskedua', 'initeskedua', 1, 0, 1, 1, 1, '1', 'initeskedua', 'initeskedua'),
(48, 'namaposyandutes1', 'Pratama', 'namaposyandutes1', 15, 'namaposyandutes1', 'namaposyandutes1', 'namaposyandutes1', 'namaposyandutes1', 1, 1, 1, 1, 1, 'namaposyandutes1', 'namaposyandutes1', 'namaposyandutes1'),
(49, 'namaposyandutes2', 'Pratama', 'namaposyandutes2', 15, 'namaposyandutes2', 'namaposyandutes2', 'namaposyandutes2', 'namaposyandutes2', 1, 1, 1, 5, 5, 'namaposyandutes2', 'namaposyandutes2', 'namaposyandutes2');

-- --------------------------------------------------------

--
-- Table structure for table `format_1`
--

CREATE TABLE `format_1` (
  `id_format1` int NOT NULL,
  `kecamatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pendataan` int DEFAULT NULL,
  `nama_ibu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ayah` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bayi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tanggal_bayi_meninggal` date DEFAULT NULL,
  `tanggal_ibu_meninggal` date DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `format_1`
--

INSERT INTO `format_1` (`id_format1`, `kecamatan`, `kelurahan`, `posyandu`, `tahun_pendataan`, `nama_ibu`, `nama_ayah`, `nama_bayi`, `tgl_lahir`, `tanggal_bayi_meninggal`, `tanggal_ibu_meninggal`, `keterangan`) VALUES
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 'Ani Lestari', 'Budi Santoso', 'Rafa Pratama', '2022-06-14', NULL, NULL, 'Pemantauan tumbuh kembang rutin'),
(2, 'Cimahi Tengah', 'Baros', 'Posyandu Anggrek Lestari', 2024, 'Dewi Anggraeni', 'Rizki Maulana', 'Nadia Safitri', '2022-09-11', NULL, NULL, 'Tidak ada keluhan');

-- --------------------------------------------------------

--
-- Table structure for table `format_2`
--

CREATE TABLE `format_2` (
  `id_format2` int NOT NULL,
  `kecamatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pendataan` int DEFAULT NULL,
  `id_bayi` int DEFAULT NULL,
  `nama_bayi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jk` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lhr` date DEFAULT NULL,
  `bbl` float DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `format_2`
--

INSERT INTO `format_2` (`id_format2`, `kecamatan`, `kelurahan`, `posyandu`, `tahun_pendataan`, `id_bayi`, `nama_bayi`, `jk`, `tgl_lhr`, `bbl`, `ket`) VALUES
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 1, 'Rafa Pratama', 'L', '2022-06-14', 3.2, 'BBL normal'),
(2, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 2, 'Alya Putri', 'P', '2021-12-03', 3.1, 'BBL normal');

-- --------------------------------------------------------

--
-- Table structure for table `format_3`
--

CREATE TABLE `format_3` (
  `id_format3` int NOT NULL,
  `kecamatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pendataan` int DEFAULT NULL,
  `nama_wuspus` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `nama_suami` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahapan_ks` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompok_dasawisma` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_anak_hidup` int DEFAULT NULL,
  `jumlah_anak_meninggal` int DEFAULT NULL,
  `pengukuran_lila` float DEFAULT NULL,
  `kapsul_yodium` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imunisasi_tti` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kontrasepsi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pergantian` date DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `format_3`
--

INSERT INTO `format_3` (`id_format3`, `kecamatan`, `kelurahan`, `posyandu`, `tahun_pendataan`, `nama_wuspus`, `umur`, `nama_suami`, `tahapan_ks`, `kelompok_dasawisma`, `jumlah_anak_hidup`, `jumlah_anak_meninggal`, `pengukuran_lila`, `kapsul_yodium`, `imunisasi_tti`, `jenis_kontrasepsi`, `tgl_pergantian`, `keterangan`) VALUES
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 'Ani Lestari', 27, 'Budi Santoso', 'Tahap KS I', 'Dasawisma Mawar 1', 1, 0, 23.5, 'Ya', 'Lengkap', 'IUD', '2023-01-15', 'Aktif ikut kelas ibu hamil'),
(2, 'Cimahi Tengah', 'Baros', 'Posyandu Anggrek Lestari', 2024, 'Dewi Anggraeni', 25, 'Rizki Maulana', 'Tahap KS I', 'Dasawisma Flamboyan 1', 1, 0, 22.8, 'Tidak', 'Lengkap', 'Implan', '2022-09-20', 'Aktif posyandu');

-- --------------------------------------------------------

--
-- Table structure for table `format_4`
--

CREATE TABLE `format_4` (
  `id_format4` int NOT NULL,
  `kecamatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pendataan` int DEFAULT NULL,
  `nama_ibu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bayi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `kelompok_dasawisma` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `umur_kehamilan` int DEFAULT NULL,
  `lila` float DEFAULT NULL,
  `pmt_pemulihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `format_4`
--

INSERT INTO `format_4` (`id_format4`, `kecamatan`, `kelurahan`, `posyandu`, `tahun_pendataan`, `nama_ibu`, `nama_bayi`, `umur`, `kelompok_dasawisma`, `tanggal_daftar`, `umur_kehamilan`, `lila`, `pmt_pemulihan`, `ket`) VALUES
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 'Ani Lestari', 'Rafa Pratama', 2, 'Dasawisma Mawar 1', '2022-06-15', 20, 23.5, 'PMT tambahan', 'Pemantauan gizi');

-- --------------------------------------------------------

--
-- Table structure for table `format_5`
--

CREATE TABLE `format_5` (
  `id_format5` int NOT NULL,
  `kecamatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pendataan` int DEFAULT NULL,
  `bln` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bayi_l` int DEFAULT NULL,
  `bayi_p` int DEFAULT NULL,
  `balita_l` int DEFAULT NULL,
  `balita_p` int DEFAULT NULL,
  `wus` int DEFAULT NULL,
  `pus` int DEFAULT NULL,
  `ibu_hamil` int DEFAULT NULL,
  `ibu_menyusui` int DEFAULT NULL,
  `pkk` int DEFAULT NULL,
  `plkb` int DEFAULT NULL,
  `medis` int DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `goal_id` int NOT NULL,
  `nama_goal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`goal_id`, `nama_goal`) VALUES
(1, 'Menurunkan prevalensi stunting balita'),
(2, 'Meningkatkan cakupan imunisasi dasar lengkap'),
(3, 'Meningkatkan partisipasi keluarga ke Posyandu');

-- --------------------------------------------------------

--
-- Table structure for table `imunisasi`
--

CREATE TABLE `imunisasi` (
  `id_imun` int NOT NULL,
  `kd_imun` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jns_imun` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imun_untuk` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `imunisasi`
--

INSERT INTO `imunisasi` (`id_imun`, `kd_imun`, `jns_imun`, `imun_untuk`) VALUES
(1, 'HB-0', 'Hepatitis B 0', 'Bayi'),
(2, 'BCG', 'BCG', 'Bayi'),
(3, 'POLIO', 'Polio Tetes', 'Bayi'),
(4, 'DPT-HB-Hib', 'DPT-HB-Hib', 'Bayi'),
(5, 'Campak', 'Campak Rubella', 'Bayi dan Balita');

-- --------------------------------------------------------

--
-- Table structure for table `kcmtn`
--

CREATE TABLE `kcmtn` (
  `id_kec` int NOT NULL,
  `nama_kec` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kcmtn`
--

INSERT INTO `kcmtn` (`id_kec`, `nama_kec`) VALUES
(1, 'Cimahi Utara'),
(2, 'Cimahi Tengah'),
(3, 'Cimahi Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `kdrhdr`
--

CREATE TABLE `kdrhdr` (
  `id_kdrhdr` int NOT NULL,
  `id_posyandu` int DEFAULT NULL,
  `bulan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pkk` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plkb` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kdrhdr`
--

INSERT INTO `kdrhdr` (`id_kdrhdr`, `id_posyandu`, `bulan`, `pkk`, `plkb`, `medis`) VALUES
(1, 1, 'Januari 2025', 'PKK RW 01', 'PLKB Kelurahan Cipageran', 'dr. Lilis'),
(2, 2, 'Januari 2025', 'PKK RW 03', 'PLKB Kelurahan Cibabat', 'dr. Ari'),
(3, 5, 'Januari', '100', 'PLKB Kelurahan Melong', 'dr. Rudi'),
(4, 27, 'Mei', '1', '1', '1'),
(5, 9, 'Mei', '1', '2', '3');

-- --------------------------------------------------------

--
-- Table structure for table `klrhn`
--

CREATE TABLE `klrhn` (
  `id_kel` int NOT NULL,
  `id_kec` int NOT NULL,
  `nama_kel` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klrhn`
--

INSERT INTO `klrhn` (`id_kel`, `id_kec`, `nama_kel`) VALUES
(1, 1, 'Cipageran'),
(2, 1, 'Citereup'),
(3, 1, 'Cibabat'),
(4, 1, 'Pasirkaliki'),
(5, 1, 'Cimahi Utara'),
(6, 2, 'Baros'),
(7, 2, 'Padasuka'),
(8, 2, 'Setiamanah'),
(9, 2, 'Karangmekar'),
(10, 2, 'Cimahi'),
(11, 3, 'Melong'),
(12, 3, 'Leuwigajah'),
(13, 3, 'Cibeber'),
(14, 3, 'Utama'),
(15, 3, 'Cibeureum');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `idmenu` int NOT NULL,
  `menu_uri` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_allowed` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`idmenu`, `menu_uri`, `menu_url`, `menu_allowed`, `parent_id`) VALUES
(1, 'Dashboard', 'dashboard.php', '1,2,3', NULL),
(2, 'Data Master', '#', '1,2', NULL),
(3, 'Data WUS/PUS', 'wuspus.php', '1,2,3', 2),
(4, 'Data Bayi', 'bayi.php', '1,2,3', 2),
(5, 'Laporan', 'laporan.php', '1,2', NULL);

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
(1, '2025_11_25_175025_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kcmtn` int DEFAULT NULL,
  `klrhn` int DEFAULT NULL,
  `id_posyandu` int DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reg_times` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `username`, `password`, `nama`, `alamat`, `kcmtn`, `klrhn`, `id_posyandu`, `email`, `no_hp`, `reg_times`) VALUES
(1, 'superadmin', '$2y$12$W1zKAYVM1O5xjt9XcaOH0.CkVbxxsebooJYyFsy8MisUcSmCif2Zi', 'Super Admin Kota', 'Kantor Dinas Kesehatan Kota Cimahi', 1, 1, NULL, 'superadmin@sip-posyandu.local', '081200000001', '2025-11-22 00:08:09'),
(2, 'admin_melati', '$2y$10$zFeVgkIlxbmtA3Z1Jt9MS.ZdRNWzCAWE5cf0wxZDsTzUfFTElAncy', 'Admin Posyandu Melati', 'Sekretariat Posyandu Melati Indah', 1, 1, 1, 'admin.melati@sip-posyandu.local', '081200000002', '2025-11-22 00:08:09'),
(3, 'admin_flamboyan', '$2y$10$zFeVgkIlxbmtA3Z1Jt9MS.ZdRNWzCAWE5cf0wxZDsTzUfFTElAncy', 'Admin Posyandu Flamboyan', 'Sekretariat Posyandu Flamboyan Asri', 1, 3, 2, 'admin.flamboyan@sip-posyandu.local', '081200000003', '2025-11-22 00:08:09'),
(4, 'kader_kenanga', '$2y$10$zFeVgkIlxbmtA3Z1Jt9MS.ZdRNWzCAWE5cf0wxZDsTzUfFTElAncy', 'Kader Posyandu Kenanga', 'Sekretariat Posyandu Kenanga Harmoni', 3, 11, 5, 'kader.kenanga@sip-posyandu.local', '081200000004', '2025-11-22 00:08:09'),
(7, 'testing1', '$2y$10$zFeVgkIlxbmtA3Z1Jt9MS.ZdRNWzCAWE5cf0wxZDsTzUfFTElAncy', 'testing1', 'testing1', NULL, NULL, NULL, NULL, NULL, '2025-11-25 19:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `operator_log`
--

CREATE TABLE `operator_log` (
  `id_log` int NOT NULL,
  `id_operator` int DEFAULT NULL,
  `aksi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operator_log`
--

INSERT INTO `operator_log` (`id_log`, `id_operator`, `aksi`, `waktu`, `detail`) VALUES
(1, 1, 'Login sistem', '2025-11-22 00:08:09', 'Login sebagai Super Admin'),
(2, 2, 'Input data bayi', '2025-11-22 00:08:09', 'Menambahkan data bayi baru di Posyandu Melati Indah'),
(3, 3, 'Cetak laporan bulanan', '2025-11-22 00:08:09', 'Mencetak laporan format 5 untuk Posyandu Flamboyan Asri');

-- --------------------------------------------------------

--
-- Table structure for table `operator_role_map`
--

CREATE TABLE `operator_role_map` (
  `id_map` int NOT NULL,
  `id_operator` int DEFAULT NULL,
  `lvl_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operator_role_map`
--

INSERT INTO `operator_role_map` (`id_map`, `id_operator`, `lvl_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `oplvl`
--

CREATE TABLE `oplvl` (
  `lvl_id` int NOT NULL,
  `lvl_nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oplvl`
--

INSERT INTO `oplvl` (`lvl_id`, `lvl_nama`) VALUES
(1, 'Super Admin'),
(2, 'Admin Posyandu'),
(3, 'Kader');

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
('At616oGIIkSGhFQIFaCFyT6Cbxvil6K2m55yJto6', 1, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibFlWREhaOEtvSmo3YzhsblA0aEJCcjFLQTdncGNmNWZndVpzM0JrdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1764732069);

-- --------------------------------------------------------

--
-- Table structure for table `stratapsy`
--

CREATE TABLE `stratapsy` (
  `id_strata` int NOT NULL,
  `strata_posyandu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stratapsy`
--

INSERT INTO `stratapsy` (`id_strata`, `strata_posyandu`) VALUES
(1, 'Pratama'),
(2, 'Madya'),
(3, 'Purnama'),
(4, 'Mandiri');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_stunting_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_stunting_summary` (
`id_prediksi` int
,`id_bayi` int
,`nama_bayi` varchar(150)
,`umur_bulan` int
,`berat_badan` decimal(6,2)
,`tinggi_badan` decimal(6,2)
,`tinggi_ibu` decimal(5,2)
,`tinggi_ayah` decimal(5,2)
,`z_score` float
,`status_gizi` enum('Normal','Berisiko Stunting','Stunting')
,`tingkat_risiko` decimal(5,2)
,`tanggal_prediksi` date
);

-- --------------------------------------------------------

--
-- Table structure for table `wuspus`
--

CREATE TABLE `wuspus` (
  `id_wuspus` int NOT NULL,
  `id_posyandu` int DEFAULT NULL,
  `nik_wuspus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_wuspus` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `tinggi_ibu` decimal(5,2) DEFAULT NULL,
  `nama_suami` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tinggi_ayah` decimal(5,2) DEFAULT NULL,
  `thpn_ks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klmpk_dasawisma` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jml_anak_hdp` int DEFAULT '0',
  `jml_anak_meninggal` int DEFAULT '0',
  `tgl_daftar` date DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wuspus`
--

INSERT INTO `wuspus` (`id_wuspus`, `id_posyandu`, `nik_wuspus`, `nama_wuspus`, `umur`, `tinggi_ibu`, `nama_suami`, `tinggi_ayah`, `thpn_ks`, `klmpk_dasawisma`, `jml_anak_hdp`, `jml_anak_meninggal`, `tgl_daftar`, `status`, `ket`) VALUES
(1, 1, '3277000000000001', 'Ani Lestari', 27, 155.50, 'Budi Santoso', 168.00, 'Tahap KS I', 'Dasawisma Mawar 1', 1, 0, '2022-01-10', 'Aktif', 'Ibu rumah tangga'),
(2, 1, '3277000000000002', 'Siti Rohmah', 30, 158.00, 'Andi Saputra', 170.20, 'Tahap KS II', 'Dasawisma Melati 2', 2, 0, '2021-11-20', 'Aktif', ''),
(3, 2, '3277000000000003', 'Dewi Anggraeni', 25, 152.30, 'Rizki Maulana', 169.50, 'Tahap KS I', 'Dasawisma Flamboyan 1', 1, 0, '2023-03-05', 'Aktif', ''),
(4, NULL, '3277000000000004', 'Rina Kurniasih', 32, 160.00, 'Fajar Nugraha', 172.00, 'Tahap KS III', 'Dasawisma Anggrek 3', 3, 1, '2020-06-15', 'Aktif', ''),
(5, 4, '3277000000000005', 'Eka Susilawati', 29, 157.20, 'Yudi Pratama', 169.00, 'Tahap KS II', 'Dasawisma Dahlia 2', 2, 0, '2022-09-01', 'Aktif', ''),
(6, 5, '3277000000000006', 'Lilis Fitriani', 26, 154.80, 'Taufik Hidayat', 171.30, 'Tahap KS I', 'Dasawisma Kenanga 1', 1, 0, '2023-02-18', 'Aktif', ''),
(7, 6, '3277000000000007', 'Yuni Aprilianti', 33, 159.40, 'Agus Purnama', 173.70, 'Tahap KS III', 'Dasawisma Mawar 3', 3, 0, '2019-10-22', 'Aktif', ''),
(8, 7, '3277000000000008', 'Nia Kurnia', 28, 156.70, 'Dedi Kurniawan', 170.90, 'Tahap KS II', 'Dasawisma Cempaka 2', 2, 0, '2021-05-30', 'Aktif', ''),
(9, 8, '3277000000000009', 'Mega Puspitasari', 24, 153.90, 'Yoga Saputra', 168.80, 'Tahap KS I', 'Dasawisma Sakura 1', 1, 0, '2023-07-12', 'Aktif', ''),
(10, 9, '3277000000000010', 'Indah Permata', 31, 158.60, 'Bayu Firmansyah', 174.00, 'Tahap KS II', 'Dasawisma Teratai 2', 2, 0, '2020-12-03', 'Aktif', ''),
(11, 49, '378463784', 'wuspus1tes', 18, 156.00, 'suami1', 175.00, '1', '1', 1, 0, '2000-04-05', 'Menyusui', 'wuspus1tes'),
(12, 27, '346534756437', 'wuspus2tes', 20, 158.00, 'suami2', 178.00, '1', '1', 1, 1, '2000-06-05', 'Hamil', 'wuspus2tes');

-- --------------------------------------------------------

--
-- Table structure for table `wuspus_imun`
--

CREATE TABLE `wuspus_imun` (
  `id_wuspus_imun` int NOT NULL,
  `id_wuspus` int NOT NULL,
  `id_imun` int NOT NULL,
  `tgl_imun` date DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wuspus_imun`
--

INSERT INTO `wuspus_imun` (`id_wuspus_imun`, `id_wuspus`, `id_imun`, `tgl_imun`, `ket`) VALUES
(1, 1, 4, '2023-12-01', 'TT untuk WUS'),
(2, 2, 4, '2024-01-15', 'Booster TT');

-- --------------------------------------------------------

--
-- Table structure for table `wuspus_kontrasepsi`
--

CREATE TABLE `wuspus_kontrasepsi` (
  `id_wkp` int NOT NULL,
  `id_wuspus` int NOT NULL,
  `jns_kontrasepsi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_ganti` date DEFAULT NULL,
  `kontrasepsi_baru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wuspus_kontrasepsi`
--

INSERT INTO `wuspus_kontrasepsi` (`id_wkp`, `id_wuspus`, `jns_kontrasepsi`, `tgl_ganti`, `kontrasepsi_baru`, `ket`) VALUES
(1, 1, 'IUD', '2023-01-15', 'IUD', 'Kontrol rutin setiap 6 bulan'),
(2, 2, 'Suntik 3 Bulan', '2024-02-10', 'Suntik 3 Bulan', ''),
(3, 4, 'Implan', '2022-09-20', 'Implan', 'Keluhan ringan pusing awal pemasangan'),
(4, 7, 'Pil', '2021-05-05', 'Pil Kombinasi', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_chat_history`
--
ALTER TABLE `ai_chat_history`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_operator` (`id_operator`),
  ADD KEY `id_wuspus` (`id_wuspus`);

--
-- Indexes for table `ai_food_recommendation`
--
ALTER TABLE `ai_food_recommendation`
  ADD PRIMARY KEY (`id_rekomendasi`),
  ADD KEY `id_prediksi` (`id_prediksi`);

--
-- Indexes for table `ai_stunting_prediction`
--
ALTER TABLE `ai_stunting_prediction`
  ADD PRIMARY KEY (`id_prediksi`),
  ADD KEY `id_bayi` (`id_bayi`);

--
-- Indexes for table `bayi`
--
ALTER TABLE `bayi`
  ADD PRIMARY KEY (`id_bayi`),
  ADD KEY `idx_bayi_wuspus` (`id_wuspus`);

--
-- Indexes for table `bayi_imun`
--
ALTER TABLE `bayi_imun`
  ADD PRIMARY KEY (`id_bayi_imun`),
  ADD KEY `id_bayi` (`id_bayi`),
  ADD KEY `id_imun` (`id_imun`);

--
-- Indexes for table `bayi_pnb`
--
ALTER TABLE `bayi_pnb`
  ADD PRIMARY KEY (`id_bayi_pnb`),
  ADD KEY `id_bayi` (`id_bayi`);

--
-- Indexes for table `bayi_wafat`
--
ALTER TABLE `bayi_wafat`
  ADD PRIMARY KEY (`id_wafat`),
  ADD KEY `id_bayi` (`id_bayi`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `bumil`
--
ALTER TABLE `bumil`
  ADD PRIMARY KEY (`id_bumil`),
  ADD UNIQUE KEY `id_wuspus` (`id_wuspus`);

--
-- Indexes for table `bumil_imun`
--
ALTER TABLE `bumil_imun`
  ADD PRIMARY KEY (`id_bumil_imun`),
  ADD KEY `id_wuspus` (`id_wuspus`),
  ADD KEY `id_imun` (`id_imun`);

--
-- Indexes for table `bumil_pnb`
--
ALTER TABLE `bumil_pnb`
  ADD PRIMARY KEY (`id_bumil_pnb`),
  ADD KEY `id_wuspus` (`id_wuspus`);

--
-- Indexes for table `data_bayi`
--
ALTER TABLE `data_bayi`
  ADD PRIMARY KEY (`id_data`),
  ADD KEY `id_bayi` (`id_bayi`);

--
-- Indexes for table `duspy`
--
ALTER TABLE `duspy`
  ADD PRIMARY KEY (`id_posyandu`),
  ADD KEY `id_kel` (`id_kel`);

--
-- Indexes for table `format_1`
--
ALTER TABLE `format_1`
  ADD PRIMARY KEY (`id_format1`);

--
-- Indexes for table `format_2`
--
ALTER TABLE `format_2`
  ADD PRIMARY KEY (`id_format2`),
  ADD KEY `id_bayi` (`id_bayi`);

--
-- Indexes for table `format_3`
--
ALTER TABLE `format_3`
  ADD PRIMARY KEY (`id_format3`);

--
-- Indexes for table `format_4`
--
ALTER TABLE `format_4`
  ADD PRIMARY KEY (`id_format4`);

--
-- Indexes for table `format_5`
--
ALTER TABLE `format_5`
  ADD PRIMARY KEY (`id_format5`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`goal_id`);

--
-- Indexes for table `imunisasi`
--
ALTER TABLE `imunisasi`
  ADD PRIMARY KEY (`id_imun`);

--
-- Indexes for table `kcmtn`
--
ALTER TABLE `kcmtn`
  ADD PRIMARY KEY (`id_kec`);

--
-- Indexes for table `kdrhdr`
--
ALTER TABLE `kdrhdr`
  ADD PRIMARY KEY (`id_kdrhdr`),
  ADD KEY `id_posyandu` (`id_posyandu`);

--
-- Indexes for table `klrhn`
--
ALTER TABLE `klrhn`
  ADD PRIMARY KEY (`id_kel`),
  ADD KEY `id_kec` (`id_kec`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id_operator`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `kcmtn` (`kcmtn`),
  ADD KEY `klrhn` (`klrhn`),
  ADD KEY `idx_operator_posyandu` (`id_posyandu`);

--
-- Indexes for table `operator_log`
--
ALTER TABLE `operator_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_operator` (`id_operator`);

--
-- Indexes for table `operator_role_map`
--
ALTER TABLE `operator_role_map`
  ADD PRIMARY KEY (`id_map`),
  ADD KEY `id_operator` (`id_operator`),
  ADD KEY `lvl_id` (`lvl_id`);

--
-- Indexes for table `oplvl`
--
ALTER TABLE `oplvl`
  ADD PRIMARY KEY (`lvl_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stratapsy`
--
ALTER TABLE `stratapsy`
  ADD PRIMARY KEY (`id_strata`);

--
-- Indexes for table `wuspus`
--
ALTER TABLE `wuspus`
  ADD PRIMARY KEY (`id_wuspus`),
  ADD KEY `idx_wuspus_posyandu` (`id_posyandu`);

--
-- Indexes for table `wuspus_imun`
--
ALTER TABLE `wuspus_imun`
  ADD PRIMARY KEY (`id_wuspus_imun`),
  ADD KEY `id_wuspus` (`id_wuspus`),
  ADD KEY `id_imun` (`id_imun`);

--
-- Indexes for table `wuspus_kontrasepsi`
--
ALTER TABLE `wuspus_kontrasepsi`
  ADD PRIMARY KEY (`id_wkp`),
  ADD KEY `id_wuspus` (`id_wuspus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_chat_history`
--
ALTER TABLE `ai_chat_history`
  MODIFY `id_chat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ai_food_recommendation`
--
ALTER TABLE `ai_food_recommendation`
  MODIFY `id_rekomendasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ai_stunting_prediction`
--
ALTER TABLE `ai_stunting_prediction`
  MODIFY `id_prediksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bayi`
--
ALTER TABLE `bayi`
  MODIFY `id_bayi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bayi_imun`
--
ALTER TABLE `bayi_imun`
  MODIFY `id_bayi_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bayi_pnb`
--
ALTER TABLE `bayi_pnb`
  MODIFY `id_bayi_pnb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bayi_wafat`
--
ALTER TABLE `bayi_wafat`
  MODIFY `id_wafat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bumil`
--
ALTER TABLE `bumil`
  MODIFY `id_bumil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bumil_imun`
--
ALTER TABLE `bumil_imun`
  MODIFY `id_bumil_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bumil_pnb`
--
ALTER TABLE `bumil_pnb`
  MODIFY `id_bumil_pnb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_bayi`
--
ALTER TABLE `data_bayi`
  MODIFY `id_data` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `duspy`
--
ALTER TABLE `duspy`
  MODIFY `id_posyandu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `format_1`
--
ALTER TABLE `format_1`
  MODIFY `id_format1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `format_2`
--
ALTER TABLE `format_2`
  MODIFY `id_format2` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `format_3`
--
ALTER TABLE `format_3`
  MODIFY `id_format3` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `format_4`
--
ALTER TABLE `format_4`
  MODIFY `id_format4` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `format_5`
--
ALTER TABLE `format_5`
  MODIFY `id_format5` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `goal_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `imunisasi`
--
ALTER TABLE `imunisasi`
  MODIFY `id_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kcmtn`
--
ALTER TABLE `kcmtn`
  MODIFY `id_kec` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kdrhdr`
--
ALTER TABLE `kdrhdr`
  MODIFY `id_kdrhdr` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `klrhn`
--
ALTER TABLE `klrhn`
  MODIFY `id_kel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id_operator` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `operator_log`
--
ALTER TABLE `operator_log`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `operator_role_map`
--
ALTER TABLE `operator_role_map`
  MODIFY `id_map` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oplvl`
--
ALTER TABLE `oplvl`
  MODIFY `lvl_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stratapsy`
--
ALTER TABLE `stratapsy`
  MODIFY `id_strata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wuspus`
--
ALTER TABLE `wuspus`
  MODIFY `id_wuspus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wuspus_imun`
--
ALTER TABLE `wuspus_imun`
  MODIFY `id_wuspus_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wuspus_kontrasepsi`
--
ALTER TABLE `wuspus_kontrasepsi`
  MODIFY `id_wkp` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- --------------------------------------------------------

--
-- Structure for view `vw_stunting_summary`
--
DROP TABLE IF EXISTS `vw_stunting_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_stunting_summary`  AS SELECT `p`.`id_prediksi` AS `id_prediksi`, `b`.`id_bayi` AS `id_bayi`, `b`.`nama_bayi` AS `nama_bayi`, `p`.`umur_bulan` AS `umur_bulan`, `p`.`berat_badan` AS `berat_badan`, `p`.`tinggi_badan` AS `tinggi_badan`, `p`.`tinggi_ibu` AS `tinggi_ibu`, `p`.`tinggi_ayah` AS `tinggi_ayah`, `p`.`z_score` AS `z_score`, `p`.`status_gizi` AS `status_gizi`, `p`.`tingkat_risiko` AS `tingkat_risiko`, `p`.`tanggal_prediksi` AS `tanggal_prediksi` FROM (`ai_stunting_prediction` `p` left join `bayi` `b` on((`p`.`id_bayi` = `b`.`id_bayi`))) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_chat_history`
--
ALTER TABLE `ai_chat_history`
  ADD CONSTRAINT `ai_chat_history_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`) ON DELETE SET NULL,
  ADD CONSTRAINT `ai_chat_history_ibfk_2` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE SET NULL;

--
-- Constraints for table `ai_food_recommendation`
--
ALTER TABLE `ai_food_recommendation`
  ADD CONSTRAINT `ai_food_recommendation_ibfk_1` FOREIGN KEY (`id_prediksi`) REFERENCES `ai_stunting_prediction` (`id_prediksi`) ON DELETE CASCADE;

--
-- Constraints for table `ai_stunting_prediction`
--
ALTER TABLE `ai_stunting_prediction`
  ADD CONSTRAINT `ai_stunting_prediction_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE CASCADE;

--
-- Constraints for table `bayi`
--
ALTER TABLE `bayi`
  ADD CONSTRAINT `bayi_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE SET NULL;

--
-- Constraints for table `bayi_imun`
--
ALTER TABLE `bayi_imun`
  ADD CONSTRAINT `bayi_imun_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE CASCADE,
  ADD CONSTRAINT `bayi_imun_ibfk_2` FOREIGN KEY (`id_imun`) REFERENCES `imunisasi` (`id_imun`) ON DELETE RESTRICT;

--
-- Constraints for table `bayi_pnb`
--
ALTER TABLE `bayi_pnb`
  ADD CONSTRAINT `bayi_pnb_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE CASCADE;

--
-- Constraints for table `bayi_wafat`
--
ALTER TABLE `bayi_wafat`
  ADD CONSTRAINT `bayi_wafat_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE CASCADE;

--
-- Constraints for table `bumil`
--
ALTER TABLE `bumil`
  ADD CONSTRAINT `bumil_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE CASCADE;

--
-- Constraints for table `bumil_imun`
--
ALTER TABLE `bumil_imun`
  ADD CONSTRAINT `bumil_imun_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE CASCADE,
  ADD CONSTRAINT `bumil_imun_ibfk_2` FOREIGN KEY (`id_imun`) REFERENCES `imunisasi` (`id_imun`) ON DELETE RESTRICT;

--
-- Constraints for table `bumil_pnb`
--
ALTER TABLE `bumil_pnb`
  ADD CONSTRAINT `bumil_pnb_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE CASCADE;

--
-- Constraints for table `data_bayi`
--
ALTER TABLE `data_bayi`
  ADD CONSTRAINT `data_bayi_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE SET NULL;

--
-- Constraints for table `duspy`
--
ALTER TABLE `duspy`
  ADD CONSTRAINT `duspy_ibfk_1` FOREIGN KEY (`id_kel`) REFERENCES `klrhn` (`id_kel`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `format_2`
--
ALTER TABLE `format_2`
  ADD CONSTRAINT `format_2_ibfk_1` FOREIGN KEY (`id_bayi`) REFERENCES `bayi` (`id_bayi`) ON DELETE SET NULL;

--
-- Constraints for table `kdrhdr`
--
ALTER TABLE `kdrhdr`
  ADD CONSTRAINT `kdrhdr_ibfk_1` FOREIGN KEY (`id_posyandu`) REFERENCES `duspy` (`id_posyandu`) ON DELETE SET NULL;

--
-- Constraints for table `klrhn`
--
ALTER TABLE `klrhn`
  ADD CONSTRAINT `klrhn_ibfk_1` FOREIGN KEY (`id_kec`) REFERENCES `kcmtn` (`id_kec`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `operator`
--
ALTER TABLE `operator`
  ADD CONSTRAINT `operator_ibfk_1` FOREIGN KEY (`kcmtn`) REFERENCES `kcmtn` (`id_kec`) ON DELETE SET NULL,
  ADD CONSTRAINT `operator_ibfk_2` FOREIGN KEY (`klrhn`) REFERENCES `klrhn` (`id_kel`) ON DELETE SET NULL,
  ADD CONSTRAINT `operator_ibfk_3` FOREIGN KEY (`id_posyandu`) REFERENCES `duspy` (`id_posyandu`) ON DELETE SET NULL;

--
-- Constraints for table `operator_log`
--
ALTER TABLE `operator_log`
  ADD CONSTRAINT `operator_log_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`) ON DELETE SET NULL;

--
-- Constraints for table `operator_role_map`
--
ALTER TABLE `operator_role_map`
  ADD CONSTRAINT `operator_role_map_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`) ON DELETE CASCADE,
  ADD CONSTRAINT `operator_role_map_ibfk_2` FOREIGN KEY (`lvl_id`) REFERENCES `oplvl` (`lvl_id`) ON DELETE CASCADE;

--
-- Constraints for table `wuspus`
--
ALTER TABLE `wuspus`
  ADD CONSTRAINT `wuspus_ibfk_1` FOREIGN KEY (`id_posyandu`) REFERENCES `duspy` (`id_posyandu`) ON DELETE SET NULL;

--
-- Constraints for table `wuspus_imun`
--
ALTER TABLE `wuspus_imun`
  ADD CONSTRAINT `wuspus_imun_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE CASCADE,
  ADD CONSTRAINT `wuspus_imun_ibfk_2` FOREIGN KEY (`id_imun`) REFERENCES `imunisasi` (`id_imun`) ON DELETE RESTRICT;

--
-- Constraints for table `wuspus_kontrasepsi`
--
ALTER TABLE `wuspus_kontrasepsi`
  ADD CONSTRAINT `wuspus_kontrasepsi_ibfk_1` FOREIGN KEY (`id_wuspus`) REFERENCES `wuspus` (`id_wuspus`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
