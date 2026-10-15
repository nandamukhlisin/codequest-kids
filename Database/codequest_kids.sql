-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Okt 2026 pada 14.03
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
-- Database: `codequest_kids`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `badges`
--
-- Pembuatan: 07 Okt 2026 pada 06.16
-- Pembaruan terakhir: 09 Okt 2026 pada 11.51
--

CREATE TABLE `badges` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL DEFAULT 'badge.png',
  `requirement` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `badges`
--

INSERT INTO `badges` (`id`, `name`, `description`, `icon`, `requirement`, `created_at`) VALUES
(1, 'First Mission', 'Menyelesaikan challenge pertama.', 'star', 'complete_first_challenge', '2026-10-09 11:46:17'),
(2, 'Logic Solver', 'Menyelesaikan 5 puzzle.', 'puzzle', 'complete_5_puzzles', '2026-10-09 11:46:17'),
(3, 'Loop Master', 'Menyelesaikan seluruh challenge Loop.', 'loop', 'complete_all_loop', '2026-10-09 11:46:17'),
(4, 'Consistent Coder', 'Belajar beberapa hari secara berturut-turut.', 'fire', 'login_streak_3', '2026-10-09 11:46:17'),
(5, 'Code Creator', 'Menyelesaikan Mini Project.', 'trophy', 'complete_mini_project', '2026-10-09 11:46:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `challenges`
--
-- Pembuatan: 07 Okt 2026 pada 06.16
-- Pembaruan terakhir: 07 Okt 2026 pada 06.20
--

CREATE TABLE `challenges` (
  `id` int(10) UNSIGNED NOT NULL,
  `level_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `challenge_type` enum('sequence','loop','condition','variable','project') NOT NULL DEFAULT 'sequence',
  `grid_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`grid_data`)),
  `answer_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answer_data`)),
  `hint_1` varchar(255) DEFAULT NULL,
  `hint_2` varchar(255) DEFAULT NULL,
  `hint_3` varchar(255) DEFAULT NULL,
  `xp_reward` int(10) UNSIGNED NOT NULL DEFAULT 50,
  `order_number` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `challenges`
--

