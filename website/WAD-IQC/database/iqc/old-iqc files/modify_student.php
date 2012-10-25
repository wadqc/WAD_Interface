<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

if( (!empty($_POST['action'])) || (!empty($_POST['picture_x'])) )
{
   $school=$_GET['school'];
   $school_year=$_GET['school_year'];
   $department=$_GET['department'];
   $class=$_GET['class'];
   $grade=$_GET['grade'];
   $picture=$_GET['picture'];
   $class_ref=$_GET['class_ref'];
   $student_ref=$_GET['student_ref'];
   $v=$_GET['v'];

   $firstname=$_POST['firstname'];
   $lastname=$_POST['lastname'];
   $student_sex=$_POST['student_sex'];
   $address=$_POST['address'];
   $phone=$_POST['phone'];
   $student_Year=$_POST['student_Year'];
   $student_Month=$_POST['student_Month'];
   $student_Day=$_POST['student_Day'];


   $table_new_student='new_student';

   $addStmt = "Insert into $table_new_student(page,department,class,profile,picture,firstname,lastname,student_sex,date_of_birth,address,phone,student_ref,class_ref,v,grade) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d','%s')";

   $delStmt = "delete from  $table_new_student where $table_new_student.key='%d'";
  
  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link))
  {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }
  
  if (!(mysql_query(sprintf($delStmt,0), $link))) 
  {
   DisplayErrMsg(sprintf("Error in delete patient")) ;
   exit() ;
  }
  
  $datum=sprintf("%s-%s-%s", $student_Year,$student_Month,$student_Day);
  
  if (!(mysql_query(sprintf($addStmt,"modify_student.php",$department,$class,$profile,$picture,$firstname,$lastname,$student_sex,$datum,$address,$phone,$student_ref,$class_ref,$v,$grade),$link))) 
  {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }

}

if (!empty($_POST['picture_x'])) 
{
  $executestring.= sprintf("insert_picture.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
}

if (!empty($_POST['action']))
{
  $executestring.= sprintf("update_student.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
}


//central part 

$table_new_student='new_student';
$new_student_Stmt = "SELECT * from $table_new_student";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password)))
{
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_new_student= mysql_query($new_student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$student = new Smarty_NM();


$student->assign("time_student",time());

$student->assign("student_value","Modify");  

if (!empty($_POST['picture']))
{
  if (($picture==".")||($picture==".."))
  {
    $picture=sprintf("%s",'logo_shirt.jpg');
  }
  $picture_path=sprintf("%s%s",$picture_dir,$picture);
   
  $new = mysql_fetch_object($result_new_student);
 
  $student->assign("default_picture",$picture_path);
  $student->assign("default_fname",$new->firstname);
  $student->assign("default_lname",$new->lastname);
  $student->assign("sex_id",$new->student_sex);
  $student->assign("time_student",$new->date_of_birth);
  $student->assign("default_address",$new->address);
  $student->assign("default_phone",$new->phone);
  $student->assign("profile_id",$new->profile);

  $department=$new->department;
  $class=$new->class;
  $class_ref=$new->class_ref;
  $student_ref=$new->student_ref;
  $v=$new->v; 
  $grade=$new->grade;

  mysql_free_result($result_new_student);
}

if (empty($_POST['picture']))
{
  $class_ref=$_GET['class_ref'];
  $v=$_GET['v']; 
  $grade=$_GET['grade'];  

  $table_student='student';
  $table_school_student='school_student';
  $table_department_student='department_student';
  $table_class_student='class_student';
  
  $student_Stmt = "SELECT * from $table_student, $table_school_student,
  $table_department_student, $table_class_student where 
  $table_class_student.class_ref='$class_ref' and
  $table_student.student_ref=$table_school_student.student_ref and
  $table_school_student.school_ref=$table_department_student.school_ref and
  $table_department_student.department_ref=$table_class_student.department_ref
  order by $table_student.lastname, $table_student.firstname";

  if (!($result_student= mysql_query($student_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($field_student = mysql_fetch_object($result_student)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }
  $picture=$field_student->picture;
  $default_profile=$field_student->profile;
  $picture_path=sprintf("%s%s",$picture_dir,$picture);

  $student->assign("default_picture",$picture_path);
  $student->assign("default_fname",$field_student->firstname);
  $student->assign("default_lname",$field_student->lastname);
  $student->assign("sex_id",$field_student->sex);
  $student->assign("time_student",$field_student->date_of_birth);
  $student->assign("default_address",$field_student->address);
  $student->assign("default_phone",$field_student->phone);
  $student->assign("profile_id",$field_student->profile);

  $school=$field_student->school;
  $school_year=$field_student->year;
  $department=$field_student->department;
  $class=$field_student->class;
  $class_ref=$field_student->class_ref;
  $student_ref=$field_student->student_ref;
  mysql_free_result($result_student);
}
  
  $table_profile='table_profile';
  
  $student->assign("submit_value","Update");
  $start_self = sprintf("http://%s",$_SERVER['HTTP_HOST']);
  $student->assign("action_new_student",sprintf("%s$PHP_SELF?school=$school&school_year=$school_year&department=$department&class=$class&grade=$grade&picture=$picture&class_ref=$class_ref&student_ref=$student_ref&v=$v&t=%d",$start_self,time()));

  $list_sex["m"]="m";
  $list_sex["v"]="v";
  $student->assign("sex_options",$list_sex);

  $profile_Stmt = "SELECT * from $table_profile";
    
  if (!($result_profile= mysql_query($profile_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  
  while($field = mysql_fetch_object($result_profile))
  {
    $list_profile["$field->profile"]="$field->profile";
  } 
  mysql_free_result($result_profile);
  $student->assign("profile_options",$list_profile);
  
  $header=sprintf("%s %s %s class:%s",$school,$school_year,$department,$class); 

  $student->assign("header",$header);

  $student->display("new_student.tpl");

  ReturnToMain(); 
?>