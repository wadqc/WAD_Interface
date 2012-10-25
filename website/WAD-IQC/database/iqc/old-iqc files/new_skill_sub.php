<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill_ref=$_GET['skill_ref'];
$skill=$_GET['skill'];



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



  $skill_sub = new Smarty_NM();
  
  $skill_sub->assign("header",sprintf("%s %s skill:%s",$school,$school_year,$skill));
  

  $skill_sub->assign("submit_value","Insert");

  

  $action=sprintf("add_skill_sub.php?school=%s&school_year=%s&skill_ref=%d&t=%d",$school,$school_year,$skill_ref,time());
  $skill_sub->assign("action_new_skill_sub",$action);
  $skill_sub->display("new_skill_sub.tpl");
  
?>












