<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$date_stamp=time();
$current_year=sprintf("%s",date("Y",$date_stamp));
$current_month=sprintf("%s",date("m",$date_stamp));

if (empty($_POST['down_x']))
{
  $down_x=-1;
}
if (!empty($_POST['down_x']))
{
  $down_x=$_POST['down_x'];
}


if (empty($_POST['up_x']))
{
  $up_x=-1;
}
if (!empty($_POST['up_x']))
{
  $up_x=$_POST['up_x'];
}


if ($up_x>0)
{
  $current_year=$year_select;
  $current_month=$month_select+1;
  if ($current_month>12)
  {
    $current_month=1;
    $current_year=$year_select+1;
  }
}

if ($down_x>0)
{
  $current_year=$year_select;
  $current_month=$month_select-1;
  if ($current_month<1)
  {
    $current_month=12;
    $current_year=$year_select-1;
  }
}



$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_presention='presention_subject';
$table_presention_general='presention_general';

$table_subject_table='table_subject';
$table_group='table_groep';

$table_year='year';
$table_term='term';

if ($v==0)
{
  $query_group="%";
  $query_klas=$klas;
}

if ($v==1)
{
  $query_group=$group; 
  $query_klas=sprintf("%s%%",$klas[0]);  
}

$presention_Stmt = "SELECT * from $table_presention where
$table_presention.subjects_ref='%d' and
$table_presention.date='%s'";

$presention_general_Stmt = "SELECT * from $table_presention_general where
$table_presention_general.mpc_class_ref='%d' and $table_presention_general.date='%s'";

$subject_Stmt = "SELECT * from $table_naw, $table_mpc_class, $table_subject where
$table_mpc_class.jaar='$year' and 
$table_mpc_class.afdeling='$department' and
$table_mpc_class.klas='$class' and 
$table_mpc_class.mpc_class_ref='$mpc_class_ref' and 
$table_naw.naw_ref=$table_mpc_class.naw_ref and
$table_mpc_class.mpc_class_ref=$table_subject.mpc_class_ref and
$table_subject.mpc_class_ref='$mpc_class_ref'
order by $table_subject.subject";


$teacher_Stmt = "SELECT * from $table_subject where $table_subject.subject='%s'";
$group_Stmt = "SELECT * from $table_group";

$student_Stmt = "SELECT * from $table_naw, $table_mpc_class where
$table_mpc_class.jaar='$year' and 
$table_mpc_class.afdeling='$department' and
$table_mpc_class.klas='$class' and 
$table_mpc_class.mpc_class_ref='$mpc_class_ref' and 
$table_naw.naw_ref=$table_mpc_class.naw_ref
order by $table_naw.lastname";


$subjects_Stmt = "SELECT * from $table_subject where
$table_subject.mpc_class_ref='%d' and 
$table_subject.subject='%s'";

$term_Stmt = "SELECT * from $table_year, $table_term where
$table_year.year_ref=$table_term.year_ref and
$table_year.year='%s' 
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


