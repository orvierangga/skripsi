-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2017 at 12:43 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_belanja`
--

CREATE TABLE `tb_belanja` (
  `id_belanja` int(10) NOT NULL,
  `kode_belanja` varchar(20) NOT NULL,
  `uraian` text NOT NULL,
  `volume` int(10) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga_satuan` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_belanja`
--

INSERT INTO `tb_belanja` (`id_belanja`, `kode_belanja`, `uraian`, `volume`, `satuan`, `harga_satuan`) VALUES
(8, '01', 'Perjalanan menuju tempat fotocopy', 5, 'bensin', 73000),
(12, '01', 'Kertas Mirage A4', 5, 'rim', 34000),
(24, '01', 'Pembelian sapu', 10, 'buah', 15000),
(25, '01', 'Penggajian Jasa tukang sapu', 12, 'bulan', 500000),
(31, '02', 'Pembelian kemoceng', 5, 'buah', 5000),
(32, '01', 'Pembelian snack pagi non PNS', 30, 'hari', 50000),
(33, '01', 'Penggajian non PNS', 10, 'orang', 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kegiatan`
--

CREATE TABLE `tb_kegiatan` (
  `id_kegiatan` int(10) NOT NULL,
  `no_kegiatan` varchar(5) NOT NULL,
  `nama_kegiatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kegiatan`
--

INSERT INTO `tb_kegiatan` (`id_kegiatan`, `no_kegiatan`, `nama_kegiatan`) VALUES
(1, '01', 'Penyediaan Jasa Surat Menyurat'),
(2, '02', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik'),
(3, '08', 'Penyediaan Jasa Kebersihan Kantor'),
(4, '10', 'Penyediaan Alat Tulis Kantor'),
(5, '11', 'Penyediaan Barang Cetakan dan Penggandaan'),
(6, '13', 'Penyediaan Peralatan dan Perlengkapan Kantor'),
(7, '15', 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan'),
(8, '17', 'Penyediaan Makanan dan Minuman'),
(9, '18', 'Rapat-rapat Koordinasi dan Konsultasi Ke Luar Daerah'),
(10, '19', 'Penyediaan Jasa Non PNS'),
(11, '03', 'Penyediaan Jasa Peralatan dan Perlengkapan Kantor'),
(12, '04', 'Penyediaan Jasa Jaminan Pemeliharaan Kesehatan PNS'),
(13, '05', 'Penyediaan Jasa Jaminan Barang Milik Daerah'),
(14, '06', 'Penyediaan Jasa Pemiliharaan dan Perizinan Kendaraan Dinas'),
(15, '07', 'Penyediaan Jasa Administrasi Keuangan'),
(16, '09', 'Penyediaan Jasa Perbaikan Peralatan Kerja'),
(17, '12', 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor'),
(18, '14', 'Penyediaan Peralatan Rumah Tangga'),
(19, '16', 'Penyediaan Bahan Logistik Kantor'),
(20, '07', 'Pengadaan Perlengkapan Gedung Kantor'),
(21, '09', 'Pengadaan Peralatan Gedung Kantor'),
(22, '22', 'Pemeliharaan Rutin/Berkala Gedung Kantor'),
(23, '23', 'Pemeliharaan Rutin/Berkala Mobil Jabatan'),
(24, '24', 'Pemeliharaan Rutin/Berkala Kendaraan Dinas/Operasional'),
(25, '26', 'Pemeliharaan Rutin/Berkala Perlengkapan Gedung Kantor'),
(26, '28', 'Pemeliharaan Rutin/Berkala Peralatan Gedung Kantor'),
(27, '29', 'Pemeliharaan Rutin/Berkala Mebeleur'),
(28, '01', 'Pembangunan Rumah Jabatan'),
(29, '02', 'Pembangunan Rumah Dinas'),
(30, '03', 'Pembangunan Gedung Kantor'),
(31, '04', 'Pengadaan Mobil Jabatan'),
(32, '05', 'Pengadaan Kendaraan Dinas/Operasional'),
(33, '06', 'Pengadaan Perlengkapan Rumah Jabatan/Dinas'),
(34, '08', 'Pengadaan Peralatan Rumah Jabatan/Dinas'),
(35, '10', 'Pengadaan Mebelur');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ket_belanja`
--

CREATE TABLE `tb_ket_belanja` (
  `id_ket` int(2) NOT NULL,
  `nama_belanja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ket_belanja`
--

INSERT INTO `tb_ket_belanja` (`id_ket`, `nama_belanja`) VALUES
(1, 'Belanja Langsung'),
(2, 'Belanja Tidak Langsung');

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan_belanja`
--

CREATE TABLE `tb_laporan_belanja` (
  `id_laporan` int(10) NOT NULL,
  `id_belanja` int(20) NOT NULL,
  `id_ket` int(2) NOT NULL,
  `id_programkegiatan` int(5) NOT NULL,
  `nomor_skpd` varchar(15) NOT NULL,
  `no_tahun` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_laporan_belanja`
--

INSERT INTO `tb_laporan_belanja` (`id_laporan`, `id_belanja`, `id_ket`, `id_programkegiatan`, `nomor_skpd`, `no_tahun`) VALUES
(8, 8, 2, 1, '1.01.01', 1),
(12, 12, 1, 1, '1.01.01', 1),
(24, 24, 1, 3, '1.01.01', 1),
(25, 25, 2, 3, '1.01.01', 1),
(31, 31, 1, 3, '1.01.01', 1),
(32, 32, 1, 10, '1.01.01', 1),
(33, 33, 2, 10, '1.01.01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan_programkegiatan`
--

CREATE TABLE `tb_laporan_programkegiatan` (
  `no_tabel` int(5) NOT NULL,
  `id_programkegiatan` int(5) NOT NULL,
  `no_target` int(10) NOT NULL,
  `no_tahun` int(5) NOT NULL,
  `nomor_skpd` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_laporan_programkegiatan`
--

INSERT INTO `tb_laporan_programkegiatan` (`no_tabel`, `id_programkegiatan`, `no_target`, `no_tahun`, `nomor_skpd`) VALUES
(4, 1, 4, 1, '1.01.01'),
(6, 10, 6, 1, '1.01.01'),
(8, 3, 8, 1, '1.01.01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `no_log` int(11) NOT NULL,
  `nomor_skpd` varchar(20) NOT NULL,
  `browser` text NOT NULL,
  `aktifitas` text NOT NULL,
  `waktu` varchar(20) NOT NULL,
  `ip_addres` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_log`
--

INSERT INTO `tb_log` (`no_log`, `nomor_skpd`, `browser`, `aktifitas`, `waktu`, `ip_addres`) VALUES
(1, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445612637', '127.0.0.1'),
(2, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445612786', '127.0.0.1'),
(3, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445613023', '127.0.0.1'),
(4, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615047', '127.0.0.1'),
(5, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615061', '127.0.0.1'),
(6, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615075', '127.0.0.1'),
(7, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615093', '127.0.0.1'),
(8, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615108', '127.0.0.1'),
(9, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615117', '127.0.0.1'),
(10, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615124', '127.0.0.1'),
(11, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615136', '127.0.0.1'),
(12, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445615143', '127.0.0.1'),
(13, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445992418', '127.0.0.1'),
(14, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1445993008', '127.0.0.1'),
(15, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446016858', '127.0.0.1'),
(16, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446031836', '127.0.0.1'),
(17, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446118092', '127.0.0.1'),
(18, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446137671', '127.0.0.1'),
(19, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446142165', '127.0.0.1'),
(20, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446142613', '127.0.0.1'),
(21, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446142702', '127.0.0.1'),
(22, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446188520', '127.0.0.1'),
(23, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446194224', '127.0.0.1'),
(24, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446204866', '127.0.0.1'),
(25, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446215409', '127.0.0.1'),
(26, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446216826', '127.0.0.1'),
(27, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446224305', '127.0.0.1'),
(28, '1.01.01', 'Google Chrome 42.0.2311.135', 'Masuk ke sistem', '1446224767', '127.0.0.1'),
(29, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446225236', '127.0.0.1'),
(30, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446308566', '127.0.0.1'),
(31, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446310491', '127.0.0.1'),
(32, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446312106', '127.0.0.1'),
(33, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446312739', '127.0.0.1'),
(34, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446563526', '127.0.0.1'),
(35, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446567045', '127.0.0.1'),
(36, 'admin', 'Google Chrome 42.0.2311.135', 'Masuk ke sistem', '1446652108', '127.0.0.1'),
(37, '1.01.01', 'Google Chrome 42.0.2311.135', 'Masuk ke sistem', '1446656466', '127.0.0.1'),
(38, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446659952', '127.0.0.1'),
(39, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446660660', '127.0.0.1'),
(40, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446687423', '127.0.0.1'),
(41, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446687939', '127.0.0.1'),
(42, 'admin', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446688277', '127.0.0.1'),
(43, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446690514', '127.0.0.1'),
(44, '1.01.01', 'Google Chrome 42.0.2311.135', 'Masuk ke sistem', '1446794452', '127.0.0.1'),
(45, '1.01.01', 'Mozilla Firefox 41.0', 'Masuk ke sistem', '1446795050', '127.0.0.1'),
(46, '1.01.01', 'Mozilla Firefox 42.0', 'Masuk ke sistem', '1448206003', '127.0.0.1'),
(47, 'admin', 'Mozilla Firefox 42.0', 'Masuk ke sistem', '1448209485', '127.0.0.1'),
(48, 'admin', 'Mozilla Firefox 42.0', 'Masuk ke sistem', '1450762343', '127.0.0.1'),
(49, 'admin', 'Mozilla Firefox 42.0', 'Masuk ke sistem', '1450765590', '127.0.0.1'),
(50, '1.01.01', 'Mozilla Firefox 42.0', 'Masuk ke sistem', '1450767717', '127.0.0.1'),
(51, '1.01.01', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1452495455', '127.0.0.1'),
(52, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1452497315', '127.0.0.1'),
(53, '1.01.01', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1452497463', '127.0.0.1'),
(54, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1452500414', '127.0.0.1'),
(55, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1453909101', '127.0.0.1'),
(56, '1.01.01', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1454855877', '127.0.0.1'),
(57, '1.01.01', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1454931950', '127.0.0.1'),
(58, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1454933114', '127.0.0.1'),
(59, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1454934772', '127.0.0.1'),
(60, '1.01.01', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1455018549', '127.0.0.1'),
(61, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1455018689', '127.0.0.1'),
(62, 'admin', 'Mozilla Firefox 43.0', 'Masuk ke sistem', '1455019913', '127.0.0.1'),
(63, 'admin', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455800356', '127.0.0.1'),
(64, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455922787', '127.0.0.1'),
(65, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455931126', '127.0.0.1'),
(66, 'admin', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455931238', '127.0.0.1'),
(67, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455931348', '127.0.0.1'),
(68, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1455955207', '127.0.0.1'),
(69, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458448020', '127.0.0.1'),
(70, 'admin', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458448054', '127.0.0.1'),
(71, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458448139', '127.0.0.1'),
(72, 'admin', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458448930', '127.0.0.1'),
(73, '1.01.01', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458457499', '127.0.0.1'),
(74, 'admin', 'Mozilla Firefox 44.0', 'Masuk ke sistem', '1458457583', '127.0.0.1'),
(75, '1.01.01', 'Mozilla Firefox 45.0', 'Masuk ke sistem', '1460963206', '127.0.0.1'),
(76, 'admin', 'Mozilla Firefox 45.0', 'Masuk ke sistem', '1460964289', '127.0.0.1'),
(77, '1.01.01', 'Mozilla Firefox 45.0', 'Masuk ke sistem', '1461391876', '127.0.0.1'),
(78, '1.01.01', 'Mozilla Firefox 45.0', 'Masuk ke sistem', '1461489116', '127.0.0.1'),
(79, 'admin', 'Mozilla Firefox 45.0', 'Masuk ke sistem', '1461489526', '127.0.0.1'),
(80, '1.01.01', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1464952965', '127.0.0.1'),
(81, 'admin', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1464952993', '127.0.0.1'),
(82, '1.01.01', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1464955332', '127.0.0.1'),
(83, '1.01.01', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1465055664', '127.0.0.1'),
(84, '1.01.01', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1465055841', '127.0.0.1'),
(85, 'admin', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1465056426', '127.0.0.1'),
(86, 'admin', 'Mozilla Firefox 46.0', 'Masuk ke sistem', '1465279339', '127.0.0.1'),
(87, 'admin', 'Mozilla Firefox 53.0', 'Masuk ke sistem', '1497855383', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ppas`
--

CREATE TABLE `tb_ppas` (
  `id_ppas` int(10) NOT NULL,
  `nomor_skpd` varchar(15) NOT NULL,
  `id_programkegiatan` int(5) NOT NULL,
  `belanja_tidak_langsung` int(20) NOT NULL,
  `belanja_langsung` int(20) NOT NULL,
  `no_tahun` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ppas`
--

INSERT INTO `tb_ppas` (`id_ppas`, `nomor_skpd`, `id_programkegiatan`, `belanja_tidak_langsung`, `belanja_langsung`, `no_tahun`) VALUES
(1, '1.01.01', 1, 80000000, 36000000, 1),
(2, '1.01.01', 2, 100000, 10000, 1),
(3, '1.01.01', 27, 100000000, 300000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_program`
--

CREATE TABLE `tb_program` (
  `no_program` varchar(10) NOT NULL,
  `nama_program` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_program`
--

INSERT INTO `tb_program` (`no_program`, `nama_program`) VALUES
('01', 'Program Pelayanan Administrasi Perkantoran'),
('02', 'Program Peningkatan Sarana dan Prasarana Aparatur');

-- --------------------------------------------------------

--
-- Table structure for table `tb_programkegiatan`
--

CREATE TABLE `tb_programkegiatan` (
  `id_programkegiatan` int(5) NOT NULL,
  `no_program` varchar(10) NOT NULL,
  `id_kegiatan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_programkegiatan`
--

INSERT INTO `tb_programkegiatan` (`id_programkegiatan`, `no_program`, `id_kegiatan`) VALUES
(1, '01', 1),
(2, '01', 2),
(3, '01', 3),
(4, '01', 4),
(5, '01', 5),
(6, '01', 6),
(7, '01', 7),
(8, '01', 8),
(9, '01', 9),
(10, '01', 10),
(11, '01', 11),
(12, '01', 12),
(13, '01', 13),
(14, '01', 14),
(15, '01', 15),
(16, '01', 16),
(17, '01', 17),
(18, '01', 18),
(19, '01', 19),
(20, '02', 20),
(21, '02', 21),
(22, '02', 22),
(23, '02', 23),
(24, '02', 24),
(25, '02', 25),
(26, '02', 26),
(27, '02', 27),
(28, '02', 28),
(29, '02', 29),
(30, '02', 30),
(31, '02', 31),
(32, '02', 32),
(33, '02', 33),
(34, '02', 34),
(35, '02', 35);

-- --------------------------------------------------------

--
-- Table structure for table `tb_skpd`
--

CREATE TABLE `tb_skpd` (
  `nomor_skpd` varchar(15) NOT NULL,
  `nama_skpd` text NOT NULL,
  `sandi_skpd` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_skpd`
--

INSERT INTO `tb_skpd` (`nomor_skpd`, `nama_skpd`, `sandi_skpd`, `email`, `alamat`, `telepon`, `fax`, `level`) VALUES
('1.01.01', 'Dinas Pendidikan', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Mozilla Firefox 41.0', '082152673706', '14434559721', 'user'),
('1.02.01', 'Dinas Kesehatan', 'd9b1d7db4cd6e70935368a1efb10e377', 'mariadi.andi@gmail.com', 'Mozilla Firefox 41.0', '082152673706', '1444035936', 'user'),
('1.02.02', 'Rumah Sakit Umum Daerah', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.03.01', 'Dinas Pekerjaan Umum', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.04.01', 'Dinas Perumahan, Tata Ruang dan Pengawasan Bangunan', 'd9b1d7db4cd6e70935368a1efb10e377', 'email@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.04.02', 'UPT Pemadam Kebakaran', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.05.01', 'Dinas Kebersihan dan Pertamanan', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.06.01', 'Badan Perencanaan Pembangunan Daerah', 'd9b1d7db4cd6e70935368a1efb10e377', 'boz.jogeng@gmail.com', 'Mozilla Firefox 41.0', '::1', '1443523331', 'user'),
('1.07.01', 'Dinas Perhubungan, Komunikasi dan Informatika', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah no 16 Banjarbaru', '082152673706', '', 'user'),
('1.08.01', 'Badan Lingkungan Hidup ', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.09.01', 'Dinas Kebersihan dan Pertamanan', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.09.02', 'Badan Ketahanan Pangan dan P3K', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.10.01', 'Dinas Kependudukan dan Pencatatan Sipil', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.11.01', 'Badan Pemberdayaan Masyarakat dan Keluarga Berencana', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.13.01', 'Dinas Sosial dan Tenaga Kerja', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.15.01', 'Dinas Koperasi dan Usaha Mikro Kecil dan Menengah', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.16.01', 'Badan Pelayanan Perizinan Terpadu dan Penanaman Modal1.01.01', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.17.01', 'Dinas Kebudayaan, Pariwisata, Pemuda dan Olah Raga', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.19.01', 'Badan Kesatuan Bangsa dan Politik', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.19.03', 'Satuan Polisi Pamong Praja dan Perlindungan Masyarakat', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.03', 'Sekretariat Daerah Kota', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16', '082152673706', '', 'user'),
('1.20.04', 'Sekretariat DPRD', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. Suriansyah no. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.05', 'Dinas Pendapatan, Pengelolaan Keuangan dan Aset Daerah', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.06', 'Sekretariat Korpri', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.07', 'Inspektorat', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.09.01', 'Kecamatan Banjarbaru Utara', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.09.02', 'Kecamatan Banjarbaru Selatan', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.09.03', 'Kecamatan Landasan Ulin', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.09.04', 'Kecamatan Liang Anggang', 'd9b1d7db4cd6e70935368a1efb10e377', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.20.09.05', 'Kecamatan Cempaka', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.21.01', 'Badan Kepegawaian, Pendidikan dan Pelatihan Daerah', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@domain.com', 'Jl. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('1.24.02', 'Kantor Perpustakaan dan Arsip Daerah', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('2.01.01', 'Dinas Pertanian, Perikanan dan Kehutanan', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('2.03.01', 'Dinas Perindustrian, Perdagangan, dan Pertambangan', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@domain.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'user'),
('Admin', 'Admin', '48de5266b886e255cb42cd6bf43bdcc5', 'admin@localhost.com', 'Jl. P. Suriansyah No. 16 Banjarbaru', '082152673706', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tahun`
--

CREATE TABLE `tb_tahun` (
  `no_tahun` int(5) NOT NULL,
  `tahun` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tahun`
--

INSERT INTO `tb_tahun` (`no_tahun`, `tahun`) VALUES
(1, 2015);

-- --------------------------------------------------------

--
-- Table structure for table `tb_target`
--

CREATE TABLE `tb_target` (
  `no_target` int(5) NOT NULL,
  `nama_target` text NOT NULL,
  `satuan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_target`
--

INSERT INTO `tb_target` (`no_target`, `nama_target`, `satuan`) VALUES
(4, 'Tercapainya jasa surat menyurat', '100%'),
(6, 'Tercapainya jasa non PNS', '100%'),
(8, 'Tercapainya jasa kebersihan kantor', '100%');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_belanja`
--
ALTER TABLE `tb_belanja`
  ADD PRIMARY KEY (`id_belanja`);

--
-- Indexes for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `tb_ket_belanja`
--
ALTER TABLE `tb_ket_belanja`
  ADD PRIMARY KEY (`id_ket`);

--
-- Indexes for table `tb_laporan_belanja`
--
ALTER TABLE `tb_laporan_belanja`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `kode_belanja` (`id_belanja`,`id_ket`);

--
-- Indexes for table `tb_laporan_programkegiatan`
--
ALTER TABLE `tb_laporan_programkegiatan`
  ADD PRIMARY KEY (`no_tabel`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`no_log`);

--
-- Indexes for table `tb_ppas`
--
ALTER TABLE `tb_ppas`
  ADD PRIMARY KEY (`id_ppas`);

--
-- Indexes for table `tb_program`
--
ALTER TABLE `tb_program`
  ADD PRIMARY KEY (`no_program`);

--
-- Indexes for table `tb_programkegiatan`
--
ALTER TABLE `tb_programkegiatan`
  ADD PRIMARY KEY (`id_programkegiatan`);

--
-- Indexes for table `tb_skpd`
--
ALTER TABLE `tb_skpd`
  ADD PRIMARY KEY (`nomor_skpd`);

--
-- Indexes for table `tb_tahun`
--
ALTER TABLE `tb_tahun`
  ADD PRIMARY KEY (`no_tahun`);

--
-- Indexes for table `tb_target`
--
ALTER TABLE `tb_target`
  ADD PRIMARY KEY (`no_target`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_belanja`
--
ALTER TABLE `tb_belanja`
  MODIFY `id_belanja` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  MODIFY `id_kegiatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `tb_ket_belanja`
--
ALTER TABLE `tb_ket_belanja`
  MODIFY `id_ket` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_laporan_belanja`
--
ALTER TABLE `tb_laporan_belanja`
  MODIFY `id_laporan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tb_laporan_programkegiatan`
--
ALTER TABLE `tb_laporan_programkegiatan`
  MODIFY `no_tabel` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `no_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `tb_ppas`
--
ALTER TABLE `tb_ppas`
  MODIFY `id_ppas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_programkegiatan`
--
ALTER TABLE `tb_programkegiatan`
  MODIFY `id_programkegiatan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `tb_tahun`
--
ALTER TABLE `tb_tahun`
  MODIFY `no_tahun` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_target`
--
ALTER TABLE `tb_target`
  MODIFY `no_target` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
