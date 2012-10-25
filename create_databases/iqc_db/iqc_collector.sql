
--
-- Table structure for table `collector_status_omschrijving`
--

DROP TABLE IF EXISTS `collector_status_omschrijving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collector_status_omschrijving` (
  `nummer` int(11) NOT NULL,
  `veld_omschrijving` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collector_status_omschrijving`
--

LOCK TABLES `collector_status_omschrijving` WRITE;
/*!40000 ALTER TABLE `collector_status_omschrijving` DISABLE KEYS */;
INSERT INTO `collector_status_omschrijving` VALUES (0,'Collector bezig'),(1,'Collector klaar'),(2,'Selector bezig'),(3,'Selector klaar');
/*!40000 ALTER TABLE `collector_status_omschrijving` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collector_study_status`
--

DROP TABLE IF EXISTS `collector_study_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collector_study_status` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `study_fk` int(11) DEFAULT NULL,
  `study_status` int(11) DEFAULT '0',
  PRIMARY KEY (`pk`),
  UNIQUE KEY `pk_UNIQUE` (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `collector_series_status`
--

DROP TABLE IF EXISTS `collector_series_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collector_series_status` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `series_fk` int(11) DEFAULT NULL,
  `series_status` int(11) DEFAULT '0',
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=750 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `instance_fk` bigint(20) DEFAULT NULL,
  `filesystem_fk` bigint(20) DEFAULT NULL,
  `filepath` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `file_tsuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `file_md5` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `file_status` int(11) DEFAULT NULL,
  `md5_check_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=454 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `filesystem`
--

DROP TABLE IF EXISTS `filesystem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filesystem` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `next_fk` bigint(20) DEFAULT NULL,
  `dirpath` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `fs_group_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `retrieve_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `availability` int(11) NOT NULL,
  `fs_status` int(11) NOT NULL,
  `user_info` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `patient`
--
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `patient`;
SET FOREIGN_KEY_CHECKS=1;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `merge_fk` bigint(20) DEFAULT NULL,
  `pat_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_id_issuer` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_fn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_gn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_i_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_p_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_birthdate` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_sex` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_custom1` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_custom2` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pat_custom3` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `pat_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `study`
--

DROP TABLE IF EXISTS `study`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `study` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_fk` bigint(20) DEFAULT NULL,
  `accno_issuer_fk` bigint(20) DEFAULT NULL,
  `study_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `study_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_datetime` datetime DEFAULT NULL,
  `accession_no` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ref_physician` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ref_phys_fn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ref_phys_gn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ref_phys_i_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ref_phys_p_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_desc` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_custom1` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_custom2` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_custom3` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `study_status_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `mods_in_study` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `cuids_in_study` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `num_series` int(11) NOT NULL,
  `num_instances` int(11) NOT NULL,
  `ext_retr_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `retrieve_aets` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `availability` int(11) NOT NULL,
  `study_status` int(11) NOT NULL,
  `checked_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `study_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `study_fk` bigint(20) DEFAULT NULL,
  `mpps_fk` bigint(20) DEFAULT NULL,
  `inst_code_fk` bigint(20) DEFAULT NULL,
  `series_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `series_no` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `modality` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `body_part` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `laterality` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `series_desc` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `institution` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `station_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `department` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `perf_physician` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `perf_phys_fn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `perf_phys_gn_sx` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `perf_phys_i_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `perf_phys_p_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pps_start` datetime DEFAULT NULL,
  `pps_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `series_custom1` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `series_custom2` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `series_custom3` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `num_instances` int(11) DEFAULT NULL,
  `src_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ext_retr_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `retrieve_aets` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `availability` int(11) NOT NULL,
  `series_status` int(11) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `series_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `instance`
--

DROP TABLE IF EXISTS `instance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instance` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `series_fk` bigint(20) DEFAULT NULL,
  `srcode_fk` bigint(20) DEFAULT NULL,
  `media_fk` bigint(20) DEFAULT NULL,
  `sop_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `sop_cuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `inst_no` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `content_datetime` datetime DEFAULT NULL,
  `sr_complete` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `sr_verified` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom1` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom2` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom3` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ext_retr_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `retrieve_aets` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `availability` int(11) NOT NULL,
  `inst_status` int(11) NOT NULL,
  `all_attrs` bit(1) NOT NULL,
  `commitment` bit(1) NOT NULL,
  `archived` bit(1) NOT NULL,
  `updated_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `inst_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB AUTO_INCREMENT=454 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;