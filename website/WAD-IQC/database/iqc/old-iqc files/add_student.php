<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_student_function.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$new_student_ref=$_GET['new_student_ref'];




$table_new_student='new_student';

$table_student='student';
$table_school='school_student';
$table_department='department_student';
$table_class='class_student';

$new_student_Stmt = "SELECT * from $table_new_student where student_ref='%d'";
$delStmt_new_student = "delete from  $table_new_student where $table_new_student.student_ref='%d'";


$selectStmt_student = "SELECT * from $table_student, $table_school, 
$table_department, $table_class where 
$table_class.year='%s' and
$table_school.school='%s' and
$table_department.department='%s' and 
$table_class.class='%s' and
$table_student.firstname='%s' and
$table_student.lastname='%s' and
$table_student.student_ref=$table_school.student_ref and
$table_school.school_ref=$table_department.school_ref and
$table_department.department_ref=$table_class.department_ref
order by $table_student.lastname, $table_student.firstname";

$updateStmt_student = "Update $table_student set
number='%s'where $table_student.student_ref='%d'";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) 
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) 
{
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_new_student= mysql_query(sprintf($new_student_Stmt,$new_student_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$new = mysql_fetch_object($result_new_student);

$student_number=$new->student_number;

$student_picture=$new->picture;
$student_department=$new->department;
$student_class=$new->class;
$grade=$new->grade;
$v=$new->v;
 
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
$medical_problems=$new->medical_problems; 
$medical_medication=$new->medical_medication;

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





//verify on excisting student
//all items for any student number

if (!($result_student=mysql_query(sprintf($selectStmt_student,$school_year,$school,$student_department,$student_class,$student_firstname,$student_lastname),$link))) 
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
  //add student
  $temp_number=time();
  add_student_student($temp_number,$student_firstname,$student_middlename,$student_lastname,$student_callname,$student_sex,$student_date_of_birth,$student_place_of_birth,$student_nationality,$student_residence_permit,$student_expiration_date,$student_religion,$student_language,$student_username,$student_password,$student_email,$student_lives_with,$student_general,$student_free_field1,$student_free_field2,$registration_entry_language,$registration_entry_math,$registration_entry_general,$registration_comes_from,$registration_profile,$registration_went_to,$registration_reason_out,$medical_vaccination_card,$medical_problems,$medical_medication,$doctor_ref,$father_ref,$mother_ref,$guardian_ref,&$student_ref);


   //add number
   
   $today_year=sprintf("%s",date("y",$temp_number));
   $today_month=sprintf("%d",date("m",$temp_number));
   $today_day=sprintf("%d",date("d",$temp_number));
   $birth_month=substr($student_date_of_birth,5,2);
   $birth_month=sprintf("%d",$birth_month);
   $birth_day=substr($student_date_of_birth,8,2);    
   $birth_day=sprintf("%d",$birth_day);

   $day_mix=$today_day*$birth_day;
   if ($day_mix<100)
   {
     if ($day_mix<10)
     {
       $day_mix=sprintf("0%s",$day_mix);
     }
     $day_mix=sprintf("0%s",$day_mix);
   }
   $month_mix=$today_month*$birth_month;
   if ($month_mix<100)
   {
     if ($month_mix<10)
     {
       $month_mix=sprintf("0%s",$month_mix);
     }
     $month_mix=sprintf("0%s",$month_mix);
   } 

   $ref_string=sprintf("%s",$student_ref);
   $k=strlen($ref_string);
   $missing=$pattern_length-$k;
   $i=0;
   $pattern=$ref_string;
   while($i<$missing)
   {
     $pattern=sprintf("0%s",$pattern);
     $i++;
   }

   $student_number=sprintf("%s%s%s%s",$today_year,$day_mix,$month_mix,$pattern);
   
   // update student, set unique number
   if (!mysql_query(sprintf($updateStmt_student,$student_number,$student_ref),$link)) 
   {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
   } 

     
   //add school 
   add_student_school($school,$registration_school_in,$registration_school_out,$student_ref,&$school_ref);


   //add_department
   add_student_department($student_department,$registration_department_in,$registration_department_out,$school_ref,&$department_ref);

   //add_class
   add_student_class($grade,$student_class,$school_year,$registration_profile,$student_picture,$student_to_school,$student_from_school,$department_ref,&$class_ref);
     
}


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("show_students.php?school=$school&school_year=$school_year&department=$student_department&class=$student_class&grade=$grade&v=$v&t=%d",time());
header($executestring);
exit();






ReturnToMain();
printf("
<table>
   <tr>
      <td><a href=\"show_students.php?department=%s&class=%s&school_year=%s&grade=%s&v=%s&school=%s&t=%d\">Repeat new Student</a>  </td>
    </tr>
</table>",$student_department,$student_class,$student_term,$grade,$v,$school,time());

?>

