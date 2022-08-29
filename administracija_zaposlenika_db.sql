-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2022 at 05:25 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administracija_zaposlenika_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(20) COLLATE utf8mb4_croatian_ci NOT NULL,
  `lozinka` varchar(255) COLLATE utf8mb4_croatian_ci NOT NULL,
  `dozvola` varchar(15) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `lozinka`, `dozvola`) VALUES
(1, 'admin', '$2y$10$q9xqFKF/F6xgMZCbbOwz4OaZ8pPHZHJ0/iYq0dbZ8T4IhYR.fw4I2', 'administrator'),
(2, 'pero', '$2y$10$.9WNL8MExLKtColEnrdE7uSAwNWAa9vReunIWjeWklD2dy3aoqE1C', 'editor'),
(3, 'marko', '$2y$10$WOaLEHYLWq1zYvJHDdRO/OinjY5iIXXSfbbTClbSRFnnu3nbGWIpC', 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `poduzeca`
--

CREATE TABLE `poduzeca` (
  `id` int(11) NOT NULL,
  `nazivPoduzeca` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `adresa` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `postBr` int(6) NOT NULL,
  `mjesto` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `kontaktBr` varchar(15) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `poduzeca`
--

INSERT INTO `poduzeca` (`id`, `nazivPoduzeca`, `adresa`, `postBr`, `mjesto`, `kontaktBr`) VALUES
(1, 'LEDO PLUS d.o.o.', 'Čavićeva 1a', 10000, 'ZAGREB', '01 2385 555'),
(2, 'JAMNICA d.d.', 'Getaldićeva 3', 10000, 'ZAGREB', '01 2393 111'),
(3, 'KRAŠ prehrambena industrija d.d.', 'Ravnice 48', 10000, 'ZAGREB', '01 2396 111'),
(4, 'Franck d.d.', 'Prilaz Baruna Filipovića 28', 10000, 'ZAGREB', '01 1622 36'),
(5, 'Zagrebačka banka d.d.', 'Trg bana Josipa Jelačića 10', 10000, 'ZAGREB', '01 3773 333'),
(6, 'Altis d.o.o.', 'Bogovićeva 11', 10000, 'ZAGREB', '01 5432 555'),
(7, 'Remaris', 'Frankopanska 12', 10000, 'ZAGREB', '01 4425 243'),
(8, 'Matino j.d.o.o.', 'Gundulićeva 17', 10000, 'ZAGREB', '01 3555 253'),
(9, 'Batis d.o.o.', 'Draškovićeva 13', 10000, 'ZAGREB', '01 5646 342'),
(10, 'Lapano j.d.o.o.', 'Ilica 252', 10090, 'ZAGREB', '01 9954 222'),
(11, 'Prahir d.o.o.', 'Zagrebačka 57', 10410, 'ZAGREB', '01 622 6536'),
(12, 'Kaufland d.o.o.', 'Avenija Dubrovnik 13', 10040, 'ZAGREB', '01 5546 897'),
(13, 'King ICT d.o.o.', 'Buzinski prilaz 10', 10000, 'BUZIN', '01 9987 514'),
(14, 'Patano d.o.o.', 'Ilica 12', 10000, 'ZAGREB', '01 5235 634'),
(15, 'Majadero j.d.o.o.', 'Gajeva 3', 10000, 'ZAGREB', '01 3525 531'),
(16, 'Buxar d.o.o.', 'Palmotićeva 12', 10000, 'ZAGREB', '01 6436 321');

-- --------------------------------------------------------

--
-- Table structure for table `zaposlenici`
--

CREATE TABLE `zaposlenici` (
  `id` int(11) NOT NULL,
  `ime` varchar(16) COLLATE utf8mb4_croatian_ci NOT NULL,
  `prezime` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `email` varchar(20) COLLATE utf8mb4_croatian_ci NOT NULL,
  `kontaktBr` varchar(15) COLLATE utf8mb4_croatian_ci NOT NULL,
  `poduzeceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zaposlenici`
--

INSERT INTO `zaposlenici` (`id`, `ime`, `prezime`, `email`, `kontaktBr`, `poduzeceId`) VALUES
(1, 'Marina', 'Kovačić', 'marinak@ledo.hr', '0981234567', 1),
(2, 'Ivan', 'Horvat', 'ivanh@ledo.hr', '0982345678', 1),
(3, 'Ana', 'Vuković', 'anav@jamnica.hr', '0983456789', 2),
(4, 'Marko', 'Babić', 'markob@jamnica.hr', '0984567890', 2),
(5, 'Petra', 'Knežević', 'petrak@kras.hr', '0985678901', 3),
(6, 'Luka', 'Novak', 'lukan@kras.hr', '0986789012', 3),
(7, 'Karlo', 'Petrović', 'karlop@altis.hr', '0997894561', 4),
(8, 'Matija', 'Maljević', 'matijam@batis.hr', '098534543', 4),
(9, 'Petar', 'Živković', 'petarz@gmail.com', '0999876541', 5),
(10, 'Bojan', 'Jurić', 'bojan@jamnica.hr', '0986547897', 5),
(11, 'Domagoj', 'Grgić', 'domagojg@jamnica.hr', '0995467897', 6),
(12, 'Zoran', 'Pavlović', 'zoranp@altis.hr', '0951234654', 6),
(13, 'Ivan', 'Pavlović', 'ivanp@kaufland.hr', '098754134', 7),
(14, 'Goran', 'Horvat', 'goranh@remaris.hr', '0986348854', 7),
(15, 'Marija', 'Lac', 'marijal@prahir.hr', '0997645154', 8),
(16, 'Berislav', 'Ivančić', 'berislavi@zaba.hr', '0956478548', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `poduzeca`
--
ALTER TABLE `poduzeca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poduzeceId` (`poduzeceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poduzeca`
--
ALTER TABLE `poduzeca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  ADD CONSTRAINT `fk_poduzeceId` FOREIGN KEY (`poduzeceId`) REFERENCES `poduzeca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
