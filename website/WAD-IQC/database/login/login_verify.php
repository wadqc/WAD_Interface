<?php

require("../globals_login.php") ;
require("../iqc_data.php");
require("../iqc/common.php") ;
require("../../database/iqc/php/includes/setup.php");


$user_password=$_POST['user_password'];
$user_name=$_POST['user_name'];

$table_users='users';

$password_Stmt="SELECT * from $table_users where $table_users.login='$user_name'";


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

if (!($result_password= mysql_query($password_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$pw_field = mysql_fetch_object($result_password);
if ($pw_field=='')
{
  $message=sprintf("Wrong user!");
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("main_login_iqc.php?message=$message");
  header($executestring);
  exit();
}


if (md5($user_password)==$pw_field->password)
{
  if (!session_id())
  session_start();

  $_SESSION['user_name']=$user_name;
  $_SESSION['level_1']=$pw_field->login_level_1;
  $_SESSION['level_2']=$pw_field->login_level_2;
  $_SESSION['level_3']=$pw_field->login_level_3; 
  $_SESSION['level_4']=$pw_field->login_level_4;
  $_SESSION['level_5']=$pw_field->login_level_5;

  if (md5($first_login)==$pw_field->password)
  {
    //mysql_free_result($result_password);

    $message=sprintf("First login succesfully, please enter your own personal password twice");
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
    $executestring.= sprintf("first_login.php?message=$message");
    //printf("%s",$executestring);
    //exit();
    header($executestring);
    exit();

  }  
  if (md5($first_login)!=$pw_field->password)
  {
    mysql_free_result($result_password);

    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
       
    $top_menu=sprintf("top");
    $bottom_menu='';
    $selected_top='100';
    $selected_bottom='100';


    $bottom_frame=sprintf("../iqc/frontpage-bottom.html");
    $executestring.= sprintf("../main/main_iqc.php?top_menu=$top_menu&bottom_menu=$bottom_menu&selected_top=$selected_top&selected_bottom=$selected_bottom&bottom_frame=$bottom_frame&t=%d",time());
    header($executestring);
    exit();
  }


}


if (md5($user_password)!=$pw_field->password)
{
  
  $message=sprintf("Wrong Password!");
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("main_login_iqc.php?message=$message");
  header($executestring);
  exit();

}









?>
