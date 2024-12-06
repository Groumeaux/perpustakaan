-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 01:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_pinjam`
--

CREATE TABLE `log_pinjam` (
  `id_log` int(11) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `id_anggota` varchar(10) NOT NULL,
  `tgl_pinjam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_pinjam`
--

INSERT INTO `log_pinjam` (`id_log`, `id_buku`, `id_anggota`, `tgl_pinjam`) VALUES
(1, 'B001', 'A001', '2020-06-23'),
(2, 'B002', 'A001', '2020-06-25'),
(3, 'B003', 'A002', '2020-06-01'),
(4, 'B002', 'A005', '2020-06-23'),
(5, 'B001', 'A010', '2024-12-03'),
(6, 'B008', 'A013', '2024-12-03'),
(7, 'B002', 'A013', '2024-12-06'),
(8, 'B003', 'A013', '2024-12-06'),
(9, 'B006', 'A013', '2024-12-06'),
(10, 'B001', 'A013', '2024-12-06'),
(11, 'B005', 'A013', '2024-12-06'),
(12, 'B003', 'A013', '2024-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` varchar(10) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `jekel` enum('Laki-laki','Perempuan') NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_anggota`, `nama`, `jekel`, `kelas`, `no_hp`) VALUES
('A001', 'Ana', 'Perempuan', 'juwana', '089987789000'),
('A002', 'Bagus', 'Laki-laki', 'demak', '089987789098'),
('A003', 'Citra', 'Perempuan', 'demak', '085878526048'),
('A004', 'Didik', 'Laki-laki', 'pati', '087789987654'),
('A005', 'Edi', 'Laki-laki', 'demak', '089987789098'),
('A010', 'Fanuel', 'Laki-laki', 'Tondano', '8180909209'),
('A012', 'Jane Doe', 'Perempuan', 'Somewhere', '80808008080'),
('A013', 'John Doe', 'Laki-laki', 'City A', '800808080808');

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(64) NOT NULL,
  `pengarang` varchar(64) NOT NULL,
  `penerbit` varchar(30) NOT NULL,
  `th_terbit` year(4) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `cover` varchar(200) NOT NULL,
  `jml_buku` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `judul_buku`, `pengarang`, `penerbit`, `th_terbit`, `isbn`, `cover`, `jml_buku`) VALUES
('B001', 'Matematika', 'anastasya', 'armi print', 2010, '1000000000000', '', 6),
('B002', 'RPL 2', 'Eko', 'UMK', 2020, '2000000000000', '', 7),
('B003', 'C++', 'Anton', 'Toni Perc', 2010, '3000000000000', '', 5),
('B004', 'CI 4', 'anastasya', 'armi print', 2009, '4000000000000', '', 2),
('B005', 'Data Mining', 'Anton', 'Toni Perc', 2020, '5000000000000', '', 8),
('B006', 'Buku Test', 'Saya', 'Saya juga ', 2003, '6000000000000', 'cover_test2.jpg', 1),
('B007', 'Buku Test', 'John Doe', 'SILibrary', 2023, '7000000000000', '', 4),
('B008', 'Business 101', 'Someone', 'Somewhere', 2024, '1902000000000', 'cover_test.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` enum('Administrator','Petugas','Pengguna','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `nama_pengguna`, `username`, `password`, `level`) VALUES
(1, 'M ivan S', 'admin', '202cb962ac59075b964b07152d234b70', 'Administrator'),
(5, 'Mivan', 'ivan', '123', 'Administrator'),
(6, 'SUTOMO', 'A006', '827ccb0eea8a706c4c34a16891f84e7b', ''),
(10, 'Ricky Makalalag', 'Ricky', '827ccb0eea8a706c4c34a16891f84e7b', 'Pengguna'),
(11, 'Fanuel', 'Fanuel', '827ccb0eea8a706c4c34a16891f84e7b', 'Pengguna'),
(12, 'Aku Saya', 'Aku', '827ccb0eea8a706c4c34a16891f84e7b', 'Pengguna'),
(13, 'Jane Doe', 'Jane', '827ccb0eea8a706c4c34a16891f84e7b', 'Pengguna'),
(14, 'John Doe', 'John', '827ccb0eea8a706c4c34a16891f84e7b', 'Pengguna');

-- --------------------------------------------------------

--
-- Table structure for table `tb_reservasi`
--

CREATE TABLE `tb_reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_anggota` varchar(10) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `tanggal_reservasi` date NOT NULL,
  `status` enum('Pending','Diterima','Ditolak') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_reservasi`
--

INSERT INTO `tb_reservasi` (`id_reservasi`, `id_anggota`, `id_buku`, `tanggal_reservasi`, `status`) VALUES
(1, 'A001', 'B001', '2024-11-12', 'Diterima'),
(3, 'A001', 'B003', '2024-12-02', 'Ditolak'),
(8, 'A010', 'B001', '2024-12-01', 'Diterima'),
(10, 'A012', 'B001', '2024-12-02', 'Diterima'),
(11, 'A013', 'B001', '2024-12-02', 'Diterima'),
(25, 'A013', 'B008', '2024-12-03', 'Diterima'),
(30, 'A013', 'B002', '2024-12-06', 'Diterima'),
(31, 'A013', 'B003', '2024-12-06', 'Ditolak'),
(32, 'A013', 'B006', '2024-12-06', 'Ditolak'),
(33, 'A013', 'B005', '2024-12-06', 'Ditolak'),
(34, 'A013', 'B007', '2024-12-06', 'Ditolak'),
(35, 'A013', 'B001', '2024-12-06', 'Diterima'),
(36, 'A013', 'B003', '2024-12-06', 'Diterima'),
(37, 'A013', 'B002', '2024-12-06', 'Diterima'),
(38, 'A013', 'B001', '2024-12-06', 'Ditolak'),
(39, 'A013', 'B002', '2024-12-06', 'Ditolak'),
(40, 'A013', 'B003', '2024-12-06', 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sirkulasi`
--

CREATE TABLE `tb_sirkulasi` (
  `id_sk` varchar(20) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `id_anggota` varchar(10) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` enum('PIN','KEM') NOT NULL,
  `tgl_dikembalikan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sirkulasi`
--

INSERT INTO `tb_sirkulasi` (`id_sk`, `id_buku`, `id_anggota`, `tgl_pinjam`, `tgl_kembali`, `status`, `tgl_dikembalikan`) VALUES
('S001', 'B001', 'A001', '2020-06-23', '2020-06-30', 'KEM', NULL),
('S002', 'B002', 'A001', '2020-06-13', '2020-06-20', 'PIN', NULL),
('S003', 'B003', 'A002', '2020-06-22', '2020-06-29', 'PIN', NULL),
('S004', 'B002', 'A005', '2020-06-23', '2020-06-30', 'PIN', NULL),
('S005', 'B001', 'A010', '2024-12-10', '2024-12-17', 'KEM', NULL),
('S006', 'B008', 'A013', '2024-12-03', '2024-12-10', 'KEM', '2024-12-04'),
('S007', 'B002', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S008', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S009', 'B006', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S010', 'B001', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S011', 'B005', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S012', 'B001', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S013', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S014', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S015', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S016', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S017', 'B002', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06'),
('S018', 'B003', 'A013', '2024-12-06', '2024-12-13', 'KEM', '2024-12-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_pinjam`
--
ALTER TABLE `log_pinjam`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `isbnunique` (`isbn`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `tb_sirkulasi`
--
ALTER TABLE `tb_sirkulasi`
  ADD PRIMARY KEY (`id_sk`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_pinjam`
--
ALTER TABLE `log_pinjam`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_pinjam`
--
ALTER TABLE `log_pinjam`
  ADD CONSTRAINT `log_pinjam_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `log_pinjam_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  ADD CONSTRAINT `tb_reservasi_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_reservasi_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_sirkulasi`
--
ALTER TABLE `tb_sirkulasi`
  ADD CONSTRAINT `tb_sirkulasi_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_sirkulasi_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
