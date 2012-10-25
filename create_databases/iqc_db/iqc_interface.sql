--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `initials` varchar(10) NOT NULL DEFAULT '',
  `phone` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login_level_1` varchar(5) NOT NULL DEFAULT '',
  `login_level_2` varchar(5) NOT NULL DEFAULT '',
  `login_level_3` varchar(5) NOT NULL DEFAULT '',
  `login_level_4` varchar(5) NOT NULL DEFAULT '',
  `login_level_5` varchar(5) NOT NULL DEFAULT '',
  `login` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


--
-- Tabelstructuur voor tabel `config_file`
--

DROP TABLE IF EXISTS `config_file`;
CREATE TABLE IF NOT EXISTS `config_file` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `omschrijving` varchar(100) NOT NULL,
  `filenaam` varchar(50) NOT NULL,
  `filenaam_pad` varchar(200) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

