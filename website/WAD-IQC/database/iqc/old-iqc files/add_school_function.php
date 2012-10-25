<?php

function add_school_school($school,$school_ref)
{

require("../globals.php") ;


$table_school='school';


$queryStmt_school = "Select * from $table_school where 
$table_school.school='%s'";

$addStmt_school = "Insert into $table_school(school)
values ('%s')";

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

  if ($school_ref==-1) //school not available, create new school
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

}


//new function

function add_school_year($school_year,$school_ref,$year_ref)
{

require("../globals.php") ;

$table_year='year';

$queryStmt_year = "Select * from $table_year where 
$table_year.school_ref='%d' and
$table_year.year='%s'";

$addStmt_year = "Insert into $table_year(year,school_ref)
values ('%s','%d')";

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




  //query for excisting year or create year if not excists
  
  if (!($result_year=mysql_query(sprintf($queryStmt_year,$school_ref,$school_year),$link))){
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
    if (!(mysql_query(sprintf($addStmt_year,$school_year,$school_ref),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }

    if (!($result_year=mysql_query(sprintf($queryStmt_year,$school_ref,$school_year),$link))){
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;  }
 
    $field_year = mysql_fetch_object($result_year);
    $year_ref=$field_year->year_ref;
    mysql_free_result($result_year);
  }
  // year defined
}


function add_school_department($department,$number,$year_ref,$department_ref)
{

require("../globals.php") ;

$table_department='department';

$queryStmt_department = "Select * from $table_department where 
$table_department.department='%s' and 
$table_department.number='%s' and
$table_department.year_ref='%d'";

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


if (!($result_department= mysql_query(sprintf($queryStmt_department,$department,$number,$year_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$department_ref=-1; //verify whether or not the department excists

while (($field_department = mysql_fetch_object($result_department)))
{
   $department_ref=$field_department->department_ref;
}
mysql_free_result($result_department);  

  if ($department_ref==-1) //new department
  {
    if(!mysql_query(sprintf($addStmt_department,$department,$number,$year_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_department= mysql_query(sprintf($queryStmt_department,$department,$number,$year_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_department = mysql_fetch_object($result_department);
    $department_ref=$field_department->department_ref;
    mysql_free_result($result_department);
  }
  // department defined

}


function add_school_skill($skill,$abreviation,$number,$year_ref,$skill_ref)
{

require("../globals.php") ;

$table_skill='skill';

$queryStmt_skill = "Select * from $table_skill where 
$table_skill.skill='%s' and 
$table_skill.abreviation='%s' and 
$table_skill.number='%s' and
$table_skill.year_ref='%d'";

$addStmt_skill = "Insert into $table_skill(skill,abreviation,number,year_ref)
values ('%s','%s','%d','%d')";


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


if (!($result_skill= mysql_query(sprintf($queryStmt_skill,$skill,$abreviation,$number,$year_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_skill)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$skill_ref=-1; //verify whether or not the skill excists

while (($field_skill = mysql_fetch_object($result_skill)))
{
   $skill_ref=$field_skill->skill_ref;
}
mysql_free_result($result_skill);  

  if ($skill_ref==-1) //new skill
  {
    if(!mysql_query(sprintf($addStmt_skill,$skill,$abreviation,$number,$year_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_skill= mysql_query(sprintf($queryStmt_skill,$skill,$abreviation,$number,$year_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_skill)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_skill = mysql_fetch_object($result_skill);
    $skill_ref=$field_skill->skill_ref;
    mysql_free_result($result_skill);
  }
  // skill defined

}

function add_school_score($description,$score,$selected_score,$year_ref,$score_ref)
{

require("../globals.php") ;

$table_score='score';

$queryStmt_score = "Select * from $table_score where 
$table_score.description='%s' and
$table_score.score='%d' and 
$table_score.selected_score='%s' and
$table_score.year_ref='%d'";

$updateStmt_score_selected = "Update $table_score set
selected_score='' where
$table_score.selected_score='on' and  
$table_score.year_ref='%d'";

$addStmt_score = "Insert into $table_score(description,score,selected_score,year_ref)
values ('%s','%d','%s','%d')";


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


if (!($result_score= mysql_query(sprintf($queryStmt_score,$description,$score,$selected_score,$year_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_score)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$score_ref=-1; //verify whether or not the score excists

while (($field_score = mysql_fetch_object($result_score)))
{
   $score_ref=$field_score->score_ref;
}
mysql_free_result($result_score);  

  if ($score_ref==-1) //new score
  {
    if ($selected_score=='on')
    {
      //reset curent default values
      if (!(mysql_query(sprintf($updateStmt_score_selected,$year_ref), $link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_score)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
    }
    
    if(!mysql_query(sprintf($addStmt_score,$description,$score,$selected_score,$year_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_score= mysql_query(sprintf($queryStmt_score,$description,$score,$selected_score,$year_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_score)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_score = mysql_fetch_object($result_score);
    $score_ref=$field_score->score_ref;
    mysql_free_result($result_score);
  }
  // score defined

}

function add_school_sub_skill($skill_sub,$code,$number,$skill_ref,$skill_sub_ref)
{

require("../globals.php") ;

$table_skill_sub='skill_sub';

$queryStmt_skill_sub = "Select * from $table_skill_sub where 
$table_skill_sub.skill_sub='%s' and
$table_skill_sub.code='%s' and 
$table_skill_sub.number='%d' and
$table_skill_sub.skill_ref='%d'";

$addStmt_skill_sub = "Insert into $table_skill_sub(skill_sub,code,number,skill_ref)
values ('%s','%s','%d','%d')";

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


if (!($result_skill_sub= mysql_query(sprintf($queryStmt_skill_sub,$skill_sub,$code,$number,$skill_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_skill_sub)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$skill_sub_ref=-1; //verify whether or not the skill_sub excists

while (($field_skill_sub = mysql_fetch_object($result_skill_sub)))
{
   $skill_sub_ref=$field_skill_sub->skill_sub_ref;
}
mysql_free_result($result_skill_sub);  

  if ($skill_sub_ref==-1) //new skill_sub
  {
    if(!mysql_query(sprintf($addStmt_skill_sub,$skill_sub,$code,$number,$skill_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_skill_sub= mysql_query(sprintf($queryStmt_skill_sub,$skill_sub,$code,$number,$skill_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_skill_sub)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_skill_sub = mysql_fetch_object($result_skill_sub);
    $skill_sub_ref=$field_skill_sub->skill_sub_ref;
    mysql_free_result($result_skill_sub);
  }
  // skill_sub defined

}



function add_school_grade($grade,$department_ref,$grade_ref)
{

require("../globals.php") ;

$table_grade='grade';

$queryStmt_grade = "Select * from $table_grade where 
$table_grade.grade='%s' and 
$table_grade.department_ref='%d'";

$addStmt_grade = "Insert into $table_grade(grade,department_ref)
values ('%s','%d')";


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


if (!($result_grade= mysql_query(sprintf($queryStmt_grade,$grade,$department_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_grade)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$grade_ref=-1; //verify whether or not the grade excists

while (($field_grade = mysql_fetch_object($result_grade)))
{
   $grade_ref=$field_grade->grade_ref;
}
mysql_free_result($result_grade);  

  if ($grade_ref==-1) //new grade
  {
    if(!mysql_query(sprintf($addStmt_grade,$grade,$department_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_grade= mysql_query(sprintf($queryStmt_grade,$grade,$department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_grade)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_grade = mysql_fetch_object($result_grade);
    $grade_ref=$field_grade->grade_ref;
    mysql_free_result($result_grade);
  }
  // grade defined

}

function add_school_class($class,$number,$grade_ref,$class_ref)
{

require("../globals.php") ;

$table_class='class';

$queryStmt_class = "Select * from $table_class where 
$table_class.class='%s' and 
$table_class.number='%d' and 
$table_class.grade_ref='%d'";

$addStmt_class = "Insert into $table_class(class,number,grade_ref)
values ('%s','%s','%d')";


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


if (!($result_class= mysql_query(sprintf($queryStmt_class,$class,$number,$grade_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_class)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$class_ref=-1; //verify whether or not the class excists

while (($field_class = mysql_fetch_object($result_class)))
{
   $class_ref=$field_class->class_ref;
}
mysql_free_result($result_class);  

  if ($class_ref==-1) //new class
  {
    if(!mysql_query(sprintf($addStmt_class,$class,$number,$grade_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_class= mysql_query(sprintf($queryStmt_class,$class,$number,$grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_class)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_class = mysql_fetch_object($result_class);
    $class_ref=$field_class->class_ref;
    mysql_free_result($result_class);
  }
  // class defined

}

function add_school_subject_report($category,$subject,$abreviation,$number,$grade_ref,$subject_report_ref)
{

require("../globals.php") ;

$table_subject_report='subject_report';

$queryStmt_subject_report = "Select * from $table_subject_report where 
$table_subject_report.category='%s' and 
$table_subject_report.subject='%s' and 
$table_subject_report.abreviation='%s' and 
$table_subject_report.number='%d' and 
$table_subject_report.grade_ref='%d'";

$addStmt_subject_report = "Insert into $table_subject_report(category,subject,abreviation,number,grade_ref)
values ('%s','%s','%s','%s','%d')";


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


if (!($result_subject_report= mysql_query(sprintf($queryStmt_subject_report,$category,$subject,$abreviation,$number,$grade_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject_report)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$subject_report_ref=-1; //verify whether or not the subject_report excists

while (($field_subject_report = mysql_fetch_object($result_subject_report)))
{
   $subject_report_ref=$field_subject_report->subject_report_ref;
}
mysql_free_result($result_subject_report);  

  if ($subject_report_ref==-1) //new subject_report
  {
    if(!mysql_query(sprintf($addStmt_subject_report,$category,$subject,$abreviation,$number,$grade_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_subject_report= mysql_query(sprintf($queryStmt_subject_report,$category,$subject,$abreviation,$number,$grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject_report)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_subject_report = mysql_fetch_object($result_subject_report);
    $subject_report_ref=$field_subject_report->subject_report_ref;
    mysql_free_result($result_subject_report);
  }
  // subject_report defined

}

function add_school_subject_exam($category,$subject,$abreviation,$number,$grade_ref,$subject_exam_ref)
{

require("../globals.php") ;

$table_subject_exam='subject_exam';

$queryStmt_subject_exam = "Select * from $table_subject_exam where 
$table_subject_exam.category='%s' and 
$table_subject_exam.subject='%s' and 
$table_subject_exam.abreviation='%s' and 
$table_subject_exam.number='%d' and 
$table_subject_exam.grade_ref='%d'";

$addStmt_subject_exam = "Insert into $table_subject_exam(category,subject,abreviation,number,grade_ref)
values ('%s','%s','%s','%s','%d')";


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


if (!($result_subject_exam= mysql_query(sprintf($queryStmt_subject_exam,$category,$subject,$abreviation,$number,$grade_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject_exam)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$subject_exam_ref=-1; //verify whether or not the subject_exam excists

while (($field_subject_exam = mysql_fetch_object($result_subject_exam)))
{
   $subject_exam_ref=$field_subject_exam->subject_exam_ref;
}
mysql_free_result($result_subject_exam);  

  if ($subject_exam_ref==-1) //new subject_exam
  {
    if(!mysql_query(sprintf($addStmt_subject_exam,$category,$subject,$abreviation,$number,$grade_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_subject_exam= mysql_query(sprintf($queryStmt_subject_exam,$category,$subject,$abreviation,$number,$grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject_exam)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_subject_exam = mysql_fetch_object($result_subject_exam);
    $subject_exam_ref=$field_subject_exam->subject_exam_ref;
    mysql_free_result($result_subject_exam);
  }
  // subject_exam defined

}

function add_school_subject($category,$subject,$abreviation,$department_ref,$subject_ref)
{

require("../globals.php") ;

$table_subject='subject';

$queryStmt_subject = "Select * from $table_subject where 
$table_subject.category='%s' and 
$table_subject.subject='%s' and 
$table_subject.abreviation='%s' and 
$table_subject.department_ref='%d'";

$addStmt_subject = "Insert into $table_subject(category,subject,abreviation,department_ref)
values ('%s','%s','%s','%d')";


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


if (!($result_subject= mysql_query(sprintf($queryStmt_subject,$category,$subject,$abreviation,$department_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$subject_ref=-1; //verify whether or not the subject excists

while (($field_subject = mysql_fetch_object($result_subject)))
{
   $subject_ref=$field_subject->subject_ref;
}
mysql_free_result($result_subject);  

  if ($subject_ref==-1) //new subject
  {
    if(!mysql_query(sprintf($addStmt_subject,$category,$subject,$abreviation,$department_ref),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    if (!($result_subject= mysql_query(sprintf($queryStmt_subject,$category,$subject,$abreviation,$department_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_subject)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
 
    $field_subject = mysql_fetch_object($result_subject);
    $subject_ref=$field_subject->subject_ref;
    mysql_free_result($result_subject);
  }
  // subject defined

}


?>
