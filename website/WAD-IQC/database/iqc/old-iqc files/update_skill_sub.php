<?

require("../globals.php") ;
require("./common.php") ;

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill_sub_ref=$_GET['skill_sub_ref'];
$skill_sub=$_POST['skill_sub'];
$code=$_POST['code'];
$number=$_POST['number'];


$table_skill_sub='skill_sub';
$updateStmt_skill_sub = "Update $table_skill_sub set
skill_sub='%s', code='%s', number='%s' where
$table_skill_sub.skill_sub_ref='%d'";

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


if (!mysql_query(sprintf($updateStmt_skill_sub,$skill_sub,$code,$number,$skill_sub_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_skills_sub.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();




?>














