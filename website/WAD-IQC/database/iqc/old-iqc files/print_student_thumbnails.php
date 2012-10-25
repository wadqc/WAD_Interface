<?php
require("../globals.php") ;
require("./common.php") ;
require("./../school_data.php");
require("./php/includes/setup.php");

require('./pdf/fpdf.php');
require('./pdf/barcode_creator_pdf.php');

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



$pdf = new PDF_barcode();

$pdf->FPDF('L','mm',$pdf_format);
$pdf->AddPage();

$xcorner=10;
$ycorner=10;

$xpos=$xcorner;
$ypos=$ycorner;

$x_shift=30;
$y_shift=51;

$j=0; 
$i=0;
$b=0;
$row_counter=0;
$header_counter=0;
$header_string=sprintf("Students at %s %s Department %s Class %s",$school_project_name,$school_year,$department,$class);
$id_card_logo=sprintf("./logo_pictures/logo_open_school_white.jpg");

while (($field_student = mysql_fetch_object($result_student)))
{
  
  $student_picture=sprintf("%s%s",$picture_root,$field_student->picture);
  

  $pdf->SetDrawColor(225,225,225);
  $pdf->SetLineWidth(0.1);

  if ($header_counter==0)
  {
    $pdf->SetFont('Arial','',14);
    $pdf->SetTextColor(24,32,156);
    $pdf->Text($xpos+20, $ypos-3, $header_string);
    $pdf->Image($id_card_logo,$xpos,$ypos-8,'',6,'jpg','');
    $header_counter++;
  }
  
  $pdf->Image($student_picture,$xpos+1.5,$ypos+1.5,'28','','jpg','');
  

  $pdf->SetFillColor(255,255,255);
  $pdf->Rect($xpos,$ypos+42,$x_shift,8,'F');
  
  $pdf->SetDrawColor(0,0,0);
  $pdf->SetLineWidth(0.05);
  //$pdf->Rect($xpos+0.05,$ypos+42.05,$x_shift-0.1,8-0.1); 


  //$student_f_name=sprintf("%s (%s)",$field_student->firstname, $field_student->sex);
  $student_f_name=sprintf("%s",$field_student->firstname);
  $student_l_name=sprintf("%s",$field_student->lastname);

  $pdf->SetFont('Arial','',10);
  $pdf->SetTextColor(0,0,0);
  $pdf->Text($xpos+1.5, $ypos+45, $student_f_name);
  $pdf->Text($xpos+1.5, $ypos+49, $student_l_name);
  $j++;

  $xpos=$xpos+$x_shift+0.1;

  $b=($j%8);
  if (($b==0)&&($j>0))
  {
    $xpos=$xcorner;
    $ypos=$ypos+$y_shift;
   
    $row_counter++;
  }

  if ($row_counter==5)
  {
    $xpos=$xcorner;
    $ypos=$ycorner;
    $pdf->AddPage();
    
    $row_counter=0;
    $header_counter=0;
  }    

}

$pdf->output();
exit();






?>