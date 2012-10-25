<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_school='school';
$table_department='department';
$table_year='year';

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$number=$_POST['number'];
$department=$_POST['department'];


$selectStmt_department = "Select * from $table_school, $table_year, $table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_department.department='%s'
order by $table_year.year";

$queryStmt_school = "Select * from $table_school where 
$table_school.school='%s'";

$queryStmt_year = "Select * from $table_school,$table_year where 
$table_school.school_ref=$table_year.school_ref and
$table_school.school_ref ='%d' and
$table_school.school='%s' and
$table_year.year='%s'";

$addStmt_year = "Insert into $table_year(year,school_ref)
values ('%s','%d')";

$addStmt_school = "Insert into $table_school(school)
values ('%s')";

$addStmt_department = "Insert into $table_department(department,number,year_ref)
values ('%s','%d','%d')";


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

printf($selectStmt_department,$school,$school_year,$department);

if (!($result_department= mysql_query(sprintf($selectStmt_department,$school,$school_year,$department), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$content="";
while (($field_department = mysql_fetch_object($result_department)))
{
   $content.=sprintf("<tr><td class=\"table_data\">department %s already
   excists for school %s at year %s</td></tr>",$field_department->department,$field_department->school,$field_department->year);  
}
mysql_free_result($result_department);  

if ($content!="") //department already excists
{
  $data = new Smarty_NM();
  $data->assign("content",$content);
  $data->display("department_excist.tpl");
}

if (!($content)) //new department
{
  //query for excisting school or create school if not excists

  if (!($result_school=mysql_query(sprintf($queryStmt_school,$school),$link))){
  DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }

  $school_ref=-1; //verify whether or not the school excists
  while($field_school = mysql_fetch_object($result_school))
  {
     $school_ref=$field_school->school_ref;
  }
  mysql_free_result($result_school);

  if ($school_ref==-1) //year not available, create new year
  {
    if (!(mysql_query(sprintf($addStmt_school,$school),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }

    if (!($result_school=mysql_query(sprintf($queryStmt_school,$school),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }
 
    $field_school = mysql_fetch_object($result_school);
    $school_ref=$field_school->school_ref;
    mysql_free_result($result_school);
  }
  // school defined

  //query for excisting year or create year if not excists
  
  printf($queryStmt_year,$school_ref,$school,$school_year);
  
  if (!($result_year=mysql_query(sprintf($queryStmt_year,$school_ref,$school,$school_year),$link))){
  DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }

  $year_ref=-1; //verify whether or not the year excists
  while($field_year = mysql_fetch_object($result_year))
  {
     $year_ref=$field_year->year_ref;
  }
  mysql_free_result($result_year);

  if ($year_ref==-1) //year not available, create new year
  {
    printf($addStmt_year,$school_year,$school_ref);
    if (!(mysql_query(sprintf($addStmt_year,$school_year,$school_ref),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }

    if (!($result_year=mysql_query(sprintf($queryStmt_year,$school_ref,$school,$school_year),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }
 
    $field_year = mysql_fetch_object($result_year);
    $year_ref=$field_year->year_ref;
    mysql_free_result($result_year);
  }
  // year defined

  if(!mysql_query(sprintf($addStmt_department,$department,$number,$year_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  GenerateHTMLHeader("The entry was added succesfully");
}

ReturnToMain();
printf("
<table>
   <tr>
      <td><a href=\"create_departments.php?school=$school$school_year=$school_year&t=%d\">Repeat new Department</a>  </td>
    </tr>
</table>",time());

?>





