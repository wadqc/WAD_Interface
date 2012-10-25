<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_department='department';
$table_grade='grade';
$table_class='class';
$table_subject='subject';

$year=$_GET['year'];
$department=$_GET['department'];

//$delete_Stmt_department = "DELETE from $table_department WHERE
//$table_department.department_ref='%d'";

$delete_Stmt_grade = "DELETE from $table_grade WHERE
$table_grade.grade='%s' and
$table_grade.department_ref='%d'";

$delete_Stmt_class = "DELETE from $table_class WHERE
$table_class.grade_ref='%d'";

$delete_Stmt_subject = "DELETE from $table_department WHERE
$table_department.department_ref='%d'";


$select_Stmt_department = "select * from $table_department WHERE
$table_department.department='%s' and 
$table_department.year='%s'";

$select_Stmt_grade = "select * from $table_grade WHERE
$table_grade.department_ref='%d' and 
$table_grade.grade='%s'";



$add_Stmt_department = "Insert into $table_department(department,year) values ('%s','%s')";
$add_Stmt_grade = "Insert into $table_grade(grade,department_ref) values ('%s','%d')";
$add_Stmt_class = "Insert into $table_class(class,number,grade_ref) values ('%s','%d','%d')";



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

//query for excisting department or create department if not excists

if (!($result_department=mysql_query(sprintf($select_Stmt_department,$department,$year),$link))){
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$department_ref=-1; //verify whether or not the department excists
while($field_department = mysql_fetch_object($result_department))
{
   $department_ref=$field_department->department_ref;
}

mysql_free_result($result_department);

if ($department_ref==-1) //department not available, create new department
{
  if (!(mysql_query(sprintf($add_Stmt_department,$department,$year),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }

  if (!($result_department=mysql_query(sprintf($select_Stmt_department,$department,$year),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $field_department = mysql_fetch_object($result_department);
  $department_ref=$field_department->department_ref;
  mysql_free_result($result_department);
}

// department defined


  $grade_key=array_keys($class);
  
  $first_key=$grade_key[0];
  $number_key=array_keys($class[$first_key]);
  
  $i=0;
  while ($i<sizeof($grade_key)) // loop for $grades
  {
    //query for excisting grade or create grade if not excists
    if (!($result_grade=mysql_query(sprintf($select_Stmt_grade,$department_ref,$i),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }

    $grade_ref=-1; //verify whether or not the grade excists
    while($field_grade = mysql_fetch_object($result_grade))
    {
      $grade_ref=$field_grade->grade_ref;
    }
    mysql_free_result($result_grade);

    if ($grade_ref==-1) //grade not available, create new grade
    {
      if (!(mysql_query(sprintf($add_Stmt_grade,$i,$department_ref),$link))){
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
  
      if (!($result_grade=mysql_query(sprintf($select_Stmt_grade,$department_ref,$i),$link))){
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ; }
    
      $field_grade = mysql_fetch_object($result_grade);
      $grade_ref=$field_grade->grade_ref;
      mysql_free_result($result_grade);   
    }

    // grade defined
    
    //delete all classes for this grade
    if (!(mysql_query(sprintf($delete_Stmt_class,$grade_ref),$link))) 
    {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    $j=0;
    while ($j<sizeof($number_key)) //rebuild all classes
    {
      
      if ($class[$grade_key[$i]][$number_key[$j]]!='')
      {
        if (!(mysql_query(sprintf($add_Stmt_class,$class[$grade_key[$i]][$number_key[$j]],$number_key[$j],$grade_ref),$link))) 
        {
           DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
           DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
           exit() ;
        }
      }
      
      $j++;
    }
    
    $i++;
  }

  GenerateHTMLHeader("The department entry was build succesfully");
  ReturnToMain();
  
?>