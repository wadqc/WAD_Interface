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







$table_teacher='teacher';
$table_year='teacher_year';


$school=$_GET['school'];
$school_year=$_GET['school_year'];
$v=$_GET['v'];


$teacher_Stmt = "SELECT * from $table_teacher, $table_year where 
$table_year.school='$school' and $table_year.year='$school_year' and
$table_teacher.teacher_ref=$table_year.teacher_ref
order by $table_teacher.lastname, $table_teacher.firstname";


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
$id_cards='';
$table_content='';
$page_content='';

$row_counter=0; 
$j=0;
while (($field_teacher = mysql_fetch_object($result_teacher)))
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
  
  $picture_path=sprintf("%s",$field_teacher->picture);
  $picture_full_path=sprintf("%s%s",$picture_root,$picture_path);
  $picture_src=sprintf("image_resize.php?f_name=$picture_full_path&height=120");

  $pdf->Image($picture_full_path,$xpos+1.5,$ypos+1.5,'',35,'jpg','');
  $firstname=sprintf("%s %s %s",$field_teacher->title,$field_teacher->firstname,$field_teacher->middlename);
  
  $needle=",";
  $position=strpos($field_teacher->address,$needle);
  $address_part1=substr($field_teacher->address,0,$position);
  $address_part2=substr($field_teacher->address,$position+2,strlen($field_teacher->address)-$position); 
                   
    
  //convert date into txt format
  $teacher_day = substr($field_teacher->date_of_birth,8,2); 
  $teacher_month  = substr($field_teacher->date_of_birth,5,2); 
  $teacher_year = substr($field_teacher->date_of_birth,0,4);
  $teacher_month_text=date ("M",mktime(0,0,0,$teacher_month,$teacher_day,$teacher_year)); 
  $teacher_date_text=sprintf("%s-%s-%s",$teacher_month_text,$teacher_day,$teacher_year); 
  if ($field_teacher->date_of_birth=='0000-00-00')
  {
    $teacher_date_text=sprintf("MM-DD-YYYY");
  }

  //$pdf->SetFont('Arial','',14);
  //$pdf->SetTextColor(16,197,122);
  //$pdf->Text($xpos+29, $ypos+6, $id_card_header);

  $pdf->SetFont('Arial','',10);
  $pdf->SetTextColor(24,32,156);
  $pdf->Text($xpos+35, $ypos+16, $firstname);
  $pdf->Text($xpos+35, $ypos+20, $field_teacher->lastname);
  $pdf->Text($xpos+35, $ypos+24, substr($address_part1,0,24));
  $pdf->Text($xpos+35, $ypos+28, substr($address_part2,0,24));
  
  $coding='Code 39';
  $barcode=$field_teacher->teacher_ref*100000000+$teacher_year*10000+$teacher_month*100+$teacher_day;
  $barcode=sprintf("%s",$barcode);
  $pdf->SetTextColor(0,0,0);
  $pdf->Text($xpos+1.5,$ypos+46.5, $barcode);
  
  $pdf->create_barcode($xpos+2, $ypos+37, $barcode, 0.3, 6);
  
  $j++;

  $xpos=$xpos+$card_width+1;

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