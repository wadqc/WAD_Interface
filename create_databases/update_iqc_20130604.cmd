@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Database updaten...
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% < iqc_db\iqc_users.sql

echo.
echo Done...
echo.

pause