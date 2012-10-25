<?
  
function delete_student($class_ref)
{  

require("../globals.php");

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



//delete definition

$student_Stmt = "SELECT * from $table_student, $table_school_student,
$table_department_student, $table_class_student where 
$table_class_student.class_ref='%d' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref";


$class_Stmt = "SELECT * from $table_department_student, $table_class_student where 
$table_department_student.department_ref=$table_class_student.department_ref
and $table_department_student.department_ref='%d'";

$department_Stmt = "SELECT * from $table_school_student, $table_department_student where
$table_school_student.school_ref=$table_department_student.school_ref and
$table_school_student.school_ref='%d'";

$school_Stmt = "SELECT * from $table_student,$table_school_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_student.student_ref='%d'";



//$school_Stmt = "SELECT * from $table_year_student,$table_school_student where 
//$table_year_student.year_ref=$table_school_student.year_ref and
//$table_year_student.year_ref='%d'";


//$year_Stmt = "SELECT * from $table_student, $table_year_student where 
//$table_student.student_ref=$table_year_student.student_ref and
//$table_student.student_ref='%d'";


$del_student = "delete from  $table_student where 
$table_student.student_ref='%d'";

//$del_year = "delete from $table_year_student where 
//$table_year_student.year_ref='%d'";

$del_school = "delete from  $table_school_student where 
$table_school_student.school_ref='%d'";

$del_department = "delete from $table_department_student where 
$table_department_student.department_ref='%d'";

$del_class = "delete from $table_class_student where 
$table_class_student.class_ref='%d'";

$query_subject_Stmt="SELECT * from $table_subjects where 
$table_subjects.class_ref='%d'";

$del_presention_general = "delete from $table_presention_general where 
$table_presention_general.class_ref='%d'";

$del_subjects = "delete from $table_subjects where 
$table_subjects.class_ref='%d'";

$del_category = "delete from $table_category where 
$table_category.subjects_ref='%d'";

$del_exam_marks = "delete from $table_exam where 
$table_exam.subjects_ref='%d'";

$del_marks = "delete from $table_marks where 
$table_marks.subjects_ref='%d'";

$del_presention_subject = "delete from $table_presention_subject where 
$table_presention_subject.subjects_ref='%d'";


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


    // by default delete everything except table_department 
    
    //query on subjects
    if (!($result_subject=mysql_query(sprintf($query_subject_Stmt,$class_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $query_subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete all subjects_ref related tables
    while ($subject_field = mysql_fetch_object($result_subject))
    {
      // delete category
      if (!(mysql_query(sprintf($del_category,$subject_field->subjects_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

      // delete exam marks
      if (!(mysql_query(sprintf($del_exam_marks,$subject_field->subjects_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_exam_marks)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

      // delete marks
      if (!(mysql_query(sprintf($del_marks,$subject_field->subjects_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_marks)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
       
      // delete presention subject
      if (!(mysql_query(sprintf($del_presention_subject,$subject_field->subjects_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_presention_subject)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

    } 
    
    // delete all class_ref related tables 

    // delete presention_general
    if (!(mysql_query(sprintf($del_presention_general,$class_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_presention_general)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
          
    // delete subjects
    if (!(mysql_query(sprintf($del_subjects,$class_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_subjects)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete class
    if (!(mysql_query(sprintf($del_class,$class_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_klas)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    

    //check on other classes
    if (!($result_class= mysql_query(sprintf($class_Stmt,$student_field->department_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $j=0;
    while ($class = mysql_fetch_object($result_class))
    {
      $j++;
    }
    mysql_free_result($result_class);
    
    // j=0 no more classes; delete department    
    if ($j==0)
    {
       // delete department
      if (!(mysql_query(sprintf($del_department,$student_field->department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_klas)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
      
      //check on other departments
      if (!($result_department= mysql_query(sprintf($department_Stmt,$student_field->school_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $j=0;
      while ($department = mysql_fetch_object($result_department))
      {
        $j++;
      }
      mysql_free_result($result_department);
    
      // j=0 no more departments; delete school    
      if ($j==0)
      {
        // delete school
        if (!($result_class= mysql_query(sprintf($del_school,$student_field->school_ref), $link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $del_klas)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;}
      
        //check on other schools
        if (!($result_school= mysql_query(sprintf($school_Stmt,$student_field->student_ref),$link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
        }
        $j=0;
        while ($school = mysql_fetch_object($result_school))
        {
          $j++;
        }
        mysql_free_result($result_school);
    
        // j=0 no more schools; delete year    
        //if ($j==0)
        //{
          //// delete year
          //if (!($result_class= mysql_query(sprintf($del_year,$student_field->year_ref), $link))) {
          //DisplayErrMsg(sprintf("Error in executing %s stmt", $del_klas)) ;
          //DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          //exit() ;}

          ////check on other years
          //if (!($result_year= mysql_query(sprintf($year_Stmt,$student_field->student_ref),$link))) {
          //DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
          //DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          //exit() ;
          //}
          //$j=0;
          //while ($year = mysql_fetch_object($result_year))
          //{
            //$j++;
          //}
          //mysql_free_result($result_year);
    
          //// j=0 no more years; delete student    
          
          // j=0 no more schools; delete student 
          if ($j==0)
          {
            //delete student 
            if (!($result_stud= mysql_query(sprintf($del_student,$student_field->student_ref), $link))) {
            DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
            DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
            exit() ;}
          } //del student
        //} //del year
      } //del school
    } //del department
  
    mysql_free_result($result_student);

}// end of function
   
?>