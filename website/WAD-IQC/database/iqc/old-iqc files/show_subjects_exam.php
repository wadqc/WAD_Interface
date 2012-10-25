<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

if (!empty($_POST['grade']))
{
  $grade=$_POST['grade'];
}

if (!empty($_GET['grade']))
{
  $grade=$_GET['grade'];
}

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_subject_exam='subject_exam';

$subject_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_grade, $table_subject_exam where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_subject_exam.grade_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade'
order by $table_subject_exam.number, $table_subject_exam.subject";


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


if (!($result_subject=mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


//define the header
$data_table = new Smarty_NM();
$table_subject=$data_table->fetch("grade_exam_select_header.tpl");

$j=0;
while (($field_subject = mysql_fetch_object($result_subject)))
{
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor="#B8E7FF";
   }

   $data_table = new Smarty_NM();
   
   $data_table->assign("bgcolor",$bgcolor);
   $data_table->assign("category",$field_subject->category);
   $data_table->assign("subject",$field_subject->subject);
   $data_table->assign("abreviation",$field_subject->abreviation);

   $table_subject.=$data_table->fetch("grade_exam_select_row.tpl");
   $j++;
}


mysql_free_result($result_subject);  

$data = new Smarty_NM();


$data->assign("header",sprintf("%s %s %s grade:%d",$school,$school_year,$department,$grade));

$data->assign("subject_list",$table_subject);

$new_subject=sprintf("<a href=\"change_subject_exam.php?school=$school&school_year=$school_year&grade=$grade&department=$department&t=%d\">Modify</a>",time());

$data->assign("new_subject",$new_subject);

$data->display("subject_department_select.tpl");
 
  
