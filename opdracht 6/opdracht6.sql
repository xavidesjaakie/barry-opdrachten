-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 okt 2025 om 11:09
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opdracht6`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `gebruikersnaam` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `gebruikersnaam`, `password_hash`, `created_at`) VALUES
(1, 'sjaakie', '$2y$10$c5bqlw.1mteQKVTbCWEW5O.hj9VG38HE0sowxOJk321UsTpdV60LK', '2025-09-28 20:57:32'),
(2, 'kaas', '$2y$10$nD4ZdedP9IvesT0MlV40ce3VEJKzmOQLjc1m17dAp/.R3nusuZl6e', '2025-09-28 20:58:29'),
(3, 'test', '$2y$10$ffYPygTD0IzW8Q.LnfMcl.lWeeU8sJWcnPKtIyPZS1jhaMJoSXPTW', '2025-09-28 21:03:07'),
(4, 'yoopie', '$2y$10$OH.LD2fHLDgbf2WJJjOxcetUw3lJs.b88uNx0S99dVvJrijiNaMQC', '2025-09-28 21:05:45'),
(5, 'yoopiee', '$2y$10$ZUvpzvKg0mMHUZe1JLGrVuVeGAxhTWnL0w2VCaer/VlQp4lG9ZKk.', '2025-09-28 21:06:22');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
