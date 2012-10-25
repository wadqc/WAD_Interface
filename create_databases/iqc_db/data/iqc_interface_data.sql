--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`pk`, `firstname`, `lastname`, `initials`, `phone`, `email`, `login_level_1`, `login_level_2`, `login_level_3`, `login_level_4`, `login_level_5`, `login`, `password`) VALUES
(1, 'Anne', 'Talsma', 'A.', '050-5246733', 'anne.talsma@mzh.nl', 'on', '', '', '', '', 'Talsma', '19fdf51d7001bd6430bc30fcaaa570c5');


--
-- Gegevens worden uitgevoerd voor tabel `config_file`
--

INSERT INTO `config_file` (`pk`, `omschrijving`, `filenaam`, `filenaam_pad`) VALUES
(1, 'sample config file', 'config.ini', 'uploads/config_files/config.ini');