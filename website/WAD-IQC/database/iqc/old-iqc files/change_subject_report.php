<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];


$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_subject='subject';
$table_subject_report='subject_report';

$subject_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_subject where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department'
order by $table_subject.category, $table_subject.abreviation";

$subject_report_verify_Stmt= "SELECT * from $table_grade, $table_subject_report where 
$table_grade.grade_ref=$table_subject_report.grade_ref and
$table_grade.grade='$grade' and
$table_grade.department_ref='%d' and
$table_subject_report.subject='%s'";


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

if (!($result_subject= mysql_query($subject_Stmt,$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }



  
  $content='';
 
    $j=0;
    while ($field_subject = mysql_fetch_object($result_subject))
    {
      // one row for each subject
      if (!($result_subject_report= mysql_query(sprintf($subject_report_verify_Stmt,$field_subject->department_ref,$field_subject->subject),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $k=0;
      while ($field_subject_report = mysql_fetch_object($result_subject_report))
      {
        $k++;
        $default_number=sprintf("%s",$field_subject_report->number);
      }
      mysql_free_result($result_subject_report);
      if ($k==0)
      {
        $name="name";
        $default_number='';
      }
  
      if ($k==1)
      {
        $name="checked name";
      }
      //printf("k=%d",$k);
      $bgcolor='';
      $b=($j%2);
      if ($b==0)
      $bgcolor='#B8E7FF';
      $data = new Smarty_NM();
      $data->assign("bgcolor",$bgcolor);
      $data->assign("category",$field_subject->category);
      $data->assign("name",$name);
      $data->assign("default_number",$default_number);
      $data->assign("abreviation",$field_subject->abreviation);
      $content.=$data->fetch("subject_report_col.tpl");
      $j++;
    }      
    mysql_free_result($result_subject);
    
  $header=sprintf("%s %s %s grade:%d",$school,$school_year,$department,$grade);
  $report_action=sprintf("subject_report_add.php?school=%s&school_year=%s&department=%s&grade=%s&t=%d",$school,$school_year,$department,$grade,time());
  
  $data = new Smarty_NM();
  $data->assign("report_action",$report_action);
  $data->assign("header",$header);
  $data->assign("content",$content);
  $data->display("subject_report_select.tpl");
 
?>
