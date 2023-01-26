-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Sty 2023, 19:24
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

--
-- Zrzut danych tabeli `chat`
--

INSERT INTO `chat` (`id`, `username`, `message`, `time`, `edit_time`, `delete_time`) VALUES
(124, 'test', 'Wiadomość testowa', '2023-01-26 18:31:25.340', NULL, NULL),
(125, 'qwerty', 'drugi użytkownik', '2023-01-26 18:31:54.862', NULL, NULL),
(126, 'legion', 'jest nas wielu', '2023-01-26 18:37:12.455', NULL, NULL),
(127, 'Deleted', 'wiadomosc od uzytkownika usunietego', '2023-01-26 18:37:41.855', '2023-01-26 18:37:53.519', NULL);

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
('Deleted', ''),
('legion', '$2y$10$/04K.p5z4ozL7sTd7uhL6OGeoqamCcV1B9Yk4To8NjOZ5Aw5nL6ZK'),
('qwerty', '$2y$10$IzMurAhthJl8P9RyH3TosekHV6eulo0qtAYsQAoUwa2GGeireuEnq'),
('test', '$2y$10$SDYDyqz8aioDFpZIzKRi2Od6.mKGm4PjqvJYGPzsfErT8jBp1TMjO');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
