<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$v=$_GET['v'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];

$new_student_ref=''; 
if (!empty($_GET['new_student_ref']))
{
 $new_student_ref=$_GET['new_student_ref']; 
}

$table_school='school';
$table_year='year';
$table_department='department';



$dep_Stmt = "SELECT * from $table_school,$table_year,$table_department where
$table_school.school_ref=$table_year.school_ref and 
$table_year.year_ref=$table_department.year_ref and
$table_school.school='%s' and
$table_year.year='%s'
order by $table_department.number";


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


if (!($result_dep= mysql_query(sprintf($dep_Stmt,$school,$school_year), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



 $dep_table = new Smarty_NM();

 $content="";
 $department_action=sprintf("show_classes.php");
 switch($v)
 {
  case 3: $department_action=sprintf("show_grades.php");
          break; //grades (school)
  case 4: $department_action=sprintf("show_subjects_department.php");
          break; //subjects (school)
  
 }

 while (($field_dep = mysql_fetch_object($result_dep)))
 {
   $content.=sprintf("
     <td bgcolor=\"blue\">
      <a class=\"menu\" href=\"%s?department=$field_dep->department&school_year=$school_year&v=$v&school=$school&new_student_ref=$new_student_ref\" class=\"department_data\">$field_dep->department</a>
     </td>",$department_action);
 }
 
 
 mysql_free_result($result_dep); 

 $dep_table->assign("departments",$content);
 $header=sprintf("%s %s",$school,$school_year);
 $dep_table->assign("header",$header);

 $dep_table->display("show_departments.tpl"); 
?>
