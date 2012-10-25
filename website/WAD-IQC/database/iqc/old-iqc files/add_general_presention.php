<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

if (!empty($_POST['presention_L']))
{
  $presention_L=$_POST['presention_L'];
}
if (!empty($_POST['presention_A']))
{
  $presention_A=$_POST['presention_A'];
}
if (!empty($_POST['presention_AL']))
{
  $presention_AL=$_POST['presention_AL'];
}
if (!empty($_POST['presention_S']))
{
  $presention_S=$_POST['presention_S'];
}
if (!empty($_POST['presention_H']))
{
  $presention_H=$_POST['presention_H'];
}
if (!empty($_POST['presention_M']))
{
  $presention_M=$_POST['presention_M'];
}
if (!empty($_POST['presention_LV']))
{
  $presention_LV=$_POST['presention_LV'];
}
if (!empty($_POST['presention_SU']))
{
  $presention_SU=$_POST['presention_SU'];
  
}
if (!empty($_POST['presention_comment']))
{
  $presention_comment=$_POST['presention_comment'];
}




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

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$department=$_GET['department'];
$datum=$_GET['datum'];
$stamp=$_GET['stamp'];



$table_presention='presention_general';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

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

$student_hours_Stmt="SELECT * from $table_class_student where $table_class_student.class_ref='%d'"; 

$student_presention_Stmt="SELECT * from $table_presention where
$table_presention.date='$datum' and $table_presention.class_ref='%d'"; 

//the field name leave is set between quotes because this is also a mysql statement !!!!

$addStmt = "Insert into $table_presention(date,late,absent,absent_day,absent_letter,absent_letter_day,sendout,homework,material,`leave`,suspension,day_hours,comment,class_ref) values ('%s','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%s','%d')";

$updateStmt = "Update $table_presention set
`date`='%s',`late`='%d',`absent`='%d',`absent_day`='%d',`absent_letter`='%d',`absent_letter_day`='%d',`sendout`='%d',`homework`='%d',`material`='%d',`leave`='%d',`suspension`='%d',`day_hours`='%d',`comment`='%s',`class_ref`='%d' where `presention_general_ref`='%d'";

$deleteStmt = "DELETE from $table_presention WHERE
$table_presention.class_ref='%d'and 
$table_presention.date='%s'";


// Connect to the Database 
if (!($link=mysql_pconnect($hostName, $userName, $password))) {    DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;    exit(); }

// Select the Database
if (!mysql_select_db($databaseName, $link)) {    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;    exit() ; } 
if (!($result_student= mysql_query($student_Stmt, $link))) {    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;    exit() ; }

$day_of_week=date("l",$stamp);

