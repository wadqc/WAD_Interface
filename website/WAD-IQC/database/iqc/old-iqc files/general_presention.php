<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

if (empty($_GET['stamp']))
{  
  $date_stamp=time();
}


if (!empty($_GET['stamp']))
{
  $stamp=$_GET['stamp'];
} 



if (empty($_GET['down_x']))
{
  $down_x=-1;
}
if (!empty($_GET['down_x']))
{
  $down_x=$_GET['down_x'];
}


if (empty($_GET['up_x']))
{
  $up_x=-1;
}
if (!empty($_GET['up_x']))
{
  $up_x=$_GET['up_x'];
}

if ($up_x>0)
{
  $new_time=$stamp;
  $next_stamp  = mktime(0, 0, 0, date("m",$new_time)  , date("d",$new_time)+1, date("Y",$new_time));
  $date_stamp=$next_stamp;
}

if ($down_x>0)
{
  $new_time=$stamp;
  $prev_stamp  = mktime(0, 0, 0, date("m",$new_time)  , date("d",$new_time)-1, date("Y",$new_time));
  $date_stamp=$prev_stamp;
}



if (($up_x==-1)&&($down_x==-1))
{  
  if (empty($_GET['stamp'])) //first visit, use current time stamp 
  {  
    $date_stamp=time();
  }
  if (!empty($_GET['stamp'])) //save, use previous time stamp
  {  
    $date_stamp=$_GET['stamp'];
  }  
}



$day_of_the_week=sprintf("%s",date("l",$date_stamp));
if ($day_of_the_week=='Saturday')
{
  $date_stamp  = mktime(0, 0, 0, date("m",$date_stamp)  , date("d",$date_stamp)+2, date("Y",$date_stamp));
}
if ($day_of_the_week=='Sunday')
{
  $date_stamp  = mktime(0, 0, 0, date("m",$date_stamp)  , date("d",$date_stamp)-2, date("Y",$date_stamp));
}
$date=sprintf("%s",date("Y-m-d",$date_stamp));




//$v=$_GET['v'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];


$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$table_presention='presention_general';

$table_school='school';
$table_year='year';
$table_term='term';


$student_Stmt = "SELECT * from $table_student,$table_school_student,
$table_department_student, $table_class_student where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_class_student.year='$school_year' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";

$presention_Stmt = "SELECT * from $table_presention where
$table_presention.class_ref='%d'and
$table_presention.date='%s'"; 

$term_Stmt = "SELECT * from $table_school,$table_year,$table_term where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year' 
order by $table_term.term";

$student_hours_Stmt="SELECT * from $table_class_student where $table_class_student.class_ref='%d'"; 

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


