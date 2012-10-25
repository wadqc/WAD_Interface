<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];



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



  $class = new Smarty_NM();
  
  $class->assign("header",sprintf("%s %s %s grade:%d",$school,$school_year,$department,$grade));
  

  $class->assign("submit_value","Insert");

  

  $action=sprintf("add_class.php?school=%s&school_year=%s&department=%s&grade=%d&t=%d",$school,$school_year,$department,$grade,time());
  $class->assign("action_new_class",$action);
  $class->display("new_class.tpl");

  ReturnToMain();

?>












