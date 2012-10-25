<?
require("../globals.php") ;
require("../school_data.php");
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_teacher_function.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

if (!empty($_GET['message']))
{
  $error_message=$_GET['message'];
  $error_action=sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
  $error_button=sprintf("return to Teachers");

  $error = new Smarty_NM();
  $error->assign("error_message",$error_message);
  $error->assign("error_action",$error_action);
  $error->assign("error_button",$error_button);

  $error->display("error_message.tpl");
  exit();
}


$table_new_teacher='new_teacher';

$new_teacher_Stmt = "SELECT * from $table_new_teacher";

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

if (!($result_new_teacher= mysql_query($new_teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$new = mysql_fetch_object($result_new_teacher);

add_teacher_teacher($new->firstname,$new->middlename,$new->lastname,$new->title,$new->sex,$new->date_of_birth,$new->place_of_birth,$new->nationality,$new->religion,$new->language,$new->email,$new->address,$new->phone_home,$new->phone_cell,$new->fax,$new->marital_status,$new->spouse,$new->children,$new->picture,$new->initials,$new->login_level_1,$new->login_level_2,$new->login_level_3,$new->login,$new->date_of_employment,$new->employment_subjects,$new->employment_qualifications,$new->employment_certificates,md5($first_login),&$teacher_ref,&$message);

if ($message=='1')
{
  $content=sprintf("Last name, Login and Initials are mandatory fields");
}
if ($message=='2')
{
  $content=sprintf("Teacher already excists for year %s at school %s",$school_year,$school);  
}

if ($message!='') //message=1 or message=2
{

  $error_message=$content;
  $error_action=sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
  $error_button=sprintf("return to Teachers");

  $error = new Smarty_NM();
  $error->assign("error_message",$error_message);
  $error->assign("error_action",$error_action);
  $error->assign("error_button",$error_button);

  $error->display("error_message.tpl");
  exit();
}


if ($message=='') //new teacher
{
  add_teacher_year($school_year,$school,$teacher_ref,&$year_ref,&$message);  

  if ($message=='1')
  {
    $content=sprintf("Teacher already excists for year %s at school %s",$school_year,$year);
  }
  if ($message!='') //teacher already excists
  {
    $error_message=$content;
    $error_action=sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
    $error_button=sprintf("return to Teachers");

    $error = new Smarty_NM();
    $error->assign("error_message",$error_message);
    $error->assign("error_action",$error_action);
    $error->assign("error_button",$error_button);

    $error->display("error_message.tpl");
    exit();
  }
}
mysql_free_result($result_new_teacher);


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
header($executestring);
exit();

?>



