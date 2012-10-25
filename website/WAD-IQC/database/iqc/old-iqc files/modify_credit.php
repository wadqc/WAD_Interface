<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$term=$_GET['term'];
$student_name=$_GET['student_name'];
$credits_ref=$_GET['credits_ref'];

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


$field_credit = mysql_fetch_object($result_credit);


$credit_table = new Smarty_NM();
$credit_table->assign("header",sprintf("Student: %s %s %s department:%s term:%s",$student_name,$school,$school_year,$department,$term));
$credit_table->assign("default_project",$field_credit->project); 
$credit_table->assign("default_credits",$field_credit->credit);

 
$credit_table->assign("submit_value","Modify");

$action=sprintf("update_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&credits_ref=$credits_ref&t=%d",time());
$credit_table->assign("action_new_credit",$action);
$credit_table->display("new_credit.tpl");

mysql_free_result($result_credit);

?>












