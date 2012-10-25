<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$subject=$_GET['subject'];


$table_subject_skill='subject_skill';


$skill_Stmt = "SELECT * from $table_subject_skill where 
$table_subject_skill.subject_ref=$subject_ref
order by $table_subject_skill.number";

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

if (!($result_skill= mysql_query(sprintf($skill_Stmt,$subject_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
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
   $action=sprintf("view_skill.php?skill_ref=%d&t=%d",$field_skill->skill_ref,time());

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("skill_name",$field_skill->skill);
   $table_data->assign("skill_abreviation",$field_skill->abreviation);
   $table_data->assign("skill_number",$field_skill->number);
      
   $table_skill.=$table_data->fetch("subject_skill_row.tpl");

  $j++;
}


mysql_free_result($result_skill);  




$skill = new Smarty_NM();

$skill->assign("header",sprintf("%s %s department:%s subject:%s",$school,$school_year,$department,$subject));

$skill->assign("submit_value","Insert");

$new_skill_action=sprintf("new_subject_skill.php?school=$school&school_year=$school_year&department=$department&subject=$subject&subject_ref=$subject_ref&t=%d",time());

$skill->assign("new_skill",$new_skill_action);

$skill->display("subject_skill_select.tpl");

?>












