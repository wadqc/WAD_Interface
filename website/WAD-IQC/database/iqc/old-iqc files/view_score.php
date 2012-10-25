<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_year='year';
$table_score='score';

$score_ref=$_GET['score_ref'];

$score_Stmt = "SELECT * from  $table_school, $table_year, $table_score where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref
and $table_score.score_ref=$score_ref";

$year_Stmt = "SELECT * from $table_school, $table_year, $table_score where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and 
$table_score.score='%s'";


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

if (!($result_score= mysql_query($score_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_score = mysql_fetch_object($result_score);

$score_table = new Smarty_NM();
$score_table->assign("year",$field_score->year);
$score_table->assign("description",$field_score->description);
$score=sprintf("%s",$field_score->score);
if ($field_score->selected_score=='on')
{
  $score=sprintf("%s (default)",$field_score->score);
}
$score_table->assign("score",$score);

$score_table->assign("action_modify",sprintf("modify_score.php?school=$field_score->school&school_year=$field_score->year&score_ref=$score_ref&t=%d",time()));
$score_table->assign("action_delete",sprintf("transfer_score.php?school=$field_score->school&school_year=$field_score->year&score[$score_ref]=on&transfer_action=delete&t=%d",time()));

if (!($result_year= mysql_query(sprintf($year_Stmt,$field_score->score),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_score); 

$year_content=sprintf("<tr><td class=\"table_data_blue\"> History </td></tr>");

while ($field_year = mysql_fetch_object($result_year))
{
  $year_content.=sprintf("
  <tr>
    <td class=\"table_data_blue\"> $field_year->year </td>
  </tr>");
}
mysql_free_result($result_year); 

$score_table->assign("year_content",$year_content);

$score_table->display("view_score.tpl");

?>