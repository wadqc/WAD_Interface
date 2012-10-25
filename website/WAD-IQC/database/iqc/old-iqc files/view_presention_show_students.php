<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$grade=$_GET['grade'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$class=$_GET['class'];
$v=$_GET['v'];

$term=$_POST['term'];

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$table_presention_general='presention_general';

$table_school='school';
$table_year='year';
$table_term='term';

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


$presention_general_Stmt = "SELECT * from $table_presention_general where
$table_presention_general.class_ref='%d' and 
$table_presention_general.date>='%s' and 
$table_presention_general.date<='%s'
order by $table_presention_general.date";

$term_date_Stmt = "SELECT * from $table_school,$table_year,$table_term where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and 
$table_term.term='$term'";


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

if (!($result_term_date= mysql_query($term_date_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
 }
  
while ($field = mysql_fetch_object($result_term_date))
{
  $term_start=$field->start_date;
  $term_stop=$field->stop_date;
}
mysql_free_result($result_term_date);

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$table_presention_data=''; 
$data_counter=0;

$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
  $b=($j%2);
  //if ($b==0)
  //if ($b==1)
   
  $table_presention_row='';
  $counter=0;
  if (!($result_presention= mysql_query(sprintf($presention_general_Stmt,$field_student->class_ref,$term_start,$term_stop), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  while ($field_presention = mysql_fetch_object($result_presention))
  { 

    
    $current_year = substr($field_presention->date,0,4);   
    $current_month= substr($field_presention->date,5,2); 
    $current_day  = substr($field_presention->date,8,2);
    $date_stamp  = mktime(0, 0, 0, $current_month, $current_day, $current_year);
    $year=sprintf("%s",date("Y",$date_stamp));
    $day=sprintf("%s",date("d",$date_stamp)); 
    $day_text=sprintf("%s",date("D",$date_stamp));
    $month_text=sprintf("%s",date("F",$date_stamp));  

    $month_day_year=sprintf("%s %s %s %s",$month_text,$day,$year,$day_text);


    $data_row = new Smarty_NM(); 
    $data_row->assign("date",$month_day_year);
    $data_row->assign("presention_L",$field_presention->late);
    $data_row->assign("presention_A",$field_presention->absent);
    $data_row->assign("presention_AL",$field_presention->absent_letter);
    $data_row->assign("presention_S",$field_presention->sendout);
    $data_row->assign("presention_H",$field_presention->homework);
    $data_row->assign("presention_M",$field_presention->material);
    $data_row->assign("presention_LV",$field_presention->leave);
    $data_row->assign("presention_SU",$field_presention->suspension);
    $data_row->assign("presention_comment",$field_presention->comment);  
    if ($field_presention->comment=='')
    {
      $data_row->assign("presention_comment","-");
    }
    $table_presention_row.=$data_row->fetch("view_presention_row.tpl");
    $counter++;
  }
  mysql_free_result($result_presention);
  
  if ($counter!=0)
  {
    $data_counter++;
    $data_header = new Smarty_NM();
    $data_header->assign("bg_color","#B8E7FF");
    $student_name=sprintf("%s %s",$field_student->firstname,$field_student->lastname);
    $data_header->assign("student_name",$student_name);
    $table_presention_data.=$data_header->fetch("view_presention_header_row.tpl");
    $table_presention_data.=$table_presention_row;
  }


  
}

if ($data_counter==0)
{
  $table_presention_data.="No attendance data available for this term.";
}





mysql_free_result($result_student);  

$data = new Smarty_NM();

$data->assign("header",sprintf("School year %s Department %s Class %s Term %s
(%s until %s)",$school_year,$department,$class,$term,$term_start,$term_stop));
$data->assign("student_list",$table_presention_data);

$data->display("view_presention_student.tpl");

?> 
  
