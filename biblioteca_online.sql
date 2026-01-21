-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 21 2026 г., 20:58
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `biblioteca_online`
--

-- --------------------------------------------------------

--
-- Структура таблицы `carti_biblioteca`
--

CREATE TABLE `carti_biblioteca` (
  `id` int(11) NOT NULL,
  `titlu_carte` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `gen_literar` varchar(100) DEFAULT NULL,
  `an_publicare` int(11) DEFAULT NULL,
  `nr_pagini` int(11) DEFAULT NULL,
  `descriere` text DEFAULT NULL,
  `stare_disponibilitate` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `carti_biblioteca`
--

INSERT INTO `carti_biblioteca` (`id`, `titlu_carte`, `autor`, `gen_literar`, `an_publicare`, `nr_pagini`, `descriere`, `stare_disponibilitate`) VALUES
(1, 'Fundatia', 'Isaac Asimov', 'SF', 1951, 255, 'O operă emblematică a științifico-fantasticului.', 0),
(2, '1984', 'George Orwell', 'Dystopian', 1949, 328, 'O distopie clasică despre un stat totalitar.', 1),
(3, 'Războiul Lumilor', 'H.G. Wells', 'SF', 1898, 192, 'O invazie marțiană pe Pământ.', 0),
(4, 'Crima și pedeapsa', 'Feodor Dostoievski', 'Roman psihologic', 1866, 430, 'O profunzimă psihologică a răului și remușcării.', 1),
(5, 'Pădurea norvegiană', 'Haruki Murakami', 'Roman', 1987, 296, 'O călătorie prin memorie și singurătate.', 1),
(6, 'Harry Potter', 'J.K. Rowling', 'Fantasy', 2001, 260, '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nr_telefon` varchar(20) DEFAULT NULL,
  `data_inregistrare` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `prenume`, `email`, `nr_telefon`, `data_inregistrare`) VALUES
(1, 'Popescu', 'Maria', 'maria.popescu@gmail.com', '0712345678', '2024-01-10'),
(2, 'Ionescu', 'Andrei', 'andrei.ionescu@domeniu.md', '0723456789', '2024-01-15'),
(3, 'Mihai', 'Elena', 'elena.mihai@yahoo.com', '0734567890', '2024-01-05'),
(4, 'Radu', 'Alexandru', NULL, '0745678901', '2024-01-20'),
(5, 'Dumitru', 'Ana', 'ana.dumitru@domeniu.md', '0756789012', '2023-12-28'),
(6, 'Gurdis', 'Artemii', 'artiom@gmail.com', '078364758', '2024-05-21');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `carti_biblioteca`
--
ALTER TABLE `carti_biblioteca`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `carti_biblioteca`
--
ALTER TABLE `carti_biblioteca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
