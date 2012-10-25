<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

if (!empty($_POST['grade']))
{
  $grade=$_POST['grade'];
}

if (!empty($_GET['grade']))
{
  $grade=$_GET['grade'];
}
$action='';
if (!empty($_GET['action']))
{
  $action=$_GET['action'];
}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

if ($action=='subject')
{
   $executestring.= sprintf("change_subject_report.php?school=$school&school_year=$school_year&grade=$grade&department=$department&t=%d",time());
   header($executestring);
   exit();
}
if ($action=='report')
{  
   $executestring.= sprintf("change_calculation_report.php?school=$school&school_year=$school_year&grade=$grade&department=$department&t=%d",time());
   header($executestring);
   exit();
}

$table_school='school';
$table_year='year';
$table_term='term';
$table_department='department';
$table_grade='grade';
$table_subject_report='subject_report';
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

$subject_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_grade, $table_subject_report where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_subject_report.grade_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade'
order by $table_subject_report.number, $table_subject_report.subject";

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


if (!($result_subject=mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


//define the header
$data_table = new Smarty_NM();
$table_subject=$data_table->fetch("grade_report_select_header.tpl");

$j=0;
while (($field_subject = mysql_fetch_object($result_subject)))
{
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor="#B8E7FF";
   }

   $data_table = new Smarty_NM();
   
   $data_table->assign("bgcolor",$bgcolor);
   $data_table->assign("category",$field_subject->category);
   $data_table->assign("subject",$field_subject->subject);
   $data_table->assign("abreviation",$field_subject->abreviation);

   $table_subject.=$data_table->fetch("grade_report_select_row.tpl");
   $j++;
}


mysql_free_result($result_subject);  

//new

if (!($result_grade= mysql_query($grade_Stmt,$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $field_grade = mysql_fetch_object($result_grade);
    $grade_ref=$field_grade->grade_ref;
    mysql_free_result($result_grade);

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
  
    $content='';
 
    $j=0;
    while ($field_term = mysql_fetch_object($result_term))
    {
      // one row for each term
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
            $factor_header.=sprintf("<td class=\"table_data\">%s</td>",$stored_factor[$report_counter][$term_counter] );
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
        $data->assign("checked_show_average",'');
        if ($show_average=='on')
        {
          $data->assign("checked_show_average",'X');
        }
        $data->assign("term_honor_id",$field_calculation_report->honor_term);
        $data->assign("default_alternative_tittle",$alternative_tittle);
        $content.=$data->fetch("report_calculation_term_values.tpl");
        
      }
      mysql_free_result($result_calculation_report);
      if ($k==0)//no report calculation available
      {
        $data = new Smarty_NM();

        $content=sprintf("No data available");
        
      }
      // end k=0
    }      
    mysql_free_result($result_term);

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
        
    if ($k==1)
    {
      $data = new Smarty_NM();
      if ($credits=='on')
      {
        $data->assign("checked_show_credits",'X');
      }
      $data->assign("header","Credits");
      $data->assign("default_credit_max",$credit_max);
      $data->assign("default_level_second",$level_second);
      $data->assign("default_level_first",$level_first);
      $data->assign("default_mark_border",$mark_border);
      $content.=$data->fetch("report_calculation_credits_values.tpl");    
    }  
    mysql_free_result($result_credits);
    


$data = new Smarty_NM();


$data->assign("header",sprintf("%s %s %s grade:%d",$school,$school_year,$department,$grade));

$data->assign("subject_list",$table_subject);
$data->assign("report_list",$content);
$start_self = sprintf("http://%s%s",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

$data->assign("new_subject",sprintf("%s/show_subjects_report.php?school=$school&school_year=$school_year&department=$department&grade=$grade&action=%s&t=%d",$start_self,'subject',time()));

$data->assign("new_report",sprintf("%s/show_subjects_report.php?school=$school&school_year=$school_year&department=$department&grade=$grade&action=%s&t=%d",$start_self,'report',time()));

$data->display("subject_report_style_select.tpl");
 
?>
