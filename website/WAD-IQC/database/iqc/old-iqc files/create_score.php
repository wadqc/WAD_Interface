<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$school=$_GET['school'];

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}


$table_school='school';
$table_year='year';
$table_score='score';



$score_Stmt = "SELECT * from $table_school, $table_year, $table_score where 
$table_school.school_ref=$table_year.school_ref and 
$table_year.year_ref=$table_score.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'  
order by $table_score.score, $table_score.description";


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



if (!($result_score=mysql_query($score_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $score_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



$table_score="";
 
  $j=0;
while (($field_score = mysql_fetch_object($result_score)))
{
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_score=$table_data->fetch("score_select_header.tpl");
   }
   $checkbox_name=sprintf("score[%d]",$field_score->score_ref);
   $action=sprintf("view_score.php?score_ref=%d&t=%d",$field_score->score_ref,time());

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("description",$field_score->description);

   $score=sprintf("%s",$field_score->score);
   if ($field_score->selected_score=='on')
   {
     $score=sprintf("%s (default)",$field_score->score);
   }
   $table_data->assign("score",$score);
   $table_data->assign("action",$action);
   
   $table_score.=$table_data->fetch("score_select_row.tpl");

  $j++;
}


mysql_free_result($result_score);  

$data = new Smarty_NM();

$data->assign("year_options",$department_year_list);
$data->assign("school_options",$school_list);
$data->assign("school_id",$fixed_school);

$data->assign("header",sprintf("%s %s",$school,$school_year));

$data->assign("form_action",sprintf("transfer_score.php?school=$school&school_year=$school_year&t=%d",time()));
$data->assign("score_list",$table_score);

$new_score=sprintf("<a href=\"new_score.php?school=$school&school_year=$school_year&t=%d\">Add new Score</a>",time());

$data->assign("new_score",$new_score);

$data->display("score_select_report.tpl");
 
  
