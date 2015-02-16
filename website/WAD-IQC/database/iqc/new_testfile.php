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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

  if ($test_file_ref<=0)
  { 
    if (!($link->query(sprintf($addStmt,$title,$firstname,$lastname,$address,$phone,$school)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  }
  if ($test_file_ref>0)
  { 
    if (!($link->query(sprintf($update_Stmt,$title,$firstname,$lastname,$address,$phone,$school,$test_file_ref)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
  
  if (!($result_test_file= $link->query($test_file_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
    
  $new = $result_test_file->fetch_object();
  
  $test_file->assign("default_title",$new->title);
  $test_file->assign("default_fname",$new->firstname);
  $test_file->assign("default_lname",$new->lastname);
  $test_file->assign("default_address",$new->address);
  $test_file->assign("default_phone",$new->phone);
  
  $result_test_file->close();
  
  $test_file->assign("submit_value","Update");
}

  $test_file->assign("action_new_test_file",sprintf("new_test_file.php?school=$school&test_file_ref=%d&t=%d",$test_file_ref,time()));

  
  $header=sprintf("MD for %s",$school);
  $test_file->assign("header",$header);

  $test_file->display("new_test_file.tpl");

   
?>












