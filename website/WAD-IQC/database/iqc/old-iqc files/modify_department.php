<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department_ref=$_GET['department_ref'];


$table_school='school';
$table_year='year';
$table_department='department';




$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';


$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student where 
$table_school_student.school='$school' and
$table_department_student.department='%s' and 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref";




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


$department = new Smarty_NM();


//$department->assign("time_department",time());

$department->assign("submit_value","Modify");  

  
  $department_Stmt = "SELECT * from $table_school, $table_year, $table_department where 
  $table_school.school_ref=$table_year.school_ref and
  $table_year.year_ref=$table_department.year_ref and  
  $table_department.department_ref=$department_ref";
 
  
  if (!($result_department= mysql_query($department_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_department = mysql_fetch_object($result_department)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  // start part
  if (!($result_student= mysql_query(sprintf($student_Stmt,$field_department->department) , $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  
  while (($field_student = mysql_fetch_object($result_student)))
  {
     $content="";
     $content.=sprintf("<tr><td class=\"table_data\">There are students linked to department %s for the school year %s. Department can not be modified!</td></tr>",$field_department->department,$school_year);  
  } 
  mysql_free_result($result_student);  

  if ($content!="") //department contains students
  {
    $data = new Smarty_NM();
    $data->assign("content",$content);
    $data->display("subject_department_excist.tpl");
  }

  if (!($content)) //new department
  {

    $department->assign("default_number",$field_department->number);
    $department->assign("default_department",$field_department->department);

    $school_year=$field_department->year;
    
    mysql_free_result($result_department);


  
    $department->assign("action_new_department",sprintf("update_department.php?school=$school&school_year=$school_year&department_ref=$department_ref&t=%d",time()));  
    $department->assign("term",$school_year);

    $department->display("new_department.tpl");
 
  } 


?>











