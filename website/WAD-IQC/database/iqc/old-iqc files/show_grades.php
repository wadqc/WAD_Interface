<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];

if (!empty($_POST['school_year']))
{
  $school_year=$_POST['school_year'];
}

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}


$department=$_GET['department'];


$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$class_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_grade, $table_class where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='%d'
order by $table_class.number";  


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


 
  
 $grade=1; //start loop at this level

 //$j=0; 

 $table_class='';
 
 while ($grade<$max_grades+1)
 {
   $data_table = new Smarty_NM();
   $grade_action=sprintf("new_class.php?school=%s&school_year=%s&department=%s&grade=%d&t=%d",$school,$school_year,$department,$grade,time());
   
   $data_table->assign("grade",sprintf("Form %d",$grade));
   $data_table->assign("action",$grade_action);
      
   $table_class.=$data_table->fetch("grade_select_header.tpl");

   if (!($result_class=mysql_query(sprintf($class_Stmt,$grade), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;}

   $j=0;
   while (($field_class = mysql_fetch_object($result_class)))
   {
     $b=($j%2);
     $bgcolor=''; 
     if ($b==0)
     {
       $bgcolor="#B8E7FF";
     }

     $data_table = new Smarty_NM();
 
     $class_action=sprintf("view_class.php?school=%s&school_year=%s&department=%s&class_ref=%d&t=%d",$school,$school_year,$department,$field_class->class_ref,time());

     $data_table->assign("bgcolor",$bgcolor);
     $data_table->assign("class",$field_class->class);
     $data_table->assign("number",$field_class->number);
     $data_table->assign("action",$class_action);
     $data_table->assign("class_name",$field_class->class);
     
     $table_class.=$data_table->fetch("grade_select_row.tpl");
     
     $j++;
   } 
  
   $grade++;
   mysql_free_result($result_class);
 }
$data = new Smarty_NM();

$data->assign("table_class",$table_class); 
$data->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));

$data->display("class_select.tpl");
 
?>