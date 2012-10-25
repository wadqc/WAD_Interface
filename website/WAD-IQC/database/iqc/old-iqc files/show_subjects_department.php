<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
if (!empty($_POST['school_year']))
{
  $school_year=$_POST['school_year'];
}
if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}
$department=$_GET['department'];


$table_school='school';
$table_year='year';
$table_department='department';
$table_subject='subject';

$subject_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_subject where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and
$table_department.department='$department'
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


if (!($result_subject=mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


 
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
   if ($j==0)
   {
     $table_subject=$data_table->fetch("subject_select_header.tpl");
   }
   
   $subject_action=sprintf("view_subject_department.php?school=%s&school_year=%s&department=%s&subject_ref=%d&t=%d",$school,$school_year,$department,$field_subject->subject_ref,time());

   $data_table->assign("bgcolor",$bgcolor);
   $data_table->assign("category",$field_subject->category);
   $data_table->assign("category",$field_subject->category);
   $data_table->assign("action",$subject_action);
   $data_table->assign("subject_name",$field_subject->subject);
   $data_table->assign("abreviation",$field_subject->abreviation);

   $table_subject.=$data_table->fetch("subject_select_row.tpl");

   $j++;
}


mysql_free_result($result_subject);  

$data = new Smarty_NM();


$data->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));

$data->assign("subject_list",$table_subject);

$new_subject=sprintf("new_subject_department.php?school=$school&school_year=$school_year&department=$department&t=%d",time());

$data->assign("new_subject",$new_subject);

$data->display("subject_department_select.tpl");

?>
 
  
