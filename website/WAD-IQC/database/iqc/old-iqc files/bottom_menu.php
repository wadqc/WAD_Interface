<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$j=$_GET['j'];
 
$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));


switch($j)
{
  case 0: $level='school_bottom.tpl';         
          break;

  case 1: $level='teachers_bottom.tpl';
          break;

  case 2: $level='students_bottom.tpl';
          break;

  case 3: $level='results_bottom.tpl';
          break;

  case 4: $level='reports_bottom.tpl';
          break;

  case 5: $level='attendance_bottom.tpl';
          break;
 
}

$string = new Smarty_NM();
$start_string=$string->fetch('main_open_school.tpl');
$start_string='';
$bottom_frame=sprintf("./frontpage-bottom.html"); 

//printf("level=%s",$level);
$executestring.= sprintf("../main/main_open_school.php?start_string=$start_string&level=$level&bottom_frame=$bottom_frame");
//printf("execute=%s",$executestring);
header($executestring);
exit();
  


?>
