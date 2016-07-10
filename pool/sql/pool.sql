-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 10 Juillet 2016 à 18:50
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
(114, '2016-07-10 16:17:13', 574, 6.64, 31, 1, 1, 0, 0);

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
('custom', '<xml xmlns="http://www.w3.org/1999/xhtml"></xml>', ''),
('footer', '', 'return info; end'),
('header', '', 'function run() info="OK"; '),
('main', '&lt;xml xmlns="http://www.w3.org/1999/xhtml"&gt;&lt;block type="variables_set" id="jY:!^3yiee)o}7^DfSAp" x="418" y="-4"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="c~g]]Db=UXO)3A7_#8[8"&gt;&lt;mutation items="9"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id=".VXRW`62fto/|+=}(Wu+"&gt;&lt;field name="TEXT"&gt;&agrave; &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="sensors" id="qym1QNtyFq1-l61)ki)8"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD2"&gt;&lt;block type="text" id="9/,|eg5p2CF)38-@./lq"&gt;&lt;field name="TEXT"&gt;h: &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD3"&gt;&lt;block type="sensors" id="FAy}k/]=ssdbwkN@0LHY"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD4"&gt;&lt;block type="text" id="pk)#5r,O#7B%m^,X!7KT"&gt;&lt;field name="TEXT"&gt;&deg;C, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD5"&gt;&lt;block type="sensors" id="h6^)S=`4-QaI_19#7%xd"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD6"&gt;&lt;block type="text" id="bt7jS/aD7VV`)jn54ni]"&gt;&lt;field name="TEXT"&gt;mV, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD7"&gt;&lt;block type="sensors" id="}|`-dUzz|dvh(@G5DJ(+"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD8"&gt;&lt;block type="text" id="qkdL~XO@]AyiW=i7L|,r"&gt;&lt;field name="TEXT"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="hIyt~2Xcv4#yOS5B!FA+"&gt;&lt;field name="command"&gt;log&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="6y8*ewoPhvnF+F=Z!MG8"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="#k:`8J.D:{zzYDg00AnU"&gt;&lt;mutation else="1"&gt;&lt;/mutation&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="-92_1,Ve7hB!5Q.,VRKh"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="#lk|+Xd;OpMg*=]))P}s"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="wNzqwnx3yZzR=IGMAM1*"&gt;&lt;field name="NUM"&gt;15&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="bh90jirdqe!b.NXEf9?B"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="UIbvnLJ%MRvmz07jC%pw"&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/statement&gt;&lt;statement name="ELSE"&gt;&lt;block type="setcommand" id="vS)XM{CBv-mU`0!/-8F4"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="|w)GYCD:osMFOL3F9G=C"&gt;&lt;field name="command"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="44|aE{OfjqsXCMC3o5UM"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="KjF9P1Co;_i8%[Y]T53="&gt;&lt;field name="TEXT"&gt;Temp&eacute;rature &amp;lt; 15&deg;C, arr&ecirc;t traitement&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="#18WYQnjSO^%Lr6jseue"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="jhC6{#V2uAIeI9d.vI!,"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="DOl(wAWQ#X4?}_f74vZ["&gt;&lt;value name="IF0"&gt;&lt;block type="logic_operation" id="#o2|]hRh|)ncNc+MA1UC"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="PD*bjWOdUp+9fn(BQou+"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="~3za/PloqRw^2e9}uNP4"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="Bq~T:ub^5T,1YPrEZFBd"&gt;&lt;field name="NUM"&gt;6&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id=")CDz5U49X8D%8YNB^Ftn"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="^KxrePY3{DUxXSKNyW{t"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id=";Ftq0R#UD.f20job3/IA"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="sNIxG1uCF=^!=s!Z~L@]"&gt;&lt;field name="NUM"&gt;7.5&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id="Uy/uU#s%7E~X*kH?%_!}"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="0dDMb}.cvU^s-U~Z=Z#~"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="6;A=kCyO.-Nf=,@BdFuD"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="T8[J%(JN9bxp%*h1*W;i"&gt;&lt;field name="NUM"&gt;500&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_compare" id="XV~119R/7Tf8y@2H9,*]"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="[Y.;SMeIY:12T`yTH1J@"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="XfE()+3{uaI@LSB%n?M2"&gt;&lt;field name="NUM"&gt;750&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id=")%^:lV(=BzpV`zKv5Sf4"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="FvQFN{3xhnV30LIJ}JND"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id="=nVnL.y=?w@_0kuJv(AX"&gt;&lt;field name="TEXT"&gt;Attention &agrave; la qualit&eacute; de l''eau!&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="!n(_0C7#d;khf|IKkHm("&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="7CzG;3ViN3us3?*-I4^g"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="2df6FW`MoD9)*xmewJ1]"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="L@O,.G:g1Km1n?.5*M~2"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="L6g0s0%I5kGo7riYVL9^"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="NoQkzM05F1YrO!G0[~)W"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="f4Zx#lgj+V-z*6!waF@E"&gt;&lt;field name="NUM"&gt;3&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="AeuLW(A%Was^;U1gi1RY"&gt;&lt;field name="command"&gt;filtration&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="yGaOAP}_x1^6Z87jgg3T"&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="_u/*=*28Tv@^}hXL1M/9"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="?{Ecl`5^@mkp8`O77GNF"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id="0~AEUu#U96DjP^W2H)A)"&gt;&lt;field name="TEXT"&gt;Attention, risque de gel!&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="?|Tj@k#t}RVGwOXnzLXT"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="(C|D{28QzT4EcD5;M8Qk"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="n.1zyh5:U#eeV4f|bo0q"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="k1wWXxX_{{*MLTDa+C{p"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="-w0G;n?]sV)|P.s;l6u3"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="sensors" id="5I-m{D?6s/5*?g@vc69T"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="TK|@*MDQ*80-ne?%((J2"&gt;&lt;field name="NUM"&gt;19&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="*|]HF?T:eDlsjCECn{AK"&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="BF`[Tf/%skJ?qlw0j.nO"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id="D,q!uCMLh4`rFjkN./)j"&gt;&lt;field name="TEXT"&gt;Rapport journalier:&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="1B%=rd!Uh`*^r).7(AsM"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="5nAj[Q;#jKyV,k=iBmxn"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="v~@8;Pf+va@t_=C2m5(:"&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/xml&gt;', 'message = table.concat({''&agrave; '', hour, ''h: '', temperature, ''&deg;C, '', orp, ''mV, '', ph, ''ph''});\nlog(message);\nif (temperature) &gt; 15 then\n  set(traitement1,(1));\n else\n  set(traitement1,(0));\n  alarme = ''Temp&eacute;rature &lt; 15&deg;C, arr&ecirc;t traitement'';\n  email(alarme);\nend\nif (ph) &lt; 6 or ((ph) &gt; 7.5 or ((orp) &lt; 500 or (orp) &gt; 750)) then\n  alarme = ''Attention &agrave; la qualit&eacute; de l\\''eau!'' .. message;\n  email(alarme);\nend\nif (temperature) &lt; 3 then\n  set(filtration,(1));\n  alarme = ''Attention, risque de gel!'' .. message;\n  email(alarme);\nend\nif (hour) == 19 then\n  rapport = ''Rapport journalier:'' .. message;\n  email(rapport);\nend\n');

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
('measureIndex', 114, 0, ''),
('Parametres', 1, 0, ''),
('Planificateur', 1, 0, ''),
('scheduler', 1, 1, 'Activation planificateur filtration'),
('sensorTable', 1, 0, '');

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
