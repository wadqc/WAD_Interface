<?
  
function lock_student($class_ref,$lock_code)
{  

require("../globals.php");

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$student_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_class_student.class_ref='%d' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref";


$update_student_Stmt = "Update $table_student set
web_lock='%s'where $table_student.student_ref='%d'";     

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit();
}


// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_student= mysql_query(sprintf($student_Stmt,$class_ref), $link))) {
DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
exit() ;
}

$student_field = mysql_fetch_object($result_student);


if (!(mysql_query(sprintf($update_student_Stmt,$lock_code,$student_field->student_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

mysql_free_result($result_student);

}// end of function
   
?>