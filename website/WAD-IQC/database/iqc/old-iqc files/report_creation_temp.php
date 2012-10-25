<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

require("./report_creation_functions.php") ;
require("./../school_data.php") ;

$v=$_GET['v'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
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

$table_credits='credits';
$table_marks='marks';
$table_category='category';
$table_presention_general='presention_general';

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_subject_report='subject_report';
$table_calculation_report='calculation_report';
$table_skill='skill';
$table_score='score';

$table_subject='subject';
$table_term='term';
$table_score='score';

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$class_ref='';
if (!empty($_GET['class_ref']))
{
  $class_ref=$_GET['class_ref'];
  $student_Stmt = "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student where 
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.class='$class' and
  $table_class_student.class_ref = '$class_ref' and
  $table_class_student.year='$school_year' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref
  order by $table_student.lastname, $table_student.firstname";
}
if (empty($_GET['class_ref']))
{
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
}

$subject_student_Stmt = "SELECT * from $table_subjects where
$table_subjects.class_ref='%s' and $table_subjects.subject='%s'";

$category_Stmt ="SELECT * from $table_category,$table_subjects where
$table_category.subjects_ref=$table_subjects.subjects_ref and
$table_category.term<='$term' and
$table_subjects.subject='%s' and
$table_subjects.class_ref='%d' and 
$table_category.skill='%s'";  

$teacher_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student, $table_subjects where 
$table_student.student_ref='%d' and
$table_subjects.subject='%s' and
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_class_student.year='$school_year' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_subjects.class_ref
order by $table_subjects.teacher";

$mentor_Stmt="SELECT $table_teacher.lastname, $table_teacher.title from $table_teacher, $table_teacher_year,
$table_teacher_department, $table_teacher_subject where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref=$table_teacher_department.year_ref and
$table_teacher_department.department_ref=$table_teacher_subject.department_ref and
$table_teacher_year.year='$school_year' and
$table_teacher_year.school='$school' and
$table_teacher_department.department='$department' and
$table_teacher.initials='%s'";

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
if ($k==0)
{
  printf("No report data available, make sure you defined the report factors
  in the Report Card menu.");
  exit(1);
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

//define subject_arrays
subject_array(&$subject_full_array,&$subject_abreviation_array,&$category_array,&$subject_number,$school,$school_year,$department,$grade,$link);

//define term start and term stop
term_data(&$term_start,&$term_stop,&$subject_result_header,$school,$school_year,$term,$show_average,$factor,&$show_average_description,$link);
 
//attendance_header
$report_result_header = new Smarty_NM();
$report_result_header->assign("report_class","report_row_data");
$report_result_header->assign("bgcolor",$report_result_header_color);
$report_result_header->assign("report","Description");
$attendance_table_header=$report_result_header->fetch("create_report_row_header_report.tpl");
$attendance_table_header.=$subject_result_header;

if ($show_average=='on')
{
  $report_result_header = new Smarty_NM();
  $report_result_header->assign("report_class","report_row_data");
  $report_result_header->assign("bgcolor",$report_result_header_color);
  $report_result_header->assign("report","Av");
  $subject_result_header.=$report_result_header->fetch("create_report_row_header_report.tpl");
}

//presention_data
presention_header(&$presention_header,&$presention_L,&$presention_A,&$presention_AL,&$presention_S,&$presention_H,&$presention_M,&$presention_LV,$term);

//skill score table
skill_score_data(&$skill_score_table,&$skill_number,&$skill_array,&$abreviation_array,&$skill_ref_array,$school,$school_year,$term,$show_average,$show_average_description,$link);

//comment_header data
$row = new Smarty_NM();
$row->assign("bgcolor",$report_result_header_color);
$row->assign("header_name","Comment Homeroom Teacher"); 
$row->assign("align","center"); 
$row->assign("colspan",1); 
$comment_header=$row->fetch("create_report_result_header.tpl");


$report_class='';
$j=0; // The header information will be defined during the first student row
while (($field_student = mysql_fetch_object($result_student)))
{
  $table_content='';
  $report_skill_header='';
  $credit_sum='';
  $grade_average='';
  $number_of_subjects='';
  $i=0;
  $subject_i=0;
  $previous_category='';
  $mentor=$field_student->mentor;
  while ($i<$subject_number)
  {
     //verify whether or not the student has the specific subject
    if (!($result_subject_student= mysql_query(sprintf($subject_student_Stmt,$field_student->class_ref,$subject_abreviation_array[$i]),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $subject_counter=0;
    while ($field_subject = mysql_fetch_object($result_subject_student))
    {
      $subject_counter++;
    }
    mysql_free_result($result_subject_student);
    if ($subject_counter!='0')  // subject excists
    {
      if ($subject_i==0)
      {
        $bgcolor_header=sprintf("#a9a9a9");
      }
      if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$field_student->student_ref,$subject_abreviation_array[$i]),$link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
      
      while ($field_teacher = mysql_fetch_object($result_teacher))
      {
        $teacher_field=sprintf("%s",$field_teacher->teacher);
      }
      mysql_free_result($result_teacher);
    
      $subject=sprintf("%s",$subject_full_array[$i]);
      $teacher=sprintf("%s",$teacher_field);
  
      report_values(&$report_list,&$average_list,&$credit_sum,&$grade_average,&$number_of_subjects,$term,$subject_i,$subject_abreviation_array[$i],$field_student->class_ref,$link);
    
      $subject_result='';
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
        $term_report[$report_counter]='-';
        if (($report_m>0)&&($report_w>0))
        {
          $report_temp=($report_m/$report_w);
          $term_report[$report_counter]=sprintf("%.0f",$report_temp);
        }
        
        if ($report_counter==$term) //the average will be calculated only for the term report         
        { 
          $report_m=0;
          $report_w=0;
        
          $term_counter=1;
          while($term_counter<=$report_counter)
          {  
            if ($average_list[$term_counter]!='-')
            { 
              $report_m=$report_m+($average_list[$term_counter]*$factor[$report_counter][$term_counter]);
              $report_w=$report_w+$factor[$report_counter][$term_counter];
            }
            $term_counter++;     
          }
          $term_average[$report_counter]='-';
          if (($report_m>0)&&($report_w>0))
          {
            $average_temp=($report_m/$report_w);
            $term_average[$report_counter]=sprintf("%.0f",$average_temp);
          }
        } 
        if ($class_ref=='')
        { 
          $report_result = new Smarty_NM();
          $report_result->assign("report_class","report_row_data");
          $report_result->assign("bgcolor","white");
          if ($report_counter==$term)
          {
            $report_result->assign("bgcolor",$report_term_color);
          } 
          if ($report_counter>$term)
          {
            $report_result->assign("bgcolor",$report_average_color);
          } 

          if (($term_report[$report_counter]<$mark_border)&&($term_report[$report_counter]!='-'))
          {
            $report_result->assign("report_class","report_row_data_red");
          }
          
          $report_result->assign("report",sprintf("%s",$term_report[$report_counter])); //start with this one
          
          if ($report_counter>$term) //check for term
          {
            $report_result->assign("report",sprintf("<b>%s</b>",$term_report[$report_counter]));
          }
          
          if ($term_report[$report_counter]=='-') //check for -
          {
            $report_result->assign("report"," ");
          }
          $subject_result.=$report_result->fetch("create_report_row_header_report.tpl");
          if (($term_report[$report_counter])!='-')
          {
            $grade_average[$report_counter]+=$term_report[$report_counter];
            $number_of_subjects[$report_counter]+=1;
          }
        }
         
        if ($class_ref!='')
        { 
          if ($report_counter<=$term)
          {
            $report_result = new Smarty_NM();
            $report_result->assign("report_class","report_row_data_yellow");
            $report_result->assign("bgcolor","white");
            if ($report_counter==$term)
            {
              $report_result->assign("bgcolor",$report_term_color);
            } 
            
            if (($term_report[$report_counter]<$mark_border)&&($term_report[$report_counter]!='-'))
            {
              $report_result->assign("report_class","report_row_data_red_yellow");
            }
            $report_result->assign("action_term_mark",sprintf("marks_print.php?school=$school&school_year=$school_year&department=$department&class=$class&subject=$subject_abreviation_array[$i]&term=$report_counter&teacher=$teacher_field&class_ref=$class_ref&v=0&t=%d",time()));

            $report_result->assign("report",sprintf("%s",$term_report[$report_counter]));

            if ($term_report[$report_counter]=='-') //check for -
            {
              $report_result->assign("action_term_mark","");
              $report_result->assign("report"," ");
            }

            $subject_result.=$report_result->fetch("create_report_row_header_report_single.tpl");
            if (($term_report[$report_counter])!='-')
            {
              $grade_average[$report_counter]+=$term_report[$report_counter];
              $number_of_subjects[$report_counter]+=1;
            }
          }        
          if ($report_counter>$term)
          {
            $report_result = new Smarty_NM();
            $report_result->assign("report_class","report_row_data");
                                  
            $report_result->assign("bgcolor",$report_average_color);
            
            if (($term_report[$report_counter]<$mark_border)&&($term_report[$report_counter]!='-'))
            {
              $report_result->assign("report_class","report_row_data_red");
            }
            $report_result->assign("action_term_mark","");
            
            $report_result->assign("report",sprintf("<b>%s</b>",$term_report[$report_counter]));
            if ($term_report[$report_counter]=='-') //check for -
            {
              $report_result->assign("report"," ");
            }
            $subject_result.=$report_result->fetch("create_report_row_header_report.tpl");
            
            if (($term_report[$report_counter])!='-')
            {
              $grade_average[$report_counter]+=$term_report[$report_counter];
              $number_of_subjects[$report_counter]+=1;
            }
          }        

        }
        $report_counter++;
      }
      
      $report_result = new Smarty_NM();
      $report_result->assign("report_class","report_row_data");
      $report_result->assign("bgcolor","$report_term_color");
      if (($term_average[$term]<$mark_border)&&($term_average[$term]!='-'))
      {
        $report_result->assign("report_class","report_row_data_red");
      }
      $report_result->assign("report",sprintf("%s",$term_average[$term]));
      if ($term_average[$term]=='-')
      {
        $report_result->assign("report"," ");
      }

      $subject_average=$report_result->fetch("create_report_row_header_report.tpl");


      //loop for the categories
      $report_skill='';
      $counter=0;
      while ($counter<($skill_number))
      {
        if ($subject_i==0)
        {
          $skill_template_header = new Smarty_NM();
          $skill_template_header->assign("bgcolor",$report_result_header_color);
          $skill_template_header->assign("skill",$abreviation_array[$counter]);
          $report_skill_header.=$skill_template_header->fetch("create_report_row_header_skill.tpl");
        }

        if (!($result_category= mysql_query(sprintf($category_Stmt,$subject_abreviation_array[$i],$field_student->class_ref,$skill_array[$counter]),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $category_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
        }
        $score_value=$default_selected_score;
        while($field_category = mysql_fetch_object($result_category))
        {
          $score_value=$field_category->score;
        }
      
        $skill_template = new Smarty_NM();
        $skill_template->assign("bgcolor","white");
        $skill_template->assign("skill",$score_value);
        $report_skill.=$skill_template->fetch("create_report_row_header_skill.tpl");
      
        mysql_free_result($result_category);
  
        $counter++;
      }
        
      if ($subject_i==0)
      {
        $skill_template_header = new Smarty_NM();
        $skill_template_header->assign("bgcolor",$report_result_header_color);
        $skill_template_header->assign("skill","Ac");
        $average_header=$skill_template_header->fetch("create_report_row_header_skill.tpl");

        $row = new Smarty_NM();
        $row->assign("bgcolor",$report_result_header_color);
        $row->assign("header_name","Results"); 
        $row->assign("align","center"); 
        $row->assign("colspan",3+$skill_number+$term); 
        if ($show_average=='on')
        {
          $row->assign("colspan",4+$skill_number+$term);
        }
        $table_content.=$row->fetch("create_report_result_header.tpl");

        $row = new Smarty_NM();
        $row->assign("bgcolor",$report_result_header_color);
        $row->assign("subject",sprintf("Subject")); 
        $row->assign("teacher",sprintf("Teacher")); 
        $row->assign("result",$subject_result_header); 
        $row->assign("skill",$report_skill_header);
        $row->assign("average",$average_header);  
        $table_content.=$row->fetch("create_report_row.tpl");
      }
      if ($category_array[$i]!=$previous_category)
      {
        $row = new Smarty_NM();
        $row->assign("bgcolor",$report_category_header_color);
        $row->assign("header_name",$category_array[$i]); 
        $row->assign("align","left"); 
        $row->assign("colspan",3+$skill_number+$term); 
        if ($show_average=='on')
        {
          $row->assign("colspan",4+$skill_number+$term);
        }
        $table_content.=$row->fetch("create_report_result_header.tpl");
      }

      $row = new Smarty_NM();
      $row->assign("bgcolor","white");
      $row->assign("subject",$subject); 
      $row->assign("teacher",$teacher); 
      $row->assign("result",$subject_result); 
      $row->assign("skill",$report_skill);
      $row->assign("average",$subject_average); 
      $table_content.=$row->fetch("create_report_row.tpl");
      $previous_category=$category_array[$i];
      $subject_i++;
    } //end subject excist 
    $i++;
  } //end subjects
  
  $row = new Smarty_NM();
  $row->assign("bgcolor",$report_category_header_color);
  $row->assign("header_name","Averages"); 
  $row->assign("align","left"); 
  $row->assign("colspan",3+$skill_number+$term); 
  if ($show_average=='on')
  {
    $row->assign("colspan",4+$skill_number+$term);
  }
  $table_content.=$row->fetch("create_report_result_header.tpl");

  $average_result='';
  $credit_result='';
  $overall_result='';
  $term_counter=1; 
  if ($show_average=='on')
  {
    $average_grade_m='';
    $average_grade_w='';
    $c_s_m='';
    $c_s_w='';
    $o_a_m='';
    $o_a_w='';
  } 
  while($term_counter<=$term)
  {
    if ($credit_sum[$term_counter]>$credit_max)
    {
      $credit_sum[$term_counter]=$credit_max;
    }
    $report_result = new Smarty_NM();
    $report_result->assign("bgcolor","white");
    $grade_av='-';
    if ( ($grade_average[$term_counter]>0)&&($number_of_subjects[$term_counter]>0) )
    {
      $grade_av=sprintf("%.0f",($grade_average[$term_counter]/$number_of_subjects[$term_counter]));
    }
    $report_result->assign("bgcolor","white");
    if ($term_counter==$term)
    {
      $report_result->assign("bgcolor",$report_term_color);
    }
    $report_result->assign("report_class","report_row_data");
    if (($grade_av<$mark_border)&&($grade_av!='-'))
    {
      $report_result->assign("report_class","report_row_data_red");
    } 
    $report_result->assign("report",$grade_av);
    if ($grade_av=='-')
    {
      $report_result->assign("report"," ");
    }

    $average_result.=$report_result->fetch("create_report_row_header_report.tpl");
    
    $report_result = new Smarty_NM();
    $c_s='-';
    if ($credit_sum[$term_counter]!=0)
    {
      $c_s=sprintf("%.0f",($credit_sum[$term_counter]));
    }
    $report_result->assign("bgcolor","white"); 
    if ($term_counter==$term)
    {
      $report_result->assign("bgcolor",$report_term_color);
    } 
    $report_result->assign("report_class","report_row_data");
    $report_result->assign("report",$c_s);
    if ($c_s=='-')
    {
      $report_result->assign("report","");
    }

    $credit_result.=$report_result->fetch("create_report_row_header_report.tpl");
    
    $report_result = new Smarty_NM();
    $o_a='-';
    if ($grade_av!='-')
    {
      $o_a=sprintf("%.0f",$grade_av);
      if($c_s!='-')
      {
        $o_a=sprintf("%.0f",($grade_av+$credit_sum[$term_counter]));
      }
    } 
    $report_result->assign("bgcolor","white");
    if ($term_counter==$term)
    {
      $report_result->assign("bgcolor",$report_term_color);
    }
    $report_result->assign("report_class","report_row_data");
    if (($o_a<$mark_border)&&($o_a!='-'))
    {
      $report_result->assign("report_class","report_row_data_red");
    }   
    $report_result->assign("report",$o_a);
    if ($o_a=='-')
    {
      $report_result->assign("report"," ");
    }
    $overall_result.=$report_result->fetch("create_report_row_header_report.tpl");
    if ($term_counter==$honor_term)
    {
      $o_a_honor=$o_a;
    }    
    if ($show_average=='on')
    {
      if ($grade_av!='-')
      {
        $average_grade_m=$average_grade_m+($grade_av*$factor[$term+1][$term_counter]);
        $average_grade_w=$average_grade_w+$factor[$term+1][$term_counter];
      } 
      if ($c_s!='-')
      {
        $c_s_m=$c_s_m+($c_s*$factor[$term+1][$term_counter]);
        $c_s_w=$c_s_w+$factor[$term+1][$term_counter];
      } 
      if ($o_a!='-')
      {
        $o_a_m=$o_a_m+($o_a*$factor[$term+1][$term_counter]);
        $o_a_w=$o_a_w+$factor[$term+1][$term_counter];
      } 
    }
    $term_counter++;
  }
  if ($show_average=='on')
  {
    $average_grade_o='-';
    $c_s_o='-';
    $o_a_o='-';
    if (($average_grade_m>0)&&($average_grade_w>0))
    {
      $average_grade_o=sprintf("%.0f",($average_grade_m/$average_grade_w));
    }
    if (($c_s_m>0)&&($c_s_w>0))
    {
      $c_s_o=sprintf("%.0f",($c_s_m/$c_s_w));
    }
    if (($o_a_m>0)&&($o_a_w>0))
    {
      $o_a_o=sprintf("%.0f",($o_a_m/$o_a_w));
    }
    //overall class average
    $grade_av='-';
    if ( ($grade_average[$term+1]>0)&&($number_of_subjects[$term+1]>0) )
    {
      $grade_av=sprintf("%.0f",($grade_average[$term+1]/$number_of_subjects[$term+1]));
    }
    $report_result->assign("bgcolor",$report_result_header_color);
    $report_result->assign("report_class","report_row_data");
    if (($grade_av<$mark_border)&&($grade_av!='-'))
    {
      $report_result->assign("report_class","report_row_data_red");
    } 
    $report_result->assign("report",sprintf("<b>%s</b>",$grade_av));
    if ($grade_av=='-')
    {
      $report_result->assign("report"," ");
    }
    $average_result.=$report_result->fetch("create_report_row_header_report.tpl");
  }
 
  $honor_name='';
  $bgcolor_honor='white';
  if ($o_a_honor>=80)
  {
    $bgcolor_honor='yellow';
    $honor_name='2nd Honor';
    if ($o_a_honor>=90)
    {
      $honor_name='1st Honor';
    }
  }
  
  $row = new Smarty_NM();
  $row->assign("average_name",sprintf("Grade Average")); 
  $row->assign("average_results",$average_result); 
  $row->assign("bgcolor","white");
  $row->assign("colspan",$skill_number+1);
  $row->assign("honor_name","");
  $average_result=$row->fetch("create_report_average_header.tpl");
  
  $row = new Smarty_NM();
  $row->assign("average_name",sprintf("Extra Credits")); 
  $row->assign("average_results",$credit_result); 
  $row->assign("bgcolor","white");
  $row->assign("colspan",$skill_number+1);
  if ($show_average=='on')
  {
    $row->assign("colspan",$skill_number+2);
  }
  $row->assign("honor_name","");
  $credit_result=$row->fetch("create_report_average_header.tpl");

  $row = new Smarty_NM();
  $row->assign("average_name",sprintf("Overall Average")); 
  $row->assign("average_results",$overall_result); 
  $row->assign("bgcolor",$bgcolor_honor);
  $row->assign("colspan",$skill_number+1);
  if ($show_average=='on')
  {
    $row->assign("colspan",$skill_number+2);
  }
  $row->assign("honor_name",$honor_name);
  $overall_result=$row->fetch("create_report_average_header.tpl");

  $table_content.=$average_result;
  $table_content.=$credit_result;  
  $table_content.=$overall_result; 

  //$presention_table

  presention_row(&$row_S,&$row_A,&$row_AL,&$row_L,&$row_H,&$row_M,&$row_LV,$field_student->class_ref,$term_start,$term_stop,$term,$link);
  
  $row_S=sprintf("%s%s",$presention_S,$row_S);
  $row_A=sprintf("%s%s",$presention_A,$row_A);
  $row_AL=sprintf("%s%s",$presention_AL,$row_AL);
  $row_L=sprintf("%s%s",$presention_L,$row_L);
  $row_H=sprintf("%s%s",$presention_H,$row_H);
  $row_M=sprintf("%s%s",$presention_M,$row_M);
  $row_LV=sprintf("%s%s",$presention_LV,$row_LV);



  $row = new Smarty_NM();
  $row->assign("presention_header",$presention_header);
  $row->assign("attendance_table_header",$attendance_table_header);

  $row->assign("row_S",$row_S); 
  $row->assign("row_AL",$row_AL); 
  $row->assign("row_A",$row_A); 
  $row->assign("row_L",$row_L); 
  $row->assign("row_H",$row_H); 
  $row->assign("row_M",$row_M); 
  $row->assign("row_LV",$row_LV); 

  $table_presention=$row->fetch("report_absenteism.tpl");

  //comment
  $comment_data='<br><br><br><br><br><br><br><br>';
  $row = new Smarty_NM();
  $row->assign("comment_header",$comment_header);
  $row->assign("comment_data",$comment_data);
  $table_comment=$row->fetch("report_comment.tpl");

  if (!($result_mentor= mysql_query(sprintf($mentor_Stmt,$mentor), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $field_mentor = mysql_fetch_object($result_mentor);
  $mentor_lastname=$field_mentor->lastname;
  $mentor_title=$field_mentor->title;
  mysql_free_result($result_mentor);

  
  $report = new Smarty_NM();
  $report->assign("picture_logo",$report_logo);
  $student_name=sprintf("%s, %s",$field_student->lastname,$field_student->firstname);
  $report->assign("student_name",sprintf("<b>%s</b>",$student_name));
  $report->assign("mentor",sprintf("%s %s",$mentor_title,$mentor_lastname));
  $header_name=sprintf("Report %s %s",$school,$school_year);   
  $report->assign("header_name",$header_name);
  $term_info=sprintf("Term %s  (%s until %s)",$term,$term_start[$term],$term_stop[$term]); 
  if ($alternative_tittle!='')
  {
    $term_info=$alternative_tittle;
  }
  $report->assign("term_info",$term_info);
  $signature_info=sprintf("Signature...........................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;date ............/......../........"); 
  $report->assign("signature_info",$signature_info);
  $report->assign("department",$department);
  $report->assign("class",$class);
  $report->assign("results_table",$table_content);
  $report->assign("skill_score_table",$skill_score_table);
  $report->assign("presention_table",$table_presention);
  $report->assign("comment_table",$table_comment);

  //$report_class.=$report->fetch("school_report.tpl");
  $report_class=$report->fetch("school_report.tpl");
  printf("%s",$report_class);  
  $j++;
}
mysql_free_result($result_student); 
?>
