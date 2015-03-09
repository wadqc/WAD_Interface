-- Tabel "selector_categorie" aanmaken
CREATE TABLE IF NOT EXISTS `selector_categorie` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `omschrijving` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB;

-- kolommen toevoegen aan selector tabel
ALTER TABLE selector ADD (modaliteit varchar(20), lokatie varchar(200), selector_categorie_fk int(11), qc_frequentie int(11));

-- kolom toevoegen aan resultaten_boolean tabel
ALTER TABLE resultaten_boolean ADD (criterium varchar(100));

UPDATE config SET value='1.1.0',date_modified='2015-02-17' WHERE property='Version_Database';
