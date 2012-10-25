<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];

$number=$_POST['number'];
$class=$_POST['class'];


$selectStmt_class = "Select * from $table_school,$table_year, $table_department,
$table_grade, $table_class where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_class.class='%s' and
$table_grade.grade='%d' and
$table_department.department='%s' and
$table_year.year='%s' and
$table_school.school='%s'";

$queryStmt_grade = "Select * from $table_grade where 
$table_grade.department_ref='%d' and 
$table_grade.grade='%d'";


$queryStmt_department = "Select * from $table_school, $table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department='%s' and
$table_year.year='%s' and
$table_school.school='%s'";


$addStmt_grade = "Insert into $table_grade(grade,department_ref)
values ('%d','%d')";

$addStmt_class = "Insert into $table_class(class,number,grade_ref)
values ('%s','%d','%d')";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_class= mysql_query(sprintf($selectStmt_class,$class,$grade,$department,$school_year,$school), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_class = mysql_fetch_object($result_class)))
{
   $content.=sprintf("<tr><td class=\"table_data\">class %s already excists for grade %s</td></tr>",$field_class->class,$field_class->grade);  
}
mysql_free_result($result_class);  

if ($content!="") //class already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("class_excist.tpl");
}

if (!($content)) //new class
{
  //query for department_ref 
  
  if (!($result_department=mysql_query(sprintf($queryStmt_department,$department,$school_year,$school),$link))){
  DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_department)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  
  $field_department = mysql_fetch_object($result_department);
  $department_ref=$field_department->department_ref;
  
  // query for excisting grade or create grade if not excists

  if (!($result_grade=mysql_query(sprintf($queryStmt_grade,$department_ref,$grade),$link))){
  DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_grade)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }

  $grade_ref=-1; //verify whether or not the grade excists
  while($field_grade = mysql_fetch_object($result_grade))
  {
     $grade_ref=$field_grade->grade_ref;
  }
  mysql_free_result($result_grade);

  if ($grade_ref==-1) //grade not available, create new grade
  {
    if (!(mysql_query(sprintf($addStmt_grade,$grade,$department_ref),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt_grade)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }

    if (!($result_grade=mysql_query(sprintf($queryStmt_grade,$department_ref,$grade),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }
 
    $field_grade = mysql_fetch_object($result_grade);
    $grade_ref=$field_grade->grade_ref;
    mysql_free_result($result_grade);
  }
  // grade defined

  if(!mysql_query(sprintf($addStmt_class,$class,$number,$grade_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt_class)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  
}
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_grades.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
  header($executestring);
  exit();

?>





