<?

require("../globals.php") ;
require("./common.php") ;


$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class_ref=$_GET['class_ref'];
$grade=$_GET['grade'];
$default_class=$_GET['default_class'];
$class=$_POST['class'];
$number=$_POST['number'];


$table_class='class';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$updateStmt_class = "Update $table_class set
class='%s', number='%s' where
$table_class.class_ref='%d'";

$select_student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.grade='$grade' and
$table_class_student.class='$default_class' and
$table_class_student.year='$school_year' and
$table_department_student.department='$department' and
$table_school_student.school='$school'";

$update_student_class_Stmt = "Update $table_class_student set class='%s'where $table_class_student.class_ref='%d'";

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

// update class
if (!mysql_query(sprintf($updateStmt_class,$class,$number,$class_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


//update student_class
if (!($result_student= mysql_query($select_student_Stmt,$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $select_student_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }

while (($field_student = mysql_fetch_object($result_student)))
{
  $class_ref=$field_student->class_ref;
  
  if (!mysql_query(sprintf($update_student_class_Stmt,$class,$class_ref),$link))
  {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $update_student_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  } 


}








  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_grades.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
  header($executestring);
  exit();




?>














