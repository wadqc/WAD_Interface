<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$term=$_GET['term'];
$student_name=$_GET['student_name'];
$class_ref=$_GET['class_ref'];

  $credit = new Smarty_NM();
  $credit->assign("header",sprintf("Student: %s %s %s department:%s term:%s",$student_name,$school,$school_year,$department,$term));
  
  $credit->assign("submit_value","Insert");

  $action=sprintf("add_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&class_ref=$class_ref&t=%d",time());
  $credit->assign("action_new_credit",$action);
  $credit->display("new_credit.tpl");

?>












