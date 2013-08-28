-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 08 okt 2012 om 21:32
-- Serverversie: 5.5.16
-- PHP-versie: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databank: `iqc`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `analysemodule_output`
--

DROP TABLE IF EXISTS `analysemodule_output`;
CREATE TABLE IF NOT EXISTS `analysemodule_output` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(250) NOT NULL,
  `filepath` varchar(250) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `resultaten_boolean`
--

DROP TABLE IF EXISTS `resultaten_boolean`;
CREATE TABLE IF NOT EXISTS `resultaten_boolean` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `gewenste_processen_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) DEFAULT NULL,
  `volgnummer` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `waarde` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `resultaten_char`
--

DROP TABLE IF EXISTS `resultaten_char`;
CREATE TABLE IF NOT EXISTS `resultaten_char` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `gewenste_processen_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) DEFAULT NULL,
  `volgnummer` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `waarde` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------



--
-- Tabelstructuur voor tabel `resultaten_floating`
--

CREATE TABLE IF NOT EXISTS `resultaten_floating` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `gewenste_processen_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) DEFAULT NULL,
  `volgnummer` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `grootheid` varchar(100) DEFAULT NULL,
  `eenheid` varchar(100) DEFAULT NULL,
  `waarde` float DEFAULT NULL,
  `grens_kritisch_onder` float DEFAULT NULL,
  `grens_kritisch_boven` float DEFAULT NULL,
  `grens_acceptabel_onder` float DEFAULT NULL,
  `grens_acceptabel_boven` float DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Tabelstructuur voor tabel `resultaten_object`
--

DROP TABLE IF EXISTS `resultaten_object`;
CREATE TABLE IF NOT EXISTS `resultaten_object` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `gewenste_processen_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) DEFAULT NULL,
  `volgnummer` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `object_naam_pad` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `resultaten_status`
--

CREATE TABLE IF NOT EXISTS `resultaten_status` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `gewenste_processen_fk` int(11) NOT NULL,
  `gebruiker` varchar(30) DEFAULT NULL,
  `omschrijving` varchar(300) DEFAULT NULL,
  `initialen` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden uitgevoerd voor tabel `resultaten_status`
--

-- --------------------------------------------------------


-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `status_omschrijving`
--

DROP TABLE IF EXISTS `status_omschrijving`;
CREATE TABLE IF NOT EXISTS `status_omschrijving` (
  `nummer` int(11) NOT NULL,
  `veld_omschrijving` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `status_omschrijving`
--

LOCK TABLES `status_omschrijving` WRITE;
/*!40000 ALTER TABLE `status_omschrijving` DISABLE KEYS */;
INSERT INTO `status_omschrijving` VALUES (0,'Gewenst'),(1,'Gestart'),(2,'Bezig'),(3,'Afgeronde analyse'),(4,'Importeren'),(5,'Afgerond'),(10,'Error'),(20, 'Verwijderd'),(30, 'Gevalideerd');
/*!40000 ALTER TABLE `status_omschrijving` ENABLE KEYS */;
UNLOCK TABLES;



