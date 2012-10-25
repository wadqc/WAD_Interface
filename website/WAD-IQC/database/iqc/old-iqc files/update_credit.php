<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$term=$_GET['term'];
$student_name=$_GET['student_name'];
$credits_ref=$_GET['credits_ref'];

$table_credits='credits';

$project=$_POST['project'];
$credit=$_POST['credits'];

$updateStmt_credit = "Update $table_credits set
project='%s', credit='%s' where
$table_credits.credits_ref='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if(!mysql_query(sprintf($updateStmt_credit,$project,$credit,$credits_ref),$link)) 
{
  DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt_class)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
} 


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$executestring.=sprintf("credit_selection.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&t=%d",time());
header($executestring);

exit();

?>





