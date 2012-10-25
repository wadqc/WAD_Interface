<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$subject=$_GET['subject'];
$subject_ref=$_GET['subject_ref'];

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


  $header_data=sprintf("%s %s department:%s subject:%s",$school,$school_year,$department,$subject);

  $skill = new Smarty_NM();

  $skill->assign("header_data",$header_data);

  $skill->assign("submit_value","Insert");

  $action=sprintf("add_subject_skill.php?school=$school&school_year=$school_year&department=$department&subject=$subject&subject_ref=$subject_ref&t=time()");
  $skill->assign("action_new_skill",$action);
  $skill->display("new_skill.tpl");
  
?>












