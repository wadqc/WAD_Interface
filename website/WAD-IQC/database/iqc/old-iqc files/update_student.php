<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$school=$_GET['school'];
$school_year=$_GET['school_year'];
$new_student_ref=$_GET['new_student_ref'];


$table_new_student='new_student';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$new_student_Stmt = "SELECT * from $table_new_student where student_ref='%d'";
$delStmt_new_student = "delete from  $table_new_student where $table_new_student.student_ref='%d'";

$select_student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref='%d'";

$selectStmt_student = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref!='%d' and
$table_class_student.year='%s' and
$table_school_student.school='%s' and
$table_department_student.department='%s' and 
$table_class_student.class='%s' and
$table_student.firstname='%s' and
$table_student.lastname='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";


$update_class_Stmt = "Update $table_class_student set profile='%s',picture='%s', transportation_to_school='%s', transportation_from_school='%s' where $table_class_student.class_ref='%d'";

$update_student_Stmt = "Update $table_student set
firstname='%s',middlename='%s',lastname='%s',callname='%s',sex='%s',date_of_birth='%s',place_of_birth='%s',nationality='%s',residence_permit='%s',expiration_date='%s', religion='%s',language='%s',username='%s',password='%s',email='%s',lives_with='%s',general='%s',free_field1='%s',free_field2='%s',entry_language='%s',entry_math='%s',entry_general='%s',comes_from='%s',profile='%s',went_to='%s',reason_out='%s',vaccination_card='%s',medical_problems='%s',medication='%s',doctor_ref='%d',father_ref='%d',mother_ref='%d',guardian_ref='%d' where $table_student.student_ref='%d'";                               



$update_school_Stmt = "Update $table_school_student set school_in='%s',
school_out='%s' where $table_school_student.school_ref='%d'";
 
$update_department_Stmt = "Update $table_department_student set department_in='%s',
department_out='%s' where $table_department_student.department_ref='%d'";

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


// Execute the Statement
if (!($result_new_student= mysql_query(sprintf($new_student_Stmt,$new_student_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$new = mysql_fetch_object($result_new_student);

$student_picture=$new->picture;
$student_department=$new->department;
$student_class=$new->class;
$grade=$new->grade;
$v=$new->v;
$class_ref=$new->class_ref; 

$student_firstname=$new->student_firstname;
$student_middlename=$new->student_middlename;
$student_lastname=$new->student_lastname;
$student_callname=$new->student_callname;
$student_sex=$new->student_sex;
$student_date_of_birth=$new->student_date_of_birth;
$student_place_of_birth=$new->student_place_of_birth;
$student_nationality=$new->student_nationality;
$student_residence_permit=$new->student_residence_permit;
$student_expiration_date=$new->student_expiration_date;
$student_religion=$new->student_religion;
$student_language=$new->student_language;
$student_username=$new->student_username;
$student_password=$new->student_password;
$student_email=$new->student_email;
$student_lives_with=$new->student_lives_with;
$student_general=$new->student_general;
$student_to_school=$new->student_to_school;
$student_from_school=$new->student_from_school;
$student_free_field1=$new->student_free_field1; 
$student_free_field2=$new->student_free_field2; 

$registration_entry_language=$new->registration_entry_language; 
$registration_entry_math=$new->registration_entry_math; 
$registration_entry_general=$new->registration_entry_general; 
$registration_comes_from=$new->registration_comes_from; 
$registration_profile=$new->registration_profile; 
$registration_went_to=$new->registration_went_to; 
$registration_reason_out=$new->registration_reason_out; 
$registration_school_in=$new->registration_school_in;
$registration_school_out=$new->registration_school_out;
$registration_department_in=$new->registration_department_in;
$registration_department_out=$new->registration_department_out;

$medical_vaccination_card=$new->medical_vaccination_card; 
$medical_problems=addslashes($new->medical_problems); 
$medical_medication=addslashes($new->medical_medication);

$doctor_ref=$new->doctor_ref;
$father_ref=$new->father_ref;
$mother_ref=$new->mother_ref;
$guardian_ref=$new->guardian_ref;

mysql_free_result($result_new_student);

//delete new student
if (!(mysql_query(sprintf($delStmt_new_student,$new_student_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//get student_ref, school_ref, department_ref
if (!($result_student= mysql_query(sprintf($select_student_Stmt,$class_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_student = mysql_fetch_object($result_student);
$student_ref=$field_student->student_ref;
$school_ref=$field_student->school_ref;
$department_ref=$field_student->department_ref;

mysql_free_result($result_student);  

//verify on excisting student
//all items for any student number

if (!($result_student=mysql_query(sprintf($selectStmt_student,$student_ref,$school_year,$school,$student_department,$student_class,$student_firstname,$student_lastname),$link))) 
{
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_student)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


//a verification on transfer to the same class should be added in the future
//only a verification on student

$content="";
while (($field_student = mysql_fetch_object($result_student)))
{
   $content.=sprintf("<tr><td class=\"table_data\">Two students with the same name for the same class are not allowed!</td></tr>");  
}
mysql_free_result($result_student);  

if ($content) //student already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->assign("message","Use transfer or move from the above mentioned classes");
  $data->display("student_excist.tpl");
 
printf("
<table>
   <tr>
     <td>
       <a href=\"show_students.php?department=%s&class=%s&school_year=%s&grade=%s&v=%s&school=%s&t=%d\">Repeat new Student</a>  </td>
   </tr>
</table>",$student_department,$student_class,$school_year,$grade,$v,$school,time());
  exit();
}



if (!($content)) //new student
{
  
//update student
if (!mysql_query(sprintf($update_student_Stmt,$student_firstname,$student_middlename,$student_lastname,$student_callname,$student_sex,$student_date_of_birth,$student_place_of_birth,$student_nationality,$student_residence_permit,$student_expiration_date,$student_religion,$student_language,$student_username,$student_password,$student_email,$student_lives_with,$student_general,$student_free_field1,$student_free_field2,$registration_entry_language,$registration_entry_math,$registration_entry_general,$registration_comes_from,$registration_profile,$registration_went_to,$registration_reason_out,$medical_vaccination_card,$medical_problems,$medical_medication,$doctor_ref,$father_ref,$mother_ref,$guardian_ref,$student_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//update school
if (!mysql_query(sprintf($update_school_Stmt,$registration_school_in,$registration_school_out,$school_ref),$link)){
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//update department
if (!mysql_query(sprintf($update_department_Stmt,$registration_department_in,$registration_department_out,$department_ref),$link)){
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


//update class
if (!mysql_query(sprintf($update_class_Stmt,$registration_profile,$student_picture,$student_to_school,$student_from_school,$class_ref), $link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

}


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

$executestring.= sprintf("show_students.php?school=$school&school_year=$school_year&department=$student_department&class=$student_class&grade=$grade&v=$v&t=%d",time());
header($executestring);
exit();


?>














