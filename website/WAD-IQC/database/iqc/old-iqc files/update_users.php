<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

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


$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_new_teacher='new_teacher';

$new_teacher_Stmt = "SELECT * from $table_new_teacher";


$updateStmt_teacher = "Update $table_teacher set  firstname='%s',middlename='%s',lastname='%s',title='%s',sex='%s',date_of_birth='%s',place_of_birth='%s',nationality='%s',religion='%s',language='%s',email='%s',address='%s',phone_home='%s',phone_cell='%s',fax='%s',marital_status='%s',spouse='%s',children='%s',picture='%s',initials='%s',login_level_1='%s',login_level_2='%s',login_level_3='%s',login_level_4='%s',login_level_5='%s',login='%s',date_of_employment='%s',employment_subjects='%s',employment_qualifications='%s',employment_certificates='%s' where $table_teacher.teacher_ref='%d'";



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

// Execute the Statement
if (!($result_new_teacher= mysql_query($new_teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$new = mysql_fetch_object($result_new_teacher);

if (!mysql_query(sprintf($updateStmt_teacher,$new->firstname,$new->middlename,$new->lastname,$new->title,$new->sex,$new->date_of_birth,$new->place_of_birth,$new->nationality,$new->religion,$new->language,$new->email,$new->address,$new->phone_home,$new->phone_cell,$new->fax,$new->marital_status,$new->spouse,$new->children,$new->picture,$new->initials,$new->login_level_1,$new->login_level_2,$new->login_level_3,$new->login_level_4,$new->login_level_5,$new->login,$new->date_of_employment,$new->employment_subjects,$new->employment_qualifications,$new->employment_certificates,$new->teacher_ref),$link))
{
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_new_teacher);

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("show_teachers.php?school=$school&school_year=$school_year&t=%d",time());
header($executestring);
exit();


?>














