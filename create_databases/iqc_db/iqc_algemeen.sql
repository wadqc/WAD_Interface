drop database if exists iqc;
create database iqc;
use iqc;


--
-- Tabelstructuur voor tabel `collector_status_omschrijving`
--

DROP TABLE IF EXISTS config;
CREATE TABLE IF NOT EXISTS config (
property varchar(255) NOT NULL,
value varchar(25) NOT NULL,
date_modified date NOT NULL,
UNIQUE KEY (property)
) ENGINE=InnoDB;

INSERT INTO config (property,value,date_modified) VALUES 
('Version_Database','0.9.0','2013-10-04'),
('Version_Collector','',''),
('Version_Selector','',''),
('Version_Processor','','');