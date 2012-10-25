<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_year='year';
$table_department='department';
$table_subject='subject';

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

$category=$_POST['category'];
$subject=$_POST['subject'];
$abreviation=$_POST['abreviation'];

$selectStmt_subject = "Select * from $table_school, $table_year, $table_department,
$table_subject where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_subject.subject='%s' and
$table_subject.abreviation='%s' and
$table_department.department='%s' and
$table_year.year='%s' and
$table_school.school='%s'";


$queryStmt_department = "Select * from $table_school,$table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='%s' and 
$table_department.department='%s' and
$table_year.year='%s'";


$addStmt_subject = "Insert into $table_subject(category,subject,abreviation,department_ref)
values ('%s','%s','%s','%d')";


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


if (!($result_subject= mysql_query(sprintf($selectStmt_subject,$subject,$abreviation,$department,$school_year,$school), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_subject = mysql_fetch_object($result_subject)))
{
   printf($selectStmt_subject,$subject,$abreviation,$department,$school_year,$school);
   $content.=sprintf("<tr><td class=\"table_data\">Subject %s with abreviation
   %s already excists for department %s</td></tr>",$field_subject->subject,$field_subject->abreviation,$field_subject->department);  
}
mysql_free_result($result_subject);  

if ($content!="") //subject already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("subject_department_excist.tpl");
}

if (!($content)) //new class
{
  //query for department_ref 
  
  if (!($result_department=mysql_query(sprintf($queryStmt_department,$school,$department,$school_year),$link))){
  DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_department)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  
  $field_department = mysql_fetch_object($result_department);
  $department_ref=$field_department->department_ref;
  
  // department_ref defined

  if(!mysql_query(sprintf($addStmt_subject,$category,$subject,$abreviation,$department_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt_class)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
   
}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$executestring.= sprintf("show_subjects_department.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
header($executestring);
exit();




?>





