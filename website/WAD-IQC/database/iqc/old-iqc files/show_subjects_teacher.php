<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}


$table_teacher='teacher';
$table_year='teacher_year';
$table_department='teacher_department';
$table_subject='teacher_subject';


$teacher_Stmt ="SELECT * from $table_teacher, $table_year where 
$table_teacher.teacher_ref=$table_year.teacher_ref and
$table_year.year='$school_year' and $table_year.school='$school'
order by $table_teacher.lastname";

$department_Stmt ="SELECT * from $table_department where 
$table_department.year_ref='%d'
order by $table_department.department";

$subject_Stmt ="SELECT * from $table_subject where 
$table_subject.department_ref='%d'
order by $table_subject.subject";


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



//search for maximum of subjects
$subject_number_max=0;

 if (!($result_teacher=mysql_query($teacher_Stmt, $link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;}
  
  while ($field_teacher = mysql_fetch_object($result_teacher))
  {
    if (!($result_department=mysql_query(sprintf($department_Stmt,$field_teacher->year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
      
    while ($field_department = mysql_fetch_object($result_department))
    {
  
      if (!($result_subject=mysql_query(sprintf($subject_Stmt,$field_department->department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
  
      $k=1;
      while ($field_subject = mysql_fetch_object($result_subject))
      {
        if ($k>$subject_number_max)
        {
          $subject_number_max++; 
        }
        $k++;
      } 
      mysql_free_result($result_subject);
    }
    mysql_free_result($result_department);
  }
  mysql_free_result($result_teacher);

  


//end for maximum of subjects

  $content="";
  $data = new Smarty_NM();
  
  if (!($result_teacher=mysql_query($teacher_Stmt, $link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;}
  
  while ($field_teacher = mysql_fetch_object($result_teacher))
  {
    $data = new Smarty_NM();
    
    $data->assign("school",$school);
    $data->assign("school_year",$school_year);
    $data->assign("year_ref",$field_teacher->year_ref);
    $teacher_name=sprintf("%s, %s",$field_teacher->lastname,$field_teacher->firstname);
    $data->assign("teacher",$teacher_name);
    $teacher_name=$data->fetch("teacher_teacher_select.tpl");

    if ($subject_number_max>0)
    {
      $data = new Smarty_NM();
      $data->assign("colspan",$subject_number_max);
      $colspan_data=$data->fetch("teacher_colspan.tpl");
    } 



    $data = new Smarty_NM();
    $bgcolor='#B8E7FF';
    $data->assign("bgcolor",$bgcolor);
    $data->assign("teacher_department",$teacher_name);
    if ($subject_number_max>0)
    {
      $data->assign("colspan_data",$colspan_data);
    }
     $content.=$data->fetch("teacher_teacher.tpl");

    if (!($result_department=mysql_query(sprintf($department_Stmt,$field_teacher->year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  
    $j=0;
    while ($field_department = mysql_fetch_object($result_department))
    {
      $data = new Smarty_NM();
      $data->assign("department",$field_department->department);
      $department_name=$data->fetch("teacher_department_select.tpl");
      
      if (!($result_subject=mysql_query(sprintf($subject_Stmt,$field_department->department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
  
      $k=0;
      $subject_data='';
      while ($field_subject = mysql_fetch_object($result_subject))
      {
        $data = new Smarty_NM();
        $data->assign("subject",$field_subject->subject);
        $subject_data.=$data->fetch("teacher_subject.tpl");  
        $k++;
      } 
      mysql_free_result($result_subject);
      
      if (($subject_number_max-$k)>0)
      {
        $data = new Smarty_NM();
        $data->assign("colspan",$subject_number_max-$k);
        $colspan_data=$data->fetch("teacher_colspan.tpl");
      } 

      $data = new Smarty_NM();
      $bgcolor='';
      $data->assign("bgcolor",$bgcolor);
      $data->assign("teacher_department",$department_name);
      $data->assign("subject_data",$subject_data);
      if (($subject_number_max-$k)>0)
      {
        $data->assign("colspan_data",$colspan_data);
      }
      $content.=$data->fetch("teacher_teacher.tpl");      
    }
    mysql_free_result($result_department);
  }
  mysql_free_result($result_teacher);


  $data = new Smarty_NM();
  $header=sprintf("%s %s",$school,$school_year);
  $data->assign("header",$header);
  $data->assign("content",$content);
  $data->display("teacher_department_subject.tpl");
 
?>