if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_term= mysql_query($term_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$term_counter=0;
while($field_term = mysql_fetch_object($result_term))
{
  if ($term_counter==0)
  {
     $start_date=$field_term->start_date;
  }
  $stop_date=$field_term->stop_date;
  $term_counter++;
}
mysql_free_result($result_term);

$start_year = substr($school_year,0,4);   
$stop_year  = substr($school_year,5,4); 

$start_month = substr($start_date,5,2);   
$stop_month  = substr($stop_date,5,2); 

$start_day = substr($start_date,8,2);   
$stop_day  = substr($stop_date,8,2); 


//testing
$current_year=sprintf("%s",date("Y",$date_stamp));
$current_month=sprintf("%s",date("m",$date_stamp));
$current_day=sprintf("%s",date("d",$date_stamp));
// end testing


if ($current_year>$stop_year)
{
  $current_year=$stop_year;
  $current_month=$stop_month;
  $current_day=$stop_day;
}
if ($current_year<$start_year)
{
  $current_year=$start_year;
  $current_month=$start_month;
  $current_day=$start_day;
}

if ($current_year==$start_year)
{
  if ($current_month<$start_month)
  {
    $current_month=$start_month;
    $current_day=$start_day;
  }
  if ($current_month==$start_month)
  {
    if($current_day<$start_day)
    {
      $current_day=$start_day;
    }
  }
}

if ($current_year==$stop_year)
{
  if ($current_month>$stop_month)
  {
    $current_month=$stop_month;
    $current_day=$stop_day;
  }
  if ($current_month==$stop_month)
  {
    if($current_day>$stop_day)
    {
      $current_day=$stop_day;
    }
  }
}

//printf("current_year=%s, current_month=%s and current_day=%s",$current_month, $current_day, $current_year);


$time_stamp  = mktime(0, 0, 0, $current_month, $current_day, $current_year);
$date_stamp=$time_stamp;
$date=sprintf("%s",date("Y-m-d",$date_stamp));



$calendar_day=sprintf("%s",date("l",$date_stamp));
  
$year_select=sprintf("%s",date("Y",$date_stamp));
$day_select=sprintf("%s",date("d",$date_stamp));
$month_text=sprintf("%s",date("F",$date_stamp));  

$month_day_year=sprintf("%s %s %s",$month_text,$day_select,$year_select);

$data_header = new Smarty_NM();
$data_header->assign("bg_color","#B8E7FF");
$table_presention_select=$data_header->fetch("presention_header_row.tpl");


$data_row = new Smarty_NM();

//$date_name=sprintf("presention");
//$data_row->assign("presention_prefix",$date_name);  

$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
   if (!($result_presention=
   mysql_query(sprintf($presention_Stmt,$field_student->class_ref,$date), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }  
   //$t=0;
   $comment='';
   $checked['late']='0';
   $checked['absent']='0';
   $checked['absent_letter']='0';
   $checked['sendout']='0';
   $checked['homework']='0';
   $checked['material']='0';
   $checked['leave']='0';
   $checked['suspended']='0';
   
   if (!($result_student_hours= mysql_query(sprintf($student_hours_Stmt,$field_student->class_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
   }
   $field_student_hours = mysql_fetch_object($result_student_hours);
   switch ($calendar_day)
   {
     case 'Monday':    $hours=$field_student_hours->monday_hours;
                       break;
     case 'Tuesday':   $hours=$field_student_hours->tuesday_hours;
                       break;
     case 'Wednesday': $hours=$field_student_hours->wednesday_hours;
                       break;
     case 'Thursday':  $hours=$field_student_hours->thursday_hours;
                       break;
     case 'Friday':    $hours=$field_student_hours->friday_hours;
                       break;
   }
   mysql_free_result($result_student_hours);  

   while($field_presention = mysql_fetch_object($result_presention))
   {
     $comment=sprintf("%s",$field_presention->comment);
     $checked['late']=$field_presention->late;
     if ($checked['late']==$hours)
     {
       $checked['late']='D';
     }
     $checked['absent']=$field_presention->absent;
     if ($checked['absent']==$hours)
     {
       $checked['absent']='D';
     }
     $checked['absent_letter']=$field_presention->absent_letter;
     if ($checked['absent_letter']==$hours)
     {
       $checked['absent_letter']='D';
     }
     $checked['sendout']=$field_presention->sendout;

     $checked['homework']=$field_presention->homework;
     if ($checked['sendout']==$hours)
     {
       $checked['sendout']='D';
     }
     $checked['material']=$field_presention->material;
     if ($checked['material']==$hours)
     {
       $checked['material']='D';
     }
     $checked['leave']=$field_presention->leave;
     if ($checked['leave']==$hours)
     {
       $checked['leave']='D';
     }
     $checked['suspended']=$field_presention->suspension;
     if ($checked['suspended']==$hours)
     {
       $checked['suspended']='D';
     }
   }
   mysql_free_result($result_presention);

   //set default values
   $data_row->assign("class_hours",$class_hours_list);
   $data_row->assign("presention_L_id",$checked['late']);
   $data_row->assign("presention_A_id",$checked['absent']);
   $data_row->assign("presention_AL_id",$checked['absent_letter']);
   $data_row->assign("presention_S_id",$checked['sendout']);
   $data_row->assign("presention_H_id",$checked['homework']);
   $data_row->assign("presention_M_id",$checked['material']);
   $data_row->assign("presention_LV_id",$checked['leave']);
   $data_row->assign("presention_SU_id",$checked['suspended']);
   $data_row->assign("default_comment",sanitize_var($comment));  
   
  
   $b=($j%2);
   if ($b==0)
   {
     $data_row->assign("bg_color","#B8E7FF");
   }
   if ($b==1)
   {
     $data_row->assign("bg_color",'');
   }
   $data_row->assign("first_name",$field_student->firstname);
   $data_row->assign("last_name",$field_student->lastname);
     
   $temp=sprintf("presention_L[%s]",$field_student->class_ref); 
   $data_row->assign("presention_L",$temp);
   $temp=sprintf("presention_A[%s]",$field_student->class_ref); 
   $data_row->assign("presention_A",$temp);
   $temp=sprintf("presention_AL[%s]",$field_student->class_ref); 
   $data_row->assign("presention_AL",$temp);
   $temp=sprintf("presention_S[%s]",$field_student->class_ref); 
   $data_row->assign("presention_S",$temp);
   $temp=sprintf("presention_H[%s]",$field_student->class_ref); 
   $data_row->assign("presention_H",$temp);
   $temp=sprintf("presention_M[%s]",$field_student->class_ref); 
   $data_row->assign("presention_M",$temp);
   $temp=sprintf("presention_LV[%s]",$field_student->class_ref); 
   $data_row->assign("presention_LV",$temp);
   $temp=sprintf("presention_SU[%s]",$field_student->class_ref); 
   $data_row->assign("presention_SU",$temp);
   $temp=sprintf("presention_comment[%s]",$field_student->class_ref); 
   $data_row->assign("presention_comment",$temp);
   

   $table_presention_select.=$data_row->fetch("presention_row.tpl");
   $j++;
} 

 $data = new Smarty_NM(); 

 //$table_presention_select='';
 $data->assign("subject_list",$table_presention_select);
 $data->assign("calendar_day",$calendar_day);
 //$data->assign("month_day_year",$month_day_year); 
 $data->assign("presention_date",$date);
 $data->assign("start_year",$start_year);
 $data->assign("end_year",$stop_year);

$data->assign("date_action",sprintf("add_general_presention.php?stamp=$date_stamp&datum=$date&school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&t=%d",time()));
 
 
 $header=sprintf("School_year $school_year Department $department Class $class");
 $data->assign("header",$header);

 //printf("so far so good");
 //exit();

 $data->display("presention_subject_select.tpl");
 
 mysql_free_result($result_student);  

?>
