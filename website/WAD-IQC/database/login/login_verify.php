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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_password= $link->query($password_Stmt))) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

$pw_field = $result_password->fetch_object();
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
    //$result_password->close();

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
    $result_password->close();

    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
       
    $top_menu=sprintf("top");
    //$bottom_menu='';
    $bottom_menu='Results';
    
    // JK - by default choose results --> selector instead of nothing
    //$selected_top='100';
    //$selected_bottom='100';
    // Select results - dashboard at login
    $selected_top='1';
    $selected_bottom='2';
    $preferred_modality=$pw_field->prefmodality;


    // JK: change default behaviour: display results / selector table by default
    //$bottom_frame=sprintf("../iqc/frontpage-bottom.html");
    //$bottom_frame=sprintf("../iqc/show_selector.php");
    $bottom_frame=sprintf("../iqc/show_dashboard.php?modaliteit=$preferred_modality");
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
