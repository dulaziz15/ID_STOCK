-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2022 at 05:13 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`) VALUES
(13, 20, '2022-03-12 03:06:50', 'Alexander', 100),
(14, 11, '2022-03-12 01:49:42', 'Admin', 20);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'advancestar@gmail.com', '12345'),
(3, 'expaired@gmail.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`) VALUES
(17, 11, '2022-03-12 01:45:42', 'Alexander', 200),
(18, 12, '2022-03-12 01:46:08', 'Andrians', 100),
(19, 14, '2022-03-12 01:46:48', 'Abraham', 100),
(20, 13, '2022-03-12 01:47:19', 'Admin', 500),
(21, 15, '2022-03-12 01:48:07', 'Alexander', 50),
(22, 20, '2022-03-12 01:48:50', 'Alexander', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int(11) NOT NULL,
  `idbarang` int(11) DEFAULT NULL,
  `tanggalpinjam` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qty` int(11) DEFAULT NULL,
  `peminjam` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idbarang`, `tanggalpinjam`, `qty`, `peminjam`, `status`) VALUES
(13, 13, '2022-03-12 01:54:36', 500, 'Alexander', 'Kembali'),
(14, 16, '2022-03-12 02:04:22', 20, 'Andrians', 'Dipinjam'),
(15, 18, '2022-03-12 02:04:29', 20, 'Alexander', 'Dipinjam'),
(16, 20, '2022-03-12 02:04:07', 499, 'Abraham', 'Kembali');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(11, 'PC Kantor', 'PC ini bisa digunakan dirumah dan kantor', 303, '994a643e17c64156e1a897abb4fddea1.jpg'),
(12, 'PC Gaming RTX 3080 Ti', 'PC Gaming', 250, '0b455a4cdfb2e33d07e20a97bc985fe3.jpg'),
(13, 'Mouse Gaming', 'Mouse Gaming', 1500, '7dd7ab363bfb2f24a561637cb67280ff.jpg'),
(14, 'Mouse Kantor', 'Mouse Kantor Kabel', 300, 'd729849ff72e7ba25274a229555445f7.jpg'),
(15, 'Mouse Kantor Wireless', 'Mouse Kantor Wireless', 550, 'eff142a76f2291d2ea240a98e9b18d48.jpg'),
(16, 'Keyboard Gaming', 'Keyboard Gaming', 480, 'b50d59b991805e912acd1a6f80666625.jpg'),
(17, 'Keyboard Kantor', 'Keyboard Kantor', 1000, '55677778c05bf1af675b0a568302f6ab.jpg'),
(18, 'Harddisk Eksternal', 'Harddisk Eksternal 1TB', 980, 'a4e768ffe63650a885d551f928e440aa.jpg'),
(19, 'Harddisk Eksternal', 'Harddisk Eksternal 500GB', 1500, 'c8b9bfbbb7b8a30975a50f3eb42b90c1.jpg'),
(20, 'SSD Eksternal', 'SSD Eksternal 500GB', 1400, 'c358f416c0d57f5a70bc151834a3313b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
