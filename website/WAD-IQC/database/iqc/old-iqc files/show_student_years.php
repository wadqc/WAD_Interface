<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
$v=$_GET['v'];


$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

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

$student_query_year_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_student.username='$user' and
$table_class_student.year='%s'
order by $table_class_student.year";

$student_query_grade_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_grade, $table_class where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_department.department='%s' and
$table_class.class='%s'";  

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
     $k++;
   }
   $previous_year=$field_years->year;
}   

mysql_free_result($result_years);


//end for maximum of classes


$student_row='';
$data = new Smarty_NM();
  
if (!($result_years= mysql_query($student_year_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$k=0;
while ($k<sizeof($year_array)) //loop for $year
{
  $data = new Smarty_NM();
   
  $data->assign("year",$year_array[$k]);
  $student_year=$data->fetch("student_table_year.tpl");

  if (!($result_query_years= mysql_query(sprintf($student_query_year_Stmt,$year_array[$k]),$link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $j=0;
  $student_department='';
  while (($field_query_year = mysql_fetch_object($result_query_years)))
  {
    $data = new Smarty_NM();
   
    $school_year=$field_query_year->year;
    $school=$field_query_year->school;
    $department=$field_query_year->department;
    $class=$field_query_year->class;
    $class_ref=$field_query_year->class_ref;

    if (!($result_query_grade= mysql_query(sprintf($student_query_grade_Stmt,$school,$school_year,$department,$class),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_query_grade_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    $field_query_grade = mysql_fetch_object($result_query_grade);
    $grade=$field_query_grade->grade;
    mysql_free_result($result_query_grade);

    //$grade=$class[0];
    

    $student_report_action=sprintf("report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&p=%d&school=%s&class_ref=%s&t=%d",$grade,$department,$class,$school_year,$v,0,$school,$class_ref,time());
       

    $data->assign("student_report_action",$student_report_action);
    
    $department=sprintf("%s %s",$department,$class);
    $data->assign("department",$department);
    $student_department.=$data->fetch("student_table_department.tpl");
    $j++;
  }
  mysql_free_result($result_query_years);
  $student_colspan='';
  if ($j<$class_number_max)
  {
    $data = new Smarty_NM();
    $data->assign("colspan",($class_number_max-$j));
    $student_colspan=$data->fetch("student_table_colspan.tpl");
  } 

  $data = new Smarty_NM();
  $b=($k%2);
  $bgcolor='';
  if ($b==0)
  {
    $bgcolor='#B8E7FF';
  }
  $data->assign("bgcolor",$bgcolor);
  $data->assign("student_year",$student_year);
  $data->assign("student_department",$student_department);
  $data->assign("student_colspan",$student_colspan);

  $student_row.=$data->fetch('student_table_row.tpl');

  $k++;

}

$data = new Smarty_NM();
$header=sprintf("School History");
$data->assign("header",$header);
$data->assign("content",$student_row);
$data->display("student_table_select.tpl");
 
?>

