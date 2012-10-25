<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");

$table_school='school';
$table_skill='skill';
$table_year='year';

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$number=$_POST['number'];
$skill=$_POST['skill'];
$abreviation=$_POST['abreviation'];

$selectStmt_skill = "Select * from $table_school, $table_year, $table_skill where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_skill.skill='%s'
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

if (!($result_skill= mysql_query(sprintf($selectStmt_skill,$school,$school_year,$skill), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_skill)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_skill = mysql_fetch_object($result_skill)))
{
   $content.=sprintf("<tr><td class=\"table_data\">skill %s already
   excists for school %s at year %s</td></tr>",$field_skill->skill,$field_skill->school,$field_skill->year);  
}
mysql_free_result($result_skill);  

if ($content!="") //skill already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("skill_excist.tpl");
}

if (!($content)) //new skill
{

  add_school_school($school,&$school_ref);  
  add_school_year($school_year,$school_ref,&$year_ref);
  add_school_skill($skill,$abreviation,$number,$year_ref,&$skill_ref);
  
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_skills.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();

?>





