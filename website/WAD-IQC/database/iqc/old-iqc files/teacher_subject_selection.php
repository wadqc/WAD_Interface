<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$year_ref=$_GET['year_ref'];

$table_school='school';
$table_year='year';
$table_department='department';
$table_subject='subject';

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$teacher_Stmt="SELECT * from $table_teacher, $table_teacher_year where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref='%d'";


$teacher_verify_Stmt="SELECT * from $table_teacher_department, $table_teacher_subject where
$table_teacher_department.department_ref=$table_teacher_subject.department_ref and
$table_teacher_department.year_ref='%d' and
$table_teacher_department.department='%s' and
$table_teacher_subject.subject='%s'";

$department_Stmt = "SELECT * from $table_school, $table_year, $table_department where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'
order by $table_department.number, $table_department.department";

$subject_Stmt = "SELECT * from $table_subject where
$table_subject.department_ref='%d'
order by $table_subject.category, $table_subject.subject";

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

if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$year_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_teacher = mysql_fetch_object($result_teacher);
$header=sprintf("%s %s Teacher:%s, %s",$school,$school_year,$field_teacher->lastname,$field_teacher->firstname);
mysql_free_result($result_teacher);


if (!($result_department= mysql_query($department_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  $header_content='';
  $content='';
  while (($field_department = mysql_fetch_object($result_department)))
  {
    $content.=sprintf("<td valign=\"top\">");
    $j=0;
    
    $bgcolor='#B8E7FF';
    $data = new Smarty_NM();
    $data->assign("department",$field_department->department);
    $header_content.=$data->fetch("teacher_subject_department.tpl");

    if (!($result_subject= mysql_query(sprintf($subject_Stmt,$field_department->department_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    
    while (($field_subject = mysql_fetch_object($result_subject)))
    {
      // one row for each subject
      if (!($result_teacher= mysql_query(sprintf($teacher_verify_Stmt,$year_ref,$field_department->department,$field_subject->abreviation),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $k=0;
      while (($field_teacher = mysql_fetch_object($result_teacher)))
      {
        $k++;
      }
      mysql_free_result($result_teacher);
      if ($k==0)
      {
        $name="name";
      }
  
      if ($k==1)
      {
        $name="checked name";
      }
      $bgcolor='';
      $b=($j%2);
      if ($b==0)
      $bgcolor='#B8E7FF';
      $data = new Smarty_NM();
      $data->assign("bgcolor",$bgcolor);
      $data->assign("name",$name);
      $data->assign("department",$field_department->department);
      $data->assign("abreviation",$field_subject->abreviation);
      $content.=$data->fetch("teacher_subject_col.tpl");
      $j++;
    } //all subjects     
    mysql_free_result($result_subject);
    $content.=sprintf("</td>");
  }//all departments
  
  mysql_free_result($result_department);
  
  $data = new Smarty_NM();
  $data->assign("header",$header);
  
  $data->assign("header_content",$header_content);
  $data->assign("content",$content);
  $data->assign("year_ref",$year_ref);
  $data->assign("school",$school);
  $data->assign("school_year",$school_year);
  $data->display("teacher_subject_select.tpl");
 
?>
