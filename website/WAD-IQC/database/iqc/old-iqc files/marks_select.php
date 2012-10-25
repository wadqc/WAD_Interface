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
$mark_border=$_GET['mark_border'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$v=$_GET['v'];
$offset=1;
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

$table_school='school';
$table_year='year';
$table_term='term';

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

$table_school='school';
$table_year='year';
$table_term='term';



$term_Stmt = "SELECT * from $table_school,$table_year,$table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and 
$table_term.term='$term'";



$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

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

if ($col_max<$mark_cols)
{
  $col_max=$mark_cols;
}

if (!($result_student= mysql_query(sprintf($student_Stmt,$field_teacher->initials),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
mysql_free_result($result_teacher);

// verify if term is locked
if (!($result_term=mysql_query($term_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_term = mysql_fetch_object($result_term); //only one hit!
$term_lock=$field_term->locked;
mysql_free_result($result_term); 
if ($term_lock=='on')  //reroute if term is locked
{
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("marks_print.php?school=$school&school_year=$school_year&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&term=$term&mark_border=$mark_border&v=$v&col_max=$col_max&t=%d",time());
  header($executestring);
  exit();
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
 $row_student_report_only="";
 $row_student_marks_only="";
 $j=0;
 $average='-';
while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   $student_report.=sprintf("
   <td class=\"table_data_blue_header_scroll\">
    %s
   </td>
   <td class=\"table_data_blue_header_scroll\">
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
       $mark_input =new Smarty_NM();

       $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
       $mark_input->assign("mark_name",$mark_name);  
       $mark_input->assign("mark_value",$field_marks->mark); 
       $mark_input->assign("id_name",sprintf("r%sc%s",$j,$m));
       $mark_input->assign("row_max",$student_counter);
       $mark_input->assign("col_max",$col_max);
       $student_marks.=$mark_input->fetch("marks_m_input.tpl");
       $default_description[$m]=sanitize_var($field_marks->description);     
       $default_date[$m]=$field_marks->date;
       $default_weigth[$m]=$field_marks->weigth;
       $report=$field_marks->report;
       $average=$field_marks->average;
       $col_available=1;
     }
     
     if ($col_available==0)
     {
       $mark_input =new Smarty_NM();
       $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
       $mark_input->assign("mark_name",$mark_name);
       $mark_input->assign("row_max",$student_counter);
       $mark_input->assign("col_max",$col_max);
       $mark_input->assign("id_name",sprintf("r%sc%s",$j,$m));  
       $student_marks.=$mark_input->fetch("marks_m_input.tpl");
     }
            
     if ($j==$student_counter) //header definition for available data
     {
       $description_input = new Smarty_NM();
       $description = new Smarty_NM();
       $description->assign("description","Description");
       $description_header.= $description->fetch("marks_description.tpl");
       $description_name=sprintf("description[%d]",$m);
       $description_input->assign("description",$description_name);
       if ($default_description[$m]!='')
       {    
         $description_input->assign("default_description",$default_description[$m]);
       }
       $description_input_header.=$description_input->fetch("marks_description_input.tpl");
        
       $date = new Smarty_NM();
       $date_input =new Smarty_NM();
       $date_header.= $date->fetch("marks_date.tpl");
   
       $date_name=sprintf("date_%d_",$m);
       $date_input->assign("mark_prefix",$date_name);  
       if ($default_date[$m]!='')
       {  
         $date_input->assign("time_mark",$default_date[$m]); 
       }
       $date_input->assign("year_start",$year_start);
       $date_input->assign("year_stop",$year_stop);  
       $date_input_header.= $date_input->fetch("marks_date_input.tpl");

       $weigth = new Smarty_NM();
       $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      
       $weigth_input =new Smarty_NM();
       $weigth_name=sprintf("weigth[%d]",$m);
       $weigth_input->assign("weigth",$weigth_name);  
       if ($default_weigth[$m]!='')
       {  
         $weigth_input->assign("default_weigth",$default_weigth[$m]);
       }
       $weigth_input_header.= $weigth_input->fetch("marks_weigth_input.tpl");

       $mr = new Smarty_NM();
       $mr_header.= $mr->fetch("marks_m.tpl");
     }  
     mysql_free_result($result_marks); 
     $m++;
   }
  
   $report_input = new Smarty_NM();
   $report_input->assign("report_value",$report);
   if ($report!="-")
   {
     sscanf($report,"%f",&$report_value);
     if ($report_value<$mark_border)
     {
       $student_report.=$report_input->fetch("marks_report_input_red.tpl");
     }
     if ($report_value>=$mark_border)
     {
       $student_report.=$report_input->fetch("marks_report_input.tpl");
     }
   }
   if ($report=="-")
   {  
     $student_report.=$report_input->fetch("marks_report_input.tpl");
   }
   //offset
   if ($offset==1)
   {  
     $m=$col_max+1; 
     $mark_input =new Smarty_NM();
     $mark_name=sprintf("mark[%d][%d]",$field_student->subjects_ref,$m);
     $mark_input->assign("mark_name",$mark_name);
     $mark_input->assign("id_name",sprintf("r%sc%s",$j,$m)); 
     $mark_input->assign("row_max",$student_counter);
     $mark_input->assign("col_max",$col_max);
     $student_marks.=$mark_input->fetch("marks_m_input.tpl");
            
     if ($j==$student_counter) //header definition for available data
     {
       $description_input = new Smarty_NM();
       $description = new Smarty_NM();
       $description->assign("description","Description");
       $description_header.= $description->fetch("marks_description.tpl");
       $description_name=sprintf("description[%d]",$m);
       $description_input->assign("description",$description_name);
       $description_input_header.=$description_input->fetch("marks_description_input.tpl");
        
       $date = new Smarty_NM();
       $date_input =new Smarty_NM();
       $date_header.= $date->fetch("marks_date.tpl");
   
       $date_name=sprintf("date_%d_",$m);
       $date_input->assign("mark_prefix",$date_name);  
              
       $date_input->assign("year_start",$year_start);
       $date_input->assign("year_stop",$year_stop);  
       $date_input_header.= $date_input->fetch("marks_date_input.tpl");

       $weigth = new Smarty_NM();
       $weigth_header.= $weigth->fetch("marks_weigth.tpl");
      
       $weigth_input =new Smarty_NM();
       $weigth_name=sprintf("weigth[%d]",$m);
       $weigth_input->assign("weigth",$weigth_name);  
       $weigth_input_header.= $weigth_input->fetch("marks_weigth_input.tpl");

       $mr = new Smarty_NM();
       $mr_header.= $mr->fetch("marks_m.tpl");
       $report=$field_marks->report;
     }   
   }


   //end offset

   $start_element=sprintf("<TR>");
   if ($b==0)
   {  
     $start_element=sprintf("<TR bgcolor=\"#B8E7FF\">");
   }
 
   $row.=$start_element;
   $row.=$student_report;
   $row.=$student_marks;
   $row.=sprintf("</tr>");  

   $row_student_report_only.=$start_element;
   $row_student_report_only.=$student_report;
   $row_student_report_only.=sprintf("</tr>");

   $row_student_marks_only.=$start_element;
   $row_student_marks_only.=$student_marks;
   $row_student_marks_only.=sprintf("</tr>");

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
 
 //$marks_table->assign("student_marks",$row);
 $marks_table->assign("student_marks_only",$row_student_marks_only);
 $marks_table->assign("student_report_only",$row_student_report_only);

 $marks_table->assign("marks_action",sprintf("update_marks.php?school=$school&school_year=$school_year&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&term=$term&mark_border=$mark_border&v=$v&t=%d",time()));

 $marks_table->assign("print_action",sprintf("marks_print.php?school=$school&school_year=$school_year&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&term=$term&mark_border=$mark_border&v=$v&col_max=$col_max&t=%d",time()));
                                             
if ($v==0)
{
  $header=sprintf("%s %s %s Grade:%s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$header_class,$term,$subject,$user);
}

if ($v==1)
{
  $header=sprintf("%s %s %s Cluster:%s Term:%s Subject:%s
  Teacher:%s",$school,$school_year,$department,$cluster,$term,$subject,$user);
}

 $marks_table->assign("header",$header);
 $marks_table->assign("average",$average);


 $marks_table->display("marks_table.tpl");

?>
