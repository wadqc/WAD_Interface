<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");
require("./delete_department_function.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

if (!empty($_POST['school_t']))
{
  $school_t=$_POST['school_t'];
}
if (!empty($_POST['school_year_t']))
{
  $school_year_t=$_POST['school_year_t'];
}
if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}

$table_school='school';
$table_year='year';
$table_department='department';
$table_term='term';
$table_grade='grade';
$table_class='class';
$table_subject_report='subject_report';
$table_subject_exam='subject_exam';
$table_subject='subject';

$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref='%d'";

$department_Stmt = "SELECT * from $table_department where 
$table_department.department_ref='%d'";

$subject_Stmt = "SELECT * from $table_subject where
$table_subject.department_ref='%d'";

$grade_Stmt = "SELECT * from $table_grade where
$table_grade.department_ref='%d'";

$class_Stmt = "SELECT * from $table_class where
$table_class.grade_ref='%d'";

$subject_report_Stmt = "SELECT * from $table_subject_report where
$table_subject_report.grade_ref='%d'";

$subject_exam_Stmt = "SELECT * from $table_subject_exam where
$table_subject_exam.grade_ref='%d'";


//delete specific


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


$limit=0;
if (!empty($_POST['department']))
{
  $department=$_POST['department'];
  $department_ref_key=array_keys($department);
  $limit=sizeof($department_ref_key);
} 
if (!empty($_GET['department']))
{
  $department=$_GET['department'];
  $department_ref_key=array_keys($department);
  $limit=sizeof($department_ref_key);
} 

if (($transfer_action=='transfer')&&($limit>0))
{
   //create new school and year if necessary; else determine year_ref
   add_school_school($school_t,&$school_ref);  
   add_school_year($school_year_t,$school_ref,&$year_ref);
 
   //perform year verification for a random value of department_ref

   if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$department_ref_key[0]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
   $field_year_verification = mysql_fetch_object($result_year_verification);

   if ($year_ref== $field_year_verification->year_ref)
   {
      GenerateHTMLHeader("The department can not be transfered to the same school year");
      ReturnToMain();
      exit(1);
   }
   mysql_free_result($result_year_verification);
}


  
$i=0;
while ($i<$limit) // loop for $department_ref
{
  if (($transfer_action=='transfer')&&($department[$department_ref_key[$i]]=='on'))
  {
    if (!($result_department= mysql_query(sprintf($department_Stmt,$department_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_department = mysql_fetch_object($result_department);
    
    // create new department
    add_school_department($field_department->department,$field_department->number,$year_ref,&$department_ref);
    
    mysql_free_result($result_department);
    if (!($result_subject = mysql_query(sprintf($subject_Stmt,$department_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    while($field_subject = mysql_fetch_object($result_subject))
    {
    // create new subject
       add_school_subject($field_subject->category,$field_subject->subject,$field_subject->abreviation,$department_ref,&$subject_ref);
    } 
    
    if (!($result_grade = mysql_query(sprintf($grade_Stmt,$department_ref_key[$i]),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    
    while($field_grade = mysql_fetch_object($result_grade))
    {
      // create new grade
      add_school_grade($field_grade->grade,$department_ref,&$grade_ref);
      
      if (!($result_class = mysql_query(sprintf($class_Stmt,$field_grade->grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      while($field_class = mysql_fetch_object($result_class))
      {
        // create new class
        add_school_class($field_class->class,$field_class->number,$grade_ref,&$class_ref);
      }
      mysql_free_result($result_class);

      if (!($result_subject_report = mysql_query(sprintf($subject_report_Stmt,$field_grade->grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      while($field_subject_report = mysql_fetch_object($result_subject_report))
      {
        // create new subject_report
        add_school_subject_report($field_subject_report->category,$field_subject_report->subject,$field_subject_report->abreviation,$field_subject_report->number,$grade_ref,&$subject_report_ref);

      }
      mysql_free_result($result_subject_report);

      if (!($result_subject_exam = mysql_query(sprintf($subject_exam_Stmt,$field_grade->grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      while($field_subject_exam = mysql_fetch_object($result_subject_exam))
      {
        // create new subject_exam
        add_school_subject_exam($field_subject_exam->category,$field_subject_exam->subject,$field_subject_exam->abreviation,$field_subject_exam->number,$grade_ref,&$subject_exam_ref);
      }
      mysql_free_result($result_subject_exam);

    }
    mysql_free_result($result_grade);
  } // end transfer action and department=on

  if (($transfer_action=='delete')&&($department[$department_ref_key[$i]]=='on'))
  {
    delete_department($department_ref_key[$i],&$year_ref,&$school_ref);
  } // end delete action and department=on}

  $i++;
}// end loop for department_ref   


if ($transfer_action=='delete')
{
    if ($limit>0)
    {
      delete_year($year_ref,$school_ref); 
    }
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
    $executestring.= sprintf("create_departments.php?school=$school&school_year=$school_year&t=%d",time());
    header($executestring);
    exit();

   //GenerateHTMLHeader("The department structure was deleted succesfully");
}


if ($transfer_action=='transfer')
{
  GenerateHTMLHeader("The department structure was transfered succesfully");
}
ReturnToMain();

?>




