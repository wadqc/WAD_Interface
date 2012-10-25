<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_department='department';
$table_subject='subject';

$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

$subject_Stmt = "SELECT * from $table_subject where 
$table_subject.subject_ref='%s'";


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

if (!($result_subject= mysql_query(sprintf($subject_Stmt,$subject_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_subject = mysql_fetch_object($result_subject);

$subject_table = new Smarty_NM();
$subject_table->assign("category",$field_subject->category);
$subject_table->assign("subject",$field_subject->subject);
$subject_table->assign("abreviation",$field_subject->abreviation);

$subject_table->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));

$subject_table->assign("action_modify",sprintf("modify_subject_department.php?school=$school&school_year=$school_year&department=$department&subject_ref=$subject_ref&t=%d",time()));
$subject_table->assign("action_delete",sprintf("delete_subject_department.php?school=$school&school_year=$school_year&department=$department&subject_ref=$subject_ref&t=%d",time()));


mysql_free_result($result_subject); 

$subject_table->display("view_subject_department.tpl");

?>