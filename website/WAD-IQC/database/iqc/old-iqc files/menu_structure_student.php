<?php 

require("../globals.php") ;


$level['top']['School']=1;

$level['School']['Personal']=1;
$level['School']['Grades']=2;
$level['School']['Attendance']=3;

$action['School']['Personal']='../../open_school/show_student_personal.php';
$action['School']['Grades']='../../open_school/show_student_years.php?v=401';
$action['School']['Attendance']='../../open_school/show_student_years.php?v=503';

?>