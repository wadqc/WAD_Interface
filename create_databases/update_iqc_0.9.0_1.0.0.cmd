@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo
echo Tabel "config" aanmaken en tabel "criterium" toevoegen aan resultaten_char...
echo 

%MYSQL% -uroot iqc -p%ROOTPWD% < iqc_db\update_iqc_0.9.0_1.0.sql

echo.
echo Done...
echo.

pause