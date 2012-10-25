<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

//Should be made more sophisticated later on

$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

$table_subject='subject';
$table_subject_skill='subject_skill';

$del_subject = "delete from  $table_subject where 
$table_subject.subject_ref='%d'";

$del_subject_skill = "delete from  $table_subject_skill where 
$table_subject_skill.subject_ref='%d'";



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

    //delete subject_skill
    if (!(mysql_query(sprintf($del_subject_skill,$subject_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_subject)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    //delete subject
    if (!(mysql_query(sprintf($del_subject,$subject_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_subject)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
    
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
    $executestring.= sprintf("show_subjects_department.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
    header($executestring);
    exit();

?>





