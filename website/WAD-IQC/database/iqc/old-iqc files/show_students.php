<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_teacher='teacher';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$v=$_GET['v'];

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$grade=$_GET['grade'];

$school_t=$_GET['school'];
$school_year_t=$_GET['school_year'];
$department_t=$_GET['department'];
$class_t=$_GET['class'];
$grade_t=$_GET['grade'];

if (!empty($_GET['school_t']))
{
  $school_t=$_GET['school_t'];
}
if (!empty($_GET['year_t']))
{
  $school_year_t=$_GET['year_t'];
}
if (!empty($_GET['department_t']))
{
  $department_t=$_GET['department_t'];
}
if (!empty($_GET['class_t']))
{
  $class_t=$_GET['class_t'];
}
if (!empty($_GET['grade_t']))
{
  $grade_t=$_GET['grade_t'];
}


$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';

$class_Stmt="SELECT * from $table_school, $table_year,$table_department, $table_grade, $table_class where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_school.school='$school_t' and
$table_department.department='$department_t' and
$table_year.year='$school_year_t' and 
$table_grade.grade = '%d'
order by $table_class.number"; 

$grade_Stmt="SELECT * from $table_school, $table_year,$table_department, $table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_school.school='$school_t' and
$table_department.department='$department_t' and
$table_year.year='$school_year_t' 
order by $table_grade.grade desc"; 

$department_Stmt="SELECT * from $table_school, $table_year,$table_department where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='$school_t' and
$table_year.year='$school_year_t' 
order by $table_department.number"; 

$year_Stmt="SELECT * from $table_school, $table_year where
$table_school.school_ref=$table_year.school_ref and
$table_school.school='$school_t' 
order by $table_year.year"; 

$school_Stmt = "SELECT * from $table_school 
order by $table_school.school";





//admin, management, attendance, secretary 
if ( (!empty($user_level_1)) || (!empty($user_level_2)) || (!empty($user_level_3)) || (!empty($user_level_5)) )
{
  $student_Stmt = "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student where 
  $table_class_student.year='$school_year' and
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.class='$class' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref
  order by $table_student.lastname, $table_student.firstname";

  $next_Stmt= "SELECT * from $table_student, $table_school_student, 
  $table_department_student, $table_class_student where 
  $table_student.student_ref='%s' and
  $table_class_student.year='%s' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref
  order by $table_student.lastname, $table_student.firstname";

}
  $teacher_Stmt = "SELECT * from $table_teacher
  where $table_teacher.login = '$user'";


//teacher
if ( (!empty($user_level_4)) )   
{
  
  $student_Stmt = "SELECT * from $table_student, $table_school_student,
  $table_department_student, $table_class_student, $table_subjects where 
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref and
  $table_class_student.class_ref=$table_subjects.class_ref and
  $table_class_student.year='$school_year' and
  $table_school_student.school='$school' and
  $table_department_student.department='$department' and 
  $table_class_student.class='$class' and
  ($table_subjects.teacher='%s' or $table_class_student.mentor='%s') 
  order by $table_student.lastname, $table_student.firstname";
}


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




$list_class='';
$list_grade='';
$list_year='';
$list_department='';
$list_school='';



