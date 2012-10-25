<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_teacher='teacher';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$v=$_GET['v'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];

$department=$_GET['department'];
$class=$_GET['class'];
$grade=$_GET['grade'];

$new_student_ref=''; 
if (!empty($_GET['new_student_ref']))
{
 $new_student_ref=$_GET['new_student_ref']; 
}

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";

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



if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}





$student_table="";

$data = new Smarty_NM();
$student_table=$data->fetch("student_select_teacher_header.tpl");
  

$previous_id='';
 
$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
 if ($previous_id!=$field_student->student_ref)
 {

   $b=($j%2);
   $bgcolor='';
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }
   
   $action_name=sprintf("parental_handling.php?v=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&new_student_ref=%s&t=%d",$v,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$new_student_ref,time());
   $data = new Smarty_NM();
   $data->assign("bgcolor",$bgcolor);
   $data->assign("student_number",$field_student->number);
   $data->assign("action",$action_name);
   $data->assign("student_fname",$field_student->firstname);
   $data->assign("student_lname",$field_student->lastname);
   $data->assign("profile",$field_student->profile);
   $student_table.=$data->fetch("student_select_teacher_row.tpl");
   
   $previous_id=$field_student->student_ref;
   $j++;
 }  
}


mysql_free_result($result_student);  

$data = new Smarty_NM();

$data->assign("header",sprintf("School year %s Department %s Class %s",$school_year,$department,$class));
$data->assign("student_list",$student_table);

$data->display("student_select_teacher.tpl");

?>