-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: St 22.Máj 2019, 23:46
-- Verzia serveru: 5.7.26-0ubuntu0.18.04.1
-- Verzia PHP: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `final`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passHash` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `admin`
--

INSERT INTO `admin` (`id`, `username`, `passHash`) VALUES
(1, 'admin', '$2y$10$MoJ8b8TKYuMIS7KeF4sHFO8Um.Wj7NxnUZpTDKGANZ8NuoR7ZUldK');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `maily`
--

CREATE TABLE `maily` (
  `id` int(11) NOT NULL,
  `datum_odoslania` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `meno_studenta` varchar(50) NOT NULL,
  `predmet` varchar(50) NOT NULL,
  `id_sablony` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `maily`
--

INSERT INTO `maily` (`id`, `datum_odoslania`, `meno_studenta`, `predmet`, `id_sablony`) VALUES
(1, '2019-05-22 14:53:24', 'Priezvisko1 Meno1', 'Predmet', 1),
(2, '2019-05-22 15:01:45', 'Priezvisko1 Meno1', 'Predmet', 1),
(3, '2019-05-22 15:01:45', 'Priezvisko2 Meno2', 'Predmet', 1),
(4, '2019-05-22 15:01:45', 'Priezvisko3 Meno3', 'Predmet', 1),
(5, '2019-05-22 15:01:45', 'Priezvisko4 Meno4', 'Predmet', 1),
(6, '2019-05-22 18:16:27', 'Priezvisko1 Meno1', 'Predmet', 1),
(7, '2019-05-22 18:16:27', 'Priezvisko2 Meno2', 'Predmet', 1),
(8, '2019-05-22 18:16:27', 'Priezvisko3 Meno3', 'Predmet', 1),
(9, '2019-05-22 18:16:27', 'Priezvisko4 Meno4', 'Predmet', 1),
(10, '2019-05-22 18:17:07', 'Priezvisko1 Meno1', 'Predmet', 1),
(11, '2019-05-22 18:17:17', 'Priezvisko2 Meno2', 'Predmet', 1),
(12, '2019-05-22 18:17:27', 'Priezvisko3 Meno3', 'Predmet', 1),
(13, '2019-05-22 18:17:37', 'Priezvisko4 Meno4', 'Predmet', 1),
(14, '2019-05-22 21:32:02', 'Priezvisko1 Meno1', 'Predmetik', 1),
(15, '2019-05-22 21:32:12', 'Priezvisko2 Meno2', 'Predmetik', 1),
(16, '2019-05-22 21:32:22', 'Priezvisko3 Meno3', 'Predmetik', 1),
(17, '2019-05-22 21:32:32', 'Priezvisko4 Meno4', 'Predmetik', 1),
(18, '2019-05-22 21:36:50', 'Priezvisko1 Meno1', 'Predmet', 1),
(19, '2019-05-22 21:37:00', 'Priezvisko2 Meno2', 'Predmet', 1),
(20, '2019-05-22 21:37:10', 'Priezvisko3 Meno3', 'Predmet', 1),
(21, '2019-05-22 21:37:20', 'Priezvisko4 Meno4', 'Predmet', 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `studenti`
--

CREATE TABLE `studenti` (
  `ID` int(11) NOT NULL,
  `meno` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `heslo` varchar(20) DEFAULT NULL,
  `tim` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `studenti`
--

INSERT INTO `studenti` (`ID`, `meno`, `mail`, `heslo`, `tim`) VALUES
(10023, 'Harry', 'Potter', '', 1),
(12121, 'Hulk', 'Smash', '', 3),
(12345, 'Priezvisko1 Meno1', 'xpriezvisko1@is.stuba.sk', '', 1),
(14520, 'Priezvisko4 Meno4', 'xpriezvisko4@is.stuba.sk', '', 2),
(14552, 'Priezvisko12 Meno12', 'xpriezvisko12@is.stuba.sk', '', 4),
(23546, 'Priezvisko7 Meno7', 'xpriezvisko7@is.stuba.sk', '', 3),
(33214, 'Priezvisko10 Meno10', 'xpriezvisko10@is.stuba.sk', '', 4),
(42654, 'Priezvisko3 Meno3', 'xpriezvisko3@is.stuba.sk', '', 2),
(45671, 'Gandalf', 'biely', '', 1),
(47521, 'Priezvisko6 Meno6', 'xpriezvisko6@is.stuba.sk', '', 1),
(54782, 'Priezvisko2 Meno2', 'xpriezvisko2@is.stuba.sk', '', 2),
(62145, 'Priezvisko5 Meno5', 'xpriezvisko5@is.stuba.sk', '', 1),
(66666, 'Lucifer', 'heslo', '', 2),
(78210, 'Priezvisko11 Meno11', 'xpriezvisko11@is.stuba.sk', '', 4),
(80035, 'Priezvisko8 Meno8', 'xpriezvisko8@is.stuba.sk', '', 3),
(87968, 'Gabor', 'jelszo', '', 2),
(96530, 'Priezvisko9 Meno9', 'xpriezvisko9@is.stuba.sk', '', 3),
(98989, 'Tony', 'Stark', '', 3);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `u2_2018/2019_predmetik`
--

CREATE TABLE `u2_2018/2019_predmetik` (
  `id` int(10) UNSIGNED NOT NULL,
  `meno` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `tim` int(10) UNSIGNED NOT NULL,
  `body` int(10) UNSIGNED NOT NULL,
  `suhlas` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `hodnoteny` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `u2_2018/2019_predmetik`
--

INSERT INTO `u2_2018/2019_predmetik` (`id`, `meno`, `email`, `heslo`, `tim`, `body`, `suhlas`, `hodnoteny`) VALUES
(10023, 'Harry', 'Potter', '', 1, 15, 'suhlasim', 'hodnoteny'),
(12121, 'Hulk', 'Smash', '', 3, 0, 'nevyjadril', 'nehodnoteny'),
(45671, 'Gandalf', 'biely', '', 1, 0, 'nevyjadril', 'nehodnoteny'),
(66666, 'Lucifer', 'heslo', '', 2, 0, 'nevyjadril', 'nehodnoteny'),
(87968, 'Gabor', 'jelszo', '', 2, 0, 'nevyjadril', 'nehodnoteny'),
(98989, 'Tony', 'Stark', '', 3, 0, 'nevyjadril', 'nehodnoteny');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `u2_2018/2019_predmetik_timy_body`
--

CREATE TABLE `u2_2018/2019_predmetik_timy_body` (
  `tim` int(10) UNSIGNED NOT NULL,
  `body` int(10) UNSIGNED NOT NULL,
  `suhlas` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `u2_2018/2019_predmetik_timy_body`
--

INSERT INTO `u2_2018/2019_predmetik_timy_body` (`tim`, `body`, `suhlas`) VALUES
(1, 150, 'suhlasim'),
(2, 0, 'nevyjadril'),
(3, 0, 'nevyjadril');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `u2_2018/2019_webtech1`
--

CREATE TABLE `u2_2018/2019_webtech1` (
  `id` int(10) UNSIGNED NOT NULL,
  `meno` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `tim` int(10) UNSIGNED NOT NULL,
  `body` int(10) UNSIGNED NOT NULL,
  `suhlas` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `u2_2018/2019_webtech1`
--

INSERT INTO `u2_2018/2019_webtech1` (`id`, `meno`, `email`, `heslo`, `tim`, `body`, `suhlas`) VALUES
(10023, 'Harry', 'Potter', '', 1, 0, 'suhlasim'),
(12121, 'Hulk', 'Smash', '', 3, 0, 'nevyjadril'),
(45671, 'Gandalf', 'biely', '', 1, 0, 'nevyjadril'),
(66666, 'Lucifer', 'heslo', '', 2, 0, 'nevyjadril'),
(80035, 'Tony', 'Stark', '', 3, 0, 'nevyjadril'),
(87968, 'Gabor', 'jelszo', '', 2, 0, 'nevyjadril');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `u2_2018/2019_webtech1_timy_body`
--

CREATE TABLE `u2_2018/2019_webtech1_timy_body` (
  `tim` int(10) UNSIGNED NOT NULL,
  `body` int(10) UNSIGNED NOT NULL,
  `suhlas` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `u2_2018/2019_webtech1_timy_body`
--

INSERT INTO `u2_2018/2019_webtech1_timy_body` (`tim`, `body`, `suhlas`) VALUES
(1, 0, 'nevyjadril'),
(2, 0, 'nevyjadril'),
(3, 0, 'nevyjadril');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Webové_technológie_2`
--

