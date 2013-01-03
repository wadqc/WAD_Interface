@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set DCM4CHEE=c:\WAD-software\dcm4chee-2.17.1-mysql
rem set DCM4CHEE_ARR=c:\WAD-software\dcm4chee-arr-3.0.11-mysql
set ROOTPWD=


echo.
echo Drop + create DCM4CHEE database...
echo.

%MYSQL% -uroot -p%ROOTPWD% < dcm4chee_db\dcm4chee_db.sql

echo.
echo Tabellen aanmaken...
echo.

%MYSQL% -upacs -ppacs pacsdb < %DCM4CHEE%\sql\create.mysql
rem %MYSQL% -uarr -parr arrdb < %DCM4CHEE_ARR%\sql\dcm4chee-arr-mysql.ddl
%MYSQL% -uarr -parr arrdb < dcm4chee-arr-3.0.11-mysql\sql\dcm4chee-arr-mysql.ddl

echo.
echo Done...
echo.

pause