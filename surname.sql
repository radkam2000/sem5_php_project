-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Sty 2023, 07:23
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `surname`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `time` datetime(3) NOT NULL,
  `edit_time` datetime(3) DEFAULT NULL,
  `delete_time` datetime(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `username` varchar(25) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('as', '$2y$10$zHEu3.YW7huwyuFiDkQlse0HSWYv1eETUy08dEHjPiXDxEy6AdV2y'),
('asdf', '$2y$10$hDodRjahBkwbvDYOfe5OLu39xsFaaKr9dFw5QAQrdcDquEdNgyoSi'),
('qwerty', '$2y$10$Eyr77LZ8bgYalVzy9Ab6fujSCo.imnwDQoLjurrZg5FcolfQ09oGy'),
('qwerty2', '$2y$10$5vk3oKN9LrXaHD1VUt.qlOztlXusrMkHEatBhT55pJY19ydhYST6i'),
('zxc', '$2y$10$8tHVnc9UolB7OCaEZK2EbufozoAuBIrdzB6Mp.ipCa/VrHf1GHmAW'),
('zxcvbnm', '$2y$10$AjniIAkR4Ak.gM//VjsLaewsto3Ehrd.N5JzdFfVMaOPBH99U79vG');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
