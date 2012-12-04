-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 08 okt 2012 om 22:47
-- Serverversie: 5.5.16
-- PHP-versie: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databank: `iqc`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `initials` varchar(10) NOT NULL DEFAULT '',
  `phone` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login_level_1` varchar(5) NOT NULL DEFAULT '',
  `login_level_2` varchar(5) NOT NULL DEFAULT '',
  `login_level_3` varchar(5) NOT NULL DEFAULT '',
  `login_level_4` varchar(5) NOT NULL DEFAULT '',
  `login_level_5` varchar(5) NOT NULL DEFAULT '',
  `login` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`pk`, `firstname`, `lastname`, `initials`, `phone`, `email`, `login_level_1`, `login_level_2`, `login_level_3`, `login_level_4`, `login_level_5`, `login`, `password`) VALUES
(3, 'Voor', '8er Naam', '', '', '', 'on', '', '', '', '', 'root', '7df288e512aa7090138f14012e6d3a3a');

