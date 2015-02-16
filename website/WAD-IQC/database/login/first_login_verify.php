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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if ($user_password1==$user_password2)
{
   if (!($result_password= $link->query(sprintf($updateStmt_password,md5($user_password1),$user_name)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
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
