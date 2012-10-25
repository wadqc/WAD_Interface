

--
-- Table structure for table `analysemodule_output`
--

DROP TABLE IF EXISTS `analysemodule_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analysemodule_output` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `analysemodule_output_filename` varchar(250) NOT NULL,
  `analysemodule_output_filepath` varchar(250) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `resultaten_boolean`
--

DROP TABLE IF EXISTS `resultaten_boolean`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultaten_boolean` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) NOT NULL,
  `resultaten_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) NOT NULL,
  `waarde` tinyint(1) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `resultaten_char`
--

DROP TABLE IF EXISTS `resultaten_char`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultaten_char` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `resultaten_fk` int(11) NOT NULL,
  `omschrijving` varchar(100) NOT NULL,
  `waarde` varchar(100) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `resultaten_floating`
--

DROP TABLE IF EXISTS `resultaten_floating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultaten_floating` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `resultaten_fk` int(11) NOT NULL,
  `grootheid` varchar(100) NOT NULL,
  `eenheid` varchar(100) NOT NULL,
  `waarde` float NOT NULL,
  `grens_kritisch_onder` float NOT NULL,
  `grens_kritisch_boven` float NOT NULL,
  `grens_acceptabel_onder` float NOT NULL,
  `grens_acceptabel_boven` float NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `resultaten_object`
--

DROP TABLE IF EXISTS `resultaten_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultaten_object` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `resultaten_fk` int(11) NOT NULL,
  `object_naam_pad` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `status_omschrijving`
--

DROP TABLE IF EXISTS `status_omschrijving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_omschrijving` (
  `nummer` int(11) NOT NULL,
  `veld_omschrijving` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_omschrijving`
--

LOCK TABLES `status_omschrijving` WRITE;
/*!40000 ALTER TABLE `status_omschrijving` DISABLE KEYS */;
INSERT INTO `status_omschrijving` VALUES (0,'Gewenst'),(1,'Gestart'),(2,'Bezig'),(3,'Afgeronde analyse'),(4,'Importeren'),(5,'Afgerond'),(10,'Error');
/*!40000 ALTER TABLE `status_omschrijving` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `testen`
--

DROP TABLE IF EXISTS `testen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testen` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `filenaam` varchar(200) NOT NULL,
  `filenaam_pad` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `testen_configuratie`
--

DROP TABLE IF EXISTS `testen_configuratie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testen_configuratie` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `testen_pk` int(11) NOT NULL,
  `filenaam` varchar(50) NOT NULL,
  `filenaam_pad` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
