<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$v=$_GET['v'];




if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

//class_ref specific
$table_subjects='subjects';
$table_presention_general='presention_general';

//subjects_ref specific
$table_category='category';
$table_exam='exam_marks';
$table_marks='marks';
$table_presention_subject='presention_subject';


//transfer definition

$selectStmt_student = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.class_ref='%d' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref";

$verify_student_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_student.student_ref!='%d' and
$table_student.firstname='%s' and
$table_student.lastname='%s' and
$table_class_student.year='%s' and
$table_school_student.school='%s' and
$table_department_student.department='%s' and
$table_class_student.class='%s' and
$table_class_student.grade='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref";


$verify_class_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_student.student_ref='%d' and
$table_class_student.year='%s' and
$table_school_student.school='%s' and
$table_department_student.department='%s' and
$table_class_student.class='%s' and
$table_class_student.grade='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref";



$verify_department_Stmt = "SELECT * from $table_student,
$table_school_student, $table_department_student where 
$table_student.student_ref='%d' and
$table_school_student.school='%s' and
$table_department_student.department='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref";

$verify_school_Stmt = "SELECT * from $table_student, $table_school_student where 
$table_student.student_ref='%d' and
$table_school_student.school='%s' and
$table_student.student_ref=$table_school_student.student_ref";


//other
$student_all = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_class_student.grade='$grade' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";


$queryStmt_subject_ref = "select * from $table_subjects where
$table_subjects.subject = '%s' and
$table_subjects.teacher = '%s' and
$table_subjects.cluster = '%s' and
$table_subjects.class_ref= '%d'";


$queryStmt_subject = "select * from $table_subjects where
$table_subjects.class_ref='%d' ";

$add_Stmt_subject = "Insert into $table_subjects(subject,teacher,cluster,class_ref) values ('%s','%s','%s','%d')";

$queryStmt_exam = "select * from $table_exam where
$table_exam.subjects_ref='%d'";

$add_Stmt_exam = "Insert into $table_exam(description,date,mark,mark_r,weigth,report,average,subjects_ref)
values ('%s','%s','%s','%s','%s','%s','%d','%d')";

$update_Stmt_department = "Update $table_department_student set
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


$limit=0;
if (!empty($_POST['student']))
{
  $student=$_POST['student'];
  $class_ref_key=array_keys($student);
  $limit=sizeof($class_ref_key);
} 

if (!empty($_GET['student']))
{
  $student=$_GET['student'];
  $class_ref_key=array_keys($student);
  $limit=sizeof($class_ref_key);
} 


$message='';


$i=0;

$current_date=sprintf("%s",date("Y-m-d",time()));
$zero_date=sprintf("0000-00-00");

