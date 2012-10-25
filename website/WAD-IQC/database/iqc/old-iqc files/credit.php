<?php

require("../globals.php") ;
require("./common.php") ;
require("././php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];
$class=$_GET['class'];
$v=$_GET['v'];

$table_school='school';
$table_year='year';
$table_department='department';
$table_term='term';
$table_grade='grade';
$table_credits_report='credits_report';


$term_Stmt = "SELECT * from $table_school, $table_year, $table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'
order by $table_term.term";


$grade_Stmt = "SELECT * from $table_school, $table_year,
$table_department, $table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade'";

$credits_report_Stmt = "SELECT * from $table_credits_report where
$table_credits_report.grade_ref='%d'";




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

//verify if credits is on

if (!($result_grade= mysql_query($grade_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_grade = mysql_fetch_object($result_grade);
$grade_ref=$field_grade->grade_ref;
mysql_free_result($result_grade);

//credits
if (!($result_credits= mysql_query(sprintf($credits_report_Stmt,$grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
}
$k=0;
while ($field_credits = mysql_fetch_object($result_credits) )
{  
  $k++;
  $credits=$field_credits->credits;
}
if ($k==0)
{
  $credits='';
}
mysql_free_result($result_credits);

if ($credits=='')
{
    $data = new Smarty_NM(); 
    $data->assign("error_message","Credits are not used for this grade.");
    $data->display("error_message_plain.tpl");
    exit(); 
}







$term_list='';
while($field = mysql_fetch_object($result_term))
{
  $term_list["$field->term"]="$field->term";
} 
mysql_free_result($result_term);


$data = new Smarty_NM();
$data->assign("term_options",$term_list); 
$data->assign("credit_action","credit_selection.php?school_year=$school_year&school=$school&department=$department&class=$class");
$data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
$data->display("credit_term.tpl");

?>
