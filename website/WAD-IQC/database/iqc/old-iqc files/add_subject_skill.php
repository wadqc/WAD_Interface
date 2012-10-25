<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");

$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$subject=$_GET['subject'];

$number=$_POST['number'];
$skill=$_POST['skill'];
$abreviation=$_POST['abreviation'];


add_subject_skill($skill,$abreviation,$number,$subject_ref,&$skill_ref);



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.=sprintf("view_subject_department.php?school=$school&school_year=$school_year&department=$department&subject_ref=$subject_ref&t=%d",time());

header($executestring);
exit();

?>





