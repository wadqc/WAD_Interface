<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class_ref=$_GET['class_ref'];

$table_class='class';
$table_grade='grade';

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


$class->assign("submit_value","Modify");  

  
$class_Stmt = "SELECT * from $table_class, $table_grade where 
$table_grade.grade_ref=$table_class.grade_ref
 and $table_class.class_ref=$class_ref";
 
  
 if (!($result_class= mysql_query($class_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_class = mysql_fetch_object($result_class)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  $class->assign("default_number",$field_class->number);
  $class->assign("default_class",$field_class->class);
  $grade=$field_class->grade;
  $default_class=$field_class->class;  

  $class->assign("header",sprintf("%s %s %s grade:%d",$school,$school_year,$department,$field_class->grade));
  
  mysql_free_result($result_class);


  
  $class->assign("action_new_class",sprintf("update_class.php?school=$school&school_year=$school_year&department=$department&grade=$grade&default_class=$default_class&class_ref=$class_ref&t=%d",time()));  
  
  $class->display("new_class.tpl");
 
?>











