-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 17, 2025 alle 12:37
-- Versione del server: 10.4.22-MariaDB
-- Versione PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i100spettacoli`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `attori`
--

CREATE TABLE `attori` (
  `id_a` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `cod_f` varchar(16) CHARACTER SET utf8mb4 NOT NULL,
  `data_nas` date NOT NULL,
  `n_tel` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `attori`
--

INSERT INTO `attori` (`id_a`, `nome`, `cod_f`, `data_nas`, `n_tel`) VALUES
(1, 'Mario Rossi', 'aaaaaaaaaaaaaaaa', '1994-01-01', 3401627382),
(2, 'Pino Bianchi', 'bbbbbbbbbbbbbbbb', '1990-03-21', 3401627383),
(3, 'Alessio Genovesi', 'cccccccccccccccc', '1998-07-09', 3401627384),
(4, 'Alessandro Cocco', 'ddddddddddddddd', '2002-10-10', 3401627385),
(5, 'Giusy Till', 'eeeeeeeeeeeeeee', '1997-12-09', 3401627386),
(6, 'Archie Baldwin', 'LPSHFZ39M21E885A', '1982-02-12', 3893381791),
(7, 'Monty Green', 'SSSHYV36L11F809B', '1990-08-02', 3944496363),
(8, 'Giuseppe Amato', 'YLDSYA51P57F267A', '1972-12-06', 1586321377),
(9, 'Giulia Giacchi', 'PGSTTS90B23D371P', '1997-10-23', 1874629014);

-- --------------------------------------------------------

--
-- Struttura della tabella `dettagli`
--

CREATE TABLE `dettagli` (
  `id_d` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `id_t` int(11) NOT NULL,
  `id_sp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dettagli`
--

INSERT INTO `dettagli` (`id_d`, `costo`, `data`, `ora`, `id_t`, `id_sp`) VALUES
(8, 6, '2025-11-17', '21:00:00', 2, 1),
(9, 5, '2025-11-17', '22:00:00', 1, 2),
(10, 10, '2025-11-18', '20:00:00', 1, 4),
(11, 12, '2025-11-19', '13:00:00', 2, 5),
(12, 8, '2025-11-20', '19:30:00', 2, 1),
(13, 10, '2025-11-19', '17:00:00', 1, 3),
(14, 7, '2025-11-20', '15:00:00', 2, 5),
(15, 9, '2025-11-21', '14:00:00', 1, 4),
(16, 10, '2025-11-22', '14:30:00', 1, 1),
(18, 5, '2025-11-24', '20:00:00', 2, 2),
(19, 7, '2025-11-24', '20:00:00', 1, 4),
(20, 8, '2025-11-27', '20:30:00', 2, 3),
(21, 10, '2025-11-28', '13:00:00', 2, 3),
(22, 12, '2025-11-25', '12:30:00', 1, 4),
(23, 8, '2025-11-29', '15:00:00', 2, 5),
(25, 12, '2025-11-25', '20:00:00', 1, 5),
(26, 10, '2025-11-26', '22:00:00', 1, 5),
(27, 6, '2025-11-28', '12:00:00', 1, 1),
(28, 8, '2021-06-25', '14:00:00', 2, 3),
(29, 15, '2025-11-29', '19:30:00', 1, 2),
(30, 13, '2025-10-11', '20:00:00', 2, 3),
(31, 12, '2025-10-11', '21:10:00', 1, 1),
(32, 8, '2025-10-10', '18:00:00', 1, 2),
(35, 12, '2022-12-09', '21:30:00', 2, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenota`
--

