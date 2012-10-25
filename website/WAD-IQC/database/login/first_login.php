<?php

require("../globals_login.php") ;
require("../open_school/common.php") ;
require("../../database/open_school/php/includes/setup.php");

$message='';
if (!empty($_GET['message']))
{
  $message=$_GET['message'];
}

$login = new Smarty_NM();

$login->assign("login_action",sprintf("first_login_verify.php"));
$login->assign("login_picure_src","../open_school/logo_pictures/logo_open_school.jpg");
$login->assign("message",$message);
$login->assign("login_submit","Login");
$login->display("first_login.tpl");


?>
