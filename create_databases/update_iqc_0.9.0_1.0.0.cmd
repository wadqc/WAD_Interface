@echo off

set MYSQL=c:\xampp\mysql\bin\mysql.exe
rem set MYSQL=C:\wamp\bin\mysql\mysql5.5.20\bin\mysql.exe
set ROOTPWD=

echo.
echo Tabel "config" aanmaken...
echo.

%MYSQL% -uroot iqc -p%ROOTPWD% -e "DROP TABLE IF EXISTS config; CREATE TABLE IF NOT EXISTS config (property varchar(255) NOT NULL, value varchar(25) NOT NULL, date_modified date NOT NULL, UNIQUE KEY (property)) ENGINE=InnoDB; INSERT INTO config (property,value,date_modified) VALUES ('Version_Database','1.0.0','2014-04-08'), ('Version_Collector','',''), ('Version_Selector','',''), ('Version_Processor','','');"

echo
echo Tabel "criterium" toevoegen aan resultaten_char...
echo 

%MYSQL% -uroot iqc -p%ROOTPWD% <<!!
DROP PROCEDURE IF EXISTS addcritifnote;
delimiter ;; 
create procedure addcritifnote ()
begin
    declare continue handler for 1060 begin end;
    ALTER TABLE resultaten_char ADD criterium varchar(100);
end;;
call addcritifnote();;
DROP PROCEDURE IF EXISTS addcritifnote;
!!

echo.
echo Done...
echo.

pause