CREATE TABLE `prenota` (
  `id_p` int(11) NOT NULL,
  `id_d` int(11) NOT NULL,
  `id_s` int(11) NOT NULL,
  `n_posto` varchar(3) CHARACTER SET utf8mb4 NOT NULL,
  `balconata` tinyint(1) NOT NULL,
  `moltiplicatore` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prenota`
--

INSERT INTO `prenota` (`id_p`, `id_d`, `id_s`, `n_posto`, `balconata`, `moltiplicatore`) VALUES
(105, 8, 23, 'A0', 1, 0.25),
(106, 8, 23, 'A1', 1, 0.25),
(107, 13, 23, 'A0', 0, 0.25);

-- --------------------------------------------------------

--
-- Struttura della tabella `recita`
--

CREATE TABLE `recita` (
  `id_r` int(11) NOT NULL,
  `id_a` int(11) NOT NULL,
  `id_sp` int(11) NOT NULL,
  `ruolo` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recita`
--

INSERT INTO `recita` (`id_r`, `id_a`, `id_sp`, `ruolo`) VALUES
(9, 1, 1, 'protagonista'),
(10, 1, 2, 'secondario'),
(11, 1, 3, 'protagonista'),
(12, 2, 5, 'comparsa'),
(13, 3, 1, 'protagonista'),
(14, 3, 5, 'secondario'),
(15, 4, 4, 'protagonista'),
(16, 5, 1, 'secondario'),
(17, 5, 2, 'protagonista'),
(18, 5, 3, 'secondario'),
(19, 5, 5, 'comparsa'),
(20, 6, 5, 'protagonista'),
(21, 7, 1, 'comparsa'),
(22, 7, 5, 'comparsa'),
(23, 7, 4, 'comparsa'),
(24, 8, 5, 'secondario'),
(25, 9, 4, 'protagonista');

-- --------------------------------------------------------

--
-- Struttura della tabella `spettacoli`
--

CREATE TABLE `spettacoli` (
  `id_sp` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `trama` text CHARACTER SET utf8mb4 NOT NULL,
  `autore` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `spettacoli`
--

INSERT INTO `spettacoli` (`id_sp`, `nome`, `trama`, `autore`) VALUES
(1, '6 personaggi in cerca d\'autore', 'Mentre gli attori ed i membri della compagnia si organizzano per la realizzazione della prova, l\'usciere del teatro annuncia al capocomico l\'arrivo di sei personaggi, i quali lo seguiranno con aria smarrita e perplessa, guardandosi intorno.', 'Luigi Pirandello'),
(2, 'La Locandiera', 'La storia si incentra sulle vicende di Mirandolina, un\'attraente e astuta giovane donna che possiede a Firenze una locanda ereditata dal padre e la amministra con l\'aiuto del cameriere Fabrizio.', 'Carlo Goldoni'),
(3, 'Così è (se vi pare)', 'La vita di una tranquilla cittadina di provincia viene scossa dall\'arrivo di un nuovo impiegato, il Signor Ponza, e della suocera, la Signora Frola, scampati ad un terribile terremoto nella Marsica.', 'Luigi Pirandello'),
(4, 'Amleto', 'Nel XVI secolo, sulle torri che cingono Elsinora, capitale della Danimarca, due soldati s\'interrogano sul fantasma che nelle ultime sere sta facendo la sua comparsa, aspettando il cambio di mezzanotte. Al cambio, insieme alla sentinella arriva anche Orazio, amico del principe, chiamato dalla guardia a vigilare sullo strano fenomeno.', 'William Shakespeare'),
(5, 'Morte di un commesso viaggiatore', 'Willy Loman è un commesso viaggiatore di 63 anni, ossessionato dall\'idea del successo e dal perseguimento ad ogni costo della felicità materiale indotti dalla società americana. Nel corso di uno dei suoi viaggi di lavoro, si accorge di non essere più in grado di guidare la sua vettura e rientra a casa disperato, accolto dalla moglie Linda. Biff e Happy, i loro due figli ormai adulti, si trovano a casa quella sera, per incontrarsi dopo anni di lontananza.', 'Arthur Miller');

-- --------------------------------------------------------

--
-- Struttura della tabella `spettatori`
--

CREATE TABLE `spettatori` (
  `id_s` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `cod_f` varchar(16) CHARACTER SET utf8mb4 NOT NULL,
  `data_nas` date NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `spettatori`
--

INSERT INTO `spettatori` (`id_s`, `nome`, `cod_f`, `data_nas`, `email`, `password`) VALUES
(18, 'Alessio Manni', 'KKOPSC71C12C507J', '1998-04-10', 'alessio.manni@gmail.com', '$2y$10$4k10Wu5n/xPlXhl5bsvjkOWVSt0wb/hYrUYpAzWwabegAIhunVX2u'),
(19, 'Armando Zolfo', 'HRYFGV54A26G480C', '1999-12-02', 'armzolf@gmail.com', '$2y$10$ci9PZeLOdFR5oHLDkFHv7efldh/urltqmuHQCvJ4OKKZz6ML7CKoi'),
(21, 'Luca Giordano', 'NZVTVM68B06H104U', '1973-01-01', 'luca.giordano@gmail.com', '$2y$10$sob3yHrUERQ5LRxf6XAuB.XBAzYuX6Z1YCmmV7CvBspUwtqSxnbE6'),
(22, 'Cristian Petrilli', 'PTRCST02P04H501U', '2002-09-04', 'cristianpetrilli404@gmail.com', '$2y$10$KqOmgXWH72vysviQfwGlZOUlxzsgEJPx1DxW5eZL0GBpcYMXKzpGO'),
(23, 'Ginevra Marchetti', 'MRCGVR00D68H501W', '2000-04-28', 'ginevramargm@gmail.com', '$2y$10$/e/CwIll.XFPLp4G4vw0pOYxMpI5HQgSTTGhw2vPzCVTusVvxZhES');

-- --------------------------------------------------------

--
-- Struttura della tabella `teatri`
--

CREATE TABLE `teatri` (
  `id_t` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `citta` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `via` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `n_civico` varchar(255) DEFAULT NULL,
  `orario_apertura` time NOT NULL,
  `orario_chiusura` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `teatri`
--

INSERT INTO `teatri` (`id_t`, `nome`, `citta`, `via`, `n_civico`, `orario_apertura`, `orario_chiusura`) VALUES
(1, 'Eclissi', 'Roma', 'Nazionale', '27', '08:00:00', '24:00:00'),
(2, 'Sisifone', 'Roma', 'Marti', '14', '08:00:00', '22:00:00');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `attori`
--
ALTER TABLE `attori`
  ADD PRIMARY KEY (`id_a`),
  ADD UNIQUE KEY `cod_f` (`cod_f`);

--
-- Indici per le tabelle `dettagli`
--
ALTER TABLE `dettagli`
  ADD PRIMARY KEY (`id_d`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Indici per le tabelle `prenota`
--
ALTER TABLE `prenota`
  ADD PRIMARY KEY (`id_p`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_s` (`id_s`);

--
-- Indici per le tabelle `recita`
--
ALTER TABLE `recita`
  ADD PRIMARY KEY (`id_r`),
  ADD KEY `id_a` (`id_a`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Indici per le tabelle `spettacoli`
--
ALTER TABLE `spettacoli`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indici per le tabelle `spettatori`
--
ALTER TABLE `spettatori`
  ADD PRIMARY KEY (`id_s`),
  ADD UNIQUE KEY `cod_f` (`cod_f`);

--
-- Indici per le tabelle `teatri`
--
ALTER TABLE `teatri`
  ADD PRIMARY KEY (`id_t`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `attori`
--
ALTER TABLE `attori`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `dettagli`
--
ALTER TABLE `dettagli`
  MODIFY `id_d` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `prenota`
--
ALTER TABLE `prenota`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT per la tabella `recita`
--
ALTER TABLE `recita`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `spettacoli`
--
ALTER TABLE `spettacoli`
  MODIFY `id_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `spettatori`
--
ALTER TABLE `spettatori`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `teatri`
--
ALTER TABLE `teatri`
  MODIFY `id_t` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `dettagli`
--
ALTER TABLE `dettagli`
  ADD CONSTRAINT `dettagli_ibfk_1` FOREIGN KEY (`id_sp`) REFERENCES `spettacoli` (`id_sp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dettagli_ibfk_2` FOREIGN KEY (`id_t`) REFERENCES `teatri` (`id_t`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenota`
--
ALTER TABLE `prenota`
  ADD CONSTRAINT `prenota_ibfk_2` FOREIGN KEY (`id_s`) REFERENCES `spettatori` (`id_s`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `prenota_ibfk_3` FOREIGN KEY (`id_d`) REFERENCES `dettagli` (`id_d`);

--
-- Limiti per la tabella `recita`
--
ALTER TABLE `recita`
  ADD CONSTRAINT `recita_ibfk_1` FOREIGN KEY (`id_a`) REFERENCES `attori` (`id_a`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recita_ibfk_2` FOREIGN KEY (`id_sp`) REFERENCES `spettacoli` (`id_sp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
