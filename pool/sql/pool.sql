-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 11 Juillet 2016 à 23:12
-- Version du serveur :  5.5.44-0+deb8u1
-- Version de PHP :  5.6.22-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pool`
--
CREATE DATABASE IF NOT EXISTS `pool` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pool`;

-- --------------------------------------------------------

--
-- Structure de la table `measures`
--

DROP TABLE IF EXISTS `measures`;
CREATE TABLE IF NOT EXISTS `measures` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orp` smallint(6) NOT NULL,
  `ph` float NOT NULL,
  `temperature` smallint(6) NOT NULL,
  `pump` tinyint(4) NOT NULL,
  `treatment1` tinyint(4) NOT NULL,
  `treatment2` tinyint(4) NOT NULL,
  `pac` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `measures`
--

INSERT INTO `measures` (`id`, `timestamp`, `orp`, `ph`, `temperature`, `pump`, `treatment1`, `treatment2`, `pac`) VALUES
(4, '2016-06-23 13:55:00', 646, 5.89, 31, 0, 0, 0, 0),
(5, '2016-06-23 13:55:57', 646, 5.95, -2, 0, 0, 0, 0),
(6, '2016-06-23 13:56:26', 646, 5.91, 21, 0, 0, 0, 0),
(7, '2016-06-23 13:56:50', 646, 5.92, 27, 0, 0, 0, 0),
(8, '2016-06-23 13:57:11', 646, 5.93, 11, 0, 0, 0, 0),
(9, '2016-06-23 14:17:19', 647, 5.71, 19, 0, 0, 0, 0),
(10, '2016-06-23 14:56:56', 646, 5.95, 11, 0, 0, 0, 0),
(11, '2016-06-23 19:55:48', 646, 5.97, 3, 1, 1, 0, 0),
(12, '2016-06-23 14:59:19', 646, 5.97, 26, 0, 0, 0, 0),
(13, '2016-06-23 14:59:38', 646, 5.98, 6, 0, 0, 0, 0),
(14, '2016-06-23 15:00:02', 646, 5.91, 1, 0, 0, 0, 0),
(15, '2016-06-23 15:01:12', 646, 5.88, 18, 0, 0, 0, 0),
(16, '2016-06-23 15:01:32', 646, 5.93, -4, 0, 0, 0, 0),
(17, '2016-06-23 15:04:54', 646, 5.92, 12, 0, 0, 0, 0),
(18, '2016-06-23 15:17:17', 646, 5.92, 6, 0, 0, 0, 0),
(19, '2016-06-23 15:44:59', 646, 5.57, -3, 0, 0, 0, 0),
(20, '2016-06-23 16:17:17', 646, 6.01, 21, 0, 0, 0, 0),
(21, '2016-06-23 17:17:17', 647, 5.69, 5, 0, 0, 0, 0),
(22, '2016-06-23 19:55:14', 647, 5.62, 13, 1, 0, 0, 0),
(23, '2016-06-23 19:17:17', 647, 5.96, 12, 0, 0, 0, 0),
(24, '2016-06-23 19:56:29', 646, 5.69, 19, 0, 0, 0, 0),
(28, '2016-06-23 20:14:22', 646, 5.7, 8, 1, 1, 0, 0),
(29, '2016-06-23 20:15:55', 646, 5.63, 8, 0, 0, 0, 0),
(30, '0000-00-00 00:00:00', 646, 5.64, 12, 1, 0, 0, 0),
(31, '2016-06-23 20:18:07', 646, 5.6, 13, 0, 0, 0, 0),
(1, '2016-07-06 12:17:01', 702, 7.1, 26, 0, 1, 0, 0),
(2, '2016-07-06 13:17:01', 749, 7.1, 28, 0, 1, 0, 0),
(3, '2016-07-06 14:17:01', 708, 7, 27, 1, 1, 0, 0),
(4, '2016-07-06 15:17:01', 744, 7.1, 28, 1, 1, 0, 0),
(5, '2016-07-06 16:17:01', 727, 7.3, 26, 1, 1, 0, 0),
(6, '2016-07-06 16:50:42', 715, 7.01, 25, 1, 1, 0, 0),
(7, '2016-07-06 17:17:01', 744, 7.25, 27, 1, 1, 0, 0),
(8, '2016-07-06 18:17:02', 757, 7.06, 28, 1, 1, 0, 0),
(9, '2016-07-06 18:43:16', 636, 8.04, 22, 1, 1, 0, 0),
(10, '2016-07-06 19:17:13', -99, -99, -99, 1, 0, 0, 0),
(11, '2016-07-06 19:22:47', 636, 8.04, 22, 1, 1, 0, 0),
(12, '2016-07-06 20:17:14', 636, 8.09, 22, 0, 1, 0, 0),
(13, '2016-07-06 21:17:14', 635, 8.09, 22, 0, 1, 0, 0),
(14, '2016-07-06 22:17:15', 635, 8.1, 22, 0, 1, 0, 0),
(15, '2016-07-06 23:17:14', 635, 8.09, 22, 0, 1, 0, 0),
(16, '2016-07-07 00:17:14', 635, 8.09, 22, 0, 1, 0, 0),
(17, '2016-07-07 01:17:15', 634, 8.1, 22, 0, 1, 0, 0),
(18, '2016-07-07 02:17:15', 634, 8.09, 22, 0, 1, 0, 0),
(19, '2016-07-07 03:18:18', 633, 8.1, 22, 0, 1, 0, 0),
(20, '2016-07-07 04:17:14', 634, 8.1, 22, 1, 1, 0, 0),
(21, '2016-07-07 05:17:15', 634, 8.1, 22, 1, 1, 0, 0),
(22, '2016-07-07 06:17:15', 633, 8.1, 22, 1, 1, 0, 0),
(23, '2016-07-07 07:17:14', 634, 8.1, 22, 1, 1, 0, 0),
(24, '2016-07-07 08:17:14', 634, 8.1, 22, 1, 1, 0, 0),
(25, '2016-07-07 09:17:14', 634, 8.1, 22, 1, 1, 0, 0),
(26, '2016-07-07 10:17:15', 634, 8.1, 22, 1, 1, 0, 0),
(27, '2016-07-07 11:17:15', 635, 8.1, 22, 1, 1, 0, 0),
(28, '2016-07-07 12:17:14', 634, 8.1, 22, 0, 1, 0, 0),
(29, '2016-07-07 13:17:15', 634, 8.11, 22, 0, 1, 0, 0),
(30, '2016-07-07 14:17:15', 634, 8.1, 22, 0, 1, 0, 0),
(31, '2016-07-07 15:17:14', 634, 8.1, 22, 0, 1, 0, 0),
(32, '2016-07-07 16:17:14', 634, 8.11, 22, 1, 1, 0, 0),
(33, '2016-07-07 17:17:15', 634, 8.11, 22, 1, 1, 0, 0),
(34, '2016-07-07 18:17:15', 634, 8.11, 22, 1, 1, 0, 0),
(35, '2016-07-07 19:17:14', 634, 8.1, 22, 1, 1, 0, 0),
(36, '2016-07-07 20:17:14', 634, 8.1, 22, 0, 1, 0, 0),
(37, '2016-07-07 21:17:15', 633, 8.1, 22, 0, 1, 0, 0),
(38, '2016-07-07 22:17:14', 633, 8.1, 22, 0, 1, 0, 0),
(39, '2016-07-07 23:17:14', 633, 8.1, 22, 0, 1, 0, 0),
(40, '2016-07-08 00:17:15', 633, 8.11, 22, 0, 1, 0, 0),
(41, '2016-07-08 01:17:15', 633, 8.12, 22, 0, 1, 0, 0),
(42, '2016-07-08 02:17:15', 632, 8.12, 22, 0, 1, 0, 0),
(43, '2016-07-08 03:17:14', 633, 8.13, 22, 0, 1, 0, 0),
(44, '2016-07-08 04:17:14', 633, 8.12, 22, 1, 1, 0, 0),
(45, '2016-07-08 05:17:15', 633, 8.12, 22, 1, 1, 0, 0),
(46, '2016-07-08 06:17:15', 632, 8.12, 22, 1, 1, 0, 0),
(47, '2016-07-08 07:17:14', 632, 8.12, 22, 1, 1, 0, 0),
(48, '2016-07-08 08:17:14', 633, 8.12, 22, 1, 1, 0, 0),
(49, '2016-07-08 09:17:14', 632, 8.12, 22, 1, 1, 0, 0),
(50, '2016-07-08 10:17:22', 633, 8.12, -99, 1, 1, 0, 0),
(51, '2016-07-08 11:17:21', 633, 8.12, -99, 1, 0, 0, 0),
(52, '2016-07-08 12:17:21', 633, 8.12, -99, 0, 0, 0, 0),
(53, '2016-07-08 13:17:22', 633, 8.12, -99, 0, 0, 0, 0),
(54, '2016-07-08 14:17:21', 633, 8.12, -99, 1, 1, 0, 0),
(55, '2016-07-08 15:17:03', 638, 8.11, 27, 1, 1, 0, 0),
(56, '2016-07-08 16:17:03', 640, 8.1, 26, 1, 1, 0, 0),
(57, '2016-07-08 17:17:03', 639, 8.16, 26, 1, 1, 0, 0),
(58, '2016-07-08 18:17:03', 635, 8.2, 28, 1, 1, 0, 0),
(59, '2016-07-08 19:17:01', 635, 8.15, 26, 1, 0, 0, 0),
(60, '2016-07-08 20:17:01', 637, 8.16, 28, 1, 1, 0, 0),
(61, '2016-07-08 21:17:01', 640, 8.18, 29, 1, 0, 0, 0),
(62, '2016-07-08 22:06:27', 639, 8.11, 24, 0, 0, 0, 0),
(63, '2016-07-08 22:08:01', 639, 8.1, 24, 0, 0, 0, 0),
(64, '2016-07-08 22:09:23', 640, 8.11, 23, 0, 0, 0, 0),
(65, '2016-07-08 22:10:19', 640, 8.11, 23, 0, 0, 0, 0),
(66, '2016-07-08 22:17:12', 640, 8.11, 23, 0, 0, 0, 0),
(67, '2016-07-08 23:17:13', 641, 8.11, 23, 0, 0, 0, 0),
(68, '2016-07-09 00:17:13', 641, 8.1, 24, 0, 0, 0, 0),
(69, '2016-07-09 01:17:13', 641, 8.09, 24, 0, 0, 0, 0),
(70, '2016-07-09 02:17:12', 642, 8.1, 24, 0, 0, 0, 0),
(71, '2016-07-09 03:17:12', 640, 8.08, 24, 0, 0, 0, 0),
(72, '2016-07-09 04:17:13', 639, 8.05, 24, 1, 0, 0, 0),
(73, '2016-07-09 05:17:13', 637, 8.05, 23, 1, 0, 0, 0),
(74, '2016-07-09 06:17:13', 637, 8.03, 23, 1, 0, 0, 0),
(75, '2016-07-09 07:17:12', 636, 8.02, 23, 1, 0, 0, 0),
(76, '2016-07-09 08:17:13', 635, 7, 23, 1, 0, 0, 0),
(77, '2016-07-09 08:32:49', 635, 6.99, 23, 1, 0, 0, 0),
(78, '2016-07-09 08:35:09', 635, 6.99, 23, 1, 0, 0, 0),
(79, '2016-07-09 08:50:14', 636, 6.98, 23, 1, 1, 0, 0),
(80, '2016-07-09 09:17:15', 635, 6.97, 23, 1, 1, 0, 0),
(81, '2016-07-09 11:17:15', 648, 7.14, 29, 1, 1, 0, 0),
(82, '2016-07-09 12:17:15', 559, 7.02, 33, 1, 1, 0, 0),
(83, '2016-07-09 13:17:13', 604, 7.09, -99, 1, 1, 0, 0),
(84, '2016-07-09 14:17:15', 603, 6.96, 31, 1, 1, 0, 0),
(85, '2016-07-09 15:17:13', 569, -99, 31, 1, 1, 0, 0),
(86, '2016-07-09 16:17:15', 553, 6.55, 31, 1, 1, 0, 0),
(87, '2016-07-09 17:17:15', 529, 6.6, 31, 1, 1, 0, 0),
(88, '2016-07-09 18:17:15', 507, 6.5, 30, 1, 1, 0, 0),
(89, '2016-07-09 19:17:15', 498, 6.38, 30, 1, 1, 0, 0),
(90, '2016-07-09 20:17:15', 482, 6.38, 30, 1, 1, 0, 0),
(91, '2016-07-09 21:17:13', 461, 6.95, 30, 1, 1, 0, 0),
(92, '2016-07-09 22:17:15', 332, 6.44, 30, 1, 1, 0, 0),
(93, '2016-07-09 23:17:15', 328, 6.45, 30, 1, 1, 0, 0),
(94, '2016-07-10 00:17:15', 39, 6.5, 30, 0, 1, 0, 0),
(95, '2016-07-10 01:17:14', 300, 6.36, 30, 0, 1, 0, 0),
(96, '2016-07-10 02:17:14', 318, 6.34, 29, 0, 1, 0, 0),
(97, '2016-07-10 03:17:14', 320, 6.16, 29, 0, 1, 0, 0),
(98, '2016-07-10 04:17:14', 337, 6.1, 29, 0, 1, 0, 0),
(99, '2016-07-10 05:17:15', 350, 5.96, 29, 0, 1, 0, 0),
(100, '2016-07-10 06:17:15', 600, 6.08, 29, 0, 1, 0, 0),
(101, '2016-07-10 07:17:15', 563, 6.24, 30, 0, 1, 0, 0),
(102, '2016-07-10 08:17:15', 543, 6.35, 30, 1, 1, 0, 0),
(103, '2016-07-10 09:17:15', 478, 6.33, 30, 1, 1, 0, 0),
(104, '2016-07-10 09:53:12', 579, 6.33, 30, 1, 1, 0, 0),
(105, '2016-07-10 09:55:39', 578, 6.36, 30, 1, 1, 0, 0),
(106, '2016-07-10 09:59:37', 577, 6.34, 30, 1, 1, 0, 0),
(107, '2016-07-10 10:08:32', 572, 6.3, 30, 1, 1, 0, 0),
(108, '2016-07-10 10:17:14', 567, 6.33, 30, 1, 1, 0, 0),
(109, '2016-07-10 11:17:15', 548, 6.34, 30, 1, 1, 0, 0),
(110, '2016-07-10 12:17:15', 541, 6.36, 31, 1, 1, 0, 0),
(111, '2016-07-10 13:17:15', 542, 6.29, 31, 1, 1, 0, 0),
(112, '2016-07-10 14:17:15', 554, 6.79, 31, 1, 1, 0, 0),
(113, '2016-07-10 15:17:14', 565, 6.63, 31, 1, 1, 0, 0),
(114, '2016-07-10 16:17:13', 574, 6.64, 31, 1, 1, 0, 0),
(115, '2016-07-10 17:17:15', 579, 7.18, 31, 1, 1, 0, 0),
(116, '2016-07-10 18:17:13', 603, 7.13, 31, 1, 1, 0, 0),
(117, '2016-07-10 19:17:13', 632, 6.84, 31, 1, 1, 0, 0),
(118, '2016-07-10 20:17:13', 683, 6.69, 30, 1, 1, 0, 0),
(119, '2016-07-10 21:17:13', 740, 6.69, 30, 1, 1, 0, 0),
(120, '2016-07-10 22:17:15', 740, 6.7, 30, 0, 1, 0, 0),
(121, '2016-07-10 23:17:13', 657, 6.54, 30, 0, 1, 0, 0),
(122, '2016-07-11 00:17:12', 657, 6.53, 30, 0, 1, 0, 0),
(123, '2016-07-11 01:17:13', 659, 6.4, 30, 0, 1, 0, 0),
(124, '2016-07-11 02:17:13', 662, 6.31, 30, 0, 1, 0, 0),
(125, '2016-07-11 03:17:13', 666, 6.2, 30, 0, 1, 0, 0),
(126, '2016-07-11 04:17:13', 670, 6.08, 30, 0, 1, 0, 0),
(127, '2016-07-11 05:17:15', 668, 5.99, 30, 0, 1, 0, 0),
(128, '2016-07-11 06:17:18', 725, 5.99, -99, 1, 0, 0, 0),
(129, '2016-07-11 07:17:13', 733, 6.28, 30, 1, 1, 0, 0),
(130, '2016-07-11 08:17:13', 697, 6.44, 30, 1, 1, 0, 0),
(131, '2016-07-11 09:17:13', 671, 6.53, 30, 1, 1, 0, 0),
(132, '2016-07-11 10:17:13', 654, 6.44, 30, 1, 1, 0, 0),
(133, '2016-07-11 11:17:13', 637, 6.48, 30, 1, 1, 0, 0),
(134, '2016-07-11 12:17:13', 553, 6.46, 30, 1, 1, 0, 0),
(135, '2016-07-11 13:17:13', 542, 6.47, 30, 1, 1, 0, 0),
(136, '2016-07-11 13:53:19', 542, 6.46, 30, 1, 1, 0, 0),
(137, '2016-07-11 14:17:13', 540, 6.45, 30, 1, 1, 0, 0),
(138, '2016-07-11 15:10:25', 542, 6.46, 30, 1, 1, 0, 0),
(139, '2016-07-11 15:17:13', 542, 6.43, 30, 1, 1, 0, 0),
(140, '2016-07-11 16:17:13', 541, 6.46, 30, 1, 1, 0, 0),
(141, '2016-07-11 17:17:13', 540, 6.49, 30, 1, 1, 0, 0),
(142, '2016-07-11 17:31:52', 541, 6.44, 30, 1, 1, 0, 0),
(143, '2016-07-11 18:17:17', 543, 7.03, 30, 1, 1, 0, 0),
(144, '2016-07-11 19:17:15', 545, 6.56, 30, 1, 1, 0, 0),
(145, '2016-07-11 20:17:15', 545, 6.47, 30, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `pumpSchedule`
--

DROP TABLE IF EXISTS `pumpSchedule`;
CREATE TABLE IF NOT EXISTS `pumpSchedule` (
  `timeWindow` varchar(4) NOT NULL,
  `below0` tinyint(1) NOT NULL,
  `0to2` tinyint(1) NOT NULL,
  `2to4` tinyint(1) NOT NULL,
  `4to6` tinyint(1) NOT NULL,
  `6to8` tinyint(1) NOT NULL,
  `8to10` tinyint(1) NOT NULL,
  `10to12` tinyint(1) NOT NULL,
  `12to14` tinyint(1) NOT NULL,
  `14to16` tinyint(1) NOT NULL,
  `16to18` tinyint(1) NOT NULL,
  `18to20` tinyint(1) NOT NULL,
  `20to22` tinyint(1) NOT NULL,
  `22to24` tinyint(1) NOT NULL,
  `24to26` tinyint(1) NOT NULL,
  `26to28` tinyint(1) NOT NULL,
  `above28` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pumpSchedule`