while (($field_student = mysql_fetch_object($result_student)))
{
  $trigger=0;
  $check_L='';
  if ($presention_L[$field_student->class_ref]!='0')
  {
    $check_L=sprintf("%s",$presention_L[$field_student->class_ref]); 
    $trigger++;
  }
  $check_A='';
  if ($presention_A[$field_student->class_ref]!='0')
  {
    $check_A=sprintf("%s",$presention_A[$field_student->class_ref]);
    $trigger++; 
  }
  $check_AL='';
  if ($presention_AL[$field_student->class_ref]!='0')
  {
    $check_AL=sprintf("%s",$presention_AL[$field_student->class_ref]);
    $trigger++; 
  }
  $check_S='';
  if ($presention_S[$field_student->class_ref]!='0')
  {
    $check_S=sprintf("%s",$presention_S[$field_student->class_ref]);
    $trigger++; 
  }
  $check_H='';
  if ($presention_H[$field_student->class_ref]!='0')
  {
    $check_H=sprintf("%s",$presention_H[$field_student->class_ref]);
    $trigger++; 
  }
  $check_M='';
  if ($presention_M[$field_student->class_ref]!='0')
  {
    $check_M=sprintf("%s",$presention_M[$field_student->class_ref]);
    $trigger++; 
  }
  $check_LV='';
  if ($presention_LV[$field_student->class_ref]!='0')
  {
    $check_LV=sprintf("%s",$presention_LV[$field_student->class_ref]);
    $trigger++; 
  } 
  $check_SU='';
  if ($presention_SU[$field_student->class_ref]!='0')
  {
    $check_SU=sprintf("%s",$presention_SU[$field_student->class_ref]);
    $trigger++; 
  } 

  $comment='';
  if (!empty($presention_comment[$field_student->class_ref]))
  {
    $comment=sprintf("%s",$presention_comment[$field_student->class_ref]);
    $trigger++; 
  }
  

  if (!($result_student_presention= mysql_query(sprintf($student_presention_Stmt,$field_student->class_ref),$link))) {       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;       exit() ;   }
  $presention_counter=0;
  while($field_student_presention = mysql_fetch_object($result_student_presention))
  {
    $presention_counter++;
    $presention_general_ref=$field_student_presention->presention_general_ref;
  }
  mysql_free_result($result_student_presention); 
  //printf("presention_counter=%d",$presention_counter);
  //exit();

  if ($trigger>0) // at least one field is on
  {  //rebuild all presention data (new and modified) 
    
    if (!($result_student_hours= mysql_query(sprintf($student_hours_Stmt,$field_student->class_ref),$link))) {       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;       exit() ;     }
    $field_student_hours = mysql_fetch_object($result_student_hours);
    switch ($day_of_week)
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
    $absent_day=''; 
    $absent_letter_day=''; 
    mysql_free_result($result_student_hours);
    if(($check_L=='D')||($check_L>$hours))
    {
      $check_L=$hours;
    }
    if(($check_A=='D')||($check_A>$hours))
    {
      $check_A=$hours;
      $absent_day='1';
    }
    if(($check_AL=='D')||($check_AL>$hours))
    {
      $check_AL=$hours;
      $absent_letter_day='1';
    }
    if(($check_S=='D')||($check_S>$hours))
    {
      $check_S=$hours;
    }
    if(($check_H=='D')||($check_H>$hours))
    {
      $check_H=$hours;
    }
    if(($check_M=='D')||($check_M>$hours))
    {
      $check_M=$hours;
    }
    if(($check_LV=='D')||($check_LV>$hours))
    {
      $check_LV=$hours;
    }
    if(($check_SU=='D')||($check_SU>$hours))
    {
      $check_SU=$hours;
    }

    if ($presention_counter==0)
    {
      if (!(mysql_query(sprintf($addStmt,$datum,$check_L,$check_A,$absent_day,$check_AL,$absent_letter_day,$check_S,$check_H,$check_M,$check_LV,$check_SU,$hours,$comment,$field_student->class_ref),$link))) 
      {
        DisplayErrMsg(sprintf("Error for couter equal 0")) ;
        exit() ;       }
    }

    if ($presention_counter==1)
    {
      if (!(mysql_query(sprintf($updateStmt,$datum,$check_L,$check_A,$absent_day,$check_AL,$absent_letter_day,$check_S,$check_H,$check_M,$check_LV,$check_SU,$hours,$comment,$field_student->class_ref,$presention_general_ref),$link))) 
      {
        DisplayErrMsg(sprintf("Error for counter equal 1")) ;
        exit() ;       }
    }

  }//end trigger >0
  if ($trigger==0) // no field is on
  {
    if ($presention_counter==1)
    {
      //delete excisting presention
      if (!(mysql_query(sprintf($deleteStmt,$field_student->class_ref,$datum),$link))) 
      {
        DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
        exit() ;       }
    }
  }
} //loop for all students (class_ref)
mysql_free_result($result_student);  
 
if (!empty($_POST['Go']))
{
  $presention_date_day=$_POST['presention_Day'];
  $presention_date_month=$_POST['presention_Month'];
  $presention_date_Year=$_POST['presention_Year'];
  $stamp  = mktime(0, 0, 0, $presention_date_month  , $presention_date_day, $presention_date_Year );
}


 

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("general_presention.php?stamp=$stamp&school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&up_x=$up_x&down_x=$down_x&t=%d",time());

  header($executestring);
  exit();
   
?>