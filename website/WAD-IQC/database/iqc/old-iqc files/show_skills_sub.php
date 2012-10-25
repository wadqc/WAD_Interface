<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];

if (!empty($_POST['school_year']))
{
  $school_year=$_POST['school_year'];
}

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}


$table_school='school';
$table_year='year';
$table_skill='skill';
$table_skill_sub='skill_sub';


$skill_Stmt = "SELECT * from $table_school, $table_year, $table_skill where 
$table_school.school_ref=$table_year.school_ref and 
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'  
order by $table_skill.number, $table_skill.skill";


$skill_sub_Stmt = "SELECT * from $table_skill_sub where 
$table_skill_sub.skill_ref='%d'
order by $table_skill_sub.number";  


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

if (!($result_skill=mysql_query($skill_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $skill_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



$table_skill="";
 
while (($field_skill = mysql_fetch_object($result_skill)))
{
   $data_table = new Smarty_NM();
   $skill_action=sprintf("new_skill_sub.php?school=%s&school_year=%s&skill_ref=%d&skill=%s&t=%d",$school,$school_year,$field_skill->skill_ref,$field_skill->skill,time());
   $data_table->assign("skill",$field_skill->skill);
   $data_table->assign("action",$skill_action);
      
   $table_skill.=$data_table->fetch("skill_sub_select_header.tpl");

   if (!($result_skill_sub=mysql_query(sprintf($skill_sub_Stmt,$field_skill->skill_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;}

   $j=0;
   while ($field_skill_sub = mysql_fetch_object($result_skill_sub))
   {
     $b=($j%2);
     $bgcolor=''; 
     if ($b==0)
     {
       $bgcolor="#B8E7FF";
     }

     $data_table = new Smarty_NM();
 
     $skill_sub_action=sprintf("view_skill_sub.php?school=%s&school_year=%s&skill=%s&skill_sub_ref=%d&t=%d",$school,$school_year,$field_skill->skill,$field_skill_sub->skill_sub_ref,time());
     $data_table->assign("bgcolor",$bgcolor);
     $data_table->assign("skill_sub",$field_skill_sub->skill_sub);
     $data_table->assign("number",$field_skill_sub->number);
     $data_table->assign("action",$skill_sub_action);
     $data_table->assign("code",$field_skill_sub->code);
     
     $table_skill.=$data_table->fetch("skill_sub_select_row.tpl");
     
     $j++;
   } 
   mysql_free_result($result_skill_sub);
}
mysql_free_result($result_skill);

$data = new Smarty_NM();

$data->assign("table_skill",$table_skill); 
$data->assign("header",sprintf("%s %s skills and sub skills",$school,$school_year));

$data->display("skill_sub_select.tpl");
 
?>