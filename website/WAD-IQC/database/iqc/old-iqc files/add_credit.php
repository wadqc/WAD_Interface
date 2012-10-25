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
$class_ref=$_GET['class_ref'];

$table_teacher='teacher';
$table_credits='credits';

$project=$_POST['project'];
$credit=$_POST['credits'];

$queryStmt_teacher = "Select * from $table_teacher where 
$table_teacher.login='$user'";

$addStmt_credit = "Insert into $table_credits(project,teacher,teacher_name,term,credit,class_ref)
values ('%s','%s','%s','%s','%s','%d')";


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


if (!($result_teacher= mysql_query($queryStmt_teacher, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_teacher = mysql_fetch_object($result_teacher);

$teacher_name=sprintf("%s %s",$field_teacher->firstname,$field_teacher->lastname);
$teacher_initials=$field_teacher->initials;

mysql_free_result($result_teacher);

if(!mysql_query(sprintf($addStmt_credit,$project,$teacher_initials,$teacher_name,$term,$credit,$class_ref),$link)) 
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





