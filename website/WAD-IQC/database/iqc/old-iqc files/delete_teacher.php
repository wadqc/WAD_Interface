<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$year_ref=$_GET['year_ref'];

//delete definition
$teacher_Stmt = "SELECT * from $table_teacher, $table_teacher_year where 
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and 
$table_teacher_year.year_ref='%d'";

$year_Stmt = "SELECT * from $table_teacher, $table_teacher_year where 
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and 
$table_teacher.teacher_ref='%d'";

$department_Stmt = "SELECT * from $table_teacher_department where 
$table_teacher_department.year_ref='%d'";

$del_year = "delete from $table_teacher_year where 
$table_teacher_year.year_ref='%d'";

$del_teacher_department = "delete from $table_teacher_department where 
$table_teacher_department.year_ref='%d'";

$del_teacher_subject = "delete from $table_teacher_subject where 
$table_teacher_subject.department_ref='%d'";

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




    if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }

    $teacher_field = mysql_fetch_object($result_teacher);

    if (!($result_year= mysql_query(sprintf($year_Stmt,$teacher_field->teacher_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }

    $j=0;
    while ($year = mysql_fetch_object($result_year))
    {
      $j++;
    }
    mysql_free_result($result_year);
    
    if ($j>1) //teacher excists for more than 1 year
    {
      mysql_free_result($result_teacher);
    }
    // by default delete everything except table_teacher 
    
    //delete teacher_subject
    if (!($result_year= mysql_query(sprintf($department_Stmt,$year_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    while ($department = mysql_fetch_object($result_department))
    {
      if (!(mysql_query(sprintf($del_teacher_subject,$department->department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_subjects)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
      
    }
    mysql_free_result($result_department);
            
    // delete teacher_department
    if (!(mysql_query(sprintf($del_teacher_department,$year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_subjects)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete year
    if (!(mysql_query(sprintf($del_year,$year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_klas)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
 

    if ($j==1) //only in this class; delete teacher as well
    {
      //delete teacher 
      if (!(mysql_query(sprintf($del_teacher,$teacher_field->teacher_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
      mysql_free_result($result_teacher);
    }
 
    GenerateHTMLHeader("The entry was removed succesfully");
    ReturnToMain();
?>
