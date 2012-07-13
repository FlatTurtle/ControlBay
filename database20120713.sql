-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 13, 2012 at 06:38 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amadeus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tokens`
--

CREATE TABLE IF NOT EXISTS `admin_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`) VALUES
(1, 'John', 'password'),
(2, 'yeri', 'abc'),
(3, 'flatturtle', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `demo_infoscreens`
--

CREATE TABLE IF NOT EXISTS `demo_infoscreens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `interval` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `demo_infoscreens`
--

INSERT INTO `demo_infoscreens` (`id`, `customer_id`, `title`, `alias`, `logo`, `color`, `lang`, `interval`) VALUES
(10, 1, 'Tour & Taxis', 'f3f39abc089189659ef39e1cee14fb25', 'http://img.flatturtle.com/infoscreen/logos/tourtaxis.png', '#C14032', 'nl', 1500),
(11, 1, 'FlatTurtle', '5ed6ec66679ff43cc1ac8e347831804a', 'http://', '#', 'en', 1500),
(12, 1, 'FlatTurtle', 'd00f80c21e007435e6d05a6b9ef97407', 'http://', '#607E16', 'en', 1500),
(13, 1, 'Lunch Garden', '1fc4a1fb6ddc15fa177e7a8d7b5de2c8', 'http://www.kookeiland.be/Images/Image/Logo%20LG.JPG', '#558b2b', 'en', 1500),
(14, 1, 'FlatTurtle', '8373c1685f1e81bc21b01ecf5d2a96c3', 'http://', '#', 'en', 1500),
(15, 1, 'FlatTurtle', 'baf1b17615276ebad5548acf8f8c899a', 'http://', '#', 'en', 1500),
(16, 1, 'FlatTurtle', 'e01f4534a5a2e4de937cb770539e449e', 'http://', '#', 'en', 1500),
(17, 1, 'FlatTurtle', '6d15ea6db45d447dcc722de321fb639d', 'http://www.rentalvalue.be/layout/www.rentalvalue.be/logo.jpg', '#000000', 'en', 1500),
(18, 1, 'Personal Screen', 'cf4c9650f10e8429a885341fc8f7b5af', 'http://', '#2057A7', 'nl', 1500),
(19, 1, 'FlatTurtle', '60fb04f0c1f21dd40e02e2ff5b3b198b', 'http://', '#', 'en', 1500),
(20, 1, 'FlatTurtle', '74bed79ea50f2f1a475117e6f9dccfa0', 'http://', '#FF0000', 'en', 1500),
(21, 1, 'FlatTurtle', '02b638f718142f899827b57b4661bf0f', 'http://', '#0F0', 'en', 1500),
(22, 1, 'FlatTurtle', 'ed7c193de8d1b87f66b682d92a3490c2', 'http://m4.licdn.com/media/p/3/000/003/264/3de9597.jpg', '#ce0026', 'en', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `infoscreens`
--

CREATE TABLE IF NOT EXISTS `infoscreens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `interval` int(11) NOT NULL DEFAULT '15000',
  `hostname` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `infoscreens`
--

INSERT INTO `infoscreens` (`id`, `customer_id`, `title`, `alias`, `logo`, `color`, `lang`, `interval`, `hostname`, `pincode`) VALUES
(1, 1, 'The Amadeus Square', 'the-amadeus-square', 'templates/default/img/amadeussquare.jpg', '#FB8B1A', 'en', 15000, 'efikamx-561a07', 222222),
(2, 1, 'iRail Liveboards', 'iRail', 'http://npo.irail.be/img/headerlogo.png', '#C70000', 'en', 15000, '', 0),
(3, 1, 'Hogeschool Gent', 'hogent', 'http://sites.google.com/site/thesissvenvdb/_/rsrc/1268125647077/home/logoHogent.jpg?height=105&width=240', '#0075FA', 'nl', 15000, '', 0),
(4, 1, 'IBBT', 'ibbt-zuiderpoort', 'http://www.edingesawards.be/wp-content/uploads/ibbt_logo.gif', '#e9578e', 'en', 15000, '', 0),
(5, 1, 'Universiteit Antwerpen', 'ua-venusstraat', 'http://img.flatturtle.com/infoscreen/logos/ua.jpg', '#7e002f', 'nl', 15000, '', 0),
(6, 1, 'Atlantis Square Access', 'atlantis-access', 'http://img.flatturtle.com/infoscreen/logos/atlantis.png', '#444324', 'en', 15000, 'efikamx-561dcb', 0),
(7, 1, 'LeopoldThree', 'leopold3', 'http://img.flatturtle.com/infoscreen/logos/l3.jpg', '#716F6E', 'en', 15000, '', 0),
(8, 1, 'Newcort', 'newcort', 'http://img.flatturtle.com/infoscreen/logos/newcort.png', '#4F762E', 'en', 15000, 'efikamx-561b94', 0),
(9, 1, 'FlatTurtle Demo', 'demo', 'http://img.flatturtle.com/infoscreen/logos/flatturtle.png', '#2057A7', 'en', 10000, '', 0),
(10, 1, 'KdG (Groenplaats)', 'kdg-groenplaats', 'http://img.flatturtle.com/infoscreen/logos/kdglogo.png', '#26328C', 'nl', 15000, '', 0),
(11, 1, 'BetaGroup Coworking', 'betagroup-coworking', 'http://coworking.betagroup.be/assets/furniture/bgc-logo.gif', '#e6424a', 'en', 15000, '', 0),
(12, 1, 'Royal Center', 'royal-center', 'http://img.flatturtle.com/infoscreen/logos/royalcenter.jpg', '#1477A0', 'en', 15000, 'efikamx-561b5a', 0),
(13, 1, 'Tour & Taxis', 'tourtaxis', 'http://img.flatturtle.com/infoscreen/logos/tourtaxis.png', '#C14032', 'en', 15000, '', 0),
(14, 2, 'yeri', 'test1', 'http://twimg0-a.akamaihd.net/profile_images/1203982716/thumb_large_eRfglXxdkp4ced6a46a8282f4b14000060.png', '#000000', 'en', 150000, 'efikamx-9ba5a6 ', 0),
(15, 3, 'test2', 'test2', 'http://img.flatturtle.com/flatturtle/logo/FlatTurtle-Turtle.png', '#000000', 'en', 2000, 'efikamx-561a64', 0),
(16, 3, 'test3', 'test3', 'http://img.flatturtle.com/flatturtle/logo/FlatTurtle-Turtle.png', '#000000', 'en', 15000, 'efikamx-9ba3da', 0),
(17, 3, 'test4', 'test4', 'http://img.flatturtle.com/flatturtle/logo/FlatTurtle-Turtle.png', '#000000', 'nl', 15000, 'efikamx-9b9833', 0),
(18, 3, 'test5', 'test5', 'http://img.flatturtle.com/flatturtle/logo/FlatTurtle-Turtle.png', '#1477A0', 'fr', 15000, 'efikamx-9b98c6', 0),
(19, 3, 'test6', 'test6', 'http://img.flatturtle.com/flatturtle/logo/FlatTurtle-Turtle.png', '#F0F0F0', 'en', 15000, '', 0),
(20, 2, '#iSoc12', 'isoc12', 'http://blog.irail.be/wp-content/uploads/2012/05/logo_summerofcode_final.png', '#FF0000', 'en', 15000, 'efikamx-9ba51c', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobname` varchar(30) NOT NULL,
  `javascript` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `jobname`, `javascript`) VALUES
