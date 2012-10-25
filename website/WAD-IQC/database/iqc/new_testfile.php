<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$pk=$_GET['pk'];

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));


if(!empty($_POST['action']))
{
  
  $title=$_POST['title'];
  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $address=$_POST['address'];
  $phone=$_POST['phone'];
  
  
  $table_test_file='test_file';
  $addStmt = "Insert into $table_test_file(omschrijving,filenaam,filenaam_pad) values ('%s','%s','%s')";
  $update_Stmt = "Update $table_test_file set omschrijving='%s',filenaam='%s',filenaam_pad='%s' where $table_test_file.pk='%d'";

  $delStmt = "delete from  $table_test_file where $table_test_file.pk='%d'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
  DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
  exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if ($test_file_ref<=0)
  { 
    if (!(mysql_query(sprintf($addStmt,$title,$firstname,$lastname,$address,$phone,$school),$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
  }
  if ($test_file_ref>0)
  { 
    if (!(mysql_query(sprintf($update_Stmt,$title,$firstname,$lastname,$address,$phone,$school,$test_file_ref),$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
  }








}

if (!empty($_POST['action']))
{
  $executestring.=sprintf("show_test_files.php?school=$school&t=%d",time());
  header($executestring);
  exit();
}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$test_file = new Smarty_NM();




if ($test_file_ref<=0)
{
  $test_file->assign("submit_value","Add");  
}

if ($test_file_ref>0)
{
  $table_test_file='test_file';
  $test_file_Stmt = "SELECT * from $table_test_file where
  $table_test_file.test_file_ref='$test_file_ref' and
  $table_test_file.school='$school'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  if (!($result_test_file= mysql_query($test_file_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
    
  $new = mysql_fetch_object($result_test_file);
  
  $test_file->assign("default_title",$new->title);
  $test_file->assign("default_fname",$new->firstname);
  $test_file->assign("default_lname",$new->lastname);
  $test_file->assign("default_address",$new->address);
  $test_file->assign("default_phone",$new->phone);
  
  mysql_free_result($result_test_file);
  
  $test_file->assign("submit_value","Update");
}

  $test_file->assign("action_new_test_file",sprintf("new_test_file.php?school=$school&test_file_ref=%d&t=%d",$test_file_ref,time()));

  
  $header=sprintf("MD for %s",$school);
  $test_file->assign("header",$header);

  $test_file->display("new_test_file.tpl");

   
?>












