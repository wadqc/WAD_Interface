<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_student='naw';
$table_mpc_class='mpc_class';

$class=$_GET['class'];
$grade=$_GET['grade'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];


$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';


$class_Stmt="SELECT * from $table_year, $table_department, $table_grade,
$table_class where
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_year.year='%s' and 
$table_grade.grade >= ($grade-1)
order by $table_grade.grade, $table_class.number,$table_class.class"; 


$year_Stmt = "SELECT * from $table_year";

$department_Stmt = "SELECT * from $table_year, $table_department where 
$table_year.year_ref=$table_department.year_ref and
$table_year.year='%s'
order by $table_department.number";



$student_Stmt = "SELECT * from $table_student, $table_mpc_class where 
$table_mpc_class.afdeling='$department' and 
$table_mpc_class.klas='$class' and
$table_mpc_class.jaar='$school_year'and
$table_student.naw_ref=$table_mpc_class.naw_ref
order by $table_student.lastname, $table_student.firstname";



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

if (!($result_klas= mysql_query(sprintf($class_Stmt,$school_year,$department), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_year= mysql_query($year_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$previous="";
while($field = mysql_fetch_object($result_klas))
{
  if($field->class!=$previous)
  {
    $list_klas["$field->class"]="$field->class";
  }
  $previous=$field->class;
} 
mysql_free_result($result_klas);

while($field = mysql_fetch_object($result_year))
{
   $list_year["$field->year"]="$field->year";
   $most_recent_year=$field->year;
} 
mysql_free_result($result_year);

if (!($result_department= mysql_query(sprintf($department_Stmt,$most_recent_year),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

while($field = mysql_fetch_object($result_department))
{
  $list_department["$field->department"]="$field->department";
} 
mysql_free_result($result_department);





 $table_student="";
 
  $j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   if ($b==0)
   $table_student.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_student.=sprintf("<TR>");
   //$student[$field_student->mpc_class_ref]="off";
   $table_student.=sprintf("<td><input
   type=\"checkbox\" name=\"student[$field_student->mpc_class_ref]\" value=\"on\"></td>");  
  
   $table_student.=sprintf("
  <td>
     <font color=\"red\"><B>%s</B></font>
  </td>
  <td>
     <font color=\"red\"><B><a href=\"view_student_teacher.php?mpc_class_ref=$field_student->mpc_class_ref\">%s</a></B></font>
  </td>
  <td>
     <font color=\"red\"><B>%s</B></font>
  </td>
  <td>
     <font color=\"red\"><B>%s</B></font>
  </td>",$field_student->number,$field_student->firstname,$field_student->lastname,$field_student->profiel);
  $table_student.=sprintf("</TR>");
  $j++;
}


mysql_free_result($result_student);  

$data = new Smarty_NM();


$data->assign("klas_options",$list_klas);
$data->assign("year_options",$list_year);
$data->assign("department_options",$list_department);



$data->assign("header",sprintf("School year %s Department %s Class %s",$school_year,$department,$class));

$data->assign("form_action",sprintf("transfer_student.php?class=%s&department=%s&school_year=%s",$class,$department,$school_year));
$data->assign("student_list",$table_student);

$new_student=sprintf("<a href=\"new_student.php?department=%s&class=%s&school_year=%s&t=%d\">Add new Student</a>",$department,$class,$school_year,time());

$data->assign("new_student",$new_student);

$data->display("student_select.tpl");
 
  
