<?php
  



function subject_array($subject_full_array,$subject_abreviation_array,$category_array,$subject_number,$school,$school_year,$department,$grade,$link)
{
  require("../globals.php") ;

  $table_school='school';
  $table_year='year';
  $table_department='department';
  $table_grade='grade';
  $table_subject_report='subject_report';

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

  if (!($result_subject= mysql_query($subject_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $subject_full_array='';
  $subject_abreviation_array='';
  $category_array='';

  $j=0;
  $subject_number=0;
  while (($field = mysql_fetch_object($result_subject)))
  {
    if ($j>0)
    { 
      if ($field->abreviation!=$subject_abreviation_array[$j-1])
      {
        $subject_abreviation_array[$j]=$field->abreviation;
        $subject_full_array[$j]=$field->subject;
        $category_array[$j]=$field->category;
        $j++;
      }
    }
    if ($j==0)
    { 
      $subject_abreviation_array[$j]=$field->abreviation;
      $subject_full_array[$j]=$field->subject;
      $category_array[$j]=$field->category;
      $j++;
    }
    //printf("abreviation=%s", $subject_abreviation_array[$j-1]);
    //printf("full_subject=%s", $subject_full_array[$j-1]);
    //printf("category=%s", $category_array[$j-1]);
  } 
  //exit(); 
  mysql_free_result($result_subject); 

  $subject_number=0;

  if (!empty($subject_abreviation_array))
  {
    $subject_number=count($subject_abreviation_array);
  }
}

function term_data($term_start,$term_stop,$subject_result_header,$school,$school_year,$term,$show_average,$factor,&$show_average_description,$link)
{
  require("../globals.php") ;
  require_once("./php/includes/setup.php");

  $table_school='school';
  $table_year='year';
  $table_term='term';

  $show_average_description='';
  $subject_result_header=''; 
  $term_counter=1;
  while($term_counter<=$term)
  {
    $term_date_Stmt = "SELECT * from $table_school,$table_year,$table_term where
    $table_school.school_ref=$table_year.school_ref and
    $table_year.year_ref=$table_term.year_ref and
    $table_school.school='$school' and
    $table_year.year='$school_year' and 
    $table_term.term='$term_counter'";

    if (!($result_term_date= mysql_query($term_date_Stmt,$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
  
    while ($field = mysql_fetch_object($result_term_date))
    {
      $term_start[$term_counter]=$field->start_date;
      $term_stop[$term_counter]=$field->stop_date;
    }
    mysql_free_result($result_term_date);

    
    $report_result_header = new Smarty_NM();
    $report_result_header->assign("report_class","report_row_data");
    $report_result_header->assign("bgcolor",$report_result_header_color);
    $report_result_header->assign("report",$report_title[$term_counter]);
    $subject_result_header.=$report_result_header->fetch("create_report_row_header_report.tpl");

    if ($show_average=='on')
    {
       if ($term_counter>1)
       {
         $show_average_description.=sprintf("+");
       }
       $show_average_description.=sprintf("%sx%s",$factor[$term+1][$term_counter],$report_title[$term_counter]);
    }
    $term_counter++;

  }

}


function presention_header($presention_header,$presention_L,$presention_A,$presention_AL,$presention_S,$presention_H,$presention_M,$presention_LV,$term)
{
  require("../globals.php") ;
  require_once("./php/includes/setup.php");

  $row = new Smarty_NM();
  $row->assign("bgcolor",$report_result_header_color);
  $row->assign("header_name","Attendance & Homework"); 
  $row->assign("align","center"); 
  $row->assign("colspan",1+$term); 
  $presention_header=$row->fetch("create_report_result_header.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Late for class (Tardiness)");
  $presention_L=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Absent without letter");
  $presention_A=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Absent with letter");
  $presention_AL=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Sent out");
  $presention_S=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Homework not in order");
  $presention_H=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Material not in order");
  $presention_M=$report_result->fetch("create_report_row_header_report.tpl");

  $report_result = new Smarty_NM();
  $report_result->assign("report_class","report_average_data");
  $report_result->assign("bgcolor","white");
  $report_result->assign("align","left");
  $report_result->assign("report","Detention");
  $presention_LV=$report_result->fetch("create_report_row_header_report.tpl");

}

function skill_score_data($skill_score_table,$skill_number,$skill_array,$abreviation_array,$skill_ref_array,$school,$school_year,$term,$show_average,$show_average_description,$link)
{
  require("../globals.php");
  require_once("./php/includes/setup.php");

  $table_school='school';
  $table_year='year';
  $table_score='score';
  $table_skill='skill';
  
  $score_Stmt = "SELECT * from $table_school, $table_year, $table_score where 
  $table_school.school_ref=$table_year.school_ref and 
  $table_year.year_ref=$table_score.year_ref and
  $table_school.school='$school' and
  $table_year.year='$school_year'  
  order by $table_score.score, $table_score.description";

  $skill_Stmt="SELECT * from $table_year, $table_school, $table_skill 
  where $table_school.school_ref=$table_year.school_ref and
  $table_year.year_ref=$table_skill.year_ref and
  $table_school.school='$school' and 
  $table_year.year='$school_year'
  order by $table_skill.number";
  
  //score data
  if (!($result_score=mysql_query($score_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $score_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $row_score='';
  $row_score_description='';
  $counter=0;
  while (($field_score = mysql_fetch_object($result_score)))
  {
    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$field_score->score);
    $row_score.=$report_result->fetch("create_report_row_header_report.tpl"); 

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$field_score->description);
    $row_score_description.=$report_result->fetch("create_report_row_header_report.tpl");

    $counter++;
  }
  $score_number=$counter;

  //skill_header data
  $row = new Smarty_NM();
  $row->assign("bgcolor",$report_result_header_color);
  $row->assign("header_name","Explanation of Skills"); 
  $row->assign("align","center"); 
  $row->assign("colspan",$score_number); 
  $skill_score_header=$row->fetch("create_report_result_header.tpl");

  //define skill array
  if (!($result_skill= mysql_query($skill_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $j=0;

  $explanation_table_data='';
  //add average
  if ($show_average=='on')
  {
    $explanation_template = new Smarty_NM();
    $explanation_template->assign("bgcolor",$report_skill_color);
    $explanation_template->assign("item","Av");
    $explanation_template->assign("explanation",$show_average_description);
    $explanation_table_data.=$explanation_template->fetch('explanation_report_row.tpl');
  }
  while ($field_skill = mysql_fetch_object($result_skill))
  {
    $skill_array[$j]=$field_skill->skill;
    $abreviation_array[$j]=$field_skill->abreviation;
    $skill_ref_array[$j]=$field_skill->skill_ref;
  
    $explanation_template = new Smarty_NM();
    $explanation_template->assign("bgcolor",$report_skill_color);
    $explanation_template->assign("item",$field_skill->abreviation);
    $explanation_template->assign("explanation",$field_skill->skill);
    $explanation_table_data.=$explanation_template->fetch('explanation_report_row.tpl');

    $j++;
  }
  mysql_free_result($result_skill); 
  $skill_number=count($skill_array);

  //add explanation class average
  $explanation_template = new Smarty_NM();
  $explanation_template->assign("bgcolor",$report_skill_color);
  $explanation_template->assign("item","Ac");
  $explanation_template->assign("explanation",sprintf("Average Class term %s",$term));
  $explanation_table_data.=$explanation_template->fetch('explanation_report_row.tpl');

  $skill_score_template = new Smarty_NM();
  $skill_score_template->assign("skill_score_header",$skill_score_header);
  $skill_score_template->assign("colspan",$score_number);
  $skill_score_template->assign("explanation_table_data",$explanation_table_data);
  $skill_score_template->assign("row_score",$row_score);
  $skill_score_template->assign("row_score_description",$row_score_description);

  $skill_score_table=$skill_score_template->fetch('report_skill_score.tpl');

}



function presention_row($row_S,$row_A,$row_AL,$row_L,$row_H,$row_M,$row_LV,$class_ref,$term_start,$term_stop,$term,$link)
{
  require("../globals.php");
  require_once("./php/includes/setup.php");

  $table_presention_general='presention_general';

  $presention_Stmt = "SELECT * from $table_presention_general where
  $table_presention_general.class_ref='%d' and 
  $table_presention_general.date>='%s' and 
  $table_presention_general.date<='%s'";






// query for presention

  $row_S='';
  $row_A='';
  $row_AL='';
  $row_L='';
  $row_H='';
  $row_M='';
  $row_LV='';
  
  $term_counter=1;
  while($term_counter<=$term)
  {
    $late=0;
    $absent=0;
    $absent_letter=0;
    $sent_out=0;
    $organisation_homework=0;
    $organisation_material=0;
    $leave=0; 
  

    if (!($result_presention_student= mysql_query(sprintf($presention_Stmt,$class_ref,$term_start[$term_counter],$term_stop[$term_counter]),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
     




    while ($field_presention = mysql_fetch_object($result_presention_student))
    {
      if (($field_presention->day_hours!='')&&($field_presention->day_hours>0))
      {
        $absent=$absent+($field_presention->absent/$field_presention->day_hours);
        $absent_letter=$absent_letter+($field_presention->absent_letter/$field_presention->day_hours);
      }
      $late=$late+$field_presention->late;
      $sent_out=$sent_out+$field_presention->sendout;
      $organisation_homework=$organisation_homework+$field_presention->homework;
      $organisation_material=$organisation_material+$field_presention->material;
      $leave=$leave+$field_presention->leave;
    }  
    mysql_free_result($result_presention_student); 
    $absent=sprintf("%.1f",$absent);
    if ($absent=='0.0')
    {
      $absent='0';
    }
    $absent_letter=sprintf("%.1f",$absent_letter);
    if ($absent_letter=='0.0')
    {
      $absent_letter='0';
    }

    //$leave=sprintf("%.1f",$leave);
    //if ($leave=='0.0')
    //{
    //  $leave='0';
    //}

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$sent_out);
    $row_S.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$absent);
    $row_A.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$absent_letter);
    $row_AL.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$late);
    $row_L.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$organisation_homework);
    $row_H.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$organisation_material);
    $row_M.=$report_result->fetch("create_report_row_header_report.tpl");

    $report_result = new Smarty_NM();
    $report_result->assign("report_class","report_average_data");
    $report_result->assign("bgcolor","white");
    $report_result->assign("align","center");
    $report_result->assign("report",$leave);
    $row_LV.=$report_result->fetch("create_report_row_header_report.tpl");

    $term_counter++;
  }

}

function report_values($report_list,$average_list,$credit_sum,$grade_average,$number_of_subjects,$term,$subject_i,$subject_abreviation,$class_ref,$link)
{
  require("../globals.php");
  require_once("./php/includes/setup.php");

  $table_subjects='subjects';
  $table_marks='marks';
  $table_credits='credits';

  $subject_Stmt ="SELECT * from $table_subjects where
  $table_subjects.subject='%s' and
  $table_subjects.class_ref='%d'";

  $report_Stmt ="SELECT * from $table_marks where
  $table_marks.term='%s' and $table_marks.subjects_ref='%d'";

  $credit_Stmt ="SELECT * from $table_credits where
  $table_credits.term='%s' and
  $table_credits.class_ref='%d'";

// loop for the terms in order to calculate the report and the credits
      $credit_list='';
      $report_list='';  
      $term_counter=1;
      
      //determining the subjects_ref
      if (!($result_subject= mysql_query(sprintf($subject_Stmt,$subject_abreviation,$class_ref),$link)))
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
      while ($field_subject = mysql_fetch_object($result_subject))
      {
        $subjects_ref=$field_subject->subjects_ref;
      }
      mysql_free_result($result_subject);
      while($term_counter<=$term)
      {
        //determining the reports
        if (!($result_report= mysql_query(sprintf($report_Stmt,$term_counter,$subjects_ref),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
        }
        $term_value='-';
        $term_average='-';
        while($field_report = mysql_fetch_object($result_report))
        {
          sscanf($field_report->report,"%s",&$term_value);
          sscanf($field_report->average,"%s",&$term_average);
        }
        $report_list[$term_counter]=$term_value;
        $average_list[$term_counter]=$term_average; 
        mysql_free_result($result_report);
      
        //initialising and determining credit_sum
        if ($subject_i==0)
        {
          $grade_average[$term_counter]=0;
          $number_of_subjects[$term_counter]=0;
        
          if (!($result_credit= mysql_query(sprintf($credit_Stmt,$term_counter,$class_ref),$link)))
          {
            DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
            DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
            exit() ;
          }
        
          $credit_sum[$term_counter]=0;
          while($field_credit=mysql_fetch_object($result_credit))
          {
            sscanf($field_credit->credit,"%d",&$term_credit);
            $credit_sum[$term_counter]+=$term_credit;
          }
          mysql_free_result($result_credit);
        }
        $term_counter++;
      }
      //extra initialisation for average
      if ($subject_i==0)
      {
        $grade_average[$term+1]=0;
        $number_of_subjects[$term+1]=0;
      }
}

function credit_values($credit_sum,$class_ref,$term,$link)
//determining the credits
{
  $table_credits='credits';
  $credit_Stmt ="SELECT * from $table_credits where
  $table_credits.term='%s' and
  $table_credits.class_ref='%d'";
  
  $term_counter=1;
  while($term_counter<=$term)
  {
    if (!($result_credit= mysql_query(sprintf($credit_Stmt,$term_counter,$class_ref),$link)))
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $report_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
        
    $credit_sum[$term_counter]=0;
    while($field_credit=mysql_fetch_object($result_credit))
    {
      sscanf($field_credit->credit,"%d",&$term_credit);
      $credit_sum[$term_counter]+=$term_credit;
    }
    mysql_free_result($result_credit);
    $term_counter++;
  }
}