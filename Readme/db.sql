-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 17 Jul 2020 pada 01.10
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `images_project`
--
CREATE DATABASE IF NOT EXISTS `images_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `images_project`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `caption_images`
--

CREATE TABLE `caption_images` (
  `id_cap` int(11) NOT NULL,
  `mediagr_id` varchar(255) NOT NULL,
  `caption_cap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `noncapted_images`
--

CREATE TABLE `noncapted_images` (
  `id_noncapted` int(11) NOT NULL,
  `mediagr_id` varchar(255) NOT NULL,
  `file_on` varchar(255) NOT NULL,
  `time_noncapted` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan_images`
--

CREATE TABLE `pelanggan_images` (
  `id_pelanggan_i` int(255) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbphoto_images`
--

CREATE TABLE `tbphoto_images` (
  `id_tbphoto` int(255) NOT NULL,
  `photo_tbphoto` varchar(255) NOT NULL,
  `hash_tbphoto` varchar(255) NOT NULL,
  `mediagr_id` varchar(255) NOT NULL,
  `uploadtime_tbphoto` int(255) NOT NULL,
  `from_tbphoto` int(255) NOT NULL,
  `intcaption_tbphoto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_images`
--

CREATE TABLE `user_images` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `pass_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `caption_images`
--
ALTER TABLE `caption_images`
  ADD PRIMARY KEY (`id_cap`);

--
-- Indeks untuk tabel `noncapted_images`
--
ALTER TABLE `noncapted_images`
  ADD PRIMARY KEY (`id_noncapted`);

--
-- Indeks untuk tabel `pelanggan_images`
--
ALTER TABLE `pelanggan_images`
  ADD PRIMARY KEY (`id_pelanggan_i`);

--
-- Indeks untuk tabel `tbphoto_images`
--
ALTER TABLE `tbphoto_images`
  ADD PRIMARY KEY (`id_tbphoto`);

--
-- Indeks untuk tabel `user_images`
--
ALTER TABLE `user_images`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `caption_images`
--
ALTER TABLE `caption_images`
  MODIFY `id_cap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `noncapted_images`
--
ALTER TABLE `noncapted_images`
  MODIFY `id_noncapted` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggan_images`
--
ALTER TABLE `pelanggan_images`
  MODIFY `id_pelanggan_i` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbphoto_images`
--
ALTER TABLE `tbphoto_images`
  MODIFY `id_tbphoto` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_images`
--
ALTER TABLE `user_images`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
