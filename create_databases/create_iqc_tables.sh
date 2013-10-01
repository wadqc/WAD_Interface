#!/bin/sh

# optional first argument = mysql root password

echo "Drop + create IQC database..."

rm source/WAD_Interface/create_databases/iqc_db/iqc.sql 2> /dev/null

cat source/WAD_Interface/create_databases/iqc_db/*.sql > source/WAD_Interface/create_databases/iqc_db/iqc.sql 
mysql -uroot -p$1  <  source/WAD_Interface/create_databases/iqc_db/iqc.sql
rm source/WAD_Interface/create_databases/iqc_db/iqc.sql

mysql -uroot iqc -p$1 < source/WAD_Interface/create_databases/iqc_db/data/iqc_interface_data.sql
