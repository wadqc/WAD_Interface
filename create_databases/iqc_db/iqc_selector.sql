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
-- Tabelstructuur voor tabel `analysemodule`
--

DROP TABLE IF EXISTS `analysemodule`;
CREATE TABLE IF NOT EXISTS `analysemodule` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(250) NOT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `pk_UNIQUE` (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `analysemodule_cfg`
--

DROP TABLE IF EXISTS `analysemodule_cfg`;
CREATE TABLE IF NOT EXISTS `analysemodule_cfg` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(250) NOT NULL,
  `filename` varchar(250) NOT NULL,
  `filepath` varchar(250) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `analysemodule_input`
--

DROP TABLE IF EXISTS `analysemodule_input`;
CREATE TABLE IF NOT EXISTS `analysemodule_input` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(250) DEFAULT NULL,
  `filepath` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `pk_UNIQUE` (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `gewenste_processen`
--

DROP TABLE IF EXISTS `gewenste_processen`;
CREATE TABLE IF NOT EXISTS `gewenste_processen` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `selector_fk` int(11) DEFAULT NULL,
  `study_fk` bigint(20) DEFAULT NULL,
  `series_fk` bigint(20) DEFAULT NULL,
  `instance_fk` bigint(20) DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `analysemodule_input_fk` int(11) DEFAULT NULL,
  `analysemodule_output_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `selector_fk` (`selector_fk`),
  KEY `study_fk` (`study_fk`),
  KEY `series_fk` (`series_fk`),
  KEY `instance_fk` (`instance_fk`),
  KEY `status` (`status`),
  KEY `analysemodule_input_fk` (`analysemodule_input_fk`),
  KEY `analysemodule_output_fk` (`analysemodule_output_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selector`
--

DROP TABLE IF EXISTS `selector`;
CREATE TABLE IF NOT EXISTS `selector` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT 'Geen',
  `description` varchar(250) DEFAULT 'Geen',
  `analysemodule_fk` int(11) DEFAULT NULL,
  `analysemodule_cfg_fk` int(11) DEFAULT NULL,
  `analyselevel` varchar(20) DEFAULT NULL,
  `selector_patient_fk` int(11) DEFAULT NULL,
  `selector_study_fk` int(11) DEFAULT NULL,
  `selector_series_fk` int(11) DEFAULT NULL,
  `selector_instance_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `pk_UNIQUE` (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selector_instance`
--

DROP TABLE IF EXISTS `selector_instance`;
CREATE TABLE IF NOT EXISTS `selector_instance` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `series_fk` bigint(20) DEFAULT NULL,
  `srcode_fk` bigint(20) DEFAULT NULL,
  `media_fk` bigint(20) DEFAULT NULL,
  `sop_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `sop_cuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_no` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `content_datetime` datetime DEFAULT NULL,
  `sr_complete` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `sr_verified` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom1` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom2` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `inst_custom3` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ext_retr_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `retrieve_aets` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `inst_status` int(11) DEFAULT NULL,
  `all_attrs` bit(1) DEFAULT NULL,
  `commitment` bit(1) DEFAULT NULL,
  `archived` bit(1) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `inst_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selector_patient`
--

DROP TABLE IF EXISTS `selector_patient`;
CREATE TABLE IF NOT EXISTS `selector_patient` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selector_series`
--

DROP TABLE IF EXISTS `selector_series`;
CREATE TABLE IF NOT EXISTS `selector_series` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `study_fk` bigint(20) DEFAULT NULL,
  `mpps_fk` bigint(20) DEFAULT NULL,
  `inst_code_fk` bigint(20) DEFAULT NULL,
  `series_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
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
  `availability` int(11) DEFAULT NULL,
  `series_status` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `series_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selector_study`
--

DROP TABLE IF EXISTS `selector_study`;
CREATE TABLE IF NOT EXISTS `selector_study` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_fk` bigint(20) DEFAULT NULL,
  `accno_issuer_fk` bigint(20) DEFAULT NULL,
  `study_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
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
  `num_series` int(11) DEFAULT NULL,
  `num_instances` int(11) DEFAULT NULL,
  `ext_retr_aet` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `retrieve_aets` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_iuid` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fileset_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `study_status` int(11) DEFAULT NULL,
  `checked_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `study_attrs` longblob,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Constraints for dumped tables
--

--
-- Constraints for table `gewenste_processen`
--
ALTER TABLE `gewenste_processen`
  ADD CONSTRAINT `gewenste_processen_ibfk_1` FOREIGN KEY (`analysemodule_input_fk`) REFERENCES `analysemodule_input` (`pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gewenste_processen_ibfk_2` FOREIGN KEY (`analysemodule_output_fk`) REFERENCES `analysemodule_output` (`pk`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------
