-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: Út 14.Máj 2019, 15:31
-- Verzia serveru: 5.7.25-0ubuntu0.18.04.2
-- Verzia PHP: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `projekt`
--

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
(12345, 'Priezvisko1 Meno1', 'xpriezvisko1@is.stuba.sk', '', 1),
(12384, 'Priezvisko8 Meno8', 'xpriezvisko8@is.stuba.sk', '', 3),
(14520, 'Priezvisko4 Meno4', 'xpriezvisko4@is.stuba.sk', '', 2),
(14552, 'Priezvisko12 Meno12', 'xpriezvisko12@is.stuba.sk', '', 4),
(23546, 'Priezvisko7 Meno7', 'xpriezvisko7@is.stuba.sk', '', 3),
(33214, 'Priezvisko10 Meno10', 'xpriezvisko10@is.stuba.sk', '', 4),
(42654, 'Priezvisko3 Meno3', 'xpriezvisko3@is.stuba.sk', '', 2),
(47521, 'Priezvisko6 Meno6', 'xpriezvisko6@is.stuba.sk', '', 1),
(54782, 'Priezvisko2 Meno2', 'xpriezvisko2@is.stuba.sk', '', 2),
(62145, 'Priezvisko5 Meno5', 'xpriezvisko5@is.stuba.sk', '', 1),
(78210, 'Priezvisko11 Meno11', 'xpriezvisko11@is.stuba.sk', '', 4),
(96530, 'Priezvisko9 Meno9', 'xpriezvisko9@is.stuba.sk', '', 3);

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
('2018/2019', 12384, 'Priezvisko8 Meno8', '4', '3', '4', '3', '3', '4', '3', '4', '2', '4', '3', '9', '8', '9', '18', '24', '105', 'A'),
('2018/2019', 14552, 'Priezvisko12 Meno12', '4', '4', '4', '3', '3', '3', '4', '4', '3', '4', '3', '9', '9', '10', '17', '30', '114', 'A'),
('2018/2019', 23546, 'Priezvisko7 Meno7', '3', '4', '3', '4', '2', '3', '2,5', '4', '3,5', '3', '4', '4', '7', '7', '15', '20', '89', 'B'),
('2018/2019', 33214, 'Priezvisko10 Meno10', '3,5', '2', '3', '3', '2', '3', '2', '4', '4', '3', '3', '5', '7', '10', '8', '16', '78,5', 'C'),
('2018/2019', 78210, 'Priezvisko11 Meno11', '3', '4', '4', '4', '3', '4', '3,5', '3', '2', '3', '4', '6', '9', '10', '19', '25', '106,5', 'A'),
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
('2018/2019', 14520, 'Priezvisko4 Meno4', '3', '3', '3', '4', '3', '3', '2', '2', '3', '2', '2', '9', '10', '8', '20', '30', '107', 'A'),
('2018/2019', 42654, 'Priezvisko3 Meno3', '3', '2', '3', '4', '3', '3', '2', '2', '2', '2', '1,5', '10', '7', '7', '14,5', '24', '90', 'B'),
('2018/2019', 47521, 'Priezvisko6 Meno6', '3', '3', '4', '3', '3', '2', '2', '2', '2', '2', '1,5', '10', '10', '7', '17', '28', '99,5', 'A'),
('2018/2019', 54782, 'Priezvisko2 Meno2', '3', '2', '4', '3', '3', '2', '2', '2', '3', '2', '2', '10', '7', '8', '20', '14', '87', 'B'),
('2018/2019', 62145, 'Priezvisko5 Meno5', '3', '2', '3', '4', '3', '3', '2', '2', '3', '2', '2,5', '6', '6', '8', '19', '18', '86,5', 'B');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`ID`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
