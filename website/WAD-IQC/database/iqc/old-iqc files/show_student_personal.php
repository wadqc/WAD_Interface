<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$student_year_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_student.username='$user'
order by $table_class_student.year";

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


if (!($result_years= mysql_query($student_year_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//wip

//search for maximum of classes
$class_number_max=1;
$previous_year='';
if (!($result_years= mysql_query($student_year_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$k=0;
while (($field_years = mysql_fetch_object($result_years)))
{
   if ($field_years->year==$previous_year)
   {
     $class_number_max++; 
   }
   if ($field_years->year!=$previous_year)
   {
     $year_array[$k]=$field_years->year; 
   }
   $previous_year=$field_years->year;

   $school_year=$field_years->year;
   $school=$field_years->school;
   $department=$field_years->department;
   $class=$field_years->class;
   $class_ref=$field_years->class_ref;
   $father_ref=$field_years->father_ref;
   $mother_ref=$field_years->mother_ref;
   $guardian_ref=$field_years->guardian_ref;
   $k++;
}   
mysql_free_result($result_years);
 
//end for maximum of classes
 $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
 
 $executestring.=sprintf("view_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&p=%s&school=%s&t=%d",$class_ref,$father_ref,$mother_ref,$guardian_ref,$department,$class,$school_year,$grade,1,$school,time());
 header($executestring);
 exit();


 
?>

