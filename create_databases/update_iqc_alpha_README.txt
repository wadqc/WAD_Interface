Bij update handmatig uitvoeren:

0) user iqc heeft permissie nodig voor select in pacsdb
   --> uitvoeren update_iqc_20130604.cmd
1) de regel "extension=php_fileinfo.dll" in php.ini activeren (";" weghalen)
   --> met de hand de file php.ini editen
2) tabel status_omschrijving: toevoegen nieuwe waardes Verwijderd en Gevalideerd
3) nieuwe tabel resultaten_status

voor items 2 en 3 zie SQL fragmenten hieronder


--
-- Dumping data for table `status_omschrijving`
--

LOCK TABLES `status_omschrijving` WRITE;
/*!40000 ALTER TABLE `status_omschrijving` DISABLE KEYS */;
INSERT INTO `status_omschrijving` VALUES (20, 'Verwijderd'),(30, 'Gevalideerd');
/*!40000 ALTER TABLE `status_omschrijving` ENABLE KEYS */;
UNLOCK TABLES;



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


