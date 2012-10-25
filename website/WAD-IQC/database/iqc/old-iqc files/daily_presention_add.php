<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];

if (!empty($_POST['student_id']))
{
  $student_id=$_POST['student_id'];
}

$table_student='student';
$table_school_student='school_student';

$table_daily_presention='presention_daily';

$student_Stmt = "SELECT * from $table_student,$table_school_student
where $table_school_student.school='$school' and
$table_student.student_ref=$table_school_student.student_ref and
$table_student.number='%s'";

$presention_Stmt = "SELECT * from $table_daily_presention where
$table_daily_presention.student_ref='%d' and $table_daily_presention.date='%s'"; 

$addStmt = "Insert into $table_daily_presention(date,time,student_ref) values ('%s','%d','%d')";

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


$date_stamp=time();

$date=sprintf("%s",date("Y-m-d",$date_stamp));


if (!($result_student= mysql_query(sprintf($student_Stmt,$student_id),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$student_counter=0;
while($field_student = mysql_fetch_object($result_student))
{
  $student_counter++;
  $student_ref=$field_student->student_ref;
}
mysql_free_result($result_student); 

if ($student_counter>0)
{
  if (!($result_presention= mysql_query(sprintf($presention_Stmt,$student_ref,$date),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }

  $presention_counter=0;
  while($field_presention = mysql_fetch_object($result_presention))
  {
    $presention_counter++;
  }
  mysql_free_result($result_presention); 
  if ($presention_counter==0)
  {
    if (!(mysql_query(sprintf($addStmt,$date,$date_stamp,$student_ref),$link))) 
    {
      DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
      exit() ;
    }
  }

}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$executestring.= sprintf("daily_presention.php?school=$school&t=%d",time());
header($executestring);
exit();






?>
