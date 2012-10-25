<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

require('./pdf/fpdf.php');

$v=$_GET['v'];
$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];




if (!empty($_POST['term']))
{
  $term=$_POST['term'];
}



$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade'; 
$table_subject_report='subject_report';
$table_calculation_report='calculation_report';
$table_subject='subject';

$table_skill='skill';
$table_skill_sub='skill_sub';
$table_score='score';

$table_marks='marks';
$table_subjects='subjects';
$table_category='category';

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$student_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.year='$school_year' and
$table_class_student.class='$class' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";

$subject_Stmt = "SELECT * from $table_school,$table_year,$table_department,$table_grade,$table_subject_report where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_subject_report.grade_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade' 
order by $table_subject_report.number";




$subject_report_Stmt ="SELECT * from $table_subjects where
$table_subjects.subject='%s' and
$table_subjects.class_ref='%d'";

$report_Stmt ="SELECT * from $table_marks where
$table_marks.term='%s' and $table_marks.subjects_ref='%d'";


$category_Stmt ="SELECT * from $table_category,$table_subjects where
$table_category.subjects_ref=$table_subjects.subjects_ref and
$table_category.term<='$term' and
$table_subjects.subject='%s' and
$table_subjects.class_ref='%d' and 
$table_category.skill='%s'
order by $table_category.term desc";  

$teacher_Stmt="SELECT $table_teacher.initials from $table_teacher, $table_teacher_year,
$table_teacher_department, $table_teacher_subject where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref=$table_teacher_department.year_ref and
$table_teacher_department.department_ref=$table_teacher_subject.department_ref and
$table_teacher_year.year='$school_year' and
$table_teacher_year.school='$school' and
$table_teacher_department.department='$department' and
$table_teacher_subject.subject='%s'";

$skill_Stmt="SELECT * from $table_year, $table_school, $table_skill 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_skill.number";

$skill_sub_Stmt = "SELECT * from $table_skill_sub where 
$table_skill_sub.skill_ref='%d'
order by $table_skill_sub.number";  

$score_Stmt="SELECT * from $table_year, $table_school, $table_score 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_score.score";

$calculation_report_verify_Stmt = "SELECT * from $table_school, $table_year,
$table_department, $table_grade, $table_calculation_report where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_calculation_report.grade_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade' and
$table_calculation_report.term='%d'";

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
if (!($result_calculation_report=mysql_query(sprintf($calculation_report_verify_Stmt,$term),$link))) 
{
  DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
}

$k=0;

while ($field_calculation_report = mysql_fetch_object($result_calculation_report))
{
  $k++;
  $factor=unserialize($field_calculation_report->factor);
  $alternative_tittle=$field_calculation_report->alternative_tittle;
  $show_average=$field_calculation_report->show_average;
  $honor_term=$field_calculation_report->honor_term;
}
mysql_free_result($result_calculation_report);

