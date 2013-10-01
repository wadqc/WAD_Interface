#!/bin/sh

# optional first argument = mysql root password

mysql -uroot -p$1 < source/WAD_Interface/create_databases/dcm4chee_db/dcm4chee_db.sql

echo "Tabellen aanmaken..."

mysql -upacs -ppacs pacsdb < /opt/dcm4chee-2.17.1-mysql/sql/create.mysql
mysql -uarr -parr arrdb < source/WAD_Interface/create_databases/dcm4chee-arr-3.0.11-mysql/sql/dcm4chee-arr-mysql.ddl

echo "Done..."


