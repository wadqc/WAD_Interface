<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

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

  $subject->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));

  $subject->assign("submit_value","Insert");

  $action=sprintf("add_subject_department.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
  $subject->assign("action_new_subject",$action);
  $subject->display("new_subject_department.tpl");

  ReturnToMain();

?>