--

INSERT INTO `pumpSchedule` (`timeWindow`, `below0`, `0to2`, `2to4`, `4to6`, `6to8`, `8to10`, `10to12`, `12to14`, `14to16`, `16to18`, `18to20`, `20to22`, `22to24`, `24to26`, `26to28`, `above28`) VALUES
('00h', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
('02h', 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
('04h', 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
('06h', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0),
('08h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
('10h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1),
('12h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
('14h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
('16h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
('18h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
('20h', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
('22h', 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `scripts`
--

DROP TABLE IF EXISTS `scripts`;
CREATE TABLE IF NOT EXISTS `scripts` (
  `id` varchar(255) NOT NULL,
  `xml` text NOT NULL,
  `lua` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `scripts`
--

INSERT INTO `scripts` (`id`, `xml`, `lua`) VALUES
('custom', '&lt;xml xmlns="http://www.w3.org/1999/xhtml"&gt;&lt;block type="variables_set" id="G6ozAE{+%AwhH@Ov.L5N" x="158" y="155"&gt;&lt;field name="VAR"&gt;memoire[2]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="a#w[_Ex8pL??nyuq{l[`"&gt;&lt;field name="TEXT"&gt;{variable ["texte", "accentu&eacute;"], &amp;amp; virgule /@# (qualit&eacute; de l''eau)}&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="C]W?1+4(iqL@J|vFEFQO"&gt;&lt;field name="VAR"&gt;memoire[2]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="GQLZulgQ=#:}7dys!CTJ"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="dynamicData" id="+1{keG/x!8vJb!)47qGx"&gt;&lt;field name="select"&gt;memoire[2]&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="math_number" id="#(N!Nw2WTc]_8QL:e*}2"&gt;&lt;field name="NUM"&gt;999&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="Plh]0hz~jc|w~y`/01K!"&gt;&lt;field name="VAR"&gt;memoire["clef"]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id=";m4[AnwTOA!^%`+D^FUw"&gt;&lt;field name="TEXT"&gt;text&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/xml&gt;', 'memoire[2] = ''{variable ["texte", "accentu&eacute;"], &amp; virgule /@# (qualit&eacute; de l\\''eau)}'';\nmemoire[2] = memoire[2] .. 999;\nmemoire[''clef''] = ''text'';\n'),
('footer', '', '    persistence.store("storage.lua", memoire);\n    return info; \nend'),
('header', '', 'local write, writeIndent, writers, refCount;\n\npersistence =\n{\n	store = function (path, ...)\n		local file, e = io.open(path, "w");\n		if not file then\n			return error(e);\n		end\n		local n = select("#", ...);\n		-- Count references\n		local objRefCount = {}; -- Stores reference that will be exported\n		for i = 1, n do\n			refCount(objRefCount, (select(i,...)));\n		end;\n		-- Export Objects with more than one ref and assign name\n		-- First, create empty tables for each\n		local objRefNames = {};\n		local objRefIdx = 0;\n		file:write("-- Persistent Data\\n");\n		file:write("local multiRefObjects = {\\n");\n		for obj, count in pairs(objRefCount) do\n			if count > 1 then\n				objRefIdx = objRefIdx + 1;\n				objRefNames[obj] = objRefIdx;\n				file:write("{};"); -- table objRefIdx\n			end;\n		end;\n		file:write("\\n} -- multiRefObjects\\n");\n		-- Then fill them (this requires all empty multiRefObjects to exist)\n		for obj, idx in pairs(objRefNames) do\n			for k, v in pairs(obj) do\n				file:write("multiRefObjects["..idx.."][");\n				write(file, k, 0, objRefNames);\n				file:write("] = ");\n				write(file, v, 0, objRefNames);\n				file:write(";\\n");\n			end;\n		end;\n		-- Create the remaining objects\n		for i = 1, n do\n			file:write("local ".."obj"..i.." = ");\n			write(file, (select(i,...)), 0, objRefNames);\n			file:write("\\n");\n		end\n		-- Return them\n		if n > 0 then\n			file:write("return obj1");\n			for i = 2, n do\n				file:write(" ,obj"..i);\n			end;\n			file:write("\\n");\n		else\n			file:write("return\\n");\n		end;\n		if type(path) == "string" then\n			file:close();\n		end;\n	end;\n\n	load = function (path)\n		local f, e;\n		if type(path) == "string" then\n			f, e = loadfile(path);\n		else\n			f, e = path:read(''*a'')\n		end\n		if f then\n			return f();\n		else\n			return nil, e;\n		end;\n	end;\n}\n\n-- Private methods\n\n-- write thing (dispatcher)\nwrite = function (file, item, level, objRefNames)\n	writers[type(item)](file, item, level, objRefNames);\nend;\n\n-- write indent\nwriteIndent = function (file, level)\n	for i = 1, level do\n		file:write("\\t");\n	end;\nend;\n\n-- recursively count references\nrefCount = function (objRefCount, item)\n	-- only count reference types (tables)\n	if type(item) == "table" then\n		-- Increase ref count\n		if objRefCount[item] then\n			objRefCount[item] = objRefCount[item] + 1;\n		else\n			objRefCount[item] = 1;\n			-- If first encounter, traverse\n			for k, v in pairs(item) do\n				refCount(objRefCount, k);\n				refCount(objRefCount, v);\n			end;\n		end;\n	end;\nend;\n\n-- Format items for the purpose of restoring\nwriters = {\n	["nil"] = function (file, item)\n			file:write("nil");\n		end;\n	["number"] = function (file, item)\n			file:write(tostring(item));\n		end;\n	["string"] = function (file, item)\n			file:write(string.format("%q", item));\n		end;\n	["boolean"] = function (file, item)\n			if item then\n				file:write("true");\n			else\n				file:write("false");\n			end\n		end;\n	["table"] = function (file, item, level, objRefNames)\n			local refIdx = objRefNames[item];\n			if refIdx then\n				-- Table with multiple references\n				file:write("multiRefObjects["..refIdx.."]");\n			else\n				-- Single use table\n				file:write("{\\n");\n				for k, v in pairs(item) do\n					writeIndent(file, level+1);\n					file:write("[");\n					write(file, k, level+1, objRefNames);\n					file:write("] = ");\n					write(file, v, level+1, objRefNames);\n					file:write(";\\n");\n				end\n				writeIndent(file, level);\n				file:write("}");\n			end;\n		end;\n	["function"] = function (file, item)\n			-- Does only work for "normal" functions, not those\n			-- with upvalues or c functions\n			local dInfo = debug.getinfo(item, "uS");\n			if dInfo.nups > 0 then\n				file:write("nil --[[functions with upvalue not supported]]");\n			elseif dInfo.what ~= "Lua" then\n				file:write("nil --[[non-lua function not supported]]");\n			else\n				local r, s = pcall(string.dump,item);\n				if r then\n					file:write(string.format("loadstring(%q)", s));\n				else\n					file:write("nil --[[function could not be dumped]]");\n				end\n			end\n		end;\n	["thread"] = function (file, item)\n			file:write("nil --[[thread]]\\n");\n		end;\n	["userdata"] = function (file, item)\n			file:write("nil --[[userdata]]\\n");\n		end;\n}\n\nmemoire = persistence.load("storage.lua");\n\nfunction run()\n    info="OK";'),
('main', '&lt;xml xmlns="http://www.w3.org/1999/xhtml"&gt;&lt;block type="variables_set" id="B]P2Ee!Dy^}mSk2{4g_c" x="97" y="19"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="z`fw9,GRplfJq3]RP[1n"&gt;&lt;mutation items="8"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id=".[#0`r,gC,R%Z9AL,=L_"&gt;&lt;field name="TEXT"&gt;&agrave; &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="dynamicData" id=",GyZ3V:kUp*PQ{U{U3.P"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD2"&gt;&lt;block type="text" id="0?h|VL]K@}g(,4Z3U.cp"&gt;&lt;field name="TEXT"&gt;h, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD3"&gt;&lt;block type="dynamicData" id=".;*aZo7kV0whS@Az0qqU"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD4"&gt;&lt;block type="text" id="b?5B]X2A5NctY=dG}.[;"&gt;&lt;field name="TEXT"&gt;&deg;C, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD5"&gt;&lt;block type="dynamicData" id="DSm?H0yUkLf:d0)PyJ,S"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD6"&gt;&lt;block type="text" id="I(@aL(m0AB!27s^LIPU@"&gt;&lt;field name="TEXT"&gt;mV, Ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD7"&gt;&lt;block type="dynamicData" id="`JLuiip8Dqw?c%rF1A3U"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="l3.rre@Q^6z1I=GspA;|"&gt;&lt;field name="command"&gt;log&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="57#JgVrwyzZcS14VN|x#"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="LqI|ms-G~+.Qbl][H_dU"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="RDsd:z~N}0(~M(x1:pje"&gt;&lt;field name="TEXT"&gt;.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="3Ik/c}U^FvpMc]Mkibb!"&gt;&lt;mutation else="1"&gt;&lt;/mutation&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="1SQ9M646)fK^j2AfYw=n"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="C|CEFM-n?YV)VdsAhnhD"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="ARL:4,dPe=wG7JkrD)Fl"&gt;&lt;field name="NUM"&gt;15&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="math_change" id="wu*^f_G`3]Rtx6]%jmmn"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;value name="DELTA"&gt;&lt;block type="math_number" id="40BWy%+[^,ClPoc@qOwe"&gt;&lt;field name="NUM"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="e-:lXcLj4l.%7RXvPa?0"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="qT!_D`/jq`?T-NiEc~Qp"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="crWc@li`F)^wz`=~RF,g"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="at9|XsjbZ4of9/b2R{VO"&gt;&lt;field name="NUM"&gt;2&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="gNbi)6}glFr~Ezq_bK)g"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="|+M[NUn1gcI=Z?uMA*3G"&gt;&lt;field name="command"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id=".xE0^?7O;kH29[Ux7^84"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="math_number" id="g=X8FaLt.`[XuVT=X,HU"&gt;&lt;field name="NUM"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="XWxd,}I|K]q?TjGboIi5"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="=IOrOn]fl.41s?T%];Ij"&gt;&lt;field name="TEXT"&gt; Traitement arr&ecirc;t&eacute;, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;statement name="ELSE"&gt;&lt;block type="setcommand" id="~jFPwmPFD336^QjLQ-b|"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="PqJa{^qmTRwmC-}-+n!5"&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="mnD*{e!M9CL;Zc5=QN%?"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="C4zLWuKDhVP]sr[rIHZ("&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="Dw6(%U8_f.|M!6U9P1(l"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="9uh?F0.z-k])An)NI6_]"&gt;&lt;field name="NUM"&gt;3&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="math_change" id="%t771mH]Jyw[:!Is-b%j"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;value name="DELTA"&gt;&lt;block type="math_number" id="A%AkdzfqR}c;O4[kT,[5"&gt;&lt;field name="NUM"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="(/,pnN}dji:UxcZ0aLh1"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="XxwFTG|a|3!}pTFt=j5R"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="HAsxsO]!UkE_zQtJrCGT"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="IF|.dL;VO]K?r84XGS^d"&gt;&lt;field name="NUM"&gt;2&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="a^46,4JdO[h%/2e2:8YP"&gt;&lt;field name="command"&gt;filtration&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="bJ:%YR1UIuWaBrREZ2f="&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="hTmgXdr/R^N,KY+L1lPR"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="math_number" id="}:+f/^Z^X7R.nHynV^lG"&gt;&lt;field name="NUM"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="f{~mRB*0?jHa(9/0VmjT"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="P6iQ6aUyk(P]8uv!mI:("&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="bD^uq_O+c%6wIhi:ynAB"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="text" id="DB%z~|zF`2kAAK5r.@_d"&gt;&lt;field name="TEXT"&gt; Attention, risque de gel!  Filtration activ&eacute;e.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="_r31.}Le!r.0w2%l5^j*"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_operation" id="zSce%Cd!m8MJXwk7g}kw"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="3*lww/YRM?wNbof1H/EW"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id=";9T{C=P;N-U%ZXWuKs#2"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="0_gT/T?Hjn9%E+d3`E9_"&gt;&lt;field name="NUM"&gt;7&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id="Z,1FyDzL~NNwvIVTY#xI"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="+lxy:pCGAh=OG)^k5jkK"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id=".UHfCeH=v+2z@3RQ/@^}"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="hDT@4}pEjlG}1{NT3D7#"&gt;&lt;field name="NUM"&gt;8&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id="akeX;TDrVO#5D{rPqv]K"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="N@RTf4~*v+;y/4pr(bl+"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="YqUgqo`j~+bP66:mPUb-"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="xyhIdJ%_8`Oc1f|s:nU-"&gt;&lt;field name="NUM"&gt;550&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_compare" id="9s2z/qOpA}BA6{(-79~j"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="L!^@BmB8.Rwj?k{Ur]UJ"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="APrTG`;s6Ftp#s149J(m"&gt;&lt;field name="NUM"&gt;800&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="jkb654y.12]LPs|)dJeK"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="s-DBqaE!Dp0`T{~0rdY!"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="WP5|8{?i1RsaqUg2^f~g"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="text" id="5Y]v:C;IZ6yeE::JdeK]"&gt;&lt;field name="TEXT"&gt; Attention &agrave; la qualit&eacute; de l''eau.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="S+?;KDoWPw?VS0(l]2h3"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="vQp51%*GJ%n~+%^Fk,/M"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="[~{[S*I5_mhv7[rg*6el"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="eIB3OsrHZZV;t*9)yQ*b"&gt;&lt;field name="NUM"&gt;20&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="f4G(!19%Hf-iT%@`XLd["&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="BJmrnT6?)B;Hy|5hUoI*"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id="5c:O1N-=xEL#vr=RaG_V"&gt;&lt;field name="TEXT"&gt;Rapport journalier: &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="co!ZL}B;fx7eO]-ceQ3o"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="pmJJkuZfv@5+d)4L]R=*"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="zAR=KK3KbZYE3=g,HGX1"&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="*n4agXBBUpv5{D:_qIAq"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="70t)D`K;g4D;i34QY]Jw"&gt;&lt;field name="OP"&gt;NEQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="J!YOTfoyBxTZ00Wj]^Be"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="text" id="L[,ShRbzHR=D#H:9@0CV"&gt;&lt;field name="TEXT"&gt;.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="k.ARgxShZ*Q~A~O1]?OL"&gt;&lt;field name="VAR"&gt;emailNotif&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="n7]D*uzLlo75.i%gW_3J"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="Tg;yCN[ew52xh2%5{!(D"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="B7;X:q}W6*(~Ja20m0b-"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="2}-17)j(5efYt)!%%ZW5"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="q^n1kwocykG3BPm_L)gG"&gt;&lt;field name="VAR"&gt;emailNotif&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="#Fq;5,!LQ_5ta+ZO^Y4R"&gt;&lt;field name="command"&gt;log&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id=".zy[|h3FuT7~a+:%:b6G"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/xml&gt;', 'message = table.concat({''&agrave; '', hour, ''h, '', temperature, ''&deg;C, '', orp, ''mV, Ph'', ph});\nlog((message));\nalarme = ''.'';\nif (temperature) &lt; 15 then\n  memoire[''temperatureFaible''] = memoire[''temperatureFaible''] + 1\n  if (memoire[''temperatureFaible'']) == 2 then\n    set(traitement1,(0));\n    memoire[''temperatureFaible''] = 0;\n    alarme = '' Traitement arr&ecirc;t&eacute;, '';\n  end\n else\n  set(traitement1,(1));\nend\nif (temperature) &lt; 3 then\n  memoire[''gel''] = memoire[''gel''] + 1\n  if (memoire[''gel'']) == 2 then\n    set(filtration,(1));\n    memoire[''gel''] = 0;\n    alarme = alarme .. '' Attention, risque de gel!  Filtration activ&eacute;e.'';\n  end\nend\nif (ph) &lt; 7 or ((ph) &gt; 8 or ((orp) &lt; 550 or (orp) &gt; 800)) then\n  alarme = alarme .. '' Attention &agrave; la qualit&eacute; de l\\''eau.'';\nend\nif (hour) == 20 then\n  rapport = ''Rapport journalier: '' .. message;\n  email((rapport));\nend\nif (alarme) ~= ''.'' then\n  emailNotif = message .. alarme;\n  email((emailNotif));\n  log((alarme));\nend\n');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(40) NOT NULL,
  `value` smallint(6) NOT NULL,
  `userSetting` tinyint(1) NOT NULL,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`id`, `value`, `userSetting`, `description`) VALUES
('actionTable', 1, 0, ''),
('blocklyTable', 0, 0, ''),
('logTable', 1, 0, ''),
('measureIndex', 145, 0, ''),
('Parametres', 1, 0, ''),
('Planificateur', 1, 0, ''),
('scheduler', 1, 1, 'Activation planificateur filtration'),
('sensorTable', 0, 0, '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pumpSchedule`
--
ALTER TABLE `pumpSchedule`
 ADD PRIMARY KEY (`timeWindow`);

--
-- Index pour la table `scripts`
--
ALTER TABLE `scripts`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
