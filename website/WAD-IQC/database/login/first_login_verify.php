<?php

require("../globals_login.php") ;
require("../iqc/common.php") ;
require("../iqc/php/includes/setup.php");


$user_password1=$_POST['user_password1'];
$user_password2=$_POST['user_password2'];

$user_name=$user;

$table_users='users';

$updateStmt_password = "Update $table_users set password='%s' where $table_users.login='%s'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



if ($user_password1==$user_password2)
{
   if (!($result_password= mysql_query(sprintf($updateStmt_password,md5($user_password1),$user_name),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
   
   $message=sprintf("Password succesfully entered, login with new password");

   $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
   $executestring.= sprintf("main_login_iqc.php?message=$message");
   header($executestring);
   exit();
  
}

if ($user_password1!=$user_password2)
{

  $message=sprintf("Sorry, the passwords are not equal, please retry");

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("first_login.php?message=$message");
  header($executestring);
  exit();
   
}


?>