INSERT INTO `challenges` (`id`, `level_id`, `title`, `description`, `challenge_type`, `grid_data`, `answer_data`, `hint_1`, `hint_2`, `hint_3`, `xp_reward`, `order_number`, `created_at`) VALUES
(1, 1, 'Langkah Pertama', 'Bantu karakter mencapai bintang dengan menggerakkannya ke depan.', 'sequence', '{\"grid\":5,\"player\":{\"x\":0,\"y\":2},\"goal\":{\"x\":2,\"y\":2},\"obstacles\":[]}', '[\"FORWARD\",\"FORWARD\"]', 'Perhatikan arah tujuan karakter.', 'Karakter harus maju beberapa langkah.', 'Coba gunakan FORWARD dua kali.', 50, 1, '2026-10-07 06:20:09'),
(2, 2, 'Belok Kanan', 'Susun perintah agar karakter sampai ke tujuan dengan satu kali belok.', 'sequence', '{\"grid\":5,\"player\":{\"x\":0,\"y\":0},\"goal\":{\"x\":2,\"y\":2},\"obstacles\":[{\"x\":0,\"y\":1}]}', '[\"FORWARD\",\"FORWARD\",\"RIGHT\",\"FORWARD\",\"FORWARD\"]', 'Ada penghalang di jalur lurus.', 'Karaktermu perlu berbelok.', 'Coba FORWARD dua kali lalu RIGHT.', 80, 1, '2026-10-07 06:20:09'),
(3, 3, 'Ulangi Terus', 'Gunakan REPEAT untuk mengulangi FORWARD tanpa menulisnya berkali-kali.', 'loop', '{\"grid\":6,\"player\":{\"x\":0,\"y\":0},\"goal\":{\"x\":5,\"y\":0},\"obstacles\":[]}', '[\"REPEAT 5 { FORWARD }\"]', 'Jaraknya cukup jauh, bukan?', 'Perintah yang sama diulang terus.', 'Gunakan REPEAT 5 TIMES FORWARD.', 100, 1, '2026-10-07 06:20:09'),
(4, 4, 'Hati-Hati Penghalang', 'Gunakan IF untuk memeriksa apakah jalan terhalang sebelum bergerak.', 'condition', '{\"grid\":5,\"player\":{\"x\":0,\"y\":0},\"goal\":{\"x\":4,\"y\":0},\"obstacles\":[{\"x\":2,\"y\":0}]}', '[\"FORWARD\",\"IF BLOCKED { JUMP }\",\"FORWARD\"]', 'Ada sesuatu di tengah jalan.', 'Karaktermu harus melompati penghalang.', 'Gunakan IF BLOCKED lalu JUMP.', 120, 1, '2026-10-07 06:20:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `challenge_attempts`
--
-- Pembuatan: 07 Okt 2026 pada 06.17
--

CREATE TABLE `challenge_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `challenge_id` int(10) UNSIGNED NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `used_hint` tinyint(1) NOT NULL DEFAULT 0,
  `commands_used` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`commands_used`)),
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `levels`
--
-- Pembuatan: 07 Okt 2026 pada 06.16
-- Pembaruan terakhir: 07 Okt 2026 pada 06.18
--

CREATE TABLE `levels` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `difficulty` enum('easy','medium','hard') NOT NULL DEFAULT 'easy',
  `order_number` int(10) UNSIGNED NOT NULL,
  `xp_reward` int(10) UNSIGNED NOT NULL DEFAULT 50,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `levels`
--

INSERT INTO `levels` (`id`, `title`, `description`, `difficulty`, `order_number`, `xp_reward`, `icon`, `created_at`) VALUES
(1, 'Coding Explorer', 'Pengenalan computational thinking. Belajar bahwa coding adalah kumpulan instruksi berurutan.', 'easy', 1, 50, '??', '2026-10-07 06:18:59'),
(2, 'Sequence', 'Menyusun urutan perintah agar karakter mencapai tujuan.', 'easy', 2, 80, '??', '2026-10-07 06:18:59'),
(3, 'Loop', 'Menggunakan REPEAT untuk mengulang instruksi yang sama.', 'medium', 3, 100, '??', '2026-10-07 06:18:59'),
(4, 'Condition', 'Menggunakan IF untuk mengambil keputusan berdasarkan kondisi.', 'medium', 4, 120, '?', '2026-10-07 06:18:59'),
(5, 'Variable', 'Menggunakan variabel sederhana untuk menyimpan nilai.', 'hard', 5, 150, '??', '2026-10-07 06:18:59'),
(6, 'Mini Project', 'Menggabungkan semua konsep dalam satu mini project.', 'hard', 6, 200, '??', '2026-10-07 06:18:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progress`
--
-- Pembuatan: 07 Okt 2026 pada 06.16
-- Pembaruan terakhir: 09 Okt 2026 pada 11.38
--

CREATE TABLE `progress` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `level_id` int(10) UNSIGNED NOT NULL,
  `status` enum('locked','unlocked','in_progress','completed') NOT NULL DEFAULT 'locked',
  `score` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `progress`
--

INSERT INTO `progress` (`id`, `user_id`, `level_id`, `status`, `score`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'unlocked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24'),
(2, 1, 2, 'locked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24'),
(3, 1, 3, 'locked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24'),
(4, 1, 4, 'locked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24'),
(5, 1, 5, 'locked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24'),
(6, 1, 6, 'locked', 0, NULL, '2026-10-09 11:38:24', '2026-10-09 11:38:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--
-- Pembuatan: 07 Okt 2026 pada 06.16
-- Pembaruan terakhir: 09 Okt 2026 pada 11.38
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.png',
  `xp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `level` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `xp`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Raka', 'avatar_raka.png', 750, 2, '2026-10-09 11:38:24', '2026-10-09 11:38:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_badges`
--
-- Pembuatan: 07 Okt 2026 pada 06.17
--

CREATE TABLE `user_badges` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `badge_id` int(10) UNSIGNED NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_badges_name` (`name`);

--
-- Indeks untuk tabel `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_challenges_level` (`level_id`);

--
-- Indeks untuk tabel `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_attempts_user` (`user_id`),
  ADD KEY `idx_attempts_challenge` (`challenge_id`);

--
-- Indeks untuk tabel `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_levels_order` (`order_number`),
  ADD KEY `idx_levels_difficulty` (`difficulty`);

--
-- Indeks untuk tabel `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_progress_user_level` (`user_id`,`level_id`),
  ADD KEY `fk_progress_level` (`level_id`),
  ADD KEY `idx_progress_status` (`status`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_users_xp` (`xp`);

--
-- Indeks untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_badge` (`user_id`,`badge_id`),
  ADD KEY `fk_user_badges_badge` (`badge_id`),
  ADD KEY `idx_user_badges_user` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `fk_challenges_level` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  ADD CONSTRAINT `fk_attempts_challenge` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attempts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `fk_progress_level` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `fk_user_badges_badge` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_badges_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
