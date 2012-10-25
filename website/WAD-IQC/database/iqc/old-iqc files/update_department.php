<?

require("../globals.php") ;
require("./common.php") ;

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department_ref=$_GET['department_ref'];

$department=$_POST['department'];
$number=$_POST['number'];


$table_department='department';

$updateStmt_department = "Update $table_department set
department='%s', number='%s' where
$table_department.department_ref='%d'";

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


if (!mysql_query(sprintf($updateStmt_department,$department,$number,$department_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_departments.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
?>














