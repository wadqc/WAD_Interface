<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_year='year';
$table_department='department';



$department_ref=$_GET['department_ref'];

$department_Stmt = "SELECT * from  $table_school, $table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref
and $table_department.department_ref=$department_ref";

$year_Stmt = "SELECT * from $table_school, $table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and 
$table_department.department='%s'";


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

if (!($result_department= mysql_query($department_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_department = mysql_fetch_object($result_department);

$department_table = new Smarty_NM();

$department_table->assign("department",$field_department->department);
$department_table->assign("number",$field_department->number);

$department_table->assign("year",$field_department->year);

$department_table->assign("action_modify",sprintf("modify_department.php?school=$field_department->school&school_year=$field_department->year&department_ref=$department_ref&t=%d",time()));
$department_table->assign("action_delete",sprintf("transfer_department.php?school=$field_department->school&school_year=$field_department->year&department[$department_ref]=on&transfer_action=delete&t=%d",time()));

if (!($result_year= mysql_query(sprintf($year_Stmt,$field_department->department),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_department); 

$year_content=sprintf("<tr><td class=\"table_data_blue\"> History </td></tr>");

while ($field_year = mysql_fetch_object($result_year))
{
  $year_content.=sprintf("
  <tr>
    <td class=\"table_data_blue\"> $field_year->year </td>
  </tr>");
}
mysql_free_result($result_year); 

$department_table->assign("year_content",$year_content);

$department_table->display("view_department.tpl");

?>