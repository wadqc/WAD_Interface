<?php 

require("../globals.php") ;
require("./common.php") ;
require("./add_school_function.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill_ref=$_GET['skill_ref'];

$skill_sub=$_POST['skill_sub'];
$code=$_POST['code'];
$number=$_POST['number'];



  add_school_sub_skill($skill_sub,$code,$number,$skill_ref,&$skill_sub_ref);

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_skills_sub.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();

?>





