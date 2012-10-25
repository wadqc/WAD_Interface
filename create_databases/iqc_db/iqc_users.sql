-- Gebruiker aanmaken om vanuit de collector bewerkingen te kunnen doen (moet overeenkomen met de gebruiker in config.xml bij de WAD_Collector)
grant all on iqc.* to 'wad'@'localhost' identified by 'wad';

-- gebruikt in WAD_Interface
grant all on iqc.* to 'iqc'@'localhost' identified by 'TY8BqYRdn3Uhzq8T';