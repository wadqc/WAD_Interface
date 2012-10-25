<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school_year=$_GET['school_year'];
$school=$_GET['school'];


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


  $header_data=sprintf("%s %s",$school,$school_year);

  $score = new Smarty_NM();

  $score->assign("header_data",$header_data);

  $score->assign("submit_value","Insert");

  $action=sprintf("add_score_report.php?school=%s&school_year=%s&t=%d",$school,$school_year,time());
  $score->assign("action_new_score",$action);
  $score->display("new_score.tpl");

?>












