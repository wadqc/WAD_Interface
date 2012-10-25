<?php

require("../globals.php") ;
require("./common.php") ;
require("./print_student_function.php") ;
require("./php/includes/setup.php");

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$table_teacher='teacher';

$table_doctor='doctor';

$v=$_GET['v'];
$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$class_ref=$_GET['class_ref'];
$father_ref=$_GET['father_ref'];
$mother_ref=$_GET['mother_ref'];
$guardian_ref=$_GET['guardian_ref'];

$p=0;
if(!empty($_GET['p']))
{
  $p=$_GET['p'];
}

if ($p==1)
{
  $data = new Smarty_NM(); 
  $data->assign("error_message","No permission");
  $data->display("error_message_plain.tpl");
  exit(); 
}


print_single_student($class_ref,$department,$class,$school_year,$grade,$school,0);
exit();



$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.class_ref='$class_ref' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";

$class_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref='%d' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_class_student.year";

$teacher_Stmt = "SELECT * from $table_teacher";

$doctor_Stmt = "SELECT * from $table_doctor where
$table_doctor.school='$school' and 
$table_doctor.doctor_ref='%d'";


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

if (!($result_teacher= mysql_query($teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}





$field_teacher=mysql_fetch_object($result_teacher);
$initials=$field_teacher->initials;
mysql_free_result($result_teacher);

$field_student = mysql_fetch_object($result_student);

//convert date into txt format
$student_day = substr($field_student->date_of_birth,8,2); 
$student_month  = substr($field_student->date_of_birth,5,2); 
$student_year = substr($field_student->date_of_birth,0,4);
$student_month_text=date ("M",mktime(0,0,0,$student_month,$student_day,$student_year)); 
$student_date_text=sprintf("%s-%s-%s",$student_month_text,$student_day,$student_year); 
if ($field_student->date_of_birth=='0000-00-00')
{
  $student_date_text=sprintf("MM-DD-YYYY");
}

//obtain doctor info
if (!($result_doctor= mysql_query(sprintf($doctor_Stmt,$field_student->doctor_ref), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
}

$field_doctor = mysql_fetch_object($result_doctor); 

$medical_doctor=sprintf("%s %s %s",$field_doctor->title,$field_doctor->firstname,$field_doctor->lastname);
$medical_doctor_phone=$field_doctor->phone;
$medical_doctor_address=$field_doctor->address;

mysql_free_result($result_doctor);



if ($field_student->mentor==$initials)
{
  $v=0;
}





$student_table = new Smarty_NM();


  $student_table->assign("student_number",$field_student->number);
  $student_table->assign("student_firstname",$field_student->firstname);
  $student_table->assign("student_middlename",$field_student->middlename);
  $student_table->assign("student_lastname",$field_student->lastname);
  $student_table->assign("student_callname",$field_student->callname);
  $student_table->assign("student_sex",$field_student->sex);
  $student_table->assign("student_date_of_birth",$student_date_text);
  $student_table->assign("student_place_of_birth",$field_student->place_of_birth);
  $student_table->assign("student_nationality",$field_student->nationality);
  $student_table->assign("student_residence_permit",$field_student->residence_permit);
  $student_table->assign("student_religion",$field_student->religion);
  $student_table->assign("student_language",$field_student->language);
  $student_table->assign("student_username",$field_student->username);
  $student_table->assign("student_password",$field_student->password);
  $student_table->assign("student_email",$field_student->email);
  $student_table->assign("student_lives_with",$field_student->lives_with);
  $student_table->assign("student_general",$field_student->general);
  $student_table->assign("student_transportation",$field_student->transportation);
  if ($field_student->transportation_to_school=='on')
  {
    $student_table->assign("transportation_to_school",'X');
  }
  if ($field_student->transportation_from_school=='on')
  {
    $student_table->assign("transportation_from_school",'X');
  }
  
  $student_table->assign("student_free_field1",$field_student->free_field1);
  $student_table->assign("student_free_field2",$field_student->free_field2);

  //registration
  $student_table->assign("registration_entry_language",$field_student->entry_language);
  $student_table->assign("registration_entry_math",$field_student->entry_math);
  $student_table->assign("registration_entry_general",$field_student->entry_general);
  $student_table->assign("registration_comes_from",$field_student->comes_from);
  $student_table->assign("registration_school_in",$field_student->school_in);
  if ($field_student->school_in=='0000-00-00')
  {
    $student_table->assign("registration_school_in","MM-DD-YYYY");
  }
  $student_table->assign("registration_school_out",$field_student->school_out);
  if ($field_student->school_out=='0000-00-00')
  {
    $student_table->assign("registration_school_out","MM-DD-YYYY");
  }
  $student_table->assign("registration_department_in",$field_student->department_in);
  if ($field_student->department_in=='0000-00-00')
  {
    $student_table->assign("registration_department_in","MM-DD-YYYY");
  }
  $student_table->assign("registration_department_out",$field_student->department_out);
  if ($field_student->department_out=='0000-00-00')
  {
    $student_table->assign("registration_department_out","MM-DD-YYYY");
  }

  $student_table->assign("registration_profile",$field_student->profile);
  $student_table->assign("registration_went_to",$field_student->went_to);
  $student_table->assign("registration_reason_out",$field_student->reason_out);

  //medical
  $student_table->assign("medical_doctor",$medical_doctor);
  $student_table->assign("medical_doctor_address",$medical_doctor_address); 
  $student_table->assign("medical_doctor_phone",$medical_doctor_phone);  
  $student_table->assign("medical_vaccination_card",$field_student->vaccination_card);
  $student_table->assign("medical_problems",$field_student->medical_problems);
  $student_table->assign("medical_medication",$field_student->medication);

  //parental
  $father_siblings='';
  $mother_siblings='';
  $guardian_siblings='';
  $table_fmg='';
  if ( ($father_ref>0)||($mother_ref>0)||($guardian_ref>0) )  //get parental data
  {
    parental_function_siblings($class_ref,$father_ref,$mother_ref,$guardian_ref,&$father_siblings,&$mother_siblings,&$guardian_siblings);
    parental_function_fmg($class_ref,$father_ref,$mother_ref,$guardian_ref,$father_siblings,$mother_siblings,$guardian_siblings,&$table_fmg);
  }
  $student_table->assign("table_fmg",$table_fmg);


$student_table->assign("student_school",$field_student->school);
$student_table->assign("student_department",$field_student->department);
$student_table->assign("student_class",$field_student->class);
$student_table->assign("student_profile",$field_student->profile);

$picture_path=sprintf("%s",$field_student->picture);
$picture_full_path=sprintf("%s%s",$picture_root,$picture_path);
$student_table->assign("student_picture",$picture_full_path);

if (!($result_class= mysql_query(sprintf($class_Stmt,$field_student->student_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_student); 

$klas_content='';

while ($field_class = mysql_fetch_object($result_class))
{
  $klas_content.=sprintf("
  <tr>
    <td class=\"table_data\"> $field_class->year </td>
    <td class=\"table_data\"> $field_class->school </td>
    <td class=\"table_data\"> $field_class->department </td>
    <td class=\"table_data\"> class:$field_class->class </td>
    <td class=\"table_data\"> mentor:$field_class->mentor </td>
  </tr>");
}
mysql_free_result($result_class); 

$student_table->assign("klas_content",$klas_content);

$student_table->display("view_student_print.tpl");

?>