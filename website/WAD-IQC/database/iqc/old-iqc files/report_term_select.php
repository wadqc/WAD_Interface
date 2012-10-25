<?php

require("../globals.php") ;
require("./common.php") ;
require("././php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$v=$_GET['v'];

$p=0;
if (!empty($_GET['p']))
{
  $p=$_GET['p'];
}

if ($p==1)
{
  $data = new Smarty_NM(); 
  $data->assign("error_message","No permission");
  $data->assign("error_action",sprintf("show_students.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s&t=time()",$grade,$department,$class,$school_year,201,$school));
  $data->assign("error_button","Return");
  $data->display("error_message.tpl");
  exit(); 
}

$table_school_school='school';
$table_school_year='year';
$table_school_term='term';

$term_Stmt = "SELECT * from $table_school_school, $table_school_year, $table_school_term where 
$table_school_school.school_ref=$table_school_year.school_ref and
$table_school_year.year_ref=$table_school_term.year_ref and
$table_school_school.school='$school' and
$table_school_year.year='$school_year'
order by $table_school_term.term";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$term_list='';
while($field = mysql_fetch_object($result_term))
{
  $term_list["$field->term"]="$field->term";
} 
mysql_free_result($result_term);


$data = new Smarty_NM();
$data->assign("term_options",$term_list); 

if ($v==401)
{
  $class_ref='';
  if (!empty($_GET['class_ref']))
  {
    $class_ref=$_GET['class_ref'];
  }
  $credit_action=sprintf("report_creation.php?school_year=$school_year&school=$school&department=$department&class=$class&grade=$grade&class_ref=$class_ref&v=$v&t=%d",time());
}

if ($v==402)
{
  $credit_action=sprintf("report_selection.php?school_year=$school_year&school=$school&department=$department&class=$class&grade=$grade&v=$v&t=%d",time());
}

if ($v==503)
{
  $class_ref='';
  if (!empty($_GET['class_ref']))
  {
    $class_ref=$_GET['class_ref'];
  }
  $credit_action=sprintf("view_presention_show_students.php?school_year=$school_year&school=$school&department=$department&class=$class&grade=$grade&class_ref=$class_ref&v=$v&t=%d",time());
}

$data->assign("credit_action",$credit_action);
$data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
$data->display("credit_term_report.tpl");

?>
