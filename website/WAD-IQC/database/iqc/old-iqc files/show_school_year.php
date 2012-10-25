<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$v=$_GET['v'];

$new_student_ref=''; 
if (!empty($_GET['new_student_ref']))
{
 $new_student_ref=$_GET['new_student_ref']; 
}

$year_action=sprintf("show_departments.php?v=$v&school=$school&school_year=$login_school_year&new_student_ref=$new_student_ref");
 switch($v)
 { 
  case 1:   $year_action=sprintf("create_terms.php?v=$v&school=$school&school_year=$login_school_year");
            break; //terms

  case 2:   $year_action=sprintf("create_departments.php?v=$v&school=$school&school_year=$login_school_year");
            break; //departments

  case 7:   $year_action=sprintf("create_skills.php?v=$v&school=$school&school_year=$login_school_year");
            break; //skills

  case 9:   $year_action=sprintf("create_score.php?v=$v&school=$school&school_year=$login_school_year");
            break; //score

  case 101: $year_action=sprintf("show_teachers.php?v=$v&school=$school&school_year=$login_school_year");
            break; //teachers

  case 102: $year_action=sprintf("show_subjects_teacher.php?v=$v&school=$school&school_year=$login_school_year");
            break; //subject teachers
  case 103: $year_action=sprintf("create_id_cards_teachers_pdf.php?v=$v&school=$school&school_year=$login_school_year");
            break; //id_cards (teacher)
  case 403: $year_action=sprintf("report_attendance_select.php?v=$v&school=$school&school_year=$login_school_year");
            break; //report attendance

}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= $year_action;
  header($executestring);
  exit();
 
 
$school_table->display("show_school_year.tpl"); 
?>
