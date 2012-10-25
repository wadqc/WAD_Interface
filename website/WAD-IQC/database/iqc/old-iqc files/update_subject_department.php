<?

require("../globals.php") ;
require("./common.php") ;


$subject_ref=$_GET['subject_ref'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$subject_ref=$_GET['subject_ref'];

$category=$_POST['category'];
$subject=$_POST['subject'];
$abreviation=$_POST['abreviation'];

$table_subject='subject';


$updateStmt_subject = "Update $table_subject set
category='%s', subject='%s', abreviation='%s' where
$table_subject.subject_ref='%d'";

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


if (!mysql_query(sprintf($updateStmt_subject,$category,$subject,$abreviation,$subject_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
    $executestring.= sprintf("show_subjects_department.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
    header($executestring);
    exit();

?>














