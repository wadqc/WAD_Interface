<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$mentor=$_POST['mentor'];

$submit_value=$_POST['submit_button'];

if ($submit_value=='Customize')
{
  $flag=0;
} 
if ($submit_value=='Preset')
{
  $flag=1;
} 

$table_class_student='class_student';

$update_Stmt = "Update $table_class_student set mentor='%s' where  $table_class_student.class_ref='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
  DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
  exit();
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
  DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
}

$class_ref_key=array_keys($mentor);


if ($flag==0)
{
  $select_class_ref_id=-1;

  $i=0;
  while ($i<sizeof($class_ref_key)) // loop for $class_ref
  {
    if ($class_ref_key[$i]!=$select_class_ref_id)  // update for class_ref=-1 doesn't excist
    {
      if (!(mysql_query(sprintf($update_Stmt,$mentor[$class_ref_key[$i]],$class_ref_key[$i]),$link))) 
      {
        DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
        exit() ;
      }
    }
    $i++;
  }
}

if ($flag==1)
{
  $select_class_ref_id=-1;

  $i=0;
  while ($i<sizeof($class_ref_key)) // loop for $class_ref
  {
    if ($class_ref_key[$i]!=$select_class_ref_id) // update for class_ref=-1 doesn't excist
    {
      if (!(mysql_query(sprintf($update_Stmt,$mentor[$select_class_ref_id],$class_ref_key[$i]),$link))) 
      {
        DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
        exit() ;
      }
    }
    $i++;
  }

}
$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("mentor_selection.php?school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&t=%d",time());
header($executestring);
exit();



  
?>