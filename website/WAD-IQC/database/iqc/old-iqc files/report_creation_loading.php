<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$v=$_GET['v'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$class=$_GET['class'];
$grade=$_GET['grade'];

if (!empty($_POST['term']))
{
  $term=$_POST['term'];
}
if (!empty($_POST['factor']))
{
  $factor=$_POST['factor'];
}


$report = new Smarty_NM();
$report->display("school_report_loading.tpl");  


if ($v==401)//Term (* main menu reports)
{ 
   $action=sprintf("report_creation_loading.php?school=%s&department=%s&class=%s&grade=%s&school_year=%s&v=%d&term_number=$term_number&t=%d",$school,$department,$class,$grade,$school_year,$v,time());
}
if ($v==402)//Meeting (* main menu reports)
{ 
   $action=sprintf("report_selection.php?school=%s&department=%s&class=%s&grade=%s&school_year=%s&v=%d&term_number=$term_number&t=%d",$school,$department,$class,$grade,$school_year,$v,time());
}  

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= $action;
  
  header($executestring);
  exit();


?>
