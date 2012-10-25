<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_grade='grade';
$table_class='class';


$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class_ref=$_GET['class_ref'];

$table_grade='grade';
$table_class='class';

$grade_Stmt = "SELECT * from $table_class, $table_grade where 
$table_grade.grade_ref=$table_class.grade_ref
and $table_grade.grade_ref='%s'";

$class_Stmt = "SELECT * from $table_class, $table_grade where 
$table_grade.grade_ref=$table_class.grade_ref
and $table_class.class_ref='%s'";


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

if (!($result_class= mysql_query(sprintf($class_Stmt,$class_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_class = mysql_fetch_object($result_class);

$class_table = new Smarty_NM();

$class_table->assign("class",$field_class->class);
$class_table->assign("number",$field_class->number);

$class_table->assign("header",sprintf("%s %s %s Grade:%d",$school,$school_year,$department,$field_class->grade));

$class_table->assign("action_modify",sprintf("modify_class.php?school=$school&school_year=$school_year&department=$department&class_ref=$class_ref&t=%d",time()));
$class_table->assign("action_delete",sprintf("delete_class.php?school=$school&school_year=$school_year&department=$department&class_ref=$class_ref&t=%d",time()));

if (!($result_grade= mysql_query(sprintf($grade_Stmt,$field_class->grade_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_class); 

$history_content=sprintf("<tr><td class=\"table_data_blue\"> Current classes </td></tr>");

while ($field_grade = mysql_fetch_object($result_grade))
{
  $history_content.=sprintf("
  <tr>
    <td class=\"table_data\"> $field_grade->class </td>
    <td class=\"table_data\"> $field_grade->number </td>
  </tr>");
}
mysql_free_result($result_grade); 

$class_table->assign("history_content",$history_content);

$class_table->display("view_class.tpl");

?>