CREATE TABLE `Webové_technológie_2` (
  `skolskyrok` varchar(15) NOT NULL,
  `ID` int(11) NOT NULL,
  `meno` varchar(30) NOT NULL,
  `cv1` varchar(10) DEFAULT NULL,
  `cv2` varchar(10) DEFAULT NULL,
  `cv3` varchar(10) DEFAULT NULL,
  `cv4` varchar(10) DEFAULT NULL,
  `cv5` varchar(10) DEFAULT NULL,
  `cv6` varchar(10) DEFAULT NULL,
  `cv7` varchar(10) DEFAULT NULL,
  `cv8` varchar(10) DEFAULT NULL,
  `cv9` varchar(10) DEFAULT NULL,
  `cv10` varchar(10) DEFAULT NULL,
  `cv11` varchar(10) DEFAULT NULL,
  `Z1` varchar(10) DEFAULT NULL,
  `Z2` varchar(10) DEFAULT NULL,
  `VT` varchar(10) DEFAULT NULL,
  `SKT` varchar(10) DEFAULT NULL,
  `SKP` varchar(10) DEFAULT NULL,
  `Spolu` varchar(10) DEFAULT NULL,
  `Známka` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `Webové_technológie_2`
--

INSERT INTO `Webové_technológie_2` (`skolskyrok`, `ID`, `meno`, `cv1`, `cv2`, `cv3`, `cv4`, `cv5`, `cv6`, `cv7`, `cv8`, `cv9`, `cv10`, `cv11`, `Z1`, `Z2`, `VT`, `SKT`, `SKP`, `Spolu`, `Známka`) VALUES
('2018/2019', 12345, 'Priezvisko1 Meno1', '', '2', '3', '4', '3', '3', '2', '2', '0', '2', '1,25', '6', '6', '8', '14,9', '16', '76,15', 'D'),
('2018/2019', 54782, 'Priezvisko2 Meno2', '3', '2', '4', '3', '3', '2', '2', '2', '3', '2', '2', '10', '7', '8', '20', '14', '87', 'B'),
('2018/2019', 42654, 'Priezvisko3 Meno3', '3', '2', '3', '4', '3', '3', '2', '2', '2', '2', '1,5', '10', '7', '7', '14,5', '24', '90', 'B'),
('2018/2019', 14520, 'Priezvisko4 Meno4', '3', '3', '3', '4', '3', '3', '2', '2', '3', '2', '2', '9', '10', '8', '20', '30', '107', 'A'),
('2018/2019', 62145, 'Priezvisko5 Meno5', '3', '2', '3', '4', '3', '3', '2', '2', '3', '2', '2,5', '6', '6', '8', '19', '18', '86,5', 'B'),
('2018/2019', 47521, 'Priezvisko6 Meno6', '3', '3', '4', '3', '3', '2', '2', '2', '2', '2', '1,5', '10', '10', '7', '17', '28', '99,5', 'A');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `webtech1`
--

CREATE TABLE `webtech1` (
  `skolskyrok` varchar(15) NOT NULL,
  `ID` int(11) NOT NULL,
  `meno` varchar(30) NOT NULL,
  `cv1` varchar(10) DEFAULT NULL,
  `cv2` varchar(10) DEFAULT NULL,
  `cv3` varchar(10) DEFAULT NULL,
  `cv4` varchar(10) DEFAULT NULL,
  `cv5` varchar(10) DEFAULT NULL,
  `cv6` varchar(10) DEFAULT NULL,
  `cv7` varchar(10) DEFAULT NULL,
  `cv8` varchar(10) DEFAULT NULL,
  `cv9` varchar(10) DEFAULT NULL,
  `cv10` varchar(10) DEFAULT NULL,
  `cv11` varchar(10) DEFAULT NULL,
  `Z1` varchar(10) DEFAULT NULL,
  `Z2` varchar(10) DEFAULT NULL,
  `VT` varchar(10) DEFAULT NULL,
  `SKT` varchar(10) DEFAULT NULL,
  `SKP` varchar(10) DEFAULT NULL,
  `Spolu` varchar(10) DEFAULT NULL,
  `Známka` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `webtech1`
--

INSERT INTO `webtech1` (`skolskyrok`, `ID`, `meno`, `cv1`, `cv2`, `cv3`, `cv4`, `cv5`, `cv6`, `cv7`, `cv8`, `cv9`, `cv10`, `cv11`, `Z1`, `Z2`, `VT`, `SKT`, `SKP`, `Spolu`, `Známka`) VALUES
('2018/2019', 14552, 'Priezvisko12 Meno12', '4', '4', '4', '3', '3', '3', '4', '4', '3', '4', '3', '9', '9', '10', '17', '30', '114', 'A'),
('2018/2019', 23546, 'Priezvisko7 Meno7', '3', '4', '3', '4', '2', '3', '2,5', '4', '3,5', '3', '4', '4', '7', '7', '15', '20', '89', 'B'),
('2018/2019', 33214, 'Priezvisko10 Meno10', '3,5', '2', '3', '3', '2', '3', '2', '4', '4', '3', '3', '5', '7', '10', '8', '16', '78,5', 'C'),
('2018/2019', 78210, 'Priezvisko11 Meno11', '3', '4', '4', '4', '3', '4', '3,5', '3', '2', '3', '4', '6', '9', '10', '19', '25', '106,5', 'A'),
('2018/2019', 80035, 'Priezvisko8 Meno8', '4', '3', '4', '3', '3', '4', '3', '4', '2', '4', '3', '9', '8', '9', '18', '24', '105', 'A'),
('2018/2019', 96530, 'Priezvisko9 Meno9', '4', '3', '4', '2', '2', '3,5', '2,5', '2', '3', '2', '4', '4', '5', '7', '16', '22', '86', 'B');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `webtech2`
--

CREATE TABLE `webtech2` (
  `skolskyrok` varchar(15) NOT NULL,
  `ID` int(11) NOT NULL,
  `meno` varchar(30) NOT NULL,
  `cv1` varchar(10) DEFAULT NULL,
  `cv2` varchar(10) DEFAULT NULL,
  `cv3` varchar(10) DEFAULT NULL,
  `cv4` varchar(10) DEFAULT NULL,
  `cv5` varchar(10) DEFAULT NULL,
  `cv6` varchar(10) DEFAULT NULL,
  `cv7` varchar(10) DEFAULT NULL,
  `cv8` varchar(10) DEFAULT NULL,
  `cv9` varchar(10) DEFAULT NULL,
  `cv10` varchar(10) DEFAULT NULL,
  `cv11` varchar(10) DEFAULT NULL,
  `Z1` varchar(10) DEFAULT NULL,
  `Z2` varchar(10) DEFAULT NULL,
  `VT` varchar(10) DEFAULT NULL,
  `SKT` varchar(10) DEFAULT NULL,
  `SKP` varchar(10) DEFAULT NULL,
  `Spolu` varchar(10) DEFAULT NULL,
  `Známka` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `webtech2`
--

INSERT INTO `webtech2` (`skolskyrok`, `ID`, `meno`, `cv1`, `cv2`, `cv3`, `cv4`, `cv5`, `cv6`, `cv7`, `cv8`, `cv9`, `cv10`, `cv11`, `Z1`, `Z2`, `VT`, `SKT`, `SKP`, `Spolu`, `Známka`) VALUES
('2018/2019', 12345, 'Priezvisko1 Meno1', '3', '2', '3', '4', '3', '3', '2', '2', '0', '2', '1,25', '6', '6', '8', '14,9', '16', '76,15', 'D'),
('2018/2019', 42654, 'Priezvisko3 Meno3', '3', '2', '3', '4', '3', '3', '2', '2', '2', '2', '1,5', '10', '7', '7', '14,5', '24', '90', 'B'),
('2018/2019', 47521, 'Priezvisko6 Meno6', '3', '3', '4', '3', '3', '2', '2', '2', '2', '2', '1,5', '10', '10', '7', '17', '28', '99,5', 'A'),
('2018/2019', 54782, 'Priezvisko2 Meno2', '3', '2', '4', '3', '3', '2', '2', '2', '3', '2', '2', '10', '7', '8', '20', '14', '87', 'B'),
('2018/2019', 62145, 'Priezvisko5 Meno5', '3', '2', '3', '4', '3', '3', '2', '2', '3', '2', '2,5', '6', '6', '8', '19', '18', '86,5', 'B'),
('2018/2019', 80035, 'Priezvisko4 Meno4', '3', '3', '3', '4', '3', '3', '2', '2', '3', '2', '2', '9', '10', '8', '20', '30', '107', 'A');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `maily`
--
ALTER TABLE `maily`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pre tabuľku `u2_2018/2019_predmetik`
--
ALTER TABLE `u2_2018/2019_predmetik`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `u2_2018/2019_predmetik_timy_body`
--
ALTER TABLE `u2_2018/2019_predmetik_timy_body`
  ADD PRIMARY KEY (`tim`);

--
-- Indexy pre tabuľku `u2_2018/2019_webtech1`
--
ALTER TABLE `u2_2018/2019_webtech1`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `u2_2018/2019_webtech1_timy_body`
--
ALTER TABLE `u2_2018/2019_webtech1_timy_body`
  ADD PRIMARY KEY (`tim`);

--
-- Indexy pre tabuľku `webtech1`
--
ALTER TABLE `webtech1`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pre tabuľku `webtech2`
--
ALTER TABLE `webtech2`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pre tabuľku `maily`
--
ALTER TABLE `maily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pre tabuľku `u2_2018/2019_predmetik`
--
ALTER TABLE `u2_2018/2019_predmetik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98990;
--
-- AUTO_INCREMENT pre tabuľku `u2_2018/2019_predmetik_timy_body`
--
ALTER TABLE `u2_2018/2019_predmetik_timy_body`
  MODIFY `tim` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pre tabuľku `u2_2018/2019_webtech1`
--
ALTER TABLE `u2_2018/2019_webtech1`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98990;
--
-- AUTO_INCREMENT pre tabuľku `u2_2018/2019_webtech1_timy_body`
--
ALTER TABLE `u2_2018/2019_webtech1_timy_body`
  MODIFY `tim` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
