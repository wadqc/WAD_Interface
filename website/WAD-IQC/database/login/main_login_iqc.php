<?php

require("../globals_login.php") ;
require("../iqc/common.php") ;
require("../iqc/php/includes/setup.php");


$default_login='';
if (!empty($_GET['default_login']))
{
  $default_login=$_GET['default_login'];
}

$message='';
if (!empty($_GET['message']))
{
  $message=$_GET['message'];
}


$login = new Smarty_NM();

$login->assign("login_action",sprintf("login_verify.php"));
$login->assign("message",$message);
$login->assign("default_login",$default_login);

$login->assign("login_picure_src","../../../WAD-logo_pictures/logo_iqc.jpg");
$login->assign("application_link","../iqc/about.php");

$login->assign("login_submit","Login");
$login->display("login.tpl");


?>
