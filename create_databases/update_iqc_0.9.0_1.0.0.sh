#!/bin/sh

# optional first argument = mysql root password 

echo
echo Tabel "config" bijwerken...
echo 

mysql -uroot iqc -p$1 -e "DROP TABLE IF EXISTS config; CREATE TABLE IF NOT EXISTS config (property varchar(255) NOT NULL, value varchar(25) NOT NULL, date_modified date NOT NULL, UNIQUE KEY (property)) ENGINE=InnoDB; INSERT INTO config (property,value,date_modified) VALUES ('Version_Database','1.0.0','2014-04-08'), ('Version_Collector','',''), ('Version_Selector','',''), ('Version_Processor','','');"

echo
echo Tabel "criterium" toevoegen aan resultaten_char...
echo 

mysql -uroot iqc -p$1 <<!!
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

echo
echo Done...
echo
