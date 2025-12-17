-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: sip-mysql
-- Generation Time: Dec 17, 2025 at 05:02 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

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
-- Table structure for table `ai_analisis_stunting`
--

CREATE TABLE `ai_analisis_stunting` (
  `id_analisis` bigint NOT NULL,
  `id_bayi` bigint NOT NULL,
  `umur_bulan` int DEFAULT NULL,
  `berat_badan` decimal(6,2) DEFAULT NULL,
  `tinggi_badan` decimal(6,2) DEFAULT NULL,
  `jenis_kelamin` varchar(2) DEFAULT NULL,
  `z_score` decimal(6,3) DEFAULT NULL,
  `status_gizi` varchar(50) DEFAULT NULL,
  `tingkat_risiko` decimal(6,2) DEFAULT NULL,
  `id_klaster` int DEFAULT NULL,
  `ringkasan` varchar(255) DEFAULT NULL,
  `faktor_utama` json DEFAULT NULL,
  `faktor_pendukung` json DEFAULT NULL,
  `rekomendasi_prioritas` json DEFAULT NULL,
  `confidence` decimal(5,2) DEFAULT NULL,
  `tanggal_analisis` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_rekomendasi_makanan`
--

CREATE TABLE `ai_rekomendasi_makanan` (
  `id_rekomendasi` bigint NOT NULL,
  `id_analisis` bigint NOT NULL,
  `jenis_makanan` varchar(50) NOT NULL,
  `nama_makanan` varchar(120) NOT NULL,
  `porsi_harian` varchar(80) DEFAULT NULL,
  `kandungan_gizi` varchar(180) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 1, 'Rafa Pratama', 'P', '2022-06-14', 3.20, 49.00, 82.00, '2022-06-15', NULL),
(2, 2, 'Alya Putri', 'P', '2021-12-03', 3.10, 48.50, 80.50, '2021-12-04', ''),
(3, 3, 'Farel Nugraha', 'L', '2023-01-20', 2.40, 47.00, 74.00, '2023-01-21', 'BB sedikit di bawah normal'),
(4, 4, 'Nadia Safitri', 'P', '2022-09-11', 2.50, 46.50, 78.20, '2022-09-12', 'Dipantau pertumbuhan'),
(5, 5, 'Alvin Ramadhan', 'L', '2021-03-05', 2.10, 45.00, 86.00, '2021-03-06', 'Tinggi badan rendah untuk umur'),
(6, 6, 'Keisha Lestari', 'P', '2023-04-18', 2.00, 44.50, 70.00, '2023-04-19', 'Diduga stunting'),
(7, 7, 'Zidan Hakim', 'L', '2020-11-23', 2.30, 45.50, 90.00, '2020-11-24', 'Riwayat gizi kurang'),
(8, 8, 'Kayla Syifa', 'P', '2019-08-30', 2.20, 44.00, 95.00, '2019-08-31', 'Perlu intervensi gizi'),
(9, 5, 'bayitesting', 'L', '2025-09-10', 1.20, 40.00, 50.00, '2025-12-02', NULL),
(10, 7, 'Testing Bayinya', 'L', '2025-10-23', 799.00, NULL, NULL, '2025-11-13', NULL);

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
(1, 1, 1, '2022-06-14', 'HB-0 lahir'),
(2, 1, 2, '2022-07-14', 'BCG lengkap'),
(3, 1, 3, '2022-07-14', 'Polio 1'),
(4, 2, 1, '2021-12-03', 'HB-0 lahir'),
(5, 2, 2, '2022-01-03', 'BCG'),
(6, 3, 1, '2023-01-20', 'HB-0 lahir'),
(7, 4, 1, '2022-09-11', 'HB-0'),
(8, 5, 1, '2021-03-05', 'HB-0'),
(9, 6, 1, '2023-04-18', 'HB-0'),
(10, 7, 1, '2020-11-23', 'HB-0'),
(11, 8, 1, '2019-08-30', 'HB-0');

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
(1, 1, '2024-06-01', 11.00, 82.00, 'Normal', 'Biskuit balita', ''),
(2, 2, '2024-06-01', 10.50, 80.50, 'Normal', 'Susu tambahan', ''),
(3, 3, '2024-06-01', 8.20, 74.00, 'Berisiko stunting', 'PMT pemulihan', 'Dipantau tiap bulan'),
(4, 4, '2024-06-01', 8.00, 78.20, 'Berisiko stunting', 'PMT pemulihan', ''),
(5, 5, '2024-06-01', 7.40, 86.00, 'Stunting', 'PMT tinggi energi protein', ''),
(6, 6, '2024-06-01', 7.10, 70.00, 'Stunting', 'PMT dan rujukan', ''),
(7, 7, '2024-06-01', 7.30, 90.00, 'Stunting', 'PMT dan rujukan', ''),
(8, 8, '2024-06-01', 7.20, 95.00, 'Stunting', 'PMT dan rujukan', '');

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
(1, 1, '2024-02-10', 16, 1, 'PMT ibu hamil', 23.5, ''),
(2, 3, '2024-03-05', 3, 2, 'PMT tambahan', 22.8, NULL),
(3, 6, '2023-11-12', 9, 3, 'Tidak', 21.9, 'Perlu pemantauan gizi'),
(7, 4, '2025-12-05', 1, 1, '1', 1, '1');

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
(1, 4, 4, '2025-12-11', NULL);

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
(1, 1, '4 bulan', '2024-03-10', 55.00, 'Normal', ''),
(3, 6, '6 bulan', '2023-12-12', 48.00, 'Kurang', 'Disarankan tambahan gizi'),
(5, 7, '3', '2025-12-23', 41.00, 'asdasd', 'asdasd'),
(6, 7, 'asfasf', '2025-12-03', 34.00, '44werwq', 'qweqwe');

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
(5, 'Posyandu Kenanga Harmoni', 'Madya', 'Jl. Kenanga No. 8, Melong', 10, 'Yayu Pertiwi', 'Dewi Sartika', 'Novi Kurnia', 'Irma Rosdiana', 1, 1, 1, 8, 1, 'Petugas KB 5', 'Petugas Medis 5', 'Bidan 5'),
(6, 'Posyandu Mawar Sentosa', 'Pratama', 'Jl. Mawar No. 14, Leuwigajah', 11, 'Ana Pratiwi', 'Rika Amelia', 'Lia Mulyani', 'Dewi Ayu', 1, 1, 1, 8, 1, 'Petugas KB 6', 'Petugas Medis 6', 'Bidan 6'),
(7, 'Posyandu Cempaka Husada', 'Purnama', 'Jl. Cempaka No. 9, Cibeber', 12, 'Hana Lestari', 'Tata Sari', 'Dina Agustin', 'Rani Febriani', 1, 1, 1, 22, 1, 'Petugas KB 7', 'Petugas Medis 7', 'Bidan 7'),
(8, 'Posyandu Sakura Ceria', 'Madya', 'Jl. Sakura No. 2, Utama', 13, 'Rosa Amelia', 'Yani Rahayu', 'Euis Komariah', 'Sari Purnama', 1, 1, 1, 8, 1, 'Petugas KB 8', 'Petugas Medis 8', 'Bidan 8'),
(11, 'initescibeber1', 'Pratama', 'initescibeber1', 12, 'initescibeber1', 'initescibeber1', 'initescibeber1', 'initescibeber1', 1, 1, 0, 4, 4, '4', 'initescibeber1', 'initescibeber1'),
(12, 'initescibeber2', 'Madya', 'initescibeber2', 12, 'initescibeber2', 'initescibeber2', 'initescibeber2', 'initescibeber2', 1, 0, 0, 4, 4, '4', 'initescibeber2', 'initescibeber2'),
(13, 'Leuwigajahtes-1', 'Pratama', 'Leuwigajahtes-1', 11, 'Leuwigajahtes-1', 'Leuwigajahtes-1', 'Leuwigajahtes-1', 'Leuwigajahtes-1', 1, 0, 0, 4, 3, '1', 'Leuwigajahtes-1', 'Leuwigajahtes-1'),
(14, 'Leuwigajahtes-2', 'Purnama', 'Leuwigajahtes-2', 11, 'Leuwigajahtes-2', 'Leuwigajahtes-2', 'Leuwigajahtes-2', 'Leuwigajahtes-2', 0, 0, 0, 5, 6, '5', 'Leuwigajahtes-2', 'Leuwigajahtes-2'),
(15, 'Padasukates-1', 'Mandiri', 'Padasukates-1', 7, 'Padasukates-1', 'Padasukates-1', 'Padasukates-1', 'Padasukates-1', 0, 0, 0, 0, 0, '0', 'Padasukates-1', 'Padasukates-1'),
(16, 'Pasirkalikitesting-1', 'Pratama', 'Pasirkalikitesting-1', 4, 'Pasirkalikitesting-1', 'Pasirkalikitesting-1', 'Pasirkalikitesting-1', 'Pasirkalikitesting-1', 1, 0, 0, 4, 0, '1', 'Pasirkalikitesting-1', 'Pasirkalikitesting-1'),
(17, 'Pasirkalikitesting-2', 'Madya', 'Pasirkalikitesting-2', 4, 'Pasirkalikitesting-2', 'Pasirkalikitesting-2', 'Pasirkalikitesting-2', 'Pasirkalikitesting-2', 1, 0, 1, 8, 8, '8', 'Pasirkalikitesting-2', 'Pasirkalikitesting-2'),
(18, 'cobatesting1ajanih', 'Pratama', 'cobatesting1ajanih', 12, 'cobatesting1ajanih', 'cobatesting1ajanih', 'cobatesting1ajanih', 'cobatesting1ajanih', 1, 1, 0, 3, 2, '1', 'cobatesting1ajanih', 'cobatesting1ajanih'),
(19, 'Karangmekartes1', 'Madya', 'Karangmekartes1', 9, 'Karangmekartes1', 'Karangmekartes1', 'Karangmekartes1', 'Karangmekartes1', 1, 1, 1, 5, 5, '1', 'Karangmekartes1', 'Karangmekartes1'),
(20, 'Karangmekartes2', 'Mandiri', 'Karangmekartes2', 9, 'Karangmekartes2', 'Karangmekartes2', 'Karangmekartes2', 'Karangmekartes2', 0, 0, 1, 6, 6, 'Karangmekartes2', 'Karangmekartes2', 'Karangmekartes2'),
(21, 'Padasukates11', 'Pratama', 'Padasukates11', 7, 'Padasukates11', 'Padasukates11', 'Padasukates11', 'Padasukates11', 1, 1, 0, 1, 1, NULL, NULL, NULL),
(24, 'cimahitestingke2', 'Purnama', 'cimahitestingke2', 5, 'cimahitestingke2', 'cimahitestingke2', 'cimahitestingke2', 'cimahitestingke2', 1, 1, 0, 4, 4, 'cimahitestingke2', 'cimahitestingke2', 'cimahitestingke2'),
(25, 'teskelurahanut1', 'Madya', 'teskelurahanut1', 13, 'teskelurahanut1', 'teskelurahanut1', 'teskelurahanut1', 'teskelurahanut1', 1, 1, 1, 1, 1, '1', 'teskelurahanut1', 'teskelurahanut1');

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
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 'Ani Lestari', 'Budi Santoso', 'Rafa Pratama', '2022-06-14', NULL, NULL, 'Pemantauan tumbuh kembang rutin');

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
(1, 'Cimahi Utara', 'Cipageran', 'Posyandu Melati Indah', 2024, 'Ani Lestari', 27, 'Budi Santoso', 'Tahap KS I', 'Dasawisma Mawar 1', 1, 0, 23.5, 'Ya', 'Lengkap', 'IUD', '2023-01-15', 'Aktif ikut kelas ibu hamil');

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
  `bulan/tahun` date DEFAULT NULL,
  `pkk` int DEFAULT NULL,
  `plkb` int DEFAULT NULL,
  `medis` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kdrhdr`
--

INSERT INTO `kdrhdr` (`id_kdrhdr`, `id_posyandu`, `bulan/tahun`, `pkk`, `plkb`, `medis`) VALUES
(1, 12, '2025-12-02', 4, 4, 4),
(4, 19, '2025-04-01', 1, 1, 1),
(5, 20, '2025-04-01', 0, 4, 4);

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
(5, 2, 'Cimahi'),
(6, 2, 'Baros'),
(7, 2, 'Padasuka'),
(8, 2, 'Setiamanah'),
(9, 2, 'Karangmekar'),
(10, 3, 'Melong'),
(11, 3, 'Leuwigajah'),
(12, 3, 'Cibeber'),
(13, 3, 'Utama'),
(14, 3, 'Cibeureum');

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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `role` enum('superadmin','admin','kader') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kader',
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

INSERT INTO `operator` (`id_operator`, `username`, `role`, `password`, `nama`, `alamat`, `kcmtn`, `klrhn`, `id_posyandu`, `email`, `no_hp`, `reg_times`) VALUES
(1, 'superadmin', 'superadmin', '$2y$12$W1zKAYVM1O5xjt9XcaOH0.CkVbxxsebooJYyFsy8MisUcSmCif2Zi', 'Super Admin eSIP', 'Kantor Dinas Kesehatan Kota Cimahi', 1, 1, NULL, 'superadmin@sip-posyandu.local', '081200000001', '2025-11-22 00:08:09'),
(2, 'admin_melati', 'admin', '$2y$12$HpQWr1BEzVilD88p98VVvOl8dsWgHIhftQPAffmgE6efbXSlWLpE.', 'Admin Posyandu Melati', 'Sekretariat Posyandu Melati Indah', 1, 1, 1, 'admin.melati@sip-posyandu.local', '081200000002', '2025-11-22 00:08:09'),
(3, 'admin_flamboyan', 'admin', 'ac250e4a00ff3144ae7689f0d23e8b26d06aa929', 'Admin Posyandu Flamboyan', 'Sekretariat Posyandu Flamboyan Asri', 1, 3, 2, 'admin.flamboyan@sip-posyandu.local', '081200000003', '2025-11-22 00:08:09'),
(4, 'kader_kenanga', 'kader', '$2y$10$zFeVgkIlxbmtA3Z1Jt9MS.ZdRNWzCAWE5cf0wxZDsTzUfFTElAncy', 'Kader Posyandu Kenanga', 'Sekretariat Posyandu Kenanga Harmoni', 3, 10, 5, 'kader.kenanga@sip-posyandu.local', '081200000004', '2025-11-22 00:08:09'),
(5, 'kadertesting', 'kader', '$2y$12$hOXF/6j04G.tt8FULBjQGu/dfGdmxYW4SYUt/TNn1Cm/oZ/BNDj0K', 'Testing Kader', 'asd', 3, 2, 6, NULL, NULL, '2025-12-14 07:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, '320111000001', 'asd Lestari', 27, 152.00, 'Budi Santoso', 167.00, 'KS1', 'Mawar 1', 1, 0, '2023-01-10', 'Aktif', NULL),
(2, 1, '320111000002', 'Rina Kurniasih', 30, 150.00, 'Fajar Nugraha', 170.00, 'KS1', 'Mawar 2', 2, 0, '2022-11-05', 'Aktif', ''),
(3, 2, '320111000003', 'Dewi Anggraeni', 25, 155.00, 'Rizki Maulana', 172.00, 'KS2', 'Flamboyan 1', 1, 0, '2023-03-12', 'Aktif', ''),
(4, 4, '320111000004', 'Eka Susilawati', 29, 153.00, 'Yudi Pratama', 173.00, 'KS2', 'Dahlia 1', 1, 0, '2022-09-21', 'Aktif', ''),
(5, 5, '320111000005', 'Lilis Fitriani', 28, 150.00, 'Taufik Hidayat', 168.00, 'KS1', 'Kenanga 1', 1, 0, '2023-02-02', 'Aktif', ''),
(6, 6, '320111000006', 'Yuni Aprilianti', 32, 149.00, 'Agus Purnama', 170.00, 'KS3', 'Mawar 3', 2, 0, '2021-10-18', 'Aktif', ''),
(7, 7, '320111000007', 'Nia Kurnia', 31, 151.00, 'Dedi Kurniawan', 174.00, 'KS2', 'Cempaka 1', 2, 0, '2020-08-25', 'Aktif', ''),
(8, 8, '320111000008', 'Mega Puspitasari', 29, 154.00, 'Yoga Saputra', 176.00, 'KS2', 'Sakura 1', 1, 0, '2022-03-07', 'Aktif', '');

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
(1, 1, 1, '2025-12-30', NULL),
(3, 4, 3, '2025-12-01', NULL);

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
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_analisis_stunting`
--
ALTER TABLE `ai_analisis_stunting`
  ADD PRIMARY KEY (`id_analisis`),
  ADD UNIQUE KEY `uq_ai_analisis_id_bayi` (`id_bayi`),
  ADD KEY `idx_ai_analisis_status` (`status_gizi`),
  ADD KEY `idx_ai_analisis_klaster` (`id_klaster`),
  ADD KEY `idx_ai_analisis_tanggal` (`tanggal_analisis`);

--
-- Indexes for table `ai_rekomendasi_makanan`
--
ALTER TABLE `ai_rekomendasi_makanan`
  ADD PRIMARY KEY (`id_rekomendasi`),
  ADD KEY `idx_ai_rek_id_analisis` (`id_analisis`);

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
-- AUTO_INCREMENT for table `ai_analisis_stunting`
--
ALTER TABLE `ai_analisis_stunting`
  MODIFY `id_analisis` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_rekomendasi_makanan`
--
ALTER TABLE `ai_rekomendasi_makanan`
  MODIFY `id_rekomendasi` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bayi`
--
ALTER TABLE `bayi`
  MODIFY `id_bayi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bayi_imun`
--
ALTER TABLE `bayi_imun`
  MODIFY `id_bayi_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bayi_pnb`
--
ALTER TABLE `bayi_pnb`
  MODIFY `id_bayi_pnb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bayi_wafat`
--
ALTER TABLE `bayi_wafat`
  MODIFY `id_wafat` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bumil`
--
ALTER TABLE `bumil`
  MODIFY `id_bumil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bumil_imun`
--
ALTER TABLE `bumil_imun`
  MODIFY `id_bumil_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bumil_pnb`
--
ALTER TABLE `bumil_pnb`
  MODIFY `id_bumil_pnb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_bayi`
--
ALTER TABLE `data_bayi`
  MODIFY `id_data` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `duspy`
--
ALTER TABLE `duspy`
  MODIFY `id_posyandu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `format_1`
--
ALTER TABLE `format_1`
  MODIFY `id_format1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `format_2`
--
ALTER TABLE `format_2`
  MODIFY `id_format2` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `format_3`
--
ALTER TABLE `format_3`
  MODIFY `id_format3` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_kel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id_operator` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stratapsy`
--
ALTER TABLE `stratapsy`
  MODIFY `id_strata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wuspus`
--
ALTER TABLE `wuspus`
  MODIFY `id_wuspus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wuspus_imun`
--
ALTER TABLE `wuspus_imun`
  MODIFY `id_wuspus_imun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wuspus_kontrasepsi`
--
ALTER TABLE `wuspus_kontrasepsi`
  MODIFY `id_wkp` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_rekomendasi_makanan`
--
ALTER TABLE `ai_rekomendasi_makanan`
  ADD CONSTRAINT `fk_ai_rek_analisis` FOREIGN KEY (`id_analisis`) REFERENCES `ai_analisis_stunting` (`id_analisis`) ON DELETE CASCADE;

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
