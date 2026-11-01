-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2026 at 05:01 AM
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
-- Database: `tugas_praktikum`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG01', 'Minyak Goreng 1L', 15000, 100, 1),
(2, 'BRG02', 'Beras 5kg', 65000, 50, 2),
(3, 'BRG03', 'Gula Pasir 1kg', 12000, 200, 3),
(4, 'BRG04', 'Tepung Terigu 1kg', 10000, 150, 4),
(5, 'BRG05', 'Telur Ayam 1kg', 25000, 300, 5),
(6, 'BRG06', 'Mie Instan', 3000, 500, 6),
(7, 'BRG07', 'Susu Kental Manis', 11000, 120, 7),
(8, 'BRG08', 'Kopi Bubuk 100gr', 15000, 80, 8),
(9, 'BRG09', 'Teh Celup', 6000, 250, 9),
(10, 'BRG10', 'Garam Dapur', 4000, 400, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('P001', 'Budi Santoso', 'L', '08120000001', 'Jl. Merdeka No 1'),
('P002', 'Siti Aminah', 'P', '08120000002', 'Jl. Sudirman No 2'),
('P003', 'Andi Wijaya', 'L', '08120000003', 'Jl. Thamrin No 3'),
('P004', 'Rina Melati', 'P', '08120000004', 'Jl. Gatot Subroto No 4'),
('P005', 'Joko Susilo', 'L', '08120000005', 'Jl. Pahlawan No 5'),
('P006', 'Maya Sari', 'P', '08120000006', 'Jl. Diponegoro No 6'),
('P007', 'Agus Pratama', 'L', '08120000007', 'Jl. Imam Bonjol No 7'),
('P008', 'Dewi Lestari', 'P', '08120000008', 'Jl. Teuku Umar No 8'),
('P009', 'Eko Saputro', 'L', '08120000009', 'Jl. Hasanuddin No 9'),
('P010', 'Fitriani', 'P', '08120000010', 'Jl. Veteran No 10');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `total` int DEFAULT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') DEFAULT NULL,
  `transaksi_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:30:00', 50000, 'TUNAI', 1),
(2, '2026-10-02 11:00:00', 150000, 'TRANSFER', 2),
(3, '2026-10-03 12:15:00', 30000, 'TUNAI', 3),
(4, '2026-10-04 14:00:00', 75000, 'EDC', 4),
(5, '2026-10-05 09:45:00', 200000, 'TRANSFER', 5),
(6, '2026-10-06 15:30:00', 45000, 'TUNAI', 6),
(7, '2026-10-07 16:20:00', 60000, 'TUNAI', 7),
(8, '2026-10-08 10:10:00', 300000, 'TRANSFER', 8),
(9, '2026-10-09 13:40:00', 80000, 'EDC', 9),
(10, '2026-10-10 17:05:00', 95000, 'TUNAI', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Makmur Jaya', '0812998877', 'Sidoarjo'),
(5, 'UD. Berkah Alam', '0855667788', 'Malang'),
(6, 'PT. Teknologi Baru', '0822334455', 'Jakarta'),
(7, 'CV. Sumber Rejeki', '0811223344', 'Gresik'),
(8, 'UD. Hasil Bumi', '0877665544', 'Mojokerto'),
(9, 'PT. Bintang Kejora', '0899887766', 'Pasuruan'),
(10, 'CV. Karya Mandiri', '0833445566', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date DEFAULT NULL,
  `keterangan` text,
  `total` int DEFAULT NULL,
  `pelanggan_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian Rutin', 50000, 'P001'),
(2, '2026-10-02', 'Belanja Bulanan', 150000, 'P002'),
(3, '2026-10-03', 'Pembelian Eceran', 30000, 'P003'),
(4, '2026-10-04', 'Belanja Mingguan', 75000, 'P004'),
(5, '2026-10-05', 'Grosir Kecil', 200000, 'P005'),
(6, '2026-10-06', 'Pembelian Eceran', 45000, 'P006'),
(7, '2026-10-07', 'Kebutuhan Harian', 60000, 'P007'),
(8, '2026-10-08', 'Belanja Bulanan', 300000, 'P008'),
(9, '2026-10-09', 'Pembelian Rutin', 80000, 'P009'),
(10, '2026-10-10', 'Kebutuhan Dapur', 95000, 'P010');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int DEFAULT NULL,
  `qty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 15000, 2),
(2, 2, 65000, 2),
(3, 3, 12000, 2),
(4, 4, 10000, 5),
(5, 5, 25000, 8),
(6, 6, 3000, 15),
(7, 7, 11000, 4),
(8, 8, 15000, 10),
(9, 9, 6000, 10),
(10, 10, 4000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin1', 'pass123', 'Admin Satu', 'Gedung A', '0811111111', 1),
(2, 'admin2', 'pass123', 'Admin Dua', 'Gedung A', '0811111112', 1),
(3, 'kasir1', 'kasir123', 'Kasir Satu', 'Toko Depan', '0811111113', 2),
(4, 'kasir2', 'kasir123', 'Kasir Dua', 'Toko Depan', '0811111114', 2),
(5, 'kasir3', 'kasir123', 'Kasir Tiga', 'Toko Tengah', '0811111115', 2),
(6, 'kasir4', 'kasir123', 'Kasir Empat', 'Toko Tengah', '0811111116', 2),
(7, 'staff1', 'staff123', 'Staff Gudang 1', 'Gudang Belakang', '0811111117', 3),
(8, 'staff2', 'staff123', 'Staff Gudang 2', 'Gudang Belakang', '0811111118', 3),
(9, 'staff3', 'staff123', 'Staff Gudang 3', 'Gudang Belakang', '0811111119', 3),
(10, 'staff4', 'staff123', 'Staff Gudang 4', 'Gudang Belakang', '0811111120', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
