<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$v=$_GET['v'];

$new_student_ref=''; 
if (!empty($_GET['new_student_ref']))
{
 $new_student_ref=$_GET['new_student_ref']; 
}


//$action['School']['Terms']='../open_school/show_school_name.php?v=1';
//$action['School']['Departments']='../open_school/show_school_name.php?v=2';
//$action['School']['Grades']='../open_school/show_school_name.php?v=3';
//$action['School']['Subjects']='../open_school/show_school_name.php?v=4';
//$action['School']['Report card']='../open_school/show_school_name.php?v=5';
//$action['School']['Skills']='../open_school/show_school_name.php?v=6';
//$action['School']['Sub Skills']='../open_school/show_school_name.php?v=7';
//$action['School']['Exam card']='../open_school/show_school_name.php?v=8';
//$action['School']['Score']='../open_school/show_school_name.php?v=9';
//$action['School']['Doctors']='../open_school/show_school_name.php?v=10';

//$action['Teachers']['Teachers']='../open_school/show_school_name.php?v=101';
//$action['Teachers']['Subjects']='../open_school/show_school_name.php?v=102';

//$action['Students']['Students']='../open_school/show_school_name.php?v=201';
//$action['Students']['Subjects']='../open_school/show_school_name.php?v=202';
//$action['Students']['Mentor']='../open_school/show_school_name.php?v=203';
//$action['Students']['Admin']='../open_school/show_school_name.php?v=204';
//$action['Students']['ID cards']='../open_school/show_school_name.php?v=205';

//$action['Results']['Grades']='../open_school/show_school_name.php?v=301';
//$action['Results']['Skills']='../open_school/show_school_name.php?v=302';
//$action['Results']['SBA']='../open_school/show_school_name.php?v=303';
//$action['Results']['Credits']='../open_school/show_school_name.php?v=304';

//$action['Reports']['Term']='../open_school/show_school_name.php?v=401';
//$action['Reports']['Meeting']='../open_school/show_school_name.php?v=402';

//$action['Attendance']['Class']='../open_school/show_school_name.php?v=501';
//$action['Attendance']['Subject']='../open_school/show_school_name.php?v=502';
//$action['Attendance']['Student']='../open_school/show_school_name.php?v=503';
//$action['Attendance']['Barcode']='../open_school/show_school_name.php?v=504';





$level=1;

switch($v)
{
  case 1: $level=1;
          break;
  case 2: $level=1;
          break;
  case 3: $level=1;
          break;
  case 4: $level=1;
          break;
  case 5: $level=1;
          break;
  case 6: $level=1;
          break;
  case 7: $level=1;
          break;
  case 8: $level=1;
          break;
  case 9: $level=1;
          break;
  case 10: $level=1;
           break;
  case 101: $level=1;
            break;
  case 102: $level=1;
            break;
  case 103: $level=1;
            break;
  case 201: $level=4;
            break;
  case 202: $level=1;
            break;
  case 203: $level=1;
            break;
  case 204: $level=1;
            break;
  case 205: $level=1;
            break;
  case 301: $level=4;
            break;
  case 302: $level=4;
            break;
  case 303: $level=4;
            break;
  case 304: $level=4;
            break;
  case 401: $level=4;
            break;
  case 402: $level=1;
            break;
  case 403: $level=1;
            break;
  case 501: $level=1;
            break;
  case 502: $level=1;
            break;
  case 503: $level=1;
            break; 
  case 504: $level=1;
            break;  
}
//printf("user_level_1=%s",$user_level_1);
//printf("user_level_2=%s",$user_level_2);
//printf("user_level_3=%s",$user_level_3);
//printf("level_3=%s",$level);



if ( (!empty($user_level_4))&&($level==1))
{
  $error_message=sprintf("No permission");
  
  $error = new Smarty_NM();
  $error->assign("error_message",$error_message);
  
  $error->assign("error_action",'');
  $error->assign("error_button",'');

  $error->display("error_message.tpl");

  exit();
}

if ($v==303)
{  
  $error_message=sprintf("Not implemented yet");
  
  $error = new Smarty_NM();
  $error->assign("error_message",$error_message);
  
  $error->assign("error_action",'');
  $error->assign("error_button",'');

  $error->display("error_message.tpl");

  exit();
}


$school_action=sprintf("show_school_year.php?v=%s&school=%s&new_student_ref=%s",$v,$login_school_name,$new_student_ref);
switch($v)
{
  case 8: $school_action=sprintf("show_skills_sub.php?v=%s&school=%s&school_year=%s",$v,$login_school_name,$login_school_year);
        break; //skill_sub (school)

  case 10: $school_action=sprintf("show_doctors.php?v=%s&school=%s",$v,$login_school_name);
           break; //doctor (school)

  case 504: $school_action=sprintf("daily_presention.php?v=%s&school=%s",$v,$login_school_name);
            break; //barcode (attendance)
} 



  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= $school_action;
  header($executestring);
  exit();

?>
