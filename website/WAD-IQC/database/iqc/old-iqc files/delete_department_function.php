<?php


function delete_department($department_ref,$year_ref,$school_ref)
{

require("../globals.php") ;
  

$table_school='school';
$table_year='year';
$table_department='department';
$table_term='term';
$table_grade='grade';
$table_class='class';
$table_subject_report='subject_report';
$table_subject_exam='subject_exam';
$table_subject='subject';

//delete specific

$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_department where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref='%d'";

$grade_query_Stmt = "SELECT * from $table_school,$table_year,$table_department,$table_grade where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_department.department_ref='%d'";

$del_subject_exam = "delete from  $table_subject_exam where 
$table_subject_exam.grade_ref='%d'";

$del_subject_report = "delete from  $table_subject_report where 
$table_subject_report.grade_ref='%d'";

$del_class = "delete from  $table_class where 
$table_class.grade_ref='%d'";

$del_grade = "delete from  $table_grade where 
$table_grade.department_ref='%d'";

$del_subject = "delete from  $table_subject where 
$table_subject.department_ref='%d'";

$del_department = "delete from  $table_department where 
$table_department.department_ref='%d'";

$del_term = "delete from  $table_term where 
$table_term.year_ref='%d'";

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


    if (!($result_grade= mysql_query(sprintf($grade_query_Stmt,$department_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    while($field_grade = mysql_fetch_object($result_grade))
    {
      // delete subject_report
      if (!(mysql_query(sprintf($del_subject_report,$field_grade->grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

      // delete subject_exam
      if (!(mysql_query(sprintf($del_subject_exam,$field_grade->grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

      // delete class
      if (!(mysql_query(sprintf($del_class,$field_grade->grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
    }
    mysql_free_result($result_grade);

    if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$department_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_year_verification = mysql_fetch_object($result_year_verification);

    $school_ref= $field_year_verification->school_ref;
    $year_ref= $field_year_verification->year_ref;
   
    mysql_free_result($result_year_verification);
    
    // delete grade
    if (!(mysql_query(sprintf($del_grade,$department_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete subject
    if (!(mysql_query(sprintf($del_subject,$department_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete department
    if (!(mysql_query(sprintf($del_department,$department_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete term
    if (!(mysql_query(sprintf($del_term,$year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  
}

function delete_skill($skill_ref,$year_ref,$school_ref)
{

require("../globals.php") ;
  

$table_school='school';
$table_year='year';
$table_skill='skill';
$table_skill_sub='skill_sub';


//delete specific

$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_skill where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_skill.skill_ref='%d'";

$del_skill_sub = "delete from  $table_skill_sub where 
$table_skill_sub.skill_ref='%d'";

$del_skill = "delete from  $table_skill where 
$table_skill.skill_ref='%d'";

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

    if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$skill_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_year_verification = mysql_fetch_object($result_year_verification);

    $school_ref= $field_year_verification->school_ref;
    $year_ref= $field_year_verification->year_ref;
   
    mysql_free_result($result_year_verification);
    
    // delete skill_sub
    if (!(mysql_query(sprintf($del_skill_sub,$skill_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    // delete skill
    if (!(mysql_query(sprintf($del_skill,$skill_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  
} 


//start delete score
function delete_score($score_ref,$year_ref,$school_ref)
{

require("../globals.php") ;
  

$table_school='school';
$table_year='year';
$table_score='score';

//delete specific

$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_score where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_score.score_ref='%d'";

$del_score = "delete from  $table_score where 
$table_score.score_ref='%d'";

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

    if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$score_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_year_verification = mysql_fetch_object($result_year_verification);

    $school_ref= $field_year_verification->school_ref;
    $year_ref= $field_year_verification->year_ref;
   
    mysql_free_result($result_year_verification);
    
    // delete score
    if (!(mysql_query(sprintf($del_score,$score_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  
} 


function delete_year($year_ref,$school_ref) 
{
require("../globals.php") ;
  

$table_school='school';
$table_year='year';
$table_department='department';
$table_skill='skill';
$table_score='score';


//delete specific

$department_query_Stmt = "SELECT * from $table_year, $table_department where 
$table_year.year_ref=$table_department.year_ref and
$table_year.year_ref='%d'";

$skill_query_Stmt = "SELECT * from $table_year, $table_skill where 
$table_year.year_ref=$table_skill.year_ref and
$table_year.year_ref='%d'";

$score_query_Stmt = "SELECT * from $table_year, $table_score where 
$table_year.year_ref=$table_score.year_ref and
$table_year.year_ref='%d'";

$year_query_Stmt = "SELECT * from $table_school, $table_year where 
$table_school.school_ref=$table_year.school_ref and
$table_school.school_ref='%d'";


$del_year = "delete from  $table_year where 
$table_year.year_ref='%d'";

$del_school = "delete from  $table_school where 
$table_school.school_ref='%d'";

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

if (!($result_department= mysql_query(sprintf($department_query_Stmt,$year_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_skill= mysql_query(sprintf($skill_query_Stmt,$year_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_score= mysql_query(sprintf($score_query_Stmt,$year_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$counter=0; 

while($field_department = mysql_fetch_object($result_department))
{
  $counter++;
}
mysql_free_result($result_department);

while($field_skill = mysql_fetch_object($result_skill))
{
  $counter++;
}

while($field_score = mysql_fetch_object($result_score))
{
  $counter++;
}
mysql_free_result($result_score);

  if ($counter==0) //now there are no more departments, skills and scores left, so year can be deleted
  {
    // delete year
    if (!(mysql_query(sprintf($del_year,$year_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    if (!($result_year= mysql_query(sprintf($year_query_Stmt,$school_ref),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }

    $year_counter=0; 
    while($field_year = mysql_fetch_object($result_year))
    {
      $year_counter++;
    }
    mysql_free_result($result_year);
    if ($year_counter==0) //no more years available, delete school as well. 
    {
       // delete school
       if (!(mysql_query(sprintf($del_school,$school_ref), $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $del_category)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;}
    }
  
  }// end counter

}

?>