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



$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';


$table_school='school';
$table_year='year';
$table_department='department';
$table_term='term';
$table_grade='grade';
$table_credits_report='credits_report';


$term_Stmt = "SELECT * from $table_school, $table_year, $table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'
order by $table_term.term";

$subject_Stmt = "SELECT * from $table_teacher, $table_teacher_year, $table_teacher_department,
$table_teacher_subject where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref=$table_teacher_department.year_ref and
$table_teacher_department.department_ref=$table_teacher_subject.department_ref and
$table_teacher.login='$user' and
$table_teacher_year.school='$school' and
$table_teacher_year.year='$school_year' and
$table_teacher_department.department='$department'
order by $table_teacher_subject.subject";

$grade_Stmt = "SELECT * from $table_school, $table_year,
$table_department, $table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_grade.grade='$grade'";

$credits_report_Stmt = "SELECT * from $table_credits_report where
$table_credits_report.grade_ref='%d'";








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


//determination of mark_border

if (!($result_grade= mysql_query($grade_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_grade = mysql_fetch_object($result_grade);
$grade_ref=$field_grade->grade_ref;
mysql_free_result($result_grade);

//credits
if (!($result_credits= mysql_query(sprintf($credits_report_Stmt,$grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
}
$k=0;
while ($field_credits = mysql_fetch_object($result_credits) )
{  
  $k++;
  $mark_border=$field_credits->mark_border;
}
if ($k==0)
{
  $mark_border=60;
}
mysql_free_result($result_credits);


if (!($result_subject= mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

while($field = mysql_fetch_object($result_subject))
{
  $subject_list["$field->subject"]="$field->subject";
} 
mysql_free_result($result_subject);

$term_list='';
while($field = mysql_fetch_object($result_term))
{
  $term_list["$field->term"]="$field->term";
} 
mysql_free_result($result_term);





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
     $executestring.=sprintf("marks_select.php?school_year=$school_year&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&term=$term&subject=$subject&cluster=$cluster&v=0&t=%d",time());
  
   }
   if ($v==302)//Score (* main menu results)
   {
      $executestring = sprintf("Location: score_select.php?school_year=$school_year&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&term=$term&subject=$subject&cluster=$cluster&v=0&t=%d",time());
         
   }
   if ($v==303)//exams (* main menu results)//exams
   {
      $executestring = sprintf("Location: exam_select.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&v=0&t=%d",time());
   }

   if ($v==502)//Subject (* main menu attendance)
   {
      $executestring = sprintf("Location: subject_presention.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&v=0&t=%d",time());
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
     $executestring = sprintf("Location: marks_select.php?school_year=$school_year&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&term=$term&subject=$subject&cluster=$cluster&v=1&t=%d",time());
     
   }
   if ($v==302)//Score (* main menu results)
   {
      $executestring = sprintf("Location: score_select.php?school_year=$school_year&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&term=$term&subject=$subject&cluster=$cluster&v=1&t=%d",time());
   }
   if ($v==303)//exams (* main menu results)//exams
   {
      $executestring = sprintf("Location: exam_select.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&v=1&t=%d",time());
   }
   if ($v==502)//Subject (* main menu attendance)
   {
     $executestring = sprintf("Location: subject_presention.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&subject=$subject&cluster=$cluster&v=11&t=%d",time());
   }
  
   header($executestring);
   exit();
}



if (!($v==502||$v==3)) //exam and attendance(subject)
{
  $data = new Smarty_NM();
  $data->assign("subject_options",$subject_list);
  $data->assign("term_options",$term_list); 
  $data->assign("cluster_options",$cluster_list);
  $data->assign("subject_action","subject.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&teacher=$user&v=$v");
  
  $data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
  $data->display("subject_term.tpl");
}

if (($v==502)||($v==3))
{
  $data = new Smarty_NM();
  $data->assign("subject_options",$subject_list);
  $data->assign("cluster_options",$cluster_list);
  $data->assign("subject_action","subject.php?school_year=$school_year&school=$school&department=$department&grade=$grade&class=$class&teacher=$user&v=$v");
  
  $data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
  $data->display("subject.tpl");
}




?>