if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_subject= mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_term= mysql_query(sprintf($term_Stmt,$year),$link))) {
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

$start_year = substr($year,0,4);   
$stop_year  = substr($year,5,4); 

$start_month = substr($start_date,5,2);   
$stop_month  = substr($stop_date,5,2); 

printf("start_year=%s",$start_year);
printf("stop_year=%s",$stop_year);
printf("start_month=%s",$start_month);
printf("stop_month=%s",$stop_month);


if ($current_year>$stop_year)
{
  $current_year=$stop_year;
  $current_month=$stop_month;
}
if ($current_year<$start_year)
{
  $current_year=$start_year;
  $current_month=$start_month;
}

if ($current_year==$start_year)
{
  if ($current_month<$start_month)
  {
    $current_month=$start_month;
  }
}
if ($current_year==$stop_year)
{
  if ($current_month>$stop_month)
  {
    $current_month=$stop_month;
  }
}




$stamp=mktime(0, 0, 0, $current_month, 1, $current_year);
$amount=sprintf("%d",date("t",$stamp));

//tot hier

$j=0;
while (($field = mysql_fetch_object($result_subject)))
{
  $subject_array[$j]=$field->subject;
  $j++;
}  

mysql_free_result($result_subject); 
$subject_number=count($subject_array);

$data = new Smarty_NM();

  $field_student = mysql_fetch_object($result_student);
  $header_class=sprintf("School_year $year Department $department Class $class");
  $data->assign("header_class",$header_class);
  $header_student=sprintf("Student %s %s",$field_student->firstname,$field_student->lastname);
  $data->assign("header_student",$header_student);
  


$table_view_presention=sprintf("
<tr>
  <td>
     <font color=\"blue\"><B>#</B></font>
  </td>
  <td>
     <font color=\"blue\"><B>Day</B></font>
  </td>
  <td>
     <font color=\"blue\"><B>General comment</B></font>
  </td>");
  
  $i=0;
  while ($i<$subject_number)
  {
    $table_view_presention.=sprintf("
    <td ><font color=\"blue\"><B>%s</B></font></td>
    <td ><font color=\"blue\"><B>Comment</B></font></td>",$subject_array[$i]);
    $i++;
  }
     
$table_view_presention.=sprintf("</tr>");

    
  $j=0;
  $day=1;

//printf("amount=%d",$amount);

while ($day<$amount+1)
{
  $date_stamp=mktime(0, 0, 0, $current_month, $day, $current_year);
  $date=sprintf("%s",date("Y-m-d",$date_stamp));
  
  $year_select=sprintf("%s",date("Y",$date_stamp));
  $month_select=sprintf("%s",date("m",$date_stamp));
  $month_text=sprintf("%s",date("F",$date_stamp));  

  $calendar_day=sprintf("%s",date("l",$date_stamp));
  $weekend=0;
  if (($calendar_day=="Saturday")||($calendar_day=="Sunday"))
  $weekend=1;
  $symbol="";
  $symbol.=$calendar_day[0];
  $symbol.=$calendar_day[1];

  
  $b=($j%2);
   
  if ($weekend==1)
  {
  $table_view_presention.=sprintf("<TR bgcolor=\"black\">"); 
  $table_view_presention.=sprintf("
  <td bgcolor=\"red\" ></td>");
  }
  if ($weekend==0)
  { 
  if ($b==0)
   $table_view_presention.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_view_presention.=sprintf("<TR>");
  $table_view_presention.=sprintf("
  <td bgcolor=\"#d5d5d5\">
     <font color=\"black\"><B>%d</B></font>
  </td>
  <td bgcolor=\"#d5d5d5\">
     <font color=\"black\"><B>%s</B></font>
  </td>",$day,$symbol);
  
  //insert general comment 
   if (!($result_presention_general=
   mysql_query(sprintf($presention_general_Stmt,$field_student->mpc_class_ref,$date), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }  
   $g=0;
   $comment_general="";
   while($field_presention_general = mysql_fetch_object($result_presention_general))
   {
     $comment_general=sprintf("%s",$field_presention_general->comment);
     $g=1;
   }
   mysql_free_result($result_presention_general);
   $table_view_presention.=sprintf("
  <td>
     <font color=\"black\"><B>%s</B></font>
  </td>",$comment_general);


  $i=0;
  while ($i<$subject_number)
  {

  if (!($result_subjects= mysql_query(sprintf($subjects_Stmt,$field_student->mpc_class_ref,$subject_array[$i]),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }
  $k=0;

  while($field_subject = mysql_fetch_object($result_subjects))
  {
    $subjects_ref=$field_subject->subjects_ref;
    $k++;
  }
 
  if ($k>0) //subject available
  {
     
   //insert subject specific comment
   if (!($result_presention=
   mysql_query(sprintf($presention_Stmt,$subjects_ref,$date), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }    
   $comment="";
   $checked="";
   while($field_presention = mysql_fetch_object($result_presention))
   {
     $comment=sprintf("%s",$field_presention->comment);
     $checked=sprintf("x");
     $t=1;
   }
   mysql_free_result($result_presention);
   } //k>0
   if ($k==0)
   {
     $comment="";
     $checked="";
   }

$table_view_presention.=sprintf("
  <td>
     <font color=\"black\"><B>%s</B></font>
  </td>
  <td>
     <font color=\"black\"><B>%s</B></font>
  </td>",$checked,$comment);
 
  mysql_free_result($result_subjects);
  $i++;  
  }//all subjects
 }//for weekdays only! 
 

 $table_view_presention.=sprintf("</tr>");
 $j++; 
 $day++;
  
}//all days

 mysql_free_result($result_student);  
 
 $data->assign("table_content",$table_view_presention);
 $start_self = sprintf("http://%s",$_SERVER['HTTP_HOST']);
 //printf("%s$PHP_SELF?mpc_class_ref=$mpc_class_ref&department=$department&class=$class&year=$year&year_select=$year_select&month_select=$month_select&v=$v&t=%d",$start_self,time());
 
$date_action=sprintf("%s$PHP_SELF?mpc_class_ref=$mpc_class_ref&department=$department&class=$class&year=$year&year_select=$year_select&month_select=$month_select&v=$v&t=%d",$start_self,time());
 
 $data->assign("calendar_month_year",sprintf("%s %d",$month_text,$year_select));
 $data->assign("date_action",$date_action);


 
 $data->display("view_presention.tpl");
 

?>
