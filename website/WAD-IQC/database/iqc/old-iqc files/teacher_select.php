<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_teacher='table_teacher';


$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.department='$department' order by $table_teacher.teacher";


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


if (!($result_teacher= mysql_query($teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


while($field = mysql_fetch_object($result_teacher))
{
  $list_teacher["$field->teacher"]="$field->teacher";
} 
mysql_free_result($result_teacher);


$teacher = new Smarty_NM();

$teacher->assign("teacher_options",$list_teacher);

$teacher->assign("teacher_action",sprintf("subject.php?department=%s&class=%s&school_year=%s&v=%s&t=%d",$department,$class,$school_year,$v,time()));

$teacher->assign("teacher_submit","Next");
$teacher->display("teacher.tpl");





?>
