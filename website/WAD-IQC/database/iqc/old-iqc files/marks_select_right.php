<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$term=$_GET['term'];

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$v=$_GET['v'];
$offset=0;
if (!empty($_GET['offset']))
{
  $offset=$_GET['offset'];
}



$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$table_subject='subjects';
$table_marks='marks';

$table_teacher='teacher';

$retry=0; // no retry for all colums

$header_class=$class;

if ($v==0)
{
  $query_cluster='%%';
  $query_class=$class;
}

if ($v==1)
{
  $query_cluster=$cluster; 
  $query_class=sprintf("%s%s",$class[0],'%%');  
  $header_class=$class[0];
}

$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student, $table_subject where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class like '$query_class' and
$table_class_student.year='$school_year' and
$table_subject.subject='$subject' and
$table_subject.cluster like '$query_cluster' and
$table_subject.teacher='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_subject.class_ref  
order by $table_student.lastname, $table_student.firstname";



$marks_Stmt = "SELECT * from $table_marks where
$table_marks.subjects_ref='%d' and 
$table_marks.term='$term' 
order by $table_marks.col"; 


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


if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$user),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_teacher = mysql_fetch_object($result_teacher); //only one hit!

if (!($result_student= mysql_query(sprintf($student_Stmt,$field_teacher->initials),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$year_position=strpos($school_year,'-');
$year_start=substr($school_year,0,$year_position);
$year_stop= substr($school_year,$year_position+1,strlen($school_year));

//Determine the heighest number of mark collumns
$col_max=0;
$j_max=0;
$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
  if (!($result_marks= mysql_query(sprintf($marks_Stmt,$field_student->subjects_ref),$link)))
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $col_counter=0;
  while (($field_marks = mysql_fetch_object($result_marks)))
  {
    if ($field_marks->mark!='')
    {
      $col_counter++;
      if ($col_counter>$col_max)
      {
        $col_max++;
        $j_max=$j;
      }
    }
  }
  mysql_free_result($result_marks);
  $j++;
} 
mysql_free_result($result_student);

if (!($result_student= mysql_query(sprintf($student_Stmt,$field_teacher->initials),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
mysql_free_result($result_teacher);
//printf("col_max=%d",$col_max);
//printf("j_max=%d",$j_max);


 $marks_table = new Smarty_NM();

 $i=0;
 $description_header="";
 $description_input_header="";
 $date_header="";
 $date_input_header=""; 
 $weigth_header="";
 $weigth_input_header="";
 $mr_header="";
 $student_marks=""; 
 $student_report="";
 $row="";
 $j=0;

while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   if ($b==0)
   $student_report.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $student_report.=sprintf("<TR>");
   $student_report.=sprintf("
   <td class=\"table_data_blue\">
    %s
   </td>
   <td class=\"table_data_blue\">
    %s
   </td>",$field_student->firstname,$field_student->lastname);
  
  if (!($result_marks= mysql_query(sprintf($marks_Stmt,$field_student->subjects_ref),$link)))
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  $report='-';  

  $m=0;
  $mark_temp=0;
  $weigth_temp=0;
   
  
  //selection on all available marks
  while (($field_marks = mysql_fetch_object($result_marks)))
  {
    $mark_input =new Smarty_NM();

    $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
    $mark_input->assign("mark_name",$mark_name);  
    $mark_input->assign("mark_value",$field_marks->mark); 
    
    if ($retry==1)
    {
      $retry_name=sprintf("retry[%d][%d]",$field_student->subjects_ref,$m);
      $mark_input->assign("retry_name",$retry_name);  
      $mark_input->assign("retry_value",$field_marks->mark_r);

      $student_marks.=$mark_input->fetch("marks_mr_input.tpl");
    }
    if ($retry==0)
    {
      $student_marks.=$mark_input->fetch("marks_m_input.tpl");
    }

    if ($j==$j_max) //header definition for available data
    {
      $description_input = new Smarty_NM();
      $description = new Smarty_NM();
      $description->assign("description","Description");
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description->assign("colspan",$content);
      }
      $description_header.= $description->fetch("marks_description.tpl");
   
      $description_name=sprintf("description[%d]",$m);
      $description_input->assign("description",$description_name);
      $description_input->assign("default_description",$field_marks->description);
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description_input->assign("colspan",$content);
      }
      $description_input_header.=$description_input->fetch("marks_description_input.tpl");
      
      $date = new Smarty_NM();
      $date_input =new Smarty_NM();
      
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date->assign("colspan",$content);
      }
      $date_header.= $date->fetch("marks_date.tpl");
   
      $date_name=sprintf("date_%d_",$m);
      $date_input->assign("mark_prefix",$date_name);  
      $date_input->assign("time_mark",$field_marks->date); 
      $date_input->assign("year_start",$year_start);
      $date_input->assign("year_stop",$year_stop);  
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date_input->assign("colspan",$content);
      }

      $date_input_header.= $date_input->fetch("marks_date_input.tpl");

      $weigth = new Smarty_NM();
      $weigth_input =new Smarty_NM();
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth->assign("colspan",$content);
      }
      $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      $weigth_name=sprintf("weigth[%d]",$m);
      $weigth_input->assign("weigth",$weigth_name);  
      $weigth_input->assign("default_weigth",$field_marks->weigth);
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth_input->assign("colspan",$content);
      }
      $weigth_input_header.= $weigth_input->fetch("marks_weigth_input.tpl");
 
      $mr = new Smarty_NM();
      if ($retry==1)
      {
        $mr_header.= $mr->fetch("marks_mr.tpl");
      }
      if ($retry==0)
      {
        $mr_header.= $mr->fetch("marks_m.tpl");
      }
    }
    $report=$field_marks->report;
    $m++;
  }
  mysql_free_result($result_marks);  
  
  $report_input = new Smarty_NM();

  
  if ($report!="-")
  {
    sscanf($report,"%f",&$report_value);
    if ($report_value<$mark_border)
    {
       $content=sprintf("bgcolor=\"red\"");
       $report_input->assign("bgcolor",$content);
    }
  }
     
  $report_input->assign("report_value",$report);
  
  $student_report.=$report_input->fetch("marks_report_input.tpl");


  if ($col_max<$mark_cols)
  {
    $col_max=$mark_cols;
  }

  while ($m<$col_max)
  {
    $mark_input =new Smarty_NM();

    $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
    $mark_input->assign("mark_name",$mark_name);  
    
    if ($retry==1)
    {
      $retry_name=sprintf("retry[%d][%d]",$field_student->subjects_ref,$m);
      $mark_input->assign("retry_name",$retry_name);  
      $student_marks.=$mark_input->fetch("marks_mr_input.tpl");
    }
    if ($retry==0)
    {
      $student_marks.=$mark_input->fetch("marks_m_input.tpl");
    }

          
    if ($j==$j_max) //header definition for unavailable data
    {
      $description_input = new Smarty_NM();
      $description = new Smarty_NM();
      $description->assign("description","Description");
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description->assign("colspan",$content);
      }
      $description_header.= $description->fetch("marks_description.tpl");
   
      $description_name=sprintf("description[%d]",$m);
      $description_input->assign("description",$description_name);
      
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description_input->assign("colspan",$content);
      }
      $description_input_header.=$description_input->fetch("marks_description_input.tpl");

      $date = new Smarty_NM();
      $date_input =new Smarty_NM();
      
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date->assign("colspan",$content);
      }
      $date_header.= $date->fetch("marks_date.tpl");

      $date_name=sprintf("date_%d_",$m);
      $date_input->assign("mark_prefix",$date_name);  
      //$date_input->assign("time_mark",time()); 
      $date_input->assign("year_start",$year_start);
      $date_input->assign("year_stop",$year_stop);  
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date_input->assign("colspan",$content);
      }
      $date_input->assign("time_mark","--"); 
      $date_input_header.= $date_input->fetch("marks_date_input.tpl");

      $weigth = new Smarty_NM();
      $weigth_input =new Smarty_NM();
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth->assign("colspan",$content);
      }
      $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      $weigth_name=sprintf("weigth[%d]",$m);
      $weigth_input->assign("weigth",$weigth_name);  
      //$weigth_input->assign("default_weigth",$field_marks->weigth);
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth_input->assign("colspan",$content);
      }
      $weigth_input_header.= $weigth_input->fetch("marks_weigth_input.tpl");

      $mr = new Smarty_NM();
      if ($retry==1)
      {
        $mr_header.= $mr->fetch("marks_mr.tpl");
      }
      if ($retry==0)
      {
        $mr_header.= $mr->fetch("marks_m.tpl");
      }
      
    }   
    $m++;
  } 
 
  //offset

  if ($offset==1)
  {
    $mark_input =new Smarty_NM();

    $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
    $mark_input->assign("mark_name",$mark_name);  
    
    if ($retry==1)
    {
      $retry_name=sprintf("retry[%d][%d]",$field_student->subjects_ref,$m);
      $mark_input->assign("retry_name",$retry_name);  
      $student_marks.=$mark_input->fetch("marks_mr_input.tpl");
    }
    if ($retry==0)
    {
      $student_marks.=$mark_input->fetch("marks_m_input.tpl");
    }

          
    if ($j==$j_max) //header definition for unavailable data
    {
      $description_input = new Smarty_NM();
      $description = new Smarty_NM();
      $description->assign("description","Description");
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description->assign("colspan",$content);
      }
      $description_header.= $description->fetch("marks_description.tpl");
   
      $description_name=sprintf("description[%d]",$m);
      $description_input->assign("description",$description_name);
      
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $description_input->assign("colspan",$content);
      }
      $description_input_header.=$description_input->fetch("marks_description_input.tpl");

      $date = new Smarty_NM();
      $date_input =new Smarty_NM();
      
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date->assign("colspan",$content);
      }
      $date_header.= $date->fetch("marks_date.tpl");

      $date_name=sprintf("date_%d_",$m);
      $date_input->assign("mark_prefix",$date_name);  
      //$date_input->assign("time_mark",time()); 
      $date_input->assign("year_start",$year_start);
      $date_input->assign("year_stop",$year_stop);  
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $date_input->assign("colspan",$content);
      }
      $date_input->assign("time_mark","--"); 
      $date_input_header.= $date_input->fetch("marks_date_input.tpl");

      $weigth = new Smarty_NM();
      $weigth_input =new Smarty_NM();
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth->assign("colspan",$content);
      }
      $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      $weigth_name=sprintf("weigth[%d]",$m);
      $weigth_input->assign("weigth",$weigth_name);  
      //$weigth_input->assign("default_weigth",$field_marks->weigth);
      if ($retry==1)
      {
        $content=sprintf("colspan=\"%d\"",2);
        $weigth_input->assign("colspan",$content);
      }
      $weigth_input_header.= $weigth_input->fetch("marks_weigth_input.tpl");

      $mr = new Smarty_NM();
      if ($retry==1)
      {
        $mr_header.= $mr->fetch("marks_mr.tpl");
      }
      if ($retry==0)
      {
        $mr_header.= $mr->fetch("marks_m.tpl");
      }
      
    }   
  }  

  //end offset

  $student_marks.=sprintf("</tr>");
 
  $row.=$student_report;
  $row.=$student_marks;
  
  $student_marks="";
  $student_report="";
  $j++; 
 }//all students
 mysql_free_result($result_student);  
 
 $button =new Smarty_NM();
 $button->assign("button_value","Save"); 
 $submit_button=$button->fetch("submit_button.tpl");



 $marks_table->assign("description",$description_header);
 $marks_table->assign("description_input",$description_input_header);
 $marks_table->assign("date_input",$date_input_header);
 $marks_table->assign("weigth_input",$weigth_input_header);
 $marks_table->assign("submit_button",$submit_button);

 $marks_table->assign("mr",$mr_header);
 
 $marks_table->assign("student_marks",$row);

 $marks_table->assign("marks_action",sprintf("update_marks.php?school=$school&school_year=$school_year&department=$department&class=$class&subject=$subject&cluster=$cluster&term=$term&v=$v&t=%d",time()));

 $header=sprintf("%s %s %s Class:%s Cluster:%s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$header_class,$cluster,$term,$subject,$user);

 $marks_table->assign("header",$header);

 $marks_table->display("marks_table.tpl");

?>
