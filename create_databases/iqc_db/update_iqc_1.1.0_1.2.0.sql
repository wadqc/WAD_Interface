
-- kolom prefmodality toevoegen aan users tabel
ALTER TABLE `users` ADD `prefmodality` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `email`;

-- database versie
UPDATE config SET value='1.2.0',date_modified='2017-01-30' WHERE property='Version_Database';

