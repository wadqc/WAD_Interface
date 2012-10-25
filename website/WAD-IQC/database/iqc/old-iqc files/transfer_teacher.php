<?php
require("../globals.php");
require("../school_data.php");
require("./common.php");
require("./php/includes/setup.php");
require("./add_teacher_function.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}

if (!empty($_POST['school_t']))
{
  $school_t=$_POST['school_t'];
}
if (!empty($_POST['school_year_t']))
{
  $school_year_t=$_POST['school_year_t'];
}

$table_teacher='teacher';
$table_year='teacher_year';
$table_department='teacher_department';
$table_subject='teacher_subject';


//transfer specific

$teacher_Stmt="SELECT * from $table_year where
$table_year.teacher_ref='%d'";

$year_Stmt = "SELECT * from $table_teacher, $table_year where 
$table_teacher.teacher_ref=$table_year.teacher_ref and
$table_year.year_ref='%d'";

$department_Stmt = "SELECT * from $table_department where 
$table_department.year_ref='%d'";

$department_query = "SELECT * from $table_department where 
$table_department.department='%s' and
$table_department.year_ref='%d'";

$subject_Stmt = "SELECT * from $table_subject where
$table_subject.department_ref='%d'";

$addStmt_department = "Insert into $table_department(department,year_ref)
values ('%s','%d')";

$addStmt_subject = "Insert into $table_subject(subject,department_ref)
values ('%s','%d')";

//delete specific
$del_teacher = "delete from  $table_teacher where 
$table_teacher.teacher_ref='%d'";

$del_subject = "delete from  $table_subject where 
$table_subject.department_ref='%d'";

$del_department = "delete from  $table_department where 
$table_department.year_ref='%d'";

$del_year = "delete from  $table_year where 
$table_year.year_ref='%d'";

$updateStmt_teacher = "Update $table_teacher set
password='%s' where
$table_teacher.teacher_ref='%d'";

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

if ($transfer_action=='transfer')
{
  if (($school_year_t==$school_year)&&($school_t==$school))
  {
    GenerateHTMLHeader("Teachers can not be transfered within the same school and school year");
    ReturnToMain();
    exit();
  }
}

$limit=0;
if (!empty($_POST['teacher']))
{
  $teacher=$_POST['teacher'];
  $year_ref_key=array_keys($teacher);
  $limit=sizeof($year_ref_key);
} 

if (!empty($_GET['teacher']))
{
  $teacher=$_GET['teacher'];
  $year_ref_key=array_keys($teacher);
  $limit=sizeof($year_ref_key);
} 






  
$i=0;
while ($i<$limit) // loop for $year_ref
{
  if (($transfer_action=='transfer')&&($teacher[$year_ref_key[$i]]=='on'))
  {
    if (!($result_year= mysql_query(sprintf($year_Stmt,$year_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    
    $field_year = mysql_fetch_object($result_year); //only one hit
    $teacher_ref=$field_year->teacher_ref;
    mysql_free_result($result_year);

    // create new year
    add_teacher_year($school_year_t,$school_t,$teacher_ref,&$year_ref,&$message); 
          
  } // end transfer action and department=on
  if (($transfer_action=='delete')&&($teacher[$year_ref_key[$i]]=='on'))
  {
    //del subject
    if (!($result_department= mysql_query(sprintf($department_Stmt,$year_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    while($field_department = mysql_fetch_object($result_department))
    {
      if (!(mysql_query(sprintf($del_subject,$field_department->department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
    } 
    mysql_free_result($result_department);
    
    //del department
    if (!(mysql_query(sprintf($del_department,$year_ref_key[$i]), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    
    //determine teacher_ref
    if (!($result_year= mysql_query(sprintf($year_Stmt,$year_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    
    $field_year = mysql_fetch_object($result_year); //only one hit
    $teacher_ref=$field_year->teacher_ref;
    mysql_free_result($result_year); 

    //del teacher_year
    if (!(mysql_query(sprintf($del_year,$year_ref_key[$i]), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$teacher_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $counter=0;
    while($field_teacher = mysql_fetch_object($result_teacher))
    {
      $counter++;
    }
    if ($counter==0) //teacher does not excist for other years, delete teacher as well.
    {
      if (!(mysql_query(sprintf($del_teacher,$teacher_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
    }
  } // end delete action and teacher=on
  
  if (($transfer_action=='reset_pwd')&&($teacher[$year_ref_key[$i]]=='on'))
  {
    //determine teacher_ref
    if (!($result_year= mysql_query(sprintf($year_Stmt,$year_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    
    $field_year = mysql_fetch_object($result_year); //only one hit
    $teacher_ref=$field_year->teacher_ref;
    mysql_free_result($result_year);  
    
    if (!(mysql_query(sprintf($updateStmt_teacher,md5($first_login),$teacher_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  } // end reset action and teacher = on

  $i++;
}// end loop for year_ref



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
header($executestring);
exit();





if ($transfer_action=='delete')
{
  GenerateHTMLHeader("The teachers are deleted succesfully");
}


if ($transfer_action=='transfer')
{
  GenerateHTMLHeader("The teachers are transfered succesfully");
}

if ($transfer_action=='reset_pwd')
{
  GenerateHTMLHeader("The passwords are reset succesfully");
}

ReturnToMain();

?>




