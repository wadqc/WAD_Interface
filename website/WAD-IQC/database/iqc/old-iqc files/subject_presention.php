<?php

//grade comes in as a new parameter check to divide cluster/class 




printf("comming soon");
exit();

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$class=$_GET['class'];
$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$v=$_GET['v'];





$date_stamp=time();
$date=sprintf("%s",date("Y-m-d",$date_stamp));

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
  $date=sprintf("%s",date("Y-m-d",$date_stamp));
  
  
}

if ($down_x>0)
{
  $new_time=$stamp;
  $prev_stamp  = mktime(0, 0, 0, date("m",$new_time)  , date("d",$new_time)-1, date("Y",$new_time));
  $date_stamp=$prev_stamp;
  $date=sprintf("%s",date("Y-m-d",$date_stamp));
  
}

$table_naw='naw';
$table_mpc_class='mpc_class';
$table_subject='subjects';
$table_presention='presention_subject';
$table_presention_general='presention_general';

$table_teacher='teacher';

if ($v==0)
{
  $query_cluster="%%";
  $query_class=$class;
}

if ($v==1)
{
  $query_cluster=$cluster; 
  $query_class=sprintf("%s%s",$class[0],'%%');  
}

$calendar_day=sprintf("%s",date("l",$date_stamp));
$year_select=sprintf("%s",date("Y",$date_stamp));
$day_select=sprintf("%s",date("d",$date_stamp));
$month_text=sprintf("%s",date("F",$date_stamp));  

$month_day_year=sprintf("%s %s %s",$month_text,$day_select,$year_select);

$student_Stmt = "SELECT * from $table_naw, $table_mpc_class, $table_subject where
$table_naw.naw_ref=$table_mpc_class.naw_ref and
$table_mpc_class.mpc_class_ref=$table_subject.mpc_class_ref and 
$table_mpc_class.jaar='$school_year' and
$table_mpc_class.class like '$query_class' and 
$table_mpc_class.afdeling='$department' and
$table_subject.subject='$subject' and 
$table_subject.groep like '$query_cluster' and 
$table_subject.teacher='%s' 
order by $table_naw.lastname";

$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

//$presention_Stmt = "SELECT * from $table_presention where
//$table_presention.subjects_ref='%d' and $table_presention.term='$term'
//and  $table_presention.date='%s'";

$presention_Stmt = "SELECT * from $table_presention where
$table_presention.subjects_ref='%d' and
$table_presention.date='%s'";

$presention_general_Stmt = "SELECT * from $table_presention_general where
$table_presention_general.mpc_class_ref='%d' and $table_presention_general.date='%s'";


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
mysql_free_result($result_teacher);

$data = new Smarty_NM();

$table_presention_select=sprintf("
<tr>
  <td>
     <font color=\"red\"><B>First_name</B></font>
  </td>
  <td>
     <font color=\"red\"><B>Last_name</B></font>
  </td>
  <td>
     <font color=\"red\"><B>NAC</B></font>
  </td>
  <td>
     <font color=\"red\"><B>Comment</B></font>
  </td>
  <td>
     <font color=\"red\"><B>General Comment</B></font>
  </td>");
     
  $table_presention_select.=sprintf("</tr>");

   $j=0;
$data_row = new Smarty_NM();

$date_name=sprintf("presention");
$data_row->assign("presention_prefix",$date_name);  

while (($field_student = mysql_fetch_object($result_student)))
{
   if (!($result_presention=
   mysql_query(sprintf($presention_Stmt,$field_student->subjects_ref,$date), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }  
   
   if (!($result_presention_general=
   mysql_query(sprintf($presention_general_Stmt,$field_student->mpc_class_ref,$date), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }  
   $t=0;
   $comment="";
   $checked="";
   while($field_presention = mysql_fetch_object($result_presention))
   {
     $comment=sprintf("%s",$field_presention->comment);
     $checked=sprintf("checked");
     $t=1;
   }
   mysql_free_result($result_presention);
   
   $g=0;
   $comment_general="";
   while($field_presention_general = mysql_fetch_object($result_presention_general))
   {
     $comment_general=sprintf("%s",$field_presention_general->comment);
     $g=1;
   }
   mysql_free_result($result_presention_general);

   //set default values
   $data_row->assign("checked",$checked);  
   $data_row->assign("default_comment",$comment);  
   $data_row->assign("default_comment_general",$comment_general);  
   $b=($j%2);
   if ($b==0)
   {
     $data_row->assign("bg_color","bgcolor=\"#B8E7FF\"");
   }
   if ($b==1)
   {
     $data_row->assign("bg_color","");
   }
   $data_row->assign("first_name",$field_student->firstname);
   $data_row->assign("last_name",$field_student->lastname);
     
   $temp=sprintf("presention_check[%s]",$field_student->subjects_ref); 
   $data_row->assign("presention_check",$temp);  
   $temp=sprintf("presention_comment[%s]",$field_student->subjects_ref); 
   $data_row->assign("presention_comment",$temp);
   

   $table_presention_select.=$data_row->fetch("presention_row.tpl");
   $j++;
} 
 
 $data->assign("subject_list",$table_presention_select);
 $data->assign("calendar_day",$calendar_day);
 $data->assign("month_day_year",$month_day_year);

 $data->assign("date_action",sprintf("add_subject_presention.php?stamp=$date_stamp&datum=$date&school_year=$school_year&department=$department&class=$class&subject=$subject&cluster=$cluster&v=$v&t=%d",time()));
 
 $header=sprintf("School_year $school_year Department $department Class $class");

 $data->assign("header",$header);

 $data->display("presention_subject_select.tpl");
 
 mysql_free_result($result_student);  
 ReturnToMain()
?>
