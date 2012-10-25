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

$data=new Smarty_NM();
$table_student_admin_select=$data->fetch("admin_select_arrows.tpl");

$table_student_admin='';

// Tuition templates are stored at
// student_admin_data_tuition_part.tpl
// student_admin_select_tuition.tpl

$j=0; // The header information will be defined during the first student row
while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   if ($b==0)
   {  
     $table_student_admin.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   }
   if ($b==1)
   {
     $table_student_admin.=sprintf("<TR>");
   }
   $table_student_admin.=sprintf("
   <td class=\"table_data_blue\">
     %s
   </td>
   <td class=\"table_data_blue\">
     %s
   </td>",$field_student->firstname,$field_student->lastname);
  
   $data_part = new Smarty_NM(); 
  
   $class_tuition='';
  
   if (!empty($field_student->tuition))
   {
     $class_tuition=$field_student->tuition;
   }
   $tuition_name=sprintf("tuition[%d]",$field_student->class_ref);
   $data_part->assign("tuition_name",$tuition_name);
   $data_part->assign("default_tuition",$class_tuition);
   
   $checked_to_school='';
   $checked_from_school='';

   if ($field_student->transportation_to_school=='on')
   {
     $checked_to_school='checked';
   }
   if ($field_student->transportation_from_school=='on')
   {
     $checked_from_school='checked';
   }
 
   $data_part->assign("checked_to_school",$checked_to_school);
   $to_school_name=sprintf("to_school[%d]",$field_student->class_ref);
   $data_part->assign("to_school_name",$to_school_name);
   $data_part->assign("checked_from_school",$checked_from_school);
   $from_school_name=sprintf("from_school[%d]",$field_student->class_ref);
   $data_part->assign("from_school_name",$from_school_name);
   //monday
   $monday_hours='';
   if (!empty($field_student->monday_hours))
   {
     $monday_hours=$field_student->monday_hours;
   }
   $monday_name=sprintf("monday[%d]",$field_student->class_ref);
   $data_part->assign("monday_name",$monday_name);
   $data_part->assign("default_monday",$monday_hours);
   //tuesday
   $tuesday_hours='';
   if (!empty($field_student->tuesday_hours))
   {
     $tuesday_hours=$field_student->tuesday_hours;
   }
   $tuesday_name=sprintf("tuesday[%d]",$field_student->class_ref);
   $data_part->assign("tuesday_name",$tuesday_name);
   $data_part->assign("default_tuesday",$tuesday_hours);
   //wednesday
   $wednesday_hours='';
   if (!empty($field_student->wednesday_hours))
   {
     $wednesday_hours=$field_student->wednesday_hours;
   }
   $wednesday_name=sprintf("wednesday[%d]",$field_student->class_ref);
   $data_part->assign("wednesday_name",$wednesday_name);
   $data_part->assign("default_wednesday",$wednesday_hours);
   //thursday
   $thursday_hours='';
   if (!empty($field_student->thursday_hours))
   {
     $thursday_hours=$field_student->thursday_hours;
   }
   $thursday_name=sprintf("thursday[%d]",$field_student->class_ref);
   $data_part->assign("thursday_name",$thursday_name);
   $data_part->assign("default_thursday",$thursday_hours);
   //friday
   $friday_hours='';
   if (!empty($field_student->friday_hours))
   {
     $friday_hours=$field_student->friday_hours;
   }
   $friday_name=sprintf("friday[%d]",$field_student->class_ref);
   $data_part->assign("friday_name",$friday_name);
   $data_part->assign("default_friday",$friday_hours);
     
   $table_student_admin.=$data_part->fetch("student_admin_data_part.tpl");
 
   $table_student_admin.=sprintf("</tr>");

   if ($j==0) //first student row only
   {
     $select_class_ref_id=-1;
     $data_part = new Smarty_NM();
     $tuition_name=sprintf("tuition[%d]",$select_class_ref_id);
     $data_part->assign("tuition_name",$tuition_name);
     $data_part->assign("default_tuition",$class_tuition);
       
     $data_part->assign("checked_to_school",$checked_to_school);
     $to_school_name=sprintf("to_school[%d]",$select_class_ref_id);
     $data_part->assign("to_school_name",$to_school_name);
     $data_part->assign("checked_from_school",$checked_from_school);
     $from_school_name=sprintf("from_school[%d]",$select_class_ref_id);
     $data_part->assign("from_school_name",$from_school_name);
     $monday_name=sprintf("monday[%d]",$select_class_ref_id);
     $data_part->assign("monday_name",$monday_name);
     $data_part->assign("default_monday",$monday_hours);
     $tuesday_name=sprintf("tuesday[%d]",$select_class_ref_id);
     $data_part->assign("tuesday_name",$tuesday_name);
     $data_part->assign("default_tuesday",$tuesday_hours);
     $wednesday_name=sprintf("wednesday[%d]",$select_class_ref_id);
     $data_part->assign("wednesday_name",$wednesday_name);
     $data_part->assign("default_wednesday",$wednesday_hours);
     $thursday_name=sprintf("thursday[%d]",$select_class_ref_id);
     $data_part->assign("thursday_name",$thursday_name);
     $data_part->assign("default_thursday",$thursday_hours);
     $friday_name=sprintf("friday[%d]",$select_class_ref_id);
     $data_part->assign("friday_name",$friday_name);
     $data_part->assign("default_friday",$friday_hours);

     $table_student_admin_select.=$data_part->fetch("student_admin_data_part.tpl");
     $table_student_admin_select.=sprintf("</tr>");
   }

   $j++; 
  
}//all students
mysql_free_result($result_student);  

$data = new Smarty_NM();
$data->assign("admin_list_all",$table_student_admin_select);
$data->assign("admin_list",$table_student_admin);
$data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
$action=sprintf("student_admin_add.php?school_year=$school_year&school=$school&department=$department&class=$class&grade=$grade&t=%d",time());
$data->assign("student_admin_action",$action);

$data->display("student_admin_select.tpl");
 
?>
