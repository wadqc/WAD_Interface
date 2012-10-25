<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$year_ref=$_GET['year_ref'];


$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$table_school='school';
$table_year='year';
$table_department='department';
$subject=$_POST['subject'];


$add_department_Stmt = "Insert into $table_teacher_department(department,year_ref) values ('%s','%d')";

$add_subject_Stmt="Insert into $table_teacher_subject(subject,department_ref) values ('%s','%s')";

$delete_Stmt_department = "DELETE from $table_teacher_department WHERE
$table_teacher_department.department_ref='%d'";

$delete_Stmt_subject = "DELETE from $table_teacher_subject WHERE
$table_teacher_subject.department_ref='%d'";

$department_Stmt = "select * from $table_teacher_department WHERE
$table_teacher_department.year_ref='%d' and
$table_teacher_department.department='%s'";

$department_query= "select * from $table_school, $table_year, $table_department WHERE
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'";


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

   
  if (!($result_query_department= mysql_query($department_query,$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  
  //query for all available departments
  while ($field_department_query = mysql_fetch_object($result_query_department)) 
  {
     //delete teacher_department and teacher_subject
     if (!($result_department=
  mysql_query(sprintf($department_Stmt,$year_ref,$field_department_query->department),$link)))
     {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
     }
     $department_ref=-1;
     $counter=0;  
     while (($field_department = mysql_fetch_object($result_department)))
     {
       if ($counter>0)
       {
         printf("database structure for teacher_department and teacher_subject
  isn't unique");
       }
       $department_ref=$field_department->department_ref;
       $counter++;
     }
     mysql_free_result($result_department);
     
     if ($department_ref>0) //department and subject excist and should be deleted first
     {
       //delete teacher_subject
       if (!(mysql_query(sprintf($delete_Stmt_subject,$department_ref),$link))) 
       {
         DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
         exit() ;
       }

       //delete teacher_department
       if (!(mysql_query(sprintf($delete_Stmt_department,$department_ref),$link))) 
       {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
       }
     } 
     
     $subject_number=0;
     $subject_counter=0;    
 
     if (!empty($subject[$field_department_query->department]))
     {
       $subject_key=array_keys($subject[$field_department_query->department]);
       $subject_counter= sizeof($subject_key);
     }
     $j=0;
     
     while ($j<$subject_counter) //loop for $subject
     {
      if ($subject[$field_department_query->department][$subject_key[$j]]=='on')
      {
        if ($subject_number==0) //a teacher_department should be created
        {
          if (!(mysql_query(sprintf($add_department_Stmt,$field_department_query->department,$year_ref),$link))) 
          {
            DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
            exit() ;
          }
          //query for department_ref;
          if (!($result_department= mysql_query(sprintf($department_Stmt,$year_ref,$field_department_query->department),$link))) {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
          }
          $field_department = mysql_fetch_object($result_department);
          $department_ref=$field_department->department_ref;
          mysql_free_result($result_department);
          $subject_number++;
        }
        if (!(mysql_query(sprintf($add_subject_Stmt,$subject_key[$j],$department_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      $j++;
     } //all subjects
  } //all departments
  mysql_free_result($result_query_department);
  

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_subjects_teacher.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
?>