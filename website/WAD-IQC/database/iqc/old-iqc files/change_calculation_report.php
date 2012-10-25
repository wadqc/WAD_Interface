<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];


$table_school='school';
$table_year='year';
$table_term='term';
$table_department='department';
$table_grade='grade';
$table_calculation_report='calculation_report';
$table_credits_report='credits_report';

$grade_Stmt = "SELECT * from $table_school, $table_year,
$table_department, $table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade'";

$calculation_report_Stmt = "SELECT * from $table_calculation_report where
$table_calculation_report.grade_ref='%d' and 
$table_calculation_report.term='%d'";

$credits_report_Stmt = "SELECT * from $table_credits_report where
$table_credits_report.grade_ref='%d'";

$term_Stmt = "SELECT * from $table_school, $table_year, $table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'
order by $table_term.term";


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

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
  
    $content='';
   
    if (!($result_grade= mysql_query($grade_Stmt,$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $field_grade = mysql_fetch_object($result_grade);
    $grade_ref=$field_grade->grade_ref;
    mysql_free_result($result_grade);

    $j=0;
    while ($field_term = mysql_fetch_object($result_term))
    {
      // one row for each term
      $year_ref=$field_term->year_ref;

      if (!($result_calculation_report= mysql_query(sprintf($calculation_report_Stmt,$grade_ref,$field_term->term),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $k=0;
      $f_name=sprintf("factor_%s",$field_term->term);
      $alternative_tittle_name=sprintf("alternative_tittle_%s",$field_term->term);
      $show_average_name=sprintf("show_average_%s",$field_term->term);
      $honor_term_name=sprintf("honor_term_%s",$field_term->term);
      while ($field_calculation_report = mysql_fetch_object($result_calculation_report))
      {
        $k++;
        $stored_factor=unserialize($field_calculation_report->factor);
        $alternative_tittle=$field_calculation_report->alternative_tittle;
        $show_average=$field_calculation_report->show_average;
        $honor_term=$field_calculation_report->honor_term;
         
	$term_number=$field_term->term;
        $term_honor_list='';
        $term_counter=1; 
        while($term_counter<$term_number+1)
        {
          $term_honor_list["$term_counter"]="$term_counter";
          $term_counter++;
        } 
        $report_counter=1;

        $term_header=sprintf("<tr><td class=\"template_data\"> Report</td>");
        $factor_header='';
        $average_header='';
        $factor = new Smarty_NM();

        while ($report_counter<($term_number+2))
        {
          if ($report_counter<($term_number+1))
          {
            $term_header.=sprintf("<td class=\"template_data\">Term %s</td>",$report_counter);
          }
          if ($report_counter!=($term_number+1))
          {
            $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",$report_counter);
          }
          if ($report_counter==($term_number+1))
          {
            $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",'Average');
          }
          $term_counter=1;
          while (($term_counter<($report_counter+1))&&($term_counter<($term_number+1)) )
          {
            $factor_name=sprintf("%s[%s][%s]",$f_name,$report_counter,$term_counter);
            $factor->assign("factor_id",$stored_factor[$report_counter][$term_counter]);   
            $factor->assign("factor_name",$factor_name);
            $factor->assign("factor_options",$list_factor);
            $factor_header.= $factor->fetch("report_term_factor.tpl"); 
            $term_counter++;
          }
          while ($term_counter<($term_number+1))
          {
            $factor_header.=sprintf("<td></td>");
            $term_counter++;
          }
          $factor_header.=sprintf("</tr>");
          $list_term["$report_counter"]=$report_counter;
          $report_counter++;
        }
        $term_header.=sprintf("</tr>");

        $term_factors=$term_header;
        $term_factors.=$factor_header;

        $data = new Smarty_NM();

        $report_name=sprintf("Report term %d",$field_term->term);
        $data->assign("header",$report_name);
        $data->assign("term_options",$list_term);
        $data->assign("term_factors",$term_factors);
        $data->assign("report_name",$report_name);

        $data->assign("term_honor_list",$term_honor_list);
        if ($show_average=='on')
        {
          $data->assign("checked_show_average",'checked');
        }
        $data->assign("term_honor_id",$field_calculation_report->honor_term);
        $data->assign("default_alternative_tittle",$alternative_tittle);
        $data->assign("alternative_tittle_name",$alternative_tittle_name);
        $data->assign("show_average_name",$show_average_name);
        $data->assign("honor_term_name",$honor_term_name);
        $content.=$data->fetch("report_calculation_term.tpl");
        
      }
      mysql_free_result($result_calculation_report);
      if ($k==0)//no report calculation available
      {
        $term_number=$field_term->term;
        $term_honor_list='';
        $term_counter=1; 
        while($term_counter<$term_number+1)
        {
          $term_honor_list["$term_counter"]="$term_counter";
          $term_counter++; 
        } 
        $report_counter=1;

        $term_header=sprintf("<tr><td class=\"template_data\"> Report</td>");
        $factor_header='';
        $average_header='';
        $factor = new Smarty_NM();

        while ($report_counter<($term_number+2))
        {
          if ($report_counter<($term_number+1))
          {
            $term_header.=sprintf("<td class=\"template_data\">Term %s</td>",$report_counter);
          }
          if ($report_counter!=($term_number+1))
          {
            $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",$report_counter);
          }
          if ($report_counter==($term_number+1))
          {
            $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",'Average');
          }
          $term_counter=1;
          while (($term_counter<($report_counter+1))&&($term_counter<($term_number+1)) )
          {
            $factor_name=sprintf("%s[%s][%s]",$f_name,$report_counter,$term_counter);   
            $factor->assign("factor_name",$factor_name);
            $factor->assign("factor_options",$list_factor);
            $factor_header.= $factor->fetch("report_term_factor.tpl"); 
            $term_counter++;
          }
          while ($term_counter<($term_number+1))
          {
            $factor_header.=sprintf("<td></td>");
            $term_counter++;
          }
          $factor_header.=sprintf("</tr>");
          $list_term["$report_counter"]=$report_counter;
          $report_counter++;
        }
        $term_header.=sprintf("</tr>");

        $term_factors=$term_header;
        $term_factors.=$factor_header;

        $data = new Smarty_NM();

        $report_name=sprintf("Report term %d",$field_term->term);
        $data->assign("header",$report_name);
        $data->assign("term_options",$list_term);
        $data->assign("term_factors",$term_factors);
        
        $data->assign("term_honor_list",$term_honor_list);
        $data->assign("term_honor_id",$field_term->term);

        $data->assign("alternative_tittle_name",$alternative_tittle_name);
        $data->assign("show_average_name",$show_average_name);
        $data->assign("honor_term_name",$honor_term_name);
        $content.=$data->fetch("report_calculation_term.tpl");
        
      }
      // end k=0
      $j++;
    } 
    mysql_free_result($result_term);
   
    if ($j==0)
    {
       $message=sprintf("The terms should be entered first before this function can be used.");
       DisplayErrMsg( $message );
       exit(1);
    } 


    //credits section 
    if (!($result_credits= mysql_query(sprintf($credits_report_Stmt,$grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $k=0;
    while ($field_credits = mysql_fetch_object($result_credits) )
    {  
      $k++;
      $credits=$field_credits->credits;
      $credit_max=$field_credits->credit_max;
      $level_first=$field_credits->level_first;
      $level_second=$field_credits->level_second;
      $text_second=$field_credits->text_second;
      $text_first=$field_credits->text_first;
      $mark_border=$field_credits->mark_border;
    }
    $data = new Smarty_NM();
    if ($k==1)
    {
      $data->assign("header","Credits");
      if ($credits=='on')
      {
        $data->assign("checked_show_credits",'checked');
      }
      $data->assign("default_credit_max",$credit_max);
      $data->assign("default_level_second",$level_second);
      $data->assign("default_level_first",$level_first);
      $data->assign("default_mark_border",$mark_border);
    }    
    $content.=$data->fetch("report_calculation_credits.tpl");    
    mysql_free_result($result_credits);
    
  $header=sprintf("%s %s %s grade:%d Report Calculation",$school,$school_year,$department,$grade);
  $report_action=sprintf("calculation_report_add.php?school=$school&school_year=$school_year&department=$department&grade=$grade&grade_ref=$grade_ref&year_ref=$year_ref&t=%d",time());
  
  $data = new Smarty_NM();
  $data->assign("report_action",$report_action);
  $data->assign("header",$header);
  $data->assign("content",$content);
  $data->display("subject_report_select.tpl");
 
?>
