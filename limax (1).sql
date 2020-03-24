-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 03:25 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limax`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `namalengkap` varchar(40) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telpon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `namalengkap`, `alamat`, `telpon`) VALUES
(1, 'torik', 'ponorogo', '0813123123'),
(2, 'orang gila', 'jalan mor baut', '087678765123'),
(3, 'Hanim', 'Ponorogo', '0812131112232'),
(4, 'Afif', 'Balong', '677867867868767'),
(5, 'Hudaifi', 'Jalan Kenangan', '9873928748979'),
(6, 'Andi Solihin', 'Jalan Pamekasan', '478578465864'),
(7, 'Yasita', 'jl pramuka', '6876786876'),
(8, 'firdaus', 'jalabn aspal', '79897989789798'),
(9, 'Ahmad Kurniawan', 'siman', '7836876387687'),
(10, 'Jafar Hisyamudin', 'Setono', '6287346826348'),
(1234, 'daffa perdana', 'ponorogo', '08756778665'),
(112312, 'Hanim Putra', 'Madiun', '123123');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(60) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `idlokasi` int(10) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `deskripsi`, `jenis`, `jumlah`, `idlokasi`) VALUES
(0000000001, 'buku', 'jksdfdsklcskjkjscdkj jsdk', 'koran', 0, 0000000001),
(0000000002, 'android', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Mobile', 17, 0000000002),
(0000000003, 'Auto Magz', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'majalah', 17, 0000000001),
(0000000004, 'Otomotif', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Koran', 20, 0000000001),
(0000000005, 'Laporan Prakerin', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Contoh Laporan', 20, 0000000001),
(0000000006, 'buku2', 'jksdfdsklcskjkjscdkj jsdkj', 'koran', 2, 0000000001),
(0000000007, 'android2', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Mobile', 20, 0000000002),
(0000000008, 'Auto Magz2', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'majalah', 20, 0000000001),
(0000000009, 'Otomotif2', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Koran', 20, 0000000001),
(0000000010, 'Laporan Prakerin2', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'Contoh Laporan', 20, 0000000001),
(0000000011, 'Web Development2', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'web', 20, 0000000001),
(0000000012, 'Web Development', 'buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku buku ', 'web', 20, 0000000001);

-- --------------------------------------------------------

--
-- Table structure for table `detiltransaksi`
--

CREATE TABLE `detiltransaksi` (
  `idtransaksi` int(10) UNSIGNED ZEROFILL NOT NULL,
  `idbuku` int(10) UNSIGNED ZEROFILL NOT NULL,
  `tglharuskembali` datetime NOT NULL,
  `tglpengembalian` datetime DEFAULT NULL,
  `denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detiltransaksi`
--

INSERT INTO `detiltransaksi` (`idtransaksi`, `idbuku`, `tglharuskembali`, `tglpengembalian`, `denda`) VALUES
(0000000001, 0000000001, '2017-05-02 19:58:20', '2017-05-03 12:14:12', 0),
(0000000002, 0000000001, '2017-05-05 07:36:23', '2017-05-03 12:14:12', 0),
(0000000002, 0000000002, '2017-05-05 07:36:23', '2017-05-03 12:14:12', 0),
(0000000002, 0000000003, '2017-05-05 07:36:23', NULL, 0),
(0000000003, 0000000002, '2017-05-09 11:12:05', '2017-05-03 12:14:12', 0),
(0000000003, 0000000003, '2017-05-09 11:12:05', NULL, 0),
(0000000004, 0000000001, '2017-05-10 12:13:28', '2017-05-03 12:14:12', 0),
(0000000004, 0000000002, '2017-05-10 12:13:28', '2017-05-03 12:14:12', 0),
(0000000005, 0000000001, '2017-05-11 08:33:20', NULL, 0),
(0000000005, 0000000003, '2017-05-11 08:33:20', NULL, 0),
(0000000006, 0000000002, '2017-05-19 20:22:49', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tempat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `nama`, `tempat`) VALUES
(0000000001, 'Rak 1', 'bawah'),
(0000000002, 'Rak 2', 'Ruang Server'),
(0000000003, 'Rak 8', 'Bawah');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` varchar(20) NOT NULL,
  `nilai` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `katasandi` varchar(80) NOT NULL,
  `tingkatan` varchar(20) NOT NULL,
  `opsi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `katasandi`, `tingkatan`, `opsi`) VALUES
('admin', 'Administrator', '$2y$10$Qj5ZrV7ZqzKsbe7Y4qa5D.XwS/ElCKgA2kXj0HXbe1ThdZHgrVINe', 'admin', '{\"session\":\"fjf92aqltdp0n8t7bui50a5cne\"}'),
('Edwin', 'Edwin', '$2y$10$/vev/QTcZFcfGHu2Hja1luOJMdaFM7KWthb72OcUP9CofuE3Z89ES', 'librarian', '{\"session\":\"dcp17j3bsv471lcn3mddb60nl3\"}'),
('librarian', 'lib', '$2y$10$49O3Gqv45SWhHy9DaaMQnegSgxfHzkA81NkT8QaoxlSb3xzWftYzW', 'librarian', '{\"session\":\"hmj3pjp1pargvf2shuu060hghu\"}');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `idanggota` int(11) NOT NULL,
  `tglpinjam` datetime NOT NULL,
  `idpengguna` varchar(20) DEFAULT NULL,
  `totdenda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `idanggota`, `tglpinjam`, `idpengguna`, `totdenda`) VALUES
(00000000001, 1, '2017-04-25 19:58:20', 'librarian', 0),
(00000000002, 4, '2017-04-28 07:36:23', 'admin', 0),
(00000000003, 1, '2017-05-02 11:12:05', 'admin', 0),
(00000000004, 1234, '2017-05-03 12:13:29', 'admin', 0),
(00000000005, 112312, '2017-05-04 08:33:20', 'admin', 0),
(00000000006, 1, '2017-05-12 20:22:49', 'admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDLokasi_idx` (`idlokasi`);

--
-- Indexes for table `detiltransaksi`
--
ALTER TABLE `detiltransaksi`
  ADD PRIMARY KEY (`idtransaksi`,`idbuku`),
  ADD KEY `FK_IDBuku_idx` (`idbuku`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDPengguna_idx` (`idpengguna`),
  ADD KEY `FK_IDAnggota_idx` (`idanggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `FK_IDLokasi` FOREIGN KEY (`idlokasi`) REFERENCES `lokasi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detiltransaksi`
--
ALTER TABLE `detiltransaksi`
  ADD CONSTRAINT `FK_IDBuku` FOREIGN KEY (`idbuku`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IDTransaksi` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_IDAnggota` FOREIGN KEY (`idanggota`) REFERENCES `anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IDPengguna` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
