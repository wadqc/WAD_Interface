<?php
require("../globals.php") ;
require("./common.php") ;
require("./../school_data.php") ;
require("./php/includes/setup.php");



//wip
require('./pdf/barcode_creator_pdf.php');
$pdf = new PDF_barcode();

$pdf->FPDF('P','mm','A4');
$pdf->AddPage();

$xcorner=20;
$ycorner=20;

$xpos=$xcorner;
$ypos=$ycorner;
$card_width=84;
$card_height=48;







$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';


$class=$_GET['class'];
$grade=$_GET['grade'];
$department=$_GET['department'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$v=$_GET['v'];

$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$student_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_class_student.year='$school_year' and
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
$id_cards='';
$table_content='';
$page_content='';

$row_counter=0; 
$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
   
// start implementation of new part
  
  $pdf->Image($id_card_background,$xpos,$ypos,'84','','jpg','');
  
  $id_card_logo=sprintf("./logo_pictures/logo_open_school_white.jpg");
  //$pdf->Image($id_card_logo,$xpos+66.5,$ypos+38.5,'',8,'jpg','');
  $pdf->Image($id_card_logo,$xpos+71,$ypos+40,'',5,'jpg','');

  $pdf->SetDrawColor(225,225,225);
  $pdf->SetLineWidth(0.1);
  $pdf->Rect($xpos-0.05,$ypos-0.05,$card_width+0.1,$card_height+0.1);
  $pdf->SetDrawColor(24,32,156);
  $pdf->SetLineWidth(0.2);
  $pdf->Rect($xpos+0.1,$ypos+0.1,$card_width-0.2,$card_height-0.2);
  $pdf->Rect($xpos+0.9,$ypos+0.9,$card_width-1.8,$card_height-1.8);
  
  $student_sex='';
  if ($field_student->sex=='m')
  {
    $student_sex=sprintf("male");
  }
  if ($field_student->sex=='f')
  {
    $student_sex=sprintf("female");
  }
  
  $picture_path=sprintf("%s",$field_student->picture);
  $picture_full_path=sprintf("%s%s",$picture_root,$picture_path);
  $picture_src=sprintf("image_resize.php?f_name=$picture_full_path&height=120");

  $pdf->Image($picture_full_path,$xpos+1.5,$ypos+1.5,'',35,'jpg','');
  
  $address='';
  if ($field_student->lives_with!='')
  {  
    if ($field_student->lives_with=='Father')
    {
      $table_parents='father';
      $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
      $student_link="$table_student.father_ref"; 
      $student_link_ref=$field_student->father_ref; 
    } 
    if ($field_student->lives_with=='Mother')
    {
      $table_parents='mother';
      $parent_student_link="$table_parents.mother_ref=$table_student.mother_ref";
      $student_link="$table_student.mother_ref"; 
      $student_link_ref=$field_student->mother_ref; 
    } 
    if ($field_student->lives_with=='Father & Mother')
    {
      $table_parents='father';
      $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
      $student_link="$table_student.father_ref"; 
      $student_link_ref=$field_student->father_ref; 
    } 
    if ($field_student->lives_with=='Guardian')
    {
      $table_parents='guardian';
      $parent_student_link="$table_parents.guardian_ref=$table_student.guardian_ref";
      $student_link="$table_student.guardian_ref"; 
      $student_link_ref=$field_student->guardian_ref; 
    } 

    $parents_Stmt = "SELECT * from $table_student, $table_parents where $parent_student_link and $student_link='%d'";
    if (!($result_parents= mysql_query(sprintf($parents_Stmt,$student_link_ref), $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    $field_parents = mysql_fetch_object($result_parents);
    $address=$field_parents->home_address;
    mysql_free_result($result_parents);
  }                  
    
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

  //$pdf->SetFont('Arial','',14);
  //$pdf->SetTextColor(16,197,122);
  //$pdf->Text($xpos+29, $ypos+6, $id_card_header);

  $pdf->SetFont('Arial','',10);
  $pdf->SetTextColor(24,32,156);
  $pdf->Text($xpos+35, $ypos+16, $field_student->firstname);
  $pdf->Text($xpos+35, $ypos+20, $field_student->lastname);
  $pdf->Text($xpos+35, $ypos+24, sprintf("%s / %s",$student_date_text,$student_sex));
  //$pdf->Text($xpos+35, $ypos+28, $student_sex);
  $pdf->Text($xpos+35, $ypos+28, substr($address,0,24));
  
  $coding='Code 39';
  $barcode=sprintf("%s",$field_student->number);
  $pdf->SetTextColor(0,0,0);
  $pdf->Text($xpos+1.5,$ypos+46.5, $barcode);
  
  $pdf->create_barcode($xpos+2, $ypos+37, $barcode, 0.3, 6);
  
  $j++;

  //$xpos=$xpos+$card_width+0.1;
  $xpos=$xpos+$card_width+ 1;

  $b=($j%2);
  if (($b==0)&&($j>0))
  {
    $xpos=$xcorner;
    $ypos=$ypos+$card_height+1;
   
    $row_counter++;
  }

  if ($row_counter==5)
  {
    $xpos=$xcorner;
    $ypos=$ycorner;
    $pdf->AddPage();
    
    $row_counter=0;
  }    

}

$pdf->output();
exit();






mysql_free_result($result_student); 

?>