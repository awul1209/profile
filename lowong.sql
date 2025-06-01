-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jun 2025 pada 15.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lowong`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang`
--

CREATE TABLE `bidang` (
  `id` int(11) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bidang`
--

INSERT INTO `bidang` (`id`, `nama_bidang`, `gambar`) VALUES
(1, 'Keuangan', ''),
(2, 'Informasi Teknologi', ''),
(3, 'Sumber Daya Manusia', ''),
(4, 'Pemasaran', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `id` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `bidang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id`, `kriteria`, `bobot`, `bidang_id`) VALUES
(1, 'pendidikan', 0.30, 1),
(2, 'pengalaman_kerja', 0.30, 1),
(3, 'keterampilan_komunikasi', 0.20, 1),
(4, 'problem_solving', 0.20, 1),
(10, 'pendidikan', 0.25, 2),
(11, 'pengalaman_kerja', 0.25, 2),
(12, 'keterampilan_komunikasi', 0.20, 2),
(13, 'problem_solving', 0.30, 2),
(14, 'pendidikan', 0.30, 3),
(15, 'pengalaman_kerja', 0.20, 3),
(16, 'keterampilan_komunikasi', 0.30, 3),
(17, 'problem_solving', 0.20, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `calon_karyawan`
--

CREATE TABLE `calon_karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tahun_daftar` int(11) DEFAULT NULL,
  `pendidikan` int(11) NOT NULL,
  `pengalaman_kerja` int(11) NOT NULL,
  `keterampilan_komunikasi` int(11) NOT NULL,
  `problem_solving` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `calon_karyawan`
--

INSERT INTO `calon_karyawan` (`id`, `nama`, `tahun_daftar`, `pendidikan`, `pengalaman_kerja`, `keterampilan_komunikasi`, `problem_solving`) VALUES
(1, 'Budi Santoso', 2024, 4, 5, 5, 4),
(2, 'Siti Aminah', 2024, 3, 4, 4, 3),
(3, 'Agus Wijaya', 2024, 5, 3, 4, 5),
(4, 'Dewi Lestari', 2025, 2, 2, 3, 2),
(5, 'Joko Susilo', 2025, 4, 5, 4, 4),
(6, 'Fitriani', 2025, 3, 3, 3, 3),
(7, 'Rina Rahmawati', 2024, 5, 5, 5, 5),
(8, 'Bayu Perkasa', 2025, 1, 1, 1, 1),
(9, 'Fajar Kurniawan', 2024, 4, 4, 4, 4),
(10, 'Melati Indah', 2025, 3, 2, 3, 3),
(11, 'Rio Pratama', 2025, 5, 5, 5, 5),
(12, 'Andi', 2025, 4, 3, 5, 4),
(13, 'Bunga', 2025, 5, 4, 4, 5),
(14, 'Charlie', 2025, 3, 2, 3, 3),
(15, 'Dina', 2025, 2, 5, 4, 2),
(16, 'Eko', 2025, 1, 1, 2, 1),
(17, 'Fajar', 2025, 3, 4, 3, 4),
(18, 'Gina', 2025, 5, 5, 5, 5),
(19, 'Heri', 2025, 4, 2, 4, 3),
(20, 'Intan', 2025, 2, 3, 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_pencocokan`
--

CREATE TABLE `hasil_pencocokan` (
  `id` int(11) NOT NULL,
  `calon_karyawan_id` int(11) NOT NULL,
  `bidang_id` int(11) NOT NULL,
  `skor_kecocokan` decimal(5,2) NOT NULL,
  `tanggal_pencocokan` datetime DEFAULT current_timestamp(),
  `detail_penjelasan_skor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_pencocokan`
--

INSERT INTO `hasil_pencocokan` (`id`, `calon_karyawan_id`, `bidang_id`, `skor_kecocokan`, `tanggal_pencocokan`, `detail_penjelasan_skor`) VALUES
(1, 1, 1, 100.00, '2025-06-01 19:27:38', '[\"Pendidikan: Kandidat 4, Ideal 4, GAP 0, Skor Konversi 5.00, Bobot 0.3, Skor x Bobot 0.30\", \"Pengalaman Kerja: Kandidat 5, Ideal 5, GAP 0, Skor Konversi 5.00, Bobot 0.3, Skor x Bobot 0.30\", \"Keterampilan Komunikasi: Kandidat 5, Ideal 5, GAP 0, Skor Konversi 5.00, Bobot 0.2, Skor x Bobot 0.20\", \"Problem Solving: Kandidat 4, Ideal 4, GAP 0, Skor Konversi 5.00, Bobot 0.2, Skor x Bobot 0.20\"]'),
(2, 5, 1, 96.00, '2025-06-01 19:27:38', '[\"Pendidikan: Kandidat 4, Ideal 4, GAP 0, Skor Konversi 5.00, Bobot 0.3, Skor x Bobot 0.30\", \"Pengalaman Kerja: Kandidat 5, Ideal 5, GAP 0, Skor Konversi 5.00, Bobot 0.3, Skor x Bobot 0.30\", \"Keterampilan Komunikasi: Kandidat 4, Ideal 5, GAP -1, Skor Konversi 4.00, Bobot 0.2, Skor x Bobot 0.16\", \"Problem Solving: Kandidat 4, Ideal 4, GAP 0, Skor Konversi 5.00, Bobot 0.2, Skor x Bobot 0.20\"]'),
(3, 2, 1, 80.00, '2025-06-01 19:27:38', '[\"Pendidikan: Kandidat 3, Ideal 4, GAP -1, Skor Konversi 4.00, Bobot 0.3, Skor x Bobot 0.24\", \"Pengalaman Kerja: Kandidat 4, Ideal 5, GAP -1, Skor Konversi 4.00, Bobot 0.3, Skor x Bobot 0.24\", \"Keterampilan Komunikasi: Kandidat 4, Ideal 5, GAP -1, Skor Konversi 4.00, Bobot 0.2, Skor x Bobot 0.16\", \"Problem Solving: Kandidat 3, Ideal 4, GAP -1, Skor Konversi 4.00, Bobot 0.2, Skor x Bobot 0.16\"]'),
(4, 3, 1, 74.00, '2025-06-01 19:27:38', '[\"Pendidikan: Kandidat 5, Ideal 4, GAP 1, Skor Konversi 4.00, Bobot 0.3, Skor x Bobot 0.24\", \"Pengalaman Kerja: Kandidat 3, Ideal 5, GAP -2, Skor Konversi 3.00, Bobot 0.3, Skor x Bobot 0.18\", \"Keterampilan Komunikasi: Kandidat 4, Ideal 5, GAP -1, Skor Konversi 4.00, Bobot 0.2, Skor x Bobot 0.16\", \"Problem Solving: Kandidat 5, Ideal 4, GAP 1, Skor Konversi 4.00, Bobot 0.2, Skor x Bobot 0.16\"]'),
(5, 4, 1, 54.00, '2025-06-01 19:27:38', '[\"Pendidikan: Kandidat 2, Ideal 4, GAP -2, Skor Konversi 3.00, Bobot 0.3, Skor x Bobot 0.18\", \"Pengalaman Kerja: Kandidat 2, Ideal 5, GAP -3, Skor Konversi 2.00, Bobot 0.3, Skor x Bobot 0.12\", \"Keterampilan Komunikasi: Kandidat 3, Ideal 5, GAP -2, Skor Konversi 3.00, Bobot 0.2, Skor x Bobot 0.12\", \"Problem Solving: Kandidat 2, Ideal 4, GAP -2, Skor Konversi 3.00, Bobot 0.2, Skor x Bobot 0.12\"]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidat_bidang`
--

CREATE TABLE `kandidat_bidang` (
  `calon_karyawan_id` int(11) NOT NULL,
  `bidang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kandidat_bidang`
--

INSERT INTO `kandidat_bidang` (`calon_karyawan_id`, `bidang_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_foto` int(50) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id_foto`, `gambar`, `img_path`) VALUES
(6, 'utama.png', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_ideal`
--

CREATE TABLE `profil_ideal` (
  `id` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `nilai` int(11) NOT NULL,
  `bidang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_ideal`
--

INSERT INTO `profil_ideal` (`id`, `kriteria`, `nilai`, `bidang_id`) VALUES
(1, 'pendidikan', 4, 1),
(2, 'pengalaman_kerja', 5, 1),
(3, 'keterampilan_komunikasi', 5, 1),
(4, 'problem_solving', 4, 1),
(10, 'pendidikan', 5, 2),
(11, 'pengalaman_kerja', 4, 2),
(12, 'keterampilan_komunikasi', 4, 2),
(13, 'problem_solving', 5, 2),
(18, 'pendidikan', 4, 3),
(19, 'pengalaman_kerja', 5, 3),
(20, 'keterampilan_komunikasi', 5, 3),
(21, 'problem_solving', 5, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id_foto` int(50) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `usaha`
--

CREATE TABLE `usaha` (
  `id_foto` int(50) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','perusahaan','karyawan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nama`, `role`) VALUES
(2, 'sale@gmail.com', '$2y$10$lNEIaFN4PJczHOuKQV0oSuXu1.0SYtJbxx2XqvQXbXix6GLnTZ1.W', 'dafith', 'admin'),
(4, 'dafit@gmail.com', '$2y$10$BbltegyX80wZnEka6FpJw.HJzJEzb4WWpAZft2lvfkcDE.Tf5fK4u', 'dafith', 'perusahaan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_bidang` (`nama_bidang`);

--
-- Indeks untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bobot_kriteria_bidang` (`bidang_id`);

--
-- Indeks untuk tabel `calon_karyawan`
--
ALTER TABLE `calon_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_pencocokan`
--
ALTER TABLE `hasil_pencocokan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calon_karyawan_id` (`calon_karyawan_id`),
  ADD KEY `bidang_id` (`bidang_id`);

--
-- Indeks untuk tabel `kandidat_bidang`
--
ALTER TABLE `kandidat_bidang`
  ADD PRIMARY KEY (`calon_karyawan_id`,`bidang_id`),
  ADD KEY `bidang_id` (`bidang_id`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indeks untuk tabel `profil_ideal`
--
ALTER TABLE `profil_ideal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profil_ideal_bidang` (`bidang_id`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indeks untuk tabel `usaha`
--
ALTER TABLE `usaha`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `calon_karyawan`
--
ALTER TABLE `calon_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `hasil_pencocokan`
--
ALTER TABLE `hasil_pencocokan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_foto` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `profil_ideal`
--
ALTER TABLE `profil_ideal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `id_foto` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `usaha`
--
ALTER TABLE `usaha`
  MODIFY `id_foto` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD CONSTRAINT `fk_bobot_kriteria_bidang` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_pencocokan`
--
ALTER TABLE `hasil_pencocokan`
  ADD CONSTRAINT `hasil_pencocokan_ibfk_1` FOREIGN KEY (`calon_karyawan_id`) REFERENCES `calon_karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_pencocokan_ibfk_2` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kandidat_bidang`
--
ALTER TABLE `kandidat_bidang`
  ADD CONSTRAINT `kandidat_bidang_ibfk_1` FOREIGN KEY (`calon_karyawan_id`) REFERENCES `calon_karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kandidat_bidang_ibfk_2` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_ideal`
--
ALTER TABLE `profil_ideal`
  ADD CONSTRAINT `fk_profil_ideal_bidang` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
