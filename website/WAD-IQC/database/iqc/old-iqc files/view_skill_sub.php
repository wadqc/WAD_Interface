<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_skill='skill';
$table_skill_sub='skill_sub';


$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill=$_GET['skill'];
$skill_sub_ref=$_GET['skill_sub_ref'];

$table_skill='skill';
$table_skill_sub='skill_sub';

$skill_Stmt = "SELECT $table_skill_sub.number, $table_skill_sub.code, $table_skill_sub.skill_sub from $table_skill_sub, $table_skill where 
$table_skill.skill_ref=$table_skill_sub.skill_ref
and $table_skill.skill_ref='%d'";

$skill_sub_Stmt = "SELECT * from $table_skill_sub where 
$table_skill_sub.skill_sub_ref='%s'";


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

if (!($result_skill_sub= mysql_query(sprintf($skill_sub_Stmt,$skill_sub_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_skill_sub = mysql_fetch_object($result_skill_sub);

$skill_sub_table = new Smarty_NM();

$skill_sub_table->assign("skill_sub",$field_skill_sub->skill_sub);
$skill_sub_table->assign("code",$field_skill_sub->code);
$skill_sub_table->assign("number",$field_skill_sub->number);

$skill_sub_table->assign("header",sprintf("%s %s Skill:%s",$school,$school_year,$skill));

$skill_sub_table->assign("action_modify",sprintf("modify_skill_sub.php?school=$school&school_year=$school_year&skill=$skill&skill_sub_ref=$skill_sub_ref&t=%d",time()));
$skill_sub_table->assign("action_delete",sprintf("delete_skill_sub.php?school=$school&school_year=$school_year&skill=$skill&skill_sub_ref=$skill_sub_ref&t=%d",time()));

if (!($result_skill= mysql_query(sprintf($skill_Stmt,$field_skill_sub->skill_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_skill_sub); 

$history_content=sprintf("<tr><td class=\"table_data_blue\"> Current sub Skills </td></tr>");

while ($field_skill = mysql_fetch_object($result_skill))
{
  $history_content.=sprintf("
  <tr>
    <td skill_sub=\"table_data\"> $field_skill->skill_sub </td>
    <td skill_sub=\"table_data\"> $field_skill->code </td>
    <td skill_sub=\"table_data\"> $field_skill->number </td>
  </tr>");
}
mysql_free_result($result_skill); 

$skill_sub_table->assign("history_content",$history_content);

$skill_sub_table->display("view_skill_sub.tpl");

?>