while ($i<$limit) // loop for $class_ref
{

  //transfer
  if (($student[$class_ref_key[$i]]=='on')&&($transfer_action=='transfer'))
  {

   if (empty($_POST['year_t']))
   {
     printf("Students can only be transfered if a year is selected");
     exit();
   }
   if (empty($_POST['school_t']))
   {
     printf("Students can only be transfered if a school is selected");
     exit();
   }
   if (empty($_POST['department_t']))
   {
     printf("Students can only be transfered if a department is selected");
     exit();
   }
   if (empty($_POST['grade_t']))
   {
     printf("Students can only be transfered if a grade is selected");
     exit();
   }
   if (empty($_POST['class_t']))
   {
     printf("Students can only be transfered if a class is selected");
     exit();
   }   

   
    //select old class values
    if (!($result_student= mysql_query(sprintf($selectStmt_student,$class_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_student)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $student_field = mysql_fetch_object($result_student);
    
    $current_department_ref=$student_field->department_ref;   

    // verify if this student already excists for this class
    if (!($result_class= mysql_query(sprintf($verify_class_Stmt,$student_field->student_ref,$year_t,$school_t,$department_t,$class_t,$grade_t),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $class_counter=0;
    while ($class_search = mysql_fetch_object($result_class))
    {
      $class_counter++;
    }
    mysql_free_result($result_class);
    
    if ($class_counter>0) //Same student already at class
    {
      if ($message=='')
      {
        $message=sprintf("<table>");
      } 
      $message.=sprintf("<tr><td>Student with firstname %s and lastname %s does already excists for class %s </td></tr>",$student_field->firstname,$student_field->lastname,$class_t);
    }
    
    //verify if a student with same name excists for this class
    if (!($result_class= mysql_query(sprintf($verify_student_Stmt,$student_field->student_ref,$student_field->firstname,$student_field->lastname,$year_t,$school_t,$department_t,$class_t,$grade_t),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $name_counter=0;
    while ($class_search = mysql_fetch_object($result_class))
    {
      $name_counter++;
    }
    mysql_free_result($result_class);
    if ($name_counter>0) //Another student with same first and last name at class
    {
      if ($message=='')
      {
        $message=sprintf("<table>");
      } 
      $message.=sprintf("<tr><td>There's already a student with firstname %s and lastname %s for class %s </td></tr>",$student_field->firstname,$student_field->lastname,$class_t);
    }
    

    if ( ($class_counter==0)&&($name_counter==0) )
    {
     
      // verify if department excists  
      if (!($result_department= mysql_query(sprintf($verify_department_Stmt,$student_field->student_ref,$school_t,$department_t),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
   
     $department_counter=0;
      while ($department_search = mysql_fetch_object($result_department))
      {
        $department_counter++;
        $student_department_ref=$department_search->department_ref;
      }
      mysql_free_result($result_department);
      if ($department_counter>0) // same department; different class
      {
        //add new class
        //add_student_class($class_t,$student_field->profile,$student_field->picture,$student_field->department_ref,&$class_ref_transfer);
        //add_student_class($grade_t,$class_t,$year_t,$student_field->profile,$student_field->picture,$student_field->transportation_to_school,$student_field->transportation_from_school,$student_field->department_ref,&$class_ref_t);
        add_student_class($grade_t,$class_t,$year_t,$student_field->profile,$student_field->picture,$student_field->transportation_to_school,$student_field->transportation_from_school,$student_department_ref,&$class_ref_t);
      }
      if ($department_counter==0)
      {
        // verify if school excists  
        if (!($result_school= mysql_query(sprintf($verify_school_Stmt,$student_field->student_ref,$school_t),$link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
        }
        $school_counter=0;
        while ($school_search = mysql_fetch_object($result_school))
        {
          $school_counter++;
        }
        mysql_free_result($result_school);
                
        if ($school_counter>0) // same school; different department, different class
        {
          //update current department
          if (!($result_department=
          mysql_query(sprintf($update_Stmt_department,$current_date,$current_department_ref),$link)))
          {
            DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
            DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
            exit() ;
          }
          //add new department
          add_student_department($department_t,$current_date,$zero_date,$student_field->school_ref,&$department_ref);
          add_student_class($grade_t,$class_t,$year_t,$student_field->profile,$student_field->picture,$student_field->transportation_to_school,$student_field->transportation_from_school,$department_ref,&$class_ref_t);
        }
        if ($school_counter==0) //different school, different department, different class
        {
          //add new school
          add_student_school($school_t,$student_field->student_ref,&$school_ref);
          add_student_department($department_t,$current_date,$zero_date,$school_ref,&$department_ref);
          add_student_class($grade_t,$class_t,$year_t,$student_field->profile,$student_field->picture,$student_field->transportation_to_school,$student_field->transportation_from_school,$department_ref,&$class_ref_t);
        } // end school_counter
      } // end department_counter
    } // end class_counter and name_counter

    //copy old class values into new class    

    //class_ref_t is the new class_ref
    
    if ($year_t==$student_field->year)
    {
      // voor transfer binnen school jaar.
      // verwijder huidige tree en copieer alles naar nieuwe class_ref_t
      // neem de voldoende resultaten van de examenwerken over
    }
    
    // query the old subject table
    if (!($result_subject= mysql_query(sprintf($queryStmt_subject,$class_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_subject_exam)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    //$specific_subject="";
    while ($field_subject=mysql_fetch_object($result_subject))
    {
      // query the old exam table
      if (!($result_exam= mysql_query(sprintf($queryStmt_exam,$field_subject->subjects_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_subject_exam)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $exam_counter=0;
      while ($field_exam=mysql_fetch_object($result_exam))
      {
        if ($exam_counter==0)
        {
          // copy old subject into new field for class_ref
          if (!(mysql_query(sprintf($add_Stmt_subject,$field_subject->subject,$field_subject->teacher,$field_subject->cluster,$class_ref_t),$link))) {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $add_Stmt_subject)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
          }
      
          // trace the new subjects_ref
      
          if (!($result_query_subject= mysql_query(sprintf($queryStmt_subject_ref,$field_subject->subject,$field_subject->teacher,$field_subject->cluster,$class_ref_t),$link))) {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_klas)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
          }
          $field_query_subject=mysql_fetch_object($result_query_subject);
          $new_subjects_ref=$field_query_subject->subjects_ref;
          mysql_free_result($result_query_subject);
              
          $exam_counter++;
        }

        // copy old exam into new field for new_subjects_ref
        if (!(mysql_query(sprintf($add_Stmt_exam,$field_exam->description,$field_exam->date,$field_exam->mark,$field_exam->mark_r,$field_exam->weigth,$field_exam->report,$field_exam->average,$new_subjects_ref),$link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $add_Stmt_subject)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
        }
      }
      mysql_free_result($result_exam);
    }
    mysql_free_result($result_subject);

    mysql_free_result($result_student);
    
  } //end transfer
  
  //lock
  if (($student[$class_ref_key[$i]]=='on')&&($transfer_action=='lock'))
  {
    lock_student($class_ref_key[$i],'on');
  }
  
  //unlock
  if (($student[$class_ref_key[$i]]=='on')&&($transfer_action=='unlock'))
  {
    lock_student($class_ref_key[$i],'');
  }
  //delete
  if (($student[$class_ref_key[$i]]=='on')&&($transfer_action=='delete'))
  {
    delete_student($class_ref_key[$i]);
  }
  //print
  if (($student[$class_ref_key[$i]]=='on')&&($transfer_action=='print'))
  {
    print_single_student($class_ref_key[$i],$department,$class,$school_year,$grade,$school,1);
  }
  $i++;
}

if ($message!='')
{
  $message.=sprintf("</table>");
  printf($message);
  exit(0);
}


//lock all
if ($transfer_action=='lock all')
{
  if (!($result_student_all= mysql_query($student_all,$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_student)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  while ($field_student_all=mysql_fetch_object($result_student_all))
  {
    lock_student($field_student_all->class_ref,'on');
  }
  mysql_free_result($result_student_all);
}
//unlock all
if ($transfer_action=='unlock all')
{
  if (!($result_student_all= mysql_query($student_all,$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_student)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  while ($field_student_all=mysql_fetch_object($result_student_all))
  {
    lock_student($field_student_all->class_ref,'');
  }
  mysql_free_result($result_student_all);
}

if ($transfer_action!='print')
{
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("show_students.php?school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&v=$v&t=%d",time());
  header($executestring);
  exit();
}






?>

