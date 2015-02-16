-- Tabel "selector_categorie" aanmaken
DROP TABLE IF EXISTS `selector_categorie`;
CREATE TABLE IF NOT EXISTS `selector_categorie` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `omschrijving` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB;

-- kolommen toevoegen aan selector tabel
ALTER TABLE selector ADD (modaliteit varchar(20), lokatie varchar(200), selector_categorie_fk int(11), qc_frequentie int(11));