<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school_year=$_GET['school_year'];
$school=$_GET['school'];
$department=$_GET['department'];
$subject=$_GET['subject'];
$subject_skill_ref=$_GET['subject_skill_ref'];
$subject_ref=$_GET['subject_ref'];

$table_subject_skill='subject_skill';

$del_subject_skill = "delete from  $table_subject_skill where 
$table_subject_skill.subject_skill_ref='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}


// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


    if (!(mysql_query(sprintf($del_subject_skill,$subject_skill_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_skill_sub)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.=sprintf("view_subject_department.php?school=%s&school_year=%s&department=%s&subject_ref=%d&t=%d",$school,$school_year,$department,$subject_ref,time());

  header($executestring);

  exit();

?>





