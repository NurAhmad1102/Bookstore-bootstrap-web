-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2022 pada 15.56
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssip_final`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(69, 13, '5 Design', 17000, 1, '5 design.png'),
(70, 13, 'Annual report 2019', 10000, 1, 'Annual report 2019.png'),
(71, 13, 'Cereal', 25000, 1, 'Cereal.png'),
(72, 13, 'Design is color magic', 15000, 1, 'Design is color magic.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `admin_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `admin_id`) VALUES
(14, 9, 'ananti', '454545', 'ananti@gmail.com', 'cash on delivery', 'bekasi, jabar - 676767', ', Graphic (1) , Design is color magic (1) ', 30000, '19-Dec-2022', 'Completed', '4'),
(17, 8, 'abi', '1212', 'abi@gmail.com', 'paytm', 'Bogor, jabar - 454544', ', Picture of Dorian Gray (1) ', 20000, '19-Dec-2022', 'Completed', '4'),
(18, 8, 'abi', '121212122', 'abi@gmail.com', 'e-wallet', 'bekasi, jabar - 1212121', ', Design is color magic (1) ', 15000, '20-Dec-2022', 'Pending', ''),
(19, 9, 'a', '12122', 'a@gmail.com', 'e-wallet', 'Bogor, jabar - 121221', ', Event Poster (1) , Picture of Dorian Gray (1) ', 32000, '20-Dec-2022', 'Pending', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(10, '5 Design', 17000, '5 design.png'),
(11, 'Annual report 2019', 10000, 'Annual report 2019.png'),
(13, 'Design is color magic', 15000, 'Design is color magic.png'),
(14, 'Event Poster', 12000, 'Event poster.png'),
(15, 'Graphic', 15000, 'Graphic.png'),
(16, 'Picture of Dorian Gray', 20000, 'Picture of dorian gray.png'),
(17, 'The Two Towers', 19000, 'The two towers.png'),
(19, 'Typography', 22000, 'Typography.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `log_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`log_id`, `name`, `email`, `password`, `user_type`) VALUES
(4, 'natta', 'natta@gmail', '1234', 'admin'),
(7, 'qw', 'qw@gmail.com', '12', 'user'),
(8, 'abi', 'abi@gmail.com', '12', 'user'),
(9, 'a', 'a@gmail.com', '12', 'user'),
(10, 'b', 'b@gmail.com', '12', 'user'),
(11, 'c', 'c@gmail.com', '12', 'user'),
(12, 'd', 'd@gmail.com', '12', 'user'),
(13, 'e', 'e@gmail.com', '12', 'user'),
(14, 'f', 'f@gmail.com', '12', 'admin'),
(15, 'g', 'g@gmail.com', '12', 'admin'),
(16, 'h', 'h@gmail.com', '12', 'admin'),
(18, 'x', 'x@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'admin'),
(19, 'z', 'z@gmail.com', '123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `log_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
