<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];

if (!empty($_POST['term']))
{
  $term=$_POST['term'];
}
if (!empty($_GET['term']))
{
  $term=$_GET['term'];
}


$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_credits='credits';

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

$credit_Stmt = "SELECT * from $table_credits where
$table_credits.class_ref='%d' and 
$table_credits.term='%d'";

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

if (!($result_credit= mysql_query(sprintf($credit_Stmt,$school,$school_year,$department),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $credit_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $credit_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$data=new Smarty_NM();
$table_credit_select=$data->fetch("credits_header_row.tpl");
$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
  $b=($j%2);
  if ($b==0)
    $bgcolor="B8E7FF";
  if ($b==1)
    $bgcolor='';
  $student_name=sprintf("%s %s",$field_student->firstname,$field_student->lastname);   
 
  if (!($result_credit= mysql_query(sprintf($credit_Stmt,$field_student->class_ref,$term),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $credit_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
   
  $data_student_row=new Smarty_NM();
  $data_student_row->assign("bgcolor",$bgcolor); 
  $data_student_row->assign("student",$student_name);
  $data_student_row->assign("student_action",sprintf("show_credits.php?school=$school&department=$department&class=$class&school_year=$school_year&student_name=$student_name&class_ref=%d&term=%d",$field_student->class_ref,$term));
  $credit_row='';
  $credit_counter=0;   
  while ($field_credit = mysql_fetch_object($result_credit))
  {
    if ($credit_counter==0)
    {
      $data_student_row->assign("project",$field_credit->project);
      $data_student_row->assign("teacher",$field_credit->teacher_name);
      $data_student_row->assign("credit",$field_credit->credit);
    }
    if ($credit_counter>0)
    {
      $data_row=new Smarty_NM();
      $data_row->assign("bgcolor",$bgcolor);
      $data_row->assign("project",$field_credit->project);
      $data_row->assign("teacher",$field_credit->teacher_name);
      $data_row->assign("credit",$field_credit->credit);
      $credit_row.=$data_row->fetch("credits_row.tpl");
    } 
    $credit_counter++;
  }
  mysql_free_result($result_credit);
  if ($credit_counter==0)
  {
    $data_student_row->assign("project","&nbsp;");
    $data_student_row->assign("teacher","&nbsp;");
    $data_student_row->assign("credit","&nbsp;");
    $data_student_row->assign("row_span",1);
  }
  if ($credit_counter!=0)
  {
    $data_student_row->assign("row_span",$credit_counter);
  }
  $student_row=$data_student_row->fetch("credits_student_row.tpl");
  $table_credit_select.=$student_row;
  $table_credit_select.=$credit_row;

  $j++; 
}//all students
mysql_free_result($result_student);  

$data = new Smarty_NM();
$data->assign("credit_list",$table_credit_select);
$data->assign("header",sprintf("%s %s Term:%s %s Class:%s",$school,$school_year,$term,$department,$class));
$data->display("credit_select.tpl");
 
?>
