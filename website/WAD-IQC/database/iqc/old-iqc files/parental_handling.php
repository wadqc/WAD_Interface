<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_parent_function.php");

 
$father_ref=$_GET['father_ref'];
$mother_ref=$_GET['mother_ref'];
$guardian_ref=$_GET['guardian_ref'];
$new_student_ref=$_GET['new_student_ref']; 







$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

$table_new_student='new_student';


$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';

$new_student_Stmt = "SELECT * from $table_new_student where student_ref='%d'";

$select_student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref='%d'";

$update_student_father_Stmt = "Update $table_student set
father_ref='0' where $table_student.student_ref='%d'"; 

$update_student_mother_Stmt = "Update $table_student set
mother_ref='0' where $table_student.student_ref='%d'"; 

$update_student_guardian_Stmt = "Update $table_student set
guardian_ref='0' where $table_student.student_ref='%d'"; 








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


if (!empty($_GET['parental']))
{
  $parental=$_GET['parental'];


  if ($parental=='link_father')
  {
    $executestring.=sprintf("show_school_name.php?v=60&new_student_ref=$new_student_ref&t=%d",time());
    header($executestring);
    exit();

  }
  
  if ($parental=='link_mother')
  {
    $executestring.=sprintf("show_school_name.php?v=61&new_student_ref=$new_student_ref&t=%d",time());
    header($executestring);
    exit();

  }

  if ($parental=='link_guardian')
  {
    $executestring.=sprintf("show_school_name.php?v=62&new_student_ref=$new_student_ref&t=%d",time());
    header($executestring);
    exit();

  }
  
  if ($parental=='link_parents')
  {
    $executestring.=sprintf("show_school_name.php?v=63&new_student_ref=$new_student_ref&t=%d",time());
    header($executestring);
    exit();

  }

  if ( ($parental=='delete_father')||($parental=='delete_mother')||($parental=='delete_guardian')||($parental=='delete_parents') )
  {
     //get student_ref, school_ref, department_ref
     if (!($result_student= mysql_query(sprintf($select_student_Stmt,$new->class_ref), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
     }
     $field_student = mysql_fetch_object($result_student);
     $student_ref=$field_student->student_ref;

     mysql_free_result($result_student);
   }


  if (($parental=='delete_father')||($parental=='delete_parents'))
  {
    delete_father($father_ref);  //deletes father if this is the only student linked to it
   
    //update student immediately because father no longer excists 
    if (!mysql_query(sprintf($update_student_father_Stmt,$student_ref),$link)) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    
    $father_ref=0;
  }
  if (($parental=='delete_mother')||($parental=='delete_parents'))
  {
    delete_mother($mother_ref);  //deletes mother if this is the only student linked to it
   
    //update student immediately because mother no longer excists 
    if (!mysql_query(sprintf($update_student_mother_Stmt,$student_ref),$link)) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    $mother_ref=0;
  }
  if ($parental=='delete_guardian')
  {
    delete_guardian($guardian_ref);  //deletes guardian if this is the only student linked to it

    //update student immediately because father no longer excists 
    if (!mysql_query(sprintf($update_student_guardian_Stmt,$student_ref),$link)) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    $guardian_ref=0;
  }

}



if (!empty($_GET['v']))
{
  $v=$_GET['v'];

  if ($v==60)//link father
  {
    $parental='link_father';
    $mother_ref=$new->mother_ref;
    $guardian_ref=$new->guardian_ref;
  }
  if ($v==61)//link mother
  {
    $parental='link_mother';
    $father_ref=$new->father_ref;
    $guardian_ref=$new->guardian_ref;
  }
  if ($v==62)//link guardian
  {
    $parental='link_guardian';
    $father_ref=$new->father_ref;
    $mother_ref=$new->mother_ref;
  }
  if ($v==63)//link parents
  {
    $parental='link_parents';
    $guardian_ref=$new->guardian_ref;
  }
}
$v=$new->v;
$class_ref=$new->class_ref;
$grade=$new->grade;
mysql_free_result($result_new_student);

$executestring.=sprintf("new_student.php?parental=$parental&father_ref=$father_ref&mother_ref=$mother_ref&guardian_ref=$guardian_ref&new_student_ref=$new_student_ref&v=$v&class_ref=$class_ref&grade=$grade&t=%d",time());

header($executestring);
exit();



?>

