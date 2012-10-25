<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];

$subject=$_POST['subject'];
$number=$_POST['number'];

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_subject='subject';
$table_subject_exam='subject_exam';


$add_subject_exam_Stmt="Insert into $table_subject_exam(category,subject,abreviation,number,grade_ref) values ('%s','%s','%s','%s','%d')";

$delete_Stmt_subject_exam = "DELETE from $table_subject_exam WHERE
$table_subject_exam.grade_ref='%d'";

$grade_Stmt = "select * from $table_school, $table_year, $table_department, $table_grade WHERE
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_department.department='%s' and
$table_grade.grade='%s'";

$subject_Stmt = "select * from $table_subject WHERE
$table_subject.department_ref='%d' and
$table_subject.abreviation='%s'";

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

  if (empty($subject))



  $subject_key=array_keys($subject);
  
  if (!($result_grade= mysql_query(sprintf($grade_Stmt,$school,$school_year,$department,$grade),$link)))
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $field_grade = mysql_fetch_object($result_grade);
  $grade_ref=$field_grade->grade_ref;
  $department_ref=$field_grade->department_ref;  
  mysql_free_result($result_grade);

  
  if (!(mysql_query(sprintf($delete_Stmt_subject_exam,$grade_ref),$link))) 
  {
    DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
    exit() ;
  }
  


  if (!empty($subject))
  {
    $subject_key=array_keys($subject);
    $j=0;
    while ($j<sizeof($subject_key)) //loop for $subject
    {
      if ($subject[$subject_key[$j]]=='on')
      {
        if (!($result_subject= mysql_query(sprintf($subject_Stmt,$department_ref,$subject_key[$j]),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
        }
        $field_subject = mysql_fetch_object($result_subject);
        if (!(mysql_query(sprintf($add_subject_exam_Stmt,$field_subject->category,$field_subject->subject,
        $field_subject->abreviation,$number[$subject_key[$j]],$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
        mysql_free_result($result_subject);
      }
      $j++;
    }
  }
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_subjects_exam.php?school=$school&school_year=$school_year&department=$department&grade=$grade&t=%d",time());
  header($executestring);
  exit();
  
?>