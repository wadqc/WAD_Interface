<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

$table_subject='subject';

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



$subject = new Smarty_NM();

$subject->assign("submit_value","Modify");  

  
$subject_Stmt = "SELECT * from $table_subject where 
$table_subject.subject_ref=$subject_ref";
 
  
  if (!($result_subject= mysql_query($subject_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_subject = mysql_fetch_object($result_subject)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  $subject->assign("default_category",$field_subject->category);
  $subject->assign("default_subject",$field_subject->subject);
  $subject->assign("default_abreviation",$field_subject->abreviation);
  
  mysql_free_result($result_subject);


  
  $subject->assign("action_new_subject",sprintf("update_subject_department.php?school=$school&school_year=$school_year&department=$department&subject_ref=$subject_ref&t=%d",time()));  
  
  $subject->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));

  $subject->display("new_subject_department.tpl");
  
?>











