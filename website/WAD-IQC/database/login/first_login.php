<?php

require("../globals_login.php") ;
require("../iqc/common.php") ;
require("../iqc/php/includes/setup.php");

$message='';
if (!empty($_GET['message']))
{
  $message=$_GET['message'];
}

$login = new Smarty_NM();

$login->assign("login_action",sprintf("first_login_verify.php"));
$login->assign("login_picure_src","../../../WAD-logo_pictures/logo_iqc.jpg");
$login->assign("message",$message);
$login->assign("login_submit","Login");
$login->display("first_login.tpl");


?>
