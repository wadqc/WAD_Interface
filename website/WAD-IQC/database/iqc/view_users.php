<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

if (!empty($_GET['pk']))
{
  $users_pk=$_GET['pk'];
}



$table_users='users';


$users_Stmt = "SELECT * from $table_users where 
$table_users.pk=$users_pk";


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_users= $link->query($users_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}



  $field_users = $result_users->fetch_object();

  $users = new Smarty_NM();
  
  $users->assign("default_users_firstname",$field_users->firstname);
  $users->assign("default_users_middlename",$field_users->middlename);
  $users->assign("default_users_lastname",$field_users->lastname);
  $users->assign("default_users_phone",$field_users->phone);
  $users->assign("default_users_email",$field_users->email);
  $users->assign("default_users_preferred_modality",$field_users->prefmodality);
  $users->assign("default_users_initials",$field_users->initials);
  $users->assign("default_users_login",$field_users->login);
  $checked1='';
  $checked2='';
  $checked3='';
  $checked4='';
  $checked5='';

  if ($field_users->login_level_1=='on')
  {
    $checked1='checked';
  }
  if ($field_users->login_level_2=='on')
  {
    $checked2='checked';
  }
  if ($field_users->login_level_3=='on')
  {
    $checked3='checked';
  }
  if ($field_users->login_level_4=='on')
  {
    $checked4='checked';
  }
  if ($field_users->login_level_5=='on')
  {
    $checked5='checked';
  }

  $users->assign("checked_login_level_1",$checked1);
  $users->assign("checked_login_level_2",$checked2);
  $users->assign("checked_login_level_3",$checked3);
  $users->assign("checked_login_level_4",$checked4);
  $users->assign("checked_login_level_5",$checked5);
  

  $result_users->close(); 



if (!empty($user_level_1))
{
  $users->assign("action_modify",sprintf("new_users.php?users_pk=$users_pk&t=%d",time()));
  $users->assign("action_delete",sprintf("transfer_users.php?users_pk=$users_pk&transfer_action=delete&t=%d",time()));
  $users->assign("content_modify","Modify");
  $users->assign("separator"," / ");
  $users->assign("content_delete","Delete");
  $users->display("view_users_select.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_5)) )
{
  $users->display("view_users.tpl");
}


?>