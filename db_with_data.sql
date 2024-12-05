-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2024 pada 15.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `power_monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `area` varchar(20) NOT NULL,
  `control_on` enum('button','switch','sound') NOT NULL,
  `control_off` enum('button','switch','sound') NOT NULL,
  `start_time` datetime NOT NULL,
  `finish_time` datetime NOT NULL,
  `power_consumed` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history`
--

INSERT INTO `history` (`id`, `area`, `control_on`, `control_off`, `start_time`, `finish_time`, `power_consumed`) VALUES
(1, 'Area 1', 'button', 'switch', '2024-11-01 08:00:00', '2024-11-01 17:00:00', 135.00),
(2, 'Area 2', 'button', 'switch', '2024-11-01 08:00:10', '2024-11-01 17:01:10', 135.20),
(3, 'Area 1', 'button', 'sound', '2024-11-01 08:00:07', '2024-11-01 17:00:13', 135.10),
(4, 'Area 2', 'button', 'sound', '2024-11-01 08:00:15', '2024-11-01 17:00:13', 135.09),
(5, 'Area 1', 'switch', 'button', '2024-11-02 08:00:10', '2024-11-02 17:01:10', 135.20),
(6, 'Area 2', 'switch', 'button', '2024-11-02 08:00:10', '2024-11-02 17:01:10', 135.20),
(7, 'Area 1', 'sound', 'button', '2024-11-02 08:00:10', '2024-11-02 17:01:10', 135.20),
(8, 'Area 2', 'sound', 'button', '2024-11-02 08:00:10', '2024-11-02 17:01:10', 135.20),
(9, 'Area 1', 'button', 'sound', '2024-11-04 08:00:00', '2024-11-04 17:00:00', 135.00),
(10, 'Area 2', 'button', 'sound', '2024-11-04 08:00:00', '2024-11-04 17:00:00', 135.00),
(11, 'Area 1', 'switch', 'sound', '2024-11-04 08:00:00', '2024-11-04 17:00:00', 135.00),
(12, 'Area 2', 'switch', 'sound', '2024-11-04 08:00:00', '2024-11-05 08:00:00', 360.00);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
