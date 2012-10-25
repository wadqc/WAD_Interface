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

$school_t=$_GET['school'];
$school_year_t=$_GET['school_year'];
$department_t=$_GET['department'];
$class_t=$_GET['class'];
$grade_t=$_GET['grade'];

if (!empty($_GET['school_t']))
{
  $school_t=$_GET['school_t'];
}
if (!empty($_GET['year_t']))
{
  $school_year_t=$_GET['year_t'];
}
if (!empty($_GET['department_t']))
{
  $department_t=$_GET['department_t'];
}
if (!empty($_GET['class_t']))
{
  $class_t=$_GET['class_t'];
}
if (!empty($_GET['grade_t']))
{
  $grade_t=$_GET['grade_t'];
}


$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$class_Stmt="SELECT * from $table_school, $table_year,$table_department, $table_grade, $table_class where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_school.school='$school_t' and
$table_department.department='$department_t' and
$table_year.year='$school_year_t' and 
$table_grade.grade = $grade_t
order by $table_class.number"; 

$grade_Stmt="SELECT * from $table_school, $table_year,$table_department, $table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='$school_t' and
$table_department.department='$department_t' and
$table_year.year='$school_year_t' 
order by $table_grade.grade"; 

$department_Stmt="SELECT * from $table_school, $table_year,$table_department where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='$school_t' and
$table_year.year='$school_year_t' 
order by $table_department.number"; 

$year_Stmt="SELECT * from $table_school, $table_year where
$table_school.school_ref=$table_year.school_ref and
$table_school.school='$school_t' 
order by $table_year.year"; 

$school_Stmt = "SELECT * from $table_school 
order by $table_school.school";





//admin, management, secretary 
if ( (!empty($user_level_1)) || (!empty($user_level_2)) || (!empty($user_level_5)) )
{
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

  $next_Stmt= "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student where 
  $table_student.student_ref='%s' and
  $table_class_student.year='%s' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref
  order by $table_student.lastname, $table_student.firstname";

}
  $teacher_Stmt = "SELECT * from $table_teacher
  where $table_teacher.login = '$user'";


//teacher and attendance
if ( (!empty($user_level_3)) || (!empty($user_level_4)) )   
{
  
  $student_Stmt = "SELECT * from $table_student, $table_school_student,
  $table_department_student, $table_class_student, $table_subjects where 
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref and
  $table_class_student.class_ref=$table_subjects.class_ref and
  $table_class_student.year='$school_year' and
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.class='$class' and
  ($table_subjects.teacher='%s' or $table_class_student.mentor='%s')
  order by $table_student.lastname, $table_student.firstname";
}


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
   $field = mysql_fetch_object($result_teacher);
   $initials=$field->initials;

   mysql_free_result($result_teacher);

//teacher and attendance
if ( (!empty($user_level_3)) || (!empty($user_level_4)) )    
{   
   if (!($result_student= mysql_query(sprintf($student_Stmt,$initials,$initials), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
}

//admin, management, secretary 
if ( (!empty($user_level_1)) || (!empty($user_level_2)) || (!empty($user_level_5)) )
{
   if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
}



$student_table="";
if (!empty($user_level_1)) //admin
{ 
  $data = new Smarty_NM();
  $student_table=$data->fetch("student_select_header.tpl");
}  

if (empty($user_level_1))
{ 
  $data = new Smarty_NM();
  $student_table=$data->fetch("student_select_teacher_header.tpl");
}  

$previous_id='';
 
$male_students=0;
$female_students=0;

$j=0; 
$i=0;
$picture_content='';
$picture_row='';
$name_row='';
$table_content='';
$b=0;


while (($field_student = mysql_fetch_object($result_student)))
{
  if ($previous_id!=$field_student->student_ref)
  {
    $picture = new Smarty_NM();
    $name = new Smarty_NM();
    $student_picture=sprintf("%s%s",$picture_root,$field_student->picture);
    //$student_picture=sprintf("%s",$field_student->picture);
    //printf("student_picture=%s",$student_picture);
    $picture_src=sprintf("image_resize.php?f_name=$student_picture&height=120");
    $picture->assign("picture_src",$picture_src);
    if (!empty($user_level_1))  //admin
    { 
      $p=0;
      $action_name=sprintf("view_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
    }
    if (empty($user_level_1))
    { 
      if ( ($field_student->mentor!=$initials) && ( (!empty($user_level_3)) || (!empty($user_level_4))) ) 
      {
        // not a mentor and (teacher or attendance)
        $p=1;
      }
      $action_name=sprintf("view_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
    } 
 
    $picture->assign("picture_action",$action_name);

    $student_name=sprintf("%s %s (%s)",$field_student->firstname, $field_student->lastname, $field_student->sex);
    $name->assign("picture_name",$student_name);   
  
    $picture_row.=$picture->fetch("insert_picture_row.tpl");
    $name_row.=$name->fetch("insert_picture_name_row.tpl");
   
    $j++;
    $b=($j%8);
    if (($b==0)&&($j>0))
    {
      $table_content.=sprintf("<tr>%s</tr>",$picture_row);
      $table_content.=sprintf("<tr>%s</tr>",$name_row);
      $picture_row='';
      $name_row='';
    }
    $previous_id=$field_student->student_ref; 
  }
}  

mysql_free_result($result_student);

if ($b!=0)
{
  while ($b<8)
  {
    $picture_row.=sprintf("<td></td>");
    $name_row.=sprintf("<td></td>");
    $b++;
  }
  $table_content.=sprintf("<tr>%s</tr>",$picture_row);
  $table_content.=sprintf("<tr>%s</tr>",$name_row);
}



$pic = new Smarty_NM();
$pic->assign("header",sprintf("School year %s Department %s Class %s",$school_year,$department,$class));
$pic->assign("action_print",sprintf("print_student_thumbnails.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s",$grade,$department,$class,$school_year,$v,$school) );






$pic->assign("table_rows",$table_content);

$pic->display("student_thumbs.tpl");





?>