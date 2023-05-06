-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Apr 2023 pada 17.10
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `katiga_carwash`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `role` enum('Admin','Customer') NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data untuk tabel `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `nama_lengkap`, `no_telp`, `role`, `status`) VALUES
(1, 'admin@gmail.com', '$2y$10$XwhDa2Uls774FxI1qzpegeKxgDY96CUcKL188A8nOQ6PJ3LxUIzPm', 'Admin', '089629614608', 'Admin', 'Offline'),
(2, 'christian@gmail.com', '$2y$10$rXKydVX7UU/j7opbr59EH.PRioOR2os9xAlfrdcKQ3kakd23cgpT2', 'Christian', '081398897738', 'Customer', 'Offline'),
(3, 'kristiana@gmail.com', '$2y$10$QMMOf.YFxuusZiZnDbQJ4u7fc4S0bnbbmSM7EwiGZIJJIJwVRf8he', 'Kristiana', '081578945612', 'Customer', 'Offline');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga`
--

CREATE TABLE `harga` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `harga` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `harga`
--

INSERT INTO `harga` (`id`, `type_id`, `harga`) VALUES
(1, 1, 75000),
(2, 2, 50000),
(3, 3, 25000),
(4, 4, 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `list_kendaraan`
--

CREATE TABLE `list_kendaraan` (
  `id` int(11) NOT NULL,
  `nama_kendaraan` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `list_kendaraan`
--

INSERT INTO `list_kendaraan` (`id`, `nama_kendaraan`, `type_id`, `customers_id`) VALUES
(1, 'Xenia', 2, 2),
(2, 'Supra 125', 4, 2),
(12, 'Hyundai Ionic 5', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kendaraan_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `status` enum('Belum Datang','Datang','Tidak Datang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `jam`, `kendaraan_id`, `customers_id`, `status`) VALUES
(1, '2023-04-14', '15:00:00', 2, 2, 'Datang'),
(3, '2023-04-14', '17:00:00', 12, 3, 'Datang'),
(4, '2023-04-17', '16:00:00', 1, 2, 'Tidak Datang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `nama_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `type`
--

INSERT INTO `type` (`id`, `nama_type`) VALUES
(1, 'Mobil Besar'),
(2, 'Mobil Kecil'),
(3, 'Motor Besar'),
(4, 'Motor Kecil');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indeks untuk tabel `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_id_2` (`type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indeks untuk tabel `list_kendaraan`
--
ALTER TABLE `list_kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kendaraan` (`nama_kendaraan`,`type_id`),
  ADD KEY `list_kendaraan_ibfk_1` (`type_id`),
  ADD KEY `list_kendaraan_ibfk_2` (`customers_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kendaraan_id` (`kendaraan_id`),
  ADD KEY `customer_id` (`customers_id`);

--
-- Indeks untuk tabel `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_type` (`nama_type`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `harga`
--
ALTER TABLE `harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `list_kendaraan`
--
ALTER TABLE `list_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `harga`
--
ALTER TABLE `harga`
  ADD CONSTRAINT `harga_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Ketidakleluasaan untuk tabel `list_kendaraan`
--
ALTER TABLE `list_kendaraan`
  ADD CONSTRAINT `list_kendaraan_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  ADD CONSTRAINT `list_kendaraan_ibfk_2` FOREIGN KEY (`customers_id`) REFERENCES `accounts` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`kendaraan_id`) REFERENCES `list_kendaraan` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`customers_id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
