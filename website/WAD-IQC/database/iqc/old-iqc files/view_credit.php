<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$credits_ref=$_GET['credits_ref'];
$term=$_GET['term'];
$student_name=$_GET['student_name'];

$table_credits='credits';

$credit_Stmt = "SELECT * from $table_credits where 
$table_credits.credits_ref=$credits_ref";

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


if (!($result_credit=mysql_query($credit_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $credit_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$data_table = new Smarty_NM();
$credit_list=$data_table->fetch("credits_select_header.tpl");
 

$field_credit = mysql_fetch_object($result_credit);

$bgcolor=''; 

$data_table = new Smarty_NM();
$table_credit=$data_table->fetch("credits_select_header.tpl");

$data_table->assign("bgcolor",$bgcolor);
$data_table->assign("project",$field_credit->project);
$data_table->assign("teacher",$field_credit->teacher_name);
$data_table->assign("credits",$field_credit->credit);

$data_table->assign("header",sprintf("Student: %s %s %s department:%s term:%s",$student_name,$school,$school_year,$department,$term));

$data_table->assign("action_modify",sprintf("modify_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&credits_ref=%d&t=%d",$field_credit->credits_ref,time()));

$data_table->assign("action_delete",sprintf("delete_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&credits_ref=%d&t=%d",$field_credit->credits_ref,time()));

mysql_free_result($result_credit);  


$data_table->display("view_credit.tpl");

 
?> 
