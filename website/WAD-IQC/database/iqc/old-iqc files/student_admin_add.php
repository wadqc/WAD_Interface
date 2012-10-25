<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];

if (!empty($_POST['monday']))
{
  $monday=$_POST['monday'];
}
if (!empty($_POST['tuesday']))
{
  $tuesday=$_POST['tuesday'];
}
if (!empty($_POST['wednesday']))
{
  $wednesday=$_POST['wednesday'];
}
if (!empty($_POST['thursday']))
{
  $thursday=$_POST['thursday'];
}
if (!empty($_POST['friday']))
{
  $friday=$_POST['friday'];
}


$submit_value=$_POST['submit_button'];

if ($submit_value=='Customize')
{
  $flag=0;
} 
if ($submit_value=='Preset')
{
  $flag=1;
} 

//printf("value =%s and flag=%d",$submit_value,$flag);
//exit();

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";

//$update_Stmt = "Update $table_class_student set tuition='%d',transportation_to_school='%s',transportation_from_school='%s',monday_hours='%s',tuesday_hours='%s',wednesday_hours='%s',thursday_hours='%s',friday_hours='%s' where  $table_class_student.class_ref='%d'";

$update_Stmt = "Update $table_class_student set monday_hours='%s',tuesday_hours='%s',wednesday_hours='%s',thursday_hours='%s',friday_hours='%s' where  $table_class_student.class_ref='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
    DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
    exit();
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
}

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
  $class_ref_key[$j]=$field_student->class_ref;
  $j++;
}
mysql_free_result($result_student);

$class_ref_number=sizeof($class_ref_key);




if ($flag==0)
{
  $select_class_ref_id=-1;
  $i=0;
  while ($i<$class_ref_number) // loop for $class_ref
  {
    if (empty($monday[$class_ref_key[$i]]))
    {
      $monday[$class_ref_key[$i]]='';
    }   
    if (empty($tuesday[$class_ref_key[$i]]))
    {
      $tuesday[$class_ref_key[$i]]='';
    }  
    if (empty($wednesday[$class_ref_key[$i]]))
    {
      $wednesday[$class_ref_key[$i]]='';
    }  
    if (empty($thursday[$class_ref_key[$i]]))
    {
      $thursday[$class_ref_key[$i]]='';
    }  
    if (empty($friday[$class_ref_key[$i]]))
    {
      $friday[$class_ref_key[$i]]='';
    }  


    if (!(mysql_query(sprintf($update_Stmt,$monday[$class_ref_key[$i]],$tuesday[$class_ref_key[$i]],$wednesday[$class_ref_key[$i]],$thursday[$class_ref_key[$i]],$friday[$class_ref_key[$i]],$class_ref_key[$i]),$link))) 
    {
      DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
      exit() ;
    }
    $i++;
  }
  
}

if ($flag==1)
{
  $select_class_ref_id=-1;
  $i=0;
  while ($i<$class_ref_number) // loop for $class_ref
  {
    if (empty($monday[$select_class_ref_id]))
    {
      $monday[$select_class_ref_id]='';
    }   
    if (empty($tuesday[$select_class_ref_id]))
    {
      $tuesday[$select_class_ref_id]='';
    }  
    if (empty($wednesday[$select_class_ref_id]))
    {
      $wednesday[$select_class_ref_id]='';
    }  
    if (empty($thursday[$select_class_ref_id]))
    {
      $thursday[$select_class_ref_id]='';
    }  
    if (empty($friday[$select_class_ref_id]))
    {
      $friday[$select_class_ref_id]='';
    }  
    if (!(mysql_query(sprintf($update_Stmt,$monday[$select_class_ref_id],$tuesday[$select_class_ref_id],$wednesday[$select_class_ref_id],$thursday[$select_class_ref_id],$friday[$select_class_ref_id],$class_ref_key[$i]),$link))) 
    {
      DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
      exit() ;
    }
    $i++;
  }

}
$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("student_admin_selection.php?school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&t=%d",time());
header($executestring);
exit();



  
?>