(1, 'screen_on', 'try{application.enableScreen(true);}catch(err){}window.location = $("base").attr("href") + infoScreen.alias; '),
(2, 'screen_off', 'try{application.enableScreen(false);}catch(err){}window.location = $("base").attr("href") + infoScreen.alias + "/sleep/";');

-- --------------------------------------------------------

--
-- Table structure for table `jobtab`
--

CREATE TABLE IF NOT EXISTS `jobtab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `infoscreen_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `minutes` varchar(50) NOT NULL,
  `hours` varchar(50) NOT NULL,
  `day_of_month` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `day_of_week` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `infoscreen_id` (`infoscreen_id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `jobtab`
--

INSERT INTO `jobtab` (`id`, `infoscreen_id`, `job_id`, `minutes`, `hours`, `day_of_month`, `month`, `day_of_week`) VALUES
(3, 1, 1, '0', '7', '*', '*', '*'),
(4, 1, 2, '0', '20', '*', '*', '*'),
(5, 6, 1, '0', '7', '*', '*', '*'),
(6, 6, 2, '0', '22', '*', '*', '*'),
(7, 7, 1, '0', '7', '*', '*', '*'),
(8, 7, 2, '0', '19', '*', '*', '*'),
(9, 8, 1, '0', '7', '*', '*', '*'),
(10, 8, 2, '0', '21', '*', '*', '*'),
(11, 12, 1, '45', '7', '*', '*', '*'),
(12, 12, 2, '0', '19', '*', '*', '*'),
(13, 13, 1, '0', '6', '*', '*', '*'),
(14, 13, 2, '0', '0', '*', '*', '*'),
(15, 14, 1, '0', '8', '*', '*', '*'),
(16, 14, 2, '30', '20', '*', '*', '*'),
(17, 15, 1, '23', '5', '*', '*', '*'),
(18, 15, 2, '43', '2', '*', '*', '*'),
(19, 16, 1, '0', '6', '*', '*', '*'),
(20, 16, 2, '30', '0', '*', '*', '*'),
(21, 17, 1, '15', '9', '*', '*', '*'),
(22, 17, 2, '45', '22', '*', '*', '*'),
(23, 18, 1, '0', '6', '*', '*', '*'),
(24, 18, 2, '0', '23', '*', '*', '*'),
(25, 19, 1, '0', '7', '*', '*', '*'),
(26, 19, 2, '0', '23', '*', '*', '*');

-- --------------------------------------------------------

--
-- Table structure for table `public_tokens`
--

CREATE TABLE IF NOT EXISTS `public_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `screen_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `public_tokens`
--

INSERT INTO `public_tokens` (`id`, `ip`, `token`, `expiration`, `user_agent`, `role`, `screen_id`) VALUES
(10, '127.0.0.1', 'a2da0f10bbe1f824fcfaf7980091df37786ed8be', '3000-07-13 18:27:20', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', 'tablet', 1),
(12, '127.0.0.1', '6e8d14364717efe3c4a7c763dfa4fe219eccb189', '3000-07-13 18:30:15', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', 'tablet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `turtles`
--

CREATE TABLE IF NOT EXISTS `turtles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `infoscreen_id` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `order` tinyint(4) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `colspan` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `infoscreen_id` (`infoscreen_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `turtles`
--

INSERT INTO `turtles` (`id`, `infoscreen_id`, `module`, `order`, `group`, `source`, `colspan`) VALUES
(1, 1, 'airport', 3, '3', '', 1),
(2, 1, 'nmbs', 1, '1', '', 1),
(3, 1, 'map', 2, '3', '', 1),
(4, 2, 'nmbs', 0, '1', '', 2),
(5, 2, 'nmbs', 0, '1', '', 2),
(6, 2, 'nmbs', 0, '1', '', 1),
(7, 2, 'nmbs', 0, '2', '', 2),
(8, 2, 'nmbs', 0, '2', '', 2),
(9, 2, 'map', 0, '3', '', 1),
(10, 2, 'twitter', 0, '3', '', 1),
(11, 3, 'nmbs', 0, '', '', 2),
(12, 3, 'map', 0, '2', '', 2),
(13, 4, 'nmbs', 0, '1', '', 2),
(14, 4, 'nmbs', 0, '1', NULL, 2),
(15, 4, 'map', 0, '2', '', 2),
(16, 5, 'nmbs', 0, '1', '', 2),
(17, 5, 'nmbs', 0, '1', '', 2),
(18, 5, 'map', 0, '2', '', 2),
(19, 1, 'nmbs', 1, '2', '', 1),
(20, 5, 'twitter', 0, '2', '', 2),
(21, 4, 'twitter', 0, '2', '', 2),
(22, 3, 'twitter', 0, '2', '', 2),
(23, 6, 'nmbs', 1, '1', NULL, 1),
(24, 6, 'map', 2, '3', NULL, 1),
(25, 7, 'nmbs', 2, '2', NULL, 1),
(26, 7, 'map', 1, '1', NULL, 1),
(27, 8, 'nmbs', 1, '1', NULL, 1),
(28, 8, 'map', 3, '3', NULL, 1),
(29, 6, 'airport', 2, '3', NULL, 1),
(30, 7, 'airport', 3, '3', NULL, 1),
(32, 9, 'nmbs', 1, '1', NULL, 1),
(33, 9, 'nmbs', 1, '1', NULL, 1),
(34, 9, 'nmbs', 1, '1', NULL, 1),
(41, 9, 'map', 3, '3', NULL, 1),
(42, 9, 'airport', 2, '2', NULL, 1),
(43, 9, 'twitter', 3, '3', NULL, 1),
(44, 9, 'mivbstib', 2, '2', NULL, 1),
(45, 10, 'nmbs', 0, '1', NULL, 1),
(46, 10, 'map', 0, NULL, NULL, 1),
(47, 10, 'twitter', 0, NULL, NULL, 1),
(48, 10, 'nmbs', 0, '1', NULL, 1),
(49, 6, 'nmbs', 1, '2', '', 1),
(50, 11, 'nmbs', 1, '1', NULL, 1),
(51, 11, 'nmbs', 1, '1', NULL, 1),
(52, 11, 'map', 2, '2', NULL, 1),
(53, 8, 'nmbs', 2, '2', NULL, 1),
(54, 12, 'nmbs', 0, '1', NULL, 1),
(55, 12, 'nmbs', 1, '2', NULL, 1),
(56, 12, 'map', 2, '3', NULL, 1),
(58, 13, 'nmbs', 1, '1', NULL, 1),
(59, 13, 'mivbstib', 1, '2', NULL, 1),
(63, 13, 'ttshuttles', 2, '1', NULL, 1),
(66, 6, 'mivbstib', 2, '1', NULL, 1),
(67, 1, 'mivbstib', 2, '2', NULL, 0),
(68, 1, 'delijn', 2, '1', NULL, 0),
(69, 7, 'mivbstib', 3, '3', NULL, 1),
(70, 8, 'mivbstib', 1, '1', NULL, 1),
(71, 8, 'mivbstib', 2, '2', NULL, 1),
(72, 12, 'mivbstib', 1, '2', NULL, 1),
(73, 12, 'mivbstib', 2, '3', NULL, 1),
(74, 12, 'delijn', 0, '1', NULL, 1),
(75, 6, 'delijn', 2, '2', '', 1),
(76, 13, 'map', 2, '2', NULL, 1),
(77, 14, 'map', 1, '1', NULL, 1),
(78, 15, 'mivbstib', 1, '1', NULL, 1),
(79, 15, 'delijn', 2, '1', NULL, 1),
(80, 16, 'airport', 1, '1', NULL, 1),
(81, 16, 'airport', 2, '1', NULL, 1),
(82, 17, 'nmbs', 1, '1', NULL, 1),
(83, 17, 'nmbs', 2, '1', NULL, 1),
(84, 17, 'nmbs', 1, '2', NULL, 1),
(85, 17, 'nmbs', 2, '2', NULL, 1),
(86, 18, 'twitter', 1, '1', NULL, 1),
(87, 18, 'ttshuttles', 1, '2', NULL, 1),
(88, 20, 'twitter', 0, '0', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `turtle_options`
--

CREATE TABLE IF NOT EXISTS `turtle_options` (
  `turtle_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`turtle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `turtle_options`
--

INSERT INTO `turtle_options` (`turtle_id`, `key`, `value`) VALUES
(1, 'location', 'BRU'),
(2, 'location', 'Vorst Zuid'),
(3, 'location', 'Mozartlaan 8, Drogenbos'),
(4, 'location', 'Gent Sint Pieters'),
(5, 'location', 'Brussel Zuid'),
(6, 'location', 'Luik Guillemins'),
(7, 'location', 'Gent Dampooort'),
(8, 'location', 'Antwerpen Centraal'),
(9, 'location', 'Brugge'),
(10, 'hashtag', 'iRail'),
(11, 'location', 'Gent Sint Pieters'),
(12, 'location', 'Gent station Gent Sint Pieters'),
(13, 'location', 'Gent Sint Pieters'),
(14, 'location', 'Gentbrugge'),
(15, 'location', 'Gaston Crommenlaan 8 Gent'),
(16, 'location', 'Antwerpen Zuid'),
(17, 'location', 'Antwerpen Centraal'),
(18, 'location', 'Venusstraat 35 Antwerpen'),
(19, 'location', 'Brussels South'),
(20, 'hashtag', 'antwerpen'),
(21, 'hashtag', 'IBBT'),
(22, 'hashtag', 'hogent'),
(23, 'location', 'St Agatha Berchem'),
(24, 'location', 'Keizer Karellaan 586, Sint-Agatha-Berchem'),
(25, 'location', 'Evere'),
(26, 'location', 'Avenue des Olympiades 2, Brussels'),
(27, 'location', 'Brussels Schuman '),
(28, 'location', 'Kortenberglaan 172-182, Brussels'),
(29, 'location', 'BRU'),
(30, 'location', 'BRU'),
(32, 'location', 'Brussels Noord'),
(33, 'location', 'Brussels Central'),
(34, 'location', 'Brussels South'),
(41, 'location', 'Avenue du Port 83c, Brussels'),
(42, 'location', 'BRU'),
(43, 'hashtag', 'BrusselsAirport'),
(44, 'location', '7214'),
(45, 'location', 'Antwerpen Centraal'),
(46, 'location', 'Nationalestraat 5, Antwerpen'),
(47, 'hashtag', 'kdghogeschool'),
(48, 'location', 'Antwerpen Berchem'),
(49, 'location', 'Brussel Noord'),
(50, 'location', 'Etterbeek'),
(51, 'location', 'Merode'),
(52, 'location', 'Witte Patersstraat 4, 1040 Brussel'),
(53, 'location', 'Brussels South'),
(54, 'location', 'Brussels Noord'),
(55, 'location', 'Brussels Congres'),
(56, 'location', 'Rue Royale 180, Brussels'),
(58, 'location', 'Brussels Noord'),
(59, 'location', 'TOUR ET TAXIS'),
(66, 'location', 'BERCHEM STATION'),
(67, 'location', 'MOZART'),
(68, 'location', 'Drogenbos Mozart'),
(69, 'location', 'PERMEKE'),
(70, 'location', 'GUEUX'),
(71, 'location', 'DE JAMBLINNE DE MEUX'),
(72, 'location', 'CONGRES'),
(73, 'location', 'BOTANIQUE'),
(74, 'location', 'Sint-Joost-ten-Node Kruidtuin'),
(75, 'location', 'Sint-Agatha-Berchem Shopping'),
(76, 'location', 'Havenlaan 83c, Brussels'),
(77, 'location', 'Borgtstraat 319, Grimbergen'),
(78, 'location', 'VILVORDE STATION'),
(79, 'location', 'Grimbergen Oude Schapenbaan'),
(80, 'location', 'BRU'),
(81, 'location', 'JFK'),
(82, 'location', 'Brussels South'),
(83, 'location', 'Antwerpen Centraal'),
(84, 'location', 'Vilvoorde'),
(85, 'location', 'Harelbeke'),
(86, 'hashtag', 'iRail'),
(88, 'hashtag', 'iSoc12');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `infoscreens`
--
ALTER TABLE `infoscreens`
  ADD CONSTRAINT `infoscreens_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `turtles`
--
ALTER TABLE `turtles`
  ADD CONSTRAINT `turtles_ibfk_1` FOREIGN KEY (`infoscreen_id`) REFERENCES `infoscreens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `turtle_options`
--
ALTER TABLE `turtle_options`
  ADD CONSTRAINT `turtle_options_ibfk_1` FOREIGN KEY (`turtle_id`) REFERENCES `turtles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