if (!($result_grade= mysql_query($grade_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $grade_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

while($field = mysql_fetch_object($result_grade))
{
  $list_grade["$field->grade"]="$field->grade";
  $first_grade=$field->grade;
} 
mysql_free_result($result_grade);

$grade_id=$grade_t;
if (!(in_array ($grade_t,$list_grade)))
{
  $grade_id=$first_grade;
}

if (!($result_class= mysql_query(sprintf($class_Stmt,$grade_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
while($field = mysql_fetch_object($result_class))
{
  $list_class["$field->class"]="$field->class";
} 
mysql_free_result($result_class);








if (!($result_year= mysql_query($year_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
while($field = mysql_fetch_object($result_year))
{
  $list_year["$field->year"]="$field->year";
} 
mysql_free_result($result_year);

if (!($result_department= mysql_query($department_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
while($field = mysql_fetch_object($result_department))
{
  $list_department["$field->department"]="$field->department";
} 
mysql_free_result($result_department);

if (!($result_school= mysql_query($school_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
while($field = mysql_fetch_object($result_school))
{
  $list_school["$field->school"]="$field->school";
} 
mysql_free_result($result_school);

$start_year=substr($school_year,0,4);
$stop_year=substr($school_year,5,4);

$start_year=sprintf("%d",$start_year);
$stop_year=sprintf("%d",$stop_year);


$next_year=sprintf("%d-%d",$start_year+1,$stop_year+1);
 

   if (!($result_teacher= mysql_query($teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
   $field = mysql_fetch_object($result_teacher);
   $initials=$field->initials;

   mysql_free_result($result_teacher);

//teacher and attendance
if ( (!empty($user_level_3)) || (!empty($user_level_4)) )    
{   
   if (!($result_student= mysql_query(sprintf($student_Stmt,$initials,$initials), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
}
//admin, management, attendance, secretary 
if ( (!empty($user_level_1)) || (!empty($user_level_2)) || (!empty($user_level_3)) || (!empty($user_level_5)) )
{
   if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
}

//new october 2007
$update_student_class_Stmt = "Update $table_class_student set grade='%s'where $table_class_student.class_ref='%d'";


$student_table="";
if (!empty($user_level_1)) //admin
{ 
  $data = new Smarty_NM();
  $student_table=$data->fetch("student_select_header.tpl");
}  

if (empty($user_level_1))
{ 
  $data = new Smarty_NM();
  $student_table=$data->fetch("student_select_teacher_header.tpl");
}  

$previous_id='';
 
$male_students=0;
$female_students=0;

$j=0;
while (($field_student = mysql_fetch_object($result_student)))
{
  //new october 2007
   
  if (!mysql_query(sprintf($update_student_class_Stmt,$grade,$field_student->class_ref),$link))
  {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $update_student_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  } 

  //end new 


 if ($previous_id!=$field_student->student_ref)
 {
   
   $b=($j%2);
   $bgcolor='';
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }
   //convert date into txt format
   $student_day = substr($field_student->date_of_birth,8,2); 
   $student_month  = substr($field_student->date_of_birth,5,2); 
   $student_year = substr($field_student->date_of_birth,0,4);
   $student_month_text=date ("M",mktime(0,0,0,$student_month,$student_day,$student_year)); 
   $student_date_text=sprintf("%s-%s-%s",$student_month_text,$student_day,$student_year); 
   if ($field_student->date_of_birth=='0000-00-00')
   {
     $student_date_text=sprintf("MM-DD-YYYY");
   }
   //determine phone numbers from parents
   $home_phone='';
   $cell_phone='';

   if ($field_student->lives_with!='')
   {  
     if ($field_student->lives_with=='Father')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Mother')
     {
       $table_parents='mother';
       $parent_student_link="$table_parents.mother_ref=$table_student.mother_ref";
       $student_link="$table_student.mother_ref"; 
       $student_link_ref=$field_student->mother_ref; 
     } 
     if ($field_student->lives_with=='Father & Mother')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Guardian')
     {
       $table_parents='guardian';
       $parent_student_link="$table_parents.guardian_ref=$table_student.guardian_ref";
       $student_link="$table_student.guardian_ref"; 
       $student_link_ref=$field_student->guardian_ref; 
     } 

     $parents_Stmt = "SELECT * from $table_student, $table_parents where $parent_student_link and $student_link='%d'";
     if (!($result_parents= mysql_query(sprintf($parents_Stmt,$student_link_ref), $link)))
     {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     $field_parents = mysql_fetch_object($result_parents);
     $home_phone=$field_parents->home_phone;
     mysql_free_result($result_parents);

     //get cell phone from mother
     $table_parents='mother';
     $parent_student_link="$table_parents.mother_ref=$table_student.mother_ref";
     $student_link="$table_student.mother_ref"; 
     $student_link_ref=$field_student->mother_ref; 

     $parents_Stmt = "SELECT * from $table_student, $table_parents where $parent_student_link and $student_link='%d'";
     if (!($result_parents= mysql_query(sprintf($parents_Stmt,$student_link_ref), $link)))
     {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     $field_parents = mysql_fetch_object($result_parents);
     $cell_phone=$field_parents->cell_phone;
     mysql_free_result($result_parents);


   }    

   // end determine phone numbers

   $web_lock='open';
   if ($field_student->web_lock=='on')
   {
     $web_lock='locked';
   }   


   if (!empty($user_level_1))  //admin
   { 
     if (!($result_next= mysql_query(sprintf($next_Stmt,$field_student->student_ref,$next_year), $link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     $next_content='';
     while (($field_next = mysql_fetch_object($result_next)))
     {
       $next_content=sprintf("-->%s %s %s:%s",$field_next->year,$field_next->school,$field_next->department,$field_next->class);
     } 
     mysql_free_result($result_next);
     $data = new Smarty_NM();
     $p=0;
     $action_name=sprintf("view_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
     $print_action_name=sprintf("print_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
     $report_action_name=sprintf("report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&p=$p&school=%s&class_ref=%s&t=%d",$grade,$department,$class,$school_year,401,$school,$field_student->class_ref,time());


     if ($next_content=='')
     {
       $checkbox_name=sprintf("student[%s]",$field_student->class_ref);  
       $data->assign("bgcolor",$bgcolor);
       $data->assign("checkbox_name",$checkbox_name);
       $data->assign("web_lock",$web_lock);
       $data->assign("action",$action_name);
       $data->assign("action_print",$print_action_name);
       $data->assign("action_report",$report_action_name);
       $data->assign("student_fname",$field_student->firstname);
       $data->assign("student_lname",$field_student->lastname);
       $data->assign("student_date_of_birth",$student_date_text);
       $data->assign("student_gender",$field_student->sex);
       $data->assign("student_home_phone",$home_phone);
       $data->assign("student_cell_phone",$cell_phone);
       $data->assign("print_image_name",sprintf("print_image_%d",$j));
       $data->assign("report_image_name",sprintf("report_image_%d",$j));
       
       $student_table.=$data->fetch("student_select_row.tpl");
     }
     if ($next_content!='')
     {
       $data->assign("bgcolor",$bgcolor);
       $data->assign("next",$next_content); 
       $data->assign("web_lock",$web_lock);
       $data->assign("action",$action_name);
       $data->assign("action_print",$print_action_name);
       $data->assign("action_report",$report_action_name);
       $data->assign("student_fname",$field_student->firstname);
       $data->assign("student_lname",$field_student->lastname);
       $data->assign("student_date_of_birth",$student_date_text);
       $data->assign("student_gender",$field_student->sex);
       $data->assign("student_home_phone",$home_phone);
       $data->assign("student_cell_phone",$cell_phone);
       $data->assign("print_image_name",sprintf("print_image_%d",$j));
       $data->assign("report_image_name",sprintf("report_image_%d",$j));

       $student_table.=$data->fetch("student_select_next_row.tpl");
     }
   } //end admin

   if (empty($user_level_1))
   { 
     $p=0;
     if ( ($field_student->mentor!=$initials) && ( (!empty($user_level_3)) || (!empty($user_level_4))) ) 
     {
       // not a mentor and (teacher or attendance)
       $p=1;
     }

     $action_name=sprintf("view_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
     $print_action_name=sprintf("print_student.php?class_ref=%d&father_ref=%d&mother_ref=%d&guardian_ref=%d&department=%s&class=%s&school_year=%s&grade=%s&v=%s&p=$p&school=%s&t=%d",$field_student->class_ref,$field_student->father_ref,$field_student->mother_ref,$field_student->guardian_ref,$department,$class,$school_year,$grade,$v,$school,time());
     $report_action_name=sprintf("report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&p=$p&school=%s&class_ref=%s&t=%d",$grade,$department,$class,$school_year,401,$school,$field_student->class_ref,time());

     $data = new Smarty_NM();
     $data->assign("bgcolor",$bgcolor);
     $data->assign("student_number",$field_student->number);
     $data->assign("action",$action_name);
     $data->assign("action_print",$print_action_name);
     $data->assign("action_report",$report_action_name);
     $data->assign("student_fname",$field_student->firstname);
     $data->assign("student_lname",$field_student->lastname);
     $data->assign("student_date_of_birth",$student_date_text);
     $data->assign("student_gender",$field_student->sex);
     $data->assign("student_home_phone",$home_phone);
     $data->assign("student_cell_phone",$cell_phone);
     $data->assign("print_image_name",sprintf("print_image_%d",$j));
     $data->assign("report_image_name",sprintf("report_image_%d",$j));
     
     $student_table.=$data->fetch("student_select_teacher_row.tpl");
   }
   switch($field_student->sex)
   {
     case 'm': $male_students++;
               break;
     case 'f': $female_students++;
               break; 
   }
   $previous_id=$field_student->student_ref;
   $j++;
 }  
}

mysql_free_result($result_student);  

$data = new Smarty_NM();

$data->assign("year_options",$list_year);
$data->assign("school_options",$list_school);
$data->assign("class_options",$list_class);
$data->assign("department_options",$list_department);
$data->assign("grade_options",$list_grade);
$data->assign("year_id",$school_year_t);
$data->assign("school_id",$school_t);
$data->assign("class_id",$class_t);
$data->assign("department_id",$department_t);
$data->assign("grade_id",$grade_id);




$data->assign("header",sprintf("School year %s Department %s Class %s",$school_year,$department,$class));
$data->assign("header_statistics",sprintf("Number of Students %d (%dm %df)",($male_students+$female_students),$male_students,$female_students));
$data->assign("student_thumbs_action",sprintf("show_student_thumbnails.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s",$grade,$department,$class,$school_year,$v,$school) );
$data->assign("student_list",$student_table);

if (!empty($user_level_1))  //admin
{
  $form_action=sprintf("transfer_student.php?school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&v=$v&t=%d",time());
  $data->assign("form_action",$form_action);
  $new_student=sprintf("<a
  href=\"new_student.php?department=%s&class=%s&school_year=%s&grade=%s&v=%s&school=%s&class_ref=-1&father_ref=0&mother_ref=0&guardian_ref=0&t=%d\">Add new Student</a>",$department,$class,$school_year,$grade,$v,$school,time());

  $data->assign("school",$school);
  $data->assign("school_year",$school_year);
  $data->assign("department",$department);
  $data->assign("class",$class);
  $data->assign("grade",$grade);
  $data->assign("v",$v);

  $data->assign("new_student",$new_student);
  $data->display("student_select.tpl");
} 
if (empty($user_level_1))
{  
  $data->display("student_select_teacher.tpl");
}



?>