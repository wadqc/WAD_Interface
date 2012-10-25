<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill=$_GET['skill'];
$skill_sub_ref=$_GET['skill_sub_ref'];

$table_skill_sub='skill_sub';
$table_skill='skill';

$skill_sub_Stmt = "SELECT * from $table_skill_sub where 
$table_skill_sub.skill_sub_ref=$skill_sub_ref";


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

  
 if (!($result_skill_sub= mysql_query($skill_sub_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_skill_sub = mysql_fetch_object($result_skill_sub)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  $skill_sub = new Smarty_NM();
  $skill_sub->assign("submit_value","Modify");  

  $skill_sub->assign("default_skill_sub",$field_skill_sub->skill_sub);
  $skill_sub->assign("default_code",$field_skill_sub->code);
  $skill_sub->assign("default_number",$field_skill_sub->number);
  $skill_sub->assign("header",sprintf("%s %s skill:%s",$school,$school_year,$skill));
  
  $action=sprintf("update_skill_sub.php?school=$school&school_year=$school_year&skill_sub_ref=$skill_sub_ref&t=%d",time());  $skill_sub->assign("action_new_skill_sub",$action);
  
  
  mysql_free_result($result_skill_sub);

  $skill_sub->display("new_skill_sub.tpl");
 
?>











