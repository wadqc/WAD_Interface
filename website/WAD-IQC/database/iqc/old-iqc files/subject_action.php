<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$v=$_GET['v'];

$action='';
if (!empty($_POST['action']))
{
  $action=$_POST['action'];
}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

if ($action=='Query_class')
{
   $subject=$_POST['subject'];
   $cluster=$_POST['cluster'];
   if (!empty($_POST['term']))
   {
     $term=$_POST['term'];
   }

   if ($v==301)//marks (* main menu results)
   {
     $executestring.=sprintf("marks_select.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=0&t=%d",time());
      
   //printf("%s",$executestring);
   }
   if ($v==302)//Score (* main menu results)
   {
      $executestring = sprintf("Location: score_select.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=0&t=%d",time());
   }
   if ($v==303)//exams (* main menu results)//exams
   {
      $executestring = sprintf("Location: exam_select.php?school_year=$school_year&school=$school&department=$department&class=$class&subject=$subject&cluster=$cluster&v=0&t=%d",time());
   }

   if ($v==502)//Subject (* main menu attendance)
   {
      $executestring = sprintf("Location: subject_presention.php?school_year=$school_year&school=$school&department=$department&class=$class&subject=$subject&cluster=$cluster&v=0&t=%d",time());
   }
   
   header($executestring);
   exit();
}


if ($action=='Query_cluster')
{
   $subject=$_POST['subject'];
   $cluster=$_POST['cluster'];
   if (!empty($_POST['term']))
   {
     $term=$_POST['term'];
   }
   
   if ($v==301) //marks (* main menu results)
   { 
     $executestring = sprintf("Location: marks_select.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=1&t=%d",time());
   }
   if ($v==302)//Score (* main menu results)
   {
      $executestring = sprintf("Location: score_select.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=0&t=%d",time());
   }
   if ($v==303)//exams (* main menu results)//exams
   {
      $executestring = sprintf("Location: exam_select.php?school_year=$school_year&school=$school&department=$department&class=$class&subject=$subject&cluster=$cluster&v=1&t=%d",time());
   }
   if ($v==502)//Subject (* main menu attendance)
   {
     $executestring = sprintf("Location: subject_presention.php?school_year=$school_year&school=$school&department=$department&class=$class&subject=$subject&cluster=$cluster&v=11&t=%d",time());
   }
  
   header($executestring);
   exit();
}

?>