<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");

$table_school='school';
$table_score='score';
$table_year='year';

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$description=$_POST['description'];
$score=$_POST['score'];

$selected_score='';
if (!empty($_POST['selected_score']))
{
  $selected_score=$_POST['selected_score'];
}

$selectStmt_score = "Select * from $table_school, $table_year, $table_score where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_score.score='%s'
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

if (!($result_score= mysql_query(sprintf($selectStmt_score,$school,$school_year,$score), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_score)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_score = mysql_fetch_object($result_score)))
{
   $content.=sprintf("<tr><td class=\"table_data\">score %s already
   excists for school %s at year %s</td></tr>",$field_score->score,$field_score->school,$field_score->year);  
}
mysql_free_result($result_score);  

if ($content!="") //score already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("score_excist.tpl");
}

if (!($content)) //new score
{

  add_school_school($school,&$school_ref);  
  add_school_year($school_year,$school_ref,&$year_ref);
  add_school_score($description,$score,$selected_score,$year_ref,&$score_ref);
  
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_score.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();

?>





