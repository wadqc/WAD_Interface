<?php

function add_student_student($student_number,$student_firstname,$student_middlename,$student_lastname,$student_callname,$student_sex,$student_date_of_birth,$student_place_of_birth,$student_nationality,$student_residence_permit,$student_expiration_date,$student_religion,$student_language,$student_username,$student_password,$student_email,$student_lives_with,$student_general,$student_free_field1,$student_free_field2,$registration_entry_language,$registration_entry_math,$registration_entry_general,$registration_comes_from,$registration_profile,$registration_went_to,$registration_reason_out,$medical_vaccination_card,$medical_problems,$medical_medication,$doctor_ref,$father_ref,$mother_ref,$guardian_ref,&$student_ref)
{

require("../globals.php") ;

$table_student='student';

$addStmt_student = "Insert into
$table_student(number,firstname,middlename,lastname,callname,sex,date_of_birth,place_of_birth,nationality,residence_permit,expiration_date,religion,language,username,password,email,lives_with,general,free_field1,free_field2,entry_language,entry_math,entry_general,comes_from,profile,went_to,reason_out,vaccination_card,medical_problems,medication,doctor_ref,father_ref,mother_ref,guardian_ref) values ('%s','%s', '%s','%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s','%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s','%s', '%s','%s','%s','%s','%d','%d','%d','%d')";

$queryStmt_student = "Select * from $table_student where 
$table_student.number='%s' and
$table_student.firstname='%s' and
$table_student.lastname='%s' and
$table_student.sex='%s' and
$table_student.date_of_birth='%s' ";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) 
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) 
{
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  //add student
  if(!mysql_query(sprintf($addStmt_student,$student_number,$student_firstname,$student_middlename,$student_lastname,$student_callname,$student_sex,$student_date_of_birth,$student_place_of_birth,$student_nationality,$student_residence_permit,$student_expiration_date,$student_religion,$student_language,$student_username,$student_password,$student_email,$student_lives_with,$student_general,$student_free_field1,$student_free_field2,$registration_entry_language,$registration_entry_math,$registration_entry_general,$registration_comes_from,$registration_profile,$registration_went_to,$registration_reason_out,$medical_vaccination_card,$medical_problems,$medical_medication,$doctor_ref,$father_ref,$mother_ref,$guardian_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  //query student
 
  if (!($result_query= mysql_query(sprintf($queryStmt_student,$student_number,$student_firstname,$student_lastname,$student_sex,$student_date_of_birth), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }

   $field_query = mysql_fetch_object($result_query);
   $student_ref=$field_query->student_ref;
   mysql_free_result($result_query); 

  
}

function add_student_school($school,$school_in,$school_out,$student_ref,$school_ref)
{
require("../globals.php") ;


$table_school='school_student';

$addStmt_school = "Insert into $table_school(school,school_in,school_out,student_ref)
values ('%s','%s','%s','%d')";

$queryStmt_school = "Select * from $table_school where 
$table_school.school='%s' and
$table_school.student_ref='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) 
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) 
{
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

   //add school  
  if (!mysql_query(sprintf($addStmt_school,$school,$school_in,$school_out,$student_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  //query school  
  if (!($result_query= mysql_query(sprintf($queryStmt_school,$school,$student_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }

  $field_query = mysql_fetch_object($result_query);
  $school_ref=$field_query->school_ref;
  mysql_free_result($result_query);

}


function add_student_department($department,$department_in,$department_out,$school_ref,$department_ref)
{
require("../globals.php") ;


$table_department='department_student';

$addStmt_department = "Insert into $table_department(department,department_in,department_out,school_ref)
values ('%s','%s','%s','%d')";

$queryStmt_department = "Select * from $table_department where 
$table_department.department='%s' and
$table_department.school_ref='%d'";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) 
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) 
{
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  //add_department
  if (!mysql_query(sprintf($addStmt_department,$department,$department_in,$department_out,$school_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  //query department  
  if (!($result_query= mysql_query(sprintf($queryStmt_department,$department,$school_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }

  $field_query = mysql_fetch_object($result_query);
  $department_ref=$field_query->department_ref;
  mysql_free_result($result_query);

}


function add_student_class($grade,$class,$year,$profile,$picture,$student_to_school,$student_from_school,$department_ref,$class_ref)
{
require("../globals.php") ;

$table_class='class_student';


$addStmt_class = "Insert into $table_class(class,grade,year,profile,picture,transportation_to_school,transportation_from_school,department_ref)
values ('%s','%s','%s','%s','%s','%s','%s','%d')";

$queryStmt_class = "Select * from $table_class where
$table_class.class='%s' and 
$table_class.grade='%s' and
$table_class.year='%s' and 
$table_class.profile='%s' and
$table_class.picture='%s' and
$table_class.transportation_to_school='%s' and
$table_class.transportation_from_school='%s' and
$table_class.department_ref='%d'";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) 
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) 
{
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  //add_class
  if (!mysql_query(sprintf($addStmt_class,$class,$grade,$year,$profile,$picture,$student_to_school,$student_from_school,$department_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  //query class  
  if (!($result_query= mysql_query(sprintf($queryStmt_class,$class,$grade,$year,$profile,$picture,$student_to_school,$student_from_school,$department_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }

  $field_query = mysql_fetch_object($result_query);
  $class_ref=$field_query->class_ref;
  mysql_free_result($result_query);

}

?>