@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Kolom "prefmodality" toevoegen aan tabel users
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% < iqc_db\update_iqc_1.1.0_1.2.0.sql

echo.
echo Done...
echo.

pause

