-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 15. 12 2015 kl. 10:15:48
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `security`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user` varchar(50) NOT NULL,
  `time_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data dump for tabellen `comments`
--

INSERT INTO `comments` (`id`, `text`, `user`, `time_date`) VALUES
(1, 'Hello\r\n', '', '0000-00-00 00:00:00');
-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `color` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Data dump for tabellen `items`
--

INSERT INTO `items` (`id`, `product`, `price`, `color`) VALUES
(1, 'iphone 3', '99', 'Black'),
(2, 'iphone 3g', '149', 'Black'),
(3, 'iphone 3gs', '199', 'Black'),
(4, 'iphone 4', '249', 'Black'),
(5, 'iphone 4s', '299', 'Black'),
(6, 'iphone 5', '349', 'Black/White'),
(7, 'iphone 5s', '399', 'White/Red/Yellow'),
(8, 'samsung galaxy', '250', 'Black'),
(9, 'HTC magic', '150', 'white');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `Department`, `email`) VALUES
(1, 'Hans', '1234', 'Sales', 'hans@hansen.dk'),
(2, 'Lars', '5678', 'Tech', 'lars@larsen.dk'),
(3, 'Peter', '1111', 'Tech', 'peter@petersen.dk'),
(4, 'Mogens', '9999', 'Sales', 'mogens@mogensen.dk'),
(5, 'Admin', '0000', 'IT', 'admin@admin.dk');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
