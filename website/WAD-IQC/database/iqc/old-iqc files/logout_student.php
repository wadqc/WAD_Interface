<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$default_login=$user;

session_unset();
session_destroy();

$executestring = sprintf("Location:http://%s/%s/%s",$_SERVER['HTTP_HOST'],$site_dir,'database/student/login/main_login_open_school.php?default_login=');
$executestring.= sprintf("%s",$default_login);

//printf("%s",$executestring);

header($executestring);
exit();

?>
