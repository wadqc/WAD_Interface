<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));


if( (!empty($_POST['action']))||(!empty($_POST['picture_x'])) )
{
  $school=$_GET['school'];
  $school_year=$_GET['school_year']; 
  $picture=$_GET['picture'];
  $teacher_ref=$_GET['teacher_ref'];
  $year_ref=$_GET['year_ref'];

  $title=$_POST['title'];
  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $teacher_sex=$_POST['teacher_sex'];
  $teacher_Day=$_POST['teacher_Day'];
  $teacher_Month=$_POST['teacher_Month'];
  $teacher_Year=$_POST['teacher_Year'];
  $address=$_POST['address'];
  $phone=$_POST['phone'];
  $initials=$_POST['initials'];
  $login=$_POST['login'];
  
  $amount=0;
  $level_1='';
  $level_2='';
  $level_3='';
  if (!empty($_POST['level_1']))
  {
     $level_1=$_POST['level_1'];
     $amount++;
  }
  if (!empty($_POST['level_2']))
  {
     $level_2=$_POST['level_2'];
     $amount++;
  }
  if (!empty($_POST['level_3']))
  {
     $level_3=$_POST['level_3'];
     $amount++;
  }
  $message='';
  if ($amount<1)
  {
    $message=sprintf("No user level selected");
  }
  if ($amount>1)
  {
    $message=sprintf("Only one user level allowed");
  } 
  
  $table_new_teacher='new_teacher';

  $datum=sprintf("%s-%s-%s", $teacher_Year,$teacher_Month,$teacher_Day);

  $addStmt = "Insert into $table_new_teacher(page,picture,firstname,lastname,title,sex,date_of_birth,address,phone,initials,login,level_1,level_2,level_3,teacher_ref,year_ref) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";

  $delStmt = "delete from  $table_new_teacher where $table_new_teacher.key='%d'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
  DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
  exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!(mysql_query(sprintf($delStmt,0), $link))) {
    DisplayErrMsg(sprintf("Error in delete patient")) ;
    exit() ;
  }
//printf($addStmt,"new_teacher.php",$picture,$firstname,$lastname,$title,$teacher_sex,$datum,$address,$phone,$initials,$login); 


  if (!(mysql_query(sprintf($addStmt,"new_teacher.php",$picture,$firstname,$lastname,$title,$teacher_sex,$datum,$address,$phone,$initials,$login,$level_1,$level_2,$level_3,$teacher_ref,$year_ref),$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
}

if (!empty($_POST['picture_x'])) //add or modify picture
{
  $executestring.=sprintf("insert_picture_teacher.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
}

if (!empty($_POST['action']))
{
  $executestring.=sprintf("update_teacher.php?message=$message&school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();

}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$teacher = new Smarty_NM();


if (!empty($_POST['picture'])) //returns from add/modify picture
{
  $school=$_GET['school'];
  $school_year=$_GET['school_year']; 
  $picture=$_POST['picture'];
  
  $table_new_teacher='new_teacher';
  $new_teacher_Stmt = "SELECT * from $table_new_teacher";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  if (!($result_new_teacher= mysql_query($new_teacher_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  //$picture_path=sprintf("%s%s",$picture_dir,$picture);
  if (($picture==".")||($picture==".."))
  {
    $picture=sprintf("%s%s",$picture_teacher_dir,$logo_shirt);
  }
  //$picture_path=sprintf("%s%s",$picture_dir,$picture);
  $picture_path=sprintf("%s",$picture);
  printf("path=%s", $picture_path);


  $teacher->assign("teacher_value","Add");  
  $teacher->assign("default_picture",$picture_path);
  
  $new = mysql_fetch_object($result_new_teacher);

  $teacher->assign("default_title",$new->title);
  $teacher->assign("default_fname",$new->firstname);
  $teacher->assign("default_lname",$new->lastname);
  $teacher->assign("sex_id",$new->sex);
  $teacher->assign("time_teacher",$new->date_of_birth);
  $teacher->assign("default_address",$new->address);
  $teacher->assign("default_phone",$new->phone);
  $teacher->assign("default_initials",$new->initials);
  $teacher->assign("default_login",$new->login);

  $checked1='';
  $checked2='';
  $checked3='';

  if ($new->level_1=='on')
  {
     $checked1='checked';
  }
  if ($new->level_2=='on')
  {
     $checked2='checked';
  }
  if ($new->level_3=='on')
  {
     $checked3='checked';
  }

  $teacher->assign("checked_level_1",$checked1);
  $teacher->assign("checked_level_2",$checked2);
  $teacher->assign("checked_level_3",$checked3);
  
  $teacher_ref=$new->teacher_ref;
  $year_ref=$new->year_ref;


  mysql_free_result($result_new_teacher);
}

if (empty($_POST['picture'])) //enters here at first time
{
  $year_ref=$_GET['year_ref'];
  $table_teacher='teacher';
  $table_teacher_year='teacher_year';
 
  
  $teacher_Stmt = "SELECT * from $table_teacher, $table_teacher_year where 
  $table_teacher.teacher_ref=$table_teacher_year.teacher_ref
  and $table_teacher_year.year_ref='$year_ref'";
 
  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  if (!($result_teacher= mysql_query($teacher_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  
  if (!($field_teacher = mysql_fetch_object($result_teacher)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
    $teacher_counter++;
  }

  $picture=$field_teacher->picture;
  //$picture_path=sprintf("%s%s",$picture_teacher_dir,$picture);
  $picture_path=sprintf("%s",$picture);

  $teacher->assign("default_picture",$picture_path);
  $teacher->assign("default_title",$field_teacher->title);
  $teacher->assign("default_fname",$field_teacher->firstname);
  $teacher->assign("default_lname",$field_teacher->lastname);
  $teacher->assign("sex_id",$field_teacher->sex);
  $teacher->assign("time_teacher",$field_teacher->date_of_birth);
  $teacher->assign("default_address",$field_teacher->address);
  $teacher->assign("default_phone",$field_teacher->phone);
  $teacher->assign("default_initials",$field_teacher->initials);
  $teacher->assign("default_login",$field_teacher->login);

  $checked1='';
  $checked2='';
  $checked3='';

  if ($field_teacher->level_1=='on')
  {
     $checked1='checked';
  }
  if ($field_teacher->level_2=='on')
  {
     $checked2='checked';
  }
  if ($field_teacher->level_3=='on')
  {
     $checked3='checked';
  }

  $teacher->assign("checked_level_1",$checked1);
  $teacher->assign("checked_level_2",$checked2);
  $teacher->assign("checked_level_3",$checked3);


  $school_year=$field_teacher->year;
  
  $teacher_ref=$field_teacher->teacher_ref;
  
  $year_ref=$field_teacher->year_ref;
  
  $teacher->assign("teacher_value","Add");  
  $teacher->assign("default_picture",$picture_path);
  
  mysql_free_result($result_teacher);

}

  $teacher->assign("submit_value","Modify");
  $teacher->assign("action_new_teacher",sprintf("modify_teacher.php?school=$school&school_year=$school_year&picture=$picture&teacher_ref=$teacher_ref&year_ref=$year_ref&t=%d",time()));

  $list_sex["m"]="m";
  $list_sex["v"]="v";
  $teacher->assign("sex_options",$list_sex);

  $header=sprintf("%s %s",$school,$school_year);
  $teacher->assign("header",$header);

  $teacher->display("new_teacher.tpl");

  ReturnToMain();
 
?>












