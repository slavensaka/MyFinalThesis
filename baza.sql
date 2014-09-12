-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Raƒçunalo: localhost
-- Vrijeme generiranja: Ruj 01, 2011 u 10:30 
-- Verzija poslu≈æitelja: 5.5.8
-- PHP verzija: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza podataka: `baza`
--

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_current`
--

CREATE TABLE IF NOT EXISTS `current` (
  `id` int(2) DEFAULT '1',
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Izbacivanje podataka za tablicu `db_cart_current`
--

INSERT INTO `current` (`id`, `email`) VALUES
(1, 'system00@localhost.com');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
  `order_id` int(11) unsigned NOT NULL DEFAULT '0',
  `time` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Izbacivanje podataka za tablicu `db_cart_delivery`
--

INSERT INTO `delivery` (`order_id`, `time`) VALUES
(28, 'Utorak 09:00-11:00 <br><br>Cijena Dostave: 30 kn'),
(29, 'Dostava Postom <br><br>Cijena Dostave: 15 kn'),
(30, 'Utorak 09:00-11:00 <br><br>Cijena Dostave: 30 kn');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL DEFAULT '0',
  `order_date` date NOT NULL DEFAULT '0000-00-00',
  `processed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `open` enum('y','n') NOT NULL DEFAULT 'y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Izbacivanje podataka za tablicu `db_cart_orders`
--

INSERT INTO `orders` (`id`, `customer`, `order_date`, `processed_on`, `open`) VALUES
(28, 1, '2011-09-01', '2011-09-01 22:26:11', 'n'),
(29, 1, '2011-09-01', '2011-09-01 22:28:00', 'n'),
(30, 1, '2011-09-01', '2011-09-01 22:30:19', 'n'),
(32, 1, '2011-09-01', '0000-00-00 00:00:00', 'y');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `order_id` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `kartica` varchar(15) DEFAULT 'NON',
  `broj` int(19) NOT NULL DEFAULT '0',
  `kontr_br` int(4) DEFAULT '0',
  `mjesec_isteka` int(5) NOT NULL DEFAULT '0',
  `godina_isteka` int(5) NOT NULL DEFAULT '0',
  `tip` enum('putem_interneta','putem_preuzimanja') NOT NULL,
  `placanje` varchar(60) NOT NULL DEFAULT 'NON'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Izbacivanje podataka za tablicu `db_cart_payment`
--

INSERT INTO `payment` (`order_id`, `email`, `kartica`, `broj`, `kontr_br`, `mjesec_isteka`, `godina_isteka`, `tip`, `placanje`) VALUES
(28, 'system0@net.hr', 'DINERS', 2147483647, 2323, 3, 13, 'putem_interneta', 'NON'),
(29, 'pero@net.hr', 'NON', 0, 0, 0, 0, 'putem_preuzimanja', 'maestro debitnom karticom jednokratno'),
(30, 'system00@localhost.com', 'DINERS', 2147483647, 4765, 3, 19, 'putem_interneta', 'NON');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_rows`
--

CREATE TABLE IF NOT EXISTS `rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` varchar(20) NOT NULL DEFAULT '0',
  `product_name` varchar(100) NOT NULL DEFAULT '',
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `vat_perc` decimal(3,1) NOT NULL DEFAULT '0.0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Izbacivanje podataka za tablicu `db_cart_rows`
--

INSERT INTO `rows` (`id`, `order_id`, `product_id`, `product_name`, `price`, `vat_perc`, `quantity`) VALUES
(26, 28, '403949', 'The Ocean Of Truth: The Story Of Sir Isaac Newton', 53.45, 0.0, 1),
(27, 29, '403949', 'The Ocean Of Truth: The Story Of Sir Isaac Newton', 53.45, 0.0, 1),
(28, 30, '464334', 'Michael Faraday, Father of Electronics', 51.03, 0.0, 1);

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_shipment`
--

CREATE TABLE IF NOT EXISTS `shipment` (
  `order_id` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `first_name` varchar(10) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Izbacivanje podataka za tablicu `db_cart_shipment`
--

INSERT INTO `shipment` (`order_id`, `username`, `email`, `first_name`, `last_name`) VALUES
(28, 'system0', 'system0@net.hr', 'Slaven', 'Sakacic'),
(29, 'pero', 'pero@net.hr', 'Pero', 'Peric'),
(30, 'system00', 'system00@localhost.com', 'Slaven', 'Sakacic');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `db_cart_stock_article_example`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `art_no` varchar(11) NOT NULL DEFAULT '',
  `art_descr` varchar(200) NOT NULL DEFAULT '',
  `amount` int(11) NOT NULL DEFAULT '0',
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `last_buy` date NOT NULL DEFAULT '0000-00-00',
  `pic` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Izbacivanje podataka za tablicu `db_cart_stock_article_example`
--

INSERT INTO `stock` (`id`, `art_no`, `art_descr`, `amount`, `price`, `last_buy`, `pic`) VALUES
(1, '403949', 'The Ocean Of Truth: The Story Of Sir Isaac Newton', 42, 53.45, '2011-09-01', 'http://uploadpie.com/UVtQm'),
(2, '394599', 'What Do You Care What Other People Think?', 0, 55.70, '2011-09-01', 'http://uploadpie.com/OyLyC'),
(3, '655434', 'The Natural Philosophy of James Clerk Maxwell', 23, 255.16, '2011-09-01', 'http://uploadpie.com/TPhYu'),
(4, '245466', 'Einstein: His Life and Universe', 0, 62.53, '2011-08-30', 'http://uploadpie.com/5vHzp'),
(5, '464334', 'Michael Faraday, Father of Electronics', 4, 51.03, '2011-09-01', 'http://uploadpie.com/63cfH');

-- --------------------------------------------------------

--
-- Tabliƒçna struktura za tablicu `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('member','admin') NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `pass` varbinary(32) DEFAULT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `address` varchar(60) DEFAULT 'NON',
  `postal_code` varchar(60) DEFAULT 'NON',
  `place` varchar(60) DEFAULT 'NON',
  `country` varchar(60) DEFAULT 'NON',
  `order_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Izbacivanje podataka za tablicu `users`
-- Zaporka je 0000sS

INSERT INTO `users` (`id`, `type`, `username`, `email`, `pass`, `first_name`, `last_name`, `address`, `postal_code`, `place`, `country`, `order_id`) VALUES
(31, 'admin', 'pero', 'pero@net.hr', 'gú≤£÷Í Eµ\ZXwùDí∫2ØÕ≈GÖ·∆∆SœH™ùå', 'Pero', 'Peric', 'Cara Hedrijana 54', '31000', 'Osijek', 'Hrvatska', 29),
(32, 'member', 'system00', 'system00@localhost.com', 'gú≤£÷Í Eµ\ZXwùDí∫2ØÕ≈GÖ·∆∆SœH™ùå', 'Slaven', 'Sakacic', 'Cara Hedrijana 54', '31000', 'Osijek', 'Hrvatska', 30);
