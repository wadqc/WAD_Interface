<?php
require("../globals.php") ;
require("./common.php") ;
require("./../school_data.php") ;
require("./php/includes/setup.php");



//wip
require('./pdf/fpdf.php');
$pdf = new FPDF();

$pdf->FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->Rect(0, 0, 84, 48);







//$pdf->Output();
//exit();

















//end wip


















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


  $student_table = new Smarty_NM();
  
  $student_table->assign("id_card_header",$id_card_header);
  $student_table->assign("student_firstname",$field_student->firstname);
  $student_table->assign("student_lastname",$field_student->lastname);
  $student_table->assign("student_date_of_birth",$field_student->date_of_birth);
  $student_sex='';
  if ($field_student->sex=='m')
  {
    $student_sex=sprintf("male");
  }
  if ($field_student->sex=='f')
  {
    $student_sex=sprintf("female");
  }
  $student_table->assign("student_sex",$student_sex);
  $student_table->assign("student_lives_with",$field_student->lives_with);
  $picture_path=sprintf("%s",$field_student->picture);
  $picture_full_path=sprintf("%s%s",$picture_root,$picture_path);
  $picture_src=sprintf("image_resize.php?f_name=$picture_full_path&height=120");
  $pdf->Image($picture_full_path,1,1,'',35,'jpg','');
  
  $student_table->assign("picture_student",$picture_src);
  
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
  $student_table->assign("student_address",$address);
  
  
  $coding='Code 39';
  $barcode=sprintf("%s",$field_student->number);

  //barcode picture will be created on the fly, by refering directly to the
  //script that creates the barcode.
  
  
  $barcode_url = sprintf("http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $barcode_url.= sprintf("barcode_creator.php?&barcode=$barcode");
  $pdf->Image($barcode_url,1,40,'',10,'jpg','');
  $pdf->Output();
  exit();
  $student_table->assign("picture_barcode",$barcode_url);
  $student_table->assign("barcode",$barcode);
  $j++;

  $student_table->assign("picture_logo_id","./logo_pictures/logo_sdh_id.jpg");
  $id_cards.=sprintf("<td width=\"323px\">");
  $id_cards.=$student_table->fetch("view_id_card.tpl");
  $id_cards.=sprintf("</td>");
  $b=($j%2);
  if (($b==0)&&($j>0))
  {
    $table_content.=sprintf("<tr>%s</tr>",$id_cards);
    $id_cards='';
    $row_counter++;
  }

  if ($row_counter==4)
  {
    $card_page = new Smarty_NM();
    $card_page->assign("table_content",$table_content);
    $page_content.=$card_page->fetch("id_cards_page.tpl");
    $row_counter=0;
    $table_content='';
  }    

}
if ($b!=0)
{
  while ($b<3)
  {
    $id_cards.=sprintf("<td></td>");
    $b++;
  }
  $table_content.=sprintf("<tr>%s</tr>",$id_cards);
  $card_page = new Smarty_NM();
  $card_page->assign("table_content",$table_content);
  $page_content.=$card_page->fetch("id_cards_page.tpl");
}



mysql_free_result($result_student); 

$card = new Smarty_NM();
$card->assign("page_content",$page_content);
$card->display("id_cards_form.tpl");





?>