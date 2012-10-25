<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

if (!empty($_GET['subject']))
{
  $subject=$_GET['subject'];
}
$cluster='';
if (!empty($_GET['cluster']))
{
  $cluster=$_GET['cluster'];
}

if (!empty($_GET['teacher']))
{
  $teacher=$_GET['teacher'];
}

$class_ref='';
if (!empty($_GET['class_ref']))
{
  $class_ref=$_GET['class_ref'];
}

$term=$_GET['term'];

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$v=$_GET['v'];
$mark_border=$_GET['mark_border'];
$col_max=0;
if (!empty($_GET['col_max']))
{
  $col_max=$_GET['col_max'];
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
  //$query_class=sprintf("%s%s",$class[0],'%%');  
  //$header_class=$class[0];
  $header_class=$grade;
  $query_class='%%'; 
}




$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

if ($class_ref=='')
{
  $student_Stmt = "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student, $table_subject where 
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.grade='$grade'and
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
}
if ($class_ref!='')
{
  $student_Stmt = "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student, $table_subject where 
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.grade='$grade'and
  $table_class_student.class like '$query_class' and
  $table_class_student.class_ref = '$class_ref' and
  $table_class_student.year='$school_year' and
  $table_subject.subject='$subject' and
  $table_subject.cluster like '$query_cluster' and
  $table_subject.teacher='%s' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref and
  $table_class_student.class_ref=$table_subject.class_ref  
  order by $table_student.lastname, $table_student.firstname";
}



$marks_Stmt = "SELECT * from $table_marks where
$table_marks.subjects_ref='%d' and 
$table_marks.term='$term' and 
$table_marks.col='%d'
order by $table_marks.col"; 

$marks_query_Stmt = "SELECT * from $table_marks where
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


if ($class_ref=='')
{
  if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$user),$link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $field_teacher = mysql_fetch_object($result_teacher); //only one hit!
  $teacher=$field_teacher->initials;
  mysql_free_result($result_teacher);
}



if (!($result_student= mysql_query(sprintf($student_Stmt,$teacher),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$year_position=strpos($school_year,'-');
$year_start=substr($school_year,0,$year_position);
$year_stop= substr($school_year,$year_position+1,strlen($school_year));

$j_max=0;
$j=0;
$student_counter=0;
while ($field_student = mysql_fetch_object($result_student))
{
  if (!($result_marks= mysql_query(sprintf($marks_query_Stmt,$field_student->subjects_ref),$link)))
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  while (($field_marks = mysql_fetch_object($result_marks)))
  {
    if ($field_marks->mark!='')
    {
      $col_counter=$field_marks->col;
      if ($col_counter>$col_max)
      {
        $col_max=$col_counter;
      }
    }
  }
  mysql_free_result($result_marks);
  $student_counter++;
} 
$student_counter-=1; //the last count is 1 to much

mysql_free_result($result_student);


if (!($result_student= mysql_query(sprintf($student_Stmt,$teacher),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$marks_table = new Smarty_NM();

$m=0;
while($m<($col_max+1)) 
{
  $default_description[$m]='';
  $default_date[$m]='';;
  $default_weigth[$m]='';
  $m++;
}

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
 $average='-';
while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   $student_report.=sprintf("
   <td class=\"table_data\">
    %s
   </td>
   <td class=\"table_data\">
    %s
   </td>",$field_student->firstname,$field_student->lastname);
   $report='-'; 
   $m=0;
   while($m<($col_max+1)) //selection on all available marks
   {
     if (!($result_marks= mysql_query(sprintf($marks_Stmt,$field_student->subjects_ref,$m),$link)))
     {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
     }

     $col_available=0;
     while (($field_marks = mysql_fetch_object($result_marks)))
     {
       $mark_data = new Smarty_NM();
       $mark_data->assign("content",$field_marks->mark);
       $default_description[$m]=$field_marks->description;     
       $default_date[$m]=$field_marks->date;
       $default_weigth[$m]=$field_marks->weigth;
       $report=$field_marks->report;
       $average=$field_marks->average;
       $col_available=1;
     }
     
     if ($col_available==0)
     {
       $mark_data = new Smarty_NM();
       $mark_data->assign("content","&nbsp;");
     }
     $student_marks.= $mark_data->fetch("marks_print_cell.tpl");      
     if ($j==$student_counter) //header definition for available data
     {
       $description_input = new Smarty_NM();
       $description = new Smarty_NM();
       $description->assign("content","Description");
       $description_header.= $description->fetch("marks_print_cell.tpl");
       if ($default_description[$m]=='')
       {    
         $description_input->assign("content","&nbsp;");
       }      
       if ($default_description[$m]!='')
       {    
         $description_input->assign("content",$default_description[$m]);
       } 
       $description_input_header.=$description_input->fetch("marks_print_cell.tpl");
       
       $date = new Smarty_NM();
       $date_input =new Smarty_NM();
       $date_header.= $date->fetch("marks_date.tpl");
       if ($default_date[$m]=='')
       {    
         $date_input->assign("content","&nbsp;");
       }    
       if ($default_date[$m]!='')
       {  
         $date_input->assign("content",$default_date[$m]); 
       }
       $date_input_header.= $date_input->fetch("marks_print_cell.tpl");

       $weigth = new Smarty_NM();
       $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      
       $weigth_input =new Smarty_NM();
       if ($default_weigth[$m]=='')
       {    
         $weigth_input->assign("content","&nbsp;");
       }    
       if ($default_weigth[$m]!='')
       {  
         $weigth_input->assign("content",$default_weigth[$m]);
       }
       $weigth_input_header.= $weigth_input->fetch("marks_print_cell.tpl");

       $mr = new Smarty_NM();
       $mr_header.= $mr->fetch("marks_m_print.tpl");
     }  
     mysql_free_result($result_marks); 
     $m++;
   }
  
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
   $report_input =new Smarty_NM();
   $report_input->assign("content",$report);
   if ($report!="-")
   {
     sscanf($report,"%f",&$report_value);
     if ($report_value<$mark_border)
     {
       $student_report.=$report_input->fetch("marks_print_cell_red.tpl");
     }
     if ($report_value>=$mark_border)
     {
       $student_report.=$report_input->fetch("marks_print_cell.tpl");
     }
   }
   if ($report=="-")
   {
     $student_report.=$report_input->fetch("marks_print_cell.tpl");
   }


   $start_element=sprintf("<TR bgcolor=\"white\">");
   if ($b==0)
   {  
     $start_element=sprintf("<TR bgcolor=\"#EaEaEa\">");
   }
 
   $row.=$start_element;
   $row.=$student_report;
   $row.=$student_marks;
   $row.=sprintf("</tr>");  

   $student_marks='';
   $student_report='';
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

if ($v==0)
{
  $header=sprintf("%s %s %s Class:%s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$header_class,$term,$subject,$user);
}

if ($v==1)
{
  $header=sprintf("%s %s %s Cluster:%s Term:%s Subject:%s
  Teacher:%s",$school,$school_year,$department,$cluster,$term,$subject,$user);
}

if ($class_ref!='')
{
  if ($v==0)
  {
    $header=sprintf("%s %s %s Class:%s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$header_class,$term,$subject,$teacher);
  }

  if ($v==1)
  {
    $header=sprintf("%s %s %s Cluster:%s Term:%s Subject:%s
    Teacher:%s",$school,$school_year,$department,$cluster,$term,$subject,$teacher);
  }

}


 $marks_table->assign("header",$header);
 $marks_table->assign("average",$average);
 $marks_table->display("marks_print_table.tpl");

?>