if ($k==0)
{
  printf("No report data available, make sure you defined the report factors
  in the Report Card menu.");
  exit(1);
}


if (!($result_subject= mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//define default score
 
if (!($result_score= mysql_query($score_Stmt, $link))) {
 DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
 DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
 exit() ;
}

while($field_score = mysql_fetch_object($result_score))
{
  if ($field_score->selected_score=='on')
  {
    $default_selected_score=$field_score->score;
  }
} 
mysql_free_result($result_score);


//define skill array
if (!($result_skill= mysql_query($skill_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$j=0;
$code_field=0;

while ($field_skill = mysql_fetch_object($result_skill))
{
  $skill_array[$j]=$field_skill->skill;
  $skill_ref_array[$j]=$field_skill->skill_ref;

  if (!($result_skill_sub=mysql_query(sprintf($skill_sub_Stmt,$field_skill->skill_ref), $link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $class_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;}

  while ($field_skill_sub = mysql_fetch_object($result_skill_sub))
  {
    $code_field=1;
  }
  mysql_free_result($result_skill_sub); 

  $j++;
}
mysql_free_result($result_skill); 

$skill_number=count($skill_array);

$j=0;
$subject_number=0;
$teacher_counter=0;

while (($field = mysql_fetch_object($result_subject)))
{
  if ($j>0)
  { 
    if ($field->abreviation!=$subject_array[$j-1])
    {
      $subject_array[$j]=$field->abreviation;
    }
  }
  if ($j==0)
  { 
    $subject_array[$j]=$field->abreviation;
  }
  
  $teacher_array[$j]='';
  if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$subject_array[$j]),$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  $tc=0;
  while ($field_teacher = mysql_fetch_object($result_teacher))
  {
    if ($tc>0)
    { 
      if ($field_teacher->initials!=$previous)
      {
        //$teacher_array[$j].=sprintf(" and %s",$field_teacher->initials); 
        $teacher_array[$j].=sprintf("\n%s",$field_teacher->initials); 
        $previous=$field_teacher->initials;
        $tc++;
      }
    }
    if ($tc==0)
    { 
      $teacher_array[$j]=sprintf("%s",$field_teacher->initials);
      $previous=$field_teacher->initials;
      $tc++;
    }
  }
  mysql_free_result($result_teacher);
  
  if ($tc>$teacher_counter)
  {
    $teacher_counter=$tc;
  }

  $j++;
  

}

//printf("teacher_counter=%s",$teacher_counter);






mysql_free_result($result_subject); 



if (!empty($subject_array))
{
  $subject_number=count($subject_array);
}

$table_content="";
$table_content_report="";

$number_of_rows=$term+$skill_number;
if ($show_average=='on')
{
  $number_of_rows=$number_of_rows+1;
}



$pdf=new FPDF();
$pdf->FPDF('L','mm',$pdf_format);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(.3);
$pdf->SetAutoPageBreak(0);
//Legal width 355.6mm heigth 215.9 mm

$new_page=1;

if ($code_field==0)
{
  $font_size=8;
  $cell_width=7;
  $cell_heigth=4;
  $code_factor=1;
}

if ($code_field==1)
{
  $font_size=8;
  $cell_width=7;
  $cell_heigth=4;
  $code_factor=2;
}


$x=$pdf->getX();
$y=$pdf->getY();



$j=0; // The header information will be defined during the first student row
while (($field_student = mysql_fetch_object($result_student)))
{
  $b=($j%2);
  
  $student_name=sprintf("%s, %s",$field_student->lastname,$field_student->firstname);

  $i=0;
  $average_sum=0;
  $average_number=0;
  
  if ($new_page==0) 
  {
    $x=$pdf->getX();
    $y=$pdf->getY();
    if ( ($y+($number_of_rows*$cell_heigth))>210)
    {
      $new_page=1;
    }
  }

  if ($new_page==1)  
  {
    $header_school=sprintf("%s %s",$school,$school_year); 
    $header_class=sprintf("%s %s",$department, $class);     
    $pdf->AddPage();
    
    //Colors, line width and bold font
    $pdf->SetFillColor(200,200,200);
    
    $pdf->SetFont('arial','B',$font_size-1);
    
    $pdf->Cell(50,$cell_heigth,$header_school,1,0,'L',1);
    $i=0;
    while ($i<$subject_number)
    {
      $pdf->Cell($cell_width,$cell_heigth,$subject_array[$i],1,0,'L',1);
      if ($code_field==1)
      {
        $pdf->Cell($cell_width,$cell_heigth,'Code',1,0,'L',1);
      }
      $i++;
    }
    $pdf->Cell($cell_width,$cell_heigth*($teacher_counter+1),'Av',1,0,'L',1);
    $pdf->Ln();
    $pdf->setY($pdf->getY()-($cell_heigth*$teacher_counter));
    
    $pdf->Cell(50,$cell_heigth*$teacher_counter,$header_class,1,0,'L',1);
    $i=0;
    while ($i<$subject_number)
    {
      $start=0;
      $number=1;
      while ($position=strpos($teacher_array[$i],"\n",$start))
      {
        $start=$position+1;
        $number++;
      }
      //printf("number=%d",$number);
      while ($number<$teacher_counter)
      {
        $teacher_array[$i].=sprintf(" \n ");
        $number++;
      }
      if ($i>0)
      {
        $pdf->setXY($x+$code_factor*$cell_width,$y);
      }
      $x=$pdf->getX();
      $y=$pdf->getY(); 
      $pdf->SetFont('arial','B',$font_size-2);
      $pdf->MultiCell($code_factor*$cell_width,$cell_heigth,$teacher_array[$i],1,'L',1);
      $pdf->SetFont('arial','',$font_size);
      $i++;
    }
    $new_page=0;
  }
  if ($b==1)
  {
    $pdf->SetFillColor(229,229,229);
  }
  if ($b==0)
  {
    $pdf->SetFillColor(255,255,255);  
  }
  $pdf->SetFont('arial','',$font_size);
  

  $i=0;
  while ($i<$subject_number)
  {
    // loop for the terms in order to calculate the report
    
     $subject_array_student[$i]=1;
    
    //determining the subjects_ref
    if (!($result_subject_report= mysql_query(sprintf($subject_report_Stmt,$subject_array[$i],$field_student->class_ref),$link)))
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $subjects_ref=0;    
    if ($field_subject_report = mysql_fetch_object($result_subject_report) ) //only one row needed
    {
      $subjects_ref=$field_subject_report->subjects_ref;
    }
    mysql_free_result($result_subject_report);

    $term_counter=1;
     
    
    while($term_counter<=$term)
    {
      if ($subjects_ref>0)       
      {
        if (!($result_report= mysql_query(sprintf($report_Stmt,$term_counter,$subjects_ref),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
        }
            
        $field_report = mysql_fetch_object($result_report);
      
        $term_value=0;
        sscanf($field_report->report,"%s",&$term_value);
        $report_list[$term_counter]=$term_value;
      
        mysql_free_result($result_report);
      }
    
      if ($subjects_ref==0)
      {
        $term_value='-';
        $report_list[$term_counter]=$term_value;
        $subject_array_student[$i]=0;
      } 
            
      if ($term_counter==1)
      {
        $term_description=sprintf("%s",$report_title[$term_counter]);
        $student_add='';
      }
      if ($term_counter>1)
      {
        $term_description.=sprintf("\n%s",$report_title[$term_counter]);
        $student_add.=sprintf("\n ");
      }
      $term_counter++;
    }

    if ($show_average=='on')
    {
      $term_description.=sprintf("\nAv");
      $student_add.=sprintf("\n ");
    }
    if ($i==0)
    {
      $student_name.=$student_add;
      $x=$pdf->getX();
      $y=$pdf->getY();
      $pdf->SetFont('arial','B',$font_size);
      $pdf->MultiCell(50-$cell_width,$cell_heigth,$student_name,1,'L',1);
      $pdf->SetFont('arial','',$font_size);
      $pdf->setXY($x+50-$cell_width,$y);
      $x=$pdf->getX();
      $y=$pdf->getY();
      $pdf->MultiCell($cell_width,$cell_heigth,$term_description,1,'R',1);
      $pdf->setXY($x+$cell_width,$y);
    }
    //$report_sheet="";
    $report_counter=1;
    $report_counter_stop=$term;
    if ($show_average=='on')
    {
      $report_counter_stop=$term+1;
    }
    
    while($report_counter<=$report_counter_stop)  //start
    {
      $report_m=0;
      $report_w=0;
      $term_counter=1;
      $term_counter_stop=$report_counter;
      if ($term_counter_stop>$term)
      {
        $term_counter_stop=$term;
      }
      while($term_counter<=$term_counter_stop)      
      {   
        if ($report_list[$term_counter]!='-') 
        {
          $report_m=$report_m+($report_list[$term_counter]*$factor[$report_counter][$term_counter]);
          $report_w=$report_w+$factor[$report_counter][$term_counter];
        }
        $term_counter++;     
      }
      if ($i==0) //initialisation
      {
        $average_subjects_sum[$report_counter]=0;//$grade_average[$term_counter]=0;
        $average_subjects_number[$report_counter]=0;
      }

      $term_report[$report_counter]="-";
      if (($report_m>0)&&($report_w>0))
      {
        $report_temp=($report_m/$report_w);
        $term_report[$report_counter]=sprintf("%.0f",$report_temp);
      }
      
      $report_mark=$term_report[$report_counter];
      if ($term_report[$report_counter]=='-')
      {
        $report_mark=' ';
      } 
      
      if ($report_counter<=$term)
      {
        //$report_sheet.=sprintf("$report_title[$report_counter]:&nbsp;%s<br>",$term_report[$report_counter]);  
        
        if ($report_counter==1)
        {
          $mark_description=sprintf("%s",$report_mark);
        }
        if ($report_counter>1)
        {
          $mark_description.=sprintf("\n%s",$report_mark);
        }

        if ($term_report[$report_counter]!='-')
        {
          $average_subjects_sum[$report_counter]+=$term_report[$report_counter];
          $average_subjects_number[$report_counter]+=1;
        } 
      }
      if ($report_counter>$term)
      {
        //$report_sheet.=sprintf("Av:&nbsp;%s<br>",$term_report[$report_counter]);
        $mark_description.=sprintf("\n%s",$term_report[$report_counter]); 
        if ($term_report[$report_counter]!='-')
        {
          $average_subjects_sum[$report_counter]+=$term_report[$report_counter];
          $average_subjects_number[$report_counter]+=1;
        } 
      }
      $report_counter++;
    }

    $x=$pdf->getX();
    $y=$pdf->getY();
    $pdf->MultiCell($code_factor*$cell_width,$cell_heigth,$mark_description,1,'L',1);
    $pdf->setXY($x+$code_factor*$cell_width,$y);
        
    $i++;
  } 


  //calculation of subject averages
  //$report_sheet='';
  $report_counter=1;
  $report_counter_stop=$term;
  if ($show_average=='on')
  {
    $report_counter_stop=$term+1;
  }
  while($report_counter<=$report_counter_stop)  //start
  {
    $average_report_subject[$report_counter]='-';
    if (( $average_subjects_sum[$report_counter]>0)&&($average_subjects_number[$report_counter]>0))
    {
      $temp=($average_subjects_sum[$report_counter]/$average_subjects_number[$report_counter]);
      $average_report_subject[$report_counter]=sprintf("%.0f",$temp);
      $average_report_sub=$average_report_subject[$report_counter];
    }
    if ($average_report_subject[$report_counter]=='-')
    {
      $average_report_sub=' ';
    }

    if ($report_counter==1)
    {
      $average_description=sprintf("%s",$average_report_sub);
    }
    if ($report_counter>1)
    {
      $average_description.=sprintf("\n%s",$average_report_sub);
    }

    
    $report_counter++;
  }
  $x=$pdf->getX();
  $y=$pdf->getY();
  $pdf->SetFont('arial','B',$font_size-1);
  $pdf->MultiCell($cell_width,$cell_heigth,$average_description,1,'C',1);
  $pdf->SetFont('arial','',$font_size);
  
  
  //loop for the categories
  $counter=0;
   
    
  //$category_description_header='';

  $category_counter_cell=0;
  //if ($counter>0)
  while ($counter<($skill_number))
  {
    $i=0;
    $category_counter_cell=0;
    while ($i<$subject_number)
    {
      //printf("skill_number=%s",$skill_number);
      //printf("subject_number=%s",$subject_number);
      if ($i==0)
      {
        $pdf->Cell(50,$cell_heigth,$skill_array[$counter],1,0,'L',1); 
      }
      
      if (!($result_category= mysql_query(sprintf($category_Stmt,$subject_array[$i],$field_student->class_ref,$skill_array[$counter]),$link)))
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $category_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
      
      $score_value=$default_selected_score;
      $code_value='';
            

      if ($field_category = mysql_fetch_object($result_category))
      {
                
        if ($field_category->score!='')
        {
          $score_value=$field_category->score;
        }

        if ($field_category->code!='')
        {
          $code_value=$field_category->code;
        } 
       
      }
      mysql_free_result($result_category);
      if ($subject_array_student[$i]==1)
      {
        if ($category_counter_cell>0)
        {
          $pdf->Cell($cell_width*$category_counter_cell,$cell_heigth,'',1,0,'L',1);  
          if ($code_field==1)
          {
            $pdf->Cell($cell_width*$category_counter_cell,$cell_heigth,'',1,0,'L',1);
          } 
          $category_counter_cell=0;

        }          

        $pdf->Cell($cell_width,$cell_heigth,$score_value,1,0,'L',1);  
        if ($code_field==1)
        {
          $pdf->Cell($cell_width,$cell_heigth,$code_value,1,0,'L',1);
        } 
      }
      if ($subject_array_student[$i]==0)
      {
        $category_counter_cell++;
      }

            
      $i++;
    }
    
    

    if ($category_counter_cell>0)
    {
      $pdf->Cell($cell_width*$category_counter_cell,$cell_heigth,'',1,0,'L',1);  
      if ($code_field==1)
      {
        $pdf->Cell($cell_width*$category_counter_cell,$cell_heigth,'',1,0,'L',1);
      } 
      $category_counter_cell=0;
    }        

    if ($counter==0)
    {
      $x=$pdf->getX();
      $y=$pdf->getY();
      $pdf->Cell($cell_width,$cell_heigth*$skill_number,'',1,0,'L',1);
      $pdf->setXY($x,$y-$cell_heigth*($skill_number-1));
    }
    $counter++;
    $pdf->Ln();
  }
    
  $counter=0;
  
     
  $j++;
  
  
}
mysql_free_result($result_student); 
$pdf->Output();


exit();


 
?>
