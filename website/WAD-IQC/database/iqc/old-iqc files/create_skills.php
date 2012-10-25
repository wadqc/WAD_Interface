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
$table_skill='skill';



$skill_Stmt = "SELECT * from $table_school, $table_year, $table_skill where 
$table_school.school_ref=$table_year.school_ref and 
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'  
order by $table_skill.number, $table_skill.skill";


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
 
  $j=0;
while (($field_skill = mysql_fetch_object($result_skill)))
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
     $table_skill=$table_data->fetch("skill_select_header.tpl");
   }
   $checkbox_name=sprintf("skill[%d]",$field_skill->skill_ref);
   $action=sprintf("view_skill.php?skill_ref=%d&t=%d",$field_skill->skill_ref,time());

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("skill_name",$field_skill->skill);
   $table_data->assign("skill_abreviation",$field_skill->abreviation);
   $table_data->assign("skill_number",$field_skill->number);
   $table_data->assign("action",$action);
   
   $table_skill.=$table_data->fetch("skill_select_row.tpl");

  $j++;
}


mysql_free_result($result_skill);  

$data = new Smarty_NM();

$data->assign("year_options",$department_year_list);
$data->assign("school_options",$school_list);
$data->assign("school_id",$fixed_school);

$data->assign("header",sprintf("%s %s",$school,$school_year));

$data->assign("form_action",sprintf("transfer_skill.php?school=$school&school_year=$school_year&t=%d",time()));
$data->assign("skill_list",$table_skill);

$new_skill=sprintf("<a href=\"new_skill.php?school=$school&school_year=$school_year&t=%d\">Add new Skill</a>",time());

$data->assign("new_skill",$new_skill);

$data->display("skill_select.tpl");
 
  
