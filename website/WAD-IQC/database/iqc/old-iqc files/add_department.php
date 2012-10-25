<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");

$table_school='school';
$table_department='department';
$table_year='year';

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$number=$_POST['number'];
$department=$_POST['department'];


$selectStmt_department = "Select * from $table_school, $table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_department.department='%s'
order by $table_year.year";

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

if (!($result_department= mysql_query(sprintf($selectStmt_department,$school,$school_year,$department), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_department = mysql_fetch_object($result_department)))
{
   $content.=sprintf("<tr><td class=\"table_data\">department %s already
   excists for school %s at year %s</td></tr>",$field_department->department,$field_department->school,$field_department->year);  
}
mysql_free_result($result_department);  

if ($content!="") //department already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("department_excist.tpl");
}

if (!($content)) //new department
{

  add_school_school($school,&$school_ref);  
  add_school_year($school_year,$school_ref,&$year_ref);
  add_school_department($department,$number,$year_ref,&$department_ref);
  
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_departments.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();

?>





