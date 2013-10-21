@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Tabel "config" aanmaken...
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% -e "DROP TABLE IF EXISTS config; CREATE TABLE IF NOT EXISTS config (property varchar(255) NOT NULL, value varchar(25) NOT NULL, date_modified date NOT NULL, UNIQUE KEY (property)) ENGINE=InnoDB; INSERT INTO config (property,value,date_modified) VALUES ('Version_Database','0.9.0','2013-10-04'), ('Version_Collector','',''), ('Version_Selector','',''), ('Version_Processor','','');"

echo.
echo Done...
echo.

pause