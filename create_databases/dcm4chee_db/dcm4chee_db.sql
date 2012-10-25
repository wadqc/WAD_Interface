drop database if exists pacsdb;
create database pacsdb;
grant all on pacsdb.* to 'pacs'@'localhost' identified by 'pacs';

drop database if exists arrdb;
create database arrdb;
grant all on arrdb.* to 'arr'@'localhost' identified by 'arr';