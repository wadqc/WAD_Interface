#!/bin/sh

# optional first argument = mysql root password 

echo
echo - Tabel "selector_categorie" aanmaken en kolommen toevoegen aan selector tabel
echo - Kolom "criterium" toevoegen aan resultaten_boolean
echo

mysql -uroot iqc -p$1 < iqc_db/update_iqc_1.0.0_1.1.0.sql

echo
echo Done...
echo

