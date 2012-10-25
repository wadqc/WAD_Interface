<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_year='year';
$table_skill='skill';



$skill_ref=$_GET['skill_ref'];

$skill_Stmt = "SELECT * from  $table_school, $table_year, $table_skill where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref
and $table_skill.skill_ref=$skill_ref";

$year_Stmt = "SELECT * from $table_school, $table_year, $table_skill where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and 
$table_skill.skill='%s'";


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

if (!($result_skill= mysql_query($skill_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_skill = mysql_fetch_object($result_skill);

$skill_table = new Smarty_NM();

$skill_table->assign("skill",$field_skill->skill);
$skill_table->assign("number",$field_skill->number);

$skill_table->assign("year",$field_skill->year);

$skill_table->assign("action_modify",sprintf("modify_skill.php?school=$field_skill->school&school_year=$field_skill->year&skill_ref=$skill_ref&t=%d",time()));
$skill_table->assign("action_delete",sprintf("transfer_skill.php?school=$field_skill->school&school_year=$field_skill->year&skill[$skill_ref]=on&transfer_action=delete&t=%d",time()));

if (!($result_year= mysql_query(sprintf($year_Stmt,$field_skill->skill),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_skill); 

$year_content=sprintf("<tr><td class=\"table_data_blue\"> History </td></tr>");

while ($field_year = mysql_fetch_object($result_year))
{
  $year_content.=sprintf("
  <tr>
    <td class=\"table_data_blue\"> $field_year->year </td>
  </tr>");
}
mysql_free_result($result_year); 

$skill_table->assign("year_content",$year_content);

$skill_table->display("view_skill.tpl");

?>