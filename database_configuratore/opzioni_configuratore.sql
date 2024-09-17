-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 14, 2024 alle 19:28
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `configuratore`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `opzioni_configuratore`
--

CREATE TABLE `opzioni_configuratore` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `prezzo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `opzioni_configuratore`
--

INSERT INTO `opzioni_configuratore` (`id`, `categoria`, `descrizione`, `prezzo`) VALUES
(1, 'sedi', '1 sede', 50.00),
(2, 'sedi', ' 2 sede', 100.00),
(3, 'utenti', '1 utente', 20.00),
(4, 'utenti', '5 utenti', 80.00),
(5, 'movimenti', '500 movimenti', 30.00),
(6, 'movimenti', '1000 movimenti', 50.00),
(7, 'movimenti', '5000 movimenti', 100.00),
(8, 'abbonamento', 'Mensile', 0.00),
(9, 'abbonamento', 'Annulale - Sconto 20 €', -20.00);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `opzioni_configuratore`
--
ALTER TABLE `opzioni_configuratore`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `opzioni_configuratore`
--
ALTER TABLE `opzioni_configuratore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
