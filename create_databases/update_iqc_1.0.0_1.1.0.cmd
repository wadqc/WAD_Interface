@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Tabel "selector_categorie" aanmaken en kolommen toevoegen aan selector tabel
echo Kolom "criterium" toevoegen aan resultaten_boolean
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% < iqc_db\update_iqc_1.0.0_1.1.0.sql

echo.
echo Done...
echo.

pause
