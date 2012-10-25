<?

require("../globals.php") ;
require("./common.php") ;

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill_ref=$_GET['skill_ref'];

$skill=$_POST['skill'];
$number=$_POST['number'];
$abreviation=$_POST['abreviation'];

$table_skill='skill';

$updateStmt_skill = "Update $table_skill set
skill='%s', abreviation='%s', number='%s' where
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


if (!mysql_query(sprintf($updateStmt_skill,$skill,$abreviation,$number,$skill_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_skills.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
?>














