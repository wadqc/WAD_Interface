<?php
require("../globals.php");
require("../iqc_data.php");
require("./common.php");
require("./php/includes/setup.php");


if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}



$table_users='users';


//transfer specific

$users_Stmt="SELECT * from $table_users where
$table_users.pk='%d'";


//delete specific
$del_users = "delete from  $table_users where 
$table_users.pk='%d'";


$updateStmt_users = "Update $table_users set
password='%s' where
$table_users.pk='%d'";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



$limit=0;
if (!empty($_POST['users']))
{
  $users=$_POST['users'];
  $users_ref_key=array_keys($users);
  $limit=sizeof($users_ref_key);
} 

if (!empty($_GET['users']))
{
  $users=$_GET['users'];
  $users_ref_key=array_keys($users);
  $limit=sizeof($users_ref_key);
} 






  
$i=0;
while ($i<$limit) // loop for $users_ref_key
{
  if (($transfer_action=='delete')&&($users[$users_ref_key[$i]]=='on'))
  {    
    if (!($link->query(sprintf($del_users,$users_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($del_users,$users_ref_key[$i]) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
  } // end delete action and users=on
  
  if (($transfer_action=='reset_pwd')&&($users[$users_ref_key[$i]]=='on'))
  {
    if (!($link->query(sprintf($updateStmt_users,md5($first_login),$users_ref_key[$i])))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($updateStmt_users,md5($first_login),$users_ref_key[$i])  )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;}
  } // end reset action and users = on

  $i++;
}// end loop for $users_ref_key



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("create_users.php?t=%d",time());
header($executestring);
exit();






?>




