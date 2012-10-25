<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

if (!empty($_POST['school_year']))
{
  $school_year=$_POST['school_year'];
}

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}

if (!empty($_POST['department']))
{
  $department=$_POST['department'];
}

if (!empty($_GET['department']))
{
  $department=$_GET['department'];
}


$table_year='year';
$table_department='department';
$table_subject='subject';

$subject_Stmt = "SELECT * from $table_year, $table_department, $table_subject where 
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_year.year='$school_year' and
$table_department.department='$department'
order by $table_subject.subject";


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


 $table_subject="";
 
  $j=0;
while (($field_subject = mysql_fetch_object($result_subject)))
{
   $b=($j%2);
   if ($b==0)
   $table_subject.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_subject.=sprintf("<TR>");
   
   $table_subject.=sprintf("
  <td>
     <font color=\"red\"><B><a href=\"view_subject.php?subject_ref=$field_subject->subject_ref\">%s</a></B></font>
  </td>
  <td>
     <font color=\"red\"><B>%s</B></font>
  </td>",$field_subject->subject,$field_subject->abreviation);
 
  $table_subject.=sprintf("</TR>");
  $j++;
}


mysql_free_result($result_subject);  

$data = new Smarty_NM();


$data->assign("header",sprintf("School year %s Subject %s",$school_year,$subject));

$data->assign("subject_list",$table_subject);

$new_subject=sprintf("<a href=\"new_subject.php?school_year=%s&t=%d\">Add new Subject</a>",$school_year,time());

$data->assign("new_subject",$new_subject);

$data->display("subject_select.tpl");
 
  
