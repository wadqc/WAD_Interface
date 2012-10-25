@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Drop + create IQC database...
echo.
echo Tabellen aanmaken...
echo.

del /q iqc.sql data.sql 2> NUL

copy iqc_db\*.sql iqc.sql > NUL
%MYSQL% -uroot -p%ROOTPWD% < iqc.sql
del iqc.sql

echo.
echo Vul database...
echo.

rem copy data\*.sql data.sql
%MYSQL% -uroot iqc -p%ROOTPWD% < iqc_db\data\iqc_interface_data.sql
rem del data.sql

echo.
echo Done...
echo.

pause