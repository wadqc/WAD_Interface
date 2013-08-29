@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Tabel "selector_status" hernoemen naar "resultaten_status"...
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% -e "RENAME TABLE selector_status TO resultaten_status"

echo.
echo Done...
echo.

pause