#!/bin/sh

# optional first argument = mysql root password 

echo
echo - Kolom "prefmodality" toevoegen aan tabel users
echo

mysql -uroot iqc -p$1 < iqc_db/update_iqc_1.1.0_1.2.0.sql

echo
echo Done...
echo

