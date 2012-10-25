<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$subject=$_GET['subject'];
$subject_ref=$_GET['subject_ref'];
$subject_skill_ref=$_GET['subject_skill_ref'];

$table_subject_skill='subject_skill';
$skill_Stmt = "SELECT * from  $table_subject_skill where 
$table_subject_skill.subject_skill_ref=$subject_skill_ref";

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
$header_data=sprintf("%s %s department:%s subject:%s",$school,$school_year,$department,$subject);
$skill_table->assign("header",$header_data);

$skill_table->assign("skill",$field_skill->skill);
$skill_table->assign("number",$field_skill->number);

$skill_table->assign("action_modify",sprintf("modify_subject_skill.php?school=$school&school_year=$school_year&department=$department&subject=$subject&subject_ref=$subject_ref&subject_skill_ref=%d&t=%d",$field_skill->subject_skill_ref,time()));
$skill_table->assign("action_delete",sprintf("delete_subject_skill.php?school=$school&school_year=$school_year&department=$department&subject=$subject&subject_ref=$subject_ref&subject_skill_ref=%d&t=%d",$field_skill->subject_skill_ref,time()));

mysql_free_result($result_skill); 

$skill_table->display("view_subject_skill.tpl");

?>