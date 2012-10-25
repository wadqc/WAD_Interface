<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];


$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$teacher_Stmt="SELECT * from $table_teacher, $table_teacher_year,
$table_teacher_department where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref=$table_teacher_department.year_ref and
$table_teacher_year.year='$school_year' and
$table_teacher_year.school='$school' and
$table_teacher_department.department='$department' 
order by $table_teacher.initials";


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

if (!($result_teacher= mysql_query($teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$j=0;
while (($field = mysql_fetch_object($result_teacher)))
{
  $teacher_list[$field->initials]=$field->initials;
}  
mysql_free_result($result_teacher); 
$teacher_number=count($teacher_list);

$table_mentor='';
$data=new Smarty_NM();
$table_mentor_select=$data->fetch("mentor_select_arrows.tpl");

$j=0; // The header information will be defined during the first student row
while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   if ($b==0)
   $table_mentor.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_mentor.=sprintf("<TR>");
   $table_mentor.=sprintf("
   <td class=\"table_data_blue\">
     %s
   </td>
   <td class=\"table_data_blue\">
     %s
   </td>",$field_student->firstname,$field_student->lastname);
    
   $class_mentor='';
  
   if (!empty($field_student->mentor))
   {
     $class_mentor=$field_student->mentor;
   }
   $data_part = new Smarty_NM();
   $teacher_name=sprintf("mentor[%d]",$field_student->class_ref);
   $data_part->assign("teacher_name",$teacher_name);
   $data_part->assign("teacher_options",$teacher_list);
   $data_part->assign("teacher_id",$class_mentor);
           
   $table_mentor.=$data_part->fetch("mentor_data_part.tpl");
 
   $table_mentor.=sprintf("</tr>");

   if ($j==0)
   {
     $select_class_ref_id=-1;
     $data_part = new Smarty_NM();
     $teacher_name=sprintf("mentor[%d]",$select_class_ref_id);
     $data_part->assign("teacher_name",$teacher_name);
     $data_part->assign("teacher_options",$teacher_list);
     $data_part->assign("teacher_id",$class_mentor);
           
     $table_mentor_select.=$data_part->fetch("mentor_data_part.tpl");
    
   }
   $j++; 
  
}//all students
mysql_free_result($result_student);  

$data = new Smarty_NM();
$data->assign("mentor_list_all",$table_mentor_select);
$data->assign("mentor_list",$table_mentor);
$data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
$data->assign("mentor_overall_name",sprintf("mentor_overall"));
$data->assign("teacher_overall_options",$teacher_list);
$data->assign("teacher_overall_id",'');
$action=sprintf("mentor_add.php?school_year=$school_year&school=$school&department=$department&class=$class&grade=$grade&t=%d",time());
$data->assign("mentor_action",$action);

$data->display("mentor_select.tpl");
 
?>
